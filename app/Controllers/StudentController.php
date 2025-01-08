<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\HocSinhModel;
use App\Models\DiemModel;
use App\Models\ViPhamModel;
use App\Models\DanhHieuModel;
use App\Models\HoaDonModel;
use App\Models\TaiKhoanModel;


class StudentController extends Controller
{
    public function score()
    {
        $DiemModel = new DiemModel();
        $yearList = $DiemModel->getYearList();
        $latestYear = $yearList[0];

        $selectedSemester = $this->request->getVar('semester') ?? 'Học kì 1';
        $selectedYear = $this->request->getVar('year') ?? $latestYear;

        preg_match('/\d+/', $selectedSemester, $matches); // 1
        $selectedSemesterNumber = $matches;



        $HocSinhModel = new HocSinhModel();
        $HocSinh = $HocSinhModel->getCurrentStudent();
        $MaHS = $HocSinh['MaHS'];

        $DiemModel = new DiemModel();
        $Score = $DiemModel->getScore($MaHS,  $selectedSemesterNumber, $selectedYear);


        return view('student/score', 
        [
            'Score' => $Score,
            'yearList' => $yearList,
            'selectedYear' => $selectedYear,
            'selectedSemester' => $selectedSemester
        ]);
    }

    public function profile()
    {    
        $HocSinhModel = new HocSinhModel();

        // Lấy thông tin tài khoản hiện tại
        $MaTK = session('MaTK');

        // Lấy thông tin ban giám hiệu
        $HocSinh = $HocSinhModel
            ->select('hocsinh.*, taikhoan.*')
            ->join('taikhoan', 'taikhoan.MaTK = hocsinh.MaTK')
            ->where('hocsinh.MaTK', $MaTK)
            ->first();


        return view('student/profile', [
            'Student' => $HocSinh,
        ]);

    }

    public function updateProfile()
    {    
        $errors = [];
        // Lấy dữ liệu từ form
        $MaHS = $this->request->getPost('MaHS');
        $MaTK = $this->request->getPost('MaTK');
        $email = $this->request->getPost('email');
        $phone = $this->request->getPost('phone');
        $address = $this->request->getPost('address');
        $country = $this->request->getPost('country');
        $nation = $this->request->getPost('nation');
        
        // Kiểm tra email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            $errors['email'] = 'Email không đúng định dạng.';
        // Kiểm tra số điện thoại
        if (!preg_match('/^\d{10}$/', $phone))
            $errors['phone'] = 'Số điện thoại phải có đúng 10 chữ số.';
        // Kiểm tra địa chỉ
        if (empty(trim($address)))
            $errors['address'] = 'Địa chỉ không được để trống';
        if (empty(trim($country)))
            $errors['country'] = 'Quốc gia không được để trống';
        if (empty(trim($nation)))
            $errors['nation'] = 'Dân tộc không được để trống';
        if (!empty($errors))
            return redirect()->back()->withInput()->with('errors', $errors);

        $HocSinhModel = new HocSinhModel();
        $TaiKhoanModel = new TaiKhoanModel();

        // Cập nhật thông tin tài khoản

        $HocSinhModel->update($MaHS, 
        [
            'DanToc' => $this->request->getPost('nation'),
            'NoiSinh' => $this->request->getPost('country'),
        ]
        );

        $TaiKhoanModel->update($MaTK, [
            'Email' => $this->request->getPost('email'),
            'SoDienThoai' => $this->request->getPost('phone'),
            'DiaChi' => $this->request->getPost('address'),
        ]);

        // Xử lý thông báo
        if ($TaiKhoanModel && $HocSinhModel) {
            return redirect()->back()->with('success', 'Cập nhật thông tin thành công!');
        } else {
            return redirect()->back()->with('errors', 'Không thể cập nhật. Vui lòng thử lại.');
        }
    }

    public function updatePassword()
    {
        $errors = [];
        // Lấy dữ liệu từ form
        $MaTK = session('MaTK');
        $oldPassword = $this->request->getPost('old_pw');
        $newPassword = $this->request->getPost('new_pw');
        $confirmPassword = $this->request->getPost('confirm_pw');

        // Kiểm tra mật khẩu cũ
        $TaiKhoanModel = new TaiKhoanModel();
        $TaiKhoan = $TaiKhoanModel->find($MaTK);
        if ($TaiKhoan['MatKhau'] !== $oldPassword) {
            $errors['old_pw'] = 'Mật khẩu cũ không chính xác.';
        }

        // Kiểm tra mật khẩu mới
        if (strlen($newPassword) < 6) {
            $errors['new_pw'] = 'Mật khẩu mới phải có ít nhất 6 ký tự.';
        }

        // Kiểm tra mật khẩu xác nhận
        if ($newPassword !== $confirmPassword) {
            $errors['confirm_pw'] = 'Mật khẩu xác nhận không khớp.';
        }

        // Nếu có lỗi, trả về cùng thông báo
        if (!empty($errors)) {
            return redirect()->back()->withInput()->with('errors', $errors);
        }

        // Cập nhật mật khẩu mới
        $TaiKhoanModel->update($MaTK, [
            'MatKhau' => $this->request->getPost('new_pw'),
        ]);

        if ($TaiKhoanModel) {
            return redirect()->back()->with('success', 'Cập nhật thông tin thành công!');
        } else {
            return redirect()->back()->with('errors', 'Không thể cập nhật. Vui lòng thử lại.');
        }
        
    }


