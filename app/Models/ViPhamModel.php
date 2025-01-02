<?php

namespace App\Models;

use CodeIgniter\Model;

class ViPhamModel extends Model
{
    protected $table      = 'vipham';
    protected $primaryKey = 'MaVP';
    
    public function getAllVP($selectedSemester, $selectedYear, $search)
    {   
                    // Tạo câu lệnh SQL với JOIN để lấy thêm thông tin từ các bảng liên quan
            $SQL = "SELECT 
            vp.MaVP,
            vp.MaHS, 
            vp.HocKy AS HocKi,
            vp.NamHoc,
            tk_hs.HoTen AS TenHS, 
            l.TenLop, 
            lv.TenLVP, 
            lv.DiemTru, 
            tk_gt.HoTen AS TenGT
        FROM 
            vipham vp
        JOIN 
            hocsinh hs ON vp.MaHS = hs.MaHS
        JOIN 
            taikhoan tk_hs ON hs.MaTK = tk_hs.MaTK
        JOIN 
            giamthi gt ON vp.MaGT = gt.MaGT
        JOIN 
            taikhoan tk_gt ON gt.MaTK = tk_gt.MaTK
        JOIN 
            loaivipham lv ON vp.MaLVP = lv.MaLVP
        JOIN 
            lop l ON vp.MaLop = l.MaLop
        WHERE 1=1";  // Điều kiện mặc định để có thể thêm các điều kiện khác vào sau

        // Tạo mảng tham số để truyền vào câu truy vấn
        $params = [];

        // Nếu có tìm kiếm theo MaHS, TenHS, TenLop
        if (!empty($search)) {
        $SQL .= " AND (vp.MaHS LIKE ? OR tk_hs.HoTen LIKE ? OR l.TenLop LIKE ?)";
        $params[] = "%" . $search . "%";  // MaHS
        $params[] = "%" . $search . "%";  // TenHS
        $params[] = "%" . $search . "%";  // TenLop
        }

        // Nếu có tìm kiếm theo HocKy và NamHoc
        if ($selectedSemester !== 'Chọn học kì' && !empty($selectedSemester)) {
        $SQL .= " AND vp.HocKy = ?";
        $params[] = $selectedSemester;
        }

        if ($selectedYear !== 'Chọn năm học' && !empty($selectedYear)) {
        $SQL .= " AND vp.NamHoc = ?";
        $params[] = $selectedYear;
        }

        // Thực thi truy vấn với các tham số đã được thêm vào
        $result = $this->db->query($SQL, $params)->getResultArray();

        return $result; // Trả về kết quả tìm kiếm
    }



    public function getVPById($faultId) {
                // Tạo câu lệnh SQL với JOIN để lấy thêm thông tin từ các bảng liên quan
                $SQL = "SELECT 
                vp.MaVP,
                vp.MaHS, 
                vp.HocKy AS HocKi,
                vp.NamHoc,
                tk_hs.HoTen AS TenHS, 
                l.TenLop, 
                lv.TenLVP, 
                lv.DiemTru, 
                tk_gt.HoTen AS TenGT
            FROM 
                vipham vp
            JOIN 
                hocsinh hs ON vp.MaHS = hs.MaHS
            JOIN 
                taikhoan tk_hs ON hs.MaTK = tk_hs.MaTK
            JOIN 
                giamthi gt ON vp.MaGT = gt.MaGT
            JOIN 
                taikhoan tk_gt ON gt.MaTK = tk_gt.MaTK
            JOIN 
                loaivipham lv ON vp.MaLVP = lv.MaLVP
            JOIN 
                lop l ON vp.MaLop = l.MaLop
            WHERE 
                vp.MaVP = ?";

            $result = $this->db->query($SQL, [$faultId])->getRowArray();

    
            return $result; 
  }

    public function addVP($data) {

        return $this->db->table($this->table)->insert($data);
    }

    public function updateLVP($categoryId, $data) {

        return $this->db->table($this->table)
        ->where('MaLVP', $categoryId) // Điều kiện cập nhật
        ->update($data);    // Dữ liệu cần cập nhật
    }

    public function deleteVP($faultId) {

         // Tạo câu SQL cơ bản
         $SQL = "DELETE FROM vipham Where MaVP=?";

         // Thực thi truy vấn và trả về kết quả mảng 1 chiều 
         return $this->db->query($SQL, [$faultId]);
    }


}
