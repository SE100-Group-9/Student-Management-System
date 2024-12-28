<?php

namespace App\Controllers;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use CodeIgniter\Controller;
use App\Models\TaiKhoanModel;
use App\Models\HocSinhModel;
use App\Models\HocSinhLopModel;
use App\Models\LopModel;
use App\Models\DanhHieuModel;
use App\Models\ThuNganModel;
use App\Models\GiamThiModel;
use App\Models\GiaoVienModel;
use App\Models\BanGiamHieuModel;
use App\Models\GiaoVienLopModel;
use App\Models\MonHocModel;
use App\Models\PhanCongModel;
use App\Models\DiemModel;
use App\Models\HanhKiemModel;
use App\Models\CTPTTModel;
use App\Models\ThamSoModel;
use App\Models\HoaDonModel;
use PhpCsFixer\Tokenizer\CT;

class DirectorController extends Controller
{

    public function staticsConduct()
    {
        return view('director/statics/conduct');
    }

    public function staticsGrade()
    {
        return view('director/statics/grade');
    }

    public function staticsStudent()
    {
        return view('director/statics/student');
    }

    public function exportStudentList() {}

    public function studentAdd()
    {
        $HocSinhModel = new HocSinhModel();
        // Lấy mã học sinh lớn nhất hiện tại
        $lastStudent = $HocSinhModel->select('MaHS')->orderBy('MaHS', 'DESC')->first();

        // Sinh mã học sinh mới
        $newMaHS = 'HS0001'; // Giá trị mặc định nếu chưa có mã nào
        if ($lastStudent && preg_match('/^HS(\d+)$/', $lastStudent['MaHS'], $matches)) {
            $newIndex = (int)$matches[1] + 1;
            $newMaHS = 'HS' . str_pad($newIndex, 4, '0', STR_PAD_LEFT);
        }
        return view('director/student/add', ['newMaHS' => $newMaHS]);
    }

    public function addStudent()
    {
        $errors = [];
        // Lấy dữ liệu từ form
        $birthday = $this->request->getPost('student_birthday');
        $email = $this->request->getPost('student_email');
        $password = $this->request->getPost('student_password');
        $phone = $this->request->getPost('student_phone');
        $gender = $this->request->getPost('student_gender');
        //Kiểm tra giới tính
        if (empty($gender))
            $errors['student_gender'] = 'Vui lòng chọn giới tính.';

        // Kiểm tra ngày sinh
        if (strtotime($birthday) > strtotime(date('Y-m-d')))
            $errors['student_birthday'] = 'Ngày sinh không hợp lệ.';

        if (empty($birthday))
            $errors['student_birthday'] = 'Vui lòng nhập ngày sinh.';

        // Kiểm tra email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            $errors['student_email'] = 'Email không đúng định dạng.';

        // Kiểm tra mật khẩu
        if (strlen($password) < 6)
            $errors['student_password'] = 'Mật khẩu phải có ít nhất 6 ký tự.';

        // Kiểm tra số điện thoại
        if (!preg_match('/^\d{10}$/', $phone))
            $errors['student_phone'] = 'Số điện thoại phải có đúng 10 chữ số.';

        // Nếu có lỗi, trả về cùng thông báo
        if (!empty($errors)) {
            return redirect()->back()->withInput()->with('errors', $errors);
        }



        $TaiKhoanModel = new TaiKhoanModel();
        $HocSinhModel = new HocSinhModel();
        $HocSinhLopModel = new HocSinhLopModel();

        $MaTK = $TaiKhoanModel->insert([
            'TenTK' => $this->request->getPost('student_account'),
            'MatKhau' => $this->request->getPost('student_password'),
            'HoTen' => $this->request->getPost('student_name'),
            'Email' => $this->request->getPost('student_email'),
            'SoDienThoai' => $this->request->getPost('student_phone'),
            'DiaChi' => $this->request->getPost('student_address'),
            'GioiTinh' => $this->request->getPost('student_gender'),
            'NgaySinh' => $this->request->getPost('student_birthday'),
            'MaVT' => 3, // Mã vai trò học sinh
        ]);
        // Lưu thông tin học sinh
        $MaHS = $HocSinhModel->insert([
            'MaTK' => $MaTK,
            'DanToc' => $this->request->getPost('student_nation'),
            'NoiSinh' => $this->request->getPost('student_country'),
            'TinhTrang' => $this->request->getPost('student_status') ?? 'Mới tiếp nhận',
        ]);

        return redirect()->back()->with('success', 'Thêm học sinh mới thành công!');
    }

    public function studentUpdate($id = null)
    {
        if ($id === null) {
            return redirect()->to('director/student/list'); // Redirect nếu không có id
        }
        $TaiKhoanModel = new TaiKhoanModel();
        $HocSinhModel = new HocSinhModel();
        $HocSinhLopModel = new HocSinhLopModel();
        $LopModel = new LopModel();
        // Lấy thông tin học sinh theo id
        $data = $HocSinhModel
            ->select('hocsinh.*, taikhoan.*, hocsinh_lop.*, lop.TenLop')
            ->join('taikhoan', 'taikhoan.MaTK = hocsinh.MaTK')
            ->join('hocsinh_lop', 'hocsinh.MaHS = hocsinh_lop.MaHS', 'left')
            ->join('lop', 'lop.MaLop = hocsinh_lop.MaLop', 'left')
            ->where('hocsinh.MaHS', $id)
            ->first();
        if (!$data) {
            return redirect()->to('director/student/list'); // Redirect nếu không tìm thấy học sinh
        }
        return view('director/student/update', ['student' => $data]);
    }
    public function updateStudent()
    {
        $errors = [];
        // Lấy dữ liệu từ form
        $MaHS = $this->request->getPost('MaHS');
        $MaTK = $this->request->getPost('MaTK');
        $birthday = $this->request->getPost('student_birthday');
        $email = $this->request->getPost('student_email');
        $password = $this->request->getPost('student_password');
        $phone = $this->request->getPost('student_phone');
        $gender = $this->request->getPost('student_gender');
        //Kiểm tra giới tính
        if (empty($gender))
            $errors['student_gender'] = 'Vui lòng chọn giới tính.';

        // Kiểm tra ngày sinh
        if (strtotime($birthday) > strtotime(date('Y-m-d')))
            $errors['student_birthday'] = 'Ngày sinh không hợp lệ.';

        if (empty($birthday))
            $errors['student_birthday'] = 'Vui lòng nhập ngày sinh.';

        // Kiểm tra email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            $errors['student_email'] = 'Email không đúng định dạng.';

        // Kiểm tra mật khẩu
        if (strlen($password) < 6)
            $errors['student_password'] = 'Mật khẩu phải có ít nhất 6 ký tự.';

        // Kiểm tra số điện thoại
        if (!preg_match('/^\d{10}$/', $phone))
            $errors['student_phone'] = 'Số điện thoại phải có đúng 10 chữ số.';

        // Nếu có lỗi, trả về cùng thông báo
        if (!empty($errors)) {
            return redirect()->back()->withInput()->with('errors', $errors);
        }



        $TaiKhoanModel = new TaiKhoanModel();
        $HocSinhModel = new HocSinhModel();



        $TaiKhoanModel->update($MaTK, [
            'TenTK' => $this->request->getPost('student_account'),
            'MatKhau' => $this->request->getPost('student_password'),
            'HoTen' => $this->request->getPost('student_name'),
            'Email' => $this->request->getPost('student_email'),
            'SoDienThoai' => $this->request->getPost('student_phone'),
            'DiaChi' => $this->request->getPost('student_address'),
            'GioiTinh' => $this->request->getPost('student_gender'),
            'NgaySinh' => $this->request->getPost('student_birthday'),
        ]);

        $HocSinhModel->update($MaHS, [
            'DanToc' => $this->request->getPost('student_nation'),
            'NoiSinh' => $this->request->getPost('student_country'),
            'TinhTrang' => $this->request->getPost('student_status'),
        ]);
        $allPostData = $this->request->getPost();
        log_message('info', 'Received Data: ' . json_encode($allPostData));
        // Xử lý thông báo
        if ($TaiKhoanModel && $HocSinhModel) {
            return redirect()->back()->with('success', 'Cập nhật thành công!');
        } else {
            return redirect()->back()->with('error', 'Không thể cập nhật. Vui lòng thử lại.');
        }
    }


