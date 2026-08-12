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
            // Thêm cột ma_don_hang vào DONHANG nếu chưa tồn tại
            $chkMaDon = $this->db->conn->query("SHOW COLUMNS FROM DONHANG LIKE 'ma_don_hang'");
            if ($chkMaDon && $chkMaDon->rowCount() == 0) {
                $this->db->conn->exec("ALTER TABLE DONHANG ADD COLUMN ma_don_hang VARCHAR(50) UNIQUE AFTER don_hang_id");
                $this->db->conn->exec("UPDATE DONHANG SET ma_don_hang = CONCAT('DH-OLD-', don_hang_id) WHERE ma_don_hang IS NULL");
            }
        } catch (PDOException $e) {}

        try {
            // Bảng DONHANG
            $sqlDonHang = "CREATE TABLE IF NOT EXISTS DONHANG (
                don_hang_id INT AUTO_INCREMENT PRIMARY KEY,
                ma_don_hang VARCHAR(50) UNIQUE,
                user_id INT NOT NULL,
                ho_ten VARCHAR(100) NOT NULL,
                sdt VARCHAR(20),
                email VARCHAR(100),
                dia_chi VARCHAR(255) NOT NULL,
                tong_tien DECIMAL(12, 2) NOT NULL,
                trang_thai VARCHAR(50) DEFAULT 'Đã giao',
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
                $this->db->conn->exec("INSERT INTO DONHANG (don_hang_id, ma_don_hang, user_id, ho_ten, sdt, email, dia_chi, tong_tien, trang_thai, ngay_dat) VALUES
                    (1, 'DH-260812-A1B2', 2, 'Nguyễn Văn User', '0901234567', 'user@example.com', 'Hồ Chí Minh', 6700000.00, 'Đã giao', DATE_SUB(NOW(), INTERVAL 10 DAY)),
                    (2, 'DH-260812-C3D4', 4, 'Nguyễn Văn A', '0912345678', 'nguyenvana@gmail.com', 'Hà Nội', 2500000.00, 'Đã giao', DATE_SUB(NOW(), INTERVAL 2 DAY)),
                    (3, 'DH-260812-E5F6', 5, 'Trần Thị B', '0923456789', 'tranthib@gmail.com', 'Đà Nẵng', 350000.00, 'Đã giao', DATE_SUB(NOW(), INTERVAL 1 DAY)),
                    (4, 'DH-260812-G7H8', 6, 'Lê Văn C', '0934567890', 'levanc@gmail.com', 'Hồ Chí Minh', 4200000.00, 'Đã giao', NOW()),
                    (5, 'DH-260812-I9J0', 7, 'Phạm Thị D', '0945678901', 'phamthid@gmail.com', 'Cần Thơ', 350000.00, 'Đã hủy', DATE_SUB(NOW(), INTERVAL 5 DAY))");

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

    // 2. THỐNG KÊ SẢN PHẨM
    public function thongKeSanPham() {
        $tongSanPham = $this->db->conn->query("SELECT COUNT(*) FROM PRODUCTS")->fetchColumn();
        $conHang = $this->db->conn->query("SELECT COUNT(*) FROM PRODUCTS WHERE trang_thai = 1")->fetchColumn();
        $hetHang = $this->db->conn->query("SELECT COUNT(*) FROM PRODUCTS WHERE trang_thai = 0")->fetchColumn();

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
        $tongKhachHang = $this->db->conn->query("SELECT COUNT(*) FROM USER WHERE vai_tro_id = 2")->fetchColumn();

        $sqlMoi = "SELECT COUNT(*) FROM USER WHERE vai_tro_id = 2 AND (ngay_tao IS NULL OR (MONTH(ngay_tao) = MONTH(CURDATE()) AND YEAR(ngay_tao) = YEAR(CURDATE())))";
        $khachHangMoi = $this->db->conn->query($sqlMoi)->fetchColumn();

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

    // 5. THỐNG KÊ TỒN KHO SẢN PHẨM
    public function thongKeTonKho() {
        $sql = "SELECT 
                    p.product_id,
                    p.ma_sp,
                    p.ten,
                    p.anh,
                    p.trang_thai AS trang_thai_sp,
                    p.so_luong AS tong_ton_kho,
                    (SELECT IFNULL(SUM(so_luong), 0) FROM CHITIETDONHANG ct JOIN DONHANG d ON ct.don_hang_id = d.don_hang_id WHERE ct.product_id = p.product_id AND d.trang_thai != 'Đã hủy') AS tong_da_ban
                FROM PRODUCTS p
                ORDER BY p.so_luong ASC";
        $dsSanPham = $this->db->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);

        $conHang = 0; $sapHet = 0; $hetHang = 0; $tongTonKho = 0;
        foreach ($dsSanPham as $sp) {
            $qty = (int)$sp['tong_ton_kho'];
            $tongTonKho += $qty;
            if ($qty > 0) {
                $conHang++;
                if ($qty <= 10) {
                    $sapHet++;
                }
            } else {
                $hetHang++;
            }
        }

        return [
            'ds_san_pham' => $dsSanPham,
            'tong_ton_kho' => $tongTonKho,
            'con_hang' => $conHang,
            'sap_het' => $sapHet,
            'het_hang' => $hetHang
        ];
    }

    // THỐNG KÊ LỊCH SỬ ĐƠN HÀNG (Mới)
    public function getLichSuDonHang() {
        $sql = "SELECT d.ma_don_hang, d.ho_ten, d.tong_tien, d.ngay_dat, d.trang_thai,
                       GROUP_CONCAT(CONCAT(c.so_luong, ' x ', c.ten_san_pham) SEPARATOR '<br>') as san_pham
                FROM DONHANG d
                LEFT JOIN CHITIETDONHANG c ON d.don_hang_id = c.don_hang_id
                GROUP BY d.don_hang_id
                ORDER BY d.ngay_dat DESC
                LIMIT 50";
        $stmt = $this->db->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
