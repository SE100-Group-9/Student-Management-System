<?php

namespace App\Models;

use CodeIgniter\Model;

class VaiTroModel extends Model
{
    protected $table = 'vaitro';  // Bảng chứa thông tin vai trò
    protected $primaryKey = 'MaVT'; // Khóa chính của bảng VAITRO
    protected $allowedFields = ['MaVT', 'TenVT']; // Các trường được phép truy xuất

    // Hàm tìm vai trò theo MaVT
    public function findRoleById($maVT)
    {
        return $this->where('MaVT', $maVT)->first();
    }
}
