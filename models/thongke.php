<?php
require_once 'models/db.php';

class ThongKe {
    private $db;

    public function __construct() {
        $this->db = new Database();
        $this->initTablesAndData();
    }

    // Tự động tạo bảng & dữ liệu mẫu cho đơn hàng nếu chưa có trong Database
    private function initTablesAndData() {
        try {
            // Thêm cột ngay_tao vào USER nếu chưa tồn tại
            $this->db->conn->exec("ALTER TABLE USER ADD COLUMN ngay_tao DATETIME DEFAULT CURRENT_TIMESTAMP");
        } catch (PDOException $e) {}

        try {
            // Bảng DONHANG
            $sqlDonHang = "CREATE TABLE IF NOT EXISTS DONHANG (
                don_hang_id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT NOT NULL,
                ho_ten VARCHAR(100) NOT NULL,
                sdt VARCHAR(20),
                email VARCHAR(100),
                dia_chi VARCHAR(255) NOT NULL,
                tong_tien DECIMAL(12, 2) NOT NULL,
                trang_thai VARCHAR(50) DEFAULT 'Đang xử lý',
                ngay_dat DATETIME DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES USER(user_id) ON DELETE CASCADE
            )";
            $this->db->conn->exec($sqlDonHang);

            // Bảng CHITIETDONHANG
            $sqlChiTiet = "CREATE TABLE IF NOT EXISTS CHITIETDONHANG (
                chi_tiet_don_id INT AUTO_INCREMENT PRIMARY KEY,
                don_hang_id INT NOT NULL,
                product_id INT NOT NULL,
                ten_san_pham VARCHAR(255) NOT NULL,
                don_gia DECIMAL(12, 2) NOT NULL,
                so_luong INT NOT NULL DEFAULT 1,
                thanh_tien DECIMAL(12, 2) NOT NULL,
                FOREIGN KEY (don_hang_id) REFERENCES DONHANG(don_hang_id) ON DELETE CASCADE,
                FOREIGN KEY (product_id) REFERENCES PRODUCTS(product_id) ON DELETE CASCADE
            )";
            $this->db->conn->exec($sqlChiTiet);

            // Kiểm tra và khởi tạo dữ liệu mẫu nếu DONHANG trống
            $countStmt = $this->db->conn->query("SELECT COUNT(*) FROM DONHANG");
            if ($countStmt && $countStmt->fetchColumn() == 0) {
                $this->db->conn->exec("INSERT INTO DONHANG (don_hang_id, user_id, ho_ten, sdt, email, dia_chi, tong_tien, trang_thai, ngay_dat) VALUES
                    (1, 2, 'Nguyễn Văn User', '0901234567', 'user@example.com', 'Hồ Chí Minh', 6700000.00, 'Đã giao', DATE_SUB(NOW(), INTERVAL 10 DAY)),
                    (2, 4, 'Nguyễn Văn A', '0912345678', 'nguyenvana@gmail.com', 'Hà Nội', 2500000.00, 'Đã giao', DATE_SUB(NOW(), INTERVAL 2 DAY)),
                    (3, 5, 'Trần Thị B', '0923456789', 'tranthib@gmail.com', 'Đà Nẵng', 350000.00, 'Đã giao', DATE_SUB(NOW(), INTERVAL 1 DAY)),
                    (4, 6, 'Lê Văn C', '0934567890', 'levanc@gmail.com', 'Hồ Chí Minh', 4200000.00, 'Đã giao', NOW()),
                    (5, 7, 'Phạm Thị D', '0945678901', 'phamthid@gmail.com', 'Cần Thơ', 350000.00, 'Đã hủy', DATE_SUB(NOW(), INTERVAL 5 DAY))");


                $this->db->conn->exec("INSERT INTO CHITIETDONHANG (chi_tiet_don_id, don_hang_id, product_id, ten_san_pham, don_gia, so_luong, thanh_tien) VALUES
                    (1, 1, 1, 'Vợt Pickleball Franklin Signature', 2500000.00, 1, 2500000.00),
                    (2, 1, 2, 'Vợt Selkirk Vanguard', 4200000.00, 1, 4200000.00),
                    (3, 2, 1, 'Vợt Pickleball Franklin Signature', 2500000.00, 1, 2500000.00),
                    (4, 3, 3, 'Bộ 4 quả bóng Pickleball Outdoor', 350000.00, 1, 350000.00),
                    (5, 4, 2, 'Vợt Selkirk Vanguard', 4200000.00, 1, 4200000.00),
                    (6, 5, 3, 'Bộ 4 quả bóng Pickleball Outdoor', 350000.00, 1, 350000.00)");
            }
        } catch (PDOException $e) {}
    }

