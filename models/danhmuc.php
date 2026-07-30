<?php
require_once 'models/db.php';

class DanhMuc {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // [TỰ CODE] Lấy danh sách danh mục
    public function getAll() {
        // SQL code...
    }

    // [TỰ CODE] Thêm danh mục mới
    public function add($name) {
        // SQL code...
    }

    // [TỰ CODE] Lấy chi tiết danh mục theo ID
    public function getById($id) {
        // SQL code...
    }

    // [TỰ CODE] Cập nhật danh mục
    public function update($id, $name) {
        // SQL code...
    }

    // [TỰ CODE] Xóa danh mục
    public function delete($id) {
        // SQL code...
    }

    // [TỰ CODE] Tìm kiếm danh mục
    public function search($keyword) {
        // SQL code...
    }
}
