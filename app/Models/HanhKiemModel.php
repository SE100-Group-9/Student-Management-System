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
}