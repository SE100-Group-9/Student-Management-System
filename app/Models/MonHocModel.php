<?php

namespace App\Models;

use CodeIgniter\Model;

class MonHocModel extends Model
{
    protected $table = 'monhoc'; 
    protected $primaryKey = 'MaMH'; 
    protected $allowedFields = ['TenMH']; 

    // Lấy danh sách môn học
    public function getSubjectList()
    {
        $SQL = "SELECT monhoc.TenMH
                FROM monhoc";
        return $this->db->query($SQL)->getResultArray();
    }
}
