<?php

namespace App\Models;

use CodeIgniter\Model;

class TaiKhoanModel extends Model
{
    protected $table = 'taikhoan';
    protected $primaryKey = 'MaTK';
    protected $allowedFields = ['TenTK', 'MatKhau', 'Email', 'HoTen', 'SoDienThoai', 'DiaChi', 'GioiTinh', 'NgaySinh', 'MaVT'];

    // Hàm kiểm tra tài khoản dựa vào TenTK
    public function findByUsernameWithRole($username)
    {
        $user = $this->where('TenTK', $username)->first();
        if ($user) {
            $roleModel = new VaiTroModel();
            $role = $roleModel->findRoleById($user['MaVT']);
            $user['TenVT'] = $role['TenVT'];
            return $user;
        }
        return null;
    }

    // Cập nhật thông tin tài khoản dựa vào MaTK
    public function updateAccount($MaTK, $data)
    {
        $this->set($data);
        $this->where('MaTK', $MaTK);
        return $this->update();
    }
}
