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

    // Hàm báo cáo học lực theo lớp, học kỳ và năm học và loại bài kiểm tra
    public function getAcademicReport($MaGV, $HocKy, $NamHoc, $TenBaiKT)
    {
        $SQLClasses = "SELECT DISTINCT lop.TenLop, monhoc.TenMH
                        FROM phancong
                        JOIN lop ON phancong.Malop = lop.MaLop
                        JOIN monhoc ON phancong.MaMH = monhoc.MaMH
                        WHERE phancong.MaGV = ? AND phancong.NamHoc = ? AND phancong.HocKy = ?";
        $classList = $this->db->query($SQLClasses, [$MaGV, $NamHoc, $HocKy])->getResultArray();

        $result = [];
        foreach ($classList as $class) {
            $TenLop = $class['TenLop'];
            $TenMH = $class['TenMH'];

            $SQLScores = "SELECT hocsinh_lop.MaHS, diem.*
                        FROM hocsinh_lop
                        LEFT JOIN diem
                        ON hocsinh_lop.MaHS = diem.MaHS
                        AND diem.MaGV = ?
                        AND diem.NamHoc = ?
                        AND diem.HocKy = ?
                        JOIN lop ON hocsinh_lop.MaLop = lop.MaLop
                        WHERE lop.TenLop = ? AND hocsinh_lop.NamHoc = ?";
            $scores = $this->db->query($SQLScores, [$MaGV, $NamHoc, $HocKy, $TenLop, $NamHoc])->getResultArray();

            $totalStudents = count($scores);
            if ($totalStudents === 0) {
                $result[] = [
                    'TenBaiKT' => $TenBaiKT,
                    'TenLop' => $TenLop,
                    'TenMH' => $TenMH,
                    'Percentages' => null,
                    'ClassAverageScore' => null,
                    'MissingData' => true
                ];
                continue;
            }

            $allScoresComplete = true;
            foreach ($scores as $score) {
                if (!isset($score[$TenBaiKT]) || $score[$TenBaiKT] === null) {
                    $allScoresComplete = false;
                    break;
                }
            }

            if (!$allScoresComplete) {
                $result[] = [
                    'TenLop' => $TenLop,
                    'TenMH' => $TenMH,
                    'Percentages' => null,
                    'ClassAverageScore' => null,
                    'MissingData' => true
                ];
                continue;
            }

            $performanceCounts = [
                'Giỏi' => 0,
                'Khá' => 0,
                'Trung bình' => 0,
                'Yếu' => 0
            ];
            $totalScore = 0;

            foreach ($scores as $score) {
                $examScore = $score[$TenBaiKT];
                $totalScore += $examScore;

                $performance = $this->getAcademicPerformance($examScore);
                if ($performance !== null) {
                    $performanceCounts[$performance]++;
                }
            }

            $percentages = [];
            foreach ($performanceCounts as $key => $count) {
                $percentages[$key] = $totalStudents > 0 ? round(($count / $totalStudents) * 100, 2) : 0;
            }

            $classAverageScore = $totalStudents > 0 ? round($totalScore / $totalStudents, 1) : 0;

            $result[] = [
                'TenBaiKT' => $TenBaiKT,
                'TenLop' => $TenLop,
                'TenMH' => $TenMH,
                'Percentages' => $percentages,
                'ClassAverageScore' => $classAverageScore,
                'MissingData' => false
            ];
        }

        return $result;
    }

    // Hàm lấy thong tin chi tiết báo cáo học lực lớp học dựa vào MaGV, TenLop, TenMH, HocKy, NamHoc và TenBaiKT
    public function getAcademicReportDetail($MaGV, $TenLop, $TenMH, $HocKy, $NamHoc, $TenBaiKT)
    {
        $SQL = "SELECT hocsinh.MaHS, taikhoan.HoTen, diem.*
                FROM hocsinh_lop
                LEFT JOIN hocsinh ON hocsinh_lop.MaHS = hocsinh.MaHS
                LEFT JOIN taikhoan ON hocsinh.MaTK = taikhoan.MaTK
                LEFT JOIN diem ON hocsinh.MaHS = diem.MaHS
                    AND diem.MaGV = ? 
                    AND diem.NamHoc = ?
                    AND diem.HocKy = ?
                JOIN lop ON hocsinh_lop.MaLop = lop.MaLop
                JOIN monhoc ON diem.MaMH = monhoc.MaMH
                WHERE lop.TenLop = ? AND monhoc.TenMH = ? AND hocsinh_lop.NamHoc = ?";
        $scores = $this->db->query($SQL, [$MaGV, $NamHoc, $HocKy, $TenLop, $TenMH, $NamHoc])->getResultArray();

        $performanceDetails = [
            'Giỏi' => [],
            'Khá' => [],
            'Trung bình' => [],
            'Yếu' => []
        ];

        foreach ($scores as $score) {
            $examScore = $score[$TenBaiKT];
            if ($examScore === null) {
                continue;
            }

            $performance = $this->getAcademicPerformance($examScore);
            if ($performance !== null) {
                $performanceDetails[$performance][] = [
                    'STT' => count($performanceDetails[$performance]) + 1,
                    'MaHS' => $score['MaHS'],
                    'HoTen' => $score['HoTen'],
                    'Diem' => $examScore
                ];
            }
        }

        return [
            'MaGV' => $MaGV,
            'TenLop' => $TenLop,
            'TenMH' => $TenMH,
            'HocKy' => $HocKy,
            'NamHoc' => $NamHoc,
            'TenBaiKT' => $TenBaiKT,
            'PerformanceDetails' => $performanceDetails
        ];
    }

    // Lấy thông tin nhập điểm (TenLop, TenMH, Trạng thái các cột điểm) dựa vào MaGV, HocKy, NamHoc
    public function getScoreInputInfo($MaGV, $HocKy, $NamHoc)
    {
        // Lấy danh sách lớp học mà giáo viên đang phụ trách
        $SQLClasses = "SELECT DISTINCT lop.MaLop, lop.TenLop, monhoc.MaMH, monhoc.TenMH
                        FROM phancong
                        JOIN lop ON phancong.MaLop = lop.MaLop
                        JOIN monhoc ON phancong.MaMH = monhoc.MaMH
                        WHERE phancong.MaGV = ? AND phancong.HocKy = ? AND phancong.NamHoc = ? AND phancong.VaiTro = 'Giáo viên bộ môn'";
        $classList = $this->db->query($SQLClasses, [$MaGV, $HocKy, $NamHoc])->getResultArray();

        $result = [];

        foreach ($classList as $class) {
            $examNames = [
                'Diem15P_1',
                'Diem15P_2',
                'Diem1Tiet_1',
                'Diem1Tiet_2',
                'DiemCK'
            ];
            $status = [];

            foreach ($examNames as $examName) {
                // Kiểm tra xem tất cả học sinh trong lớp đã có điểm ở cột tương ứng chưa
                $SQLCheck = "SELECT COUNT(*) AS TotalStudents,
                                    SUM(CASE WHEN $examName IS NULL THEN 1 ELSE 0 END) AS MissingScores
                            FROM hocsinh_lop
                            LEFT JOIN diem ON hocsinh_lop.MaHS = diem.MaHS
                                AND diem.HocKy = ? AND diem.NamHoc = ? AND diem.MaMH = ?
                            WHERE hocsinh_lop.MaLop = ? AND hocsinh_lop.NamHoc = ?";
                $scoreCheck = $this->db->query($SQLCheck, [$HocKy, $NamHoc, $class['MaMH'], $class['MaLop'], $NamHoc]);

                $missingScores = $scoreCheck->getRow()->MissingScores;

                if ($missingScores == 0) {
                    $status[$examName] = 'Đã hoàn thành';  // Tất cả học sinh đã có điểm
                } else {
                    $status[$examName] = '';  // Có học sinh chưa có điểm
                }
            }

            // Thêm thông tin lớp và trạng thái cột điểm vào kết quả
            $result[] = [
                'TenLop' => $class['TenLop'],
                'TenMH' => $class['TenMH'],
                'Diem15P_1' => $status['Diem15P_1'],
                'Diem15P_2' => $status['Diem15P_2'],
                'Diem1Tiet_1' => $status['Diem1Tiet_1'],
                'Diem1Tiet_2' => $status['Diem1Tiet_2'],
                'DiemCK' => $status['DiemCK']
            ];
        }

        return $result;
    }

    // Lấy thông tin nhập điểm chi tiết (MaHS, HoTen, Diem) dựa vào MaGV, TenLop, TenMH, HocKy, NamHoc
    public function getScoreInputDetail($MaGV, $TenLop, $TenMH, $HocKy, $NamHoc)
    {
        $SQL = "SELECT hocsinh.MaHS AS MaHocSinh, taikhoan.HoTen, diem.*
                FROM giaovien
                JOIN phancong ON giaovien.MaGV = phancong.MaGV
                    AND phancong.HocKy = ? AND phancong.NamHoc = ? AND phancong.VaiTro = 'Giáo viên bộ môn'
                JOIN lop ON phancong.MaLop = lop.MaLop AND lop.TenLop = ?
                JOIN monhoc ON phancong.MaMH = monhoc.MaMH AND monhoc.TenMH = ?
                LEFT JOIN hocsinh_lop ON lop.MaLop = hocsinh_lop.MaLop 
                    AND phancong.NamHoc = hocsinh_lop.NamHoc
                    AND hocsinh_lop.NamHoc = ?
                LEFT JOIN hocsinh ON hocsinh_lop.MaHS = hocsinh.MaHS
                LEFT JOIN taikhoan ON hocsinh.MaTK = taikhoan.MaTK
                LEFT JOIN diem ON hocsinh.MaHS = diem.MaHS
                    AND diem.MaGV = giaovien.MaGV
                    AND diem.HocKy = phancong.HocKy
                    AND diem.NamHoc = phancong.NamHoc
                    AND diem.NamHoc = ?
                WHERE giaoVien.MaGV = ?";
        $scores = $this->db->query($SQL, [$HocKy, $NamHoc, $TenLop, $TenMH, $NamHoc, $NamHoc, $MaGV])->getResultArray();

        // Tính điểm trung bình môn học
        foreach ($scores as &$score) {
            $score['DiemTBMonHoc'] = $this->getAverageScore($score);
        }

        return $scores;
    }

    // Lưu hoặc cập nhật điểm của học sinh dựa vào MaHS, MaGV, MaMH, HocKy, NamHoc và điểm số
    public function insertOrUpdateScore($MaHS, $MaGV, $MaMH, $Diem15P_1, $Diem15P_2, $Diem1Tiet_1, $Diem1Tiet_2, $DiemCK, $HocKy, $NamHoc)
    {
        try {
            // Xử lý giá trị rỗng thành NULL
            $Diem15P_1 = ($Diem15P_1 === null || $Diem15P_1 === '') ? null : $Diem15P_1;
            $Diem15P_2 = ($Diem15P_2 === null || $Diem15P_2 === '') ? null : $Diem15P_2;
            $Diem1Tiet_1 = ($Diem1Tiet_1 === null || $Diem1Tiet_1 === '') ? null : $Diem1Tiet_1;
            $Diem1Tiet_2 = ($Diem1Tiet_2 === null || $Diem1Tiet_2 === '') ? null : $Diem1Tiet_2;
            $DiemCK = ($DiemCK === null || $DiemCK === '') ? null : $DiemCK;

            // Kiểm tra xem bản ghi đã tồn tại chưa
            $SQLCheck = "SELECT COUNT(*) AS count
                        FROM diem
                        WHERE MaHS = ? AND MaGV = ? AND MaMH = ? AND HocKy = ? AND NamHoc = ?";
            $query = $this->db->query($SQLCheck, [$MaHS, $MaGV, $MaMH, $HocKy, $NamHoc]);
            $result = $query->getRow();

            if (!$result) {
                log_message('error', 'Lỗi khi kiểm tra bản ghi trong database.');
                return false;
            }

            // Nếu bản ghi đã tồn tại, thực hiện cập nhật
            if ($result->count > 0) {
                $SQLUpdate = "UPDATE diem
                            SET Diem15P_1 = ?, 
                                Diem15P_2 = ?, 
                                Diem1Tiet_1 = ?, 
                                Diem1Tiet_2 = ?, 
                                DiemCK = ?
                            WHERE MaHS = ? AND MaGV = ? AND MaMH = ? AND HocKy = ? AND NamHoc = ?";
                $this->db->query($SQLUpdate, [$Diem15P_1, $Diem15P_2, $Diem1Tiet_1, $Diem1Tiet_2, $DiemCK, $MaHS, $MaGV, $MaMH, $HocKy, $NamHoc]);
            }
            // Nếu bản ghi chưa tồn tại, thực hiện thêm mới
            else {
                $SQLInsert = "INSERT INTO diem (MaHS, MaGV, MaMH, Diem15P_1, Diem15P_2, Diem1Tiet_1, Diem1Tiet_2, DiemCK, HocKy, NamHoc)
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $this->db->query($SQLInsert, [$MaHS, $MaGV, $MaMH, $Diem15P_1, $Diem15P_2, $Diem1Tiet_1, $Diem1Tiet_2, $DiemCK, $HocKy, $NamHoc]);
            }
        } catch (\Exception $e) {
            log_message('error', 'Lỗi ngoại lệ: ' . $e->getMessage());
        }
    }

    // Viết hàm tính điểm trung bình môn học theo học kỳ dựa vào MaHS, MaMH, HocKy, NamHoc
    public function getAverageScoreForSemester($MaHS, $MaMH, $HocKy, $NamHoc)
    {
        $SQL = "SELECT diem.*
                FROM diem
                WHERE MaHS = ? AND MaMH = ? AND HocKy = ? AND NamHoc = ?";
        $scores = $this->db->query($SQL, [$MaHS, $MaMH, $HocKy, $NamHoc])->getResultArray();

        if (empty($scores)) {
            return null;
        }

        $DiemTrungBinh = $this->getAverageScore($scores[0]);

        return $DiemTrungBinh;
    }
}
