<?php

namespace App\Models;

use System\DesignPatterns\Creational\Singleton\ManualDatabaseConnection;


class HocSinhModelUseManualSingleton
{
    public function getStudentList($year, $semester, $class)
    {
        // ✅ Dùng Singleton thủ công
        $conn = ManualDatabaseConnection::getInstance()->getConnection();

        $sql = "SELECT DISTINCT hocsinh.MaHS, taikhoan.HoTen, lop.TenLop, monhoc.MaMH, monhoc.TenMH,
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

        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            log_message('error', '❌ Lỗi prepare SQL: ' . $conn->error);
            return [];
        }

        // ✅ Gán tham số
        $stmt->bind_param("sssss", $year, $year, $semester, $year, $class);

        $stmt->execute();
        $result = $stmt->get_result();

        // ✅ Trả kết quả dạng mảng
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
