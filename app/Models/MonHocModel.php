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

    // Lấy mã môn học dựa vào tên môn học
    public function getSubjectID($TenMH)
    {
        $SQL = "SELECT monhoc.MaMH
                    FROM monhoc
                    WHERE monhoc.TenMH = ?";
        return $this->db->query($SQL, [$TenMH])->getRowArray();
    }
}
