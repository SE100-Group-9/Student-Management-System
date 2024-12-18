<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\ThuNganModel;
use App\Models\TaiKhoanModel;

class CashierController extends Controller
{
    public function list()
    {
        return view('cashier/payment/list');
    }

    public function profile() 
    {
        $ThuNganModel = new ThuNganModel();

        // Lấy thông tin tài khoản hiện tại
        $MaTK = session('MaTK');

        // Lấy thông tin ban giám hiệu
        $ThuNgan = $ThuNganModel
            ->select('thungan.*, taikhoan.*')
            ->join('taikhoan', 'taikhoan.MaTK = thungan.MaTK')
            ->where('thungan.MaTK', $MaTK)
            ->first();


        return view('cashier/profile', [
            'cashier' => $ThuNgan,
        ]);
    }

    public function updateProfile()
    {
        $errors = [];
        // Lấy dữ liệu từ form
        $MaTN = $this->request->getPost('MaTN');
        $MaTK = $this->request->getPost('MaTK');
        $email = $this->request->getPost('cashier_email');
        $phone = $this->request->getPost('cashier_phone');

        // Kiểm tra email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            $errors['cashier_email'] = 'Email không đúng định dạng.';
        // Kiểm tra số điện thoại
        if (!preg_match('/^\d{10}$/', $phone))
            $errors['cashier_phone'] = 'Số điện thoại phải có đúng 10 chữ số.';
        // Nếu có lỗi, trả về cùng thông báo
        if (!empty($errors)) {
            return redirect()->back()->withInput()->with('errors', $errors);
        }

        $ThuNganModel = new ThuNganModel();
        $TaiKhoanModel = new TaiKhoanModel();

        // Cập nhật thông tin tài khoản
        $TaiKhoanModel->update($MaTK, [
            'Email' => $this->request->getPost('cashier_email'),
            'SoDienThoai' => $this->request->getPost('cashier_phone'),
            'DiaChi' => $this->request->getPost('cashier_address'),
        ]);

        // Xử lý thông báo
        if ($TaiKhoanModel) {
            return redirect()->back()->with('success', 'Cập nhật thông tin thành công!');
        } else {
            return redirect()->back()->with('errors', 'Không thể cập nhật. Vui lòng thử lại.');
        }
    }

    public function add()
    {
        return view('cashier/payment/add');
    }

    public function staticStudent()
    {
        return view('cashier/statics/student');
    }

    public function changepw()
    {
        return view('cashier/changepw');
    }
}
