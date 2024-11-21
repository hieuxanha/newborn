CREATE DATABASE newborn_shop;

USE newborn_shop;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    phone VARCHAR(15) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    address VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    `role` enum('user','nhanvien','admin') NOT NULL DEFAULT 'user', -- Cần giá trị mặc định cho role, ở đây mình đặt là 'user'
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE sanpham (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ten_san_pham VARCHAR(255) NOT NULL,
    gia DECIMAL(10, 2) NOT NULL,
    loai_san_pham VARCHAR(100) NOT NULL,
    mo_ta TEXT,
    so_luong INT NOT NULL,
    anh_san_pham VARCHAR(255), -- Dấu phẩy đã được thêm vào đây
    san_pham_noi_bat TINYINT(1) DEFAULT 0
);

CREATE TABLE gio_hang (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    san_pham_id INT NOT NULL,
    so_luong INT NOT NULL,
    ngay_them DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (san_pham_id) REFERENCES sanpham(id) ON DELETE CASCADE
);


CREATE TABLE `thanhtoan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `hoTen` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `soDienThoai` varchar(15) NOT NULL,
  `diaChi` varchar(255) NOT NULL,
  `ngayThanhToan` datetime NOT NULL,
  `tongTien` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Cấu trúc bảng cho bảng `chitiet_hoadon`
CREATE TABLE `chitiet_hoadon` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hoa_don_id` int(11) NOT NULL,
  `san_pham_id` int(11) NOT NULL,
  `soLuong` int(11) NOT NULL,
  `giaTien` decimal(10,2) NOT NULL,
  `thanhTien` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`hoa_don_id`) REFERENCES `thanhtoan`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`san_pham_id`) REFERENCES `sanpham`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci















