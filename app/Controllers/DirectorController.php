<?php

namespace App\Controllers;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use CodeIgniter\Controller;
use App\Models\TaiKhoanModel;
use App\Models\HocSinhModel;
use App\Models\HocSinhLopModel;
use App\Models\LopModel;

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

    public function addStudent()
    {

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
            'TinhTrang' => $this->request->getPost('student_status') ?? 'Đang học',
        ]);

        $allPostData = $this->request->getPost();
        log_message('info', 'Received Data: ' . json_encode($allPostData));
        return redirect()->back()->with('success', 'Cập nhật thành công!');
    }

    public function studentUpdate($id = null)
    {
        if ($id === null) {
            return redirect()->to('director/student/list'); // Redirect nếu không có id
        }
        $TaiKhoanModel = new TaiKhoanModel();
        $HocSinhModel = new HocSinhModel();
        // Lấy thông tin học sinh theo id
        $data = $HocSinhModel
            ->select('hocsinh.*, taikhoan.*')
            ->join('taikhoan', 'taikhoan.MaTK = hocsinh.MaTK')
            ->where('hocsinh.MaHS', $id)
            ->first();
        if (!$data) {
            return redirect()->to('director/student/list'); // Redirect nếu không tìm thấy học sinh
        }
        return view('director/student/update', ['student' => $data]);
    }
    public function updateStudent()
    {
        $TaiKhoanModel = new TaiKhoanModel();
        $HocSinhModel = new HocSinhModel();

        $MaHS = $this->request->getPost('MaHS');
        $MaTK = $this->request->getPost('MaTK');

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
        return redirect()->back()->with('success', 'Cập nhật thành công!');
    }



    public function studentList()
    {
        $TaiKhoanModel = new TaiKhoanModel();
        $HocSinhModel = new HocSinhModel();
        $HocSinhLopModel = new HocSinhLopModel();
        $LopModel = new LopModel();

        // Giá trị mặc định nếu không chọn
        $defaultYear = '2024-2025';

        // Nhận giá trị năm học và lớp từ query string
        $selectedYear = $this->request->getVar('year') ?? $defaultYear;
        $selectedClass = $this->request->getVar('class');
        $searchStudent = $this->request->getVar('search') ?? ''; // Nhận giá trị tìm kiếm

        // Lấy danh sách các năm học và lớp
        $classList = $LopModel->findColumn('TenLop');
        $yearListArray = $HocSinhLopModel
            ->distinct()
            ->select('NamHoc')
            ->orderBy('NamHoc', 'ASC')
            ->findAll();
        // Lấy các giá trị của trường 'NamHoc' từ mảng $yearListArray
        $yearList = array_map(function ($year) {
            return $year['NamHoc']; // Lấy giá trị NamHoc
        }, $yearListArray);

        log_message('debug', 'Class List: ' . print_r($classList, true));
        log_message('debug', 'Class List: ' . print_r($yearList, true));

        $query = $HocSinhModel
            ->select('hocsinh.*, taikhoan.HoTen, taikhoan.Email, taikhoan.SoDienThoai, taikhoan.GioiTinh, taikhoan.NgaySinh, hocsinh_lop.MaLop, lop.TenLop')
            ->join('taikhoan', 'taikhoan.MaTK = hocsinh.MaTK')
            ->join('hocsinh_lop', 'hocsinh.MaHS = hocsinh_lop.MaHS')
            ->join('lop', 'lop.MaLop = hocsinh_lop.MaLop');

        // Lọc theo năm học và lớp
        if ($selectedYear) {
            $query->where('hocsinh_lop.NamHoc', $selectedYear);
        }
        if ($selectedClass) {
            $query->where('lop.TenLop', $selectedClass);
        }
        // Lọc theo từ khóa tìm kiếm
        if ($searchStudent) {
            $query->groupStart() // Tạo nhóm điều kiện tìm kiếm
                ->like('hocsinh.MaHS', $searchStudent)
                ->orLike('taikhoan.HoTen', $searchStudent)
                ->groupEnd();
        }

        $studentList  = $query->findAll();

        return view('director/student/list', [
            'studentlist' => $studentList,
            'yearList' => $yearList,
            'classList' => $classList,
            'selectedYear' => $selectedYear,
            'selectedClass' => $selectedClass,
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

    public function titleList()
    {
        return view('director/title/list');
    }

    public function titleAdd()
    {
        return view('director/title/add');
    }

    public function titleUpdate()
    {
        return view('director/title/update');
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

    public function classArrangeList()
    {
        return view('director/class/arrange/list');
    }

    public function classArrangeStudent()
    {
        return view('director/class/arrange/student');
    }

    public function classArrangeTeacher()
    {
        return view('director/class/arrange/teacher');
    }

    public function employeeTeacherList()
    {
        return view('director/employee/teacher/list');
    }

    public function employeeTeacherAdd()
    {
        return view('director/employee/teacher/add');
    }

    public function employeeCashierList()
    {
        return view('director/employee/cashier/list');
    }

    public function employeeCashierAdd()
    {
        return view('director/employee/cashier/add');
    }

    public function employeeCashierUpdate()
    {
        return view('director/employee/cashier/update');
    }

    public function employeeSupervisorList()
    {
        return view('director/employee/supervisor/list');
    }

    public function employeeSupervisorAdd()
    {
        return view('director/employee/supervisor/add');
    }

    public function employeeSupervisorUpdate()
    {
        return view('director/employee/supervisor/update');
    }
    
    public function profile()
    {
        return view('director/profile');
    }

    public function changepw()
    {
        return view('director/changepw');
    }
}
