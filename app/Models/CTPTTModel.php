<?php
namespace App\Models;

use CodeIgniter\Model;

class CTPTTModel extends Model
{
    protected $table = 'ctptt';
    protected $primaryKey = 'MaCTPTT';
    protected $allowedFields = ['MaHS', 'NamHoc', 'TongHocPhi', 'DaThanhToan', 'TrangThai', 'NgayCapNhat'];

    // Thêm thông tin học phí cho học sinh khi xếp lớp
    public function addTuition($MaHS, $NamHoc, $MucHocPhi)
    {
        $data = [
            'MaHS' => $MaHS,
            'NamHoc' => $NamHoc,
            'TongHocPhi' => $MucHocPhi,
            'DaThanhToan' => 0,
            'TrangThai' => 'Chưa thanh toán',
            'NgayCapNhat' => date('Y-m-d')
        ];
        $this->insert($data);
    }

    // Xem thông tin học phí của học sinh
    public function getTuitionInfo($MaLop, $NamHoc)
    {
        $SQL = "SELECT ctptt.MaHS, taikhoan.HoTen, taikhoan.Email, lop.TenLop, ctptt.TrangThai, (ctptt.TongHocPhi - ctptt.DaThanhToan) AS TienNo
                FROM ctptt
                JOIN hocsinh ON ctptt.MaHS = hocsinh.MaHS 
                JOIN taikhoan ON hocsinh.MaTK = taikhoan.MaTK
                JOIN hocsinh_lop ON hocsinh.MaHS = hocsinh_lop.MaHS AND hocsinh_lop.NamHoc = ?
                JOIN lop ON hocsinh_lop.MaLop = lop.MaLop 
                WHERE hocsinh_lop.MaLop = ? AND ctptt.NamHoc = ?";
        return $this->db->query($SQL, [$NamHoc, $MaLop, $NamHoc])->getResultArray();

    }
}