    public function studentList()
    {
        $TaiKhoanModel = new TaiKhoanModel();
        $HocSinhModel = new HocSinhModel();
        $HocSinhLopModel = new HocSinhLopModel();
        $LopModel = new LopModel();

        // Nhận giá trị năm học, lớp học, từ khóa tìm kiếm và tình trạng từ query string
        $selectedYear = $this->request->getVar('year');
        $selectedClass = $this->request->getVar('class');
        $searchStudent = $this->request->getVar('search') ?? '';
        $selectedStatus = $this->request->getVar('status');

        // Lấy danh sách các năm học, lớp học và tình trạng
        $classList = $LopModel->findColumn('TenLop');
        $classList = array_merge(['Chọn lớp học'], $classList); // Thêm "Chọn lớp" vào danh sách lớp

        $yearListArray = $HocSinhLopModel
            ->distinct()
            ->select('NamHoc')
            ->orderBy('NamHoc', 'ASC')
            ->findAll();
        // Lấy các giá trị của trường 'NamHoc' từ mảng $yearListArray
        $yearList = array_map(function ($year) {
            return $year['NamHoc']; // Lấy giá trị NamHoc
        }, $yearListArray);
        $yearList = array_merge(['Chọn năm học'], $yearList);
        $statusList = ['Chọn trạng thái', 'Đang học', 'Mới tiếp nhận', 'Nghỉ học'];

        $query = $HocSinhModel
            ->select('hocsinh.*, taikhoan.*, hocsinh_lop.MaLop, lop.TenLop')
            ->join('taikhoan', 'taikhoan.MaTK = hocsinh.MaTK')
            ->join('hocsinh_lop', 'hocsinh.MaHS = hocsinh_lop.MaHS', 'left')
            ->join('lop', 'lop.MaLop = hocsinh_lop.MaLop', 'left');

        // Lọc theo năm học, lớp và từ khóa tìm kiếm và tình trạng (nếu có)
        if ($selectedYear && $selectedYear !== 'Chọn năm học') {
            $query->where('hocsinh_lop.NamHoc', $selectedYear);
        }
        if ($selectedClass && $selectedClass !== 'Chọn lớp học') {
            $query->where('lop.TenLop', $selectedClass);
        }
        if ($searchStudent) {
            $query->groupStart() // Tạo nhóm điều kiện tìm kiếm
                ->like('hocsinh.MaHS', $searchStudent)
                ->orLike('taikhoan.HoTen', $searchStudent)
                ->groupEnd();
        }
        if ($selectedStatus && $selectedStatus !== 'Chọn trạng thái') {
            $query->where('hocsinh.TinhTrang', $selectedStatus);
        }

        $studentList  = $query->findAll();

        return view('director/student/list', [
            'studentlist' => $studentList,
            'yearList' => $yearList,
            'classList' => $classList,
            'statusList' => $statusList,
            'selectedYear' => $selectedYear,
            'selectedClass' => $selectedClass,
            'selectedStatus' => $selectedStatus,
            'searchTerm' => $searchStudent,
        ]);
    }

    public function studentPayment()
    {
        $LopModel = new LopModel();
        $CTPTTModel = new CTPTTModel();

        // Nhận giá trị năm học và lớp học từ query string
        $selectedYear = $this->request->getVar('year') ?? '2024-2025';
        //Nhận giá trị học kỳ sau khi chuyển từ text sang số
        $selectedSemesterText = $this->request->getVar('semester') ?? 'Học kỳ 1';
        $selectedSemester = $selectedSemesterText === 'Học kỳ 1' ? 1 : 2;

        $selectedClass = $this->request->getVar('class') ?? '10_1';

        // Lấy danh sách tên lớp học
        $classList = $LopModel->findColumn('TenLop');

        // Lấy MaLop từ tên lớp học
        $MaLop = $LopModel->where('TenLop', $selectedClass)->first()['MaLop'];

        // Lấy thông tin học phí của học sinh
        $tuitionList = $CTPTTModel->getTuitionInfo($MaLop, $selectedSemester, $selectedYear);


        return view('director/student/payment', [
            'tuitionList' => $tuitionList,
            'classList' => $classList,
            'selectedYear' => $selectedYear,
            'selectedSemesterText' => $selectedSemesterText,
            'selectedClass' => $selectedClass,
        ]);
    }

    public function studentPerserved()
    {
        return view('director/student/perserved');
    }

    public function studentRecord()
    {
        $HocSinhModel = new HocSinhModel();
        $LopModel = new LopModel();
        $DiemModel = new DiemModel();
        $PhanCongModel = new PhanCongModel();

        // Nhận giá trị năm học, học kỳ và lớp học từ query string
        $selectedYear = $this->request->getVar('year') ?? '2024-2025';
        //Nhận giá trị học kỳ sau khi chuyển từ text sang số
        $selectedSemesterText = $this->request->getVar('semester') ?? 'Học kỳ 1';
        $selectedSemester = $selectedSemesterText === 'Học kỳ 1' ? 1 : 2;
        $selectedClass = $this->request->getVar('class') ?? '10_1';

        // Lấy danh sách các tên lớp học
        $classList = $LopModel->findColumn('TenLop');

        // Lấy danh sách học sinh theo năm học, học kỳ và lớp học
        $studentList = $HocSinhModel->getStudentList($selectedYear, $selectedSemester, $selectedClass);

        $students = [];
        foreach ($studentList as $student) {
            $MaHS = $student['MaHS'];

            //Khởi tạo dữ liệu học sinh nếu chưa có
            if (!isset($students[$MaHS])) {
                $students[$MaHS] = [
                    'MaHS' => $MaHS,
                    'HoTen' => $student['HoTen'],
                    'TenLop' => $student['TenLop'],
                    'Diem' => [],
                    'DiemHK' => $student['DiemHK'],
                ];
            }

            // Lưu điểm của từng môn học
            if ($student['MaMH']) {
                $students[$MaHS]['Diem'][$student['MaMH']] = [
                    'Diem15P_1' => $student['Diem15P_1'],
                    'Diem15P_2' => $student['Diem15P_2'],
                    'Diem1Tiet_1' => $student['Diem1Tiet_1'],
                    'Diem1Tiet_2' => $student['Diem1Tiet_2'],
                    'DiemCK' => $student['DiemCK'],
                ];
            }
        }

        // Tính toán điểm trung bình từng môn, điểm trung bình học kỳ và xếp loại học lực, danh hiệu
        foreach ($students as &$student) {
            $DiemTBHocKy = null;
            $TongDiemTB = 0;
            $SoMon = count($PhanCongModel->getSubjectList($selectedYear, $selectedSemester, $selectedClass)); // Số môn học trong học kỳ
            $SoMonDuCotDiem = 0; // Số môn có đủ cột điểm để tính điểm trung bình môn học

            foreach ($student['Diem'] as $MaMH => $Diem) {
                $DiemTBMonHoc = $DiemModel->getAverageScore($Diem);

                // Lưu điểm trung bình môn học vào mảng
                $student[$MaMH] = $DiemTBMonHoc;

                if ($DiemTBMonHoc !== null) {
                    $TongDiemTB += $DiemTBMonHoc;
                    $SoMonDuCotDiem++;
                }
            }
            // Tính điểm trung bình học kỳ nếu có đủ cột điểm của tất cả môn
            if ($SoMonDuCotDiem === $SoMon && $SoMon > 0) {
                $DiemTBHocKy = round($TongDiemTB / $SoMon, 1);
            }
            $student['DiemTBHocKy'] = $DiemTBHocKy;

            // Xếp loại học lực
            $student['HocLuc'] = $DiemModel->getAcademicPerformance($DiemTBHocKy);

            // Xếp loại danh hiệu
            $DanhHieuModel = new DanhHieuModel();
            $DanhHieu = $DanhHieuModel->getAcademicTitle($DiemTBHocKy, $student['DiemHK']);
            $student['DanhHieu'] = $DanhHieu ? $DanhHieu['TenDH'] : null;
        }

        return view('director/student/record', [
            'studentList' => $students,
            'classList' => $classList,
            'selectedYear' => $selectedYear,
            'selectedSemesterText' => $selectedSemesterText,
            'selectedClass' => $selectedClass,
        ]);
    }

    //Màn hình Danh hiệu
    public function titleList()
    {
        $DanhHieuModel = new DanhHieuModel();

        // Nhận giá trị từ khóa tìm kiếm từ query string
        $searchTerm = $this->request->getVar('search') ?? '';

        //Nếu có từ khóa tìm kiếm, áp dụng bộ lọc
        if ($searchTerm) {
            $DanhHieuModel->like('TenDH', $searchTerm);
        }

        // Lấy danh sách danh hiệu và sắp xếp theo DiemTBToiThieu giảm dần
        $titleList = $DanhHieuModel->orderBy('DiemTBToiThieu', 'DESC')->findAll();

        // Truyền dữ liệu tới view
        return view('director/title/list', [
            'titleList' => $titleList,
            'searchTerm' => $searchTerm,
        ]);
    }

