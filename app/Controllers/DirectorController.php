<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\TaiKhoanModel;
use App\Models\HocSinhModel;
use App\Models\HocSinhLopModel;

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

    public function studentAdd()
    {
        return view('director/student/add');
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
        return redirect()->to('director/student/list')->with('success', 'Cập nhật thành công!');
    }



    public function studentList()
    {   
        $TaiKhoanModel = new TaiKhoanModel();
        $HocSinhModel = new HocSinhModel();
        $HocSinhLopModel = new HocSinhLopModel();
        $data = $HocSinhModel
        ->select('hocsinh.*, taikhoan.HoTen, taikhoan.Email, taikhoan.SoDienThoai, taikhoan.GioiTinh, taikhoan.NgaySinh, hocsinh_lop.MaLop')
        ->join('taikhoan', 'taikhoan.MaTK = hocsinh.MaTK')
        ->join('hocsinh_lop', 'hocsinh.MaHS = hocsinh_lop.MaHS')
        //->where('hocsinh_lop.NamHoc', date('Y')) // Lọc theo năm học hiện tại
        ->findAll();
        return view('director/student/list', ['studentlist' => $data]);
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
}
