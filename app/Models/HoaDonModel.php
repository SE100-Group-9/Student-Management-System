<?php

namespace App\Models;

use CodeIgniter\Model;

class HoaDonModel extends Model
{
    protected $table      = 'hoadon';
    protected $primaryKey = 'MaHD';
    protected $allowedFields = ['MaHS', 'NamHoc', 'TongHocPhi', 'DaThanhToan', 'ConNo', 'TrangThai'];

    // Thêm hóa đơn học phí cho học sinh dựa vào MaHS, NamHoc, TongHocPhi
    public function addInvoice($studentId, $year, $totalAmount)
    {
        $data = [
            'MaHS' => $studentId,
            'NamHoc' => $year,
            'TongHocPhi' => $totalAmount,
            'DaThanhToan' => 0,
            'ConNo' => $totalAmount,
            'TrangThai' => 'Chưa thanh toán'
        ];

        $this->insert($data);
    }


    // Lấy tất cả danh sách hóa đơn
    public function getAllInvoices($selectedStatus, $selectedYear, $searchStudent)
    {
        // Tạo câu lệnh SQL với JOIN để lấy thêm thông tin từ các bảng liên quan
        $SQL = "SELECT 
            hoadon.MaHD, 
            hoadon.MaHS, 
            hoadon.NamHoc, 
            hoadon.TongHocPhi, 
            hoadon.DaThanhToan, 
            hoadon.ConNo, 
            hoadon.TrangThai, 
            taikhoan.HoTen, 
            lop.TenLop,
             (SELECT ptt.NgayThanhToan
                 FROM phieuthanhtoan ptt
                 WHERE ptt.MaHD = hoadon.MaHD
                 ORDER BY ptt.MaPTT DESC
                 LIMIT 1) AS NgayThanhToan
        FROM 
            hoadon
        JOIN hocsinh ON hoadon.MaHS = hocsinh.MaHS
        JOIN taikhoan ON hocsinh.MaTK = taikhoan.MaTK
        JOIN hocsinh_lop ON hoadon.MaHS = hocsinh_lop.MaHS AND hoadon.NamHoc = hocsinh_lop.NamHoc
        JOIN lop ON hocsinh_lop.MaLop = lop.MaLop
        WHERE 1=1"; // Luôn đúng để nối điều kiện động

        // Mảng chứa tham số truyền vào
        $params = [];

        // Kiểm tra trạng thái
        if ($selectedStatus !== 'Chọn trạng thái') {
            $SQL .= " AND hoadon.TrangThai = ?";
            $params[] = $selectedStatus;
        }

        // Kiểm tra năm học
        if ($selectedYear !== 'Chọn năm học') {
            $SQL .= " AND hoadon.NamHoc = ?";
            $params[] = $selectedYear;
        }

        // Tìm kiếm học sinh (theo Mã học sinh hoặc Họ tên)
        if (!empty($searchStudent)) {
            $SQL .= " AND (hoadon.MaHS LIKE ? OR taikhoan.HoTen LIKE ?)";
            $params[] = '%' . $searchStudent . '%';
            $params[] = '%' . $searchStudent . '%';
        }
        
        // Loại bỏ kết quả trùng lặp bằng cách nhóm theo MaHD
        // $SQL .= " GROUP BY hoadon.MaHD";

         // Loại bỏ kết quả trùng lặp bằng cách nhóm theo MaHD và lấy MaPTT cao nhất
            $SQL .= " GROUP BY hoadon.MaHD";

        // Thực thi truy vấn với các tham số
        $result = $this->db->query($SQL, $params)->getResultArray();

        return $result; // Trả về danh sách hóa đơn với thông tin mở rộng
    }

    public function getInvoiceByInvoiceId($invoiceId, $cashierId)
    {
        $SQL = "SELECT 
            hoadon.MaHD, 
            hoadon.MaHS, 
            hoadon.NamHoc, 
            hoadon.TongHocPhi, 
            hoadon.DaThanhToan, 
            hoadon.ConNo, 
            hoadon.TrangThai, 
            thungan.MaTN,
            hs_taikhoan.HoTen AS HoTenHocSinh, 
            lop.TenLop, 
            tn_taikhoan.HoTen AS HoTenThuNgan
        FROM 
            hoadon
        JOIN hocsinh ON hoadon.MaHS = hocsinh.MaHS
        JOIN taikhoan AS hs_taikhoan ON hocsinh.MaTK = hs_taikhoan.MaTK
        JOIN hocsinh_lop ON hoadon.MaHS = hocsinh_lop.MaHS AND hoadon.NamHoc = hocsinh_lop.NamHoc
        JOIN lop ON hocsinh_lop.MaLop = lop.MaLop
        Join thungan on thungan.MaTN =  ?
        JOIN taikhoan AS tn_taikhoan ON tn_taikhoan.MaTK = thungan.MaTK
        WHERE 
            hoadon.MaHD = ?";
        $query = $this->db->query($SQL, [$cashierId, $invoiceId]);
        return $query->getRowArray();
    }

    public function getInvoiceByPaymentId($paymentId)
    {
        // Truy vấn SQL để lấy thông tin MaHD và DaThanhToan từ phiếu thanh toán
        $SQL = "
            SELECT MaHD, DaThanhToan
            FROM phieuthanhtoan
            WHERE MaPTT = ?
        ";

        // Thực thi truy vấn và trả về kết quả
        $query = $this->db->query($SQL, [$paymentId]);
        return $query->getRowArray(); // Lấy một dòng dữ liệu dạng mảng

    }

    public function updateInvoice($invoiceId, $paymentAmount)
    {

        $invoiceModel = new HoaDonModel();
        // Lấy thông tin hóa đơn hiện tại
        $invoice = $invoiceModel->find($invoiceId);

        // Cập nhật lại số tiền đã thanh toán
        $newPaidAmount = $invoice['DaThanhToan'] + $paymentAmount;

        // Tính toán lại số nợ
        $debt = $invoice['TongHocPhi'] - $newPaidAmount;

        // Xác định trạng thái thanh toán
        if ($newPaidAmount >= $invoice['TongHocPhi']) {
            $status = 'Đã thanh toán';
        } elseif ($newPaidAmount > 0) {
            $status = 'Thanh toán 1 phần';
        } else {
            $status = 'Chưa thanh toán';
        }

        // Cập nhật dữ liệu hóa đơn
        $data = [
            'DaThanhToan' => $newPaidAmount,
            'ConNo' => $debt,
            'TrangThai' => $status
        ];

        // Thực hiện cập nhật
        $invoiceModel->update($invoiceId, $data);

        return true; // Cập nhật thành công
    }
}