    public function titleAdd()
    {
        return view('director/title/add');
    }

    public function addTitle()
    {
        $DanhHieuModel = new DanhHieuModel();

        // Lấy dữ liệu từ form
        $TenDH = $this->request->getPost('title_name');
        $DiemTBToiThieu = $this->request->getPost('min_grade');
        $DiemHanhKiemToiThieu = $this->request->getPost('min_conduct');

        // Kiểm tra tính hợp lệ của dữ liệu
        if ($DiemTBToiThieu < 0 || $DiemTBToiThieu > 10) {
            return redirect()->back()->with('error', 'Điểm trung bình tối thiểu phải nằm trong khoảng từ 0 đến 10.');
        }

        if ($DiemHanhKiemToiThieu < 0 || $DiemHanhKiemToiThieu > 100) {
            return redirect()->back()->with('error', 'Điểm hạnh kiểm tối thiểu phải nằm trong khoảng từ 0 đến 100.');
        }
        // Lưu danh hiệu vào cơ sở dữ liệu
        $MaDH = $DanhHieuModel->insert([
            'TenDH' => $TenDH,
            'DiemTBToiThieu' => $DiemTBToiThieu,
            'DiemHanhKiemToiThieu' => $DiemHanhKiemToiThieu,
        ]);

        // Điều hướng sau khi lưu thành công/thất bại
        if ($MaDH) {
            return redirect()->back()->with('success', 'Danh hiệu đã được thêm thành công!');
        } else {
            return redirect()->back()->with('error', 'Không thể thêm danh hiệu. Vui lòng thử lại.');
        }
    }

    public function titleUpdate($id)
    {
        $DanhHieuModel = new DanhHieuModel();

        // Lấy thông tin danh hiệu dựa trên ID
        $title = $DanhHieuModel->find($id);

        if (!$title) {
            return redirect()->to('/sms/public/director/title/list')->with('error', 'Không tìm thấy danh hiệu.');
        }

        return view('director/title/update', ['title' => $title]);
    }
    public function updateTitle()
    {
        $DanhHieuModel = new DanhHieuModel();

        // Lấy dữ liệu từ form
        $MaDH = $this->request->getPost('id');
        $TenDH = $this->request->getPost('title_name');
        $DiemTBToiThieu = $this->request->getPost('min_grade');
        $DiemHanhKiemToiThieu = $this->request->getPost('min_conduct');

        // Kiểm tra tính hợp lệ của dữ liệu
        if ($DiemTBToiThieu < 0 || $DiemTBToiThieu > 10) {
            return redirect()->back()->with('error', 'Điểm trung bình tối thiểu phải nằm trong khoảng từ 0 đến 10.');
        }

        if ($DiemHanhKiemToiThieu < 0 || $DiemHanhKiemToiThieu > 100) {
            return redirect()->back()->with('error', 'Điểm hạnh kiểm tối thiểu phải nằm trong khoảng từ 0 đến 100.');
        }

        // Cập nhật danh hiệu trong cơ sở dữ liệu
        $DanhHieu = $DanhHieuModel->update($MaDH, [
            'TenDH' => $TenDH,
            'DiemTBToiThieu' => $DiemTBToiThieu,
            'DiemHanhKiemToiThieu' => $DiemHanhKiemToiThieu,
        ]);

        // Điều hướng sau khi cập nhật
        if ($DanhHieu) {
            return redirect()->back()->with('success', 'Cập nhật danh hiệu thành công!');
        } else {
            return redirect()->back()->with('error', 'Không thể cập nhật danh hiệu. Vui lòng thử lại.');
        }
    }

    public function titleDelete($id)
    {
        $DanhHieuModel = new DanhHieuModel();

        // Xóa danh hiệu dựa trên ID
        $DanhHieu = $DanhHieuModel->delete($id);

        // Điều hướng sau khi xóa
        if ($DanhHieu) {
            return redirect()->back()->with('success', 'Xóa danh hiệu thành công!');
        } else {
            return redirect()->back()->with('error', 'Không thể xóa danh hiệu. Vui lòng thử lại.');
        }
    }

    // Màn hình quản lý lớp học
    public function classList()
    {
        $LopModel = new LopModel();
        $HocSinhLopModel = new HocSinhLopModel();


        //Nhận giá trị tìm kiếm từ query string
        $selectedYear = $this->request->getVar('year') ?? '2024-2025';
        $searchTerm = $this->request->getVar('search') ?? '';

        //Lấy danh sách các năm học
        $yearListArray = $HocSinhLopModel
            ->distinct()
            ->select('NamHoc')
            ->orderBy('NamHoc', 'ASC')
            ->findAll();
        //Lấy các giá trị của trường 'NamHoc' từ mảng $yearListArray
        $yearList = array_map(function ($year) {
            return $year['NamHoc']; //Lấy giá trị NamHoc
        }, $yearListArray);

        //Câu truy vấn SQL để lấy danh sách lớp học
        $SQL = "
        SELECT lop.MaLop, lop.TenLop, giaovien.MaGV, taikhoan.HoTen, COUNT(hocsinh_lop.MaHS) as SiSo
        FROM lop
        JOIN phancong ON lop.MaLop = phancong.MaLop
        JOIN giaovien ON phancong.MaGV = giaovien.MaGV
        JOIN taikhoan ON giaovien.MaTK = taikhoan.MaTK
        LEFT JOIN hocsinh_lop ON lop.MaLop = hocsinh_lop.MaLop AND hocsinh_lop.NamHoc = '$selectedYear'
        WHERE phancong.NamHoc = '$selectedYear' AND phancong.VaiTro = 'Giáo viên chủ nhiệm'
        ";

        // Nếu có từ khóa tìm kiếm, áp dụng bộ lọc
        if ($searchTerm) {
            $SQL .= " AND (lop.TenLop LIKE '%$searchTerm%' OR taikhoan.HoTen LIKE '%$searchTerm%')";
        }

        //Nhóm kết quả theo mã lớp, tên lớp, mã giáo viên và tên giáo viên
        $SQL .= " GROUP BY lop.MaLop, lop.TenLop, giaovien.MaGV, taikhoan.HoTen
        ORDER BY lop.TenLop ASC";

        //Thực thi câu truy vấn
        $classList = $LopModel->query($SQL)->getResultArray();

        // Lưu năm học vào session để truyền giữa các trang (classAdd)
        if ($selectedYear) {
            session()->set('selectedYear', $selectedYear);
        }

        return view('director/class/list', [
            'classList' => $classList,
            'yearList' => $yearList,
            'selectedYear' => $selectedYear,
            'searchTerm' => $searchTerm,
        ]);
    }

    public function classAdd()
    {
        // Lấy giá trị năm học từ session
        $selectedYear = session()->get('selectedYear');

        // Lấy danh sách giáo viên chưa chủ nhiệm lớp nào trong năm học đã chọn
        $GiaoVienModel = new GiaoVienModel();

        // Tạo query lấy danh sách giáo viên chưa chủ nhiệm lớp nào trong năm học đã chọn
        $SQL = "SELECT giaovien.MaGV, taikhoan.HoTen
        FROM giaovien
        JOIN taikhoan ON taikhoan.MaTK = giaovien.MaTK
        WHERE giaovien.MaGV NOT IN (
            SELECT MaGV FROM phancong WHERE NamHoc = '$selectedYear' AND VaiTro = 'Giáo viên chủ nhiệm'
        )";

        $GiaoVien = $GiaoVienModel->query($SQL)->getResultArray();


        //Chuẩn bị mảng options cho dropdown chọn giáo viên
        $GiaoVien = array_map(function ($teacher) {
            return $teacher['MaGV'] . ' - ' . $teacher['HoTen'];
        }, $GiaoVien);

        return view('director/class/add', [
            'selectedYear' => $selectedYear,
            'teacherOptions' => $GiaoVien,
        ]);
    }

