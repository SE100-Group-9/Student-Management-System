<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\TaiKhoanModel;
use App\Models\HocSinhModel;
use App\Models\HocSinhLopModel;
use App\Models\LopModel;
use App\Models\DanhHieuModel;
use App\Models\ThuNganModel;
use App\Models\GiamThiModel;
use App\Models\GiaoVienModel;
use App\Models\BanGiamHieuModel;
use App\Models\MonHocModel;
use App\Models\PhanCongModel;
use App\Models\DiemModel;
use App\Models\HanhKiemModel;
use App\Models\CTPTTModel;
use App\Models\ThamSoModel;

class TeacherController extends Controller
{

    public function statics()
    {
        $HocSinhModel = new HocSinhModel();
        $PhanCongModel = new PhanCongModel();
        $DiemModel = new DiemModel();

        $MaTK = session('MaTK');
        $MaGV = (new GiaoVienModel())->getTeacherInfo($MaTK)['MaGV'];
        // Nhận giá trị học kỳ  và năm học được chọn từ form
        $selectedSemester = $this->request->getVar('semester') ?? 'Học kỳ 1';

        // Tách chuỗi để lấy số học kỳ
        $semesterNumber = preg_replace('/\D/', '', $selectedSemester);

        // Lấy danh sách năm học được phân công dạy dựa vào mã giáo viên
        $yearList = $PhanCongModel->getAssignedYearsByTeacher($MaGV);
        $yearList = array_column($yearList, 'NamHoc');
        if (empty($yearList)) {
            return view('teacher/statics/grade', [
                'error' => 'Bạn chưa được phân công lớp giảng dạy nào.',
                'yearList' => [],
                'selectedYear' => '',
                'selectedSemester' => '',
                'previousYear' => '',
                'excellentCount' => 0,
                'goodCount' => 0,
                'averageCount' => 0,
                'weakCount' => 0,
                'excellentChange' => 0,
                'goodChange' => 0,
                'averageChange' => 0,
                'weakChange' => 0,

            ]);
        }
        $selectedYear = $this->request->getVar('year') ?? $yearList[0];

        // Lấy danh sách học sinh dựa vào MaGV, HocKy, NamHoc
        $currentStudentList = $HocSinhModel->getStudentListByTeacher($MaGV, $semesterNumber, $selectedYear);

        $currentReport = [];
        foreach ($currentStudentList as $student) {
            $MaHS = $student['MaHS'];
            $averageScore = $DiemModel->getAverageScore($student);
            $performance  = $DiemModel->getAcademicPerformance($averageScore);
            $currentReport[] = [
                'student' => $student,
                'averageScore' => $averageScore,
                'performance' => $performance,
            ];
        }
        log_message('debug', 'Current report: ' . print_r($currentReport, true));

        // Xử lý chuỗi năm học để lấy năm liền trước
        $yearArray = explode('-', $selectedYear);
        $previousYear = ($yearArray[0] - 1) . '-' . ($yearArray[1] - 1);

        // Lấy danh sách học sinh theo năm học trước
        $previousStudentList = $HocSinhModel->getStudentListByTeacher($MaGV, $semesterNumber, $previousYear);

        $previousReport = [];
        foreach ($previousStudentList as $student) {
            $MaHS = $student['MaHS'];
            $averageScore = $DiemModel->getAverageScore($student);
            $performance = $DiemModel->getAcademicPerformance($averageScore);
            $previousReport[] = [
                'student' => $student,
                'averageScore' => $averageScore,
                'performance' => $performance,
            ];
        }
        log_message('debug', 'Previous report: ' . print_r($previousReport, true));

        // Tính toán số lượng học sinh theo từng loại học lực trong năm học hiện tại và năm học trước
        $performanceStatistics = $DiemModel->getYearAverageScoreChange($currentReport, $previousReport);

        // Số lượng học sinh theo từng loại học lực
        $excellentCount = $performanceStatistics['summary']['Giỏi']['current'];
        $goodCount = $performanceStatistics['summary']['Khá']['current'];
        $averageCount = $performanceStatistics['summary']['Trung bình']['current'];
        $weakCount = $performanceStatistics['summary']['Yếu']['current'];

        // Phần trăm học lực học sinh thay đổi so với năm học trước
        $excellentChange = $performanceStatistics['changes']['Giỏi'];
        $goodChange = $performanceStatistics['changes']['Khá'];
        $averageChange = $performanceStatistics['changes']['Trung bình'];
        $weakChange = $performanceStatistics['changes']['Yếu'];

        return view('teacher/statics/grade', [
            'selectedSemester' => $selectedSemester,
            'selectedYear' => $selectedYear,
            'yearList' => $yearList,
            'previousYear' => $previousYear,
            'excellentCount' => $excellentCount,
            'goodCount' => $goodCount,
            'averageCount' => $averageCount,
            'weakCount' => $weakCount,
            'excellentChange' => $excellentChange,
            'goodChange' => $goodChange,
            'averageChange' => $averageChange,
            'weakChange' => $weakChange,
        ]);
    }

