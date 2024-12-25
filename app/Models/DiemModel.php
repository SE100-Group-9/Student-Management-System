<?php

namespace App\Models;

use CodeIgniter\Model;

class DiemModel extends Model
{
    protected $table = 'diem';
    protected $primaryKey = 'MaDiem';
    protected $allowedFields = [
        'MaDiem','MaHS','MaGV','MaMH','Diem15P_1','Diem15P_2','Diem1Tiet_1','Diem1Tiet_2','DiemCK','HocKy','NamHoc','NhanXet'
    ];

    //Hàm xếp loại học lực
    public function getAcademicPerformance($DiemTBHocKy)
    {
        if ($DiemTBHocKy === null) {
            return null;
        }

        if ($DiemTBHocKy >= 8.0) {
            return 'Giỏi';
        } elseif ($DiemTBHocKy >= 6.5) {
            return 'Khá';
        } elseif ($DiemTBHocKy >= 5.0) {
            return 'Trung bình';
        } else {
            return 'Yếu';
        }
    }

    //Hàm tính điểm trung bình
    public function getAverageScore($Diem)
    {
        $Diem15P_1 = $Diem['Diem15P_1'];
        $Diem15P_2 = $Diem['Diem15P_2'];
        $Diem1Tiet_1 = $Diem['Diem1Tiet_1'];
        $Diem1Tiet_2 = $Diem['Diem1Tiet_2'];
        $DiemCK = $Diem['DiemCK'];

        if ($Diem15P_1 === null || $Diem15P_2 === null || $Diem1Tiet_1 === null || $Diem1Tiet_2 === null || $DiemCK === null) {
            return null;
        }

        $DiemTB = (($Diem15P_1 + $Diem15P_2) + 2 * ($Diem1Tiet_1 + $Diem1Tiet_2) + 3 * $DiemCK ) / 9;
        return round($DiemTB, 1);
    }
}