    public function addClass()
    {
        $errors = [];
        // Lấy dữ liệu từ form
        $selectedYear = $this->request->getPost('year');
        $className = $this->request->getPost('class_name');
        $classTeacher = $this->request->getPost('class-teacher');

        //Kiểm tra giáo viên chủ nhiệm
        if (empty($classTeacher)) {
            $errors['class-teacher'] = 'Vui lòng chọn giáo viên chủ nhiệm.';
        }

        //Kiểm tra tên lớp
        if (empty($className)) {
            $errors['class_name'] = 'Vui lòng nhập tên lớp.';
        }

        //Kiểm tra tên lớp đã tồn tại chưa
        $LopModel = new LopModel();
        $classExists = $LopModel->where('TenLop', $className)->first();
        if ($classExists) {
            $errors['class_name'] = 'Tên lớp đã tồn tại.';
        }

        //Nếu có lỗi, trả về cùng thông báo
        if (!empty($errors)) {
            return redirect()->back()->withInput()->with('errors', $errors);
        }

        $LopModel = new LopModel();
        $PhanCongModel = new PhanCongModel();

        //Lưu thông tin lớp học
        $MaLop = $LopModel->insert([
            'TenLop' => $className,
        ]);

        //Lưu thông tin giáo viên chủ nhiệm
        $MaGV = explode(' - ', $classTeacher)[0];
        $PhanCongModel->insert([
            'MaGV' => $MaGV,
            'MaLop' => $MaLop,
            'NamHoc' => $selectedYear,
            'VaiTro' => 'Giáo viên chủ nhiệm',
        ]);

        return redirect()->back()->with('success', 'Thêm lớp học mới thành công!');
    }

    public function classUpdate($MaLop)
    {
        $LopModel = new LopModel();
        $GiaoVienModel = new GiaoVienModel();
        $PhanCongModel = new PhanCongModel();

        // Lấy giá trị năm học từ session
        $selectedYear = session()->get('selectedYear');

        // Lấy thông tin lớp học theo mã lớp
        $class = $LopModel->find($MaLop);

        // Lấy thông tin giáo viên chủ nhiệm
        $teacher = $PhanCongModel
            ->select('giaovien.MaGV, taikhoan.HoTen')
            ->join('giaovien', 'giaovien.MaGV = phancong.MaGV')
            ->join('taikhoan', 'taikhoan.MaTK = giaovien.MaTK')
            ->where('phancong.MaLop', $MaLop)
            ->where('phancong.NamHoc', $selectedYear)
            ->where('phancong.VaiTro', 'Giáo viên chủ nhiệm')
            ->first();

        // Lấy danh sách giáo viên chưa chủ nhiệm lớp nào trong năm học đã chọn
        $SQL = "SELECT giaovien.MaGV, taikhoan.HoTen
        FROM giaovien
        JOIN taikhoan ON taikhoan.MaTK = giaovien.MaTK
        WHERE giaovien.MaGV NOT IN (
            SELECT MaGV FROM phancong WHERE NamHoc = '$selectedYear' AND VaiTro = 'Giáo viên chủ nhiệm'
        )";

        $GiaoVien = $GiaoVienModel->query($SQL)->getResultArray();

        //Gộp giáo viên đang chủ nhiệm lớp đó vào danh sách giáo viên chưa chủ nhiệm
        if ($teacher) {
            array_unshift($GiaoVien, [
                'MaGV' => $teacher['MaGV'],
                'HoTen' => $teacher['HoTen']
            ]);
        }

        //Chuẩn bị mảng options cho dropdown chọn giáo viên
        $GiaoVien = array_map(function ($teacher) {
            return $teacher['MaGV'] . ' - ' . $teacher['HoTen'];
        }, $GiaoVien);

        return view('director/class/update', [
            'class' => $class,
            'teacher' => $teacher,
            'teacherOptions' => $GiaoVien,
        ]);
    }

    public function updateClass()
    {
        $errors = [];
        // Lấy dữ liệu từ form
        $MaLop = $this->request->getPost('MaLop');
        $className = $this->request->getPost('class_name');
        $classTeacher = $this->request->getPost('class-teacher');

        //Kiểm tra giáo viên chủ nhiệm
        if (empty($classTeacher)) {
            $errors['class-teacher'] = 'Vui lòng chọn giáo viên chủ nhiệm.';
        }

        //Kiểm tra tên lớp
        if (empty($className)) {
            $errors['class_name'] = 'Vui lòng nhập tên lớp.';
        }

        //Kiểm tra tên lớp đã tồn tại chưa, nếu tên lớp thay đổi
        $LopModel = new LopModel();
        $currentClass = $LopModel->find($MaLop);
        if ($currentClass['TenLop'] !== $className) {
            $classExists = $LopModel->where('TenLop', $className)->first();
            if ($classExists) {
                $errors['class_name'] = 'Tên lớp đã tồn tại.';
            }
        }

        //Nếu có lỗi, trả về cùng thông báo
        if (!empty($errors)) {
            return redirect()->back()->withInput()->with('errors', $errors);
        }
        //Lấy giá trị năm học từ session
        $selectedYear = session()->get('selectedYear');

        $LopModel = new LopModel();
        $PhanCongModel = new PhanCongModel();

        //Lưu thông tin lớp học
        $LopModel->update($MaLop, [
            'TenLop' => $className,
        ]);

        //Lưu thông tin giáo viên chủ nhiệm
        $MaGV = explode(' - ', $classTeacher)[0];

        $SQL = "UPDATE phancong
        SET MaGV = '$MaGV'
        WHERE MaLop = '$MaLop' AND NamHoc = '$selectedYear' AND VaiTro = 'Giáo viên chủ nhiệm'";
        $PhanCongModel->query($SQL);


        return redirect()->back()->with('success', 'Cập nhật lớp học thành công!');
    }

    // Màn hình xếp lớp
    public function classArrangeStudent($MaLop)
    {
        //Lấy giá trị năm học từ session
        $selectedYear = session()->get('selectedYear');

        //Lấy danh sách học sinh trong lớp theo năm học
        $HocSinhModel = new HocSinhModel();

        $SQL = "SELECT hocsinh.*, taikhoan.*, lop.TenLop
        FROM hocsinh
        JOIN taikhoan ON taikhoan.MaTK = hocsinh.MaTK
        JOIN hocsinh_lop ON hocsinh.MaHS = hocsinh_lop.MaHS
        JOIN lop ON lop.MaLop = hocsinh_lop.MaLop
        WHERE hocsinh_lop.MaLop = '$MaLop' AND hocsinh_lop.NamHoc = '$selectedYear'";
        $studentList = $HocSinhModel->query($SQL)->getResultArray();

        // Nếu danh sách không rổng, lấy tên lớp từ bản ghi đầu tiên
        $TenLop = $studentList ? $studentList[0]['TenLop'] : '';
        return view('director/class/arrange/student', [
            'MaLop' => $MaLop,
            'TenLop' => $TenLop,
            'studentList' => $studentList,
            'selectedYear' => $selectedYear,
        ]);
    }

    public function classArrangeTeacher($MaLop)
    {
        //Lưu học kỳ vào session
        $semester = $this->request->getVar('semester');
        if ($semester) {
            session()->set('selectedSemester', $semester);
        }

        //Lấy giá trị năm học từ session
        $selectedYear = session()->get('selectedYear');

        //Nhận giá trị học kỳ , từ khóa tìm kiếm từ query string
        $searchTerm = $this->request->getVar('search') ?? '';
        $selectedSemester = $this->request->getVar('semester') ?? 'Học kỳ 1';

        // Tách tên học kỳ để lấy số
        $semesterNumber = preg_replace('/\D/', '', $selectedSemester);

        //Lấy thông tin giáo viên dạy lớp được chọn
        $GiaoVienModel = new GiaoVienModel();

        $SQL = "SELECT giaovien.*, taikhoan.*, lop.TenLop, monhoc.TenMH
        FROM giaovien
        JOIN taikhoan ON taikhoan.MaTK = giaovien.MaTK
        JOIN phancong ON phancong.MaGV = giaovien.MaGV
        JOIN lop ON lop.MaLop = phancong.MaLop
        JOIN monhoc ON monhoc.MaMH = phancong.MaMH
        WHERE phancong.MaLop = '$MaLop' AND phancong.NamHoc = '$selectedYear'";

        // Lọc theo học kỳ được chọn nếu có
        if ($selectedSemester) {
            $SQL .= " AND phancong.HocKy = $semesterNumber";
        }

        // Nếu có từ khóa tìm kiếm, áp dụng bộ lọc
        if ($searchTerm) {
            $SQL .= " AND (taikhoan.HoTen LIKE '%$searchTerm%' OR giaovien.MaGV LIKE '%$searchTerm%')";
        }

        //Nhóm kết quả theo mã giáo viên, tên giáo viên, tên lớp và tên môn học
        $SQL .= " GROUP BY giaovien.MaGV, taikhoan.HoTen, lop.TenLop, monhoc.TenMH
        ORDER BY monhoc.maMH ASC";

        //Thực thi câu truy vấn
        $teacherList = $GiaoVienModel->query($SQL)->getResultArray();

        // Nếu danh sách không rổng, lấy tên lớp từ bản ghi đầu tiên
        $TenLop = $teacherList ? $teacherList[0]['TenLop'] : '';

        return view('director/class/arrange/teacher', [
            'MaLop' => $MaLop,
            'TenLop' => $TenLop,
            'teacherList' => $teacherList,
            'selectedYear' => $selectedYear,
            'selectedSemester' => $selectedSemester,
            'searchTerm' => $searchTerm,
        ]);
    }

