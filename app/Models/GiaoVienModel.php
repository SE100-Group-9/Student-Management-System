<?php

namespace App\Models;

use CodeIgniter\Model;

class GiaoVienModel extends Model
{
    protected $table = 'giaovien'; 
    protected $primaryKey = 'MaGV'; 
    protected $allowedFields = ['MaTK', 'ChucVu', 'TinhTrang'];

    // Lấy danh sách giáo viên (MaGV, HoTen) đang giảng dạy
    public function getTeacherList()
    {
        $SQL = "SELECT giaovien.MaGV, taikhoan.HoTen
                FROM giaovien
                JOIN taikhoan ON giaovien.MaTK = taikhoan.MaTK
                WHERE giaovien.TinhTrang = 'Đang giảng dạy'";
        return $this->db->query($SQL)->getResultArray();
    }


}
