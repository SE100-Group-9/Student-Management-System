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

    // Đếm số lượng học sinh nhập học lần đầu trong năm học
    public function countEnrolledStudent($NamHoc)
    {
        $SQL = "SELECT COUNT(DISTINCT MaHS) as SoLuongHS
                FROM hocsinh_lop
                WHERE NamHoc = ?
                AND MaHS NOT IN (
                    SELECT MaHS
                    FROM hocsinh_lop
                    WHERE NamHoc < ?
                )";
        $query = $this->db->query($SQL, [$NamHoc, $NamHoc]);
        $result = $query->getRowArray();
        return $result ? $result['SoLuongHS'] : 0;
    }
    // Hàm tính phần trăm sự thay đổi (tăng/giảm) số lượng học sinh nhập học lần đầu so với năm trước
    public function countEnrolledStudentChange($currentYear, $previousYear)
    {
        $currentYearCount = $this->countEnrolledStudent($currentYear);
        $previousYearCount = $this->countEnrolledStudent($previousYear);

        if ($previousYearCount == 0) {
            return $currentYearCount > 0 ? 100 : 0;
        } else {
            return (($currentYearCount - $previousYearCount) / $previousYearCount) * 100;
        }
    }

    // Hàm lấy dữ liệu nhập học lần đầu của học sinh qua các năm học
    public function getEnrolledStudentData()
    {
        $SQL = "SELECT NamHoc, COUNT(DISTINCT MaHS) AS SoLuongHS
                FROM hocsinh_lop hsl_1
                WHERE MaHS NOT IN (
                    SELECT MaHS
                    FROM hocsinh_lop hsl_2
                    WHERE hsl_2.NamHoc < hsl_1.NamHoc
                )
                GROUP BY NamHoc";
        return $this->db->query($SQL)->getResultArray();
    }

    // Đếm tổng số học sinh trong năm học
    public function countTotalStudent($NamHoc)
    {
        $SQL = "SELECT COUNT(DISTINCT hocsinh.MaHS) as SoLuongHS
                FROM hocsinh_lop
                JOIN hocsinh ON hocsinh_lop.MaHS = hocsinh.MaHS
                WHERE hocsinh.TinhTrang = 'Đang học' AND NamHoc = ?";
        $query = $this->db->query($SQL, [$NamHoc]);
        $result = $query->getRowArray();
        return $result ? $result['SoLuongHS'] : 0;
    }

    // Hàm tính phần trăm sự thay đổi (tăng/giảm) tổng số học sinh so với năm trước
    public function countTotalStudentChange($currentYear, $previousYear)
    {
        $currentYearCount = $this->countTotalStudent($currentYear);
        $previousYearCount = $this->countTotalStudent($previousYear);

        if ($previousYearCount == 0) {
            return $currentYearCount > 0 ? 100 : 0;
        } else {
            return (($currentYearCount - $previousYearCount) / $previousYearCount) * 100;
        }
    }

    // Lấy danh sách học sinh được xếp lớp dựa vào Tên lớp và Năm học được chọn
    public function getStudentInClass($TenLop, $NamHoc)
    {
        $SQL = "SELECT hocsinh.*, taikhoan.*
                FROM hocsinh_lop
                JOIN lop ON hocsinh_lop.MaLop = lop.MaLop
                JOIN hocsinh ON hocsinh_lop.MaHS = hocsinh.MaHS
                JOIN taikhoan ON hocsinh.MaTK = taikhoan.MaTK
                WHERE lop.TenLop = ? AND hocsinh_lop.NamHoc = ?
                ORDER BY hocsinh.MaHS";
        return $this->db->query($SQL, [$TenLop, $NamHoc])->getResultArray();
    }
}