    public function classArrangeAddStudent($MaLop)
    {
        $HocSinhLopModel = new HocSinhLopModel();
        $LopModel = new LopModel();

        //Lấy giá trị năm học từ session
        $selectedYear = session()->get('selectedYear');


        //Lấy danh sách học sinh chưa được xếp lớp trong năm học đã chọn (loại bỏ những học sinh lớp 12 năm trước đó)
        $studentList = $HocSinhLopModel->getStudentNotInClass($selectedYear);

        //Chuẩn bị mảng options cho dropdown chọn học sinh
        $studentOptions = array_map(function ($student) {
            return $student['MaHS'] . ' - ' . $student['HoTen'] . ' - ' . date('d/m/Y', strtotime($student['NgaySinh']));
        }, $studentList);

        //Lấy tên lớp dựa vào mã lớp được chọn
        $TenLop = $LopModel->find($MaLop)['TenLop'];

        return view(
            'director/class/arrange/addstudent',
            [
                'studentOptions' => $studentOptions,
                'MaLop' => $MaLop,
                'TenLop' => $TenLop,
                'selectedYear' => $selectedYear,
            ]
        );
    }

    public function addStudentToClass()
    {
        $errors = [];

        //Bắt đầu transaction
        $db = \Config\Database::connect();
        $db->transStart();

        $LopModel = new LopModel();
        $HocSinhLopModel = new HocSinhLopModel();
        $ThamSoModel = new ThamSoModel();
        $PhanCongModel = new PhanCongModel();
        $HanhKiemModel = new HanhKiemModel();
        $CTPTTModel = new CTPTTModel();

        //Lấy TenLop, NamHoc, MaHS từ form
        $className = $this->request->getPost('student_classname');
        $year = $this->request->getPost('student_year');
        $studentInfo = $this->request->getPost('student_studentInfo');

        //Tách MaHS từ chuỗi studentInfo
        $MaHS = explode(' - ', $studentInfo)[0];

        //Lấy MaLop từ TenLop
        $MaLop = $LopModel->where('TenLop', $className)->first()['MaLop'];

        // Kiểm tra đã chọn học sinh chưa
        if (empty($studentInfo)) {
            $errors['student_studentInfo'] = 'Vui lòng chọn học sinh.';
        }

        // Kiểm tra xem học sinh đã được xếp lớp chưa
        if ($HocSinhLopModel->checkStudentInClass($MaHS, $MaLop, $year)) {
            $errors['student_StudentInClass'] = 'Học sinh đã được xếp lớp trong năm học này.';
        }
        // Kiểm tra giới hạn sĩ số của lớp
        $maxClassSize = $ThamSoModel->getGiaTriThamSo('SiSoLopToiDa');
        $currentClassSize = $HocSinhLopModel->countStudentInClass($MaLop, $year);
        if ($currentClassSize >= $maxClassSize) {
            $errors['student_ClassSize'] = 'Lớp đã đạt giới hạn sĩ số tối đa.';
        }

        //Nếu có lỗi, trả về cùng thông báo
        if (!empty($errors)) {
            return redirect()->back()->withInput()->with('errors', $errors);
        }

        try {
            // Thêm học sinh vào lớp học trong năm học
            $HocSinhLopModel->addStudentToClass($MaHS, $MaLop, $year);

            // Thêm thông tin hạnh kiểm của học sinh
            $HanhKiemModel->addConduct($MaHS, $year);

            // Thêm thông tin học phí cho học sinh
            $tuitionFee = $ThamSoModel->getGiaTriThamSo('MucHocPhiNamHoc');
            $CTPTTModel->addTuition($MaHS, $year, $tuitionFee);

            // Kiểm tra nếu tất cả thành công
            if ($db->transStatus() === FALSE) {
                throw new \Exception('Transaction failed');
            }

            // Xác nhận transaction
            $db->transCommit();

            // Khi học sinh được xếp lớp, hóa đơn sẽ được thêm vào db
            $Hoadon = new HoaDonModel();
            $result = $Hoadon->addInvoice($MaHS, $year);
            // chỗ này thêm lỗi nè 

            return redirect()->back()->with('success', 'Thêm học sinh vào lớp học thành công!');
        } catch (\Exception $e) {
            // Nếu có lỗi, rollback transaction
            $db->transRollback();
            return redirect()->back()->with('error', 'Không thể thêm học sinh vào lớp học. Vui lòng thử lại.');
        }
    }

    public function classArrangeAddTeacher($MaLop)
    {
        $GiaoVienModel = new GiaoVienModel();
        $MonHocModel = new MonHocModel();
        $LopModel = new LopModel();

        // Lấy giá trị năm học, học kỳ từ session
        $selectedYear = session()->get('selectedYear');
        $selectedSemester = session()->get('selectedSemester');

        //Lấy tên lớp dựa vào mã lớp được chọn
        $TenLop = $LopModel->find($MaLop)['TenLop'];

        // Lấy danh sách giáo viên chưa dạy lớp đã chọn trong năm học
        $teacherList = $GiaoVienModel->getTeacherList();

        // Chuẩn bị mảng options cho dropdown chọn giáo viên
        $teacherOptions = array_map(function ($teacher) {
            return $teacher['MaGV'] . ' - ' . $teacher['HoTen'];
        }, $teacherList);

        $subjectList = array_column($MonHocModel->getSubjectList(), 'TenMH');

        return view('director/class/arrange/addteacher', [
            'teacherOptions' => $teacherOptions,
            'subjectList' => $subjectList,
            'MaLop' => $MaLop,
            'TenLop' => $TenLop,
            'selectedYear' => $selectedYear,
            'selectedSemester' => $selectedSemester,
        ]);
    }

    public function addTeacherToClass()
    {
        $errors = [];

        $PhanCongModel = new PhanCongModel();
        $LopModel = new LopModel();
        $MonHocModel = new MonHocModel();

        // Lấy dữ liệu từ form
        $className = $this->request->getPost('teacher_classname');
        $year = $this->request->getPost('teacher_year');
        $semester = $this->request->getPost('teacher_semester');
        $teacherInfo = $this->request->getPost('teacher_teacherInfo');
        $subjectName = $this->request->getPost('teacher_subject');

        // Tách tên học kỳ để lấy số
        $HocKy = preg_replace('/\D/', '', $semester);
        // Lấy MaLop từ tên lớp
        $MaLop = $LopModel->where('TenLop', $className)->first()['MaLop'];

        // Kiểm tra đã chọn giáo viên chưa
        if (empty($teacherInfo)) {
            $errors['teacher_teacherInfo'] = 'Vui lòng chọn giáo viên.';
        }

        // Kiểm tra đã chọn môn học chưa
        if (empty($subjectName)) {
            $errors['teacher_subject'] = 'Vui lòng chọn môn học.';
        }

        // Nếu có lỗi, trả về cùng thông báo
        if (!empty($errors)) {
            return redirect()->back()->withInput()->with('errors', $errors);
        }

        // Lấy MaMH từ tên môn học
        $MaMH = $MonHocModel->where('TenMH', $subjectName)->first()['MaMH'];
        // Tách MaGV từ chuỗi teacherInfo
        $MaGV = explode(' - ', $teacherInfo)[0];

        // Kiểm tra giáo viên đã được phân công dạy môn học 
        // trong năm học, học kỳ và lớp học đó chưa
        if ($PhanCongModel->isTeacherAssigned($MaGV, $MaMH, $MaLop, $HocKy, $year)) {
            $errors['teacher_TeacherAssigned'] = 'Giáo viên đã được phân công dạy môn học này trong lớp học.';
        }

        // Kiểm tra môn học đã có giáo viên phân công dạy trong năm học, học kỳ và lớp học đó chưa
        if ($PhanCongModel->isSubjectAssigned($MaMH, $MaLop, $HocKy, $year)) {
            $errors['teacher_SubjectAssigned'] = 'Môn học đã có giáo viên phân công dạy trong lớp học.';
        }

        //Nếu có lỗi, trả về cùng thông báo
        if (!empty($errors)) {
            return redirect()->back()->withInput()->with('errors', $errors);
        }

        //Lưu thông tin phân công giáo viên dạy môn học trong lớp học
        $PhanCongModel->addTeacherToAssign($MaGV, $MaMH, $MaLop, $HocKy, $year);

        return redirect()->back()->with('success', 'Phân công giáo viên dạy môn học thành công!');
    }

