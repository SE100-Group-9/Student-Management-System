<?php
namespace App\Models;

use CodeIgniter\Model;

class LopModel extends Model
{
    protected $table = 'lop';
    protected $primaryKey = 'MaLop';
    protected $allowedFields = ['MaLop', 'TenLop'];

    public function getClassList()
    {
        return $this->findAll();
    }
}