    public function studentList()
    {
        $GiaoVienModel = new GiaoVienModel();
        $PhanCongModel = new PhanCongModel();
        $HocSinhLopModel = new HocSinhLopModel();

        $MaTK = session('MaTK');
        $MaGV = $GiaoVienModel->getTeacherInfo($MaTK)['MaGV'];

        // Lấy danh sách năm học được phân công dạy
        $yearList = $PhanCongModel->getAssignedYearsByTeacher($MaGV);
        $yearList = array_column($yearList, 'NamHoc');
        if (empty($yearList)) {
            return view('teacher/student/list', [
                'error' => 'Bạn chưa được phân công lớp giảng dạy nào.',
                'yearList' => [],
                'classList' => [],
                'studentList' => []
            ]);
        }

        // Năm học và lớp học được chọn
        $selectedYear = $this->request->getVar('year') ?? $yearList[0];
        $classList = $PhanCongModel->getAssignedClasses($MaGV, $selectedYear);
        $classList = array_column($classList, 'TenLop');
        if (empty($classList)) {
            return view('teacher/student/list', [
                'error' => "Bạn chưa được phân công lớp nào trong năm học $selectedYear.",
                'yearList' => $yearList,
                'classList' => [],
                'selectedYear' => $selectedYear,
                'studentList' => []
            ]);
        }
        $selectedClass = $this->request->getVar('class') ?? $classList[0];

        // Lấy danh sách học sinh dựa vào năm học và lớp học
        $studentList = $HocSinhLopModel->getStudentInClass($selectedClass, $selectedYear);

        return view('teacher/student/list', [
            'error' => null,
            'yearList' => $yearList,
            'selectedYear' => $selectedYear,
            'classList' => $classList,
            'selectedClass' => $selectedClass,
            'studentList' => $studentList
        ]);
    }

    public function classRate()
    {
        $PhanCongModel = new PhanCongModel();
        $GiaoVienModel = new GiaoVienModel();

        $MaTK = session('MaTK');
        $MaGV = $GiaoVienModel->getTeacherInfo($MaTK)['MaGV'];

        // Nhận giá trị học kỳ được chọn từ form
        $selectedSemester = $this->request->getVar('semester') ?? 'Học kỳ 1';


        // Tách chuỗi để lấy số học kỳ
        $semesterNumber = preg_replace('/\D/', '', $selectedSemester);

        // Lấy danh sách năm học được phân công dạy dựa vào mã giáo viên
        $yearList = $PhanCongModel->getAssignedYearsByTeacher($MaGV);
        $yearList = array_column($yearList, 'NamHoc');
        if (empty($yearList)) {
            return view('teacher/class/rate', [
                'error' => 'Bạn chưa được phân công lớp giảng dạy nào.',
                'yearList' => [],
                'classList' => [],
                'studentList' => [],
                'selectedYear' => '',
                'selectedSemester' => '',
                'selectedClass' => ''

            ]);
        }
        $selectedYear = $this->request->getVar('year') ?? $yearList[0];

        // Lấy danh sách lớp học mà giáo viên đã phân công dạy dựa vào mã giáo viên, năm học và học kỳ
        $classList = $PhanCongModel->getAssignedClassesBySemester($MaGV, $selectedYear, $semesterNumber);
        $classList = array_column($classList, 'TenLop');
        if (empty($classList)) {
            return view('teacher/class/rate', [
                'error' => "Bạn chưa được phân công dạy trong học kỳ $semesterNumber năm học $yearList[0].",
                'yearList' => $yearList,
                'classList' => [],
                'studentList' => [],
                'selectedYear' => $selectedYear,
                'selectedSemester' => $selectedSemester,
                'selectedClass' => ''
            ]);
        }
        $selectedClass = $this->request->getVar('class') ?? $classList[0];


        // Lấy nhận xét của giáo viên về học sinh
        $DiemModel = new DiemModel();
        $studentList = $DiemModel->getTeacherComment($MaGV, $selectedClass, $semesterNumber, $selectedYear);

        return view('teacher/class/rate', [
            'error' => null,
            'yearList' => $yearList,
            'classList' => $classList,
            'selectedYear' => $selectedYear ?? '',
            'selectedSemester' => $selectedSemester,
            'selectedClass' => $selectedClass,
            'studentList' => $studentList
        ]);
    }

