<?php 

namespace App\Models;

use CodeIgniter\Model;

class DanhHieuModel extends Model
{
    protected $table = 'DANHHIEU';
    protected $primaryKey = 'MaDH';
    protected $allowedFields = ['MaDH', 'TenDH', 'DiemTBToiThieu', 'DiemHanhKiemToiThieu'];
}