    // Màn hình quản lý giáo viên
    public function employeeTeacherList()
    {
        $GiaoVienModel = new GiaoVienModel();

        //Nhận giá trị tìm kiếm từ query string
        $searchTerm = $this->request->getVar('search') ?? '';

        //Tạo query lấy danh sách giáo viên
        $GiaoVien = $GiaoVienModel
            ->select('giaovien.*, taikhoan.*')
            ->join('taikhoan', 'taikhoan.MaTK = giaovien.MaTK');

        //Nếu có từ khóa tìm kiếm, áp dụng bộ lọc
        if ($searchTerm) {
            $GiaoVien->groupStart()
                ->like('taikhoan.HoTen', $searchTerm)
                ->orLike('giaovien.MaGV', $searchTerm)
                ->groupEnd();
        }
        $teacherList = $GiaoVien->findAll();
        return view('director/employee/teacher/list', [
            'teacherList' => $teacherList,
            'searchTerm' => $searchTerm,
        ]);
    }

    public function employeeTeacherAdd()
    {
        $GiaoVienModel = new GiaoVienModel();

        // Lấy mã giáo viên lớn nhất hiện tại
        $lastTeacher = $GiaoVienModel->select('MaGV')->orderBy('MaGV', 'DESC')->first();

        // Sinh mã giáo viên mới
        $newMaGV = 'GV0001'; // Giá trị mặc định nếu chưa có mã nào
        if ($lastTeacher && preg_match('/^GV(\d+)$/', $lastTeacher['MaGV'], $matches)) {
            $newIndex = (int)$matches[1] + 1;
            $newMaGV = 'GV' . str_pad($newIndex, 4, '0', STR_PAD_LEFT);
        }
        return view('director/employee/teacher/add', ['newMaGV' => $newMaGV]);
    }

    public function addEmployeeTeacher()
    {
        $errors = [];
        // Lấy dữ liệu từ form
        $birthday = $this->request->getPost('teacher_birthday');
        $email = $this->request->getPost('teacher_email');
        $password = $this->request->getPost('teacher_password');
        $phone = $this->request->getPost('teacher_phone');
        $gender = $this->request->getPost('teacher_gender');
        $role = $this->request->getPost('teacher_role');
        //Kiểm tra giới tính
        if (empty($gender))
            $errors['teacher_gender'] = 'Vui lòng chọn giới tính.';

        //Kiểm tra chức vụ
        if (empty($role))
            $errors['teacher_role'] = 'Vui lòng chọn chức vụ.';

        // Kiểm tra ngày sinh
        if (strtotime($birthday) > strtotime(date('Y-m-d')))
            $errors['teacher_birthday'] = 'Ngày sinh không hợp lệ.';

        if (empty($birthday))
            $errors['teacher_birthday'] = 'Vui lòng nhập ngày sinh.';

        // Kiểm tra email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            $errors['teacher_email'] = 'Email không đúng định dạng.';

        // Kiểm tra mật khẩu
        if (strlen($password) < 6)
            $errors['teacher_password'] = 'Mật khẩu phải có ít nhất 6 ký tự.';

        // Kiểm tra số điện thoại
        if (!preg_match('/^\d{10}$/', $phone))
            $errors['teacher_phone'] = 'Số điện thoại phải có đúng 10 chữ số.';

        // Nếu có lỗi, trả về cùng thông báo
        if (!empty($errors)) {
            return redirect()->back()->withInput()->with('errors', $errors);
        }

        $TaiKhoanModel = new TaiKhoanModel();
        $GiaoVienModel = new GiaoVienModel();

        $MaTK = $TaiKhoanModel->insert([
            'TenTK' => $this->request->getPost('teacher_account'),
            'MatKhau' => $this->request->getPost('teacher_password'),
            'Email' => $this->request->getPost('teacher_email'),
            'HoTen' => $this->request->getPost('teacher_name'),
            'SoDienThoai' => $this->request->getPost('teacher_phone'),
            'DiaChi' => $this->request->getPost('teacher_address'),
            'GioiTinh' => $this->request->getPost('teacher_gender'),
            'NgaySinh' => $this->request->getPost('teacher_birthday'),
            'MaVT' => 2, // Mã vai trò giáo viên
        ]);

        // Lưu thông tin giáo viên
        $GiaoVienModel->insert([
            'MaTK' => $MaTK,
            'ChucVu' => $this->request->getPost('teacher_role'),
            'TinhTrang' => $this->request->getPost('teacher_status') ?? 'Đang giảng dạy',
        ]);

        return redirect()->back()->with('success', 'Thêm giáo viên mới thành công!');
    }

    public function employeeTeacherUpdate($MaGV)
    {
        $GiaoVienModel = new GiaoVienModel();

        // Lấy thông tin giáo viên dựa trên MaGV
        $SQL = "SELECT giaovien.*, taikhoan.*
        FROM giaovien
        JOIN taikhoan ON taikhoan.MaTK = giaovien.MaTK
        WHERE giaovien.MaGV = '$MaGV'";

        // Thực thi câu truy vấn
        $teacher = $GiaoVienModel->query($SQL)->getRowArray();

        return view('director/employee/teacher/update', ['teacher' => $teacher]);
    }

    public function updateEmployeeTeacher($MaGV)
    {
        $errors = [];
        // Lấy dữ liệu từ form
        $MaGV = $this->request->getPost('MaGV');
        $MaTK = $this->request->getPost('MaTK');
        $password = $this->request->getPost('teacher_password');
        $birthday = $this->request->getPost('teacher_birthday');
        $email = $this->request->getPost('teacher_email');
        $phone = $this->request->getPost('teacher_phone');
        $gender = $this->request->getPost('teacher_gender');
        $role = $this->request->getPost('teacher_role');
        $status = $this->request->getPost('teacher_status');

        // Kiểm tra ngày sinh
        if (strtotime($birthday) > strtotime(date('Y-m-d')))
            $errors['teacher_birthday'] = 'Ngày sinh không hợp lệ.';

        // Kiểm tra email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            $errors['teacher_email'] = 'Email không đúng định dạng.';

        // Kiểm tra số điện thoại
        if (!preg_match('/^\d{10}$/', $phone))
            $errors['teacher_phone'] = 'Số điện thoại phải có đúng 10 chữ số.';

        //Kiểm tra mật khẩu
        if (strlen($password) < 6)
            $errors['teacher_password'] = 'Mật khẩu phải có ít nhất 6 ký tự.';

        // Nếu có lỗi, trả về cùng thông báo
        if (!empty($errors)) {
            return redirect()->back()->withInput()->with('errors', $errors);
        }

        $TaiKhoanModel = new TaiKhoanModel();
        $GiaoVienModel = new GiaoVienModel();

        // Cập nhật thông tin tài khoản
        $TaiKhoan = "UPDATE taikhoan
        SET MatKhau = '$password' , Email = '$email', SoDienThoai = '$phone', GioiTinh = '$gender', NgaySinh = '$birthday'
        WHERE MaTK = '$MaTK'";
        $TaiKhoanModel->query($TaiKhoan);

        // Cập nhật thông tin giáo viên
        $GiaoVien = "UPDATE giaovien
        SET ChucVu = '$role', TinhTrang = '$status'
        WHERE MaGV = '$MaGV'";
        $GiaoVienModel->query($GiaoVien);

        return redirect()->back()->with('success', 'Cập nhật thông tin giáo viên thành công!');
    }

    // Màn hình quản lý giám thị
    public function employeeSupervisorList()
    {
        $GiamThiModel = new GiamThiModel();

        //Nhận giá trị tìm kiếm từ query string
        $searchTerm = $this->request->getVar('search') ?? '';

        //Tạo query lấy danh sách giám thị
        $GiamThi = $GiamThiModel
            ->select('giamthi.*, taikhoan.*')
            ->join('taikhoan', 'taikhoan.MaTK = giamthi.MaTK');

        //Nếu có từ khóa tìm kiếm, áp dụng bộ lọc
        if ($searchTerm) {
            $GiamThi->groupStart()
                ->like('taikhoan.HoTen', $searchTerm)
                ->orLike('giamthi.MaGT', $searchTerm)
                ->groupEnd();
        }
        $supervisorList = $GiamThi->findAll();
        return view('director/employee/supervisor/list', [
            'supervisorList' => $supervisorList,
            'searchTerm' => $searchTerm,
        ]);
    }

