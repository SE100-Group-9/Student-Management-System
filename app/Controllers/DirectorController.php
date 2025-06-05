<?php

namespace App\Controllers;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
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
use App\Models\ThamSoModel;
use App\Models\HoaDonModel;
use App\Models\HocSinhModelUseManualSingleton;
use App\Models\ViPhamModel;
use App\Models\ThanhToanModel;
use PhpCsFixer\Tokenizer\CT;
use DesignPatterns\Creational\FactoryMethod\StudentFactory;
use System\DesignPatterns\Behavioral\State\StudentStateManager;

require_once APPPATH . '../system/DesignPatterns/Creational/FactoryMethod/FactoryMethod.php';

use function DesignPatterns\Creational\FactoryMethod\getFactoryByRole;
use DesignPatterns\Behavioral\Iterator\StudentCollection;


class DirectorController extends Controller
{

    public function staticsConduct()
    {
        $HanhKiemModel = new HanhKiemModel();
        $PhanCongModel = new PhanCongModel();

        // Nhận giá trị học kỳ, năm học từ query string
        $selectedSemester = $this->request->getVar('semester') ?? 'Học kỳ 1';
        $selectedYear = $this->request->getVar('year') ?? '2024-2025';

        // Tách tên học kỳ để lấy số
        $semesterNumber = preg_replace('/\D/', '', $selectedSemester);

        // Lấy danh sách năm học
        $yearList = $PhanCongModel->getAssignedYears();
        $yearList = array_column($yearList, 'NamHoc');

        // Lấy thông tin hạnh kiểm của học sinh theo học kỳ và năm học
        $HanhKiemKhoi10 = $HanhKiemModel->countConductRank('10', $semesterNumber, $selectedYear);
        $HanhKiemKhoi11 = $HanhKiemModel->countConductRank('11', $semesterNumber, $selectedYear);
        $HanhKiemKhoi12 = $HanhKiemModel->countConductRank('12', $semesterNumber, $selectedYear);

        // Lấy danh sách học sinh có điểm hạnh kiểm thấp nhất
        $worstStudents = $HanhKiemModel->getTopWarnedStudent($semesterNumber, $selectedYear);

        return view('director/statics/conduct', [
            'selectedSemester' => $selectedSemester,
            'selectedYear' => $selectedYear,
            'yearList' => $yearList,
            'HanhKiemKhoi10' => json_encode($HanhKiemKhoi10),
            'HanhKiemKhoi11' => json_encode($HanhKiemKhoi11),
            'HanhKiemKhoi12' => json_encode($HanhKiemKhoi12),
            'worstStudents' => $worstStudents,
        ]);
    }

    public function staticsGrade()
    {
        $DiemModel = new DiemModel();
        $HocSinhModel = new HocSinhModel();
        $PhanCongModel = new PhanCongModel();

        // Nhận giá trị khối lớp, năm học từ query string
        $selectedGrade = $this->request->getVar('grade') ?? 'Khối 10';
        $selectedSemester = $this->request->getVar('semester') ?? 'Học kỳ 1';
        $selectedYear = $this->request->getVar('year') ?? '2024-2025';

        // Tách khối lớp để lấy số
        // Kiểm tra và tách khối lớp để lấy số
        $gradeParts = explode(' ', $selectedGrade);
        if (count($gradeParts) > 1 && is_numeric($gradeParts[1])) {
            $gradeNumber = (int)$gradeParts[1];
        } else {
            // Giá trị mặc định nếu không tách được số
            $gradeNumber = 10; // Ví dụ: Mặc định là Khối 10
        }

        // Lấy danh sách năm học
        $yearList = $PhanCongModel->getAssignedYears();
        $yearList = array_column($yearList, 'NamHoc');

        // Lấy danh sách học sinh theo năm học
        $currentStudentList = $HocSinhModel->getStudentListByYear($gradeNumber, $selectedYear);

        $currentReport = [];
        foreach ($currentStudentList as $student) {
            $MaHS = $student['MaHS'];
            // Tính điểm trung bình theo học kỳ hoặc cả năm học
            if ($selectedSemester === 'Học kỳ 1') {
                $averageScore = $DiemModel->getSemesterAverageScore($MaHS, 1, $selectedYear);
            } elseif ($selectedSemester === 'Học kỳ 2') {
                $averageScore = $DiemModel->getSemesterAverageScore($MaHS, 2, $selectedYear);
            } else {
                $averageScore = $DiemModel->getYearAverageScore($MaHS, $selectedYear);
            }
            $performance  = $DiemModel->getAcademicPerformance($averageScore);
            $currentReport[] = [
                'student' => $student,
                'averageScore' => $averageScore,
                'performance' => $performance,
            ];
        }

        // Xử lý chuỗi năm học để lấy năm liền trước
        $yearArray = explode('-', $selectedYear);
        $previousYear = ($yearArray[0] - 1) . '-' . ($yearArray[1] - 1);

        // Lấy danh sách học sinh theo năm học trước
        $previousStudentList = $HocSinhModel->getStudentListByYear($gradeNumber, $previousYear);

        $previousReport = [];
        foreach ($previousStudentList as $student) {
            $MaHS = $student['MaHS'];
            // Tính điểm trung bình theo học kỳ hoặc cả năm học
            if ($selectedSemester === 'Học kỳ 1') {
                $averageScore = $DiemModel->getSemesterAverageScore($MaHS, 1, $previousYear);
            } elseif ($selectedSemester === 'Học kỳ 2') {
                $averageScore = $DiemModel->getSemesterAverageScore($MaHS, 2, $previousYear);
            } else {
                $averageScore = $DiemModel->getYearAverageScore($MaHS, $previousYear);
            }
            $performance = $DiemModel->getAcademicPerformance($averageScore);
            $previousReport[] = [
                'student' => $student,
                'averageScore' => $averageScore,
                'performance' => $performance,
            ];
        }

        // Tính toán số lượng học sinh theo từng loại học lực trong năm học hiện tại và năm học trước
        $performanceStatistics = $DiemModel->getYearAverageScoreChange($currentReport, $previousReport);

        log_message('info', 'Performance Statistics: ' . print_r($performanceStatistics, true));

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

        $studentScores = [];
        foreach ($currentStudentList as $student) {
            $MaHS = $student['MaHS'];
            // Tính điểm dựa trên học kỳ hoặc cả năm học
            if ($selectedSemester === 'Học kỳ 1') {
                $averageScore  = $DiemModel->getSemesterAverageScore($MaHS, 1, $selectedYear);
            } elseif ($selectedSemester === 'Học kỳ 2') {
                $averageScore  = $DiemModel->getSemesterAverageScore($MaHS, 2, $selectedYear);
            } else {
                $averageScore  = $DiemModel->getYearAverageScore($MaHS, $selectedYear);
            }
            if ($averageScore !== null) {
                $studentScores[] = [
                    'MaHS' => $student['MaHS'],
                    'HoTen' => $student['HoTen'],
                    'TenLop' => $student['TenLop'],
                    'DiemTB' => $averageScore,
                ];
            }
        }
        // Sắp xếp học sinh theo điểm trung bình năm học giảm dần
        usort($studentScores, function ($a, $b) {
            return $b['DiemTB'] <=> $a['DiemTB'];
        });

        // Lấy danh sách 10 học sinh có điểm trung bình năm học cao nhất
        $topStudents = array_slice($studentScores, 0, 10);

        return view('director/statics/grade', [
            'selectedGrade' => $selectedGrade,
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
            'topStudents' => $topStudents,
        ]);
    }

    public function staticsStudent()
    {
        $PhanCongModel = new PhanCongModel();
        $HocSinhLopModel = new HocSinhLopModel();
        $HanhKiemModel = new HanhKiemModel();

        // Nhận giá trị năm học từ query string
        $selectedYear = $this->request->getVar('year') ?? '2024-2025';

        // Lấy danh sách năm học
        $yearList = $PhanCongModel->getAssignedYears();
        $yearList = array_column($yearList, 'NamHoc');

        // Lấy số lượng học sinh nhập học lần đầu trong năm học được chọn
        $currentEnrolledCount = $HocSinhLopModel->countEnrolledStudent($selectedYear);

        // Lấy số lượng tổng học sinh trong năm học được chọn
        $currentTotalCount = $HocSinhLopModel->countTotalStudent($selectedYear);

        // Lấy số lượng học sinh bị cảnh báo trong năm học được chọn
        $currentWarnedCount = $HanhKiemModel->countWarnedStudent($selectedYear);

        // Xử lý chuỗi năm học để lấy năm liền trước
        $yearArray = explode('-', $selectedYear);
        $previousYear = ($yearArray[0] - 1) . '-' . ($yearArray[1] - 1);

        // Tính toán phần trăm sự thay đổi (tăng/giảm) số lượng học sinh nhập học lần đầu so với năm trước
        $enrolledChange = $HocSinhLopModel->countEnrolledStudentChange($selectedYear, $previousYear);

        // Tính toán phần trăm sự thay đổi (tăng/giảm) số lượng học sinh so với năm trước
        $totalChange = $HocSinhLopModel->countTotalStudentChange($selectedYear, $previousYear);

        // Tính toán phần trăm sự thay đổi (tăng/giảm) số lượng học sinh cảnh báo so với năm trước
        $warnedChange = $HanhKiemModel->countWarnedStudentChange($selectedYear, $previousYear);

        // Lấy dữ liệu trả về biểu đồ
        $enrolledStudentData = $HocSinhLopModel->getEnrolledStudentData($selectedYear);
        $warnedStudentData = $HanhKiemModel->getWarnedStudentData($selectedYear);

        log_message('info', 'Enrolled Student Data: ' . print_r($enrolledStudentData, true));
        log_message('info', 'Warned Student Data: ' . print_r($warnedStudentData, true));
        return view('director/statics/student', [
            'selectedYear' => $selectedYear,
            'previousYear' => $previousYear,
            'yearList' => $yearList,
            'currentEnrolledCount' => $currentEnrolledCount,
            'currentTotalCount' => $currentTotalCount,
            'currentWarnedCount' => $currentWarnedCount,
            'enrolledChange' => $enrolledChange,
            'totalChange' => $totalChange,
            'warnedChange' => $warnedChange,
            'enrolledStudentData' => json_encode($enrolledStudentData),  // Ensure it's encoded
            'warnedStudentData' => json_encode($warnedStudentData),  // Ensure it's encoded
        ]);
    }

    public function exportStudentList() {}

    public function studentAdd()
    {
        $HocSinhModel = new HocSinhModel();
        // Lấy mã học sinh lớn nhất hiện tại
        $lastStudent = $HocSinhModel->select('MaHS')->orderBy('MaHS', 'DESC')->first();

        // Sinh mã học sinh mới
        $newMaHS = 'HS0001'; // Giá trị mặc định nếu chưa có mã nào
        if ($lastStudent && preg_match('/^HS(\d+)$/', $lastStudent['MaHS'], $matches)) {
            $newIndex = (int)$matches[1] + 1;
            $newMaHS = 'HS' . str_pad($newIndex, 4, '0', STR_PAD_LEFT);
        }
        return view('director/student/add', ['newMaHS' => $newMaHS]);
    }

    // public function addStudent()
    // {
    //     $errors = [];
    //     // Lấy dữ liệu từ form
    //     $birthday = $this->request->getPost('student_birthday');
    //     $email = $this->request->getPost('student_email');
    //     $password = $this->request->getPost('student_password');
    //     $phone = $this->request->getPost('student_phone');
    //     $gender = $this->request->getPost('student_gender');
    //     //Kiểm tra giới tính
    //     if (empty($gender))
    //         $errors['student_gender'] = 'Vui lòng chọn giới tính.';

    //     // Kiểm tra ngày sinh
    //     if (strtotime($birthday) > strtotime(date('Y-m-d')))
    //         $errors['student_birthday'] = 'Ngày sinh không hợp lệ.';

    //     if (empty($birthday))
    //         $errors['student_birthday'] = 'Vui lòng nhập ngày sinh.';

    //     // Kiểm tra email
    //     if (!filter_var($email, FILTER_VALIDATE_EMAIL))
    //         $errors['student_email'] = 'Email không đúng định dạng.';

    //     // Kiểm tra mật khẩu
    //     if (strlen($password) < 6)
    //         $errors['student_password'] = 'Mật khẩu phải có ít nhất 6 ký tự.';

    //     // Kiểm tra số điện thoại
    //     if (!preg_match('/^\d{10}$/', $phone))
    //         $errors['student_phone'] = 'Số điện thoại phải có đúng 10 chữ số.';

    //     // Nếu có lỗi, trả về cùng thông báo
    //     if (!empty($errors)) {
    //         return redirect()->back()->withInput()->with('errors', $errors);
    //     }

    //     $TaiKhoanModel = new TaiKhoanModel();
    //     $HocSinhModel = new HocSinhModel();
    //     $HocSinhLopModel = new HocSinhLopModel();

    //     $MaTK = $TaiKhoanModel->insert([
    //         'TenTK' => $this->request->getPost('student_account'),
    //         'MatKhau' => $this->request->getPost('student_password'),
    //         'HoTen' => $this->request->getPost('student_name'),
    //         'Email' => $this->request->getPost('student_email'),
    //         'SoDienThoai' => $this->request->getPost('student_phone'),
    //         'DiaChi' => $this->request->getPost('student_address'),
    //         'GioiTinh' => $this->request->getPost('student_gender'),
    //         'NgaySinh' => $this->request->getPost('student_birthday'),
    //         'MaVT' => 3, // Mã vai trò học sinh
    //     ]);
    //     // Lưu thông tin học sinh
    //     $MaHS = $HocSinhModel->insert([
    //         'MaTK' => $MaTK,
    //         'DanToc' => $this->request->getPost('student_nation'),
    //         'NoiSinh' => $this->request->getPost('student_country'),
    //         'TinhTrang' => $this->request->getPost('student_status') ?? 'Mới tiếp nhận',
    //     ]);

    //     return redirect()->to('director/student/list')->with('success', 'Thêm học sinh mới thành công!');
    // }

    public function addStudent()
    {
        log_message('info', 'Tài khoản mới được tạo: ');
        $info = [
            'account' => $this->request->getPost('student_account'),
            'password' => $this->request->getPost('student_password'),
            'name' => $this->request->getPost('student_name'),
            'email' => $this->request->getPost('student_email'),
            'phone' => $this->request->getPost('student_phone'),
            'address' => $this->request->getPost('student_address'),
            'gender' => $this->request->getPost('student_gender'),
            'birthday' => $this->request->getPost('student_birthday'),
            'nation' => $this->request->getPost('student_nation'),
            'country' => $this->request->getPost('student_country'),
            'status' => 'Mới tiếp nhận'
        ];

        // Gọi hàm validate nội bộ
        $errors = $this->validateStudent($info);

        if (!empty($errors)) {
            return redirect()->back()->withInput()->with('errors', $errors);
        }

        // Factory method tạo học sinh
        $factory = getFactoryByRole('học sinh', $info);
        if (!$factory) {
            return redirect()->back()->with('error', 'Không xác định được vai trò người dùng.');
        }

        $student = $factory->createUser();
        if (!$student->createAndSave()) {
            return redirect()->back()->with('error', 'Tạo tài khoản thất bại.');
        }

        log_message('info', 'Tài khoản mới được tạo: ' . $student->getInfo() . ' - Vai trò: ' . $student->getRole());

        return redirect()->to('/director/student/list')->with('success', 'Tạo tài khoản học sinh thành công.');
    }

    private function validateStudent(array $data): array
    {
        $errors = [];

        if (empty($data['account'])) {
            $errors['account'] = 'Tài khoản không được để trống.';
        }

        if (empty($data['password']) || strlen($data['password']) < 6) {
            $errors['password'] = 'Mật khẩu phải có ít nhất 6 ký tự.';
        }

        if (empty($data['name'])) {
            $errors['name'] = 'Họ tên không được để trống.';
        }

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Email không hợp lệ.';
        }

        if (!preg_match('/^[0-9]{10,11}$/', $data['phone'])) {
            $errors['phone'] = 'Số điện thoại không hợp lệ.';
        }

