<?php

namespace App\Models;

use CodeIgniter\Model;

class DiemModel extends Model
{
    protected $table = 'diem';
    protected $primaryKey = 'MaDiem';
    protected $allowedFields = [
        'MaDiem',
        'MaHS',
        'MaGV',
        'MaMH',
        'Diem15P_1',
        'Diem15P_2',
        'Diem1Tiet_1',
        'Diem1Tiet_2',
        'DiemCK',
        'HocKy',
        'NamHoc',
        'NhanXet'
    ];

    //Hàm xếp loại học lực
    public function getAcademicPerformance($Diem)
    {
        if ($Diem === null) {
            return null;
        }

        if ($Diem >= 8.0) {
            return 'Giỏi';
        } elseif ($Diem >= 6.5) {
            return 'Khá';
        } elseif ($Diem >= 5.0) {
            return 'Trung bình';
        } else {
            return 'Yếu';
        }
    }

    //Hàm tính điểm trung bình môn học
    public function getAverageScore($Diem)
    {
        $Diem15P_1 = $Diem['Diem15P_1'];
        $Diem15P_2 = $Diem['Diem15P_2'];
        $Diem1Tiet_1 = $Diem['Diem1Tiet_1'];
        $Diem1Tiet_2 = $Diem['Diem1Tiet_2'];
        $DiemCK = $Diem['DiemCK'];

        if ($Diem15P_1 === null || $Diem15P_2 === null || $Diem1Tiet_1 === null || $Diem1Tiet_2 === null || $DiemCK === null) {
            return null;
        }

        $DiemTB = (($Diem15P_1 + $Diem15P_2) + 2 * ($Diem1Tiet_1 + $Diem1Tiet_2) + 3 * $DiemCK) / 9;
        return round($DiemTB, 1);
    }

    // Hàm tính điểm trung bình học kỳ
    public function getSemesterAverageScore($MaHS, $HocKy, $NamHoc)
    {
        // Lấy danh sách môn học được phân công giảng dạy cho học sinh trong học kỳ và năm học
        $SQL = "SELECT DISTINCT MaMH
                FROM phancong
                WHERE MaLop = (
                    SELECT MaLop 
                    FROM hocsinh_lop 
                    WHERE MaHS = ? AND HocKy = ? AND NamHoc = ?)
                AND HocKy = ? AND NamHoc = ?";
        $assignedSubjects = $this->db->query($SQL, [$MaHS, $HocKy, $NamHoc, $HocKy, $NamHoc])->getResultArray();

        if (empty($assignedSubjects)) {
            return null;
        }

        $subjectCodes = array_column($assignedSubjects, 'MaMH');

        // Lấy điểm số của học sinh trong học kỳ và năm học
        $SQL = "SELECT *
                FROM diem
                WHERE MaHS = ? AND HocKy = ? AND NamHoc = ?
                AND MaMH IN (" . implode(',', array_fill(0, count($subjectCodes), '?')) . ")";
        $scores = $this->db->query($SQL, array_merge([$MaHS, $HocKy, $NamHoc], $subjectCodes))->getResultArray();

        // Đảm bảo rằng điểm số của học sinh đã được nhập đầy đủ
        if (count($scores) < count($subjectCodes)) {
            return null;
        }

        // Tính điểm trung bình học kỳ
        $TongDiemTBMonHoc = 0;
        foreach ($scores as $score) {
            //Kiểm tra điểm số có hợp lệ không
            if (
                $score['Diem15P_1'] === null || $score['Diem15P_2'] === null ||
                $score['Diem1Tiet_1'] === null || $score['Diem1Tiet_2'] === null ||
                $score['DiemCK'] === null
            ) {
                return null;
            }

            //Tính điểm trung bình môn học
            $DiemTBMonHoc = $this->getAverageScore($score);
            if ($DiemTBMonHoc === null) {
                return null;
            }
            $TongDiemTBMonHoc += $DiemTBMonHoc;
        }

        //Tính toán và trả về điểm trung bình học kỳ
        return round($TongDiemTBMonHoc / count($scores), 1);
    }

    // Hàm tính điểm trung bình năm học
    public function getYearAverageScore($MaHS, $NamHoc)
    {
        $DiemHK1 = $this->getSemesterAverageScore($MaHS, 1, $NamHoc);
        $DiemHK2 = $this->getSemesterAverageScore($MaHS, 2, $NamHoc);

        if ($DiemHK1 === null || $DiemHK2 === null) {
            return null;
        }
        return round(($DiemHK1 + $DiemHK2 * 2) / 3, 1);
    }

