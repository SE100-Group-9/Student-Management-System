<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\TaiKhoanModel;
use App\Models\GiamThiModel;
use App\Models\LoaiViPhamModel;
use App\Models\HocSinhLopModel;
use App\Models\LopModel;
use App\Models\ViPhamModel;
use App\Models\HocSinhModel;

class SupervisorController extends Controller
{


    public function profile()
    {    
        $GiamThiModel = new GiamThiModel();

        // Lấy thông tin tài khoản hiện tại
        $MaTK = session('MaTK');

        // Lấy thông tin ban giám hiệu
        $GiamThi = $GiamThiModel
            ->select('giamthi.*, taikhoan.*')
            ->join('taikhoan', 'taikhoan.MaTK = giamthi.MaTK')
            ->where('giamthi.MaTK', $MaTK)
            ->first();


        return view('supervisor/profile', [
            'supervisor' => $GiamThi,
        ]);

    }

    public function updateProfile()
    {    
        $errors = [];
        // Lấy dữ liệu từ form
        $MaTN = $this->request->getPost('MaGT');
        $MaTK = $this->request->getPost('MaTK');
        $email = $this->request->getPost('supervisor_email');
        $phone = $this->request->getPost('supervisor_phone');
        $address = $this->request->getPost('supervisor_address');
        
        // Kiểm tra email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            $errors['supervisor_email'] = 'Email không đúng định dạng.';
        // Kiểm tra số điện thoại
        if (!preg_match('/^\d{10}$/', $phone))
            $errors['supervisor_phone'] = 'Số điện thoại phải có đúng 10 chữ số.';
        // Kiểm tra địa chỉ
        if (empty(trim($address)))
            $errors['supervisor_address'] = 'Địa chỉ không được để trống';
        if (!empty($errors))
            return redirect()->back()->withInput()->with('errors', $errors);

        $GiamThiModel = new GiamThiModel();
        $TaiKhoanModel = new TaiKhoanModel();

        // Cập nhật thông tin tài khoản
        $result = $TaiKhoanModel->update($MaTK, [
            'Email' => $this->request->getPost('supervisor_email'),
            'SoDienThoai' => $this->request->getPost('supervisor_phone'),
            'DiaChi' => $this->request->getPost('supervisor_address'),
        ]);

        // Xử lý thông báo
        if ($result) {
            return redirect()->back()->with('success', 'Cập nhật thông tin thành công!');
        } else {
            return redirect()->back()->with('errors', 'Không thể cập nhật. Vui lòng thử lại.');
        }
    }

    public function category()
    {
        $LoaiViPhamModel = new LoaiViPhamModel();

        $searchLVP = $this->request->getVar('search') ?? '';
        
        
        $LoaiViPham = $LoaiViPhamModel->getLVP($searchLVP);

        
        return view(
            'supervisor/category',
            [
                'LoaiViPham' => $LoaiViPham,
            ]
        );
        
    }


    public function addcategory()
    {   
        $errors = [];
        $LoaiViPhamModel = new LoaiViPhamModel();




        $TenLVP = $this->request->getPost('TenLVP');
        $DiemTru = $this->request->getPost('DiemTru');

        if (empty(trim($TenLVP)))
        $errors['TenLVP'] = 'Tên vi phạm không được phép trống';
        if (!is_numeric($DiemTru) || $DiemTru <= 0)
        $errors['DiemTru'] = 'Điểm trừ không hợp lệ';
        if (!empty($errors))
        return redirect()->back()->withInput()->with('errors', $errors);

        $data = [
            'TenLVP'  => $TenLVP,
            'DiemTru' => $DiemTru,
        ];

        $result = $LoaiViPhamModel->addLVP($data);
        
        if ($result) {
            return redirect()->back()->with('success', 'Thêm vi phạm thành công');
        } else {
            return redirect()->back()->with('errors', 'Thêm vi phạm thất bại');
        }
    
        return view('supervisor/addcategory');
    }



