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

class DirectorController extends Controller
{

    public function staticsConduct()
    {
        return view('director/statics/conduct');
    }

    public function staticsGrade()
    {
        return view('director/statics/grade');
    }

    public function staticsStudent()
    {
        return view('director/statics/student');
    }

    public function exportStudentList()
    {
 
    }
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

    public function addStudent()
    {
        $errors = [];
        // Lấy dữ liệu từ form
        $birthday = $this->request->getPost('student_birthday');
        $email = $this->request->getPost('student_email');
        $password = $this->request->getPost('student_password');
        $phone = $this->request->getPost('student_phone');
        $gender = $this->request->getPost('student_gender');
        //Kiểm tra giới tính
        if (empty($gender)) 
            $errors['student_gender'] = 'Vui lòng chọn giới tính.';

        // Kiểm tra ngày sinh
        if (strtotime($birthday) > strtotime(date('Y-m-d'))) 
            $errors['student_birthday'] = 'Ngày sinh không hợp lệ.';
        
        if (empty($birthday)) 
            $errors['student_birthday'] = 'Vui lòng nhập ngày sinh.';
        
        // Kiểm tra email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
            $errors['student_email'] = 'Email không đúng định dạng.';
        
        // Kiểm tra mật khẩu
        if (strlen($password) < 6)
            $errors['student_password'] = 'Mật khẩu phải có ít nhất 6 ký tự.';
        
        // Kiểm tra số điện thoại
        if (!preg_match('/^\d{10}$/', $phone)) 
            $errors['student_phone'] = 'Số điện thoại phải có đúng 10 chữ số.';
        
        // Nếu có lỗi, trả về cùng thông báo
        if (!empty($errors)) {
            return redirect()->back()->withInput()->with('errors', $errors);
        }



        $TaiKhoanModel = new TaiKhoanModel();
        $HocSinhModel = new HocSinhModel();
        $HocSinhLopModel = new HocSinhLopModel();

        $MaTK = $TaiKhoanModel->insert([
            'TenTK' => $this->request->getPost('student_account'),
            'MatKhau' => $this->request->getPost('student_password'),
            'HoTen' => $this->request->getPost('student_name'),
            'Email' => $this->request->getPost('student_email'),
            'SoDienThoai' => $this->request->getPost('student_phone'),
            'DiaChi' => $this->request->getPost('student_address'),
            'GioiTinh' => $this->request->getPost('student_gender'),
            'NgaySinh' => $this->request->getPost('student_birthday'),
            'MaVT' => 3, // Mã vai trò học sinh
        ]);
        // Lưu thông tin học sinh
        $MaHS = $HocSinhModel->insert([
            'MaTK' => $MaTK,
            'DanToc' => $this->request->getPost('student_nation'),
            'NoiSinh' => $this->request->getPost('student_country'),
            'TinhTrang' => $this->request->getPost('student_status') ?? 'Mới tiếp nhận',
        ]);

        $allPostData = $this->request->getPost();
        log_message('info', 'Received Data: ' . json_encode($allPostData));
        return redirect()->back()->with('success', 'Thêm học sinh mới thành công!');
    }

