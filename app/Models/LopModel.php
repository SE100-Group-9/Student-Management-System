<?php
namespace App\Models;

use CodeIgniter\Model;

class LopModel extends Model
{
    protected $table = 'lop';
    protected $primaryKey = 'MaLop';
    protected $allowedFields = ['MaLop', 'TenLop'];

    //Lấy danh sách lớp dựa vào năm học được chọn
    public function getClassList($year)
    {
        $SQL = "SELECT lop.TenLop
                FROM lop
                JOIN hocsinh_lop ON lop.MaLop = hocsinh_lop.MaLop
                JOIN hocsinh ON hocsinh_lop.MaHS = hocsinh.MaHS
                WHERE hocsinh_lop.NamHoc = $year
                GROUP BY lop.TenLop
                ORDER BY lop.TenLop";
        return $this->db->query($SQL)->getResultArray();
    }
}
