<?php

namespace App\Models;

use CodeIgniter\Model;

class HoaDonModel extends Model
{
    protected $table      = 'hoadon';
    protected $primaryKey = 'MaHD';
    protected $allowedFields = ['MaHS', 'NamHoc', 'TongHocPhi', 'DaThanhToan', 'ConNo', 'TrangThai'];


    public function addInvoice($studentId, $NamHoc) {
        // Lấy mức học phí tương ứng từ bảng thamso
        $SQL = "SELECT GiaTri 
        FROM thamso 
        WHERE TenThamSo = ?";

        // Tạo tên tham số dựa trên năm học
        $paramName = 'MucHocPhiNamHoc' . str_replace('-', '_', $NamHoc);
        $query = $this->db->query($SQL, [$paramName]);
        $row = $query->getRow();

        $TongHocPhi = $row->GiaTri;

        // Chèn hóa đơn mới vào bảng hoadon
        $SQL = "INSERT INTO hoadon (MaHS, NamHoc, TongHocPhi, DaThanhToan, ConNo, TrangThai)
            VALUES (?, ?, ?, 0, ?, 'Chưa thanh toán')";

        // Số nợ ban đầu = Tổng học phí
        $this->db->query($SQL, [$studentId, $NamHoc, $TongHocPhi, $TongHocPhi]);

        return true; // Thêm hóa đơn thành công
    }


    // Lấy tất cả danh sách hóa đơn
    public function getAllInvoices($selectedStatus, $selectedYear, $searchStudent)
    {
        // Tạo điều kiện SQL động
    $SQL = "SELECT * FROM hoadon WHERE 1=1"; // Luôn đúng để nối điều kiện

    // Mảng chứa tham số truyền vào truy vấn
    $params = [];

    // Kiểm tra trạng thái
    if ($selectedStatus !== 'Chọn trạng thái') {
        $SQL .= " AND TrangThai = ?";
        $params[] = $selectedStatus;
    }

    // Kiểm tra năm học
    if ($selectedYear !== 'Chọn năm học') {
        $SQL .= " AND NamHoc = ?";
        $params[] = $selectedYear;
    }

    // Tìm kiếm học sinh
    if (!empty($searchStudent)) {
        $SQL .= " AND MaHS LIKE ?";
        $params[] = '%' . $searchStudent . '%';
    }

    // Thực thi truy vấn với các tham số
    $result = $this->db->query($SQL, $params)->getResultArray();

    return $result; // Trả về danh sách hóa đơn
    }

    public function getInvoiceByPaymentId($paymentId){
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

    public function updateInvoice($invoiceId, $paymentAmount) {
    
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
