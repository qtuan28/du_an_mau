<?php
require_once 'models/db.php';

class GioHang {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // [TỰ CODE] Thêm sản phẩm vào giỏ hàng
    public function add($userId, $productId, $quantity = 1) {
        // SQL code...
    }

    // [TỰ CODE] Lấy giỏ hàng theo User ID
    public function getByUserId($userId) {
        // SQL code...
    }

    // [TỰ CODE] Cập nhật số lượng sản phẩm trong giỏ
    public function updateQuantity($cartItemId, $quantity) {
        // SQL code...
    }

    // [TỰ CODE] Xóa sản phẩm khỏi giỏ hàng
    public function deleteItem($cartItemId) {
        // SQL code...
    }

    // [TỰ CODE] Xử lý thanh toán / Tạo đơn hàng
    public function thanhToan($userId) {
        // SQL code...
    }

    // [TỰ CODE] Lấy lịch sử đơn hàng của người dùng
    public function getLichSuDonHang($userId) {
        // SQL code...
    }
}