    public function final_result()
    {
        $HocSinhModel = new HocSinhModel();
        $HocSinh = $HocSinhModel->getCurrentStudent();
        $MaHS = $HocSinh['MaHS'];
      
        $DiemModel = new DiemModel();
        
        $yearList = $DiemModel->getYearList();
        $latestYear = $yearList[0];
        $selectedYear = $this->request->getVar('year') ?? $latestYear;
        $selectedSemester = $this->request->getVar('semester') ?? 'Học kỳ 1';


        $DanhHieuModel = new DanhHieuModel();
        $MaLop = $HocSinhModel->getCurrentClass($MaHS, $selectedYear);
        
        if ($selectedSemester === 'Học kì 1') {
            $DTB = $DiemModel->getSemesterAverageScore($MaHS, 1, $selectedYear);
            $HL = $DiemModel->getAcademicPerformance($DTB);
            $HK = $DiemModel->getConductPoint($MaHS, 1, $selectedYear);
            $Rank = $DiemModel->getSemesterRank($MaHS, $MaLop, 1, $selectedYear);
            $DanhHieu = $DanhHieuModel->getAcademicTitle($DTB, $HK);

        }
        if ($selectedSemester === 'Học kì 2') {
            $DTB = $DiemModel->getSemesterAverageScore($MaHS, 2, $selectedYear);
            $HL = $DiemModel->getAcademicPerformance($DTB);
            $HK = $DiemModel->getConductPoint($MaHS, 2, $selectedYear);
            $Rank = $DiemModel->getSemesterRank($MaHS, $MaLop, 2, $selectedYear);
            $DanhHieu = $DanhHieuModel->getAcademicTitle($DTB, $HK);
        }
        if ($selectedSemester === 'Cả năm') {
            $DTB = $DiemModel->getYearAverageScore($MaHS, $selectedYear);
            $HL = $DiemModel->getAcademicPerformance($DTB);
            $HK = $DiemModel->getConductPoint($MaHS, 2, $selectedYear); // Lấy hk2 làm hk cả năm
            $Rank = $DiemModel->getYearRank($MaLop, $selectedYear);
            $DanhHieu = $DanhHieuModel->getAcademicTitle($DTB, $HK);
        }
    
        
        
        return view('student/final_result', 
            [
                'yearList' => $yearList,
                'selectedYear' => $selectedYear,
                'selectedSemester' => $selectedSemester,
                'DTB' => $DTB, 
                'HL' => $HL,
                'HK' => $HK,
                'Rank' =>  $Rank,
                'DanhHieu' =>  $DH,
            ]
        );
        
        
        
    }




    public function conduct()
    {
        $ViPhamModel = new ViPhamModel();
        $yearList =  $ViPhamModel->getYearList();
        $latestYear = $yearList[0];

        $selectedSemester = $this->request->getVar('semester') ?? 'Học kì 1';
        $selectedYear = $this->request->getVar('year') ?? $latestYear;

        preg_match('/\d+/', $selectedSemester, $matches); // 1
        $selectedSemesterNumber = $matches;



        $HocSinhModel = new HocSinhModel();
        $HocSinh = $HocSinhModel->getCurrentStudent();
        $MaHS = $HocSinh['MaHS'];

        $ViPhamModel = new ViPhamModel();
        $result = $ViPhamModel->getAllVPByStudentId($MaHS,  $selectedSemesterNumber, $selectedYear);
        $Conduct = $result['violations'];
        $Point = $result['remainingScore'];

        return view('student/conduct', 
        [
            'Conduct' => $Conduct,
            'Point' => $Point,
            'yearList' => $yearList,
            'selectedYear' => $selectedYear,
            'selectedSemester' => $selectedSemester
        ]);
    }

    public function fee_info()
    {    
        $HocSinhModel = new HocSinhModel();
        $HocSinh = $HocSinhModel->getCurrentStudent();
        $MaHS = $HocSinh['MaHS'];

        $HoaDonModel = new HoaDonModel();
        $HoaDon = $HoaDonModel->getAllInvoices('Chọn trạng thái', 'Chọn năm học',  $MaHS);
        return view ('student/fee_info', [
            'HoaDon' => $HoaDon
        ]);
    }

    public function changepw()
    {
        return view('student/changepw');
    }
}

