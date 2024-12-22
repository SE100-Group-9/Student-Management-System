<?php

namespace App\Models;

use CodeIgniter\Model;

class DiemModel extends Model
{
    protected $table = 'diem';
    protected $primaryKey = 'MaDiem';
    protected $allowedFields = [
        'MaDiem', 'MaHS', 'MaGV', 'MaMH', 
        'Diem15P_1', 'Diem15P_2', 'Diem1Tiet_1', 'Diem1Tiet_2', 'DiemCK', 
        'HocKy', 'NamHoc', 'NhanXet'
    ];
}