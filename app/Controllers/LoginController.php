<?php

namespace App\Controllers;

use App\Models\TaiKhoanModel;
use App\Models\GiaoVienModel;
use App\Models\ThuNganModel;
use App\Models\GiamThiModel;
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
        $taiKhoanModel = new TaiKhoanModel();
        $giaoVienModel = new GiaoVienModel();
        $thuNganModel = new ThuNganModel();
        $giamThiModel = new GiamThiModel();

        // Lấy dữ liệu từ form đăng nhập
        $username = $this->request->getPost('TenTK');
        $password = $this->request->getPost('MatKhau');

        // Kiểm tra tài khoản
        $user = $taiKhoanModel->findByUsernameWithRole($username);
        if ($user) {
            // Xác thực mật khẩu
            if ($password === $user['MatKhau']) {
                // Kiểm tra tình trạng của vai trò (nếu cần)
                $isAllowed = true;

                switch ($user['MaVT']) {
                    case '2': // Giáo Viên
                        $teacher = $giaoVienModel->where('MaTK', $user['MaTK'])->first();
                        if ($teacher && $teacher['TinhTrang'] !== 'Đang giảng dạy') {
                            $isAllowed = false;
                            $errorMsg = "Tài khoản giáo viên {$teacher['MaGV']} không được phép đăng nhập!";
                        }
                        break;

                    case '4': // Thu Ngân
                        $cashier = $thuNganModel->where('MaTK', $user['MaTK'])->first();
                        if ($cashier && $cashier['TinhTrang'] !== 'Đang làm việc') {
                            $isAllowed = false;
                            $errorMsg = "Tài khoản thu ngân {$cashier['MaTN']} không được phép đăng nhập!";
                        }
                        break;

                    case '5': // Giám Thị
                        $supervisor = $giamThiModel->where('MaTK', $user['MaTK'])->first();
                        if ($supervisor && $supervisor['TinhTrang'] !== 'Đang làm việc') {
                            $isAllowed = false;
                            $errorMsg = "Tài khoản giám thị {$supervisor['MaGT']} không được phép đăng nhập!";
                        }
                        break;

                    default:
                        break;
                }

                if (!$isAllowed) {
                    return redirect()->to('/')->with('error', $errorMsg);
                }

                // Lưu thông tin người dùng vào session
                $session->set([
                    'MaTK'     => $user['MaTK'],
                    'TenTK'    => $user['TenTK'],
                    'HoTen'    => $user['HoTen'],
                    'MaVT'     => $user['MaVT'], // Vai trò
                    'TenVT'    => $user['TenVT'], // Tên vai trò
                    'loggedIn' => true,
                ]);

                // Điều hướng dựa trên vai trò
                switch ($user['MaVT']) {
                    case '1': // Ban Giám Hiệu
                        return redirect()->to('/director/statics/grade');
                    case '2': // Giáo Viên
                        return redirect()->to('/teacher/statics/grade');
                    case '3': // Học Sinh
                        return redirect()->to('/student/score');
                    case '4': // Thu Ngân
                        return redirect()->to('/cashier/invoice/list');
                    case '5': // Giám Thị
                        return redirect()->to('/supervisor/fault');
                    default:
                        $session->destroy();
                        return redirect()->to('/')->with('error', 'Vai trò không hợp lệ!');
                }
            } else {
                return redirect()->to('/')->with('error', 'Tên tài khoản hoặc mật khẩu không chính xác!');
            }
        } else {
            return redirect()->to('/')->with('error', 'Tên tài khoản hoặc mật khẩu không chính xác!');
        }
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/');
    }
}
