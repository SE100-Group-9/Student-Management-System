-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th12 06, 2024 lúc 04:16 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `sms`
--

DELIMITER $$
--
-- Thủ tục
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertHocSinh` ()   BEGIN
    DECLARE i INT DEFAULT 41;
    DECLARE MaHS VARCHAR(10);
    
    WHILE i <= 225 DO
        -- Tạo mã học sinh (HS0041, HS0042, ...)
        SET MaHS = CONCAT('HS', LPAD(i, 4, '0'));
        
        -- Chèn dữ liệu vào bảng HOCSINH
        INSERT INTO HOCSINH (MaHS, MaTK, DanToc, NoiSinh, TinhTrang)
        VALUES (
            MaHS, 
            (SELECT MaTK FROM TAIKHOAN WHERE TenTK = MaHS), 
            'Kinh', 
            'Hồ Chí Minh', 
            'Đang học'
        );
        
        -- Tăng giá trị i
        SET i = i + 1;
    END WHILE;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `bangiamhieu`
--

CREATE TABLE `bangiamhieu` (
  `MaBGH` varchar(10) NOT NULL,
  `MaTK` int(11) DEFAULT NULL,
  `ChucVu` enum('Hiệu trưởng','Phó hiệu trưởng') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `bangiamhieu`
--

INSERT INTO `bangiamhieu` (`MaBGH`, `MaTK`, `ChucVu`) VALUES
('BGH0001', 1, 'Hiệu trưởng'),
('BGH0002', 2, 'Phó hiệu trưởng');

--
-- Bẫy `bangiamhieu`
--
DELIMITER $$
CREATE TRIGGER `trg_BGH_BeforeInsert` BEFORE INSERT ON `bangiamhieu` FOR EACH ROW BEGIN
    SET NEW.MaBGH = CONCAT('BGH', LPAD((SELECT IFNULL(MAX(CAST(SUBSTRING(MaBGH, 4) AS UNSIGNED)), 0) + 1 FROM BANGIAMHIEU), 4, '0'));
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cttpt`
--

