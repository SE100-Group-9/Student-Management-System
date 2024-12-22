<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\TaiKhoanModel;
use App\Models\GiamThiModel;

class SupervisorController extends Controller
{
    public function fault()
    {
        return view('supervisor/fault');
    }

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
        $TaiKhoanModel->update($MaTK, [
            'Email' => $this->request->getPost('supervisor_email'),
            'SoDienThoai' => $this->request->getPost('supervisor_phone'),
            'DiaChi' => $this->request->getPost('supervisor_address'),
        ]);

        // Xử lý thông báo
        if ($TaiKhoanModel) {
            return redirect()->back()->with('success', 'Cập nhật thông tin thành công!');
        } else {
            return redirect()->back()->with('errors', 'Không thể cập nhật. Vui lòng thử lại.');
        }
    }

    public function category()
    {
        return view('supervisor/category');
    }

    public function addfault()
    {
        return view('supervisor/addfault');
    }

    public function addcategory()
    {
        return view('supervisor/addcategory');
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



    public function updatecategory()
    {
        return view('supervisor/updatecategory');
    }
}