    public function addRate()
    {
        $DiemModel = new DiemModel();

        // Lấy nhận xét của giáo viên về học sinh từ form
        $comments = $this->request->getPost('comments');
        $MaTK = session('MaTK');
        $MaGV = (new GiaoVienModel())->getTeacherInfo($MaTK)['MaGV'];
        $class = $this->request->getPost('class');
        $semester = preg_replace('/\D/', '', $this->request->getPost('semester'));
        $year = $this->request->getPost('year');

        if ($comments && is_array($comments)) {
            foreach ($comments as $MaHS => $comment) {
                $NhanXet = $comment['NhanXet'] ?? null;
                $TenMH = $comment['TenMH'] ?? null;
                // Lấy MaMH từ TenMH
                $MaMH = (new MonHocModel())->getSubjectID($TenMH)['MaMH'];

                // Kiểm tra và cập nhật nhận xét
                if ($MaHS && $MaGV && $MaMH !== null && $NhanXet !== null) {
                    $DiemModel->updateTeacherComment($MaHS, $MaGV, $MaMH, $NhanXet, $semester, $year);
                }
            }
            return redirect()->back()->with('success', 'Cập nhật đánh giá thành công!');
        }
        return redirect()->back()->with('error', 'Không có dữ liệu cập nhật.');
    }

    public function classRating()
    {
        return view('teacher/class/rating');
    }

    public $examColumnMapping = [
        '15 Phút lần 1' => 'Diem15P_1',
        '15 Phút lần 2' => 'Diem15P_2',
        '1 Tiết lần 1' => 'Diem1Tiet_1',
        '1 Tiết lần 2' => 'Diem1Tiet_2',
        'Cuối kỳ' => 'DiemCK',
    ];

    // Teacher - Báo cáo học lực lớp
    public function recordList()
    {
        $GiaoVienModel = new GiaoVienModel();
        $PhanCongModel = new PhanCongModel();
        $DiemModel = new DiemModel();

        $MaTK = session('MaTK');
        $MaGV = $GiaoVienModel->getTeacherInfo($MaTK)['MaGV'];

        // Nhận giá trị học kỳ được chọn từ form
        $selectedSemester = $this->request->getVar('semester') ?? 'Học kỳ 1';
        $selectedExam = $this->request->getVar('exam') ?? '15 Phút lần 1';

        // Tách chuỗi để lấy số học kỳ
        $semesterNumber = preg_replace('/\D/', '', $selectedSemester);

        // Lấy danh sách năm học được phân công dạy dựa vào mã giáo viên
        $yearList = $PhanCongModel->getAssignedYearsByTeacher($MaGV);
        $yearList = array_column($yearList, 'NamHoc');
        if (empty($yearList)) {
            return view('teacher/class/record/list', [
                'error' => 'Bạn chưa được phân công lớp giảng dạy nào.',
                'yearList' => [],
                'studentList' => [],
                'selectedYear' => '',
                'selectedSemester' => '',
            ]);
        }
        $selectedYear = $this->request->getVar('year') ?? $yearList[0];

        // Ánh xạ bài kiểm tra với cột điểm trong bảng điểm
        $examColumn = $this->examColumnMapping[$selectedExam] ?? '';

        if (!$examColumn) {
            return view('teacher/class/record/list', [
                'error' => 'Bài kiểm tra không hợp lệ.',
                'yearList' => $yearList,
                'selectedYear' => $selectedYear ?? '',
                'selectedSemester' => $selectedSemester,
                'selectedExam' => $selectedExam,
                'academicReport' => []
            ]);
        }

        // Gọi hàm lấy báo cáo học lực lớp từ model
        $academicReport = $DiemModel->getAcademicReport($MaGV, $semesterNumber, $selectedYear, $examColumn);

        return view(
            'teacher/class/record/list',
            [
                'error' => null,
                'yearList' => $yearList,
                'selectedYear' => $selectedYear ?? '',
                'selectedSemester' => $selectedSemester,
                'selectedExam' => $selectedExam,
                'academicReport' => $academicReport,
            ]
        );
    }

