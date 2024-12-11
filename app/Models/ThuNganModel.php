<?php
namespace App\Models;

use CodeIgniter\Model;

class ThuNganModel extends Model
{
    protected $table      = 'thungan';
    protected $primaryKey = 'MaTN';
    protected $allowedFields = ['MaTK', 'TinhTrang'];
}