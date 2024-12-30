<?php

namespace App\Models;

use CodeIgniter\Model;

class ThanhToanModel extends Model
{
    protected $table      = 'phieuthanhtoan';
    protected $primaryKey = 'MaPTT';

    // Lấy tất cả danh sách hóa đơn
    public function getAllPaymentsByInvoiceId($invoiceId)
    {
        $SQL = "
        SELECT 
            ptt.*, 
            tk.HoTen 
        FROM 
            phieuthanhtoan ptt
        JOIN 
            thungan tg ON ptt.MaTN = tg.MaTN
        JOIN 
            taikhoan tk ON tg.MaTK = tk.MaTK
        WHERE 
            ptt.MaHD = ?
    ";
        $result = $this->db->query($SQL,[$invoiceId])->getResultArray();
        return $result;
    }

    public function insertPayment($MaHD, $MaTN, $DaThanhToan, $NgayThanhToan) {
        $sql = "INSERT INTO phieuthanhtoan (MaHD, MaTN, DaThanhToan, NgayThanhToan)
            VALUES (?, ?, ?, ?)";

        // Thực thi SQL với dữ liệu đầu vào
        $result = $this->db->query($sql, [
            $MaHD,
            $MaTN,
            $DaThanhToan, $NgayThanhToan
        ]);

        return $result;
    }


}
