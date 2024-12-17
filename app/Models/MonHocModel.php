<?php

namespace App\Models;

use CodeIgniter\Model;

class MonHocModel extends Model
{
    protected $table = 'monhoc'; 
    protected $primaryKey = 'MaMH'; 
    protected $allowedFields = ['TenMH']; 
}