    public function employeeSupervisorAdd()
    {
        $GiamThiModel = new GiamThiModel();

        // Lấy mã giám thị lớn nhất hiện tại
        $lastSupervisor = $GiamThiModel->select('MaGT')->orderBy('MaGT', 'DESC')->first();

        // Sinh mã giám thị mới
        $newMaGT = 'GT0001'; // Giá trị mặc định nếu chưa có mã nào
        if ($lastSupervisor && preg_match('/^GT(\d+)$/', $lastSupervisor['MaGT'], $matches)) {
            $newIndex = (int)$matches[1] + 1;
            $newMaGT = 'GT' . str_pad($newIndex, 4, '0', STR_PAD_LEFT);
        }
        return view('director/employee/supervisor/add', ['newMaGT' => $newMaGT]);
    }

    public function addEmployeeSupervisor()
    {
        $errors = [];
        // Lấy dữ liệu từ form
        $birthday = $this->request->getPost('supervisor_birthday');
        $email = $this->request->getPost('supervisor_email');
        $password = $this->request->getPost('supervisor_password');
        $phone = $this->request->getPost('supervisor_phone');
        $gender = $this->request->getPost('supervisor_gender');

        //Kiểm tra giới tính
        if (empty($gender))
            $errors['cashier_gender'] = 'Vui lòng chọn giới tính.';

        // Kiểm tra ngày sinh
        if (strtotime($birthday) > strtotime(date('Y-m-d')))
            $errors['cashier_birthday'] = 'Ngày sinh không hợp lệ.';

        if (empty($birthday))
            $errors['cashier_birthday'] = 'Vui lòng nhập ngày sinh.';

        // Kiểm tra email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            $errors['cashier_email'] = 'Email không đúng định dạng.';

        // Kiểm tra mật khẩu
        if (strlen($password) < 6)
            $errors['cashier_password'] = 'Mật khẩu phải có ít nhất 6 ký tự.';

        // Kiểm tra số điện thoại
        if (!preg_match('/^\d{10}$/', $phone))
            $errors['cashier_phone'] = 'Số điện thoại phải có đúng 10 chữ số.';

        // Nếu có lỗi, trả về cùng thông báo
        if (!empty($errors)) {
            return redirect()->back()->withInput()->with('errors', $errors);
        }

        $TaiKhoanModel = new TaiKhoanModel();
        $GiamThiModel = new GiamThiModel();

        $MaTK = $TaiKhoanModel->insert([
            'TenTK' => $this->request->getPost('supervisor_account'),
            'MatKhau' => $this->request->getPost('supervisor_password'),
            'Email' => $this->request->getPost('supervisor_email'),
            'HoTen' => $this->request->getPost('supervisor_name'),
            'SoDienThoai' => $this->request->getPost('supervisor_phone'),
            'DiaChi' => $this->request->getPost('supervisor_address'),
            'GioiTinh' => $this->request->getPost('supervisor_gender'),
            'NgaySinh' => $this->request->getPost('supervisor_birthday'),
            'MaVT' => 5, // Mã vai trò giám thị
        ]);

        // Lưu thông tin giám thị
        $GiamThiModel->insert([
            'MaTK' => $MaTK,
            'TinhTrang' => $this->request->getPost('supervisor_status') ?? 'Đang làm việc',
        ]);

        return redirect()->back()->with('success', 'Thêm giám thị mới thành công!');
    }

    public function employeeSupervisorUpdate($MaGT)
    {
        $GiamThiModel = new GiamThiModel();
        $TaiKhoanModel = new TaiKhoanModel();

        // Lấy thông tin giám thị theo mã
        $GiamThi = $GiamThiModel
            ->select('giamthi.*, taikhoan.*')
            ->join('taikhoan', 'taikhoan.MaTK = giamthi.MaTK')
            ->where('giamthi.MaGT', $MaGT)
            ->first();

        if (!$GiamThi) {
            return redirect()->back()->with('error', 'Không tìm thấy giám thị.');
        }
        return view('director/employee/supervisor/update', ['supervisor' => $GiamThi]);
    }

    public function updateEmployeeSupervisor()
    {
        $errors = [];
        // Lấy dữ liệu từ form
        $MaGT = $this->request->getPost('MaGT');
        $MaTK = $this->request->getPost('MaTK');
        $birthday = $this->request->getPost('supervisor_birthday');
        $email = $this->request->getPost('supervisor_email');
        $password = $this->request->getPost('supervisor_password');
        $phone = $this->request->getPost('supervisor_phone');
        $gender = $this->request->getPost('supervisor_gender');

        //Kiểm tra giới tính
        if (empty($gender))
            $errors['cashier_gender'] = 'Vui lòng chọn giới tính.';

        // Kiểm tra ngày sinh
        if (strtotime($birthday) > strtotime(date('Y-m-d')))
            $errors['cashier_birthday'] = 'Ngày sinh không hợp lệ.';

        if (empty($birthday))
            $errors['cashier_birthday'] = 'Vui lòng nhập ngày sinh.';

        // Kiểm tra email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            $errors['cashier_email'] = 'Email không đúng định dạng.';

        // Kiểm tra mật khẩu
        if (strlen($password) < 6)
            $errors['cashier_password'] = 'Mật khẩu phải có ít nhất 6 ký tự.';

        // Kiểm tra số điện thoại
        if (!preg_match('/^\d{10}$/', $phone))
            $errors['cashier_phone'] = 'Số điện thoại phải có đúng 10 chữ số.';

        // Nếu có lỗi, trả về cùng thông báo
        if (!empty($errors)) {
            return redirect()->back()->withInput()->with('errors', $errors);
        }

        $GiamThiModel = new GiamThiModel();
        $TaiKhoanModel = new TaiKhoanModel();

        // Cập nhật thông tin tài khoản
        $TaiKhoanModel->update($MaTK, [
            'TenTK' => $this->request->getPost('supervisor_account'),
            'MatKhau' => $this->request->getPost('supervisor_password'),
            'HoTen' => $this->request->getPost('supervisor_name'),
            'Email' => $this->request->getPost('supervisor_email'),
            'SoDienThoai' => $this->request->getPost('supervisor_phone'),
            'DiaChi' => $this->request->getPost('supervisor_address'),
            'GioiTinh' => $this->request->getPost('supervisor_gender'),
            'NgaySinh' => $this->request->getPost('supervisor_birthday'),
        ]);

        // Cập nhật thông tin giám thị
        $GiamThiModel->update($MaGT, [
            'TinhTrang' => $this->request->getPost('supervisor_status'),
        ]);

        // Xử lý thông báo
        if ($TaiKhoanModel && $GiamThiModel) {
            return redirect()->back()->with('success', 'Cập nhật thông tin thành công!');
        } else {
            return redirect()->back()->with('errors', 'Không thể cập nhật. Vui lòng thử lại.');
        }
    }

    // Màn hình thông tin cá nhân
    public function profile()
    {
        $BanGiamHieuModel = new BanGiamHieuModel();

        // Lấy thông tin tài khoản hiện tại
        $MaTK = session('MaTK');

        // Lấy thông tin ban giám hiệu
        $BanGiamHieu = $BanGiamHieuModel
            ->select('bangiamhieu.*, taikhoan.*')
            ->join('taikhoan', 'taikhoan.MaTK = bangiamhieu.MaTK')
            ->where('bangiamhieu.MaTK', $MaTK)
            ->first();

        return view('director/profile', [
            'director' => $BanGiamHieu,
        ]);
    }

    public function updateProfile()
    {
        $errors = [];
        // Lấy dữ liệu từ form
        $MaBGH = $this->request->getPost('MaBGH');
        $MaTK = $this->request->getPost('MaTK');
        $email = $this->request->getPost('director_email');
        $phone = $this->request->getPost('director_phone');

        // Kiểm tra email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            $errors['director_email'] = 'Email không đúng định dạng.';
        // Kiểm tra số điện thoại
        if (!preg_match('/^\d{10}$/', $phone))
            $errors['director_phone'] = 'Số điện thoại phải có đúng 10 chữ số.';
        // Nếu có lỗi, trả về cùng thông báo
        if (!empty($errors)) {
            return redirect()->back()->withInput()->with('errors', $errors);
        }

        $BanGiamHieuModel = new BanGiamHieuModel();
        $TaiKhoanModel = new TaiKhoanModel();

        // Cập nhật thông tin tài khoản
        $TaiKhoanModel->update($MaTK, [
            'Email' => $this->request->getPost('director_email'),
            'SoDienThoai' => $this->request->getPost('director_phone'),
            'DiaChi' => $this->request->getPost('director_address'),
        ]);

        // Xử lý thông báo
        if ($TaiKhoanModel) {
            return redirect()->back()->with('success', 'Cập nhật thông tin thành công!');
        } else {
            return redirect()->back()->with('errors', 'Không thể cập nhật. Vui lòng thử lại.');
        }
    }

