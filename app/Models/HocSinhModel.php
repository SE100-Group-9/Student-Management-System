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

    // Lấy danh sách học sinh và điểm số theo năm học
    public function getStudentListByYear($grade, $year)
    {
        $SQL = "SELECT DISTINCT hocsinh.MaHS, taikhoan.HoTen, lop.TenLop
                FROM hocsinh
                JOIN taikhoan ON hocsinh.MaTK = taikhoan.MaTK
                JOIN hocsinh_lop ON hocsinh.MaHS = hocsinh_lop.MaHS AND hocsinh_lop.NamHoc = ?
                JOIN lop ON hocsinh_lop.MaLop = lop.MaLop ";
                
        // Lọc theo khối lớp (ví dụ: 10, 11, 12)
        $gradePrefix = $grade . "_"; // Ví dụ: 10_ hoặc 11_ hoặc 12_
        $SQL .= "WHERE lop.TenLop LIKE ? ";

        // Tham số cho câu truy vấn
        $params = [$year, $gradePrefix . '%'];

        //Tiến hành truy vấn và trả về kết quả
        $SQL .= "ORDER BY hocsinh.MaHS";
        return $this->db->query($SQL, $params)->getResultArray();
    }

    // Lấy danh sách học sinh (MaHS, HoTen) dựa vào MaGV phụ trách lớp, năm học và học kỳ
    public function getStudentListByTeacher($MaGV, $HocKy, $NamHoc)
    {
        $SQL = "SELECT DISTINCT hocsinh.MaHS, taikhoan.HoTen
                FROM phancong
                JOIN hocsinh_lop ON phancong.MaLop = hocsinh_lop.MaLop 
                    AND phancong.NamHoc = hocsinh_lop.NamHoc
                    AND hocsinh_lop.NamHoc = ?
                JOIN hocsinh ON hocsinh_lop.MaHS = hocsinh.MaHS
                JOIN taikhoan ON hocsinh.MaTK = taikhoan.MaTK
                WHERE phancong.MaGV = ? AND phancong.HocKy = ? AND phancong.NamHoc = ? AND phancong.VaiTro = 'Giáo viên bộ môn'";
        return $this->db->query($SQL, [$NamHoc, $MaGV, $HocKy, $NamHoc])->getResultArray();
    }
    public function isValidStudentCode($MaHS) {
        $SQL = "SELECT COUNT(*) AS count FROM hocsinh WHERE MaHS = ?";
        $result = $this->db->query($SQL, [$MaHS])->getRowArray();
        return !empty($result['count']) && $result['count'] > 0;
    }

    public function isValidStudentName($MaHS, $HoTen) {
        $SQL = "SELECT COUNT(*) AS count FROM hocsinh JOIN taikhoan ON hocsinh.MaTK = taikhoan.MaTK WHERE MaHS = ? AND HoTen = ?";
        $result = $this->db->query($SQL, [$MaHS, $HoTen])->getRowArray();
        return !empty($result['count']) && $result['count'] > 0;
    }

    public function getCurrentStudent() {
        $StudentModel = new HocSinhModel();

        // Lấy thông tin tài khoản hiện tại
        $MaTK = session('MaTK');

        // Lấy thông tin học sinh
        $Student = $StudentModel
            ->select('hocsinh.*, taikhoan.*')
            ->join('taikhoan', 'taikhoan.MaTK = hocsinh.MaTK')
            ->where('hocsinh.MaTK', $MaTK)
            ->first();
        return  $Student;
    }

    public function getStudentRank($MaHS, $MaLop, $HocKi, $NamHoc, $DTB) {
        // Truy vấn để lấy danh sách học sinh trong lớp, xếp theo điểm trung bình giảm dần
            $SQL = "SELECT 
            hs.MaHS,
            tk.HoTen,
            dtb.DTB,
            RANK() OVER (ORDER BY dtb.DTB DESC) AS XepHang
        FROM 
            diemtrungbinh dtb
        JOIN hocsinh hs ON dtb.MaHS = hs.MaHS
        JOIN taikhoan tk ON hs.MaTK = tk.MaTK
        JOIN hocsinh_lop hl ON hs.MaHS = hl.MaHS
        WHERE 
            hl.MaLop = ? 
            AND dtb.HocKi = ?
            AND dtb.NamHoc = ?";

        // Tham số truyền vào câu lệnh SQL
        $params = [$MaLop, $HocKi, $NamHoc];

        // Thực thi truy vấn
        $result = $this->db->query($SQL, $params)->getResultArray();

        // Tìm vị trí của học sinh hiện tại dựa trên mã học sinh
        $rank = "Chưa xếp hạng"; // Giá trị mặc định
        foreach ($result as $row) {
        if ($row['MaHS'] == $MaHS) {
            $rank = $row['XepHang']; // Gán thứ hạng
            break;
            }
        }
        // Trả về thứ hạng
        return $rank;
    }

    public function getCurrentClass($MaHS, $NamHoc) {
        $SQL = "SELECT MaLop FROM hocsinh_lop WHERE MaHS = ? AND NamHoc = ?";
        $result = $this->db->query($SQL, [$MaHS, $NamHoc])->getRowArray();
        return $result['MaLop'];
    }


}