    public function recordDetail()
    {
        $DiemModel = new DiemModel();

        $MaTK = session('MaTK');
        $MaGV = (new GiaoVienModel())->getTeacherInfo($MaTK)['MaGV'];
        $TenLop = $this->request->getGet('TenLop');
        $TenMH = $this->request->getGet('TenMH');
        $NamHoc = $this->request->getGet('NamHoc');
        $HocKy = $this->request->getGet('HocKy');
        $TenBaiKT = $this->request->getGet('TenBaiKT');

        // Tách chuỗi để lấy số học kỳ
        $semesterNumber = preg_replace('/\D/', '', $HocKy);

        // Ánh xạ bài kiểm tra với cột điểm trong bảng điểm
        $examColumn = $this->examColumnMapping[$TenBaiKT] ?? '';

        // Gọi hàm lấy báo cáo chi tiết học lực lớp từ model
        $studentList = $DiemModel->getAcademicReportDetail($MaGV, $TenLop, $TenMH, $semesterNumber, $NamHoc, $examColumn);

        log_message('debug', 'Student list: ' . print_r($studentList, true));

        return view('teacher/class/record/detail', [
            'studentList' => $studentList,
            'TenLop' => $TenLop,
            'TenMH' => $TenMH,
            'NamHoc' => $NamHoc,
            'HocKy' => $HocKy,
            'TenBaiKT' => $TenBaiKT
        ]);
    }



    public function enterList()
    {


        $MaTK = session('MaTK');
        $MaGV = (new GiaoVienModel())->getTeacherInfo($MaTK)['MaGV'];

        // Nhận giá trị học kỳ được chọn từ form
        $selectedSemester = $this->request->getVar('semester') ?? 'Học kỳ 1';
        // Tách chuỗi để lấy số học kỳ'
        $semesterNumber = preg_replace('/\D/', '', $selectedSemester);

        // Lấy danh sách năm học được phân công dạy dựa vào mã giáo viên
        $PhanCongModel = new PhanCongModel();
        $yearList = $PhanCongModel->getAssignedYearsByTeacher($MaGV);
        $yearList = array_column($yearList, 'NamHoc');
        if (empty($yearList)) {
            return view('teacher/class/enter/list', [
                'error' => 'Bạn chưa được phân công lớp giảng dạy nào.',
                'yearList' => [],
                'selectedYear' => '',
                'selectedSemester' => '',
                'enterList' => []
            ]);
        }
        $selectedYear = $this->request->getVar('year') ?? $yearList[0];

        // Lấy thông tin nhập điểm (TenLop, TenMH, Trạng thái các cột điểm) dựa vào MaGV, HocKy, NamHoc
        $DiemModel = new DiemModel();
        $enterList = $DiemModel->getScoreInputInfo($MaGV, $semesterNumber, $selectedYear);

        log_message('debug', 'Enter list: ' . print_r($enterList, true));
        return view('teacher/class/enter/list', [
            'error' => null,
            'yearList' => $yearList,
            'selectedYear' => $selectedYear,
            'selectedSemester' => $selectedSemester,
            'enterList' => $enterList
        ]);
    }