    public function addcategoryForm() {
        $GiamThiModel = new GiamThiModel();
        $GiamThi = $GiamThiModel->getCurrentSupervisor();

        $MaGT = $GiamThi['MaGT'];
        $TenGT = $GiamThi['HoTen'];

        return view('supervisor/addcategory', ['MaGT' =>  $MaGT, 'TenGT' =>  $TenGT]);
    }

    public function changepw()
    {

        return view('supervisor/changepw');
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

        if ($TaiKhoanModel) {
            return redirect()->back()->with('success', 'Cập nhật thông tin thành công!');
        } else {
            return redirect()->back()->with('errors', 'Không thể cập nhật. Vui lòng thử lại.');
        }
        
    }



    public function updatecategory($categoryId)
    {   
        $TenLVP = $this->request->getPost('TenLVP');
        $DiemTru = $this->request->getPost('DiemTru');

        if (empty(trim($TenLVP)))
        $errors['TenLVP'] = 'Tên vi phạm không được phép trống';
        if (!is_numeric($DiemTru) || $DiemTru <= 0)
        $errors['DiemTru'] = 'Điểm trừ không hợp lệ';
        if (!empty($errors))
        return redirect()->back()->withInput()->with('errors', $errors);

        $data = [
            'TenLVP'  => $TenLVP,
            'DiemTru' => $DiemTru,
        ];

        $LoaiViPhamModel = new LoaiViPhamModel();
        $result = $LoaiViPhamModel->updateLVP($categoryId, $data);
        
        if ($result) {
            return redirect()->back()->with('success', 'Cập nhật vi phạm thành công');
        } else {
            return redirect()->back()->with('errors', 'Cập nhật vi phạm thất bại');
        }
        
        return view('supervisor/updatecategory');
    }

    public function updatecategoryForm($categoryId)
    {   
        $LoaiViPhamModel = new LoaiViPhamModel();
        $LoaiViPham = $LoaiViPhamModel->getLVPByCategoryId($categoryId);
        $loaivipham = [
            'MaLVP' => $LoaiViPham['MaLVP'],
            'TenLVP' =>  $LoaiViPham['TenLVP'],
            'DiemTru' => $LoaiViPham['DiemTru']
        ];

        return view('supervisor/updatecategory', ['loaivipham' => $loaivipham]);
        
    }


    public function deletecategory($categoryId)
    {   
        $LoaiViPhamModel = new LoaiViPhamModel();
        $result= $LoaiViPhamModel->deleteLVP($categoryId);
        if ($result) {
            return redirect()->back()->with('success', 'Xóa thanh toán thành công.');
        } else {
            return redirect()->back()->with('error', 'Xóa thanh toán thất bại.');
        }
    }

