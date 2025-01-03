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