    public function enterNext()
    {
        $DiemModel = new DiemModel();

        $MaTK = session('MaTK');
        $MaGV = (new GiaoVienModel())->getTeacherInfo($MaTK)['MaGV'];
        $NamHoc = $this->request->getGet('NamHoc');
        $HocKy = $this->request->getGet('HocKy');
        // Tách chuỗi để lấy số học kỳ
        $semesterNumber = preg_replace('/\D/', '', $HocKy);
        $TenLop = $this->request->getGet('TenLop');
        $TenMH = $this->request->getGet('TenMH');

        // Gọi hàm Lấy thông tin nhập điểm chi tiết (MaHS, HoTen, Diem) dựa vào MaGV, TenLop, TenMH, HocKy, NamHoc
        $scoreList = $DiemModel->getScoreInputDetail($MaGV, $TenLop, $TenMH, $semesterNumber, $NamHoc);

        return view('teacher/class/enter/next', [
            'scoreList' => $scoreList,
            'TenLop' => $TenLop,
            'TenMH' => $TenMH,
            'NamHoc' => $NamHoc,
            'HocKy' => $HocKy
        ]);
    }

    public function enterScore()
    {
        $DiemModel = new DiemModel();

        $scores = $this->request->getPost('scores');
        $MaTK = session('MaTK');
        $MaGV = (new GiaoVienModel())->getTeacherInfo($MaTK)['MaGV'];
        $year = $this->request->getPost('year');
        $semester = preg_replace('/\D/', '', $this->request->getPost('semester'));
        $TenMH = $this->request->getPost('subject');

        // Lấy MaMH từ TenMH
        $MaMH = (new MonHocModel())->getSubjectID($TenMH)['MaMH'];

        log_message('debug', 'Scores: ' . print_r($scores, true));
        log_message('debug', 'Year: ' . $year);
        log_message('debug', 'Semester: ' . $semester);

        $errors = []; // Mảng lưu lỗi

        if ($scores && is_array($scores)) {
            foreach ($scores as $MaHocSinh => $score) {
                $Diem15P_1 = $score['Diem15P_1'] ?? null;
                $Diem15P_2 = $score['Diem15P_2'] ?? null;
                $Diem1Tiet_1 = $score['Diem1Tiet_1'] ?? null;
                $Diem1Tiet_2 = $score['Diem1Tiet_2'] ?? null;
                $DiemCK = $score['DiemCK'] ?? null;

                $invalidScores = [];

                // Kiểm tra từng giá trị điểm, chỉ kiểm tra nếu khác null và không rỗng
                if ($Diem15P_1 !== null && $Diem15P_1 !== '' && (!is_numeric($Diem15P_1) || $Diem15P_1 < 0 || $Diem15P_1 > 10)) {
                    $invalidScores[] = "Điểm 15 phút lần 1: $Diem15P_1";
                }
                if ($Diem15P_2 !== null && $Diem15P_2 !== '' && (!is_numeric($Diem15P_2) || $Diem15P_2 < 0 || $Diem15P_2 > 10)) {
                    $invalidScores[] = "Điểm 15 phút lần 2: $Diem15P_2";
                }
                if ($Diem1Tiet_1 !== null && $Diem1Tiet_1 !== '' && (!is_numeric($Diem1Tiet_1) || $Diem1Tiet_1 < 0 || $Diem1Tiet_1 > 10)) {
                    $invalidScores[] = "Điểm 1 tiết lần 1: $Diem1Tiet_1";
                }
                if ($Diem1Tiet_2 !== null && $Diem1Tiet_2 !== '' && (!is_numeric($Diem1Tiet_2) || $Diem1Tiet_2 < 0 || $Diem1Tiet_2 > 10)) {
                    $invalidScores[] = "Điểm 1 tiết lần 2: $Diem1Tiet_2";
                }
                if ($DiemCK !== null && $DiemCK !== '' && (!is_numeric($DiemCK) || $DiemCK < 0 || $DiemCK > 10)) {
                    $invalidScores[] = "Điểm cuối kỳ: $DiemCK";
                }
                if (!empty($invalidScores)) {
                    $errors[$MaHocSinh] = "Học sinh $MaHocSinh có điểm không hợp lệ! " . implode(', ', $invalidScores);
                    continue;
                }

                // Kiểm tra và cập nhật điểm
                if ($MaHocSinh && $MaGV && $year && $semester) {
                    $DiemModel->insertOrUpdateScore(
                        $MaHocSinh,
                        $MaGV,
                        $MaMH,
                        $Diem15P_1,
                        $Diem15P_2,
                        $Diem1Tiet_1,
                        $Diem1Tiet_2,
                        $DiemCK,
                        $semester,
                        $year
                    );
                }
            }
            if (!empty($errors)) {
                // Ghi lại lỗi và báo cho người dùng
                session()->setFlashdata('errors', $errors);
                return redirect()->back()->with('error', 'Có lỗi xảy ra khi cập nhật điểm. Vui lòng kiểm tra lại.');
            }

            return redirect()->back()->with('success', 'Cập nhật điểm thành công!');
        }
        return redirect()->back()->with('error', 'Không có dữ liệu cập nhật.');
    }




