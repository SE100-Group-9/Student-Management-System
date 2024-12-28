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
         // Lấy tất cả danh sách hóa đơn với thông tin chi tiết
        $SQL = "SELECT * FROM phieuthanhtoan WHERE MaHD = ?";
       // In kết quả trả về để kiểm tra
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
