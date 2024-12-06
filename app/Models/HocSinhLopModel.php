<?php
namespace App\Models;

use CodeIgniter\Model;

class HocSinhLopModel extends Model
{
    protected $table      = 'hocsinh_lop';
    protected $primaryKey = ['MaHS', 'MaLop', 'HocKy', 'NamHoc'];
    protected $allowedFields = ['MaHS', 'MaLop', 'HocKy', 'NamHoc'];
}
