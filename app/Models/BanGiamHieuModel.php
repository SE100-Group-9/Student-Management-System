<?php

namespace App\Models;
use CodeIgniter\Model;

class BanGiamHieuModel extends Model
{
    protected $table = 'bangiamhieu';          
    protected $primaryKey = 'MaBGH';         
    protected $allowedFields = ['MaTK', 'ChucVu']; 

}
