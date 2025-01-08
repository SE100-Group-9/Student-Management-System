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

    public function updateConductScore($MaHS, $HocKy, $NamHoc) {
        // Bước 1: Lấy tổng điểm trừ của học sinh trong học kỳ và năm học
        $SQL_DiemTru = "SELECT SUM(lvp.DiemTru) AS DiemTru
                        FROM vipham vp
                        INNER JOIN loaivipham lvp ON vp.MaLVP = lvp.MaLVP
                        WHERE vp.MaHS = ? AND vp.HocKy = ? AND vp.NamHoc = ?";
        $queryDiemTru = $this->db->query($SQL_DiemTru, [$MaHS, $HocKy, $NamHoc]);
        $resultDiemTru = $queryDiemTru->getRowArray();
        $DiemTru = $resultDiemTru ? $resultDiemTru['DiemTru'] : 0;
    
        // Bước 2: Tính điểm hạnh kiểm mới
        $newDiemHK = max(0, 100 - $DiemTru); // Đảm bảo DiemHK >= 0
    
        // Bước 3: Xác định trạng thái
        $TrangThai = $newDiemHK < 50 ? 'Bị cảnh báo' : null;
    
        // Bước 4: Cập nhật điểm hạnh kiểm và trạng thái
        $SQL_Update = "UPDATE hanhkiem
                       SET DiemHK = ?, TrangThai = ?
                       WHERE MaHS = ? AND HocKy = ? AND NamHoc = ?";
        $this->db->query($SQL_Update, [$newDiemHK, $TrangThai, $MaHS, $HocKy, $NamHoc]);
    
        return [
            'DiemHK' => $newDiemHK,
            'TrangThai' => $TrangThai,
        ];
    }

    public function getConductById($conductId) {
        $SQL = "SELECT 
            hanhkiem.MaHK, 
            hanhkiem.MaHS, 
            taikhoan.HoTen AS TenHS, 
            lop.TenLop AS Lop, 
            hanhkiem.HocKy, 
            hanhkiem.NamHoc, 
            hanhkiem.DiemHK, 
            hanhkiem.TrangThai
        FROM 
            hanhkiem
        JOIN hocsinh ON hanhkiem.MaHS = hocsinh.MaHS
        JOIN taikhoan ON hocsinh.MaTK = taikhoan.MaTK
        JOIN hocsinh_lop ON hanhkiem.MaHS = hocsinh_lop.MaHS AND hanhkiem.NamHoc = hocsinh_lop.NamHoc
        JOIN lop ON hocsinh_lop.MaLop = lop.MaLop
        WHERE hanhkiem.MaHK = ?"; // Điều kiện lọc theo MaHK
    
        // Thực thi truy vấn và truyền tham số
        $result = $this->db->query($SQL, [$conductId])->getRowArray();
    
        return $result; // Trả về kết quả duy nhất
    }

    public function getAllConduct($selectedSemester, $selectedYear, $searchStudent)
    {
        // Tạo câu lệnh SQL với JOIN để lấy thêm thông tin từ các bảng liên quan
        $SQL = "SELECT 
                hanhkiem.MaHK, 
                hanhkiem.MaHS, 
                taikhoan.HoTen AS TenHS, 
                lop.TenLop AS Lop, 
                hanhkiem.HocKy, 
                hanhkiem.NamHoc, 
                hanhkiem.DiemHK, 
                hanhkiem.TrangThai
            FROM 
                hanhkiem
            JOIN hocsinh ON hanhkiem.MaHS = hocsinh.MaHS
            JOIN taikhoan ON hocsinh.MaTK = taikhoan.MaTK
            JOIN hocsinh_lop ON hanhkiem.MaHS = hocsinh_lop.MaHS AND hanhkiem.NamHoc = hocsinh_lop.NamHoc
            JOIN lop ON hocsinh_lop.MaLop = lop.MaLop
            WHERE 1=1"; // Luôn đúng để nối điều kiện động
    
        // Mảng chứa tham số truyền vào
        $params = [];
    
        // Kiểm tra học kỳ
        if ($selectedSemester !== 'Chọn học kì') {
            $SQL .= " AND hanhkiem.HocKy = ?";
            $params[] = $selectedSemester;
        }
    
        // Kiểm tra năm học
        if ($selectedYear !== 'Chọn năm học') {
            $SQL .= " AND hanhkiem.NamHoc = ?";
            $params[] = $selectedYear;
        }
    
        // Tìm kiếm học sinh (theo Mã học sinh, Họ tên hoặc Tên lớp)
        if (!empty($searchStudent)) {
            // Thêm điều kiện tìm kiếm
            $SQL .= " AND (
                hanhkiem.MaHS LIKE ? 
                OR taikhoan.HoTen LIKE ? 
                OR lop.TenLop LIKE ?
            )";
            $params[] = '%' . $searchStudent . '%';
            $params[] = '%' . $searchStudent . '%';
            $params[] = '%' . $searchStudent . '%';
        }
    

    
        // Thực thi truy vấn với các tham số
        $result = $this->db->query($SQL, $params)->getResultArray();
    
        return $result; // Trả về 
    }
    


public function getYearList() {
    $SQL = "SELECT DISTINCT NamHoc FROM hanhkiem ORDER BY NamHoc DESC";
    $result = $this->db->query($SQL)->getResultArray();
    return array_column($result, 'NamHoc');
}


}