    public function addfaultForm() {
        $HocSinhLopModel = new HocSinhLopModel();
        $yearListArray = $HocSinhLopModel->getYearList();

        $LoaiViPhamModel = new LoaiViPhamModel();
        $categoryList = $LoaiViPhamModel->getLVP('');
        $categoryArray = array_column($categoryList, 'TenLVP');

        $GiamThiModel = new GiamThiModel();
        $GiamThi = $GiamThiModel->getCurrentSupervisor();
        
        $TenGT = $GiamThi['HoTen'];
        return view('supervisor/addfault', [
            'HoTen' => $TenGT,
            'yearList' => $yearListArray,
            'categoryList' => $categoryArray,
        ]);
        
    }

    
    public function addfault()
    {  
        
        $errors = [];

        $MaHS = $this->request->getPost('MaHS');
        $TenHS = $this->request->getPost('TenHS');
        $Lop = $this->request->getPost('Lop');

        $TenGT = $this->request->getPost('TenGT');

        $HocKi = $this->request->getPost('HocKi');
        $NamHoc = $this->request->getPost('NamHoc');
        $Loi = $this->request->getPost('Loi');


        if (empty($HocKi)) {
            $errors['hocki'] = 'Vui lòng chọn Học kì.';
        }
    
        if (empty($NamHoc)) {
            $errors['namhoc'] = 'Vui lòng chọn Năm học.';
        }
    
        if (empty($Loi)) {
            $errors['loi'] = 'Vui lòng chọn Lỗi vi phạm.';
        }


        if (empty(trim($MaHS)) || empty(trim($TenHS)) || empty(trim($Lop))) {
            $errors['empty'] = 'Vui lòng nhập đầy đủ thông tin';
        } else {
            $HocSinhModel = new HocSinhModel();
            // Kiểm tra mã HS có tồn tại hay không ?
            $result = $HocSinhModel->isValidStudentCode($MaHS);
            if (!$result) {
                $errors['MaHS'] = 'Mã học sinh không hợp lệ';
            } else {
                // Kiểm tra tenHS có đúng với MaHS đó không ?
                $result = $HocSinhModel->isValidStudentName($MaHS, $TenHS);
                if (!$result) {
                    $errors['TenHS'] = 'Tên học sinh không đúng với mã học sinh';
                } else {
                    $LopModel = new LopModel();
                    // Kiểm tra lớp có tồn tại không ?
                    $result = $LopModel->isExistClass($Lop);
                    if (!$result) {
                        $errors['Lop'] = 'Lớp không hợp lệ';
                    }             
                }
            }
        }
          
        if (!empty($errors))
        return redirect()->back()->withInput()->with('errors', $errors);

        $GiamThiModel = new GiamThiModel();
        $GiamThi = $GiamThiModel->getCurrentSupervisor();
        $MaGT = $GiamThi['MaGT'];

        $LoaiViPhamModel = new LoaiViPhamModel();
        $MaLVP = $LoaiViPhamModel->getMaLVP($Loi);

        $LopModel = new LopModel();
        $MaLop =  $LopModel->getMaLop($Lop);

        preg_match('/\d+/', $HocKi, $matches);
        $HocKi = $matches[0];

        $NgayVP= date('d/m/Y');

        $data = [
            'MaHS' => $MaHS, 
            'MaGT' => $MaGT,
            'MaLVP' => $MaLVP,
            'MaLop' =>  $MaLop,
            'HocKy' => $HocKi,
            'NamHoc' => $NamHoc,
            'NgayVP'=> $NgayVP
        ];

        $ViPhamModel = new ViPhamModel();
        $result = $ViPhamModel->addVP($data);
        
        if ($result) {
            return redirect()->back()->with('success', 'Thêm lỗi thành công');
        } else {
            return redirect()->back()->with('errors', 'Thêm lỗi thất bại');
        }
        return view('supervisor/addfault');
    }


    public function fault()
    {
        $HocSinhLopModel = new HocSinhLopModel();
        $yearListArray = $HocSinhLopModel->getYearList();
        $yearList = array_merge(['Chọn năm học'], $yearListArray ); 


        $selectedSemester = $this->request->getVar('semester');
        $selectedYear = $this->request->getVar('year');
        $searchStudent = $this->request->getVar('search') ?? '';

        preg_match('/\d+/', $selectedSemester, $matches);
        $selectedSemesterNumber = $matches;

        $ViPhamModel = new ViPhamModel();
        $ViPham = $ViPhamModel->getAllVP($selectedSemesterNumber, $selectedYear, $searchStudent);

        return view('supervisor/fault', [
            'yearList' => $yearList,
            'viPham' => $ViPham,
            'selectedSemester' => $selectedSemester,
            'selectedYear' => $selectedYear
        ]);
    }

    public function faultDetail($faultId)
    {
        $ViPhamModel = new ViPhamModel();
        $ViPham = $ViPhamModel->getVPById($faultId);

        return view('supervisor/faultDetail', [
            'viPham' => $ViPham
        ]);
    }
    public function deletefault($faultId)
    {   
        $ViPhamModel = new ViPhamModel();
        $result= $ViPhamModel->deleteVP($faultId);
        if ($result) {
            return redirect()->back()->with('success', 'Xóa vi phạm thành công.');
        } else {
            return redirect()->back()->with('error', 'Xóa vi phạm thất bại.');
        }
    }

}