    // Hàm tính tăng/ giảm điểm trung bình năm học so với năm học trước
    public function getYearAverageScoreChange($currentReport, $previousReport)
    {
        if ($currentReport === null || $previousReport === null) {
            return null;
        }

        $performanceChange = [
            'Giỏi' => ['current' => 0, 'previous' => 0],
            'Khá' => ['current' => 0, 'previous' => 0],
            'Trung bình' => ['current' => 0, 'previous' => 0],
            'Yếu' => ['current' => 0, 'previous' => 0]
        ];

        // Đếm số lượng học sinh theo từng loại học lực trong năm học hiện tại
        foreach ($currentReport as $current) {
            $performance = $current['performance'];
            if ($performance !== null) {
                $performanceChange[$performance]['current']++;
            }
        }

        // Đếm số lượng học sinh theo từng loại học lực trong năm học trước
        foreach ($previousReport as $previous) {
            $performance = $previous['performance'];
            if ($performance !== null) {
                $performanceChange[$performance]['previous']++;
            }
        }

        // Tính thay đổi (tăng/giảm) giữa hai năm học
        $changes = [];
        foreach ($performanceChange as $key => $data) {
            $currentCount = $data['current'];
            $previousCount = $data['previous'];

            $change = $previousCount > 0
                ? (($currentCount - $previousCount) / $previousCount) * 100
                : ($currentCount > 0 ? 100 : 0); // Nếu năm trước không có, coi là tăng 100%
            $changes[$key] = round($change, 2);
        }

        return [
            'summary' => $performanceChange,
            'changes' => $changes
        ];
    }

    // Lấy nhận xét của giáo viên về học sinh dựa vào mã giáo viên, tên lớp, học kỳ và năm học
    public function getTeacherComment($MaGV, $TenLop, $HocKy, $NamHoc)
    {
        $SQL = "SELECT hocsinh.MaHS, taikhoan.HoTen, monhoc.TenMH, diem.NhanXet,
                        diem.Diem15P_1, diem.Diem15P_2, diem.Diem1Tiet_1, diem.Diem1Tiet_2, diem.DiemCK
                FROM hocsinh_lop
                JOIN hocsinh ON hocsinh_lop.MaHS = hocsinh.MaHS AND hocsinh_lop.NamHoc = ?
                JOIN taikhoan ON hocsinh.MaTK = taikhoan.MaTK
                JOIN lop ON hocsinh_lop.MaLop = lop.MaLop AND lop.TenLop = ?
                LEFT JOIN diem ON hocsinh.MaHS = diem.MaHS
                    AND diem.MaGV = ? 
                    AND diem.HocKy = ? 
                    AND diem.NamHoc = ?
                LEFT JOIN monhoc ON diem.MaMH = monhoc.MaMH";
        $studentList = $this->db->query($SQL, [$NamHoc, $TenLop, $MaGV, $HocKy, $NamHoc])->getResultArray();

        foreach ($studentList as &$student) {
            $student['DiemTBMonHoc'] = $this->getAverageScore($student);
        }
        return $studentList;
    }

    // Lưu hoặc cập nhật nhận xét của giáo viên về học sinh dưa vào mã giáo viên, mã học sinh, học kỳ, năm học và nội dung nhận xét
    public function updateTeacherComment($MaHS, $MaGV, $MaMH, $NhanXet, $HocKy, $NamHoc)
    {
        // Kiểm tra xem dữ liệu đã tồn tại chưa
        $SQLCheck = "SELECT COUNT(*) AS count
                    FROM diem
                    WHERE MaHS = ? AND MaGV = ? AND MaMH = ? AND HocKy = ? AND NamHoc = ?";
        $query = $this->db->query($SQLCheck, [$MaHS, $MaGV, $MaMH, $HocKy, $NamHoc]);
        $result = $query->getRow();

        // Nếu dữ liệu đã tồn tại, cập nhật nó
        if ($result->count > 0) {
            $SQLUpdate = "UPDATE diem
                        SET NhanXet = ?
                        WHERE MaHS = ? AND MaGV = ? AND MaMH = ? AND HocKy = ? AND NamHoc = ?";
            $this->db->query($SQLUpdate, [$NhanXet, $MaHS, $MaGV, $MaMH, $HocKy, $NamHoc]);
        } 
    }
}
