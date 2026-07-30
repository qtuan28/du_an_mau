<?php
require_once 'models/db.php';

class ThongKe {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // [TỰ CODE] Thống kê sản phẩm
    public function thongKeSanPham() {
        // SQL code...
    }

    // [TỰ CODE] Thống kê đơn hàng
    public function thongKeDonHang() {
        // SQL code...
    }

    // [TỰ CODE] Thống kê người dùng
    public function thongKeNguoiDung() {
        // SQL code...
    }
}
