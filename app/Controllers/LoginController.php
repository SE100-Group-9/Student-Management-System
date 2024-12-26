<?php

namespace App\Controllers;

use App\Models\TaiKhoanModel;
use CodeIgniter\Controller;
use App\Models\UserModel;

class LoginController extends Controller
{
    public function index()
    {
        return view('login'); // Hiển thị trang login.php
    }

    public function authenticate()
    {
        $session = session();
        $model = new TaiKhoanModel();

        // Lấy dữ liệu từ form đăng nhập
        $username = $this->request->getPost('TenTK');
        $password = $this->request->getPost('MatKhau');
        log_message('debug', 'Username: ' . $username); // Log tên tài khoản
        log_message('debug', 'Password: ' . $password); // Log mật khẩu

        // Kiểm tra tài khoản
        $user = $model->findByUsernameWithRole($username);
        log_message('debug', 'User found: ' . print_r($user, true)); 
        if ($user) {
            // Xác thực mật khẩu
            log_message('debug', 'Username: ' . $username); // Log tên tài khoản
            if ($password === $user['MatKhau']) {
                // Lưu thông tin người dùng vào session
                log_message('debug', 'Username: ' . $username); // Log tên tài khoản
                $session->set([
                    'MaTK'     => $user['MaTK'],
                    'TenTK'    => $user['TenTK'],
                    'HoTen'    => $user['HoTen'],
                    'MaVT'     => $user['MaVT'], // Vai trò
                    'TenVT'    => $user['TenVT'], // Tên vai trò
                    'loggedIn' => true,
                ]);
                log_message('debug', 'Login successful for user: ' . $username);
                // Điều hướng dựa trên vai trò
                switch ($user['MaVT']) {
                    case '1': // Ban Giám Hiệu
                        return redirect()->to('/director/statics/conduct');
                    case '2': // Giáo Viên
                        return redirect()->to('/teacher/statics/grade');
                    case '3': // Học Sinh
                        return redirect()->to('/student/conduct');
                    case '4': // Thu Ngân
                        return redirect()->to('/cashier/invoice/list');
                    case '5': // Giám Thị
                        return redirect()->to('/supervisor/fault');
                    default:
                        $session->destroy();
                        return redirect()->to('/')->with('error', 'Vai trò không hợp lệ!');
                }
            }
            else 
                return redirect()->to('/')->with('error', 'Tên tài khoản hoặc mật khẩu không chính xác!');
        } 
        else 
            return redirect()->to('/')->with('error', 'Tên tài khoản hoặc mật khẩu không chính xác!');
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/');
    }
}
