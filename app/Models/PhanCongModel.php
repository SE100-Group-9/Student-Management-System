<?php

namespace App\Models;

use CodeIgniter\Model;

class PhanCongModel extends Model
{
    protected $table      = 'PHANCONG';
    protected $primaryKey = 'MaPC';
    protected $allowedFields = ['MaGV', 'MaMH', 'MaLop', 'HocKy', 'NamHoc', 'VaiTro'];

    // Lấy danh sách môn học được phân công dạy dựa vào năm học, học kỳ và tên lớp
    public function getSubjectList($year, $semester, $class)
    {
        $SQL = "SELECT DISTINCT phancong.MaMH FROM phancong
                JOIN lop ON phancong.MaLop = lop.MaLop
                WHERE phancong.NamHoc = ? AND phancong.HocKy = ? AND lop.TenLop = ?";
        return $this->db->query($SQL, [$year, $semester, $class])->getResultArray();
    }

    // Kiểm tra giáo viên đã được phân công dạy môn học trong năm học, học kỳ và lớp học đó chưa
    public function isTeacherAssigned($MaGV, $MaMH, $MaLop, $HocKy, $NamHoc)
    {
        $SQL = "SELECT COUNT(*) AS total
                FROM phancong
                WHERE MaGV = ? AND MaMH = ? AND MaLop = ? AND HocKy = ? AND NamHoc = ?";
        $query = $this->db->query($SQL, [$MaGV, $MaMH, $MaLop, $HocKy, $NamHoc]);
        $result = $query->getRow();

        // Kiểm tra số lượng kết quả trả về
        if ($result->total > 0) {
            return true;
        } else {
            return false;
        }
    }

    // Kiểm tra môn học đã có giáo viên phân công dạy trong năm học, học kỳ và lớp học đó chưa
    public function isSubjectAssigned($MaMH, $MaLop, $HocKy, $NamHoc)
    {
        $SQL = "SELECT COUNT(*) AS total
                FROM phancong
                WHERE MaMH = ? AND MaLop = ? AND HocKy = ? AND NamHoc = ?";
        $query = $this->db->query($SQL, [$MaMH, $MaLop, $HocKy, $NamHoc]);
        $result = $query->getRow();

        // Kiểm tra số lượng kết quả trả về
        if ($result->total > 0) {
            return true;
        } else {
            return false;
        }
    }

    // Thêm phân công giáo viên dạy môn học vào lớp học trong năm học và học kỳ
    public function addTeacherToAssign($MaGV, $MaMH, $MaLop, $HocKy, $NamHoc)
    {
        $data = [
            'MaGV' => $MaGV,
            'MaMH' => $MaMH,
            'MaLop' => $MaLop,
            'HocKy' => $HocKy,
            'NamHoc' => $NamHoc,
            'VaiTro' => 'Giáo viên bộ môn'
        ];
        $this->insert($data);
    }

    // Lấy danh sách năm học được phân công giảng dạy
    public function getAssignedYears()
    {
        $SQL = "SELECT DISTINCT NamHoc FROM phancong
                ORDER BY NamHoc DESC";
        return $this->db->query($SQL)->getResultArray();
    }

    // Lấy danh sách năm học được phân công giảng dạy dựa vào mã giáo viên
    public function getAssignedYearsByTeacher($MaGV)
    {
        $SQL = "SELECT DISTINCT NamHoc FROM phancong
                WHERE MaGV = ?
                ORDER BY NamHoc DESC";
        return $this->db->query($SQL, [$MaGV])->getResultArray();
    }

    // Lấy danh sách lớp học được phân công giảng dạy dựa vào mã giáo viên và năm học
    public function getAssignedClasses($MaGV, $NamHoc)
    {
        $SQL = "SELECT DISTINCT lop.TenLop
                FROM phancong
                JOIN lop ON phancong.MaLop = lop.MaLop
                WHERE phancong.MaGV = ? AND phancong.NamHoc = ?
                ORDER BY lop.TenLop";
        return $this->db->query($SQL, [$MaGV, $NamHoc])->getResultArray();
    }

    // Lấy danh sách lớp học được phân công giảng dạy dựa vào mã giáo viên, năm học và học kỳ
    public function getAssignedClassesBySemester($MaGV, $NamHoc, $HocKy)
    {
        $SQL = "SELECT DISTINCT lop.TenLop
                FROM phancong
                JOIN lop ON phancong.MaLop = lop.MaLop
                WHERE phancong.MaGV = ? AND phancong.NamHoc = ? AND phancong.HocKy = ? AND VaiTro = 'Giáo viên bộ môn'
                ORDER BY lop.TenLop";
        return $this->db->query($SQL, [$MaGV, $NamHoc, $HocKy])->getResultArray();
    }

}
