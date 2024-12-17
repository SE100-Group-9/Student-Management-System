<?php

namespace App\Models;

use CodeIgniter\Model;

class GiaoVienModel extends Model
{
    protected $table = 'giaovien'; 
    protected $primaryKey = 'MaGV'; 
    protected $allowedFields = ['MaTK', 'ChucVu', 'TinhTrang'];
}