    public function enterStudent()
    {
        return view('teacher/class/enter/student');
    }

    // Teacher - Thanh Header
    public function profile()
    {
        $GiaoVienModel = new GiaoVienModel();
        // Lấy thông tin tài khoản hiện tại
        $MaTK = session('MaTK');

        // Lấy thông tin giáo viên
        $teacherInfo = $GiaoVienModel->getTeacherInfo($MaTK);
        return view('teacher/profile', [
            'teacher' => $teacherInfo
        ]);
    }

    public function updateProfile()
    {
        $errors = [];
        $TaiKhoanModel = new TaiKhoanModel();
        // Lấy dữ liệu từ form
        $MaTK = $this->request->getPost('MaTK');
        $email = $this->request->getPost('teacher_email');
        $phone = $this->request->getPost('teacher_phone');

        // Kiểm tra email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            $errors['teacher_email'] = 'Email không hợp lệ';
        // Kiểm tra số điện thoại
        if (!preg_match('/^\d{10}$/', $phone))
            $errors['director_phone'] = 'Số điện thoại phải có đúng 10 chữ số.';
        // Nếu có lỗi, trả về cùng thông báo
        if (!empty($errors)) {
            return redirect()->back()->withInput()->with('errors', $errors);
        }

        // Cập nhật thông tin tài khoản giáo viên
        $data = [
            'DiaChi' => $this->request->getPost('teacher_address'),
            'SoDienThoai' => $phone,
            'Email' => $email
        ];
        $TaiKhoanModel->updateAccount($MaTK, $data);

        // Xử lý thông báo
        if ($TaiKhoanModel->updateAccount($MaTK, $data)) {
            return redirect()->back()->with('success', 'Cập nhật thông tin thành công.');
        } else {
            return redirect()->back()->with('error', 'Không thể cập nhật. Vui lòng thử lại.');
        }
    }

    public function changepw()
    {
        return view('teacher/changepw');
    }

    public function updatePassword()
    {
        $errors = [];
        // Lấy dữ liệu từ form
        $MaTK = session('MaTK');
        $oldPassword = $this->request->getPost('old_pw');
        $newPassword = $this->request->getPost('new_pw');
        $confirmPassword = $this->request->getPost('confirm_pw');

        // Kiểm tra mật khẩu cũ
        $TaiKhoanModel = new TaiKhoanModel();
        $TaiKhoan = $TaiKhoanModel->find($MaTK);
        if ($TaiKhoan['MatKhau'] !== $oldPassword) {
            $errors['old_pw'] = 'Mật khẩu cũ không chính xác';
        }
        // Kiểm tra mật khẩu mới
        if (strlen($newPassword) < 6) {
            $errors['new_pw'] = 'Mật khẩu mới phải có ít nhất 6 ký tự';
        }
        // Kiểm tra mật khẩu xác nhận
        if ($newPassword !== $confirmPassword) {
            $errors['confirm_pw'] = 'Mật khẩu xác nhận không khớp';
        }
        // Nếu có lỗi, trả về cùng thông báo
        if (!empty($errors)) {
            return redirect()->back()->withInput()->with('errors', $errors);
        }

        // Cập nhật mật khẩu
        $data = [
            'MatKhau' => $newPassword
        ];
        $TaiKhoanModel->updateAccount($MaTK, $data);
        return redirect()->back()->with('success', 'Đổi mật khẩu thành công!');
    }
}
