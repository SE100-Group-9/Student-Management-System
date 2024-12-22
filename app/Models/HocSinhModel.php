<?php

namespace App\Models;

use CodeIgniter\Model;

class HocSinhModel extends Model
{
    protected $table      = 'hocsinh';
    protected $primaryKey = 'MaHS';
    protected $allowedFields = ['MaTK', 'DanToc', 'NoiSinh', 'TinhTrang'];

    // Lấy danh sách học sinh và điểm số theo học kỳ, năm học và tên lớp
    public function getStudentList($year, $semester, $class)
    {
        $SQL = "SELECT DISTINCT hocsinh.MaHS, taikhoan.HoTen, lop.TenLop, monhoc.MaMH, monhoc.TenMH,
                    diem.Diem15P_1, diem.Diem15P_2, diem.Diem1Tiet_1, diem.Diem1Tiet_2, diem.DiemCK, 
                    hanhkiem.DiemHK
                FROM hocsinh
                JOIN taikhoan ON hocsinh.MaTK = taikhoan.MaTK
                LEFT JOIN hocsinh_lop ON hocsinh.MaHS = hocsinh_lop.MaHS AND hocsinh_lop.NamHoc = ?
                LEFT JOIN lop ON hocsinh_lop.MaLop = lop.MaLop 
                LEFT JOIN diem ON hocsinh.MaHS = diem.MaHS AND diem.NamHoc = ? AND diem.HocKy = ?
                LEFT JOIN monhoc ON diem.MaMH = monhoc.MaMH
                LEFT JOIN hanhkiem ON hocsinh.MaHS = hanhkiem.MaHS AND hanhkiem.NamHoc = ?
                WHERE lop.TenLop = ?
                ORDER BY hocsinh.MaHS, monhoc.MaMH";

        return $this->db->query($SQL, [$year, $year, $semester, $year, $class])->getResultArray();
    }
}