    // 1. THỐNG KÊ DOANH THU
    public function thongKeDoanhThu() {
        // Tổng doanh thu (Các đơn thành công / đã giao hoặc chưa hủy)
        $sqlTong = "SELECT IFNULL(SUM(tong_tien), 0) FROM DONHANG WHERE trang_thai = 'Đã giao'";
        $tongDoanhThu = $this->db->conn->query($sqlTong)->fetchColumn();

        // Doanh thu theo Ngày
        $sqlNgay = "SELECT IFNULL(SUM(tong_tien), 0) FROM DONHANG WHERE trang_thai != 'Đã hủy' AND DATE(ngay_dat) = CURDATE()";
        $doanhThuNgay = $this->db->conn->query($sqlNgay)->fetchColumn();

        // Doanh thu theo Tuần
        $sqlTuan = "SELECT IFNULL(SUM(tong_tien), 0) FROM DONHANG WHERE trang_thai != 'Đã hủy' AND YEARWEEK(ngay_dat, 1) = YEARWEEK(CURDATE(), 1)";
        $doanhThuTuan = $this->db->conn->query($sqlTuan)->fetchColumn();

        // Doanh thu theo Tháng
        $sqlThang = "SELECT IFNULL(SUM(tong_tien), 0) FROM DONHANG WHERE trang_thai != 'Đã hủy' AND MONTH(ngay_dat) = MONTH(CURDATE()) AND YEAR(ngay_dat) = YEAR(CURDATE())";
        $doanhThuThang = $this->db->conn->query($sqlThang)->fetchColumn();

        // Doanh thu theo Năm
        $sqlNam = "SELECT IFNULL(SUM(tong_tien), 0) FROM DONHANG WHERE trang_thai != 'Đã hủy' AND YEAR(ngay_dat) = YEAR(CURDATE())";
        $doanhThuNam = $this->db->conn->query($sqlNam)->fetchColumn();

        // Doanh thu theo từng sản phẩm
        $sqlTheoSP = "SELECT 
                        p.product_id, 
                        p.ten, 
                        p.gia, 
                        IFNULL(SUM(ct.so_luong), 0) AS tong_so_luong, 
                        IFNULL(SUM(ct.thanh_tien), 0) AS tong_doanh_thu 
                      FROM PRODUCTS p 
                      LEFT JOIN CHITIETDONHANG ct ON p.product_id = ct.product_id 
                      LEFT JOIN DONHANG d ON ct.don_hang_id = d.don_hang_id AND d.trang_thai != 'Đã hủy' 
                      GROUP BY p.product_id, p.ten, p.gia 
                      ORDER BY tong_doanh_thu DESC";
        $doanhThuTheoSP = $this->db->conn->query($sqlTheoSP)->fetchAll(PDO::FETCH_ASSOC);

        return [
            'tong_doanh_thu' => $tongDoanhThu,
            'ngay' => $doanhThuNgay,
            'tuan' => $doanhThuTuan,
            'thang' => $doanhThuThang,
            'nam' => $doanhThuNam,
            'theo_san_pham' => $doanhThuTheoSP
        ];
    }

