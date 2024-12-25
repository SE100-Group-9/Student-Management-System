<?php

namespace App\Models;

use CodeIgniter\Model;

class HanhKiemModel extends Model
{
    protected $table = 'hanhkiem'; 
    protected $primaryKey = 'MaHK'; 
    protected $allowedFields = [
        'MaHS', 'HocKy', 'NamHoc', 'DiemHK', 'TrangThai'
    ];

    // Thêm thông tin hạnh kiểm của học sinh dựa vào mã học sinh, năm học
    public function addConduct($MaHS, $NamHoc)
    {
        $data = [
            'MaHS' => $MaHS,
            'HocKy' => 1,
            'NamHoc' => $NamHoc,
            'DiemHK' => 100 // Mặc định điểm hạnh kiểm là 100
        ];
        $this->insert($data);

        $data = [
            'MaHS' => $MaHS,
            'HocKy' => 2,
            'NamHoc' => $NamHoc,
            'DiemHK' => 100 // Mặc định điểm hạnh kiểm là 100
        ];
        $this->insert($data);
        return true;
    }
}