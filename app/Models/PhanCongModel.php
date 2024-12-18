<?php

namespace App\Models;

use CodeIgniter\Model;

class PhanCongModel extends Model
{
    protected $table      = 'PHANCONG'; 
    protected $primaryKey = 'MaPC';     

    protected $allowedFields = ['MaGV', 'MaMH', 'MaLop', 'HocKy', 'NamHoc', 'VaiTro'];
}