    // 2. THỐNG KÊ SẢN PHẨM
    public function thongKeSanPham() {
        // Tổng số sản phẩm
        $tongSanPham = $this->db->conn->query("SELECT COUNT(*) FROM PRODUCTS")->fetchColumn();

        // Sản phẩm còn hàng (trang_thai = 1)
        $conHang = $this->db->conn->query("SELECT COUNT(*) FROM PRODUCTS WHERE trang_thai = 1")->fetchColumn();

        // Sản phẩm hết hàng (trang_thai = 0)
        $hetHang = $this->db->conn->query("SELECT COUNT(*) FROM PRODUCTS WHERE trang_thai = 0")->fetchColumn();

        // Sản phẩm bán chạy nhất
        $sqlBanChay = "SELECT 
                        p.product_id, 
                        p.ten, 
                        p.gia, 
                        p.anh, 
                        c.name AS ten_danh_muc,
                        IFNULL(SUM(ct.so_luong), 0) AS so_luong_ban, 
                        IFNULL(SUM(ct.thanh_tien), 0) AS tong_doanh_thu 
                       FROM PRODUCTS p 
                       LEFT JOIN CATEGORIES c ON p.category_id = c.category_id
                       LEFT JOIN CHITIETDONHANG ct ON p.product_id = ct.product_id 
                       LEFT JOIN DONHANG d ON ct.don_hang_id = d.don_hang_id AND d.trang_thai != 'Đã hủy' 
                       GROUP BY p.product_id, p.ten, p.gia, p.anh, c.name 
                       ORDER BY so_luong_ban DESC, tong_doanh_thu DESC";
        $sanPhamBanChay = $this->db->conn->query($sqlBanChay)->fetchAll(PDO::FETCH_ASSOC);

        return [
            'tong_san_pham' => $tongSanPham,
            'con_hang' => $conHang,
            'het_hang' => $hetHang,
            'ban_chay' => $sanPhamBanChay
        ];
    }

    // 3. THỐNG KÊ ĐƠN HÀNG
    public function thongKeDonHang() {
        $tongDonHang = $this->db->conn->query("SELECT COUNT(*) FROM DONHANG")->fetchColumn();
        $dangXuLy = $this->db->conn->query("SELECT COUNT(*) FROM DONHANG WHERE trang_thai = 'Đang xử lý'")->fetchColumn();
        $daGiao = $this->db->conn->query("SELECT COUNT(*) FROM DONHANG WHERE trang_thai = 'Đã giao'")->fetchColumn();
        $daHuy = $this->db->conn->query("SELECT COUNT(*) FROM DONHANG WHERE trang_thai = 'Đã hủy'")->fetchColumn();

        return [
            'tong_don_hang' => $tongDonHang,
            'dang_xu_ly' => $dangXuLy,
            'da_giao' => $daGiao,
            'da_huy' => $daHuy
        ];
    }

    // 4. THỐNG KÊ KHÁCH HÀNG
    public function thongKeKhachHang() {
        // Tổng số khách hàng (Role User = 2)
        $tongKhachHang = $this->db->conn->query("SELECT COUNT(*) FROM USER WHERE vai_tro_id = 2")->fetchColumn();

        // Khách hàng mới trong tháng
        $sqlMoi = "SELECT COUNT(*) FROM USER WHERE vai_tro_id = 2 AND (ngay_tao IS NULL OR (MONTH(ngay_tao) = MONTH(CURDATE()) AND YEAR(ngay_tao) = YEAR(CURDATE())))";
        $khachHangMoi = $this->db->conn->query($sqlMoi)->fetchColumn();

        // Khách hàng mua nhiều nhất
        $sqlMuaNhieu = "SELECT 
                            u.user_id, 
                            u.username, 
                            u.email, 
                            u.address, 
                            COUNT(d.don_hang_id) AS so_don_hang, 
                            IFNULL(SUM(d.tong_tien), 0) AS tong_chi_tieu 
                        FROM USER u 
                        LEFT JOIN DONHANG d ON u.user_id = d.user_id AND d.trang_thai != 'Đã hủy' 
                        WHERE u.vai_tro_id = 2 
                        GROUP BY u.user_id, u.username, u.email, u.address 
                        ORDER BY tong_chi_tieu DESC, so_don_hang DESC";
        $khachHangMuaNhieu = $this->db->conn->query($sqlMuaNhieu)->fetchAll(PDO::FETCH_ASSOC);

        return [
            'tong_khach_hang' => $tongKhachHang,
            'khach_hang_moi' => $khachHangMoi,
            'mua_nhieu_nhat' => $khachHangMuaNhieu
        ];
    }
}

