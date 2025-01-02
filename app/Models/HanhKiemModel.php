<?php

namespace App\Models;

use CodeIgniter\Model;

class HanhKiemModel extends Model
{
    protected $table = 'hanhkiem';
    protected $primaryKey = 'MaHK';
    protected $allowedFields = [
        'MaHS',
        'HocKy',
        'NamHoc',
        'DiemHK',
        'TrangThai'
    ];

    // Thêm thông tin hạnh kiểm của học sinh dựa vào mã học sinh, năm học
    public function addConduct($MaHS, $NamHoc)
    {
        $data = [
            'MaHS' => $MaHS,
            'HocKy' => 1,
            'NamHoc' => $NamHoc,
            'DiemHK' => 100 // Mặc định điểm hạnh kiểm là 100
        ];
        $this->insert($data);

        $data = [
            'MaHS' => $MaHS,
            'HocKy' => 2,
            'NamHoc' => $NamHoc,
            'DiemHK' => 100 // Mặc định điểm hạnh kiểm là 100
        ];
        $this->insert($data);
        return true;
    }

    // Đếm số lượng học sinh bị cảnh cáo trong năm học (điểm hạnh kiểm < 50)
    public function countWarnedStudent($NamHoc)
    {
        $SQL = "SELECT COUNT(MaHS) as SoLuongHS
                FROM hanhkiem
                WHERE NamHoc = ? AND DiemHK < 50";
        $query = $this->db->query($SQL, [$NamHoc]);
        $result = $query->getRowArray();
        return $result ? $result['SoLuongHS'] : 0;
    }

    // Hàm tính phần trăm sự thay đổi (tăng/giảm) số lượng học sinh bị cảnh cáo so với năm trước
    public function countWarnedStudentChange($currentYear, $previousYear)
    {
        $currentYearCount = $this->countWarnedStudent($currentYear);
        $previousYearCount = $this->countWarnedStudent($previousYear);

        if ($previousYearCount == 0) {
            return $currentYearCount > 0 ? 100 : 0;
        } else {
            return (($currentYearCount - $previousYearCount) / $previousYearCount) * 100;
        }
    }

    // Hàm lấy số lượng học sinh bị cảnh cáo theo từng qua các năm học
    public function getWarnedStudentData()
    {
        $SQL = "SELECT NamHoc, COUNT(MaHS) AS SoLuongHS
                FROM hanhkiem
                WHERE DiemHK < 50
                GROUP BY NamHoc";
        return $this->db->query($SQL)->getResultArray();
    }

    // Xếp loại hạnh kiểm của học sinh
    public function getConductRank($DiemHK)
    {
        if ($DiemHK >= 80) {
            return 'Tốt';
        } elseif ($DiemHK >= 65) {
            return 'Khá';
        } elseif ($DiemHK >= 50) {
            return 'Trung bình';
        } else {
            return 'Yếu';
        }
    }

    // Đếm số lượng từng loại hạnh kiểm của học sinh trong học kỳ và năm học
    public function countConductRank($Khoi, $HocKy, $NamHoc)
    {
        $SQL = "SELECT hanhkiem.DiemHK
            FROM hanhkiem
            JOIN hocsinh_lop ON hanhkiem.MaHS = hocsinh_lop.MaHS 
            AND hocsinh_lop.NamHoc = ?
            JOIN lop ON hocsinh_lop.MaLop = lop.MaLop
            WHERE lop.TenLop LIKE ?
            AND hanhkiem.HocKy = ?
            AND hanhkiem.NamHoc = ?";

        // Sử dụng ?_% để lọc đúng định dạng tên lớp
        $TenLopPattern = $Khoi . '_%';
        $result = $this->db->query($SQL, [$NamHoc, $TenLopPattern, $HocKy, $NamHoc])->getResultArray();

        // Nếu không có dữ liệu, trả về mảng đếm rỗng
        if (empty($result)) {
            return [
                'Tốt' => 0,
                'Khá' => 0,
                'Trung bình' => 0,
                'Yếu' => 0
            ];
        }

        $counts = [
            'Tốt' => 0,
            'Khá' => 0,
            'Trung bình' => 0,
            'Yếu' => 0
        ];

        foreach ($result as $row) {
            $rank = $this->getConductRank($row['DiemHK']);
            $counts[$rank]++;
        }

        return $counts;
    }

    // Lấy dánh sách top 20 học sinh có điểm hạnh kiểm thấp nhất trong học kỳ và năm học
    public function getTopWarnedStudent($HocKy, $NamHoc)
    {
        $SQL = "SELECT hocsinh.MaHS, taikhoan.HoTen, lop.TenLop, hanhkiem.DiemHK, COUNT(vipham.MaVP) AS SoLanViPham, hanhkiem.TrangThai
                    FROM hocsinh
                    JOIN taikhoan ON hocsinh.MaTK = taikhoan.MaTK
                    JOIN hocsinh_lop ON hocsinh.MaHS = hocsinh_lop.MaHS
                    AND hocsinh_lop.NamHoc = ?
                    JOIN lop ON hocsinh_lop.MaLop = lop.MaLop
                    JOIN hanhkiem ON hocsinh.MaHS = hanhkiem.MaHS
                    LEFT JOIN vipham ON hocsinh.MaHS = vipham.MaHS
                    WHERE hanhkiem.HocKy = ? AND hanhkiem.NamHoc = ?
                    GROUP BY hocsinh.MaHS, taikhoan.HoTen, lop.TenLop, hanhkiem.DiemHK, hanhkiem.TrangThai
                    ORDER BY hanhkiem.DiemHK ASC, SoLanViPham DESC, lop.TenLop ASC
                    LIMIT 20";
        return $this->db->query($SQL, [$NamHoc, $HocKy, $NamHoc])->getResultArray();
    }

    // Lấy điểm hạnh kiểm của học sinh trong học kỳ và năm học dựa vào MaHS, HocKy, NamHoc
    public function getConductScore($MaHS, $HocKy, $NamHoc)
    {
        $SQL = "SELECT DiemHK
                FROM hanhkiem
                WHERE MaHS = ? AND HocKy = ? AND NamHoc = ?";
        $query = $this->db->query($SQL, [$MaHS, $HocKy, $NamHoc]);
        $result = $query->getRowArray();
        return $result ? $result['DiemHK'] : 0;
    }
}