CREATE TABLE `cttpt` (
  `MaCTPTT` int(11) NOT NULL,
  `MaHS` varchar(10) DEFAULT NULL,
  `NamHoc` varchar(10) DEFAULT NULL,
  `HocKy` int(11) DEFAULT NULL,
  `TongHocPhi` float DEFAULT NULL,
  `DaThanhToan` tinyint(1) DEFAULT NULL,
  `TrangThai` varchar(50) DEFAULT NULL,
  `NgayCapNhat` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `danhhieu`
--

CREATE TABLE `danhhieu` (
  `MaDH` int(11) NOT NULL,
  `TenDH` varchar(100) DEFAULT NULL,
  `DiemTBToiThieu` float DEFAULT NULL,
  `DiemHanhKiemToiThieu` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `danhhieu`
--

INSERT INTO `danhhieu` (`MaDH`, `TenDH`, `DiemTBToiThieu`, `DiemHanhKiemToiThieu`) VALUES
(1, 'Học sinh Giỏi', 8, 80),
(2, 'Học sinh Tiên tiến', 6.5, 65),
(3, 'Học sinh Trung bình', 5, 50);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `diem`
--

CREATE TABLE `diem` (
  `MaDiem` int(11) NOT NULL,
  `MaHS` varchar(10) DEFAULT NULL,
  `MaGV` varchar(10) DEFAULT NULL,
  `MaMH` int(11) DEFAULT NULL,
  `DiemTX1` float DEFAULT NULL,
  `DiemTX2` float DEFAULT NULL,
  `DiemTX3` float DEFAULT NULL,
  `DiemGK` float DEFAULT NULL,
  `DiemCK` float DEFAULT NULL,
  `HocKy` int(11) DEFAULT NULL,
  `NamHoc` varchar(10) DEFAULT NULL,
  `NhanXet` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `giamthi`
--

CREATE TABLE `giamthi` (
  `MaGT` varchar(10) DEFAULT NULL,
  `MaTK` int(11) DEFAULT NULL,
  `TinhTrang` enum('Đang làm việc','Đã nghỉ việc') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `giamthi`
--

INSERT INTO `giamthi` (`MaGT`, `MaTK`, `TinhTrang`) VALUES
('GT0001', 68, 'Đang làm việc'),
('GT0002', 69, 'Đang làm việc'),
('GT0003', 70, 'Đang làm việc'),
('GT0004', 71, 'Đang làm việc'),
('GT0005', 72, 'Đang làm việc');

--
-- Bẫy `giamthi`
--
DELIMITER $$
CREATE TRIGGER `trg_GT_BeforeInsert` BEFORE INSERT ON `giamthi` FOR EACH ROW BEGIN
    SET NEW.MaGT = CONCAT('GT', LPAD((SELECT IFNULL(MAX(CAST(SUBSTRING(MaGT, 3) AS UNSIGNED)), 0) + 1 FROM GIAMTHI), 4, '0'));
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `giaovien`
--

CREATE TABLE `giaovien` (
  `MaGV` varchar(10) NOT NULL,
  `MaTK` int(11) DEFAULT NULL,
  `ChucVu` enum('Tổ trưởng','Tổ phó','Giáo viên') DEFAULT NULL,
  `TinhTrang` enum('Đang dạy','Đã nghỉ việc') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `giaovien`
--

INSERT INTO `giaovien` (`MaGV`, `MaTK`, `ChucVu`, `TinhTrang`) VALUES
('GV0001', 3, 'Giáo viên', 'Đang dạy'),
('GV0002', 4, 'Tổ trưởng', 'Đang dạy'),
('GV0003', 5, 'Giáo viên', 'Đang dạy'),
('GV0004', 6, 'Tổ phó', 'Đang dạy'),
('GV0005', 7, 'Giáo viên', 'Đang dạy'),
('GV0006', 8, 'Giáo viên', 'Đang dạy'),
('GV0007', 9, 'Tổ phó', 'Đang dạy'),
('GV0008', 10, 'Giáo viên', 'Đang dạy'),
('GV0009', 11, 'Giáo viên', 'Đang dạy'),
('GV0010', 12, 'Tổ trưởng', 'Đang dạy'),
('GV0011', 13, 'Giáo viên', 'Đang dạy'),
('GV0012', 14, 'Tổ trưởng', 'Đang dạy'),
('GV0013', 15, 'Giáo viên', 'Đang dạy'),
('GV0014', 16, 'Tổ phó', 'Đang dạy'),
('GV0015', 17, 'Giáo viên', 'Đang dạy'),
('GV0016', 18, 'Giáo viên', 'Đang dạy'),
('GV0017', 19, 'Tổ phó', 'Đang dạy'),
('GV0018', 20, 'Giáo viên', 'Đang dạy'),
('GV0019', 21, 'Giáo viên', 'Đã nghỉ việc'),
('GV0020', 22, 'Tổ trưởng', 'Đã nghỉ việc');

--
-- Bẫy `giaovien`
--
DELIMITER $$
CREATE TRIGGER `trg_GV_BeforeInsert` BEFORE INSERT ON `giaovien` FOR EACH ROW BEGIN
    SET NEW.MaGV = CONCAT('GV', LPAD((SELECT IFNULL(MAX(CAST(SUBSTRING(MaGV, 3) AS UNSIGNED)), 0) + 1 FROM GIAOVIEN), 4, '0'));
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `giaovien_lop`
--

CREATE TABLE `giaovien_lop` (
  `MaGV` varchar(10) DEFAULT NULL,
  `MaLop` int(11) DEFAULT NULL,
  `HocKy` int(11) DEFAULT NULL,
  `NamHoc` varchar(10) DEFAULT NULL,
  `VaiTro` enum('Giáo viên chủ nhiệm','Giáo viên bộ môn') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `giaovien_monhoc`
--

CREATE TABLE `giaovien_monhoc` (
  `MaGV` varchar(10) DEFAULT NULL,
  `MaMH` int(11) DEFAULT NULL,
  `HocKy` int(11) DEFAULT NULL,
  `NamHoc` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hocsinh`
--

CREATE TABLE `hocsinh` (
  `MaHS` varchar(10) NOT NULL,
  `MaTK` int(11) DEFAULT NULL,
  `DanToc` varchar(50) DEFAULT NULL,
  `NoiSinh` varchar(100) DEFAULT NULL,
  `TinhTrang` enum('Đang học','Đã nghỉ học','Đã tốt nghiệp') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `hocsinh`
--

INSERT INTO `hocsinh` (`MaHS`, `MaTK`, `DanToc`, `NoiSinh`, `TinhTrang`) VALUES
('HS0001', 23, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0002', 24, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0003', 25, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0004', 26, 'Tày', 'Lào Cai', 'Đang học'),
('HS0005', 27, 'Mường', 'Hòa Bình', 'Đang học'),
('HS0006', 28, 'Kinh', 'Đà Nẵng', 'Đang học'),
('HS0007', 29, 'Khmer', 'Trà Vinh', 'Đang học'),
('HS0008', 30, 'Tày', 'Lạng Sơn', 'Đang học'),
('HS0009', 31, 'Mường', 'Sơn La', 'Đang học'),
('HS0010', 32, 'Kinh', 'Cần Thơ', 'Đang học'),
('HS0011', 33, 'Tày', 'Hòa Bình', 'Đang học'),
('HS0012', 34, 'Kinh', 'Hà Nội', 'Đang học'),
('HS0013', 35, 'Tày', 'Lạng Sơn', 'Đang học'),
('HS0014', 36, 'Khmer', 'Sóc Trăng', 'Đang học'),
('HS0015', 37, 'Kinh', 'Hà Nội', 'Đang học'),
('HS0016', 38, 'Mường', 'Thanh Hóa', 'Đang học'),
('HS0017', 39, 'Kinh', 'Quảng Ninh', 'Đang học'),
('HS0018', 40, 'Khmer', 'Bạc Liêu', 'Đang học'),
('HS0019', 41, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0020', 42, 'Tày', 'Quảng Ninh', 'Đang học'),
('HS0021', 43, 'Mường', 'Nghệ An', 'Đang học'),
('HS0022', 44, 'Kinh', 'Hải Phòng', 'Đang học'),
('HS0023', 45, 'Khmer', 'An Giang', 'Đang học'),
('HS0024', 46, 'Kinh', 'Đắk Lắk', 'Đang học'),
('HS0025', 47, 'Tày', 'Lào Cai', 'Đang học'),
('HS0026', 48, 'Mường', 'Sơn La', 'Đang học'),
('HS0027', 49, 'Khmer', 'Tiền Giang', 'Đang học'),
('HS0028', 50, 'Tày', 'Lạng Sơn', 'Đang học'),
('HS0029', 51, 'Kinh', 'Ninh Bình', 'Đang học'),
('HS0030', 52, 'Khmer', 'Hà Giang', 'Đang học'),
('HS0031', 53, 'Mường', 'Bình Phước', 'Đang học'),
('HS0032', 54, 'Kinh', 'Đắk Nông', 'Đang học'),
('HS0033', 55, 'Tày', 'Thái Nguyên', 'Đang học'),
('HS0034', 56, 'Kinh', 'Kon Tum', 'Đang học'),
('HS0035', 57, 'Khmer', 'Vĩnh Long', 'Đang học'),
('HS0036', 58, 'Mường', 'Phú Thọ', 'Đang học'),
('HS0037', 59, 'Kinh', 'Bình Định', 'Đang học'),
('HS0038', 60, 'Khmer', 'Cà Mau', 'Đang học'),
('HS0039', 61, 'Tày', 'Hà Giang', 'Đang học'),
('HS0040', 62, 'Mường', 'Nghệ An', 'Đang học'),
('HS0041', 73, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0042', 74, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0043', 75, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0044', 76, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0045', 77, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0046', 78, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0047', 79, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0048', 80, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0049', 81, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0050', 82, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0051', 83, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0052', 84, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0053', 85, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0054', 86, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0055', 87, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0056', 88, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0057', 89, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0058', 90, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0059', 91, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0060', 92, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0061', 93, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0062', 94, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0063', 95, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0064', 96, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0065', 97, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0066', 98, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0067', 99, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0068', 100, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0069', 101, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0070', 102, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0071', 103, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0072', 104, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0073', 105, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0074', 106, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0075', 107, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0076', 108, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0077', 109, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0078', 110, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0079', 111, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0080', 112, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0081', 113, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0082', 114, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0083', 115, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0084', 116, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0085', 117, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0086', 118, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0087', 119, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0088', 120, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0089', 121, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0090', 122, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0091', 123, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0092', 124, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0093', 125, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0094', 126, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0095', 127, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0096', 128, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0097', 129, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0098', 130, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0099', 131, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0100', 132, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0101', 133, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0102', 134, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0103', 135, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0104', 136, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0105', 137, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0106', 138, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0107', 139, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0108', 140, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0109', 141, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0110', 142, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0111', 143, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0112', 144, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0113', 145, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0114', 146, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0115', 147, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0116', 148, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0117', 149, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0118', 150, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0119', 151, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0120', 152, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0121', 153, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0122', 154, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0123', 155, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0124', 156, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0125', 157, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0126', 158, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0127', 159, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0128', 160, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0129', 161, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0130', 162, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0131', 163, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0132', 164, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0133', 165, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0134', 166, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0135', 167, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0136', 168, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0137', 169, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0138', 170, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0139', 171, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0140', 172, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0141', 173, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0142', 174, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0143', 175, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0144', 176, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0145', 177, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0146', 178, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0147', 179, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0148', 180, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0149', 181, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0150', 182, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0151', 183, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0152', 184, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0153', 185, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0154', 186, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0155', 187, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0156', 188, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0157', 189, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0158', 190, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0159', 191, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0160', 192, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0161', 193, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0162', 194, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0163', 195, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0164', 196, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0165', 197, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0166', 198, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0167', 199, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0168', 200, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0169', 201, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0170', 202, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0171', 203, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0172', 204, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0173', 205, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0174', 206, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0175', 207, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0176', 208, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0177', 209, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0178', 210, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0179', 211, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0180', 212, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0181', 213, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0182', 214, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0183', 215, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0184', 216, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0185', 217, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0186', 218, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0187', 219, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0188', 220, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0189', 221, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0190', 222, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0191', 223, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0192', 224, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0193', 225, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0194', 226, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0195', 227, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0196', 228, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0197', 229, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0198', 230, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0199', 231, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0200', 232, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0201', 233, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0202', 234, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0203', 235, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0204', 236, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0205', 237, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0206', 238, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0207', 239, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0208', 240, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0209', 241, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0210', 242, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0211', 243, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0212', 244, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0213', 245, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0214', 246, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0215', 247, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0216', 248, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0217', 249, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0218', 250, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0219', 251, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0220', 252, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0221', 253, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0222', 254, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0223', 255, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0224', 256, 'Kinh', 'Hồ Chí Minh', 'Đang học'),
('HS0225', 257, 'Kinh', 'Hồ Chí Minh', 'Đang học');

--
-- Bẫy `hocsinh`
--
DELIMITER $$
CREATE TRIGGER `trg_HS_BeforeInsert` BEFORE INSERT ON `hocsinh` FOR EACH ROW BEGIN
    SET NEW.MaHS = CONCAT('HS', LPAD((SELECT IFNULL(MAX(CAST(SUBSTRING(MaHS, 3) AS UNSIGNED)), 0) + 1 FROM HOCSINH), 4, '0'));
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hocsinh_lop`
--

CREATE TABLE `hocsinh_lop` (
  `MaHS` varchar(10) DEFAULT NULL,
  `MaLop` int(11) DEFAULT NULL,
  `NamHoc` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `hocsinh_lop`
--

INSERT INTO `hocsinh_lop` (`MaHS`, `MaLop`, `NamHoc`) VALUES
('HS0001', 1, '2023-2024'),
('HS0002', 1, '2023-2024'),
('HS0003', 1, '2023-2024'),
('HS0004', 1, '2023-2024'),
('HS0005', 1, '2023-2024'),
('HS0006', 1, '2023-2024'),
('HS0007', 1, '2023-2024'),
('HS0008', 1, '2023-2024'),
('HS0009', 1, '2023-2024'),
('HS0010', 1, '2023-2024'),
('HS0011', 2, '2023-2024'),
('HS0012', 2, '2023-2024'),
('HS0013', 2, '2023-2024'),
('HS0014', 2, '2023-2024'),
('HS0015', 2, '2023-2024'),
('HS0016', 2, '2023-2024'),
('HS0017', 2, '2023-2024'),
('HS0018', 2, '2023-2024'),
('HS0019', 2, '2023-2024'),
('HS0020', 2, '2023-2024'),
('HS0021', 3, '2023-2024'),
('HS0022', 3, '2023-2024'),
('HS0023', 3, '2023-2024'),
('HS0024', 3, '2023-2024'),
('HS0025', 3, '2023-2024'),
('HS0026', 3, '2023-2024'),
('HS0027', 3, '2023-2024'),
('HS0028', 3, '2023-2024'),
('HS0029', 3, '2023-2024'),
('HS0030', 3, '2023-2024'),
('HS0031', 4, '2023-2024'),
('HS0032', 4, '2023-2024'),
('HS0033', 4, '2023-2024'),
('HS0034', 4, '2023-2024'),
('HS0035', 4, '2023-2024'),
('HS0036', 4, '2023-2024'),
('HS0037', 4, '2023-2024'),
('HS0038', 4, '2023-2024'),
('HS0039', 4, '2023-2024'),
('HS0040', 4, '2023-2024'),
('HS0041', 5, '2023-2024'),
('HS0042', 5, '2023-2024'),
('HS0043', 5, '2023-2024'),
('HS0044', 5, '2023-2024'),
('HS0045', 5, '2023-2024'),
('HS0046', 5, '2023-2024'),
('HS0047', 5, '2023-2024'),
('HS0048', 5, '2023-2024'),
('HS0049', 5, '2023-2024'),
('HS0050', 5, '2023-2024'),
('HS0051', 6, '2023-2024'),
('HS0052', 6, '2023-2024'),
('HS0053', 6, '2023-2024'),
('HS0054', 6, '2023-2024'),
('HS0055', 6, '2023-2024'),
('HS0056', 6, '2023-2024'),
('HS0057', 6, '2023-2024'),
('HS0058', 6, '2023-2024'),
('HS0059', 6, '2023-2024'),
('HS0060', 6, '2023-2024'),
('HS0061', 1, '2024-2025'),
('HS0062', 1, '2024-2025'),
('HS0063', 1, '2024-2025'),
('HS0064', 1, '2024-2025'),
('HS0065', 1, '2024-2025'),
('HS0066', 1, '2024-2025'),
('HS0067', 1, '2024-2025'),
('HS0068', 1, '2024-2025'),
('HS0069', 1, '2024-2025'),
('HS0070', 1, '2024-2025'),
('HS0071', 2, '2024-2025'),
('HS0072', 2, '2024-2025'),
('HS0073', 2, '2024-2025'),
('HS0074', 2, '2024-2025'),
('HS0075', 2, '2024-2025'),
('HS0076', 2, '2024-2025'),
('HS0077', 2, '2024-2025'),
('HS0078', 2, '2024-2025'),
('HS0079', 2, '2024-2025'),
('HS0080', 2, '2024-2025'),
('HS0081', 3, '2024-2025'),
('HS0082', 3, '2024-2025'),
('HS0083', 3, '2024-2025'),
('HS0084', 3, '2024-2025'),
('HS0085', 3, '2024-2025'),
('HS0086', 3, '2024-2025'),
('HS0087', 3, '2024-2025'),
('HS0088', 3, '2024-2025'),
('HS0089', 3, '2024-2025'),
('HS0090', 3, '2024-2025'),
('HS0091', 4, '2024-2025'),
('HS0092', 4, '2024-2025'),
('HS0093', 4, '2024-2025'),
('HS0094', 4, '2024-2025'),
('HS0095', 4, '2024-2025'),
('HS0096', 4, '2024-2025'),
('HS0097', 4, '2024-2025'),
('HS0098', 4, '2024-2025'),
('HS0099', 4, '2024-2025'),
('HS0100', 4, '2024-2025'),
('HS0101', 5, '2024-2025'),
('HS0102', 5, '2024-2025'),
('HS0103', 5, '2024-2025'),
('HS0104', 5, '2024-2025'),
('HS0105', 5, '2024-2025'),
('HS0106', 5, '2024-2025'),
('HS0107', 5, '2024-2025'),
('HS0108', 5, '2024-2025'),
('HS0109', 5, '2024-2025'),
('HS0110', 5, '2024-2025'),
('HS0111', 6, '2024-2025'),
('HS0112', 6, '2024-2025'),
('HS0113', 6, '2024-2025'),
('HS0114', 6, '2024-2025'),
('HS0115', 6, '2024-2025'),
('HS0116', 6, '2024-2025'),
('HS0117', 6, '2024-2025'),
('HS0118', 6, '2024-2025'),
('HS0119', 6, '2024-2025'),
('HS0120', 6, '2024-2025');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `loaivipham`
--

CREATE TABLE `loaivipham` (
  `MaLVP` int(11) NOT NULL,
  `TenLVP` varchar(255) DEFAULT NULL,
  `DiemTru` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `loaivipham`
--

INSERT INTO `loaivipham` (`MaLVP`, `TenLVP`, `DiemTru`) VALUES
(1, 'Đi trễ', 1),
(2, 'Không mang đồng phục', 1),
(3, 'Xả rác không đúng nơi quy định', 1),
(4, 'Không làm bài tập', 2),
(5, 'Gây mất trật tự trong lớp', 2),
(6, 'Không tham gia lao động tập thể', 2),
(7, 'Sử dụng điện thoại trong giờ học', 3),
(8, 'Không tham gia hoạt động ngoại khóa bắt buộc', 3),
(9, 'Nghỉ học không phép', 5),
(10, 'Vi phạm nội quy phòng thí nghiệm', 5),
(11, 'Tự ý rời khỏi trường trong giờ học', 5),
(12, 'Che giấu vi phạm của học sinh khác', 7),
(13, 'Gian lận trong kiểm tra', 10),
(14, 'Vô lễ với giáo viên', 10),
(15, 'Hút thuốc lá trong khuôn viên trường', 15),
(16, 'Đánh nhau', 20),
(17, 'Phá hoại tài sản nhà trường', 20),
(18, 'Mang đồ nguy hiểm vào trường', 20);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `lop`
--

CREATE TABLE `lop` (
  `MaLop` int(11) NOT NULL,
  `TenLop` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `lop`
--

INSERT INTO `lop` (`MaLop`, `TenLop`) VALUES
(1, '10_1'),
(2, '10_2'),
(3, '11_1'),
(4, '11_2'),
(5, '12_1'),
(6, '12_2');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `monhoc`
--

CREATE TABLE `monhoc` (
  `MaMH` int(11) NOT NULL,
  `TenMH` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `monhoc`
--

INSERT INTO `monhoc` (`MaMH`, `TenMH`) VALUES
(1, 'Toán học'),
(2, 'Vật lý'),
(3, 'Hóa học'),
(4, 'Sinh học'),
(5, 'Tin học'),
(6, 'Ngữ văn'),
(7, 'Lịch sử'),
(8, 'Địa lý'),
(9, 'Ngoại ngữ'),
(10, 'GDCD'),
(11, 'Công nghệ'),
(12, 'GDQP');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phieuthanhtoan`
--

CREATE TABLE `phieuthanhtoan` (
  `MaPTT` int(11) NOT NULL,
  `MaHS` varchar(10) DEFAULT NULL,
  `MaTN` varchar(10) DEFAULT NULL,
  `SoTien` float DEFAULT NULL,
  `NgayThanhToan` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `taikhoan`
--

CREATE TABLE `taikhoan` (
  `MaTK` int(11) NOT NULL,
  `TenTK` varchar(50) NOT NULL,
  `MatKhau` varchar(255) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `HoTen` varchar(100) NOT NULL,
  `SoDienThoai` varchar(15) DEFAULT NULL,
  `DiaChi` text DEFAULT NULL,
  `GioiTinh` enum('Nam','Nữ') NOT NULL,
  `NgaySinh` date DEFAULT NULL,
  `MaVT` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `taikhoan`
--

INSERT INTO `taikhoan` (`MaTK`, `TenTK`, `MatKhau`, `Email`, `HoTen`, `SoDienThoai`, `DiaChi`, `GioiTinh`, `NgaySinh`, `MaVT`) VALUES
(1, 'BGH0001', '123abc', 'hieu.truong@example.com', 'Trần Đình Phương Linh', '0901234567', '123 Lê Lợi, Hồ Chí Minh', 'Nữ', '1970-05-12', 1),
(2, 'BGH0002', '123abc', 'pho.hieu@example.com', 'Đặng Thị Ngọc Minh', '0906789123', '789 Cách Mạng, Hồ Chí Minh', 'Nữ', '1975-02-10', 1),
(3, 'GV0001', '123abc', 'giaovien1@gmail.com', 'Nguyễn Thị Ngọc Hải', '0902345678', '456 Trần Hưng Đạo, Quận 1, TP.HCM', 'Nữ', '1980-09-20', 2),
(4, 'GV0002', '123abc', 'giaovien2@gmail.com', 'Phạm Văn Hưng', '0902345679', '123 Nguyễn Thị Minh Khai, Quận 3, TP.HCM', 'Nam', '1982-03-15', 2),
(5, 'GV0003', '123abc', 'giaovien3@gmail.com', 'Trần Thanh Mai', '0902345680', '789 Lý Thái Tổ, Quận 10, TP.HCM', 'Nữ', '1985-11-02', 2),
(6, 'GV0004', '123abc', 'giaovien4@gmail.com', 'Lê Quang Hải', '0902345681', '12 Nguyễn Văn Linh, Quận 7, TP.HCM', 'Nam', '1978-06-14', 2),
(7, 'GV0005', '123abc', 'giaovien5@gmail.com', 'Ngô Thị Hồng', '0902345682', '25 Lê Văn Sỹ, Quận Phú Nhuận, TP.HCM', 'Nữ', '1989-07-22', 2),
(8, 'GV0006', '123abc', 'giaovien6@gmail.com', 'Võ Văn Hòa', '0902345683', '36 Phạm Ngũ Lão, Quận 1, TP.HCM', 'Nam', '1983-12-01', 2),
(9, 'GV0007', '123abc', 'giaovien7@gmail.com', 'Nguyễn Thị Hoa', '0902345684', '78 Nguyễn Trãi, Quận 5, TP.HCM', 'Nữ', '1990-10-09', 2),
(10, 'GV0008', '123abc', 'giaovien8@gmail.com', 'Hoàng Văn Tâm', '0902345685', '56 Võ Văn Kiệt, Quận Bình Tân, TP.HCM', 'Nam', '1975-05-27', 2),
(11, 'GV0009', '123abc', 'giaovien9@gmail.com', 'Bùi Thị Lan', '0902345686', '88 Điện Biên Phủ, Quận Bình Thạnh, TP.HCM', 'Nữ', '1991-08-17', 2),
(12, 'GV0010', '123abc', 'giaovien10@gmail.com', 'Lê Minh Khôi', '0902345687', '15 Hùng Vương, Quận 5, TP.HCM', 'Nam', '1987-09-05', 2),
(13, 'GV0011', '123abc', 'giaovien11@gmail.com', 'Nguyễn Thị Minh', '0902345688', '37 Cộng Hòa, Quận Tân Bình, TP.HCM', 'Nữ', '1986-01-19', 2),
(14, 'GV0012', '123abc', 'giaovien12@gmail.com', 'Đỗ Văn Trung', '0902345689', '92 Lê Thị Riêng, Quận 1, TP.HCM', 'Nam', '1979-03-22', 2),
(15, 'GV0013', '123abc', 'giaovien13@gmail.com', 'Phan Thị Bích', '0902345690', '43 Nguyễn Đình Chiểu, Quận 3, TP.HCM', 'Nữ', '1982-04-11', 2),
(16, 'GV0014', '123abc', 'giaovien14@gmail.com', 'Trương Văn Hậu', '0902345691', '67 Trần Quang Khải, Quận 1, TP.HCM', 'Nam', '1981-12-06', 2),
(17, 'GV0015', '123abc', 'giaovien15@gmail.com', 'Ngô Thị Kim', '0902345692', '21 Hồ Hảo Hớn, Quận 1, TP.HCM', 'Nữ', '1984-07-03', 2),
(18, 'GV0016', '123abc', 'giaovien16@gmail.com', 'Lê Văn Phong', '0902345693', '40 Nguyễn Hữu Thọ, Quận 7, TP.HCM', 'Nam', '1985-02-28', 2),
(19, 'GV0017', '123abc', 'giaovien17@gmail.com', 'Vũ Thị Thảo', '0902345694', '66 Huỳnh Tấn Phát, Quận 7, TP.HCM', 'Nữ', '1992-11-16', 2),
(20, 'GV0018', '123abc', 'giaovien18@gmail.com', 'Nguyễn Văn Tài', '0902345695', '73 Nguyễn Văn Nghi, Quận Gò Vấp, TP.HCM', 'Nam', '1977-08-01', 2),
(21, 'GV0019', '123abc', 'giaovien19@gmail.com', 'Phạm Thị Xuân', '0902345696', '84 Nguyễn Văn Đậu, Quận Bình Thạnh, TP.HCM', 'Nữ', '1980-09-10', 2),
(22, 'GV0020', '123abc', 'giaovien20@gmail.com', 'Trần Văn Quý', '0902345697', '91 Đinh Tiên Hoàng, Quận 1, TP.HCM', 'Nam', '1983-05-18', 2),
(23, 'HS0001', '123abc', 'hocsinh1@gmail.com', 'Nguyễn Khánh Huy', '0903456789', '789 Nguyễn Trãi, Quận 1, TP.HCM', 'Nam', '2006-03-15', 3),
(24, 'HS0002', '123abc', 'hocsinh2@gmail.com', 'Trần Minh Tuấn', '0903456790', '12 Lê Lợi, Quận 3, TP.HCM', 'Nam', '2006-06-22', 3),
(25, 'HS0003', '123abc', 'hocsinh3@gmail.com', 'Lê Ngọc Ánh', '0903456791', '45 Trần Hưng Đạo, Quận 5, TP.HCM', 'Nữ', '2006-08-11', 3),
(26, 'HS0004', '123abc', 'hocsinh4@gmail.com', 'Võ Thị Thanh Hà', '0903456792', '33 Nguyễn Văn Linh, Quận 7, TP.HCM', 'Nữ', '2006-09-05', 3),
(27, 'HS0005', '123abc', 'hocsinh5@gmail.com', 'Nguyễn Văn Nam', '0903456793', '23 Lý Tự Trọng, Quận 1, TP.HCM', 'Nam', '2006-11-19', 3),
(28, 'HS0006', '123abc', 'hocsinh6@gmail.com', 'Phạm Huy Hoàng', '0903456794', '67 Nguyễn Đình Chiểu, Quận 3, TP.HCM', 'Nam', '2007-01-03', 3),
(29, 'HS0007', '123abc', 'hocsinh7@gmail.com', 'Trần Bảo Châu', '0903456795', '18 Lê Văn Sỹ, Quận Phú Nhuận, TP.HCM', 'Nữ', '2006-04-14', 3),
(30, 'HS0008', '123abc', 'hocsinh8@gmail.com', 'Hoàng Thị Lan', '0903456796', '75 Võ Văn Kiệt, Quận Bình Tân, TP.HCM', 'Nữ', '2006-05-27', 3),
(31, 'HS0009', '123abc', 'hocsinh9@gmail.com', 'Nguyễn Thành Đạt', '0903456797', '88 Điện Biên Phủ, Quận Bình Thạnh, TP.HCM', 'Nam', '2006-12-08', 3),
(32, 'HS0010', '123abc', 'hocsinh10@gmail.com', 'Lê Văn Hùng', '0903456798', '19 Hùng Vương, Quận 5, TP.HCM', 'Nam', '2007-02-17', 3),
(33, 'HS0011', '123abc', 'hocsinh11@gmail.com', 'Nguyễn Thị Mai', '0903456799', '34 Nguyễn Trãi, Quận 1, TP.HCM', 'Nữ', '2006-06-18', 3),
(34, 'HS0012', '123abc', 'hocsinh12@gmail.com', 'Đỗ Quang Hải', '0903456800', '20 Cộng Hòa, Quận Tân Bình, TP.HCM', 'Nam', '2006-08-30', 3),
(35, 'HS0013', '123abc', 'hocsinh13@gmail.com', 'Phan Minh Khôi', '0903456801', '55 Nguyễn Thị Minh Khai, Quận 3, TP.HCM', 'Nam', '2006-03-12', 3),
(36, 'HS0014', '123abc', 'hocsinh14@gmail.com', 'Vũ Thị Yến', '0903456802', '77 Phạm Ngũ Lão, Quận 1, TP.HCM', 'Nữ', '2006-05-25', 3),
(37, 'HS0015', '123abc', 'hocsinh15@gmail.com', 'Trương Thái Bình', '0903456803', '66 Nguyễn Văn Đậu, Quận Bình Thạnh, TP.HCM', 'Nam', '2006-07-20', 3),
(38, 'HS0016', '123abc', 'hocsinh16@gmail.com', 'Hoàng Ngọc Lan', '0903456804', '39 Lê Văn Việt, Quận 9, TP.HCM', 'Nữ', '2006-09-10', 3),
(39, 'HS0017', '123abc', 'hocsinh17@gmail.com', 'Nguyễn Hồng Phúc', '0903456805', '28 Huỳnh Tấn Phát, Quận 7, TP.HCM', 'Nam', '2006-10-31', 3),
(40, 'HS0018', '123abc', 'hocsinh18@gmail.com', 'Phạm Nhật Minh', '0903456806', '95 Nguyễn Văn Nghi, Quận Gò Vấp, TP.HCM', 'Nam', '2007-01-21', 3),
(41, 'HS0019', '123abc', 'hocsinh19@gmail.com', 'Lê Thị Thảo', '0903456807', '48 Nguyễn Văn Cừ, Quận 5, TP.HCM', 'Nữ', '2006-03-02', 3),
(42, 'HS0020', '123abc', 'hocsinh20@gmail.com', 'Trần Hoài Nam', '0903456808', '21 Đinh Tiên Hoàng, Quận 1, TP.HCM', 'Nam', '2006-04-15', 3),
(43, 'HS0021', '123abc', 'hocsinh21@gmail.com', 'Nguyễn Thu Hằng', '0903456809', '32 Tô Hiến Thành, Quận 10, TP.HCM', 'Nữ', '2006-08-01', 3),
(44, 'HS0022', '123abc', 'hocsinh22@gmail.com', 'Võ Quang Duy', '0903456810', '76 Trần Huy Liệu, Quận Phú Nhuận, TP.HCM', 'Nam', '2006-12-15', 3),
(45, 'HS0023', '123abc', 'hocsinh23@gmail.com', 'Nguyễn Ngọc Bích', '0903456811', '59 Hồ Hảo Hớn, Quận 1, TP.HCM', 'Nữ', '2006-07-28', 3),
(46, 'HS0024', '123abc', 'hocsinh24@gmail.com', 'Lê Minh Nhật', '0903456812', '84 Lý Thường Kiệt, Quận 10, TP.HCM', 'Nam', '2006-09-15', 3),
(47, 'HS0025', '123abc', 'hocsinh25@gmail.com', 'Hoàng Văn Toàn', '0903456813', '25 Trương Định, Quận 1, TP.HCM', 'Nam', '2006-03-21', 3),
(48, 'HS0026', '123abc', 'hocsinh26@gmail.com', 'Vũ Quỳnh Trang', '0903456814', '44 Võ Thị Sáu, Quận 3, TP.HCM', 'Nữ', '2006-11-11', 3),
(49, 'HS0027', '123abc', 'hocsinh27@gmail.com', 'Nguyễn Tấn Phát', '0903456815', '10 Nguyễn Văn Lượng, Quận Gò Vấp, TP.HCM', 'Nam', '2006-05-09', 3),
(50, 'HS0028', '123abc', 'hocsinh28@gmail.com', 'Đỗ Thị Kim Chi', '0903456816', '71 Trần Quang Diệu, Quận 3, TP.HCM', 'Nữ', '2006-10-20', 3),
(51, 'HS0029', '123abc', 'hocsinh29@gmail.com', 'Phan Ngọc Sơn', '0903456817', '53 Hùng Vương, Quận 5, TP.HCM', 'Nam', '2007-01-06', 3),
(52, 'HS0030', '123abc', 'hocsinh30@gmail.com', 'Nguyễn Phương Mai', '0903456818', '26 Nguyễn Văn Cừ, Quận 5, TP.HCM', 'Nữ', '2006-08-12', 3),
(53, 'HS0031', '123abc', 'hocsinh31@gmail.com', 'Lê Minh Hà', '0903456819', '38 Cách Mạng Tháng 8, Quận 10, TP.HCM', 'Nam', '2006-09-25', 3),
(54, 'HS0032', '123abc', 'hocsinh32@gmail.com', 'Trần Ngọc Hân', '0903456820', '62 Tôn Đức Thắng, Quận 1, TP.HCM', 'Nữ', '2006-11-30', 3),
(55, 'HS0033', '123abc', 'hocsinh33@gmail.com', 'Phạm Thanh Thảo', '0903456821', '40 Nguyễn Huệ, Quận 1, TP.HCM', 'Nữ', '2006-03-18', 3),
(56, 'HS0034', '123abc', 'hocsinh34@gmail.com', 'Võ Anh Duy', '0903456822', '16 Nguyễn Đình Chiểu, Quận 3, TP.HCM', 'Nam', '2006-07-14', 3),
(57, 'HS0035', '123abc', 'hocsinh35@gmail.com', 'Nguyễn Thị Thanh Tâm', '0903456823', '49 Nguyễn Khắc Nhu, Quận 1, TP.HCM', 'Nữ', '2006-06-05', 3),
(58, 'HS0036', '123abc', 'hocsinh36@gmail.com', 'Phan Quốc Huy', '0903456824', '85 Nguyễn Văn Trỗi, Quận Tân Bình, TP.HCM', 'Nam', '2006-12-22', 3),
(59, 'HS0037', '123abc', 'hocsinh37@gmail.com', 'Trần Văn Tâm', '0903456825', '33 Tôn Thất Thuyết, Quận 4, TP.HCM', 'Nam', '2007-01-11', 3),
(60, 'HS0038', '123abc', 'hocsinh38@gmail.com', 'Lê Hoài Nam', '0903456826', '12 Trần Bình Trọng, Quận 5, TP.HCM', 'Nam', '2006-04-23', 3),
(61, 'HS0039', '123abc', 'hocsinh39@gmail.com', 'Phạm Văn Long', '0903456827', '50 Pasteur, Quận 3, TP.HCM', 'Nam', '2006-08-19', 3),
(62, 'HS0040', '123abc', 'hocsinh40@gmail.com', 'Hoàng Minh Đức', '0903456828', '70 Phan Văn Hân, Quận Bình Thạnh, TP.HCM', 'Nam', '2006-10-12', 3),
(63, 'TN0001', '123abc', 'thungan1@example.com', 'Phạm Thị Minh Thư', '0904567890', '123 Bạch Đằng, Quận 1, Hồ Chí Minh', 'Nữ', '1990-01-10', 4),
(64, 'TN0002', '123abc', 'thungan2@example.com', 'Nguyễn Minh Phương', '0904567891', '45 Lý Tự Trọng, Quận 1, Hồ Chí Minh', 'Nữ', '1988-06-22', 4),
(65, 'TN0003', '123abc', 'thungan3@example.com', 'Trần Quốc Đạt', '0904567892', '68 Nguyễn Huệ, Quận 5, Hồ Chí Minh', 'Nam', '1985-09-12', 4),
(66, 'TN0004', '123abc', 'thungan4@example.com', 'Lê Thị Thu Hà', '0904567893', '98 Nguyễn Trãi, Quận 11, Hồ Chí Minh', 'Nữ', '1992-04-17', 4),
(67, 'TN0005', '123abc', 'thungan5@example.com', 'Phan Thị Mai Lan', '0904567894', '150 Hùng Vương, Quận 8, Hồ Chí Minh', 'Nữ', '1994-12-03', 4),
(68, 'GT0001', '123abc', 'giamthi1@gmail.com', 'Võ Văn Tân', '0905678901', '456 Pasteur, Bình Thạnh, Hồ Chí Minh', 'Nam', '1985-07-25', 5),
(69, 'GT0002', '123abc', 'giamthi2@gmail.com', 'Nguyễn Thị Lan', '0905678902', '12 Nguyễn Tri Phương, Quận 5, Hồ Chí Minh', 'Nữ', '1990-04-10', 5),
(70, 'GT0003', '123abc', 'giamthi3@gmail.com', 'Trần Thị Thanh', '0905678903', '34 Lê Văn Sỹ, Quận 3, Hồ Chí Minh', 'Nữ', '1988-09-15', 5),
(71, 'GT0004', '123abc', 'giamthi4@gmail.com', 'Lê Minh Khoa', '0905678904', '78 Đường 3 Tháng 2, Quận 10, Hồ Chí Minh', 'Nam', '1983-02-20', 5),
(72, 'GT0005', '123abc', 'giamthi5@gmail.com', 'Phan Thị Kiều Duyên', '0905678905', '123 Nguyễn Hữu Cảnh, Bình Thạnh, Hồ Chí Minh', 'Nữ', '1992-11-12', 5),
(73, 'HS0041', '123abc', 'hocsinh41@gmail.com', 'Nguyễn Khánh Huy', '0903456789', '789 Nguyễn Trãi, Quận 1, TP HCM', 'Nam', '2006-03-15', 3),
(74, 'HS0042', '123abc', 'hocsinh42@gmail.com', 'Trần Thanh Vân', '0903456790', '456 Phan Đình Phùng, Quận 5, TP HCM', 'Nữ', '2006-05-21', 3),
(75, 'HS0043', '123abc', 'hocsinh43@gmail.com', 'Lê Minh Quang', '0903456791', '123 Lê Lợi, Quận 3, TP HCM', 'Nam', '2006-07-14', 3),
(76, 'HS0044', '123abc', 'hocsinh44@gmail.com', 'Phan Minh Tâm', '0903456792', '101 Hàm Nghi, Quận 1, TP HCM', 'Nữ', '2006-09-09', 3),
(77, 'HS0045', '123abc', 'hocsinh45@gmail.com', 'Ngô Minh Tuấn', '0903456793', '202 Bùi Viện, Quận 2, TP HCM', 'Nam', '2006-10-12', 3),
(78, 'HS0046', '123abc', 'hocsinh46@gmail.com', 'Võ Ngọc Quý', '0903456794', '303 Nguyễn Đình Chiểu, Quận 4, TP HCM', 'Nữ', '2006-11-22', 3),
(79, 'HS0047', '123abc', 'hocsinh47@gmail.com', 'Đặng Thái Duy', '0903456795', '404 Trần Phú, Quận 7, TP HCM', 'Nam', '2006-12-05', 3),
(80, 'HS0048', '123abc', 'hocsinh48@gmail.com', 'Hoàng Anh Thư', '0903456796', '505 Lê Văn Sĩ, Quận 8, TP HCM', 'Nữ', '2007-01-25', 3),
(81, 'HS0049', '123abc', 'hocsinh49@gmail.com', 'Phạm Quỳnh Mai', '0903456797', '606 Nguyễn Thị Minh Khai, Quận 10, TP HCM', 'Nữ', '2007-02-28', 3),
(82, 'HS0050', '123abc', 'hocsinh50@gmail.com', 'Bùi Minh Ánh', '0903456798', '707 Tôn Đức Thắng, Quận 6, TP HCM', 'Nam', '2007-04-10', 3),
(83, 'HS0051', '123abc', 'hocsinh51@gmail.com', 'Đoàn Minh Tâm', '0903456799', '808 Xô Viết Nghệ Tĩnh, Quận 11, TP HCM', 'Nữ', '2007-05-18', 3),
(84, 'HS0052', '123abc', 'hocsinh52@gmail.com', 'Lê Thị Lan', '0903456800', '909 Hai Bà Trưng, Quận 12, TP HCM', 'Nam', '2007-06-21', 3),
(85, 'HS0053', '123abc', 'hocsinh53@gmail.com', 'Trần Tiến Dũng', '0903456801', '1010 Phan Văn Trị, Quận 9, TP HCM', 'Nữ', '2007-08-02', 3),
(86, 'HS0054', '123abc', 'hocsinh54@gmail.com', 'Lê Đăng Khoa', '0903456802', '1111 Trần Hưng Đạo, Quận 3, TP HCM', 'Nam', '2007-09-04', 3),
(87, 'HS0055', '123abc', 'hocsinh55@gmail.com', 'Nguyễn Ngọc Trinh', '0903456803', '1212 Nguyễn An Ninh, Quận 5, TP HCM', 'Nữ', '2007-10-15', 3),
(88, 'HS0056', '123abc', 'hocsinh56@gmail.com', 'Hoàng Kim Cương', '0903456804', '1313 Lê Hồng Phong, Quận 10, TP HCM', 'Nam', '2007-11-20', 3),
(89, 'HS0057', '123abc', 'hocsinh57@gmail.com', 'Đinh Thị Kiều Oanh', '0903456805', '1414 Cách Mạng Tháng Tám, Quận 6, TP HCM', 'Nữ', '2007-12-08', 3),
(90, 'HS0058', '123abc', 'hocsinh58@gmail.com', 'Võ Thị Ngọc Lan', '0903456806', '1515 Hòa Bình, Quận 4, TP HCM', 'Nam', '2008-01-12', 3),
(91, 'HS0059', '123abc', 'hocsinh59@gmail.com', 'Trần Thị Cẩm Nhung', '0903456807', '1616 Cộng Hòa, Quận 7, TP HCM', 'Nữ', '2008-02-09', 3),
(92, 'HS0060', '123abc', 'hocsinh60@gmail.com', 'Nguyễn Đức Hải', '0903456808', '1717 Phạm Văn Đồng, Quận 12, TP HCM', 'Nam', '2008-03-04', 3),
(93, 'HS0061', '123abc', 'hocsinh61@gmail.com', 'Bùi Thị Thu Hương', '0903456809', '1818 Nguyễn Văn Cừ, Quận 8, TP HCM', 'Nữ', '2008-04-05', 3),
(94, 'HS0062', '123abc', 'hocsinh62@gmail.com', 'Võ Minh Đức', '0903456810', '1919 Trường Chinh, Quận 2, TP HCM', 'Nam', '2008-05-15', 3),
(95, 'HS0063', '123abc', 'hocsinh63@gmail.com', 'Đặng Tiến Hùng', '0903456811', '2020 Nguyễn Tri Phương, Quận 9, TP HCM', 'Nữ', '2008-06-18', 3),
(96, 'HS0064', '123abc', 'hocsinh64@gmail.com', 'Lê Minh Thư', '0903456812', '2121 Nguyễn Đình Chiểu, Quận 6, TP HCM', 'Nam', '2008-07-21', 3),
(97, 'HS0065', '123abc', 'hocsinh65@gmail.com', 'Hoàng Anh Quỳnh', '0903456813', '2222 Bến Vân Đồn, Quận 7, TP HCM', 'Nữ', '2008-08-02', 3),
(98, 'HS0066', '123abc', 'hocsinh66@gmail.com', 'Nguyễn Kim Hải', '0903456814', '2323 Trần Nhân Tôn, Quận 3, TP HCM', 'Nam', '2008-09-05', 3),
(99, 'HS0067', '123abc', 'hocsinh67@gmail.com', 'Trần Quốc Duy', '0903456815', '2424 Lý Thường Kiệt, Quận 5, TP HCM', 'Nữ', '2008-10-06', 3),
(100, 'HS0068', '123abc', 'hocsinh68@gmail.com', 'Lê Quang Hiếu', '0903456816', '2525 Nguyễn Tất Thành, Quận 2, TP HCM', 'Nam', '2008-11-09', 3),
(101, 'HS0069', '123abc', 'hocsinh69@gmail.com', 'Phan Minh Quang', '0903456817', '2626 Đường Láng, Quận 12, TP HCM', 'Nữ', '2008-12-12', 3),
(102, 'HS0070', '123abc', 'hocsinh70@gmail.com', 'Bùi Tiến Minh', '0903456818', '2727 Nguyễn Văn Linh, Quận 4, TP HCM', 'Nam', '2009-01-15', 3),
(103, 'HS0071', '123abc', 'hocsinh71@gmail.com', 'Đoàn Minh Tuấn', '0903456819', '2828 Phan Đình Phùng, Quận 6, TP HCM', 'Nữ', '2009-02-19', 3),
(104, 'HS0072', '123abc', 'hocsinh72@gmail.com', 'Võ Minh Quý', '0903456820', '2929 Nguyễn Huệ, Quận 7, TP HCM', 'Nam', '2009-03-01', 3),
(105, 'HS0073', '123abc', 'hocsinh73@gmail.com', 'Nguyễn Minh Quân', '0903456821', '3030 Nguyễn Thái Học, Quận 10, TP HCM', 'Nữ', '2009-04-05', 3),
(106, 'HS0074', '123abc', 'hocsinh74@gmail.com', 'Lê Quang Duy', '0903456822', '3131 Trường Sa, Quận 3, TP HCM', 'Nam', '2009-05-10', 3),
(107, 'HS0075', '123abc', 'hocsinh75@gmail.com', 'Phan Anh Tâm', '0903456823', '3232 Bến Tre, Quận 9, TP HCM', 'Nữ', '2009-06-15', 3),
(108, 'HS0076', '123abc', 'hocsinh76@gmail.com', 'Nguyễn Khánh Huy', '0903456789', '789 Nguyễn Trãi, Quận 1,TP HCM', 'Nam', '2006-03-15', 3),
(109, 'HS0077', '123abc', 'hocsinh77@gmail.com', 'Trần Minh Tuấn', '0903456790', '123 Lê Lợi, Quận 1, TP HCM', 'Nam', '2006-05-20', 3),
(110, 'HS0078', '123abc', 'hocsinh78@gmail.com', 'Phan Thanh Hòa', '0903456791', '456 Đinh Tiên Hoàng, Quận 3, TP HCM', 'Nữ', '2006-09-10', 3),
(111, 'HS0079', '123abc', 'hocsinh79@gmail.com', 'Lê Thị Lan', '0903456792', '789 Phan Đình Phùng, Quận 5, TP HCM', 'Nữ', '2006-02-11', 3),
(112, 'HS0080', '123abc', 'hocsinh80@gmail.com', 'Nguyễn Quang Bình', '0903456793', '101 Nguyễn Huệ, Quận 2, TP HCM', 'Nam', '2006-04-22', 3),
(113, 'HS0081', '123abc', 'hocsinh81@gmail.com', 'Vũ Thanh Thảo', '0903456794', '202 Trần Hưng Đạo, Quận 1, TP HCM', 'Nữ', '2006-07-30', 3),
(114, 'HS0082', '123abc', 'hocsinh82@gmail.com', 'Lý Thanh Vân', '0903456795', '303 Nguyễn Đình Chiểu, Quận 10, TP HCM', 'Nam', '2006-08-14', 3),
(115, 'HS0083', '123abc', 'hocsinh83@gmail.com', 'Hồ Minh Tâm', '0903456796', '404 Lý Thường Kiệt, Quận 7, TP HCM', 'Nữ', '2006-11-05', 3),
(116, 'HS0084', '123abc', 'hocsinh84@gmail.com', 'Bùi Thị Lan Anh', '0903456797', '505 Võ Văn Kiệt, Quận 11, TP HCM', 'Nữ', '2006-01-01', 3),
(117, 'HS0085', '123abc', 'hocsinh85@gmail.com', 'Phan Quang Tuấn', '0903456798', '606 Hồ Học Lãm, Quận 4, TP HCM', 'Nam', '2006-06-18', 3),
(118, 'HS0086', '123abc', 'hocsinh86@gmail.com', 'Ngô Minh Khôi', '0903456799', '707 Trường Chinh, Quận 12, TP HCM', 'Nam', '2006-12-30', 3),
(119, 'HS0087', '123abc', 'hocsinh87@gmail.com', 'Đoàn Thị Ngọc', '0903456800', '808 Nguyễn Văn Cừ, Quận 2, TP HCM', 'Nữ', '2006-03-02', 3),
(120, 'HS0088', '123abc', 'hocsinh88@gmail.com', 'Hoàng Thanh Tâm', '0903456801', '909 Bến Thành, Quận 10, TP HCM', 'Nam', '2006-04-17', 3),
(121, 'HS0089', '123abc', 'hocsinh89@gmail.com', 'Dương Minh Khánh', '0903456802', '1010 Lê Quang Định, Quận 5, TP HCM', 'Nữ', '2006-10-22', 3),
(122, 'HS0090', '123abc', 'hocsinh90@gmail.com', 'Trương Minh Triết', '0903456803', '1111 Trần Quốc Toản, Quận 3, TP HCM', 'Nam', '2006-09-12', 3),
(123, 'HS0091', '123abc', 'hocsinh91@gmail.com', 'Lê Thiên Hương', '0903456804', '1212 Võ Thị Sáu, Quận 7, TP HCM', 'Nữ', '2006-11-25', 3),
(124, 'HS0092', '123abc', 'hocsinh92@gmail.com', 'Nguyễn Minh Kiên', '0903456805', '1313 Phạm Ngũ Lão, Quận 1, TP HCM', 'Nam', '2006-07-09', 3),
(125, 'HS0093', '123abc', 'hocsinh93@gmail.com', 'Đinh Thi Thảo', '0903456806', '1414 Lê Quang Định, Quận 4, TP HCM', 'Nữ', '2006-10-30', 3),
(126, 'HS0094', '123abc', 'hocsinh94@gmail.com', 'Trần Huy Thông', '0903456807', '1515 Tôn Đức Thắng, Quận 6, TP HCM', 'Nam', '2006-08-28', 3),
(127, 'HS0095', '123abc', 'hocsinh95@gmail.com', 'Nguyễn Kiều Oanh', '0903456808', '1616 Phạm Hữu Lầu, Quận 3, TP HCM', 'Nữ', '2006-12-01', 3),
(128, 'HS0096', '123abc', 'hocsinh96@gmail.com', 'Vũ Quốc Bảo', '0903456809', '1717 Lý Thái Tổ, Quận 9, TP HCM', 'Nam', '2006-04-03', 3),
(129, 'HS0097', '123abc', 'hocsinh97@gmail.com', 'Hoàng Thị Lan', '0903456810', '1818 Cách Mạng Tháng 8, Quận 5, TP HCM', 'Nữ', '2006-01-28', 3),
(130, 'HS0098', '123abc', 'hocsinh98@gmail.com', 'Lê Thiên Quang', '0903456811', '1919 Nguyễn Công Trứ, Quận 12, TP HCM', 'Nam', '2006-07-18', 3),
(131, 'HS0099', '123abc', 'hocsinh99@gmail.com', 'Nguyễn Hoàng Thanh', '0903456812', '2020 Nguyễn Thị Minh Khai, Quận 1, TP HCM', 'Nữ', '2006-09-22', 3),
(132, 'HS0100', '123abc', 'hocsinh100@gmail.com', 'Vũ Minh Triết', '0903456813', '2121 Trần Bình Trọng, Quận 10, TP HCM', 'Nam', '2006-11-12', 3),
(133, 'HS0101', '123abc', 'hocsinh101@gmail.com', 'Lý Minh Tâm', '0903456814', '2222 Lê Đại Hành, Quận 4, TP HCM', 'Nữ', '2006-02-20', 3),
(134, 'HS0102', '123abc', 'hocsinh102@gmail.com', 'Trương Thị Diễm', '0903456815', '2323 Phan Xích Long, Quận 8, TP HCM', 'Nữ', '2006-05-28', 3),
(135, 'HS0103', '123abc', 'hocsinh103@gmail.com', 'Ngô Thị Thu', '0903456816', '2424 Nguyễn Hồng Đào, Quận 3, TP HCM', 'Nam', '2006-03-07', 3),
(136, 'HS0104', '123abc', 'hocsinh104@gmail.com', 'Dương Thị Huyền', '0903456817', '2525 Nguyễn Khánh Toàn, Quận 1, TP HCM', 'Nữ', '2006-06-25', 3),
(137, 'HS0105', '123abc', 'hocsinh105@gmail.com', 'Hoàng Minh Tuấn', '0903456818', '2626 Hoàng Văn Thụ, Quận 10, TP HCM', 'Nam', '2006-08-06', 3),
(138, 'HS0106', '123abc', 'hocsinh106@gmail.com', 'Lê Thị Mai', '0903456819', '2727 Lý Chính Thắng, Quận 12, TP HCM', 'Nữ', '2006-10-09', 3),
(139, 'HS0107', '123abc', 'hocsinh107@gmail.com', 'Nguyễn Khánh Huy', '0903456789', '789 Nguyễn Trãi, Quận 1, TP HCM', 'Nam', '2006-03-15', 3),
(140, 'HS0108', '123abc', 'hocsinh108@gmail.com', 'Phạm Thanh Tùng', '0903456790', '45 Lê Lợi, Quận 1, TP HCM', 'Nam', '2006-07-22', 3),
(141, 'HS0109', '123abc', 'hocsinh109@gmail.com', 'Lê Thị Hồng', '0903456791', '123 Cách Mạng Tháng 8, Quận 3, TP HCM', 'Nữ', '2006-12-05', 3),
(142, 'HS0110', '123abc', 'hocsinh110@gmail.com', 'Trần Minh Phương', '0903456792', '89 Lý Tự Trọng, Quận 1, TP HCM', 'Nữ', '2006-01-10', 3),
(143, 'HS0111', '123abc', 'hocsinh111@gmail.com', 'Nguyễn Văn An', '0903456793', '56 Nguyễn Văn Trỗi, Phú Nhuận, TP HCM', 'Nam', '2006-02-18', 3),
(144, 'HS0112', '123abc', 'hocsinh112@gmail.com', 'Hoàng Thị Lan', '0903456794', '78 Hoàng Diệu, Quận 4, TP HCM', 'Nữ', '2006-03-20', 3),
(145, 'HS0113', '123abc', 'hocsinh113@gmail.com', 'Đỗ Đức Thịnh', '0903456795', '67 Phạm Văn Đồng, Thủ Đức, TP HCM', 'Nam', '2006-04-25', 3),
(146, 'HS0114', '123abc', 'hocsinh114@gmail.com', 'Lý Thị Nhung', '0903456796', '34 Võ Thị Sáu, Bình Thạnh, TP HCM', 'Nữ', '2006-05-15', 3),
(147, 'HS0115', '123abc', 'hocsinh115@gmail.com', 'Phan Thanh Hào', '0903456797', '21 Điện Biên Phủ, Quận 10, TP HCM', 'Nam', '2006-06-10', 3),
(148, 'HS0116', '123abc', 'hocsinh116@gmail.com', 'Bùi Minh Hạnh', '0903456798', '99 Trần Hưng Đạo, Quận 5, TP HCM', 'Nữ', '2006-08-08', 3),
(149, 'HS0117', '123abc', 'hocsinh117@gmail.com', 'Võ Ngọc Tâm', '0903456799', '12 Nguyễn Đình Chiểu, Quận 3, TP HCM', 'Nam', '2006-09-19', 3),
(150, 'HS0118', '123abc', 'hocsinh118@gmail.com', 'Nguyễn Thị Hằng', '0903456700', '45 Lê Văn Sỹ, Tân Bình, TP HCM', 'Nữ', '2006-11-25', 3),
(151, 'HS0119', '123abc', 'hocsinh119@gmail.com', 'Trần Quốc Toàn', '0903456701', '78 Hồng Bàng, Quận 6, TP HCM', 'Nam', '2006-07-11', 3),
(152, 'HS0120', '123abc', 'hocsinh120@gmail.com', 'Đặng Văn Hoàng', '0903456702', '90 Lê Duẩn, Quận 1, TP HCM', 'Nam', '2006-05-05', 3),
(153, 'HS0121', '123abc', 'hocsinh121@gmail.com', 'Phạm Thị Bích', '0903456703', '12 Phan Đình Phùng, Quận 1, TP HCM', 'Nữ', '2006-08-17', 3),
(154, 'HS0122', '123abc', 'hocsinh122@gmail.com', 'Lê Hoàng Vũ', '0903456704', '67 Lê Hồng Phong, Quận 10, TP HCM', 'Nam', '2006-10-21', 3),
(155, 'HS0123', '123abc', 'hocsinh123@gmail.com', 'Hoàng Kim Phúc', '0903456705', '33 Trần Quang Diệu, Quận 3, TP HCM', 'Nam', '2006-04-30', 3),
(156, 'HS0124', '123abc', 'hocsinh124@gmail.com', 'Phan Minh Dũng', '0903456706', '90 Nguyễn Thiện Thuật, Quận 11, TP HCM', 'Nam', '2006-03-11', 3),
(157, 'HS0125', '123abc', 'hocsinh125@gmail.com', 'Đỗ Bảo Ngọc', '0903456707', '56 Tô Hiến Thành, Quận 10, TP HCM', 'Nữ', '2006-06-22', 3),
(158, 'HS0126', '123abc', 'hocsinh126@gmail.com', 'Nguyễn Phúc Bình', '0903456708', '32 Bạch Đằng, Bình Thạnh, TP HCM', 'Nam', '2006-12-01', 3),
(159, 'HS0127', '123abc', 'hocsinh127@gmail.com', 'Võ Thanh Sơn', '0903456709', '87 Trường Sa, Quận 3, TP HCM', 'Nam', '2006-07-15', 3),
(160, 'HS0128', '123abc', 'hocsinh128@gmail.com', 'Trần Thị Lý', '0903456710', '120 Ký Con, Quận 1, TP HCM', 'Nữ', '2006-08-30', 3),
(161, 'HS0129', '123abc', 'hocsinh129@gmail.com', 'Bùi Văn Phúc', '0903456711', '66 Nguyễn Tri Phương, Quận 5, TP HCM', 'Nam', '2006-05-20', 3),
(162, 'HS0130', '123abc', 'hocsinh130@gmail.com', 'Phan Nhật Nam', '0903456712', '45 Cao Thắng, Quận 3, TP HCM', 'Nam', '2006-09-10', 3),
(163, 'HS0131', '123abc', 'hocsinh131@gmail.com', 'Hoàng Thùy Linh', '0903456713', '78 Võ Văn Kiệt, Quận 1, TP HCM', 'Nữ', '2006-11-28', 3),
(164, 'HS0132', '123abc', 'hocsinh132@gmail.com', 'Lý Minh Anh', '0903456714', '99 Tôn Đức Thắng, Quận 7, TP HCM', 'Nam', '2006-03-08', 3),
(165, 'HS0133', '123abc', 'hocsinh133@gmail.com', 'Nguyễn Văn Tài', '0903456715', '44 Nguyễn Huệ, Quận 1, TP HCM', 'Nam', '2006-07-19', 3),
(166, 'HS0134', '123abc', 'hocsinh134@gmail.com', 'Đặng Thu Phương', '0903456716', '90 Hai Bà Trưng, Quận 3, TP HCM', 'Nữ', '2006-10-01', 3),
(167, 'HS0135', '123abc', 'hocsinh135@gmail.com', 'Phan Gia Huy', '0903456717', '33 Lê Văn Việt, Thủ Đức, TP HCM', 'Nam', '2006-04-12', 3),
(168, 'HS0136', '123abc', 'hocsinh136@gmail.com', 'Nguyễn Khánh Huy', '0903456789', '789 Nguyễn Trãi, Quận 1,TP HCM', 'Nam', '2006-03-15', 3),
(169, 'HS0137', '123abc', 'hocsinh137@gmail.com', 'Lê Minh Phúc', '0903456790', '123 Lê Lợi, Quận 3, TP HCM', 'Nam', '2005-10-20', 3),
(170, 'HS0138', '123abc', 'hocsinh138@gmail.com', 'Trần Thị Ngọc', '0903456791', '456 Cách Mạng, Quận 5, TP HCM', 'Nữ', '2007-06-12', 3),
(171, 'HS0139', '123abc', 'hocsinh139@gmail.com', 'Nguyễn Thị Mai', '0903456792', '789 Đinh Tiên Hoàng, Quận 7, TP HCM', 'Nữ', '2006-02-25', 3),
(172, 'HS0140', '123abc', 'hocsinh140@gmail.com', 'Vũ Văn Khánh', '0903456793', '12 Pasteur, Quận 1, TP HCM', 'Nam', '2005-09-30', 3),
(173, 'HS0141', '123abc', 'hocsinh141@gmail.com', 'Đặng Quang Long', '0903456794', '101 Võ Văn Tần, Quận 3, TP HCM', 'Nam', '2006-12-10', 3),
(174, 'HS0142', '123abc', 'hocsinh142@gmail.com', 'Hoàng Minh Hiếu', '0903456795', '88 Bùi Viện, Quận 1, TP HCM', 'Nam', '2005-05-18', 3),
(175, 'HS0143', '123abc', 'hocsinh143@gmail.com', 'Lê Thị Ngân', '0903456796', '150 Lý Tự Trọng, Quận 1, TP HCM', 'Nữ', '2007-08-24', 3),
(176, 'HS0144', '123abc', 'hocsinh144@gmail.com', 'Nguyễn Văn An', '0903456797', '678 Nguyễn Văn Linh, Quận 7, TP HCM', 'Nam', '2005-07-15', 3),
(177, 'HS0145', '123abc', 'hocsinh145@gmail.com', 'Phạm Quang Hải', '0903456798', '345 Điện Biên Phủ, Quận Bình Thạnh, TP HCM', 'Nam', '2006-11-22', 3),
(178, 'HS0146', '123abc', 'hocsinh146@gmail.com', 'Bùi Thanh Tâm', '0903456799', '12 Huỳnh Tấn Phát, Quận 7, TP HCM', 'Nữ', '2007-03-04', 3),
(179, 'HS0147', '123abc', 'hocsinh147@gmail.com', 'Nguyễn Thị Thu', '0903456800', '34 Phan Văn Trị, Gò Vấp, TP HCM', 'Nữ', '2005-10-10', 3),
(180, 'HS0148', '123abc', 'hocsinh148@gmail.com', 'Trần Quốc Đạt', '0903456801', '45 Trần Hưng Đạo, Quận 5, TP HCM', 'Nam', '2006-01-19', 3),
(181, 'HS0149', '123abc', 'hocsinh149@gmail.com', 'Lý Nhật Huy', '0903456802', '11 Lạc Long Quân, Tân Bình, TP HCM', 'Nam', '2006-09-05', 3),
(182, 'HS0150', '123abc', 'hocsinh150@gmail.com', 'Hoàng Ngọc Bích', '0903456803', '99 Âu Cơ, Quận 11, TP HCM', 'Nữ', '2007-04-08', 3),
(183, 'HS0151', '123abc', 'hocsinh151@gmail.com', 'Đoàn Thị Thanh', '0903456804', '28 Nguyễn Tri Phương, Quận 10, TP HCM', 'Nữ', '2006-06-27', 3),
(184, 'HS0152', '123abc', 'hocsinh152@gmail.com', 'Nguyễn Minh Thắng', '0903456805', '67 Tôn Đức Thắng, Quận 1, TP HCM', 'Nam', '2005-12-15', 3),
(185, 'HS0153', '123abc', 'hocsinh153@gmail.com', 'Phạm Văn Minh', '0903456806', '34 Hai Bà Trưng, Quận 1, TP HCM', 'Nam', '2007-05-20', 3),
(186, 'HS0154', '123abc', 'hocsinh154@gmail.com', 'Nguyễn Thị Hoa', '0903456807', '25 Trường Chinh, Tân Bình, TP HCM', 'Nữ', '2005-09-03', 3),
(187, 'HS0155', '123abc', 'hocsinh155@gmail.com', 'Lê Văn Quý', '0903456808', '9 Nguyễn Văn Cừ, Quận 5, TP HCM', 'Nam', '2006-10-14', 3),
(188, 'HS0156', '123abc', 'hocsinh156@gmail.com', 'Trần Thanh Tuyền', '0903456809', '112 Hoàng Văn Thụ, Quận Tân Bình, TP HCM', 'Nữ', '2007-07-12', 3),
(189, 'HS0157', '123abc', 'hocsinh157@gmail.com', 'Hoàng Văn Hùng', '0903456810', '19 Tân Sơn Nhì, Quận Tân Phú, TP HCM', 'Nam', '2006-03-08', 3),
(190, 'HS0158', '123abc', 'hocsinh158@gmail.com', 'Phạm Văn Trường', '0903456811', '15 Nguyễn Thượng Hiền, Quận 3, TP HCM', 'Nam', '2007-11-01', 3),
(191, 'HS0159', '123abc', 'hocsinh159@gmail.com', 'Nguyễn Văn Dũng', '0903456812', '22 Cao Thắng, Quận 10, TP HCM', 'Nam', '2006-04-17', 3),
(192, 'HS0160', '123abc', 'hocsinh160@gmail.com', 'Lê Quang Đức', '0903456813', '45 Lý Thường Kiệt, Quận Tân Bình, TP HCM', 'Nam', '2005-12-20', 3),
(193, 'HS0161', '123abc', 'hocsinh161@gmail.com', 'Đỗ Văn Nghĩa', '0903456814', '60 Phan Đăng Lưu, Phú Nhuận, TP HCM', 'Nam', '2007-02-28', 3),
(194, 'HS0162', '123abc', 'hocsinh162@gmail.com', 'Nguyễn Hoàng Anh', '0903456815', '17 Trần Quốc Toản, Quận 3, TP HCM', 'Nữ', '2006-08-19', 3),
(195, 'HS0163', '123abc', 'hocsinh163@gmail.com', 'Võ Thị Minh Hằng', '0903456816', '36 Trần Bình Trọng, Quận 5, TP HCM', 'Nữ', '2005-10-21', 3),
(196, 'HS0164', '123abc', 'hocsinh164@gmail.com', 'Lý Thị Thanh Bình', '0903456817', '11 Đường Hoa Sứ, Phú Nhuận, TP HCM', 'Nữ', '2007-01-03', 3),
(197, 'HS0165', '123abc', 'hocsinh165@gmail.com', 'Nguyễn Thành Trung', '0903456818', '47 Đinh Tiên Hoàng, Quận Bình Thạnh, TP HCM', 'Nam', '2006-09-25', 3),
(198, 'HS0166', '123abc', 'hocsinh166@gmail.com', 'Nguyễn Khánh Huy', '0903456789', '789 Nguyễn Trãi, Quận 1, TP HCM', 'Nam', '2006-03-15', 3),
(199, 'HS0167', '123abc', 'hocsinh167@gmail.com', 'Lê Thị Hồng Nhung', '0904456789', '123 Lê Lợi, Quận 1, TP HCM', 'Nữ', '2007-05-20', 3),
(200, 'HS0168', '123abc', 'hocsinh168@gmail.com', 'Trần Hoàng Nam', '0905456789', '456 Điện Biên Phủ, Quận 3, TP HCM', 'Nam', '2006-09-12', 3),
(201, 'HS0169', '123abc', 'hocsinh169@gmail.com', 'Phạm Minh Anh', '0906456789', '78 Võ Thị Sáu, Quận 3, TP HCM', 'Nữ', '2007-02-28', 3),
(202, 'HS0170', '123abc', 'hocsinh170@gmail.com', 'Đặng Văn An', '0907456789', '321 Hai Bà Trưng, Quận 1, TP HCM', 'Nam', '2006-07-30', 3),
(203, 'HS0171', '123abc', 'hocsinh171@gmail.com', 'Ngô Thanh Hà', '0908456789', '50 Nguyễn Đình Chiểu, Quận 3, TP HCM', 'Nữ', '2007-11-22', 3),
(204, 'HS0172', '123abc', 'hocsinh172@gmail.com', 'Nguyễn Văn Hùng', '0909456789', '99 Trần Hưng Đạo, Quận 5, TP HCM', 'Nam', '2006-12-10', 3),
(205, 'HS0173', '123abc', 'hocsinh173@gmail.com', 'Phạm Thị Ngọc Lan', '0910456789', '85 Nguyễn Văn Cừ, Quận 5, TP HCM', 'Nữ', '2007-06-15', 3),
(206, 'HS0174', '123abc', 'hocsinh174@gmail.com', 'Đỗ Hữu Tín', '0911456789', '45 Nguyễn Văn Trỗi, Quận 3, TP HCM', 'Nam', '2006-10-05', 3),
(207, 'HS0175', '123abc', 'hocsinh175@gmail.com', 'Lý Thu Hà', '0912456789', '12 Tôn Đức Thắng, Quận 1, TP HCM', 'Nữ', '2007-03-18', 3),
(208, 'HS0176', '123abc', 'hocsinh176@gmail.com', 'Trần Văn Khoa', '0913456789', '70 Hoàng Diệu, Quận 4, TP HCM', 'Nam', '2006-08-25', 3),
(209, 'HS0177', '123abc', 'hocsinh177@gmail.com', 'Nguyễn Thị Cẩm Tú', '0914456789', '34 Phạm Ngũ Lão, Quận 1, TP HCM', 'Nữ', '2007-10-12', 3),
(210, 'HS0178', '123abc', 'hocsinh178@gmail.com', 'Hoàng Văn Thịnh', '0915456789', '62 Bùi Thị Xuân, Quận 1, TP HCM', 'Nam', '2006-04-22', 3),
(211, 'HS0179', '123abc', 'hocsinh179@gmail.com', 'Nguyễn Phương Uyên', '0916456789', '24 Nguyễn Huệ, Quận 1, TP HCM', 'Nữ', '2007-09-30', 3),
(212, 'HS0180', '123abc', 'hocsinh180@gmail.com', 'Phan Thanh Phong', '0917456789', '89 Lý Tự Trọng, Quận 1, TP HCM', 'Nam', '2006-01-15', 3),
(213, 'HS0181', '123abc', 'hocsinh181@gmail.com', 'Lê Thị Thuỷ', '0918456789', '45 Cách Mạng Tháng 8, Quận 3, TP HCM', 'Nữ', '2007-07-20', 3),
(214, 'HS0182', '123abc', 'hocsinh182@gmail.com', 'Đỗ Văn Hùng', '0919456789', '50 Phan Xích Long, Quận Phú Nhuận, TP HCM', 'Nam', '2006-11-10', 3),
(215, 'HS0183', '123abc', 'hocsinh183@gmail.com', 'Trần Ngọc Minh', '0920456789', '75 Lê Văn Sỹ, Quận Phú Nhuận, TP HCM', 'Nữ', '2007-01-25', 3),
(216, 'HS0184', '123abc', 'hocsinh184@gmail.com', 'Nguyễn Quang Hải', '0921456789', '63 Trường Chinh, Quận Tân Bình, TP HCM', 'Nam', '2006-03-19', 3),
(217, 'HS0185', '123abc', 'hocsinh185@gmail.com', 'Phạm Thị Hằng', '0922456789', '20 Lý Thường Kiệt, Quận Tân Bình, TP HCM', 'Nữ', '2007-05-22', 3),
(218, 'HS0186', '123abc', 'hocsinh186@gmail.com', 'Đặng Văn Hoàng', '0923456789', '11 Lê Hồng Phong, Quận 10, TP HCM', 'Nam', '2006-06-15', 3),
(219, 'HS0187', '123abc', 'hocsinh187@gmail.com', 'Nguyễn Thị Kim Oanh', '0924456789', '70 Hoàng Văn Thụ, Quận Phú Nhuận, TP HCM', 'Nữ', '2007-08-28', 3),
(220, 'HS0188', '123abc', 'hocsinh188@gmail.com', 'Trần Văn Phúc', '0925456789', '123 Tô Hiến Thành, Quận 10, TP HCM', 'Nam', '2006-10-12', 3),
(221, 'HS0189', '123abc', 'hocsinh189@gmail.com', 'Nguyễn Thị Thuý', '0926456789', '321 Nguyễn Văn Linh, Quận 7, TP HCM', 'Nữ', '2007-12-10', 3),
(222, 'HS0190', '123abc', 'hocsinh190@gmail.com', 'Phan Văn Hùng', '0927456789', '78 Cao Thắng, Quận 3, TP HCM', 'Nam', '2006-02-15', 3),
(223, 'HS0191', '123abc', 'hocsinh191@gmail.com', 'Nguyễn Thị Ngọc', '0928456789', '45 Nguyễn Đình Chiểu, Quận 3, TP HCM', 'Nữ', '2007-04-28', 3),
(224, 'HS0192', '123abc', 'hocsinh192@gmail.com', 'Trần Văn Bình', '0929456789', '99 Hùng Vương, Quận 5, TP HCM', 'Nam', '2006-09-09', 3),
(225, 'HS0193', '123abc', 'hocsinh193@gmail.com', 'Nguyễn Thị Thanh', '0930456789', '15 Nguyễn Trãi, Quận 1, TP HCM', 'Nữ', '2007-11-15', 3),
(226, 'HS0194', '123abc', 'hocsinh194@gmail.com', 'Phạm Văn Dũng', '0931456789', '85 Cách Mạng Tháng 8, Quận 3, TP HCM', 'Nam', '2006-08-12', 3),
(227, 'HS0195', '123abc', 'hocsinh195@gmail.com', 'Lê Thị Mai', '0932456789', '50 Lý Tự Trọng, Quận 1, TP HCM', 'Nữ', '2007-03-30', 3),
(228, 'HS0196', '123abc', 'hocsinh196@gmail.com', 'Nguyễn Khánh Huy', '0903456789', '789 Nguyễn Trãi, Quận 1, TP HCM', 'Nam', '2006-03-15', 3),
(229, 'HS0197', '123abc', 'hocsinh197@gmail.com', 'Trần Bảo Ngọc', '0912345678', '45 Lê Lợi, Quận 1, TP HCM', 'Nữ', '2006-07-20', 3),
(230, 'HS0198', '123abc', 'hocsinh198@gmail.com', 'Lê Minh Quân', '0901234567', '12 Bạch Đằng, Quận Bình Thạnh, TP HCM', 'Nam', '2006-11-01', 3),
(231, 'HS0199', '123abc', 'hocsinh199@gmail.com', 'Phạm Hoài An', '0905671234', '56 Nguyễn Huệ, Quận 3, TP HCM', 'Nữ', '2006-05-18', 3),
(232, 'HS0200', '123abc', 'hocsinh200@gmail.com', 'Nguyễn Văn Tùng', '0918765432', '89 Lý Thường Kiệt, Quận 10, TP HCM', 'Nam', '2006-09-05', 3),
(233, 'HS0201', '123abc', 'hocsinh201@gmail.com', 'Hoàng Thu Phương', '0923456789', '102 Trần Hưng Đạo, Quận 5, TP HCM', 'Nữ', '2006-01-30', 3),
(234, 'HS0202', '123abc', 'hocsinh202@gmail.com', 'Phạm Đức Anh', '0932123456', '78 Nguyễn Văn Cừ, Quận 7, TP HCM', 'Nam', '2006-08-12', 3),
(235, 'HS0203', '123abc', 'hocsinh203@gmail.com', 'Lý Thu Hà', '0909345678', '99 Đinh Tiên Hoàng, Quận 9, TP HCM', 'Nữ', '2006-04-25', 3),
(236, 'HS0204', '123abc', 'hocsinh204@gmail.com', 'Ngô Huy Hoàng', '0908765123', '32 Trường Sa, Quận Phú Nhuận, TP HCM', 'Nam', '2006-12-10', 3),
(237, 'HS0205', '123abc', 'hocsinh205@gmail.com', 'Võ Thị Thanh', '0932456789', '56 Pasteur, Quận 3, TP HCM', 'Nữ', '2006-06-22', 3),
(238, 'HS0206', '123abc', 'hocsinh206@gmail.com', 'Phan Trọng Nghĩa', '0943219876', '85 Bùi Thị Xuân, Quận Tân Bình, TP HCM', 'Nam', '2006-02-17', 3),
(239, 'HS0207', '123abc', 'hocsinh207@gmail.com', 'Đặng Thị Lan', '0903456712', '34 Hùng Vương, Quận 6, TP HCM', 'Nữ', '2006-10-05', 3),
(240, 'HS0208', '123abc', 'hocsinh208@gmail.com', 'Trần Thanh Hùng', '0906543210', '23 Hàm Nghi, Quận 1, TP HCM', 'Nam', '2006-07-15', 3),
(241, 'HS0209', '123abc', 'hocsinh209@gmail.com', 'Lê Hải Yến', '0915671234', '67 Nguyễn Văn Linh, Quận 7, TP HCM', 'Nữ', '2006-03-19', 3),
(242, 'HS0210', '123abc', 'hocsinh210@gmail.com', 'Nguyễn Trường Giang', '0931234567', '45 Võ Văn Kiệt, Quận 8, TP HCM', 'Nam', '2006-11-30', 3),
(243, 'HS0211', '123abc', 'hocsinh211@gmail.com', 'Phạm Hồng Quân', '0909988776', '76 An Dương Vương, Quận Bình Chánh, TP HCM', 'Nam', '2006-01-22', 3),
(244, 'HS0212', '123abc', 'hocsinh212@gmail.com', 'Hoàng Bảo An', '0912123456', '19 Trần Quốc Toản, Quận 4, TP HCM', 'Nữ', '2006-09-15', 3),
(245, 'HS0213', '123abc', 'hocsinh213@gmail.com', 'Nguyễn Thanh Bình', '0921345678', '68 Nguyễn Văn Trỗi, Quận Gò Vấp, TP HCM', 'Nam', '2006-06-07', 3),
(246, 'HS0214', '123abc', 'hocsinh214@gmail.com', 'Lê Hải Đăng', '0904321987', '27 Nam Kỳ Khởi Nghĩa, Quận 1, TP HCM', 'Nam', '2006-10-12', 3),
(247, 'HS0215', '123abc', 'hocsinh215@gmail.com', 'Trần Minh Anh', '0919876543', '51 Hoàng Hoa Thám, Quận Tân Bình, TP HCM', 'Nữ', '2006-05-03', 3),
(248, 'HS0216', '123abc', 'hocsinh216@gmail.com', 'Vũ Quốc Bảo', '0903245678', '67 Nguyễn Hữu Thọ, Quận 7, TP HCM', 'Nam', '2006-04-01', 3),
(249, 'HS0217', '123abc', 'hocsinh217@gmail.com', 'Đặng Hồng Ngọc', '0932345678', '14 Tô Hiến Thành, Quận 10, TP HCM', 'Nữ', '2006-12-25', 3),
(250, 'HS0218', '123abc', 'hocsinh218@gmail.com', 'Phan Hữu Đức', '0945671234', '77 Điện Biên Phủ, Quận 1, TP HCM', 'Nam', '2006-08-05', 3),
(251, 'HS0219', '123abc', 'hocsinh219@gmail.com', 'Trịnh Ngọc Hoa', '0923456789', '38 Cách Mạng Tháng Tám, Quận 3, TP HCM', 'Nữ', '2006-11-18', 3),
(252, 'HS0220', '123abc', 'hocsinh220@gmail.com', 'Lý Văn Hải', '0902123456', '59 Phan Đăng Lưu, Quận Bình Thạnh, TP HCM', 'Nam', '2006-02-14', 3),
(253, 'HS0221', '123abc', 'hocsinh221@gmail.com', 'Ngô Thanh Tùng', '0914321234', '98 Trần Đình Xu, Quận 3, TP HCM', 'Nam', '2006-07-09', 3),
(254, 'HS0222', '123abc', 'hocsinh222@gmail.com', 'Đỗ Ngọc Trâm', '0902123345', '46 Lạc Long Quân, Quận Tân Bình, TP HCM', 'Nữ', '2006-09-28', 3),
(255, 'HS0223', '123abc', 'hocsinh223@gmail.com', 'Nguyễn Xuân Khang', '0923456781', '81 Lê Hồng Phong, Quận 5, TP HCM', 'Nam', '2006-03-04', 3),
(256, 'HS0224', '123abc', 'hocsinh224@gmail.com', 'Trần Thị Hương', '0919988776', '12 Nguyễn Tri Phương, Quận 10, TP HCM', 'Nữ', '2006-06-25', 3),
(257, 'HS0225', '123abc', 'hocsinh225@gmail.com', 'Trần Thị Khuê', '0919988776', '12 Nguyễn Tri Phương, Quận 10, TP HCM', 'Nữ', '2006-06-25', 3);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `thungan`
--

CREATE TABLE `thungan` (
  `MaTN` varchar(10) NOT NULL,
  `MaTK` int(11) DEFAULT NULL,
  `TinhTrang` enum('Đang làm việc','Đã nghỉ việc') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `thungan`
--

INSERT INTO `thungan` (`MaTN`, `MaTK`, `TinhTrang`) VALUES
('TN0001', 63, 'Đang làm việc'),
('TN0002', 64, 'Đang làm việc'),
('TN0003', 65, 'Đang làm việc'),
('TN0004', 66, 'Đang làm việc'),
('TN0005', 67, 'Đang làm việc');

--
-- Bẫy `thungan`
--
DELIMITER $$
CREATE TRIGGER `trg_TN_BeforeInsert` BEFORE INSERT ON `thungan` FOR EACH ROW BEGIN
    SET NEW.MaTN = CONCAT('TN', LPAD((SELECT IFNULL(MAX(CAST(SUBSTRING(MaTN, 3) AS UNSIGNED)), 0) + 1 FROM THUNGAN), 4, '0'));
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `vaitro`
--

CREATE TABLE `vaitro` (
  `MaVT` int(11) NOT NULL,
  `TenVT` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `vaitro`
--

INSERT INTO `vaitro` (`MaVT`, `TenVT`) VALUES
(1, 'Ban giám hiệu'),
(2, 'Giáo viên'),
(3, 'Học sinh'),
(4, 'Thu ngân'),
(5, 'Giám thị');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `vipham`
--

CREATE TABLE `vipham` (
  `MaVP` int(11) NOT NULL,
  `MaHS` varchar(10) DEFAULT NULL,
  `MaGT` varchar(10) DEFAULT NULL,
  `MaLVP` int(11) DEFAULT NULL,
  `HocKy` int(11) DEFAULT NULL,
  `NamHoc` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `bangiamhieu`
--
ALTER TABLE `bangiamhieu`
  ADD PRIMARY KEY (`MaBGH`);

--
-- Chỉ mục cho bảng `cttpt`
--
ALTER TABLE `cttpt`
  ADD PRIMARY KEY (`MaCTPTT`);

--
-- Chỉ mục cho bảng `danhhieu`
--
ALTER TABLE `danhhieu`
  ADD PRIMARY KEY (`MaDH`);

--
-- Chỉ mục cho bảng `diem`
--
ALTER TABLE `diem`
  ADD PRIMARY KEY (`MaDiem`);

--
-- Chỉ mục cho bảng `giaovien`
--
ALTER TABLE `giaovien`
  ADD PRIMARY KEY (`MaGV`);

--
-- Chỉ mục cho bảng `hocsinh`
--
ALTER TABLE `hocsinh`
  ADD PRIMARY KEY (`MaHS`);

--
-- Chỉ mục cho bảng `loaivipham`
--
ALTER TABLE `loaivipham`
  ADD PRIMARY KEY (`MaLVP`);

--
-- Chỉ mục cho bảng `lop`
--
ALTER TABLE `lop`
  ADD PRIMARY KEY (`MaLop`);

--
-- Chỉ mục cho bảng `monhoc`
--
ALTER TABLE `monhoc`
  ADD PRIMARY KEY (`MaMH`);

--
-- Chỉ mục cho bảng `phieuthanhtoan`
--
ALTER TABLE `phieuthanhtoan`
  ADD PRIMARY KEY (`MaPTT`);

--
-- Chỉ mục cho bảng `taikhoan`
--
ALTER TABLE `taikhoan`
  ADD PRIMARY KEY (`MaTK`),
  ADD UNIQUE KEY `TenTK` (`TenTK`);

--
-- Chỉ mục cho bảng `thungan`
--
ALTER TABLE `thungan`
  ADD PRIMARY KEY (`MaTN`);

--
-- Chỉ mục cho bảng `vaitro`
--
ALTER TABLE `vaitro`
  ADD PRIMARY KEY (`MaVT`);

--
-- Chỉ mục cho bảng `vipham`
--
ALTER TABLE `vipham`
  ADD PRIMARY KEY (`MaVP`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `cttpt`
--
ALTER TABLE `cttpt`
  MODIFY `MaCTPTT` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `danhhieu`
--
ALTER TABLE `danhhieu`
  MODIFY `MaDH` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `diem`
--
ALTER TABLE `diem`
  MODIFY `MaDiem` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `loaivipham`
--
ALTER TABLE `loaivipham`
  MODIFY `MaLVP` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT cho bảng `lop`
--
ALTER TABLE `lop`
  MODIFY `MaLop` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT cho bảng `monhoc`
--
ALTER TABLE `monhoc`
  MODIFY `MaMH` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `phieuthanhtoan`
--
ALTER TABLE `phieuthanhtoan`
  MODIFY `MaPTT` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `taikhoan`
--
ALTER TABLE `taikhoan`
  MODIFY `MaTK` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=258;

--
-- AUTO_INCREMENT cho bảng `vaitro`
--
ALTER TABLE `vaitro`
  MODIFY `MaVT` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `vipham`
--
ALTER TABLE `vipham`
  MODIFY `MaVP` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
