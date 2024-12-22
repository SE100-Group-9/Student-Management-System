<?php 

namespace App\Models;

use CodeIgniter\Model;

class DanhHieuModel extends Model
{
    protected $table = 'DANHHIEU';
    protected $primaryKey = 'MaDH';
    protected $allowedFields = ['MaDH', 'TenDH', 'DiemTBToiThieu', 'DiemHanhKiemToiThieu'];


    // Chọn danh hiệu cho học sinh dựa vào điểm trung bình và điểm hạnh kiểm
    public function getAcademicTitle($DiemTBHocKy, $DiemHK)
    {
        $SQL = "SELECT danhhieu.TenDH 
                FROM danhhieu
                WHERE DiemTBToiThieu <= ? AND DiemHanhKiemToiThieu <= ?
                ORDER BY DiemTBToiThieu DESC, DiemHanhKiemToiThieu DESC
                LIMIT 1";
        return $this->db->query($SQL, [$DiemTBHocKy, $DiemHK])->getRowArray();
    }
    
}