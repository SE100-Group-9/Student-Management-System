<?php
namespace App\Models;

use CodeIgniter\Model;

class GiamThiModel extends Model
{
    protected $table      = 'giamthi';
    protected $primaryKey = 'MaGT';
    protected $allowedFields = ['MaTK', 'TinhTrang'];
}