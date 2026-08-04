-- Tạo cơ sở dữ liệu (Tự động xóa CSDL cũ nếu tồn tại để tránh lỗi trùng lặp dữ liệu)
DROP DATABASE IF EXISTS du_an_mau;
CREATE DATABASE du_an_mau;
USE du_an_mau;

-- 1. TẠO CÁC BẢNG ĐỘC LẬP (KHÔNG CÓ KHÓA NGOẠI)

-- Bảng VAITRO
CREATE TABLE IF NOT EXISTS VAITRO (
    vai_tro_id INT AUTO_INCREMENT PRIMARY KEY,
    ten_vai_tro VARCHAR(50) NOT NULL
);

-- Bảng CATEGORIES
CREATE TABLE IF NOT EXISTS CATEGORIES (
    category_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    ngay_tao DATETIME DEFAULT CURRENT_TIMESTAMP,
    trang_thai TINYINT(1) DEFAULT 1
);

-- 2. TẠO CÁC BẢNG BẬC 1 (PHỤ THUỘC VÀO BẢNG ĐỘC LẬP)

-- Bảng USER (Phụ thuộc VAITRO)
CREATE TABLE IF NOT EXISTS USER (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    vai_tro_id INT NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL,
    address VARCHAR(255),
    FOREIGN KEY (vai_tro_id) REFERENCES VAITRO(vai_tro_id)
);

-- Bảng PRODUCTS (Phụ thuộc CATEGORIES)
CREATE TABLE IF NOT EXISTS PRODUCTS (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    ten VARCHAR(255) NOT NULL,
    gia DECIMAL(12, 2) NOT NULL,
    giam_gia INT DEFAULT 0,
    trang_thai TINYINT(1) DEFAULT 1,
    anh VARCHAR(255),
    ngay_tao DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES CATEGORIES(category_id)
);

-- 3. TẠO CÁC BẢNG BẬC 2 (PHỤ THUỘC VÀO USER VÀ PRODUCTS)

-- Bảng SPECIFICATION (Phụ thuộc PRODUCTS)
CREATE TABLE IF NOT EXISTS SPECIFICATION (
    spec_id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL UNIQUE,
    kich_thuoc VARCHAR(50),
    chat_lieu VARCHAR(100),
    chung_nhan VARCHAR(100),
    loai_tay_cam VARCHAR(50),
    chieu_dai FLOAT,
    chieu_rong FLOAT,
    FOREIGN KEY (product_id) REFERENCES PRODUCTS(product_id) ON DELETE CASCADE
);

-- Bảng PRODUCT_DETAILS (Phụ thuộc PRODUCTS)
CREATE TABLE IF NOT EXISTS PRODUCT_DETAILS (
    product_detail_id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    ma_sp VARCHAR(50) NOT NULL UNIQUE,
    color VARCHAR(50),
    quantity INT DEFAULT 0,
    FOREIGN KEY (product_id) REFERENCES PRODUCTS(product_id) ON DELETE CASCADE
);

-- Bảng GIOHANG (Phụ thuộc USER)
CREATE TABLE IF NOT EXISTS GIOHANG (
    gio_hang_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL UNIQUE,
    ngay_tao DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES USER(user_id) ON DELETE CASCADE
);

-- 4. TẠO BẢNG BẬC 3 (PHỤ THUỘC NHIỀU NGUỒN)

-- Bảng CHITIETGIOHANG (Phụ thuộc GIOHANG và PRODUCT_DETAILS)
CREATE TABLE IF NOT EXISTS CHITIETGIOHANG (
    item_id INT AUTO_INCREMENT PRIMARY KEY,
    gio_hang_id INT NOT NULL,
    chi_tiet_id INT NOT NULL, 
    so_luong INT NOT NULL DEFAULT 1,
    FOREIGN KEY (gio_hang_id) REFERENCES GIOHANG(gio_hang_id) ON DELETE CASCADE,
    FOREIGN KEY (chi_tiet_id) REFERENCES PRODUCT_DETAILS(product_detail_id) ON DELETE CASCADE
);

-- 5. THÊM DỮ LIỆU MẪU VỀ VAI TRÒ VÀ TÀI KHOẢN KÍCH HOẠT PHÂN QUYỀN
INSERT IGNORE INTO VAITRO (vai_tro_id, ten_vai_tro) VALUES 
(1, 'Admin'),
(2, 'User');

-- Tài khoản mẫu: 
-- admin / 123456 (vai_tro_id = 1)
-- user / 123456 (vai_tro_id = 2)
INSERT IGNORE INTO USER (user_id, vai_tro_id, username, password, email, address) VALUES 
(1, 1, 'admin', '123456', 'admin@example.com', 'Hà Nội'),
(2, 2, 'user', '123456', 'user@example.com', 'Hồ Chí Minh');

-- Dữ liệu mẫu Danh mục & Sản phẩm
INSERT IGNORE INTO CATEGORIES (category_id, name) VALUES 
(1, 'Vợt Pickleball'),
(2, 'Bóng Pickleball');

INSERT IGNORE INTO PRODUCTS (product_id, category_id, ten, gia, anh) VALUES 
(1, 1, 'Vợt Pickleball Franklin Signature', 2500000.00, 'paddle_aero.png'),
(2, 1, 'Vợt Selkirk Vanguard', 4200000.00, 'paddle_voltaic.png'),
(3, 2, 'Bộ 4 quả bóng Pickleball Outdoor', 350000.00, 'balls_box.png');