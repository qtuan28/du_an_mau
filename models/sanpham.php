<?php
require_once 'models/db.php';

class SanPham {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // Lấy tất cả sản phẩm
    public function getAll() {
        $sql = "SELECT p.*, c.name as ten_danh_muc 
                FROM PRODUCTS p 
                LEFT JOIN CATEGORIES c ON p.category_id = c.category_id";
        $stmt = $this->db->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // [TỰ CODE] Lấy chi tiết 1 sản phẩm theo ID
    public function getById($id) {
        // SQL code...
         $sql = "SELECT * FROM PRODUCTS WHERE product_id = ?";

        $stmt = $this->db->conn->prepare($sql);
        $stmt->execute([$id]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // [TỰ CODE] Thêm sản phẩm mới
    public function add($data) {
        // SQL code...
    }

    // [TỰ CODE] Sửa sản phẩm
    public function update($id, $data) {
        // SQL code...
    }

    // [TỰ CODE] Xóa sản phẩm
    public function delete($id) {
        // SQL code...
    }

    // [TỰ CODE] Tìm kiếm sản phẩm theo từ khóa
    public function search($keyword) {
        // SQL code...
    }
}