        if (empty($data['gender'])) {
            $errors['gender'] = 'Vui lòng chọn giới tính.';
        }

        if (empty($data['birthday'])) {
            $errors['birthday'] = 'Ngày sinh không được để trống.';
        }

        // Tuỳ chọn: kiểm tra quốc gia, dân tộc
        if (empty($data['nation'])) {
            $errors['nation'] = 'Vui lòng nhập dân tộc.';
        }

        if (empty($data['country'])) {
            $errors['country'] = 'Vui lòng nhập quốc tịch.';
        }

        return $errors;
    }

    public function studentUpdate($id = null)
    {
        if ($id === null) {
            return redirect()->to('director/student/list');
        }

        $TaiKhoanModel = new TaiKhoanModel();
        $HocSinhModel = new HocSinhModel();
        $HocSinhLopModel = new HocSinhLopModel();
        $LopModel = new LopModel();

        // Lấy thông tin học sinh + tài khoản + lớp
        $student = $HocSinhModel
            ->select('hocsinh.*, taikhoan.*, hocsinh_lop.*, lop.TenLop')
            ->join('taikhoan', 'taikhoan.MaTK = hocsinh.MaTK')
            ->join('hocsinh_lop', 'hocsinh.MaHS = hocsinh_lop.MaHS', 'left')
            ->join('lop', 'lop.MaLop = hocsinh_lop.MaLop', 'left')
            ->where('hocsinh.MaHS', $id)
            ->first();

        if (!$student) {
            return redirect()->to('director/student/list');
        }

        // ✅ Xử lý trạng thái hiện tại
        $currentStatus = trim($student['TinhTrang'] ?? '');
        $stateManager = new StudentStateManager($currentStatus);
        $nextStates = $stateManager->getNextStates();

        // ✅ Đảm bảo trạng thái hiện tại luôn nằm trong dropdown
        if (!in_array($currentStatus, $nextStates)) {
            array_unshift($nextStates, $currentStatus);
        }

        $availableStatuses = array_unique($nextStates); // loại trùng nếu có

        return view('director/student/update', [
            'student' => $student,
            'availableStatuses' => $availableStatuses, // 👈 Gửi xuống view để tạo dropdown
        ]);
    }



    public function updateStudent()
    {
        $errors = [];

        // Lấy dữ liệu từ form
        $MaHS = $this->request->getPost('MaHS');
        $MaTK = $this->request->getPost('MaTK');
        $birthday = $this->request->getPost('student_birthday');
        $email = $this->request->getPost('student_email');
        $password = $this->request->getPost('student_password');
        $phone = $this->request->getPost('student_phone');
        $gender = $this->request->getPost('student_gender');
        $status = trim($this->request->getPost('student_status'));


        // Debug nhanh:
        log_message('debug', '🔍 Trạng thái gửi lên: [' . $status . ']');



        // Validate giới tính
        if (empty($gender)) {
            $errors['student_gender'] = 'Vui lòng chọn giới tính.';
        }

        // Validate ngày sinh
        if (empty($birthday)) {
            $errors['student_birthday'] = 'Vui lòng nhập ngày sinh.';
        } elseif (strtotime($birthday) > strtotime(date('Y-m-d'))) {
            $errors['student_birthday'] = 'Ngày sinh không hợp lệ.';
        }

        // Validate email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['student_email'] = 'Email không đúng định dạng.';
        }

        // Validate mật khẩu
        if (strlen($password) < 6) {
            $errors['student_password'] = 'Mật khẩu phải có ít nhất 6 ký tự.';
        }

        // Validate số điện thoại
        if (!preg_match('/^\d{10}$/', $phone)) {
            $errors['student_phone'] = 'Số điện thoại phải có đúng 10 chữ số.';
        }

        // ✅ Validate trạng thái sử dụng State Pattern
        try {
            $stateManager = new \System\DesignPatterns\Behavioral\State\StudentStateManager($status);
        } catch (\Exception $e) {
            $errors['student_status'] = 'Trạng thái học sinh không hợp lệ.';
        }

        // Nếu có lỗi, quay lại form
        if (!empty($errors)) {
            return redirect()->back()->withInput()->with('errors', $errors);
        }

        // Cập nhật DB
        $TaiKhoanModel = new TaiKhoanModel();
        $HocSinhModel = new HocSinhModel();

        $TaiKhoanModel->update($MaTK, [
            'TenTK' => $this->request->getPost('student_account'),
            'MatKhau' => $password,
            'HoTen' => $this->request->getPost('student_name'),
            'Email' => $email,
            'SoDienThoai' => $phone,
            'DiaChi' => $this->request->getPost('student_address'),
            'GioiTinh' => $gender,
            'NgaySinh' => $birthday,
        ]);

        if (!empty($status)) {
            $result = $HocSinhModel->update($MaHS, [
                'DanToc' => $this->request->getPost('student_nation'),
                'NoiSinh' => $this->request->getPost('student_country'),
                'TinhTrang' => $status,
            ]);
            log_message('info', 'Update result: ' . var_export($result, true));
        } else {
            log_message('error', '❌ Không cập nhật được TinhTrang vì giá trị rỗng!');
        }
        // $HocSinhModel->update($MaHS, [
        //     'DanToc' => $this->request->getPost('student_nation'),
        //     'NoiSinh' => $this->request->getPost('student_country'),
        //     'TinhTrang' => $status,
        // ]);

        log_message('info', 'Received Data: ' . json_encode($this->request->getPost()));

        if ($TaiKhoanModel && $HocSinhModel) {
            return redirect()->to('director/student/list')->with('success', 'Cập nhật thông tin học sinh thành công!');
        } else {
            return redirect()->back()->with('error', 'Không thể cập nhật. Vui lòng thử lại.');
        }
    }



    public function studentList()
    {
        $TaiKhoanModel = new TaiKhoanModel();
        $HocSinhModel = new HocSinhModel();
        $HocSinhLopModel = new HocSinhLopModel();
        $LopModel = new LopModel();

        // Nhận giá trị năm học, lớp học, từ khóa tìm kiếm và tình trạng từ query string
        $selectedYear = $this->request->getVar('year');
        $selectedClass = $this->request->getVar('class');
        $searchStudent = $this->request->getVar('search') ?? '';
        $selectedStatus = $this->request->getVar('status');

        // Lấy danh sách các năm học, lớp học và tình trạng
        $classList = $LopModel->findColumn('TenLop');
        $classList = array_merge(['Chọn lớp học'], $classList); // Thêm "Chọn lớp" vào danh sách lớp

        $yearListArray = $HocSinhLopModel
            ->distinct()
            ->select('NamHoc')
            ->orderBy('NamHoc', 'DESC')
            ->findAll();
        // Lấy các giá trị của trường 'NamHoc' từ mảng $yearListArray
        $yearList = array_map(function ($year) {
            return $year['NamHoc']; // Lấy giá trị NamHoc
        }, $yearListArray);
        $yearList = array_merge(['Chọn năm học'], $yearList);
        $statusList = ['Chọn trạng thái', 'Đang học', 'Mới tiếp nhận', 'Nghỉ học'];

        $query = $HocSinhModel
            ->select('hocsinh.MaHS AS MaHocSinh, hocsinh.*, taikhoan.*, hocsinh_lop.*, lop.TenLop')
            ->join('taikhoan', 'taikhoan.MaTK = hocsinh.MaTK')
            ->join('hocsinh_lop', 'hocsinh.MaHS = hocsinh_lop.MaHS', 'left')
            ->join('lop', 'lop.MaLop = hocsinh_lop.MaLop', 'left');

        // Lọc theo năm học, lớp và từ khóa tìm kiếm và tình trạng (nếu có)
        if ($selectedYear && $selectedYear !== 'Chọn năm học') {
            $query->where('hocsinh_lop.NamHoc', $selectedYear);
        }
        if ($selectedClass && $selectedClass !== 'Chọn lớp học') {
            $query->where('lop.TenLop', $selectedClass);
        }
        if ($searchStudent) {
            $query->groupStart() // Tạo nhóm điều kiện tìm kiếm
                ->like('hocsinh.MaHS', $searchStudent)
                ->orLike('taikhoan.HoTen', $searchStudent)
                ->groupEnd();
        }
        if ($selectedStatus && $selectedStatus !== 'Chọn trạng thái') {
            $query->where('hocsinh.TinhTrang', $selectedStatus);
        }

        // Thêm sắp xếp theo năm học (NamHoc)
        $query->orderBy('hocsinh_lop.NamHoc', 'DESC');
        $query->orderBy('lop.TenLop', 'ASC');

        $studentList  = $query->findAll();

        return view('director/student/list', [
            'studentlist' => $studentList,
            'yearList' => $yearList,
            'classList' => $classList,
            'statusList' => $statusList,
            'selectedYear' => $selectedYear,
            'selectedClass' => $selectedClass,
            'selectedStatus' => $selectedStatus,
            'searchTerm' => $searchStudent,
        ]);
    }

    public function deleteStudent($MaHS)
    {
        $db = \Config\Database::connect();
        $HocSinhModel = new HocSinhModel();
        $TaiKhoanModel = new TaiKhoanModel();

        log_message('info', 'Deleting student with ID ' . $MaHS);
        // Bắt đầu transaction
        $db->transStart();

        try {
            // Kiểm tra học sinh có tồn tại không
            $HocSinh = $HocSinhModel->find($MaHS);
            if (!$HocSinh) {
                return redirect()->back()->with('error', 'Không tìm thấy thông tin học sinh.');
            }

            // Xóa học sinh khỏi bảng HOCSINH
            if (!$HocSinhModel->delete($MaHS)) {
                throw new \Exception('Xóa học sinh thất bại.');
            }

            // Xóa tài khoản liên kết với học sinh
            if (!$TaiKhoanModel->delete($HocSinh['MaTK'])) {
                throw new \Exception('Xóa tài khoản học sinh thất bại.');
            }

            // Hoàn tất transaction
            $db->transComplete();

            // Kiểm tra trạng thái transaction
            if ($db->transStatus() === false) {
                throw new \Exception('Có lỗi xảy ra khi thực hiện xóa học sinh.');
            }

            return redirect()->back()->with('success', 'Xóa học sinh thành công!');
        } catch (\Exception $e) {
            // Nếu có lỗi, rollback transaction
            $db->transRollback();

            // Hiển thị thông báo lỗi
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function studentPayment()
    {
        $LopModel = new LopModel();
        $HoaDonModel = new HoaDonModel();
        $HocSinhLopModel = new HocSinhLopModel();

        // Lấy danh sách năm học
        $yearList = $HocSinhLopModel->getYearList();
        // Lấy danh sách tên lớp học
        $classList = $LopModel->findColumn('TenLop');

        // Nhận giá trị năm học và lớp học từ query string
        $selectedYear = $this->request->getVar('year') ?? $yearList[0];
        $selectedClass = $this->request->getVar('class') ?? $classList[0];

        // Lấy MaLop từ tên lớp học
        $MaLop = $LopModel->where('TenLop', $selectedClass)->first()['MaLop'];

        // Lấy thông tin học phí của học sinh
        $tuitionList = $HoaDonModel->getInvoiceInfo($MaLop, $selectedYear);


        return view('director/student/payment', [
            'tuitionList' => $tuitionList,
            'yearList' => $yearList,
            'classList' => $classList,
            'selectedYear' => $selectedYear,
            'selectedClass' => $selectedClass,
        ]);
    }

    public function studentPerserved()
    {
        return view('director/student/perserved');
    }

    // public function studentRecord()
    // {
    //     $HocSinhModel = new HocSinhModel();
    //     $LopModel = new LopModel();
    //     $DiemModel = new DiemModel();
    //     $PhanCongModel = new PhanCongModel();
    //     $HocSinhLopModel = new HocSinhLopModel();
    //     $HanhKiemModel = new HanhKiemModel();

    //     // Lấy danh sách năm học lớp học
    //     $yearList = $HocSinhLopModel->getYearList();
    //     $classList = $LopModel->findColumn('TenLop');

    //     // Nhận giá trị năm học, học kỳ và lớp học từ query string
    //     $selectedYear = $this->request->getVar('year') ?? $yearList[0];
    //     //Nhận giá trị học kỳ sau khi chuyển từ text sang số
    //     $selectedSemesterText = $this->request->getVar('semester') ?? 'Học kỳ 1';
    //     $selectedSemester = null;
    //     if ($selectedSemesterText === 'Học kỳ 1') {
    //         $selectedSemester = 1;
    //     } elseif ($selectedSemesterText === 'Học kỳ 2') {
    //         $selectedSemester = 2;
    //     } else {
    //         $selectedSemester = 0;
    //     }
    //     $selectedClass = $this->request->getVar('class') ?? $classList[0];

    //     // Nếu chọn Học kỳ 1
    //     if ($selectedSemester === 1) {
    //         $studentList = $HocSinhModel->getStudentList($selectedYear, 1, $selectedClass);

    //         $student = [];

    //         foreach ($studentList as $student) {
    //             $MaHS = $student['MaHS'];

    //             // Khởi tạo dữ liệu học sinh nếu chưa có
    //             if (!isset($students[$MaHS])) {
    //                 $students[$MaHS] = [
    //                     'MaHS' => $MaHS,
    //                     'HoTen' => $student['HoTen'],
    //                     'TenLop' => $student['TenLop'],
    //                     'Diem' => [],
    //                     'DiemHK' => $student['DiemHK']
    //                 ];
    //             }

    //             // Lưu điểm của từng môn học
    //             if ($student['MaMH']) {
    //                 $students[$MaHS]['Diem'][$student['MaMH']] = [
    //                     'Diem15P_1' => $student['Diem15P_1'],
    //                     'Diem15P_2' => $student['Diem15P_2'],
    //                     'Diem1Tiet_1' => $student['Diem1Tiet_1'],
    //                     'Diem1Tiet_2' => $student['Diem1Tiet_2'],
    //                     'DiemCK' => $student['DiemCK'],
    //                 ];
    //             }
    //         }

    //         // Tính toán điểm trung bình từng môn, điểm trung bình học kỳ và học lực, danh hiệu
    //         foreach ($students as &$student) {
    //             $DiemTrungBinh = null;
    //             $TongDiemTB = 0;
    //             $SoMon = count($PhanCongModel->getSubjectList($selectedYear, $selectedSemester, $selectedClass)); // Số môn học trong học kỳ
    //             $SoMonDuCotDiem = 0; // Số môn học có điểm

    //             foreach ($student['Diem'] as $MaMH => $Diem) {
    //                 $DiemTBMonHoc = $DiemModel->getAverageScore($Diem);

    //                 // Lưu điểm trung bình môn học vào mảng
    //                 $student['Diem'][$MaMH]['DiemTBMonHoc'] = $DiemTBMonHoc;

    //                 if ($DiemTBMonHoc !== null) {
    //                     $TongDiemTB += $DiemTBMonHoc;
    //                     $SoMonDuCotDiem++;
    //                 }
    //             }
    //             // Tính điểm trung bình học kỳ nếu có đủ cột điểm của tất cả môn
    //             if ($SoMonDuCotDiem === $SoMon && $SoMon > 0) {
    //                 $DiemTrungBinh = round($TongDiemTB / $SoMon, 1);
    //             }
    //             $student['DiemTrungBinh'] = $DiemTrungBinh;

    //             // Xếp loại học lực
    //             $student['HocLuc'] = $DiemModel->getAcademicPerformance($DiemTrungBinh);

    //             // Xếp loại danh hiệu
    //             $DanhHieuModel = new DanhHieuModel();
    //             $DanhHieu = $DanhHieuModel->getAcademicTitle($DiemTrungBinh, $student['DiemHK']);
    //             $student['DanhHieu'] = $DanhHieu ? $DanhHieu['TenDH'] : null;
    //         }
    //     }

    //     // Nếu chọn Học kỳ 2
    //     if ($selectedSemester === 2) {
    //         $studentList = $HocSinhModel->getStudentList($selectedYear, 2, $selectedClass);

    //         $student = [];

    //         foreach ($studentList as $student) {
    //             $MaHS = $student['MaHS'];

    //             // Khởi tạo dữ liệu học sinh nếu chưa có
    //             if (!isset($students[$MaHS])) {
    //                 $students[$MaHS] = [
    //                     'MaHS' => $MaHS,
    //                     'HoTen' => $student['HoTen'],
    //                     'TenLop' => $student['TenLop'],
    //                     'Diem' => [],
    //                     'DiemHK' => $student['DiemHK']
    //                 ];
    //             }

    //             // Lưu điểm của từng môn học
    //             if ($student['MaMH']) {
    //                 $students[$MaHS]['Diem'][$student['MaMH']] = [
    //                     'Diem15P_1' => $student['Diem15P_1'],
    //                     'Diem15P_2' => $student['Diem15P_2'],
    //                     'Diem1Tiet_1' => $student['Diem1Tiet_1'],
    //                     'Diem1Tiet_2' => $student['Diem1Tiet_2'],
    //                     'DiemCK' => $student['DiemCK'],
    //                 ];
    //             }
    //         }

    //         // Tính toán điểm trung bình từng môn, điểm trung bình học kỳ và học lực, danh hiệu
    //         foreach ($students as &$student) {
    //             $DiemTrungBinh = null;
    //             $TongDiemTB = 0;
    //             $SoMon = count($PhanCongModel->getSubjectList($selectedYear, $selectedSemester, $selectedClass)); // Số môn học trong học kỳ
    //             $SoMonDuCotDiem = 0; // Số môn học có điểm

    //             foreach ($student['Diem'] as $MaMH => $Diem) {
    //                 $DiemTBMonHoc = $DiemModel->getAverageScore($Diem);

    //                 // Lưu điểm trung bình môn học vào mảng
    //                 $student['Diem'][$MaMH]['DiemTBMonHoc'] = $DiemTBMonHoc;

    //                 if ($DiemTBMonHoc !== null) {
    //                     $TongDiemTB += $DiemTBMonHoc;
    //                     $SoMonDuCotDiem++;
    //                 }
    //             }
    //             // Tính điểm trung bình học kỳ nếu có đủ cột điểm của tất cả môn
    //             if ($SoMonDuCotDiem === $SoMon && $SoMon > 0) {
    //                 $DiemTrungBinh = round($TongDiemTB / $SoMon, 1);
    //             }
    //             $student['DiemTrungBinh'] = $DiemTrungBinh;

    //             // Xếp loại học lực
    //             $student['HocLuc'] = $DiemModel->getAcademicPerformance($DiemTrungBinh);

    //             // Xếp loại danh hiệu
    //             $DanhHieuModel = new DanhHieuModel();
    //             $DanhHieu = $DanhHieuModel->getAcademicTitle($DiemTrungBinh, $student['DiemHK']);
    //             $student['DanhHieu'] = $DanhHieu ? $DanhHieu['TenDH'] : null;
    //         }
    //     }


    //     // Trường hợp "Cả năm"
    //     if ($selectedSemester === 0) {
    //         $studentList1 = $HocSinhModel->getStudentList($selectedYear, 1, $selectedClass); // Học kỳ 1
    //         $studentList2 = $HocSinhModel->getStudentList($selectedYear, 2, $selectedClass); // Học kỳ 2

    //         foreach ([$studentList1, $studentList2] as $key => $studentList) {
    //             foreach ($studentList as $student) {
    //                 $MaHS = $student['MaHS'];

    //                 // Khởi tạo dữ liệu học sinh nếu chưa có
    //                 if (!isset($students[$MaHS])) {
    //                     $students[$MaHS] = [
    //                         'MaHS' => $MaHS,
    //                         'HoTen' => $student['HoTen'],
    //                         'TenLop' => $student['TenLop'],
    //                         'Diem' => [],
    //                         'DiemHK' => ['HocKy1' => null, 'HocKy2' => null],
    //                     ];
    //                 }

    //                 // Lưu điểm hạnh kiểm
    //                 $students[$MaHS]['DiemHK']['HocKy' . ($key + 1)] = $student['DiemHK'];

    //                 // Lưu điểm của từng môn học
    //                 if ($student['MaMH']) {
    //                     $students[$MaHS]['Diem'][$student['MaMH']]['HocKy' . ($key + 1)] = [
    //                         'Diem15P_1' => $student['Diem15P_1'],
    //                         'Diem15P_2' => $student['Diem15P_2'],
    //                         'Diem1Tiet_1' => $student['Diem1Tiet_1'],
    //                         'Diem1Tiet_2' => $student['Diem1Tiet_2'],
    //                         'DiemCK' => $student['DiemCK'],
    //                     ];
    //                 }
    //             }
    //         }

    //         // Tính toán điểm trung bình cả năm
    //         foreach ($students as &$student) {
    //             $TongDiemTB = 0;
    //             $SoMon = count($PhanCongModel->getSubjectList($selectedYear, 1, $selectedClass)); // Số môn học
    //             $SoMonDuCotDiem = 0;

    //             foreach ($student['Diem'] as $MaMH => $DiemHocKy) {
    //                 $DiemTBHocKy1 = isset($DiemHocKy['HocKy1']) ? $DiemModel->getAverageScore($DiemHocKy['HocKy1']) : null;
    //                 $DiemTBHocKy2 = isset($DiemHocKy['HocKy2']) ? $DiemModel->getAverageScore($DiemHocKy['HocKy2']) : null;

    //                 $DiemTBCaNam = null;
    //                 if ($DiemTBHocKy1 !== null && $DiemTBHocKy2 !== null) {
    //                     $DiemTBCaNam = round(($DiemTBHocKy1 + 2 * $DiemTBHocKy2) / 3, 1);
    //                 }

    //                 $student['Diem'][$MaMH]['DiemTBMonHoc'] = $DiemTBCaNam;

    //                 if ($DiemTBCaNam !== null) {
    //                     $TongDiemTB += $DiemTBCaNam;
    //                     $SoMonDuCotDiem++;
    //                 }
    //             }

    //             $DiemTrungBinhCaNam = null;
    //             if ($SoMonDuCotDiem === $SoMon && $SoMon > 0) {
    //                 $DiemTrungBinhCaNam = round($TongDiemTB / $SoMon, 1);
    //             }

    //             $student['DiemTrungBinh'] = $DiemTrungBinhCaNam;

    //             // Xếp loại học lực
    //             $student['HocLuc'] = $DiemModel->getAcademicPerformance($DiemTrungBinhCaNam);

    //             // Xếp loại danh hiệu
    //             $DanhHieuModel = new DanhHieuModel();
    //             $DiemHKCaNam = round(($student['DiemHK']['HocKy1'] + $student['DiemHK']['HocKy2']) / 2, 1);
    //             $student['DiemHK'] = $DiemHKCaNam;
    //             $DanhHieu = $DanhHieuModel->getAcademicTitle($DiemTrungBinhCaNam, $DiemHKCaNam);
    //             $student['DanhHieu'] = $DanhHieu ? $DanhHieu['TenDH'] : null;
    //         }
    //     }

    //     // Lấy danh sách học sinh theo năm học, học kỳ và lớp học
    //     $studentList = $HocSinhModel->getStudentList($selectedYear, $selectedSemester, $selectedClass);



    //     log_message('info', 'Student List: ' . print_r($students, true));

    //     return view('director/student/record', [
    //         'studentList' => $students,
    //         'yearList' => $yearList,
    //         'classList' => $classList,
    //         'selectedYear' => $selectedYear,
    //         'selectedSemesterText' => $selectedSemesterText,
    //         'selectedClass' => $selectedClass,
    //     ]);
    // }


    public function studentRecord()
    {
        // Thay thế bằng lớp học sinh sử dụng Singleton thủ công
        $HocSinhModel = new HocSinhModelUseManualSingleton();
        $LopModel = new LopModel();
        $DiemModel = new DiemModel();
        $PhanCongModel = new PhanCongModel();
        $HocSinhLopModel = new HocSinhLopModel();
        $HanhKiemModel = new HanhKiemModel();

        // Lấy danh sách năm học lớp học
        $yearList = $HocSinhLopModel->getYearList();
        $classList = $LopModel->findColumn('TenLop');

        // Nhận giá trị năm học, học kỳ và lớp học từ query string
        $selectedYear = $this->request->getVar('year') ?? $yearList[0];
        //Nhận giá trị học kỳ sau khi chuyển từ text sang số
        $selectedSemesterText = $this->request->getVar('semester') ?? 'Học kỳ 1';
        $selectedSemester = null;
        if ($selectedSemesterText === 'Học kỳ 1') {
            $selectedSemester = 1;
        } elseif ($selectedSemesterText === 'Học kỳ 2') {
            $selectedSemester = 2;
        } else {
            $selectedSemester = 0;
        }
        $selectedClass = $this->request->getVar('class') ?? $classList[0];

        // Nếu chọn Học kỳ 1
        if ($selectedSemester === 1) {
            $studentList = $HocSinhModel->getStudentList($selectedYear, 1, $selectedClass);

            $student = [];

            foreach ($studentList as $student) {
                $MaHS = $student['MaHS'];

                // Khởi tạo dữ liệu học sinh nếu chưa có
                if (!isset($students[$MaHS])) {
                    $students[$MaHS] = [
                        'MaHS' => $MaHS,
                        'HoTen' => $student['HoTen'],
                        'TenLop' => $student['TenLop'],
                        'Diem' => [],
                        'DiemHK' => $student['DiemHK']
                    ];
                }

                // Lưu điểm của từng môn học
                if ($student['MaMH']) {
                    $students[$MaHS]['Diem'][$student['MaMH']] = [
                        'Diem15P_1' => $student['Diem15P_1'],
                        'Diem15P_2' => $student['Diem15P_2'],
                        'Diem1Tiet_1' => $student['Diem1Tiet_1'],
                        'Diem1Tiet_2' => $student['Diem1Tiet_2'],
                        'DiemCK' => $student['DiemCK'],
                    ];
                }
            }

            // Tính toán điểm trung bình từng môn, điểm trung bình học kỳ và học lực, danh hiệu
            foreach ($students as &$student) {
                $DiemTrungBinh = null;
                $TongDiemTB = 0;
                $SoMon = count($PhanCongModel->getSubjectList($selectedYear, $selectedSemester, $selectedClass)); // Số môn học trong học kỳ
                $SoMonDuCotDiem = 0; // Số môn học có điểm

                foreach ($student['Diem'] as $MaMH => $Diem) {
                    $DiemTBMonHoc = $DiemModel->getAverageScore($Diem);

                    // Lưu điểm trung bình môn học vào mảng
                    $student['Diem'][$MaMH]['DiemTBMonHoc'] = $DiemTBMonHoc;

                    if ($DiemTBMonHoc !== null) {
                        $TongDiemTB += $DiemTBMonHoc;
                        $SoMonDuCotDiem++;
                    }
                }
                // Tính điểm trung bình học kỳ nếu có đủ cột điểm của tất cả môn
                if ($SoMonDuCotDiem === $SoMon && $SoMon > 0) {
                    $DiemTrungBinh = round($TongDiemTB / $SoMon, 1);
                }
                $student['DiemTrungBinh'] = $DiemTrungBinh;

                // Xếp loại học lực
                $student['HocLuc'] = $DiemModel->getAcademicPerformance($DiemTrungBinh);

                // Xếp loại danh hiệu
                $DanhHieuModel = new DanhHieuModel();
                $DanhHieu = $DanhHieuModel->getAcademicTitle($DiemTrungBinh, $student['DiemHK']);
                $student['DanhHieu'] = $DanhHieu ? $DanhHieu['TenDH'] : null;
            }
        }

        // Nếu chọn Học kỳ 2
        if ($selectedSemester === 2) {
            $studentList = $HocSinhModel->getStudentList($selectedYear, 2, $selectedClass);

            $student = [];

            foreach ($studentList as $student) {
                $MaHS = $student['MaHS'];

                // Khởi tạo dữ liệu học sinh nếu chưa có
                if (!isset($students[$MaHS])) {
                    $students[$MaHS] = [
                        'MaHS' => $MaHS,
                        'HoTen' => $student['HoTen'],
                        'TenLop' => $student['TenLop'],
                        'Diem' => [],
                        'DiemHK' => $student['DiemHK']
                    ];
                }

                // Lưu điểm của từng môn học
                if ($student['MaMH']) {
                    $students[$MaHS]['Diem'][$student['MaMH']] = [
                        'Diem15P_1' => $student['Diem15P_1'],
                        'Diem15P_2' => $student['Diem15P_2'],
                        'Diem1Tiet_1' => $student['Diem1Tiet_1'],
                        'Diem1Tiet_2' => $student['Diem1Tiet_2'],
                        'DiemCK' => $student['DiemCK'],
                    ];
                }
            }

            // Tính toán điểm trung bình từng môn, điểm trung bình học kỳ và học lực, danh hiệu
            foreach ($students as &$student) {
                $DiemTrungBinh = null;
                $TongDiemTB = 0;
                $SoMon = count($PhanCongModel->getSubjectList($selectedYear, $selectedSemester, $selectedClass)); // Số môn học trong học kỳ
                $SoMonDuCotDiem = 0; // Số môn học có điểm

                foreach ($student['Diem'] as $MaMH => $Diem) {
                    $DiemTBMonHoc = $DiemModel->getAverageScore($Diem);

                    // Lưu điểm trung bình môn học vào mảng
                    $student['Diem'][$MaMH]['DiemTBMonHoc'] = $DiemTBMonHoc;

                    if ($DiemTBMonHoc !== null) {
                        $TongDiemTB += $DiemTBMonHoc;
                        $SoMonDuCotDiem++;
                    }
                }
                // Tính điểm trung bình học kỳ nếu có đủ cột điểm của tất cả môn
                if ($SoMonDuCotDiem === $SoMon && $SoMon > 0) {
                    $DiemTrungBinh = round($TongDiemTB / $SoMon, 1);
                }
                $student['DiemTrungBinh'] = $DiemTrungBinh;

                // Xếp loại học lực
                $student['HocLuc'] = $DiemModel->getAcademicPerformance($DiemTrungBinh);

                // Xếp loại danh hiệu
                $DanhHieuModel = new DanhHieuModel();
                $DanhHieu = $DanhHieuModel->getAcademicTitle($DiemTrungBinh, $student['DiemHK']);
                $student['DanhHieu'] = $DanhHieu ? $DanhHieu['TenDH'] : null;
            }
        }


        // Trường hợp "Cả năm"
        if ($selectedSemester === 0) {

            $studentList1 = $HocSinhModel->getStudentList($selectedYear, 1, $selectedClass); // Học kỳ 1
            $studentList2 = $HocSinhModel->getStudentList($selectedYear, 2, $selectedClass); // Học kỳ 2 <= Sử dụng lại kết nối

            foreach ([$studentList1, $studentList2] as $key => $studentList) {
                foreach ($studentList as $student) {
                    $MaHS = $student['MaHS'];

                    // Khởi tạo dữ liệu học sinh nếu chưa có
                    if (!isset($students[$MaHS])) {
                        $students[$MaHS] = [
                            'MaHS' => $MaHS,
                            'HoTen' => $student['HoTen'],
                            'TenLop' => $student['TenLop'],
                            'Diem' => [],
                            'DiemHK' => ['HocKy1' => null, 'HocKy2' => null],
                        ];
                    }

                    // Lưu điểm hạnh kiểm
                    $students[$MaHS]['DiemHK']['HocKy' . ($key + 1)] = $student['DiemHK'];

                    // Lưu điểm của từng môn học
                    if ($student['MaMH']) {
                        $students[$MaHS]['Diem'][$student['MaMH']]['HocKy' . ($key + 1)] = [
                            'Diem15P_1' => $student['Diem15P_1'],
                            'Diem15P_2' => $student['Diem15P_2'],
                            'Diem1Tiet_1' => $student['Diem1Tiet_1'],
                            'Diem1Tiet_2' => $student['Diem1Tiet_2'],
                            'DiemCK' => $student['DiemCK'],
                        ];
                    }
                }
            }

            // Tính toán điểm trung bình cả năm
            foreach ($students as &$student) {
                $TongDiemTB = 0;
                $SoMon = count($PhanCongModel->getSubjectList($selectedYear, 1, $selectedClass)); // Số môn học
                $SoMonDuCotDiem = 0;

                foreach ($student['Diem'] as $MaMH => $DiemHocKy) {
                    $DiemTBHocKy1 = isset($DiemHocKy['HocKy1']) ? $DiemModel->getAverageScore($DiemHocKy['HocKy1']) : null;
                    $DiemTBHocKy2 = isset($DiemHocKy['HocKy2']) ? $DiemModel->getAverageScore($DiemHocKy['HocKy2']) : null;

                    $DiemTBCaNam = null;
                    if ($DiemTBHocKy1 !== null && $DiemTBHocKy2 !== null) {
                        $DiemTBCaNam = round(($DiemTBHocKy1 + 2 * $DiemTBHocKy2) / 3, 1);
                    }

                    $student['Diem'][$MaMH]['DiemTBMonHoc'] = $DiemTBCaNam;

                    if ($DiemTBCaNam !== null) {
                        $TongDiemTB += $DiemTBCaNam;
                        $SoMonDuCotDiem++;
                    }
                }

                $DiemTrungBinhCaNam = null;
                if ($SoMonDuCotDiem === $SoMon && $SoMon > 0) {
                    $DiemTrungBinhCaNam = round($TongDiemTB / $SoMon, 1);
                }

                $student['DiemTrungBinh'] = $DiemTrungBinhCaNam;

                // Xếp loại học lực
                $student['HocLuc'] = $DiemModel->getAcademicPerformance($DiemTrungBinhCaNam);

                // Xếp loại danh hiệu
                $DanhHieuModel = new DanhHieuModel();
                $DiemHKCaNam = round(($student['DiemHK']['HocKy1'] + $student['DiemHK']['HocKy2']) / 2, 1);
                $student['DiemHK'] = $DiemHKCaNam;
                $DanhHieu = $DanhHieuModel->getAcademicTitle($DiemTrungBinhCaNam, $DiemHKCaNam);
                $student['DanhHieu'] = $DanhHieu ? $DanhHieu['TenDH'] : null;
            }
        }

        // Lấy danh sách học sinh theo năm học, học kỳ và lớp học
        // $studentList = $HocSinhModel->getStudentList($selectedYear, $selectedSemester, $selectedClass);



        //log_message('info', 'Student List: ' . print_r($students, true));

        return view('director/student/record', [
            'studentList' => $students,
            'yearList' => $yearList,
            'classList' => $classList,
            'selectedYear' => $selectedYear,
            'selectedSemesterText' => $selectedSemesterText,
            'selectedClass' => $selectedClass,
        ]);
    }

    //Màn hình Danh hiệu
    public function titleList()
    {
        $DanhHieuModel = new DanhHieuModel();
        $ThamSoModel = new ThamSoModel();

        // Nhận giá trị từ khóa tìm kiếm từ query string
        $searchTerm = $this->request->getVar('search') ?? '';



        // Lấy danh sách danh hiệu và sắp xếp theo DiemTBToiThieu giảm dần
        $titleList = $DanhHieuModel->orderBy('DiemTBToiThieu', 'DESC')->findAll();


        // Lấy giá trị MucHocPhiNamHoc từ bảng ThamSo
        $HocPhi = $ThamSoModel->getGiaTriThamSo('MucHocPhiNamHoc');

        // Lấy giá trị SiSoLopToiDa từ bảng ThamSo
        $SiSoLopToiDa = $ThamSoModel->getGiaTriThamSo('SiSoLopToiDa');

        // Truyền dữ liệu tới view
        return view('director/title/list', [
            'titleList' => $titleList,
            'searchTerm' => $searchTerm,
            'HocPhi' => $HocPhi,
            'SiSoLopToiDa' => $SiSoLopToiDa,
        ]);
    }

    public function updateRule()
    {
        $ThamSoModel = new ThamSoModel();

        // Lấy dữ liệu từ form
        $MucHocPhiNamHoc = $this->request->getPost('student_fee');
        $SiSoLopToiDa = $this->request->getPost('student_quantity');

        // Cập nhật giá trị MucHocPhiNamHoc và SiSoLopToiDa trong bảng ThamSo
        $ThamSoModel->updateGiaTriThamSo('MucHocPhiNamHoc', $MucHocPhiNamHoc);
        $ThamSoModel->updateGiaTriThamSo('SiSoLopToiDa', $SiSoLopToiDa);

        return redirect()->back()->with('success', 'Cập nhật quy định thành công!');
    }

    public function titleAdd()
    {
        return view('director/title/add');
    }

    public function addTitle()
    {
        $DanhHieuModel = new DanhHieuModel();

        // Lấy dữ liệu từ form
        $TenDH = $this->request->getPost('title_name');
        $DiemTBToiThieu = $this->request->getPost('min_grade');
        $DiemHanhKiemToiThieu = $this->request->getPost('min_conduct');

        // Kiểm tra tính hợp lệ của dữ liệu
        if ($DiemTBToiThieu < 0 || $DiemTBToiThieu > 10) {
            return redirect()->back()->with('error', 'Điểm trung bình tối thiểu phải nằm trong khoảng từ 0 đến 10.');
        }

        if ($DiemHanhKiemToiThieu < 0 || $DiemHanhKiemToiThieu > 100) {
            return redirect()->back()->with('error', 'Điểm hạnh kiểm tối thiểu phải nằm trong khoảng từ 0 đến 100.');
        }
        // Lưu danh hiệu vào cơ sở dữ liệu
        $MaDH = $DanhHieuModel->insert([
            'TenDH' => $TenDH,
            'DiemTBToiThieu' => $DiemTBToiThieu,
            'DiemHanhKiemToiThieu' => $DiemHanhKiemToiThieu,
        ]);

        // Điều hướng sau khi lưu thành công/thất bại
        if ($MaDH) {
            return redirect()->to('director/title/list')->with('success', 'Thêm danh hiệu thành công!');
        } else {
            return redirect()->back()->with('error', 'Không thể thêm danh hiệu. Vui lòng thử lại.');
        }
    }

    public function titleUpdate($id)
    {
        $DanhHieuModel = new DanhHieuModel();

        // Lấy thông tin danh hiệu dựa trên ID
        $title = $DanhHieuModel->find($id);

        if (!$title) {
            return redirect()->to('/sms/public/director/title/list')->with('error', 'Không tìm thấy danh hiệu.');
        }

        return view('director/title/update', ['title' => $title]);
    }
    public function updateTitle()
    {
        $DanhHieuModel = new DanhHieuModel();

        // Lấy dữ liệu từ form
        $MaDH = $this->request->getPost('id');
        $TenDH = $this->request->getPost('title_name');
        $DiemTBToiThieu = $this->request->getPost('min_grade');
        $DiemHanhKiemToiThieu = $this->request->getPost('min_conduct');

        // Kiểm tra tính hợp lệ của dữ liệu
        if ($DiemTBToiThieu < 0 || $DiemTBToiThieu > 10) {
            return redirect()->back()->with('error', 'Điểm trung bình tối thiểu phải nằm trong khoảng từ 0 đến 10.');
        }

        if ($DiemHanhKiemToiThieu < 0 || $DiemHanhKiemToiThieu > 100) {
            return redirect()->back()->with('error', 'Điểm hạnh kiểm tối thiểu phải nằm trong khoảng từ 0 đến 100.');
        }

        // Cập nhật danh hiệu trong cơ sở dữ liệu
        $DanhHieu = $DanhHieuModel->update($MaDH, [
            'TenDH' => $TenDH,
            'DiemTBToiThieu' => $DiemTBToiThieu,
            'DiemHanhKiemToiThieu' => $DiemHanhKiemToiThieu,
        ]);

        // Điều hướng sau khi cập nhật
        if ($DanhHieu) {
            return redirect()->to('director/title/list')->with('success', 'Cập nhật danh hiệu thành công!');
        } else {
            return redirect()->back()->with('error', 'Không thể cập nhật danh hiệu. Vui lòng thử lại.');
        }
    }

    public function titleDelete($id)
    {
        $DanhHieuModel = new DanhHieuModel();

        // Xóa danh hiệu dựa trên ID
        $DanhHieu = $DanhHieuModel->delete($id);

        // Điều hướng sau khi xóa
        if ($DanhHieu) {
            return redirect()->back()->with('success', 'Xóa danh hiệu thành công!');
        } else {
            return redirect()->back()->with('error', 'Không thể xóa danh hiệu. Vui lòng thử lại.');
        }
    }

    // Màn hình quản lý lớp học
    public function classList()
    {
        $LopModel = new LopModel();
        $HocSinhLopModel = new HocSinhLopModel();


        //Nhận giá trị tìm kiếm từ query string
        $selectedYear = $this->request->getVar('year') ?? '2024-2025';
        $searchTerm = $this->request->getVar('search') ?? '';

        //Lấy danh sách các năm học
        $yearListArray = $HocSinhLopModel
            ->distinct()
            ->select('NamHoc')
            ->orderBy('NamHoc', 'ASC')
            ->findAll();
        //Lấy các giá trị của trường 'NamHoc' từ mảng $yearListArray
        $yearList = array_map(function ($year) {
            return $year['NamHoc']; //Lấy giá trị NamHoc
        }, $yearListArray);

        //Câu truy vấn SQL để lấy danh sách lớp học
        $SQL = "
        SELECT lop.MaLop, lop.TenLop, giaovien.MaGV, taikhoan.HoTen, COUNT(hocsinh_lop.MaHS) as SiSo
        FROM lop
        JOIN phancong ON lop.MaLop = phancong.MaLop
        JOIN giaovien ON phancong.MaGV = giaovien.MaGV
        JOIN taikhoan ON giaovien.MaTK = taikhoan.MaTK
        LEFT JOIN hocsinh_lop ON lop.MaLop = hocsinh_lop.MaLop AND hocsinh_lop.NamHoc = '$selectedYear'
        WHERE phancong.NamHoc = '$selectedYear' AND phancong.VaiTro = 'Giáo viên chủ nhiệm'
        ";

        // Nếu có từ khóa tìm kiếm, áp dụng bộ lọc
        if ($searchTerm) {
            $SQL .= " AND (lop.TenLop LIKE '%$searchTerm%' OR taikhoan.HoTen LIKE '%$searchTerm%')";
        }

        //Nhóm kết quả theo mã lớp, tên lớp, mã giáo viên và tên giáo viên
        $SQL .= " GROUP BY lop.MaLop, lop.TenLop, giaovien.MaGV, taikhoan.HoTen
        ORDER BY lop.TenLop ASC";

        //Thực thi câu truy vấn
        $classList = $LopModel->query($SQL)->getResultArray();

        // Lưu năm học vào session để truyền giữa các trang (classAdd)
        if ($selectedYear) {
            session()->set('selectedYear', $selectedYear);
        }

        return view('director/class/list', [
            'classList' => $classList,
            'yearList' => $yearList,
            'selectedYear' => $selectedYear,
            'searchTerm' => $searchTerm,
        ]);
    }

    public function classAdd()
    {
        // Lấy giá trị năm học từ session
        $selectedYear = session()->get('selectedYear');

        // Lấy danh sách giáo viên chưa chủ nhiệm lớp nào trong năm học đã chọn
        $GiaoVienModel = new GiaoVienModel();

        // Tạo query lấy danh sách giáo viên chưa chủ nhiệm lớp nào trong năm học đã chọn
        $SQL = "SELECT giaovien.MaGV, taikhoan.HoTen
        FROM giaovien
        JOIN taikhoan ON taikhoan.MaTK = giaovien.MaTK
        WHERE giaovien.MaGV NOT IN (
            SELECT MaGV FROM phancong WHERE NamHoc = '$selectedYear' AND VaiTro = 'Giáo viên chủ nhiệm'
        )";

        $GiaoVien = $GiaoVienModel->query($SQL)->getResultArray();


        //Chuẩn bị mảng options cho dropdown chọn giáo viên
        $GiaoVien = array_map(function ($teacher) {
            return $teacher['MaGV'] . ' - ' . $teacher['HoTen'];
        }, $GiaoVien);

        return view('director/class/add', [
            'selectedYear' => $selectedYear,
            'teacherOptions' => $GiaoVien,
        ]);
    }

    public function addClass()
    {
        $errors = [];
        // Lấy dữ liệu từ form
        $selectedYear = $this->request->getPost('year');
        $className = $this->request->getPost('class_name');
        $classTeacher = $this->request->getPost('class-teacher');

        //Kiểm tra giáo viên chủ nhiệm
        if (empty($classTeacher)) {
            $errors['class-teacher'] = 'Vui lòng chọn giáo viên chủ nhiệm.';
        }

        //Kiểm tra tên lớp
        if (empty($className)) {
            $errors['class_name'] = 'Vui lòng nhập tên lớp.';
        }

        //Kiểm tra tên lớp đã tồn tại chưa
        $LopModel = new LopModel();
        $classExists = $LopModel->where('TenLop', $className)->first();
        if ($classExists) {
            $errors['class_name'] = 'Tên lớp đã tồn tại.';
        }

        //Nếu có lỗi, trả về cùng thông báo
        if (!empty($errors)) {
            return redirect()->back()->withInput()->with('errors', $errors);
        }

        $LopModel = new LopModel();
        $PhanCongModel = new PhanCongModel();

        //Lưu thông tin lớp học
        $MaLop = $LopModel->insert([
            'TenLop' => $className,
        ]);

        //Lưu thông tin giáo viên chủ nhiệm
        $MaGV = explode(' - ', $classTeacher)[0];
        $PhanCongModel->insert([
            'MaGV' => $MaGV,
            'MaLop' => $MaLop,
            'NamHoc' => $selectedYear,
            'VaiTro' => 'Giáo viên chủ nhiệm',
        ]);

        return redirect()->to('director/class/list')->with('success', 'Thêm lớp học thành công!');
    }

    public function classUpdate($MaLop)
    {
        $LopModel = new LopModel();
        $GiaoVienModel = new GiaoVienModel();
        $PhanCongModel = new PhanCongModel();

        // Lấy giá trị năm học từ session
        $selectedYear = session()->get('selectedYear');

        // Lấy thông tin lớp học theo mã lớp
        $class = $LopModel->find($MaLop);

        // Lấy thông tin giáo viên chủ nhiệm
        $teacher = $PhanCongModel
            ->select('giaovien.MaGV, taikhoan.HoTen')
            ->join('giaovien', 'giaovien.MaGV = phancong.MaGV')
            ->join('taikhoan', 'taikhoan.MaTK = giaovien.MaTK')
            ->where('phancong.MaLop', $MaLop)
            ->where('phancong.NamHoc', $selectedYear)
            ->where('phancong.VaiTro', 'Giáo viên chủ nhiệm')
            ->first();

        // Lấy danh sách giáo viên chưa chủ nhiệm lớp nào trong năm học đã chọn
        $SQL = "SELECT giaovien.MaGV, taikhoan.HoTen
        FROM giaovien
        JOIN taikhoan ON taikhoan.MaTK = giaovien.MaTK
        WHERE giaovien.MaGV NOT IN (
            SELECT MaGV FROM phancong WHERE NamHoc = '$selectedYear' AND VaiTro = 'Giáo viên chủ nhiệm'
        )";

        $GiaoVien = $GiaoVienModel->query($SQL)->getResultArray();

        //Gộp giáo viên đang chủ nhiệm lớp đó vào danh sách giáo viên chưa chủ nhiệm
        if ($teacher) {
            array_unshift($GiaoVien, [
                'MaGV' => $teacher['MaGV'],
                'HoTen' => $teacher['HoTen']
            ]);
        }

        //Chuẩn bị mảng options cho dropdown chọn giáo viên
        $GiaoVien = array_map(function ($teacher) {
            return $teacher['MaGV'] . ' - ' . $teacher['HoTen'];
        }, $GiaoVien);

        return view('director/class/update', [
            'class' => $class,
            'teacher' => $teacher,
            'teacherOptions' => $GiaoVien,
        ]);
    }

    public function updateClass()
    {
        $errors = [];
        // Lấy dữ liệu từ form
        $MaLop = $this->request->getPost('MaLop');
        $className = $this->request->getPost('class_name');
        $classTeacher = $this->request->getPost('class-teacher');

        //Kiểm tra giáo viên chủ nhiệm
        if (empty($classTeacher)) {
            $errors['class-teacher'] = 'Vui lòng chọn giáo viên chủ nhiệm.';
        }

        //Kiểm tra tên lớp
        if (empty($className)) {
            $errors['class_name'] = 'Vui lòng nhập tên lớp.';
        }

        //Kiểm tra tên lớp đã tồn tại chưa, nếu tên lớp thay đổi
        $LopModel = new LopModel();
        $currentClass = $LopModel->find($MaLop);
        if ($currentClass['TenLop'] !== $className) {
            $classExists = $LopModel->where('TenLop', $className)->first();
            if ($classExists) {
                $errors['class_name'] = 'Tên lớp đã tồn tại.';
            }
        }

        //Nếu có lỗi, trả về cùng thông báo
        if (!empty($errors)) {
            return redirect()->back()->withInput()->with('errors', $errors);
        }
        //Lấy giá trị năm học từ session
        $selectedYear = session()->get('selectedYear');

        $LopModel = new LopModel();
        $PhanCongModel = new PhanCongModel();

        //Lưu thông tin lớp học
        $LopModel->update($MaLop, [
            'TenLop' => $className,
        ]);

        //Lưu thông tin giáo viên chủ nhiệm
        $MaGV = explode(' - ', $classTeacher)[0];

        $SQL = "UPDATE phancong
        SET MaGV = '$MaGV'
        WHERE MaLop = '$MaLop' AND NamHoc = '$selectedYear' AND VaiTro = 'Giáo viên chủ nhiệm'";
        $PhanCongModel->query($SQL);


        return redirect()->to('director/class/list')->with('success', 'Cập nhật lớp học thành công!');
    }

    public function deleteClass($MaLop)
    {
        $db = \Config\Database::connect();
        $LopModel = new LopModel();
        $PhanCongModel = new PhanCongModel();
        $HocSinhLopModel = new HocSinhLopModel();
        $DiemModel = new DiemModel();
        $NamHoc = $this->request->getGet('NamHoc');

        // Bắt đầu transaction
        $db->transStart();

        try {
            // Kiểm tra lớp có tồn tại trong năm học không
            $class = $LopModel->where(['MaLop' => $MaLop])->first();
            if (!$class) {
                return redirect()->back()->with('error', 'Không tìm thấy lớp học.');
            }

            // Kiểm tra ràng buộc với bảng HOCSINH_LOP
            if ($HocSinhLopModel->where(['MaLop' => $MaLop, 'NamHoc' => $NamHoc])->countAllResults() > 0) {
                return redirect()->back()->with('error', 'Không thể xóa lớp vì có học sinh đang theo học.');
            }

            // Kiểm tra ràng buộc với bảng DIEM
            // Lấy danh sách học sinh trong lớp theo MaLop và NamHoc
            $studentsInClass = $HocSinhLopModel->where(['MaLop' => $MaLop, 'NamHoc' => $NamHoc])->findAll();

            // Kiểm tra nếu có học sinh trong lớp này có điểm
            if (!empty($studentsInClass)) {
                $studentIds = array_column($studentsInClass, 'MaHS'); // Lấy danh sách MaHS của học sinh trong lớp

                // Kiểm tra xem có điểm nào của học sinh trong bảng DIEM không
                if ($DiemModel->whereIn('MaHS', $studentIds)->where('NamHoc', $NamHoc)->countAllResults() > 0) {
                    return redirect()->back()->with('error', 'Không thể xóa lớp vì có dữ liệu điểm.');
                }
            }

            // Kiểm tra phân công giáo viên
            $assignments = $PhanCongModel->where(['MaLop' => $MaLop, 'NamHoc' => $NamHoc])->findAll();
            $GiaoVienChuNhiem = null;
            $GiaoVienBoMon = [];

            foreach ($assignments as $assignment) {
                if ($assignment['VaiTro'] === 'Giáo viên chủ nhiệm') {
                    $GiaoVienChuNhiem = $assignment;
                } else {
                    $GiaoVienBoMon[] = $assignment;
                }
            }

            // Nếu có giáo viên bộ môn, không cho phép xóa
            if (!empty($GiaoVienBoMon)) {
                return redirect()->back()->with('error', 'Không thể xóa lớp vì có phân công giáo viên bộ môn.');
            }

            // Thực hiện xóa lớp và phân công giáo viên chủ nhiệm
            if ($GiaoVienChuNhiem) {
                $PhanCongModel->delete($GiaoVienChuNhiem['MaPC']);
            }

            // Thực hiện xóa lớp
            $deletedClass = $LopModel->delete($MaLop);
            if (!$deletedClass) {
                throw new \Exception('Xóa lớp học thất bại.');
            }

            // Hoàn tất transaction
            $db->transComplete();

            if ($db->transStatus() === false) {
                throw new \Exception('Có lỗi xảy ra khi thực hiện xóa lớp.');
            }

            return redirect()->back()->with('success', 'Xóa lớp học thành công!');
        } catch (\Exception $e) {
            // Rollback transaction khi xảy ra lỗi
            $db->transRollback();

            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    // Màn hình xếp lớp
    public function classArrangeStudent($MaLop)
    {
        //Lấy giá trị năm học từ session
        $selectedYear = session()->get('selectedYear');

        //Lấy danh sách học sinh trong lớp theo năm học
        $HocSinhModel = new HocSinhModel();

        $SQL = "SELECT hocsinh.*, taikhoan.*, lop.TenLop
        FROM hocsinh
        JOIN taikhoan ON taikhoan.MaTK = hocsinh.MaTK
        JOIN hocsinh_lop ON hocsinh.MaHS = hocsinh_lop.MaHS
        JOIN lop ON lop.MaLop = hocsinh_lop.MaLop
        WHERE hocsinh_lop.MaLop = '$MaLop' AND hocsinh_lop.NamHoc = '$selectedYear'";
        $studentList = $HocSinhModel->query($SQL)->getResultArray();

        // Nếu danh sách không rổng, lấy tên lớp từ bản ghi đầu tiên
        $TenLop = $studentList ? $studentList[0]['TenLop'] : '';
        return view('director/class/arrange/student', [
            'MaLop' => $MaLop,
            'TenLop' => $TenLop,
            'studentList' => $studentList,
            'selectedYear' => $selectedYear,
        ]);
    }

    public function deleteStudentFromClass($MaHS)
    {
        $db = \Config\Database::connect();
        $HocSinhLopModel = new HocSinhLopModel();
        $DiemModel = new DiemModel();
        $ViPhamModel = new ViPhamModel();
        $HanhKiemModel = new HanhKiemModel();
        $PhieuThanhToanModel = new ThanhToanModel();
        $HoaDonModel = new HoaDonModel();

        $MaLop = $this->request->getGet('MaLop');
        $NamHoc = $this->request->getGet('NamHoc');

        log_message('debug', 'MaHS: ' . $MaHS . ', MaLop: ' . $MaLop . ', NamHoc: ' . $NamHoc);

        // Bắt đầu transaction
        $db->transStart();

        try {
            // Kiểm tra học sinh có tồn tại trong lớp học không
            $studentInClass = $HocSinhLopModel->where([
                'MaLop' => $MaLop,
                'NamHoc' => $NamHoc,
                'MaHS' => $MaHS,
            ])->first();

            if (!$studentInClass) {
                return redirect()->back()->with('error', 'Không tìm thấy học sinh trong lớp học đã chọn.');
            }

            // Kiểm tra ràng buộc với bảng DIEM
            if ($DiemModel->where(['MaHS' => $MaHS, 'NamHoc' => $NamHoc])->countAllResults() > 0) {
                return redirect()->back()->with('error', 'Không thể xóa học sinh vì đã có dữ liệu điểm.');
            }

            // Kiểm tra ràng buộc với bảng VIPHAM
            if ($ViPhamModel->where(['MaHS' => $MaHS, 'NamHoc' => $NamHoc])->countAllResults() > 0) {
                return redirect()->back()->with('error', 'Không thể xóa học sinh vì đã có dữ liệu vi phạm.');
            }

            // Kiểm tra và xử lý bảng HOADON
            $hoaDon = $HoaDonModel->where(['MaHS' => $MaHS, 'NamHoc' => $NamHoc])->first();
            if ($hoaDon) {
                if ($hoaDon['TrangThai'] === 'Đã thanh toán' || $hoaDon['DaThanhToan'] > 0) {
                    return redirect()->back()->with('error', 'Không thể xóa học sinh vì hóa đơn đã thanh toán hoặc thanh toán một phần.');
                }

                if ($hoaDon['TrangThai'] === 'Chưa thanh toán') {
                    // Xóa hóa đơn nếu chưa thanh toán
                    $HoaDonModel->delete($hoaDon['MaHD']);
                }
            }

            // Kiểm tra và xóa dữ liệu HANHKIEM nếu điểm là mặc định
            $hanhKiem = $HanhKiemModel->where(['MaHS' => $MaHS, 'NamHoc' => $NamHoc])->findAll();
            if (!empty($hanhKiem)) {
                foreach ($hanhKiem as $hk) {
                    if ($hk['DiemHK'] != 100) {
                        return redirect()->back()->with('error', 'Không thể xóa học sinh vì có dữ liệu hạnh kiểm quan trọng.');
                    }
                }

                // Xóa tất cả các bản ghi hạnh kiểm liên quan
                $HanhKiemModel->where(['MaHS' => $MaHS, 'NamHoc' => $NamHoc])->delete();
            }

            // Thực hiện xóa học sinh khỏi lớp
            $deletedStudent = $HocSinhLopModel->where([
                'MaLop' => $MaLop,
                'NamHoc' => $NamHoc,
                'MaHS' => $MaHS,
            ])->delete();

            if (!$deletedStudent) {
                throw new \Exception('Xóa học sinh khỏi lớp thất bại.');
            }

            // Hoàn tất transaction
            $db->transComplete();

            if ($db->transStatus() === false) {
                throw new \Exception('Có lỗi xảy ra khi thực hiện xóa học sinh khỏi lớp.');
            }

            return redirect()->back()->with('success', 'Xóa học sinh khỏi lớp thành công!');
        } catch (\Exception $e) {
            // Rollback transaction khi xảy ra lỗi
            $db->transRollback();

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function classArrangeTeacher($MaLop)
    {
        //Lưu học kỳ vào session
        $semester = $this->request->getVar('semester');
        if ($semester) {
            session()->set('selectedSemester', $semester);
        }

        //Lấy giá trị năm học từ session
        $selectedYear = session()->get('selectedYear');

        //Nhận giá trị học kỳ , từ khóa tìm kiếm từ query string
        $searchTerm = $this->request->getVar('search') ?? '';
        $selectedSemester = $this->request->getVar('semester') ?? 'Học kỳ 1';

        // Tách tên học kỳ để lấy số
        $semesterNumber = preg_replace('/\D/', '', $selectedSemester);

        //Lấy thông tin giáo viên dạy lớp được chọn
        $GiaoVienModel = new GiaoVienModel();

        $SQL = "SELECT giaovien.*, taikhoan.*, lop.TenLop, monhoc.*
        FROM giaovien
        JOIN taikhoan ON taikhoan.MaTK = giaovien.MaTK
        JOIN phancong ON phancong.MaGV = giaovien.MaGV
        JOIN lop ON lop.MaLop = phancong.MaLop
        JOIN monhoc ON monhoc.MaMH = phancong.MaMH
        WHERE phancong.MaLop = '$MaLop' AND phancong.NamHoc = '$selectedYear'";

        // Lọc theo học kỳ được chọn nếu có
        if ($selectedSemester) {
            $SQL .= " AND phancong.HocKy = $semesterNumber";
        }

        // Nếu có từ khóa tìm kiếm, áp dụng bộ lọc
        if ($searchTerm) {
            $SQL .= " AND (taikhoan.HoTen LIKE '%$searchTerm%' OR giaovien.MaGV LIKE '%$searchTerm%')";
        }

        //Nhóm kết quả theo mã giáo viên, tên giáo viên, tên lớp và tên môn học
        $SQL .= " GROUP BY giaovien.MaGV, taikhoan.HoTen, lop.TenLop, monhoc.TenMH
        ORDER BY monhoc.maMH ASC";

        //Thực thi câu truy vấn
        $teacherList = $GiaoVienModel->query($SQL)->getResultArray();

        // Nếu danh sách không rổng, lấy tên lớp từ bản ghi đầu tiên
        $TenLop = $teacherList ? $teacherList[0]['TenLop'] : '';

        return view('director/class/arrange/teacher', [
            'MaLop' => $MaLop,
            'TenLop' => $TenLop,
            'teacherList' => $teacherList,
            'selectedYear' => $selectedYear,
            'selectedSemester' => $selectedSemester,
            'searchTerm' => $searchTerm,
        ]);
    }

    public function deleteTeacherFromClass($MaGV)
    {
        $db = \Config\Database::connect();
        $PhanCongModel = new PhanCongModel();
        $DiemModel = new DiemModel();

        $MaLop = $this->request->getGet('MaLop');
        $NamHoc = $this->request->getGet('NamHoc');
        $HocKy = preg_replace('/\D/', '', $this->request->getGet('HocKy'));
        $MaMH = $this->request->getGet('MaMH');

        log_message('debug', 'MaGV: ' . $MaGV . ', MaLop: ' . $MaLop . ', NamHoc: ' . $NamHoc . ', HocKy: ' . $HocKy . ', MaMH: ' . $MaMH);
        // Bắt đầu transaction
        $db->transStart();

        try {
            // Kiểm tra phân công của giáo viên trong lớp học trong bảng PHANCONG
            $PhanCong = $PhanCongModel->where([
                'MaGV' => $MaGV,
                'MaLop' => $MaLop,
                'MaMH' => $MaMH,
                'NamHoc' => $NamHoc,
                'HocKy' => $HocKy,
                'VaiTro' => 'Giáo viên bộ môn',
            ])->first();

            if (!$PhanCong) {
                return redirect()->back()->with('error', 'Không tìm thấy phân công giáo viên trong lớp học đã chọn.');
            }

            // Kiểm tra xem giáo viên có điểm đã nhập cho lớp này không
            $sql = "
                    SELECT diem.*
                    FROM diem
                    JOIN hocsinh_lop ON hocsinh_lop.MaHS = diem.MaHS
                    WHERE diem.MaGV = ?
                    AND diem.MaMH = ?
                    AND diem.NamHoc = ?
                    AND diem.HocKy = ?
                    AND hocsinh_lop.MaLop = ?
                ";
            $query = $db->query($sql, [
                $MaGV,
                $MaMH,
                $NamHoc,
                $HocKy,
                $MaLop
            ]);

            $Diem = $query->getResult();

            if ($Diem) {
                return redirect()->back()->with('error', 'Không thể xóa giáo viên vì đã có dữ liệu điểm.');
            }

            // Thực hiện xóa phân công giáo viên
            $deletedAssignment = $PhanCongModel->delete($PhanCong['MaPC']);

            if (!$deletedAssignment) {
                throw new \Exception('Xóa phân công giáo viên thất bại.');
            }

            // Hoàn tất transaction
            $db->transComplete();

            if ($db->transStatus() === false) {
                throw new \Exception('Có lỗi xảy ra khi thực hiện xóa giáo viên khỏi lớp.');
            }

            return redirect()->back()->with('success', 'Xóa giáo viên khỏi lớp thành công!');
        } catch (\Exception $e) {
            // Rollback transaction khi xảy ra lỗi
            $db->transRollback();

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function classArrangeAddStudent($MaLop)
    {
        $HocSinhLopModel = new HocSinhLopModel();
        $LopModel = new LopModel();

        //Lấy giá trị năm học từ session
        $selectedYear = session()->get('selectedYear');


        //Lấy danh sách học sinh chưa được xếp lớp trong năm học đã chọn (loại bỏ những học sinh lớp 12 năm trước đó)
        $studentList = $HocSinhLopModel->getStudentNotInClass($selectedYear);

        //Chuẩn bị mảng options cho dropdown chọn học sinh
        $studentOptions = array_map(function ($student) {
            return $student['MaHS'] . ' - ' . $student['HoTen'] . ' - ' . date('d/m/Y', strtotime($student['NgaySinh']));
        }, $studentList);

        //Lấy tên lớp dựa vào mã lớp được chọn
        $TenLop = $LopModel->find($MaLop)['TenLop'];

        return view(
            'director/class/arrange/addstudent',
            [
                'studentOptions' => $studentOptions,
                'MaLop' => $MaLop,
                'TenLop' => $TenLop,
                'selectedYear' => $selectedYear,
            ]
        );
    }

    public function addStudentToClass()
    {
        $errors = [];

        //Bắt đầu transaction
        $db = \Config\Database::connect();
        $db->transStart();

        $LopModel = new LopModel();
        $HocSinhLopModel = new HocSinhLopModel();
        $ThamSoModel = new ThamSoModel();
        $PhanCongModel = new PhanCongModel();
        $HanhKiemModel = new HanhKiemModel();
        $HoaDonModel = new HoaDonModel();

        //Lấy TenLop, NamHoc, MaHS từ form
        $className = $this->request->getPost('student_classname');
        $year = $this->request->getPost('student_year');
        $studentInfo = $this->request->getPost('student_studentInfo');

        //Tách MaHS từ chuỗi studentInfo
        $MaHS = explode(' - ', $studentInfo)[0];

        //Lấy MaLop từ TenLop
        $MaLop = $LopModel->where('TenLop', $className)->first()['MaLop'];

        // Kiểm tra đã chọn học sinh chưa
        if (empty($studentInfo)) {
            $errors['student_studentInfo'] = 'Vui lòng chọn học sinh.';
        }

        // Kiểm tra xem học sinh đã được xếp lớp chưa
        if ($HocSinhLopModel->checkStudentInClass($MaHS, $MaLop, $year)) {
            $errors['student_StudentInClass'] = 'Học sinh đã được xếp lớp trong năm học này.';
        }
        // Kiểm tra giới hạn sĩ số của lớp
        $maxClassSize = $ThamSoModel->getGiaTriThamSo('SiSoLopToiDa');
        $currentClassSize = $HocSinhLopModel->countStudentInClass($MaLop, $year);
        if ($currentClassSize >= $maxClassSize) {
            $errors['student_ClassSize'] = 'Lớp đã đạt giới hạn sĩ số tối đa.';
        }

        //Nếu có lỗi, trả về cùng thông báo
        if (!empty($errors)) {
            return redirect()->back()->withInput()->with('errors', $errors);
        }

        try {
            // Thêm học sinh vào lớp học trong năm học
            $HocSinhLopModel->addStudentToClass($MaHS, $MaLop, $year);

            // Thêm thông tin hạnh kiểm của học sinh
            $HanhKiemModel->addConduct($MaHS, $year);

            // Thêm thông tin học phí cho học sinh
            $tuitionFee = $ThamSoModel->getGiaTriThamSo('MucHocPhiNamHoc');
            $HoaDonModel->addInvoice($MaHS, $year, $tuitionFee);

            // Kiểm tra nếu tất cả thành công
            if ($db->transStatus() === false) {
                throw new \Exception('Transaction failed');
            }

            // Xác nhận transaction
            $db->transCommit();

            return redirect()->to('director/class/arrange/student/' . $MaLop)->with('success', 'Thêm học sinh vào lớp học thành công!');
        } catch (\Exception $e) {
            // Nếu có lỗi, rollback transaction
            $db->transRollback();
            return redirect()->back()->with('error', 'Không thể thêm học sinh vào lớp học. Vui lòng thử lại.');
        }
    }

    public function classArrangeAddTeacher($MaLop)
    {
        $GiaoVienModel = new GiaoVienModel();
        $MonHocModel = new MonHocModel();
        $LopModel = new LopModel();

        // Lấy giá trị năm học, học kỳ từ session
        $selectedYear = session()->get('selectedYear');
        $selectedSemester = session()->get('selectedSemester');

        //Lấy tên lớp dựa vào mã lớp được chọn
        $TenLop = $LopModel->find($MaLop)['TenLop'];

        // Lấy danh sách giáo viên chưa dạy lớp đã chọn trong năm học
        $teacherList = $GiaoVienModel->getTeacherList();

        // Chuẩn bị mảng options cho dropdown chọn giáo viên
        $teacherOptions = array_map(function ($teacher) {
            return $teacher['MaGV'] . ' - ' . $teacher['HoTen'];
        }, $teacherList);

        $subjectList = array_column($MonHocModel->getSubjectList(), 'TenMH');

        return view('director/class/arrange/addteacher', [
            'teacherOptions' => $teacherOptions,
            'subjectList' => $subjectList,
            'MaLop' => $MaLop,
            'TenLop' => $TenLop,
            'selectedYear' => $selectedYear,
            'selectedSemester' => $selectedSemester,
        ]);
    }

    public function addTeacherToClass()
    {
        $errors = [];

        $PhanCongModel = new PhanCongModel();
        $LopModel = new LopModel();
        $MonHocModel = new MonHocModel();

        // Lấy dữ liệu từ form
        $className = $this->request->getPost('teacher_classname');
        $year = $this->request->getPost('teacher_year');
        $semester = $this->request->getPost('teacher_semester');
        $teacherInfo = $this->request->getPost('teacher_teacherInfo');
        $subjectName = $this->request->getPost('teacher_subject');

        // Tách tên học kỳ để lấy số
        $HocKy = preg_replace('/\D/', '', $semester);
        // Lấy MaLop từ tên lớp
        $MaLop = $LopModel->where('TenLop', $className)->first()['MaLop'];

        // Kiểm tra đã chọn học kỳ chưa
        if (empty($semester)) {
            $errors['teacher_semester'] = 'Vui lòng chọn học kỳ.';
        }

        // Kiểm tra đã chọn giáo viên chưa
        if (empty($teacherInfo)) {
            $errors['teacher_teacherInfo'] = 'Vui lòng chọn giáo viên.';
        }

        // Kiểm tra đã chọn môn học chưa
        if (empty($subjectName)) {
            $errors['teacher_subject'] = 'Vui lòng chọn môn học.';
        }

        // Nếu có lỗi, trả về cùng thông báo
        if (!empty($errors)) {
            return redirect()->back()->withInput()->with('errors', $errors);
        }

        // Lấy MaMH từ tên môn học
        $MaMH = $MonHocModel->where('TenMH', $subjectName)->first()['MaMH'];
        // Tách MaGV từ chuỗi teacherInfo
        $MaGV = explode(' - ', $teacherInfo)[0];

        // Kiểm tra giáo viên đã được phân công dạy môn học
        // trong năm học, học kỳ và lớp học đó chưa
        if ($PhanCongModel->isTeacherAssigned($MaGV, $MaMH, $MaLop, $HocKy, $year)) {
            $errors['teacher_TeacherAssigned'] = 'Giáo viên đã được phân công dạy môn học này trong lớp học.';
        }

        // // Kiểm tra môn học đã có giáo viên phân công dạy trong năm học, học kỳ và lớp học đó chưa
        // if ($PhanCongModel->isSubjectAssigned($MaMH, $MaLop, $HocKy, $year)) {
        //     $errors['teacher_SubjectAssigned'] = 'Môn học đã có giáo viên phân công dạy trong lớp học.';
        // }

        //Nếu có lỗi, trả về cùng thông báo
        if (!empty($errors)) {
            return redirect()->back()->withInput()->with('errors', $errors);
        }

        //Lưu thông tin phân công giáo viên dạy môn học trong lớp học
        $PhanCongModel->addTeacherToAssign($MaGV, $MaMH, $MaLop, $HocKy, $year);

        return redirect()->to('director/class/arrange/teacher/' . $MaLop)->with('success', 'Phân công giáo viên dạy môn học thành công!');
    }

    // Màn hình quản lý giáo viên
    public function employeeTeacherList()
    {
        $GiaoVienModel = new GiaoVienModel();

        //Nhận giá trị tìm kiếm từ query string
        $searchTerm = $this->request->getVar('search') ?? '';

        //Tạo query lấy danh sách giáo viên
        $GiaoVien = $GiaoVienModel
            ->select('giaovien.*, taikhoan.*')
            ->join('taikhoan', 'taikhoan.MaTK = giaovien.MaTK');

        //Nếu có từ khóa tìm kiếm, áp dụng bộ lọc
        if ($searchTerm) {
            $GiaoVien->groupStart()
                ->like('taikhoan.HoTen', $searchTerm)
                ->orLike('giaovien.MaGV', $searchTerm)
                ->groupEnd();
        }
        $teacherList = $GiaoVien->findAll();
        return view('director/employee/teacher/list', [
            'teacherList' => $teacherList,
            'searchTerm' => $searchTerm,
        ]);
    }

    public function employeeTeacherAdd()
    {
        $GiaoVienModel = new GiaoVienModel();

        // Lấy mã giáo viên lớn nhất hiện tại
        $lastTeacher = $GiaoVienModel->select('MaGV')->orderBy('MaGV', 'DESC')->first();

        // Sinh mã giáo viên mới
        $newMaGV = 'GV0001'; // Giá trị mặc định nếu chưa có mã nào
        if ($lastTeacher && preg_match('/^GV(\d+)$/', $lastTeacher['MaGV'], $matches)) {
            $newIndex = (int)$matches[1] + 1;
            $newMaGV = 'GV' . str_pad($newIndex, 4, '0', STR_PAD_LEFT);
        }
        return view('director/employee/teacher/add', ['newMaGV' => $newMaGV]);
    }

    // public function addEmployeeTeacher()
    // {
    //     $errors = [];
    //     // Lấy dữ liệu từ form
    //     $birthday = $this->request->getPost('teacher_birthday');
    //     $email = $this->request->getPost('teacher_email');
    //     $password = $this->request->getPost('teacher_password');
    //     $phone = $this->request->getPost('teacher_phone');
    //     $gender = $this->request->getPost('teacher_gender');
    //     $role = $this->request->getPost('teacher_role');
    //     //Kiểm tra giới tính
    //     if (empty($gender)) {
    //         $errors['teacher_gender'] = 'Vui lòng chọn giới tính.';
    //     }

    //     //Kiểm tra chức vụ
    //     if (empty($role)) {
    //         $errors['teacher_role'] = 'Vui lòng chọn chức vụ.';
    //     }

    //     // Kiểm tra ngày sinh
    //     if (strtotime($birthday) > strtotime(date('Y-m-d'))) {
    //         $errors['teacher_birthday'] = 'Ngày sinh không hợp lệ.';
    //     }

    //     if (empty($birthday)) {
    //         $errors['teacher_birthday'] = 'Vui lòng nhập ngày sinh.';
    //     }

    //     // Kiểm tra email
    //     if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    //         $errors['teacher_email'] = 'Email không đúng định dạng.';
    //     }

    //     // Kiểm tra mật khẩu
    //     if (strlen($password) < 6) {
    //         $errors['teacher_password'] = 'Mật khẩu phải có ít nhất 6 ký tự.';
    //     }

    //     // Kiểm tra số điện thoại
    //     if (!preg_match('/^\d{10}$/', $phone)) {
    //         $errors['teacher_phone'] = 'Số điện thoại phải có đúng 10 chữ số.';
    //     }

    //     // Nếu có lỗi, trả về cùng thông báo
    //     if (!empty($errors)) {
    //         return redirect()->back()->withInput()->with('errors', $errors);
    //     }

    //     $TaiKhoanModel = new TaiKhoanModel();
    //     $GiaoVienModel = new GiaoVienModel();

    //     $MaTK = $TaiKhoanModel->insert([
    //         'TenTK' => $this->request->getPost('teacher_account'),
    //         'MatKhau' => $this->request->getPost('teacher_password'),
    //         'Email' => $this->request->getPost('teacher_email'),
    //         'HoTen' => $this->request->getPost('teacher_name'),
    //         'SoDienThoai' => $this->request->getPost('teacher_phone'),
    //         'DiaChi' => $this->request->getPost('teacher_address'),
    //         'GioiTinh' => $this->request->getPost('teacher_gender'),
    //         'NgaySinh' => $this->request->getPost('teacher_birthday'),
    //         'MaVT' => 2, // Mã vai trò giáo viên
    //     ]);

    //     // Lưu thông tin giáo viên
    //     $GiaoVienModel->insert([
    //         'MaTK' => $MaTK,
    //         'ChucVu' => $this->request->getPost('teacher_role'),
    //         'TinhTrang' => $this->request->getPost('teacher_status') ?? 'Đang giảng dạy',
    //     ]);

    //     return redirect()->to('director/employee/teacher/list')->with('success', 'Thêm giáo viên thành công!');
    // }

    public function addEmployeeTeacher()
    {
        log_message('info', 'Bắt đầu tạo tài khoản giáo viên mới.');

        $info = [
            'account' => $this->request->getPost('teacher_account'),
            'password' => $this->request->getPost('teacher_password'),
            'name' => $this->request->getPost('teacher_name'),
            'email' => $this->request->getPost('teacher_email'),
            'phone' => $this->request->getPost('teacher_phone'),
            'address' => $this->request->getPost('teacher_address'),
            'gender' => $this->request->getPost('teacher_gender'),
            'birthday' => $this->request->getPost('teacher_birthday'),
            'role' => $this->request->getPost('teacher_role'),
            'status' => $this->request->getPost('teacher_status') ?? 'Đang giảng dạy'
        ];

        // Gọi hàm validate riêng
        $errors = $this->validateTeacher($info);
        if (!empty($errors)) {
            return redirect()->back()->withInput()->with('errors', $errors);
        }

        // Sử dụng Factory Method
        $factory = getFactoryByRole('giáo viên', $info);
        if (!$factory) {
            return redirect()->back()->with('error', 'Không xác định được vai trò người dùng.');
        }

        $teacher = $factory->createUser();
        if (!$teacher->createAndSave()) {
            return redirect()->back()->with('error', 'Tạo tài khoản giáo viên thất bại.');
        }

        log_message('info', 'Tài khoản giáo viên được tạo: ' . $teacher->getInfo() . ' - Vai trò: ' . $teacher->getRole());

        return redirect()->to('director/employee/teacher/list')->with('success', 'Thêm giáo viên thành công!');
    }

    private function validateTeacher($info)
    {
        $errors = [];

        if (empty($info['gender'])) {
            $errors['teacher_gender'] = 'Vui lòng chọn giới tính.';
        }

        if (empty($info['role'])) {
            $errors['teacher_role'] = 'Vui lòng chọn chức vụ.';
        }

        if (empty($info['birthday'])) {
            $errors['teacher_birthday'] = 'Vui lòng nhập ngày sinh.';
        } elseif (strtotime($info['birthday']) > strtotime(date('Y-m-d'))) {
            $errors['teacher_birthday'] = 'Ngày sinh không hợp lệ.';
        }

        if (!filter_var($info['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['teacher_email'] = 'Email không đúng định dạng.';
        }

        if (strlen($info['password']) < 6) {
            $errors['teacher_password'] = 'Mật khẩu phải có ít nhất 6 ký tự.';
        }

        if (!preg_match('/^\d{10}$/', $info['phone'])) {
            $errors['teacher_phone'] = 'Số điện thoại phải có đúng 10 chữ số.';
        }

        return $errors;
    }



    public function employeeTeacherUpdate($MaGV)
    {
        $GiaoVienModel = new GiaoVienModel();

        // Lấy thông tin giáo viên dựa trên MaGV
        $SQL = "SELECT giaovien.*, taikhoan.*
        FROM giaovien
        JOIN taikhoan ON taikhoan.MaTK = giaovien.MaTK
        WHERE giaovien.MaGV = '$MaGV'";

        // Thực thi câu truy vấn
        $teacher = $GiaoVienModel->query($SQL)->getRowArray();

        return view('director/employee/teacher/update', ['teacher' => $teacher]);
    }

    public function updateEmployeeTeacher($MaGV)
    {
        $errors = [];
        // Lấy dữ liệu từ form
        $MaTK = $this->request->getPost('MaTK');
        $password = $this->request->getPost('teacher_password');
        $birthday = $this->request->getPost('teacher_birthday');
        $email = $this->request->getPost('teacher_email');
        $phone = $this->request->getPost('teacher_phone');
        $gender = $this->request->getPost('teacher_gender');
        $role = $this->request->getPost('teacher_role');
        $status = $this->request->getPost('teacher_status');
        $name = $this->request->getPost('teacher_name');

        // Kiểm tra ngày sinh
        if (strtotime($birthday) > strtotime(date('Y-m-d'))) {
            $errors['teacher_birthday'] = 'Ngày sinh không hợp lệ.';
        }

        // Kiểm tra email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['teacher_email'] = 'Email không đúng định dạng.';
        }

        // Kiểm tra số điện thoại
        if (!preg_match('/^\d{10}$/', $phone)) {
            $errors['teacher_phone'] = 'Số điện thoại phải có đúng 10 chữ số.';
        }

        //Kiểm tra mật khẩu
        if (strlen($password) < 6) {
            $errors['teacher_password'] = 'Mật khẩu phải có ít nhất 6 ký tự.';
        }

        // Nếu có lỗi, trả về cùng thông báo
        if (!empty($errors)) {
            return redirect()->back()->withInput()->with('errors', $errors);
        }

        $TaiKhoanModel = new TaiKhoanModel();
        $GiaoVienModel = new GiaoVienModel();

        // Cập nhật thông tin tài khoản
        $TaiKhoan = "UPDATE taikhoan
        SET MatKhau = '$password' , Email = '$email', SoDienThoai = '$phone', GioiTinh = '$gender', NgaySinh = '$birthday', HoTen = '$name'
        WHERE MaTK = '$MaTK'";
        $TaiKhoanModel->query($TaiKhoan);

        // Cập nhật thông tin giáo viên
        $GiaoVien = "UPDATE giaovien
        SET ChucVu = '$role', TinhTrang = '$status'
        WHERE MaGV = '$MaGV'";
        $GiaoVienModel->query($GiaoVien);

        return redirect()->to('director/employee/teacher/list')->with('success', 'Cập nhật giáo viên thành công!');
    }

    public function deleteEmployeeTeacher($MaGV)
    {
        $db = \Config\Database::connect();
        $giaoVienModel = new GiaoVienModel();
        $taiKhoanModel = new TaiKhoanModel();
        $phanCongModel = new PhanCongModel();
        $diemModel = new DiemModel();

        // Bắt đầu transaction
        $db->transStart();

        try {
            // Kiểm tra tồn tại giáo viên
            $giaoVien = $giaoVienModel->find($MaGV);
            if (!$giaoVien) {
                return redirect()->back()->with('error', 'Không tìm thấy giáo viên.');
            }

            // Kiểm tra ràng buộc: Giáo viên có dữ liệu liên quan trong bảng PHANCONG không
            $phanCongBound = $phanCongModel->where('MaGV', $MaGV)->countAllResults();
            if ($phanCongBound > 0) {
                return redirect()->back()->with('error', 'Không thể xóa giáo viên vì đã được phân công giảng dạy.');
            }

            // Kiểm tra ràng buộc: Giáo viên có dữ liệu liên quan trong bảng DIEM không
            $diemBound = $diemModel->where('MaGV', $MaGV)->countAllResults();
            if ($diemBound > 0) {
                return redirect()->back()->with('error', 'Không thể xóa giáo viên vì đã có dữ liệu điểm liên quan.');
            }

            // Xóa giáo viên
            if (!$giaoVienModel->delete($MaGV)) {
                throw new \Exception('Xóa giáo viên thất bại.');
            }

            // Xóa tài khoản liên kết với giáo viên
            if (!$taiKhoanModel->delete($giaoVien['MaTK'])) {
                throw new \Exception('Xóa tài khoản giáo viên thất bại.');
            }

            // Hoàn tất transaction
            $db->transComplete();

            // Kiểm tra trạng thái transaction
            if ($db->transStatus() === false) {
                throw new \Exception('Có lỗi xảy ra khi thực hiện xóa giáo viên.');
            }

            return redirect()->back()->with('success', 'Xóa giáo viên thành công!');
        } catch (\Exception $e) {
            // Rollback transaction nếu có lỗi
            $db->transRollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    // Màn hình quản lý giám thị
    public function employeeSupervisorList()
    {
        $GiamThiModel = new GiamThiModel();

        //Nhận giá trị tìm kiếm từ query string
        $searchTerm = $this->request->getVar('search') ?? '';

        //Tạo query lấy danh sách giám thị
        $GiamThi = $GiamThiModel
            ->select('giamthi.*, taikhoan.*')
            ->join('taikhoan', 'taikhoan.MaTK = giamthi.MaTK');

        //Nếu có từ khóa tìm kiếm, áp dụng bộ lọc
        if ($searchTerm) {
            $GiamThi->groupStart()
                ->like('taikhoan.HoTen', $searchTerm)
                ->orLike('giamthi.MaGT', $searchTerm)
                ->groupEnd();
        }
        $supervisorList = $GiamThi->findAll();
        return view('director/employee/supervisor/list', [
            'supervisorList' => $supervisorList,
            'searchTerm' => $searchTerm,
        ]);
    }

    public function employeeSupervisorAdd()
    {
        $GiamThiModel = new GiamThiModel();

        // Lấy mã giám thị lớn nhất hiện tại
        $lastSupervisor = $GiamThiModel->select('MaGT')->orderBy('MaGT', 'DESC')->first();

        // Sinh mã giám thị mới
        $newMaGT = 'GT0001'; // Giá trị mặc định nếu chưa có mã nào
        if ($lastSupervisor && preg_match('/^GT(\d+)$/', $lastSupervisor['MaGT'], $matches)) {
            $newIndex = (int)$matches[1] + 1;
            $newMaGT = 'GT' . str_pad($newIndex, 4, '0', STR_PAD_LEFT);
        }
        return view('director/employee/supervisor/add', ['newMaGT' => $newMaGT]);
    }

    // public function addEmployeeSupervisor()
    // {
    //     $errors = [];
    //     // Lấy dữ liệu từ form
    //     $birthday = $this->request->getPost('supervisor_birthday');
    //     $email = $this->request->getPost('supervisor_email');
    //     $password = $this->request->getPost('supervisor_password');
    //     $phone = $this->request->getPost('supervisor_phone');
    //     $gender = $this->request->getPost('supervisor_gender');

    //     //Kiểm tra giới tính
    //     if (empty($gender)) {
    //         $errors['cashier_gender'] = 'Vui lòng chọn giới tính.';
    //     }

    //     // Kiểm tra ngày sinh
    //     if (strtotime($birthday) > strtotime(date('Y-m-d'))) {
    //         $errors['cashier_birthday'] = 'Ngày sinh không hợp lệ.';
    //     }

    //     if (empty($birthday)) {
    //         $errors['cashier_birthday'] = 'Vui lòng nhập ngày sinh.';
    //     }

    //     // Kiểm tra email
    //     if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    //         $errors['cashier_email'] = 'Email không đúng định dạng.';
    //     }

    //     // Kiểm tra mật khẩu
    //     if (strlen($password) < 6) {
    //         $errors['cashier_password'] = 'Mật khẩu phải có ít nhất 6 ký tự.';
    //     }

    //     // Kiểm tra số điện thoại
    //     if (!preg_match('/^\d{10}$/', $phone)) {
    //         $errors['cashier_phone'] = 'Số điện thoại phải có đúng 10 chữ số.';
    //     }

    //     // Nếu có lỗi, trả về cùng thông báo
    //     if (!empty($errors)) {
    //         return redirect()->back()->withInput()->with('errors', $errors);
    //     }

    //     $TaiKhoanModel = new TaiKhoanModel();
    //     $GiamThiModel = new GiamThiModel();

    //     $MaTK = $TaiKhoanModel->insert([
    //         'TenTK' => $this->request->getPost('supervisor_account'),
    //         'MatKhau' => $this->request->getPost('supervisor_password'),
    //         'Email' => $this->request->getPost('supervisor_email'),
    //         'HoTen' => $this->request->getPost('supervisor_name'),
    //         'SoDienThoai' => $this->request->getPost('supervisor_phone'),
    //         'DiaChi' => $this->request->getPost('supervisor_address'),
    //         'GioiTinh' => $this->request->getPost('supervisor_gender'),
    //         'NgaySinh' => $this->request->getPost('supervisor_birthday'),
    //         'MaVT' => 5, // Mã vai trò giám thị
    //     ]);

    //     // Lưu thông tin giám thị
    //     $GiamThiModel->insert([
    //         'MaTK' => $MaTK,
    //         'TinhTrang' => $this->request->getPost('supervisor_status') ?? 'Đang làm việc',
    //     ]);

    //     return redirect()->to('director/employee/supervisor/list')->with('success', 'Thêm giám thị thành công!');
    // }

    public function addEmployeeSupervisor()
    {
        log_message('info', 'Bắt đầu tạo tài khoản giám thị mới.');

        // Lấy thông tin từ form
        $info = [
            'account' => $this->request->getPost('supervisor_account'),
            'password' => $this->request->getPost('supervisor_password'),
            'name' => $this->request->getPost('supervisor_name'),
            'email' => $this->request->getPost('supervisor_email'),
            'phone' => $this->request->getPost('supervisor_phone'),
            'address' => $this->request->getPost('supervisor_address'),
            'gender' => $this->request->getPost('supervisor_gender'),
            'birthday' => $this->request->getPost('supervisor_birthday'),
            'role' => $this->request->getPost('supervisor_role') ?? 'giám thị',
            'status' => $this->request->getPost('supervisor_status') ?? 'Đang làm việc',
        ];

        // Gọi hàm validate chung (nên tái sử dụng từ teacher hoặc đặt tên lại là validateUser)
        $errors = $this->validateUser($info);
        if (!empty($errors)) {
            return redirect()->back()->withInput()->with('errors', $errors);
        }

        // Lấy Factory phù hợp với vai trò
        $factory = getFactoryByRole($info['role'], $info);
        if (!$factory) {
            return redirect()->back()->with('error', 'Không xác định được vai trò người dùng.');
        }

        // Tạo đối tượng user và lưu vào DB
        $supervisor = $factory->createUser();
        if (!$supervisor->createAndSave()) {
            return redirect()->back()->with('error', 'Tạo tài khoản giám thị thất bại.');
        }

        log_message('info', 'Tài khoản giám thị được tạo: ' . $supervisor->getInfo() . ' - Vai trò: ' . $supervisor->getRole());

        return redirect()->to('director/employee/supervisor/list')->with('success', 'Thêm giám thị thành công!');
    }

    private function validateUser($info)
    {
        $errors = [];

        if (empty($info['gender'])) {
            $errors['gender'] = 'Vui lòng chọn giới tính.';
        }

        if (empty($info['birthday'])) {
            $errors['birthday'] = 'Vui lòng nhập ngày sinh.';
        } elseif (strtotime($info['birthday']) > strtotime(date('Y-m-d'))) {
            $errors['birthday'] = 'Ngày sinh không hợp lệ.';
        }

        if (!filter_var($info['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Email không đúng định dạng.';
        }

        if (strlen($info['password']) < 6) {
            $errors['password'] = 'Mật khẩu phải có ít nhất 6 ký tự.';
        }

        if (!preg_match('/^\d{10}$/', $info['phone'])) {
            $errors['phone'] = 'Số điện thoại phải có đúng 10 chữ số.';
        }

        return $errors;
    }

    public function employeeSupervisorUpdate($MaGT)
    {
        $GiamThiModel = new GiamThiModel();
        $TaiKhoanModel = new TaiKhoanModel();

        // Lấy thông tin giám thị theo mã
        $GiamThi = $GiamThiModel
            ->select('giamthi.*, taikhoan.*')
            ->join('taikhoan', 'taikhoan.MaTK = giamthi.MaTK')
            ->where('giamthi.MaGT', $MaGT)
            ->first();

        if (!$GiamThi) {
            return redirect()->back()->with('error', 'Không tìm thấy giám thị.');
        }
        return view('director/employee/supervisor/update', ['supervisor' => $GiamThi]);
    }

    public function updateEmployeeSupervisor()
    {
        $errors = [];
        // Lấy dữ liệu từ form
        $MaGT = $this->request->getPost('MaGT');
        $MaTK = $this->request->getPost('MaTK');
        $birthday = $this->request->getPost('supervisor_birthday');
        $email = $this->request->getPost('supervisor_email');
        $password = $this->request->getPost('supervisor_password');
        $phone = $this->request->getPost('supervisor_phone');
        $gender = $this->request->getPost('supervisor_gender');

        //Kiểm tra giới tính
        if (empty($gender)) {
            $errors['cashier_gender'] = 'Vui lòng chọn giới tính.';
        }

        // Kiểm tra ngày sinh
        if (strtotime($birthday) > strtotime(date('Y-m-d'))) {
            $errors['cashier_birthday'] = 'Ngày sinh không hợp lệ.';
        }

        if (empty($birthday)) {
            $errors['cashier_birthday'] = 'Vui lòng nhập ngày sinh.';
        }

        // Kiểm tra email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['cashier_email'] = 'Email không đúng định dạng.';
        }

        // Kiểm tra mật khẩu
        if (strlen($password) < 6) {
            $errors['cashier_password'] = 'Mật khẩu phải có ít nhất 6 ký tự.';
        }

        // Kiểm tra số điện thoại
        if (!preg_match('/^\d{10}$/', $phone)) {
            $errors['cashier_phone'] = 'Số điện thoại phải có đúng 10 chữ số.';
        }

        // Nếu có lỗi, trả về cùng thông báo
        if (!empty($errors)) {
            return redirect()->back()->withInput()->with('errors', $errors);
        }

        $GiamThiModel = new GiamThiModel();
        $TaiKhoanModel = new TaiKhoanModel();

        // Cập nhật thông tin tài khoản
        $TaiKhoanModel->update($MaTK, [
            'TenTK' => $this->request->getPost('supervisor_account'),
            'MatKhau' => $this->request->getPost('supervisor_password'),
            'HoTen' => $this->request->getPost('supervisor_name'),
            'Email' => $this->request->getPost('supervisor_email'),
            'SoDienThoai' => $this->request->getPost('supervisor_phone'),
            'DiaChi' => $this->request->getPost('supervisor_address'),
            'GioiTinh' => $this->request->getPost('supervisor_gender'),
            'NgaySinh' => $this->request->getPost('supervisor_birthday'),
        ]);

        // Cập nhật thông tin giám thị
        $GiamThiModel->update($MaGT, [
            'TinhTrang' => $this->request->getPost('supervisor_status'),
        ]);

        // Xử lý thông báo
        if ($TaiKhoanModel && $GiamThiModel) {
            return redirect()->to('director/employee/supervisor/list')->with('success', 'Cập nhật giám thị thành công!');
        } else {
            return redirect()->back()->with('errors', 'Không thể cập nhật. Vui lòng thử lại.');
        }
    }

    public function deleteEmployeeSupervisor($MaGT)
    {
        // Kết nối database
        $db = \Config\Database::connect();
        $GiamThiModel = new GiamThiModel();
        $TaiKhoanModel = new TaiKhoanModel();
        $ViPhamModel = new ViPhamModel();

        // Bắt đầu transaction
        $db->transStart();

        try {
            // Lấy thông tin giám thị theo mã MaGT
            $GiamThi = $GiamThiModel->find($MaGT);

            // Kiểm tra giám thị có tồn tại không
            if (!$GiamThi) {
                return redirect()->back()->with('error', 'Không tìm thấy giám thị.');
            }

            // Kiểm tra ràng buộc với bảng ViPham
            if ($ViPhamModel->where('MaGT', $MaGT)->countAllResults() > 0) {
                return redirect()->back()->with('error', 'Không thể xóa giám thị vì đã có ràng buộc dữ liệu.');
            }

            // Xóa giám thị
            if (!$GiamThiModel->delete($MaGT)) {
                throw new \Exception('Xóa giám thị thất bại.');
            }

            // Xóa tài khoản liên kết với giám thị
            if (!$TaiKhoanModel->delete($GiamThi['MaTK'])) {
                throw new \Exception('Xóa tài khoản giám thị thất bại.');
            }

            // Hoàn tất transaction
            $db->transComplete();

            // Kiểm tra trạng thái transaction
            if ($db->transStatus() === false) {
                throw new \Exception('Có lỗi xảy ra khi thực hiện xóa giám thị.');
            }

            return redirect()->back()->with('success', 'Xóa giám thị thành công!');
        } catch (\Exception $e) {
            // Nếu có lỗi, rollback transaction
            $db->transRollback();

            // Hiển thị thông báo lỗi
            return redirect()->back()->with('error', $e->getMessage());
        }
    }



    // Màn hình thông tin cá nhân
    public function profile()
    {
        $BanGiamHieuModel = new BanGiamHieuModel();

        // Lấy thông tin tài khoản hiện tại
        $MaTK = session('MaTK');

        // Lấy thông tin ban giám hiệu
        $BanGiamHieu = $BanGiamHieuModel
            ->select('bangiamhieu.*, taikhoan.*')
            ->join('taikhoan', 'taikhoan.MaTK = bangiamhieu.MaTK')
            ->where('bangiamhieu.MaTK', $MaTK)
            ->first();

        return view('director/profile', [
            'director' => $BanGiamHieu,
        ]);
    }

    public function updateProfile()
    {
        $errors = [];
        // Lấy dữ liệu từ form
        $MaBGH = $this->request->getPost('MaBGH');
        $MaTK = $this->request->getPost('MaTK');
        $email = $this->request->getPost('director_email');
        $phone = $this->request->getPost('director_phone');

        // Kiểm tra email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['director_email'] = 'Email không đúng định dạng.';
        }
        // Kiểm tra số điện thoại
        if (!preg_match('/^\d{10}$/', $phone)) {
            $errors['director_phone'] = 'Số điện thoại phải có đúng 10 chữ số.';
        }
        // Nếu có lỗi, trả về cùng thông báo
        if (!empty($errors)) {
            return redirect()->back()->withInput()->with('errors', $errors);
        }

        $BanGiamHieuModel = new BanGiamHieuModel();
        $TaiKhoanModel = new TaiKhoanModel();

        // Cập nhật thông tin tài khoản
        $TaiKhoanModel->update($MaTK, [
            'Email' => $this->request->getPost('director_email'),
            'SoDienThoai' => $this->request->getPost('director_phone'),
            'DiaChi' => $this->request->getPost('director_address'),
        ]);

        // Xử lý thông báo
        if ($TaiKhoanModel) {
            return redirect()->back()->with('success', 'Cập nhật thông tin thành công!');
        } else {
            return redirect()->back()->with('errors', 'Không thể cập nhật. Vui lòng thử lại.');
        }
    }

    public function changepw()
    {
        return view('director/changepw');
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
            $errors['old_pw'] = 'Mật khẩu cũ không chính xác.';
        }

        // Kiểm tra mật khẩu mới
        if (strlen($newPassword) < 6) {
            $errors['new_pw'] = 'Mật khẩu mới phải có ít nhất 6 ký tự.';
        }

        // Kiểm tra mật khẩu xác nhận
        if ($newPassword !== $confirmPassword) {
            $errors['confirm_pw'] = 'Mật khẩu xác nhận không khớp.';
        }

        // Nếu có lỗi, trả về cùng thông báo
        if (!empty($errors)) {
            return redirect()->back()->withInput()->with('errors', $errors);
        }

        // Cập nhật mật khẩu mới
        $TaiKhoanModel->update($MaTK, [
            'MatKhau' => $this->request->getPost('new_pw'),
        ]);

        return redirect()->back()->with('success', 'Đổi mật khẩu thành công!');
    }

    // Màn hình quản lý thu ngân
    public function employeeCashierList()
    {
        $ThuNganModel = new ThuNganModel();

        // Nhận giá trị tìm kiếm từ query string
        $searchTerm = $this->request->getVar('search') ?? '';

        // Tạo query lấy danh sách thu ngân
        $ThuNgan = $ThuNganModel
            ->select('thungan.*, taikhoan.*')
            ->join('taikhoan', 'taikhoan.MaTK = thungan.MaTK');

        // Nếu có từ khóa tìm kiếm, áp dụng bộ lọc
        if ($searchTerm) {
            $ThuNgan->groupStart()
                ->like('taikhoan.HoTen', $searchTerm)
                ->orLike('thungan.MaTN', $searchTerm)
                ->groupEnd();
        }
        $cashierList = $ThuNgan->findAll();

        return view('director/employee/cashier/list', [
            'cashierList' => $cashierList,
            'searchTerm' => $searchTerm,
        ]);
    }
    public function employeeCashierAdd()
    {
        $ThuNganModel = new ThuNganModel();

        // Lấy mã thu ngân lớn nhất hiện tại
        $lastCashier = $ThuNganModel->select('MaTN')->orderBy('MaTN', 'DESC')->first();

        // Sinh mã thu ngân mới
        $newMaTN = 'TN0001'; // Giá trị mặc định nếu chưa có mã nào
        if ($lastCashier && preg_match('/^TN(\d+)$/', $lastCashier['MaTN'], $matches)) {
            $newIndex = (int)$matches[1] + 1;
            $newMaTN = 'TN' . str_pad($newIndex, 4, '0', STR_PAD_LEFT);
        }

        return view('director/employee/cashier/add', ['newMaTN' => $newMaTN]);
    }

    // public function addEmployeeCashier()
    // {
    //     $errors = [];
    //     // Lấy dữ liệu từ form
    //     $birthday = $this->request->getPost('cashier_birthday');
    //     $email = $this->request->getPost('cashier_email');
    //     $password = $this->request->getPost('cashier_password');
    //     $phone = $this->request->getPost('cashier_phone');
    //     $gender = $this->request->getPost('cashier_gender');

    //     //Kiểm tra giới tính
    //     if (empty($gender)) {
    //         $errors['cashier_gender'] = 'Vui lòng chọn giới tính.';
    //     }

    //     // Kiểm tra ngày sinh
    //     if (strtotime($birthday) > strtotime(date('Y-m-d'))) {
    //         $errors['cashier_birthday'] = 'Ngày sinh không hợp lệ.';
    //     }

    //     if (empty($birthday)) {
    //         $errors['cashier_birthday'] = 'Vui lòng nhập ngày sinh.';
    //     }

    //     // Kiểm tra email
    //     if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    //         $errors['cashier_email'] = 'Email không đúng định dạng.';
    //     }

    //     // Kiểm tra mật khẩu
    //     if (strlen($password) < 6) {
    //         $errors['cashier_password'] = 'Mật khẩu phải có ít nhất 6 ký tự.';
    //     }

    //     // Kiểm tra số điện thoại
    //     if (!preg_match('/^\d{10}$/', $phone)) {
    //         $errors['cashier_phone'] = 'Số điện thoại phải có đúng 10 chữ số.';
    //     }

    //     // Nếu có lỗi, trả về cùng thông báo
    //     if (!empty($errors)) {
    //         return redirect()->back()->withInput()->with('errors', $errors);
    //     }

    //     $TaiKhoanModel = new TaiKhoanModel();
    //     $ThuNganModel = new ThuNganModel();

    //     $MaTK = $TaiKhoanModel->insert([
    //         'TenTK' => $this->request->getPost('cashier_account'),
    //         'MatKhau' => $this->request->getPost('cashier_password'),
    //         'Email' => $this->request->getPost('cashier_email'),
    //         'HoTen' => $this->request->getPost('cashier_name'),
    //         'SoDienThoai' => $this->request->getPost('cashier_phone'),
    //         'DiaChi' => $this->request->getPost('cashier_address'),
    //         'GioiTinh' => $this->request->getPost('cashier_gender'),
    //         'NgaySinh' => $this->request->getPost('cashier_birthday'),
    //         'MaVT' => 4, // Mã vai trò thu ngân
    //     ]);

    //     // Lưu thông tin thu ngân
    //     $ThuNganModel->insert([
    //         'MaTK' => $MaTK,
    //         'TinhTrang' => $this->request->getPost('cashier_status') ?? 'Đang làm việc',
    //     ]);

    //     return redirect()->to('director/employee/cashier/list')->with('success', 'Thêm thu ngân thành công!');
    // }

    public function addEmployeeCashier()
    {
        log_message('info', 'Bắt đầu tạo tài khoản thu ngân mới.');

        $info = [
            'account' => $this->request->getPost('cashier_account'),
            'password' => $this->request->getPost('cashier_password'),
            'name' => $this->request->getPost('cashier_name'),
            'email' => $this->request->getPost('cashier_email'),
            'phone' => $this->request->getPost('cashier_phone'),
            'address' => $this->request->getPost('cashier_address'),
            'gender' => $this->request->getPost('cashier_gender'),
            'birthday' => $this->request->getPost('cashier_birthday'),
            'role' => 'thu ngân',
            'status' => $this->request->getPost('cashier_status') ?? 'Đang làm việc',
        ];

        // Gọi hàm validate riêng
        $errors = $this->validateCashier($info);
        if (!empty($errors)) {
            return redirect()->back()->withInput()->with('errors', $errors);
        }

        // Gọi factory method theo vai trò
        $factory = getFactoryByRole('thu ngân', $info);
        if (!$factory) {
            return redirect()->back()->with('error', 'Không xác định được vai trò người dùng.');
        }

        $cashier = $factory->createUser();
        if (!$cashier->createAndSave()) {
            return redirect()->back()->with('error', 'Tạo tài khoản thu ngân thất bại.');
        }

        log_message('info', 'Tài khoản thu ngân được tạo: ' . $cashier->getInfo() . ' - Vai trò: ' . $cashier->getRole());

        return redirect()->to('director/employee/cashier/list')->with('success', 'Thêm thu ngân thành công!');
    }

    protected function validateCashier($info)
    {
        $errors = [];

        if (empty($info['gender'])) {
            $errors['cashier_gender'] = 'Vui lòng chọn giới tính.';
        }

        if (empty($info['birthday'])) {
            $errors['cashier_birthday'] = 'Vui lòng nhập ngày sinh.';
        } elseif (strtotime($info['birthday']) > strtotime(date('Y-m-d'))) {
            $errors['cashier_birthday'] = 'Ngày sinh không hợp lệ.';
        }

        if (!filter_var($info['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['cashier_email'] = 'Email không đúng định dạng.';
        }

        if (strlen($info['password']) < 6) {
            $errors['cashier_password'] = 'Mật khẩu phải có ít nhất 6 ký tự.';
        }

        if (!preg_match('/^\d{10}$/', $info['phone'])) {
            $errors['cashier_phone'] = 'Số điện thoại phải có đúng 10 chữ số.';
        }

        return $errors;
    }



    public function employeeCashierUpdate($MaTN)
    {
        $ThuNganModel = new ThuNganModel();
        $TaiKhoanModel = new TaiKhoanModel();

        // Lấy thông tin Thu ngân dựa vào MaTN
        $ThuNgan = $ThuNganModel
            ->select('thungan.*, taikhoan.*')
            ->join('taikhoan', 'taikhoan.MaTK = thungan.MaTK')
            ->where('thungan.MaTN', $MaTN)
            ->first();

        if (!$ThuNgan) {
            return redirect()->back()->with('error', 'Không tìm thấy thông tin Thu ngân.');
        }
        return view('director/employee/cashier/update', ['cashier' => $ThuNgan]);
    }


    public function updateEmployeeCashier($MaTN)
    {
        $ThuNganModel = new ThuNganModel();
        $TaiKhoanModel = new TaiKhoanModel();

        $errors = [];
        // Lấy dữ liệu từ form
        $MaTN = $this->request->getPost('MaTN');
        $MaTK = $this->request->getPost('MaTK');
        $birthday = $this->request->getPost('cashier_birthday');
        $email = $this->request->getPost('cashier_email');
        $password = $this->request->getPost('cashier_password');
        $phone = $this->request->getPost('cashier_phone');
        $gender = $this->request->getPost('cashier_gender');
        $status = $this->request->getPost('cashier_status');

        log_message('debug', 'Dữ liệu Tình trạng nhận được: ' . print_r($status, true));

        //Kiểm tra giới tính
        if (empty($gender)) {
            $errors['cashier_gender'] = 'Vui lòng chọn giới tính.';
        }

        // Kiểm tra ngày sinh
        if (strtotime($birthday) > strtotime(date('Y-m-d'))) {
            $errors['cashier_birthday'] = 'Ngày sinh không hợp lệ.';
        }

        if (empty($birthday)) {
            $errors['cashier_birthday'] = 'Vui lòng nhập ngày sinh.';
        }

        // Kiểm tra email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['cashier_email'] = 'Email không đúng định dạng.';
        }

        // Kiểm tra mật khẩu
        if (strlen($password) < 6) {
            $errors['cashier_password'] = 'Mật khẩu phải có ít nhất 6 ký tự.';
        }

        // Kiểm tra số điện thoại
        if (!preg_match('/^\d{10}$/', $phone)) {
            $errors['cashier_phone'] = 'Số điện thoại phải có đúng 10 chữ số.';
        }

        // Nếu có lỗi, trả về cùng thông báo
        if (!empty($errors)) {
            return redirect()->back()->withInput()->with('errors', $errors);
        }

        // Cập nhật thông tin tài khoản
        $TaiKhoanModel->update($MaTK, [
            'HoTen' => $this->request->getPost('cashier_name'),
            'Email' => $this->request->getPost('cashier_email'),
            'SoDienThoai' => $this->request->getPost('cashier_phone'),
            'DiaChi' => $this->request->getPost('cashier_address'),
            'GioiTinh' => $this->request->getPost('cashier_gender'),
            'NgaySinh' => $this->request->getPost('cashier_birthday'),
        ]);


        // Cập nhật thông tin thu ngân
        $ThuNganModel->update($MaTN, [
            'TinhTrang' => $this->request->getPost('cashier_status'),
        ]);

        // Xử lý thông báo
        if ($TaiKhoanModel && $ThuNganModel) {
            return redirect()->to('director/employee/cashier/list')->with('success', 'Cập nhật thu ngân thành công!');
        } else {
            return redirect()->back()->with('errors', 'Không thể cập nhật. Vui lòng thử lại.');
        }
    }

    public function deleteEmployeeCashier($MaTN)
    {
        $db = \Config\Database::connect();
        $ThuNganModel = new ThuNganModel();
        $TaiKhoanModel = new TaiKhoanModel();
        $HoaDonModel = new HoaDonModel();
        $PhieuThanhToanModel = new ThanhToanModel;

        // Bắt đầu transaction
        $db->transStart();

        try {
            // Kiểm tra thu ngân có tồn tại không
            $ThuNgan = $ThuNganModel->find($MaTN);
            if (!$ThuNgan) {
                return redirect()->back()->with('error', 'Không tìm thấy thông tin thu ngân.');
            }

            // Kiểm tra ràng buộc với bảng PHIEUTHANHTOAN
            $isBound = $PhieuThanhToanModel->where('MaTN', $MaTN)->countAllResults();
            if ($isBound > 0) {
                return redirect()->back()->with('error', 'Không thể xóa thu ngân vì đã có ràng buộc dữ liệu trong bảng PHIEUTHANHTOAN.');
            }

            // Xóa thu ngân
            if (!$ThuNganModel->delete($MaTN)) {
                throw new \Exception('Xóa thu ngân thất bại.');
            }

            // Xóa tài khoản liên kết với thu ngân
            if (!$TaiKhoanModel->delete($ThuNgan['MaTK'])) {
                throw new \Exception('Xóa tài khoản thu ngân thất bại.');
            }

            // Hoàn tất transaction
            $db->transComplete();

            // Kiểm tra trạng thái transaction
            if ($db->transStatus() === false) {
                throw new \Exception('Có lỗi xảy ra khi thực hiện xóa thu ngân.');
            }

            return redirect()->back()->with('success', 'Xóa thu ngân thành công!');
        } catch (\Exception $e) {
            // Nếu có lỗi, rollback transaction
            $db->transRollback();

            // Hiển thị thông báo lỗi
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