    public function changepw()
    {
        return view('director/changepw');
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

        return redirect()->back()->with('success', 'Đổi mật khẩu thành công!');
    }

    // Màn hình quản lý thu ngân
    public function employeeCashierList()
    {
        $ThuNganModel = new ThuNganModel();

        // Nhận giá trị tìm kiếm từ query string
        $searchTerm = $this->request->getVar('search') ?? '';

        // Tạo query lấy danh sách thu ngân
        $ThuNgan = $ThuNganModel
            ->select('thungan.*, taikhoan.*')
            ->join('taikhoan', 'taikhoan.MaTK = thungan.MaTK');

        // Nếu có từ khóa tìm kiếm, áp dụng bộ lọc
        if ($searchTerm) {
            $ThuNgan->groupStart()
                ->like('taikhoan.HoTen', $searchTerm)
                ->orLike('thungan.MaTN', $searchTerm)
                ->groupEnd();
        }
        $cashierList = $ThuNgan->findAll();

        return view('director/employee/cashier/list', [
            'cashierList' => $cashierList,
            'searchTerm' => $searchTerm,
        ]);
    }
    public function employeeCashierAdd()
    {
        $ThuNganModel = new ThuNganModel();

        // Lấy mã thu ngân lớn nhất hiện tại
        $lastCashier = $ThuNganModel->select('MaTN')->orderBy('MaTN', 'DESC')->first();

        // Sinh mã thu ngân mới
        $newMaTN = 'TN0001'; // Giá trị mặc định nếu chưa có mã nào
        if ($lastCashier && preg_match('/^TN(\d+)$/', $lastCashier['MaTN'], $matches)) {
            $newIndex = (int)$matches[1] + 1;
            $newMaTN = 'TN' . str_pad($newIndex, 4, '0', STR_PAD_LEFT);
        }

        return view('director/employee/cashier/add', ['newMaTN' => $newMaTN]);
    }

    public function addEmployeeCashier()
    {
        $errors = [];
        // Lấy dữ liệu từ form
        $birthday = $this->request->getPost('cashier_birthday');
        $email = $this->request->getPost('cashier_email');
        $password = $this->request->getPost('cashier_password');
        $phone = $this->request->getPost('cashier_phone');
        $gender = $this->request->getPost('cashier_gender');

        //Kiểm tra giới tính
        if (empty($gender))
            $errors['cashier_gender'] = 'Vui lòng chọn giới tính.';

        // Kiểm tra ngày sinh
        if (strtotime($birthday) > strtotime(date('Y-m-d')))
            $errors['cashier_birthday'] = 'Ngày sinh không hợp lệ.';

        if (empty($birthday))
            $errors['cashier_birthday'] = 'Vui lòng nhập ngày sinh.';

        // Kiểm tra email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            $errors['cashier_email'] = 'Email không đúng định dạng.';

        // Kiểm tra mật khẩu
        if (strlen($password) < 6)
            $errors['cashier_password'] = 'Mật khẩu phải có ít nhất 6 ký tự.';

        // Kiểm tra số điện thoại
        if (!preg_match('/^\d{10}$/', $phone))
            $errors['cashier_phone'] = 'Số điện thoại phải có đúng 10 chữ số.';

        // Nếu có lỗi, trả về cùng thông báo
        if (!empty($errors)) {
            return redirect()->back()->withInput()->with('errors', $errors);
        }

        $TaiKhoanModel = new TaiKhoanModel();
        $ThuNganModel = new ThuNganModel();

        $MaTK = $TaiKhoanModel->insert([
            'TenTK' => $this->request->getPost('cashier_account'),
            'MatKhau' => $this->request->getPost('cashier_password'),
            'Email' => $this->request->getPost('cashier_email'),
            'HoTen' => $this->request->getPost('cashier_name'),
            'SoDienThoai' => $this->request->getPost('cashier_phone'),
            'DiaChi' => $this->request->getPost('cashier_address'),
            'GioiTinh' => $this->request->getPost('cashier_gender'),
            'NgaySinh' => $this->request->getPost('cashier_birthday'),
            'MaVT' => 4, // Mã vai trò thu ngân
        ]);

        // Lưu thông tin thu ngân
        $ThuNganModel->insert([
            'MaTK' => $MaTK,
            'TinhTrang' => $this->request->getPost('cashier_status') ?? 'Đang làm việc',
        ]);

        return redirect()->back()->with('success', 'Thêm thu ngân mới thành công!');
    }

    public function employeeCashierUpdate($MaTN)
    {
        $ThuNganModel = new ThuNganModel();
        $TaiKhoanModel = new TaiKhoanModel();

        // Lấy thông tin Thu ngân dựa vào MaTN
        $ThuNgan = $ThuNganModel
            ->select('thungan.*, taikhoan.*')
            ->join('taikhoan', 'taikhoan.MaTK = thungan.MaTK')
            ->where('thungan.MaTN', $MaTN)
            ->first();

        if (!$ThuNgan) {
            return redirect()->back()->with('error', 'Không tìm thấy thông tin Thu ngân.');
        }
        return view('director/employee/cashier/update', ['cashier' => $ThuNgan]);
    }

    public function updateEmployeeCashier($MaTN)
    {
        $ThuNganModel = new ThuNganModel();
        $TaiKhoanModel = new TaiKhoanModel();

        $errors = [];
        // Lấy dữ liệu từ form
        $MaTN = $this->request->getPost('MaTN');
        $MaTK = $this->request->getPost('MaTK');
        $birthday = $this->request->getPost('cashier_birthday');
        $email = $this->request->getPost('cashier_email');
        $password = $this->request->getPost('cashier_password');
        $phone = $this->request->getPost('cashier_phone');
        $gender = $this->request->getPost('cashier_gender');
        $status = $this->request->getPost('cashier_status');

        log_message('debug', 'Dữ liệu Tình trạng nhận được: ' . print_r($status, true));

        //Kiểm tra giới tính
        if (empty($gender))
            $errors['cashier_gender'] = 'Vui lòng chọn giới tính.';

        // Kiểm tra ngày sinh
        if (strtotime($birthday) > strtotime(date('Y-m-d')))
            $errors['cashier_birthday'] = 'Ngày sinh không hợp lệ.';

        if (empty($birthday))
            $errors['cashier_birthday'] = 'Vui lòng nhập ngày sinh.';

        // Kiểm tra email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            $errors['cashier_email'] = 'Email không đúng định dạng.';

        // Kiểm tra mật khẩu
        if (strlen($password) < 6)
            $errors['cashier_password'] = 'Mật khẩu phải có ít nhất 6 ký tự.';

        // Kiểm tra số điện thoại
        if (!preg_match('/^\d{10}$/', $phone))
            $errors['cashier_phone'] = 'Số điện thoại phải có đúng 10 chữ số.';

        // Nếu có lỗi, trả về cùng thông báo
        if (!empty($errors)) {
            return redirect()->back()->withInput()->with('errors', $errors);
        }

        // Cập nhật thông tin tài khoản
        $TaiKhoanModel->update($MaTK, [
            'HoTen' => $this->request->getPost('cashier_name'),
            'Email' => $this->request->getPost('cashier_email'),
            'SoDienThoai' => $this->request->getPost('cashier_phone'),
            'DiaChi' => $this->request->getPost('cashier_address'),
            'GioiTinh' => $this->request->getPost('cashier_gender'),
            'NgaySinh' => $this->request->getPost('cashier_birthday'),
        ]);


        // Cập nhật thông tin thu ngân
        $ThuNganModel->update($MaTN, [
            'TinhTrang' => $this->request->getPost('cashier_status'),
        ]);

        // Xử lý thông báo
        if ($TaiKhoanModel && $ThuNganModel) {
            return redirect()->back()->with('success', 'Cập nhật thông tin thành công!');
        } else {
            return redirect()->back()->with('errors', 'Không thể cập nhật. Vui lòng thử lại.');
        }
    }
}
