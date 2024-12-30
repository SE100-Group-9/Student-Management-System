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
        return view('teacher/statics/grade');
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
                'yearList' => [], 'classList' => [], 'studentList' => [],
                'selectedYear' => '', 'selectedSemester' => '', 'selectedClass' => ''

            ]);
        }
        $selectedYear = $this->request->getVar('year') ?? $yearList[0];

        // Lấy danh sách lớp học mà giáo viên đã phân công dạy dựa vào mã giáo viên, năm học và học kỳ
        $classList = $PhanCongModel->getAssignedClassesBySemester($MaGV, $selectedYear, $semesterNumber);
        $classList = array_column($classList, 'TenLop');
        if (empty($classList)) {
            return view('teacher/class/rate', [
                'error' => "Bạn chưa được phân công dạy trong học kỳ $semesterNumber năm học $yearList[0].",
                'yearList' => $yearList, 'classList' => [], 'studentList' => [],
                'selectedYear' => $selectedYear, 'selectedSemester' => $selectedSemester, 'selectedClass' => ''
            ]);
        }
        $selectedClass = $this->request->getVar('class') ?? $classList[0];


        // Lấy nhận xét của giáo viên về học sinh
        $DiemModel = new DiemModel();
        $studentList = $DiemModel->getTeacherComment($MaGV, $selectedClass, $semesterNumber, $selectedYear);

        return view('teacher/class/rate', [
            'error' => null,
            'yearList' => $yearList, 'classList' => $classList,
            'selectedYear' => $selectedYear ?? '', 'selectedSemester' => $selectedSemester, 'selectedClass' => $selectedClass,
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

    public function recordDetail()
    {
        return view('teacher/class/record/detail');
    }

    public function recordList()
    {
        return view('teacher/class/record/list');
    }

    public function enterList()
    {
        return view('teacher/class/enter/list');
    }

    public function enterNext()
    {
        return view('teacher/class/enter/next');
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