    public function studentUpdate($id = null)
    {
        if ($id === null) {
            return redirect()->to('director/student/list'); // Redirect nếu không có id
        }
        $TaiKhoanModel = new TaiKhoanModel();
        $HocSinhModel = new HocSinhModel();
        $HocSinhLopModel = new HocSinhLopModel();
        $LopModel = new LopModel();
        // Lấy thông tin học sinh theo id
        $data = $HocSinhModel
            ->select('hocsinh.*, taikhoan.*, hocsinh_lop.*, lop.TenLop')
            ->join('taikhoan', 'taikhoan.MaTK = hocsinh.MaTK')
            ->join('hocsinh_lop', 'hocsinh.MaHS = hocsinh_lop.MaHS', 'left')
            ->join('lop', 'lop.MaLop = hocsinh_lop.MaLop', 'left')
            ->where('hocsinh.MaHS', $id)
            ->first();
        if (!$data) {
            return redirect()->to('director/student/list'); // Redirect nếu không tìm thấy học sinh
        }    
        return view('director/student/update', ['student' => $data]);
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
        //Kiểm tra giới tính
        if (empty($gender)) 
            $errors['student_gender'] = 'Vui lòng chọn giới tính.';

        // Kiểm tra ngày sinh
        if (strtotime($birthday) > strtotime(date('Y-m-d'))) 
            $errors['student_birthday'] = 'Ngày sinh không hợp lệ.';
        
        if (empty($birthday)) 
            $errors['student_birthday'] = 'Vui lòng nhập ngày sinh.';
        
        // Kiểm tra email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
            $errors['student_email'] = 'Email không đúng định dạng.';
        
        // Kiểm tra mật khẩu
        if (strlen($password) < 6)
            $errors['student_password'] = 'Mật khẩu phải có ít nhất 6 ký tự.';
        
        // Kiểm tra số điện thoại
        if (!preg_match('/^\d{10}$/', $phone)) 
            $errors['student_phone'] = 'Số điện thoại phải có đúng 10 chữ số.';
        
        // Nếu có lỗi, trả về cùng thông báo
        if (!empty($errors)) {
            return redirect()->back()->withInput()->with('errors', $errors);
        }



        $TaiKhoanModel = new TaiKhoanModel();
        $HocSinhModel = new HocSinhModel();



        $TaiKhoanModel->update($MaTK, [
            'TenTK' => $this->request->getPost('student_account'),
            'MatKhau' => $this->request->getPost('student_password'),
            'HoTen' => $this->request->getPost('student_name'),
            'Email' => $this->request->getPost('student_email'),
            'SoDienThoai' => $this->request->getPost('student_phone'),
            'DiaChi' => $this->request->getPost('student_address'),
            'GioiTinh' => $this->request->getPost('student_gender'),
            'NgaySinh' => $this->request->getPost('student_birthday'),
        ]);

        $HocSinhModel->update($MaHS, [
            'DanToc' => $this->request->getPost('student_nation'),
            'NoiSinh' => $this->request->getPost('student_country'),
            'TinhTrang' => $this->request->getPost('student_status'),
        ]);
        $allPostData = $this->request->getPost();
        log_message('info', 'Received Data: ' . json_encode($allPostData));
            // Xử lý thông báo
        if ($TaiKhoanModel && $HocSinhModel) {
            return redirect()->back()->with('success', 'Cập nhật thành công!');
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
            ->orderBy('NamHoc', 'ASC')
            ->findAll();
        // Lấy các giá trị của trường 'NamHoc' từ mảng $yearListArray
        $yearList = array_map(function($year) {
            return $year['NamHoc']; // Lấy giá trị NamHoc
        }, $yearListArray);
        $yearList = array_merge(['Chọn năm học'], $yearList);
        $statusList = ['Chọn trạng thái', 'Đang học', 'Mới tiếp nhận', 'Nghỉ học'];

        log_message('debug', 'Class List: ' . print_r($classList, true));
        log_message('debug', 'Class List: ' . print_r($yearList, true));

        $query = $HocSinhModel
        ->select('hocsinh.*, taikhoan.*, hocsinh_lop.MaLop, lop.TenLop')
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
        if ($selectedStatus && $selectedStatus !== 'Chọn trạng thái'){
            $query->where('hocsinh.TinhTrang', $selectedStatus);
        }

        $studentList  = $query->findAll();

        return view('director/student/list', [
            'studentlist' => $studentList ,
            'yearList' => $yearList,
            'classList' => $classList,
            'statusList' => $statusList,
            'selectedYear' => $selectedYear,
            'selectedClass' => $selectedClass,
            'selectedStatus' => $selectedStatus,
            'searchTerm' => $searchStudent,
        ]);
    }

    public function studentPayment()
    {
        return view('director/student/payment');
    }

    public function studentPerserved()
    {
        return view('director/student/perserved');
    }

    public function studentRecord()
    {
        return view('director/student/record');
    }

    //Màn hình Danh hiệu
    public function titleList()
    {
        $DanhHieuModel = new DanhHieuModel();

        // Nhận giá trị từ khóa tìm kiếm từ query string
        $searchTerm = $this->request->getVar('search') ?? '';

        //Nếu có từ khóa tìm kiếm, áp dụng bộ lọc
        if ($searchTerm) {
            $DanhHieuModel->like('TenDH', $searchTerm);
        }

        // Lấy danh sách danh hiệu và sắp xếp theo DiemTBToiThieu giảm dần
        $titleList = $DanhHieuModel->orderBy('DiemTBToiThieu', 'DESC')->findAll();

        // Truyền dữ liệu tới view
        return view('director/title/list', [
            'titleList' => $titleList,
            'searchTerm' => $searchTerm,
        ]);
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
            return redirect()->back()->with('success', 'Danh hiệu đã được thêm thành công!');
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
            return redirect()->back()->with('success', 'Cập nhật danh hiệu thành công!');
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


    public function classList()
    {
        return view('director/class/list');
    }

    public function classAdd()
    {
        return view('director/class/add');
    }
    public function classUpdate()
    {
        return view('director/class/update');
    }

    public function classArrangeStudent()
    {
        return view('director/class/arrange/student');
    }

    public function classArrangeTeacher()
    {
        return view('director/class/arrange/teacher');
    }

    public function employeeTeacherList ()
    {
        return view('director/employee/teacher/list');
    }

    public function employeeTeacherAdd()
    {
        return view('director/employee/teacher/add');
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

    public function addEmployeeSupervisor()
    {
        $errors = [];
        // Lấy dữ liệu từ form
        $birthday = $this->request->getPost('supervisor_birthday');
        $email = $this->request->getPost('supervisor_email');
        $password = $this->request->getPost('supervisor_password');
        $phone = $this->request->getPost('supervisor_phone');
        $gender = $this->request->getPost('supervisor_gender');

        //Kiểm tra giới tính
        if (empty($gender)) 
            $errors['cashier_gender'] = 'Vui lòng chọn giới tính.';

        // Kiểm tra ngày sinh
        if (strtotime($birthday) > strtotime(date('Y-m-d'))) 
            $errors['cashier_birthday'] = 'Ngày sinh không hợp lệ.';
        
        if (empty($birthday)) 
            $errors['cashier_birthday'] = 'Vui lòng nhập ngày sinh.';
        
        // Kiểm tra email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
            $errors['cashier_email'] = 'Email không đúng định dạng.';
        
        // Kiểm tra mật khẩu
        if (strlen($password) < 6)
            $errors['cashier_password'] = 'Mật khẩu phải có ít nhất 6 ký tự.';
        
        // Kiểm tra số điện thoại
        if (!preg_match('/^\d{10}$/', $phone)) 
            $errors['cashier_phone'] = 'Số điện thoại phải có đúng 10 chữ số.';
        
        // Nếu có lỗi, trả về cùng thông báo
        if (!empty($errors)) {
            return redirect()->back()->withInput()->with('errors', $errors);
        }

        $TaiKhoanModel = new TaiKhoanModel();
        $GiamThiModel = new GiamThiModel();

        $MaTK = $TaiKhoanModel->insert([
            'TenTK' => $this->request->getPost('supervisor_account'),
            'MatKhau' => $this->request->getPost('supervisor_password'),
            'Email' => $this->request->getPost('supervisor_email'),
            'HoTen' => $this->request->getPost('supervisor_name'),
            'SoDienThoai' => $this->request->getPost('supervisor_phone'),
            'DiaChi' => $this->request->getPost('supervisor_address'),
            'GioiTinh' => $this->request->getPost('supervisor_gender'),
            'NgaySinh' => $this->request->getPost('supervisor_birthday'),
            'MaVT' => 5, // Mã vai trò giám thị
        ]);

        // Lưu thông tin giám thị
        $GiamThiModel->insert([
            'MaTK' => $MaTK,
            'TinhTrang' => $this->request->getPost('supervisor_status')?? 'Đang làm việc',
        ]);

        return redirect()->back()->with('success', 'Thêm giám thị mới thành công!');

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
        if (empty($gender)) 
            $errors['cashier_gender'] = 'Vui lòng chọn giới tính.';

        // Kiểm tra ngày sinh
        if (strtotime($birthday) > strtotime(date('Y-m-d'))) 
            $errors['cashier_birthday'] = 'Ngày sinh không hợp lệ.';
        
        if (empty($birthday)) 
            $errors['cashier_birthday'] = 'Vui lòng nhập ngày sinh.';
        
        // Kiểm tra email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
            $errors['cashier_email'] = 'Email không đúng định dạng.';
        
        // Kiểm tra mật khẩu
        if (strlen($password) < 6)
            $errors['cashier_password'] = 'Mật khẩu phải có ít nhất 6 ký tự.';
        
        // Kiểm tra số điện thoại
        if (!preg_match('/^\d{10}$/', $phone)) 
            $errors['cashier_phone'] = 'Số điện thoại phải có đúng 10 chữ số.';
        
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
            return redirect()->back()->with('success', 'Cập nhật thông tin thành công!');
        } else {
            return redirect()->back()->with('errors', 'Không thể cập nhật. Vui lòng thử lại.');
        }
        
    }


    public function profile()
    {
        return view('director/profile');
    }

    public function changepw()
    {
        return view('director/changepw');
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

    public function addEmployeeCashier()
    {
        $errors = [];
        // Lấy dữ liệu từ form
        $birthday = $this->request->getPost('cashier_birthday');
        $email = $this->request->getPost('cashier_email');
        $password = $this->request->getPost('cashier_password');
        $phone = $this->request->getPost('cashier_phone');
        $gender = $this->request->getPost('cashier_gender');
        
        //Kiểm tra giới tính
        if (empty($gender)) 
            $errors['cashier_gender'] = 'Vui lòng chọn giới tính.';

        // Kiểm tra ngày sinh
        if (strtotime($birthday) > strtotime(date('Y-m-d'))) 
            $errors['cashier_birthday'] = 'Ngày sinh không hợp lệ.';
        
        if (empty($birthday)) 
            $errors['cashier_birthday'] = 'Vui lòng nhập ngày sinh.';
        
        // Kiểm tra email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
            $errors['cashier_email'] = 'Email không đúng định dạng.';
        
        // Kiểm tra mật khẩu
        if (strlen($password) < 6)
            $errors['cashier_password'] = 'Mật khẩu phải có ít nhất 6 ký tự.';
        
        // Kiểm tra số điện thoại
        if (!preg_match('/^\d{10}$/', $phone)) 
            $errors['cashier_phone'] = 'Số điện thoại phải có đúng 10 chữ số.';
        
        // Nếu có lỗi, trả về cùng thông báo
        if (!empty($errors)) {
            return redirect()->back()->withInput()->with('errors', $errors);
        }

        $TaiKhoanModel = new TaiKhoanModel();
        $ThuNganModel = new ThuNganModel();

        $MaTK = $TaiKhoanModel->insert([
            'TenTK' => $this->request->getPost('cashier_account'),
            'MatKhau' => $this->request->getPost('cashier_password'),
            'Email' => $this->request->getPost('cashier_email'),
            'HoTen' => $this->request->getPost('cashier_name'),
            'SoDienThoai' => $this->request->getPost('cashier_phone'),
            'DiaChi' => $this->request->getPost('cashier_address'),
            'GioiTinh' => $this->request->getPost('cashier_gender'),
            'NgaySinh' => $this->request->getPost('cashier_birthday'),
            'MaVT' => 4, // Mã vai trò thu ngân
        ]);

        // Lưu thông tin thu ngân
        $ThuNganModel->insert([
            'MaTK' => $MaTK,
            'TinhTrang' => $this->request->getPost('cashier_status') ?? 'Đang làm việc',
        ]);

        return redirect()->back()->with('success', 'Thêm thu ngân mới thành công!');
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
        if (empty($gender)) 
            $errors['cashier_gender'] = 'Vui lòng chọn giới tính.';

        // Kiểm tra ngày sinh
        if (strtotime($birthday) > strtotime(date('Y-m-d'))) 
            $errors['cashier_birthday'] = 'Ngày sinh không hợp lệ.';
        
        if (empty($birthday)) 
            $errors['cashier_birthday'] = 'Vui lòng nhập ngày sinh.';
        
        // Kiểm tra email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
            $errors['cashier_email'] = 'Email không đúng định dạng.';
        
        // Kiểm tra mật khẩu
        if (strlen($password) < 6)
            $errors['cashier_password'] = 'Mật khẩu phải có ít nhất 6 ký tự.';
        
        // Kiểm tra số điện thoại
        if (!preg_match('/^\d{10}$/', $phone)) 
            $errors['cashier_phone'] = 'Số điện thoại phải có đúng 10 chữ số.';
        
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
            return redirect()->back()->with('success', 'Cập nhật thông tin thành công!');
        } else {
            return redirect()->back()->with('errors', 'Không thể cập nhật. Vui lòng thử lại.');
        }
    }
}
