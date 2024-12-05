<?php
namespace App\Models;

use CodeIgniter\Model;

class HocSinhModel extends Model
{
    protected $table      = 'hocsinh';
    protected $primaryKey = 'MaHS';
    protected $allowedFields = ['MaTK', 'DanToc', 'NoiSinh', 'TinhTrang'];
}
