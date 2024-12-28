<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\ThuNganModel;
use App\Models\TaiKhoanModel;
use App\Models\HoaDonModel;
use App\Models\ThanhToanModel;

class CashierController extends Controller
{
    public function listInvoice()
    {
        $HoaDonModel = new HoaDonModel();

        $selectedStatus = $this->request->getVar('status') ?? 'Chưa thanh toán';
        $selectedYear = $this->request->getVar('year') ?? '2023-2024';
        $searchStudent = $this->request->getVar('search') ?? '';
        
        // lấy list year
        $yearListArray = $HoaDonModel
        ->distinct()
        ->select('NamHoc')
        ->orderBy('NamHoc', 'ASC')
        ->findAll();
        // Lấy các giá trị của trường 'NamHoc' từ mảng $yearListArray
        $yearList = array_map(function ($year) {
            return $year['NamHoc']; // Lấy giá trị NamHoc
        }, $yearListArray);
        $yearList = array_merge(['Chọn năm học'], $yearList);
        
        
        // Gọi hàm getAllInvoices từ model để lấy tất cả hóa đơn
        $invoiceList = $HoaDonModel->getAllInvoices($selectedStatus, $selectedYear, $searchStudent);


        return view(
            'cashier/invoice/list',
            [
                'invoiceList' => $invoiceList,
                'yearList' => $yearList,
                'selectedStatus' => $selectedStatus,
                'selectedYear' => $selectedYear,
                'searchTerm' => $searchStudent
            ]
        );

    }

    public function profile() 
    {
        $ThuNganModel = new ThuNganModel();

        // Lấy thông tin tài khoản hiện tại
        $MaTK = session('MaTK');

        // Lấy thông tin ban giám hiệu
        $ThuNgan = $ThuNganModel
            ->select('thungan.*, taikhoan.*')
            ->join('taikhoan', 'taikhoan.MaTK = thungan.MaTK')
            ->where('thungan.MaTK', $MaTK)
            ->first();


        return view('cashier/profile', [
            'cashier' => $ThuNgan,
        ]);
    }

    public function updateProfile()
    {
        $errors = [];
        // Lấy dữ liệu từ form
        $MaTN = $this->request->getPost('MaTN');
        $MaTK = $this->request->getPost('MaTK');
        $email = $this->request->getPost('cashier_email');
        $phone = $this->request->getPost('cashier_phone');
        $address = $this->request->getPost('cashier_address');
        
        // Kiểm tra email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            $errors['cashier_email'] = 'Email không đúng định dạng.';
        // Kiểm tra số điện thoại
        if (!preg_match('/^\d{10}$/', $phone))
            $errors['cashier_phone'] = 'Số điện thoại phải có đúng 10 chữ số.';
        // Nếu có lỗi, trả về cùng thông báo
        if (empty(trim($address)))
            $errors['cashier_address'] = 'Địa chỉ không được để trống';
        if (!empty($errors))
            return redirect()->back()->withInput()->with('errors', $errors);

        $ThuNganModel = new ThuNganModel();
        $TaiKhoanModel = new TaiKhoanModel();

        // Cập nhật thông tin tài khoản
        $TaiKhoanModel->update($MaTK, [
            'Email' => $this->request->getPost('cashier_email'),
            'SoDienThoai' => $this->request->getPost('cashier_phone'),
            'DiaChi' => $this->request->getPost('cashier_address'),
        ]);

        // Xử lý thông báo
        if ($TaiKhoanModel) {
            return redirect()->back()->with('success', 'Cập nhật thông tin thành công!');
        } else {
            return redirect()->back()->with('errors', 'Không thể cập nhật. Vui lòng thử lại.');
        }
    }

    public function invoice()
    {
        return view('cashier/invoice/add');
    }

    public function addPaymentForm($invoiceId)
    {
        // trả về mã HS
        $HoaDonModel = new HoaDonModel();
        $HoaDon = $HoaDonModel->select('MaHS')   
                ->where('MaHD', $invoiceId)             
                ->first();
        $MaHS = $HoaDon['MaHS'];
        // trả về mã TN
        $MaTK = session('MaTK');
        $ThuNganModel = new ThuNganModel();
        $ThuNgan = $ThuNganModel->select('thungan.*, taikhoan.*')
            ->join('taikhoan', 'taikhoan.MaTK = thungan.MaTK')
            ->where('thungan.MaTK', $MaTK)
            ->first();
        $MaTN = $ThuNgan['MaTN'];

        
        return view('cashier/payment/add', [
            'MaHD' => $invoiceId,
            'MaHS' =>  $MaHS,
            'MaTN' => $MaTN
        ]); 
        
    }

    public function addPayment($invoiceId)
    {
        $errors = [];
        $MaHD = $this->request->getPost('MaHD');
        $MaTN = $this->request->getPost('MaTN');
        $DaThanhToan = $this->request->getPost('paid');
        $NgayThanhToan = date('d/m/Y');

        if (!is_numeric($DaThanhToan) || $DaThanhToan <= 0)
            $errors['paid'] = 'Số tiền đóng không hợp lệ';
        if (!empty($errors))
            return redirect()->back()->withInput()->with('errors', $errors);


        $ThanhToan = new ThanhToanModel();

        // Thêm thanh toán
        $result = $ThanhToan->insertPayment($MaHD, $MaTN,  $DaThanhToan, $NgayThanhToan);

        $invoiceModel = new HoaDonModel();
        // Cập nhật trạng thái hóa đơn
        $invoiceModel->updateInvoice($MaHD, $DaThanhToan);

        // Xử lý thông báo
        if ($result) {
            return redirect()->back()->with('success', 'Thêm thanh toán thành công');
        } else {
            return redirect()->back()->with('errors', 'Thêm thanh toán thất bại');
        }
    }


    public function addInvoice()
    {   
        
    }

    public function listPayment($invoiceId) {
        $ThanhToanModel= new ThanhToanModel();

        // Gọi hàm getAllInvoices từ model để lấy tất cả hóa đơn
        $paymentList = $ThanhToanModel->getAllPaymentsByInvoiceId($invoiceId);

        return view(
            'cashier/payment/list',
            [
                'MaHD' => $invoiceId,
                'paymentList' => $paymentList
            ]
        );
    }

    public function deletePayment($paymentId) {
        $paymentModel = new ThanhToanModel();
        $invoiceModel = new HoaDonModel();
        $invoice =  $invoiceModel->getInvoiceByPaymentId($paymentId);
        
        // Cập nhật trạng thái hóa đơn
        $invoiceModel->updateInvoice($invoice['MaHD'], $invoice['DaThanhToan'] * (-1));

        if ($paymentModel->delete($paymentId)) {
            return redirect()->back()->with('success', 'Xóa thanh toán thành công.');
        } else {
            return redirect()->back()->with('error', 'Xóa thanh toán thất bại.');
        }
    }

    public function staticStudent()
    {
        return view('cashier/statics/student');
    }

    public function changepw()
    {
        return view('cashier/changepw');
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
}
