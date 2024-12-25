<?php

namespace App\Models;

use CodeIgniter\Model;

class HocSinhLopModel extends Model
{
    protected $table      = 'hocsinh_lop';
    protected $primaryKey = ['MaHS', 'MaLop', 'HocKy', 'NamHoc'];
    protected $allowedFields = ['MaHS', 'MaLop', 'HocKy', 'NamHoc'];

    // Kiểm tra học sinh đã được xếp lớp trong năm học đó chưa
    public function checkStudentInClass($MaHS, $MaLop, $NamHoc)
    {
        $SQl = "SELECT COUNT(*) AS total
                FROM hocsinh_lop
                WHERE MaHS = ? AND MaLop = ? AND NamHoc = ?";
        $query = $this->db->query($SQl, [$MaHS, $MaLop, $NamHoc]);
        $result = $query->getRow();

        // Kiểm tra số lượng kết quả trả về
        if ($result->total > 0) {
            return true;
        } else {
            return false;
        }
    }

    // Đếm số lượng học sinh trong lớp
    public function countStudentInClass($MaLop, $NamHoc)
    {
        $SQl = "SELECT COUNT(MaHS) as SoLuongHS
                FROM hocsinh_lop
                WHERE MaLop = ? AND NamHoc = ?";
        $query = $this->db->query($SQl, [$MaLop, $NamHoc]);
        $result = $query->getRowArray();
        return $result ? $result['SoLuongHS'] : 0;
    }

    // Thêm học sinh vào lớp học trong năm học
    public function addStudentToClass($MaHS, $MaLop, $NamHoc)
    {
        $data = [
            'MaHS' => $MaHS,
            'MaLop' => $MaLop,
            'NamHoc' => $NamHoc
        ];
        $this->insert($data);
    }

    // Lấy danh sách học sinh chưa được xếp lớp trong năm học 
    // (loại bỏ những học sinh lớp 12 năm trước đó)
    public function getStudentNotInClass($NamHoc)
    {
        $SQL = "SELECT hocsinh.MaHS, taikhoan.HoTen, taikhoan.NgaySinh
                FROM hocsinh
                JOIN taikhoan ON hocsinh.MaTK = taikhoan.MaTK
                LEFT JOIN hocsinh_lop ON hocsinh.MaHS = hocsinh_lop.MaHS 
                AND hocsinh_lop.NamHoc = ?
                WHERE hocsinh_lop.MaHS IS NULL
                AND hocsinh.MaHS NOT IN (
                    SELECT MaHS
                    FROM hocsinh_lop
                    WHERE NamHoc = CONCAT(SUBSTRING(?, 1, 4) - 1, '-', SUBSTRING(?, 6, 4) - 1) AND (MaLop = 5 OR MaLop = 6)
                )";
        return $this->db->query($SQL, [$NamHoc, $NamHoc, $NamHoc])->getResultArray();
                
    }
}
