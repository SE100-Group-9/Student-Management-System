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
        $SQL = "SELECT DISTINCT lop.TenLop
                FROM lop
                JOIN hocsinh_lop ON lop.MaLop = hocsinh_lop.MaLop
                JOIN hocsinh ON hocsinh_lop.MaHS = hocsinh.MaHS
                WHERE hocsinh_lop.NamHoc = ?
                GROUP BY lop.TenLop
                ORDER BY lop.TenLop";
        return $this->db->query($SQL, [$year])->getResultArray();
    }    

    public function isExistClass($TenLop) {
        $SQL = "SELECT COUNT(*) AS count FROM lop WHERE TenLop = ?";
        $result = $this->db->query($SQL, [$TenLop])->getRowArray();
        return !empty($result['count']) && $result['count'] > 0;
    }

    public function getMaLop($Lop) {
        // Câu lệnh SQL để lấy MaLVP dựa trên TenLVP
        $SQL = "SELECT MaLop FROM lop WHERE TenLop = ?";
        
        // Thực hiện truy vấn và lấy kết quả
        $result = $this->db->query($SQL, [$Lop])->getRowArray();
        
        // Kiểm tra và trả về MaLVP
        return $result['MaLop'];
    }
}
