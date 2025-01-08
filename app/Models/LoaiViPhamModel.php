<?php

namespace App\Models;

use CodeIgniter\Model;

class LoaiViPhamModel extends Model
{
    protected $table      = 'loaivipham';
    protected $primaryKey = 'MaLVP';
    
    public function getLVP($searchLVP) {
        // Tạo câu SQL cơ bản
        $SQL = "SELECT TenLVP FROM loaivipham";
    
        // Thêm điều kiện tìm kiếm nếu có từ khóa
        if (!empty($searchLVP)) {
            $SQL .= " WHERE TenLVP LIKE '%" . $this->db->escapeLikeString($searchLVP) . "%'";
        }
    
        // Lấy dữ liệu dưới dạng mảng hai chiều
        $result = $this->db->query($SQL)->getResultArray();
    
        // Chuyển đổi sang mảng một chiều chứa các giá trị TenLVP
        $LVPList = array_column($result, 'TenLVP');
    
        return $LVPList;
    }

    public function getLVP2($searchLVP) {
                // Tạo câu SQL cơ bản
            $SQL = "SELECT * FROM loaivipham";

            // Thêm điều kiện tìm kiếm nếu có từ khóa
            if (!empty($searchLVP)) {
                $SQL .= " WHERE TenLVP LIKE '%" . $this->db->escapeLikeString($searchLVP) . "%'";
            }

            // Thực thi truy vấn và trả về kết quả mảng 2 chiều 
            return $this->db->query($SQL)->getResultArray();
    }

    public function getMaLVP($TenLVP) {
            // Câu lệnh SQL để lấy MaLVP dựa trên TenLVP
        $SQL = "SELECT MaLVP FROM loaivipham WHERE TenLVP = ?";
        
        // Thực hiện truy vấn và lấy kết quả
        $result = $this->db->query($SQL, [$TenLVP])->getRowArray();
        
        // Kiểm tra và trả về MaLVP
        return $result['MaLVP'];
    } 

    public function getLVPByCategoryId($categoryId) {
        // Tạo câu SQL cơ bản
        $SQL = "SELECT * FROM loaivipham Where MaLVP=?";


        // Thực thi truy vấn và trả về kết quả mảng 1 chiều 
        return $this->db->query($SQL, [$categoryId])->getRowArray();
  }

    public function addLVP($data) {

        return $this->db->table($this->table)->insert($data);
    }

    public function updateLVP($categoryId, $data) {

        return $this->db->table($this->table)
        ->where('MaLVP', $categoryId) // Điều kiện cập nhật
        ->update($data);    // Dữ liệu cần cập nhật
    }

    public function deleteLVP($categoryId) {

         // Tạo câu SQL cơ bản
         $SQL = "DELETE FROM loaivipham Where MaLVP=?";

         // Thực thi truy vấn và trả về kết quả mảng 1 chiều 
         return $this->db->query($SQL, [$categoryId]);
    }


}
