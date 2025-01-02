<?php
namespace App\Models;

use CodeIgniter\Model;

class GiamThiModel extends Model
{
    protected $table      = 'giamthi';
    protected $primaryKey = 'MaGT';
    protected $allowedFields = ['MaTK', 'TinhTrang'];

    public function getCurrentSupervisor() {
        $GiamThiModel = new GiamThiModel();

        // Lấy thông tin tài khoản hiện tại
        $MaTK = session('MaTK');

        // Lấy thông tin ban giám hiệu
        $GiamThi = $GiamThiModel
            ->select('giamthi.*, taikhoan.*')
            ->join('taikhoan', 'taikhoan.MaTK = giamthi.MaTK')
            ->where('giamthi.MaTK', $MaTK)
            ->first();
        return $GiamThi;
    }
}