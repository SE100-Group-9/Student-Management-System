<?php

namespace App\Models;

use CodeIgniter\Model;

class ThamSoModel extends Model
{
    protected $table = 'THAMSO';
    protected $primaryKey = 'MaThamSo';
    protected $allowedFields = ['TenThamSo', 'GiaTri'];

    // Lấy giá trị của tham số
    public function getGiaTriThamSo($TenThamSo)
    {
        $SQl = "SELECT GiaTri
                FROM thamso
                WHERE TenThamSo = ?";
        $query = $this->db->query($SQl, [$TenThamSo]);
        $result = $query->getRowArray();
        return $result ? $result['GiaTri'] : null;
    }

    // Cập nhật giá trị của tham số
    public function updateGiaTriThamSo($TenThamSo, $GiaTri)
    {
        $SQl = "UPDATE thamso
                SET GiaTri = ?
                WHERE TenThamSo = ?";
        $query = $this->db->query($SQl, [$GiaTri, $TenThamSo]);
        return $this->db->affectedRows();
    }
}
