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

    //Hàm lấy điểm HK
    public function getConductPoint($MaHS, $selectedSemester, $selectedYear) {
        $SQL = "SELECT 
        lv.DiemTru
    FROM 
        vipham vp
    JOIN 
        loaivipham lv ON vp.MaLVP = lv.MaLVP
     WHERE 1=1";  // Điều kiện mặc định để có thể thêm các điều kiện khác vào sau

        // Tạo mảng tham số để truyền vào câu truy vấn
        $params = [];

        $SQL .= " AND vp.MaHS = ?";
        $params[] = $MaHS;

        $SQL .= " AND vp.HocKy = ?";
        $params[] = $selectedSemester;

        $SQL .= " AND vp.NamHoc = ?";
        $params[] = $selectedYear;

        // Thực thi truy vấn với các tham số đã được thêm vào
        $violations = $this->db->query($SQL, $params)->getResultArray();

        // Tổng điểm ban đầu là 100
        $initialScore = 100;

        // Tính tổng điểm trừ
        $totalDiemTru = 0;
        foreach ($violations as $violation) {
            $totalDiemTru += $violation['DiemTru']; // Cộng dồn DiemTru
        }

        // Tính điểm còn lại
        $remainingScore = $initialScore - $totalDiemTru;

        return  $remainingScore;
    }

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

    public function getYearList() {
        $SQL = "SELECT DISTINCT NamHoc FROM diem ORDER BY NamHoc DESC";
        $result = $this->db->query($SQL)->getResultArray();
        return array_column($result, 'NamHoc');
    }

    public function getScore($MaHS, $searchSemester, $searchYear) {
        // Tạo câu truy vấn SQL
        $sql = "
            SELECT 
                d.MaDiem,
                m.TenMH,
                d.Diem15P_1,
                d.Diem15P_2,
                d.Diem1Tiet_1,
                d.Diem1Tiet_2,
                d.DiemCK,
                d.NhanXet,
                ROUND(((d.Diem15P_1 + d.Diem15P_2) + 2 * (d.Diem1Tiet_1 + d.Diem1Tiet_2) + 3 * d.DiemCK) / 9, 1) AS DiemTBHK
            FROM 
                diem d
            JOIN 
                monhoc m ON d.MaMH = m.MaMH
            WHERE 
                d.MaHS = ?"; // Điều kiện tìm kiếm MaHS
    
        // Mảng chứa tham số truyền vào
        $params = [$MaHS];
    
        // Thêm điều kiện nếu chọn học kỳ
        if (!empty($searchSemester)) {
            $sql .= " AND d.HocKy = ?";
            $params[] = $searchSemester;
        }
    
        // Thêm điều kiện nếu chọn năm học
        if (!empty($searchYear)) {
            $sql .= " AND d.NamHoc = ?";
            $params[] = $searchYear;
        }
    
        // Sắp xếp tăng dần theo MaDiem
        $sql .= " ORDER BY d.MaDiem ASC";
    
        // Thực thi truy vấn SQL
        $result = $this->db->query($sql, $params)->getResultArray();
    
        // Trả về kết quả
        return $result;
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

    // Hàm tính điểm trung bình học kỳ cho 1 học sinh
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

    // Hàm tính điểm trung bình học kì cho lớp học
    public function getSemesterAverageScoreForClass($MaLop, $HocKy, $NamHoc)
{
    // Lấy danh sách tất cả học sinh trong lớp, học kỳ và năm học cụ thể
    $SQL = "SELECT hsl.MaHS, tk.HoTen
            FROM hocsinh_lop hsl
            JOIN hocsinh hs ON hsl.MaHS = hs.MaHS
            JOIN taikhoan tk ON hs.MaTK = tk.MaTK
            WHERE hsl.MaLop = ? AND hsl.NamHoc = ?";

    $students = $this->db->query($SQL, [$MaLop, $NamHoc])->getResultArray();

    // Khởi tạo mảng kết quả
    $result = [];

    // Duyệt qua từng học sinh để tính điểm trung bình
    foreach ($students as $student) {
        $MaHS = $student['MaHS'];
        $HoTen = $student['HoTen'];

        // Lấy tất cả điểm của học sinh trong học kỳ và năm học
        $SQL = "SELECT Diem15P_1, Diem15P_2, Diem1Tiet_1, Diem1Tiet_2, DiemCK
                FROM diem
                WHERE MaHS = ? AND HocKy = ? AND NamHoc = ?";

        $scores = $this->db->query($SQL, [$MaHS, $HocKy, $NamHoc])->getResultArray();

        // Tính điểm trung bình nếu có dữ liệu điểm
        if (!empty($scores)) {
            $totalScore = 0;
            $subjectCount = 0;

            foreach ($scores as $score) {
                // Kiểm tra nếu có điểm null thì bỏ qua môn đó
                if ($score['Diem15P_1'] !== null && $score['Diem15P_2'] !== null &&
                    $score['Diem1Tiet_1'] !== null && $score['Diem1Tiet_2'] !== null &&
                    $score['DiemCK'] !== null) {

                    // Tính điểm trung bình môn học
                    $DiemTB = (
                        ($score['Diem15P_1'] + $score['Diem15P_2']) * 0.1 +
                        ($score['Diem1Tiet_1'] + $score['Diem1Tiet_2']) * 0.2 +
                        $score['DiemCK'] * 0.4
                    );

                    $totalScore += $DiemTB;
                    $subjectCount++;
                }
            }

            // Tính điểm trung bình chung của học kỳ
            $DTB = $subjectCount > 0 ? round($totalScore / $subjectCount, 2) : 'Chưa có dữ liệu';
        } else {
            $DTB = 'Chưa có dữ liệu';
        }

        // Thêm kết quả vào mảng
        $result[] = [
            'MaHS' => $MaHS,
            'HoTen' => $HoTen,
            'DTB' => $DTB
        ];
    }   

        // In kết quả ra màn hình để kiểm tra nếu cần
        /*
        echo "<pre>";
        print_r($result);
        echo "</pre>";
        */
        return $result; // Trả về danh sách điểm trung bình của tất cả học sinh
    }

    // Xếp hạng cho các học sinh
    public function getRankForClass($semesterAverageScoreForClass) {
        // Sắp xếp danh sách theo điểm trung bình giảm dần
        usort($semesterAverageScoreForClass, function($a, $b) {
            return $b['DTB'] <=> $a['DTB'];
        });
    
        // Gán hạng cho từng học sinh
        $rank = 1;
        foreach ($semesterAverageScoreForClass as $index => &$student) {
            $student['Rank'] = $rank++;
        }
    
        // In kết quả xếp hạng ra màn hình để kiểm tra
        /*
        echo "<pre>";
        print_r($semesterAverageScoreForClass);
        echo "</pre>";
        */
        return $semesterAverageScoreForClass; // Trả về danh sách đã xếp hạng
    }

    // Xếp hạng cho 1 học sinh
    public function getSemesterRank($MaHS, $MaLop, $HocKy, $NamHoc) {
        $DiemModel = new DiemModel();
        $semesterAverageScoreForClass = $DiemModel->getSemesterAverageScoreForClass($MaLop, $HocKy, $NamHoc);
        $RankArray = $DiemModel->getRankForClass($semesterAverageScoreForClass);
        foreach ($RankArray as $rank) {
            if ($rank['MaHS'] == $MaHS) {
                return $rank['Rank']; 
            }
        }
    }



    // Hàm tính điểm trung bình năm học cho 1 HS
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
    public function getYearAverageScoreForClass($MaLop, $NamHoc)
    {
    // Lấy danh sách tất cả học sinh trong lớp và năm học cụ thể
    $SQL = "SELECT hsl.MaHS, tk.HoTen
            FROM hocsinh_lop hsl
            JOIN hocsinh hs ON hsl.MaHS = hs.MaHS
            JOIN taikhoan tk ON hs.MaTK = tk.MaTK
            WHERE hsl.MaLop = ? AND hsl.NamHoc = ?";

    $students = $this->db->query($SQL, [$MaLop, $NamHoc])->getResultArray();

    // Khởi tạo mảng kết quả
    $result = [];

    // Lấy điểm trung bình học kỳ 1 và học kỳ 2 cho cả lớp
    $DiemHK1 = $this->getSemesterAverageScoreForClass($MaLop, 1, $NamHoc);
    $DiemHK2 = $this->getSemesterAverageScoreForClass($MaLop, 2, $NamHoc);

    // Duyệt qua từng học sinh để tính điểm trung bình cả năm
    foreach ($students as $student) {
        $MaHS = $student['MaHS'];
        $HoTen = $student['HoTen'];

        // Tìm điểm trung bình học kỳ 1 và 2 của học sinh từ mảng kết quả học kỳ
        $DTBHK1 = null;
        $DTBHK2 = null;
        foreach ($DiemHK1 as $item) {
            if ($item['MaHS'] === $MaHS) {
                $DTBHK1 = $item['DTB'];
                break;
            }
        }
        foreach ($DiemHK2 as $item) {
            if ($item['MaHS'] === $MaHS) {
                $DTBHK2 = $item['DTB'];
                break;
            }
        }

        // Tính điểm trung bình cả năm
        if ($DTBHK1 === null || $DTBHK2 === null) {
            $DTB = 'Chưa có dữ liệu';
        } else {
            $DTB = round(($DTBHK1 + $DTBHK2 * 2) / 3, 1);
        }

        // Thêm kết quả vào mảng
        $result[] = [
            'MaHS' => $MaHS,
            'HoTen' => $HoTen,
            'DTB' => $DTB
        ];
    }

    // Sắp xếp danh sách theo điểm trung bình giảm dần
    usort($result, function($a, $b) {
        return $b['DTB'] <=> $a['DTB'];
    });

    // Gán thứ hạng cho từng học sinh
    $rank = 1;
    foreach ($result as $key => $student) {
        if ($student['DTB'] !== 'Chưa có dữ liệu') {
            $result[$key]['Rank'] = $rank++;
        } else {
            $result[$key]['Rank'] = 'N/A';
        }
    }

    // In kết quả ra màn hình để kiểm tra
    /*
    echo "<pre>";
    print_r($result);
    echo "</pre>";
    */
    return $result; // Trả về danh sách điểm trung bình cả năm và xếp hạng của tất cả học sinh
}

    // Hàm lấy thứ hạng của một học sinh theo mã học sinh
    public function getYearRank($MaHS, $MaLop, $NamHoc)
    {
        $students = $this->getYearAverageScoreForClass($MaLop, $NamHoc);
        foreach ($students as $student) {
            if ($student['MaHS'] === $MaHS) {
                return $student['Rank'];
            }
        }
        return 'N/A';
    }

}
