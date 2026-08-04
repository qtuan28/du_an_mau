<?php
require_once 'models/db.php';

class SanPham {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->conn;
        $this->checkAndMigrateColumns();
    }

    // Tự động thêm cột giam_gia, trang_thai, ngay_tao vào CSDL nếu chưa có
    private function checkAndMigrateColumns() {
        try {
            $stmt = $this->db->query("SHOW COLUMNS FROM PRODUCTS LIKE 'giam_gia'");
            if ($stmt->rowCount() == 0) {
                $this->db->exec("ALTER TABLE PRODUCTS ADD COLUMN giam_gia INT DEFAULT 0");
            }

            $stmt = $this->db->query("SHOW COLUMNS FROM PRODUCTS LIKE 'trang_thai'");
            if ($stmt->rowCount() == 0) {
                $this->db->exec("ALTER TABLE PRODUCTS ADD COLUMN trang_thai TINYINT(1) DEFAULT 1");
            }

            $stmt = $this->db->query("SHOW COLUMNS FROM PRODUCTS LIKE 'ngay_tao'");
            if ($stmt->rowCount() == 0) {
                $this->db->exec("ALTER TABLE PRODUCTS ADD COLUMN ngay_tao DATETIME DEFAULT CURRENT_TIMESTAMP");
            }
        } catch (Exception $e) {
            // Bỏ qua lỗi nếu đã có cột
        }
    }

    // Lấy tất cả sản phẩm
    public function getAll() {
        $sql = "SELECT p.*, c.name as ten_danh_muc 
                FROM PRODUCTS p 
                LEFT JOIN CATEGORIES c ON p.category_id = c.category_id
                ORDER BY p.product_id DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy danh sách sản phẩm phân trang & tìm kiếm & lọc trạng thái
    public function getAllWithPagination($keyword = '', $stockStatus = '', $page = 1, $limit = 5) {
        $offset = ($page - 1) * $limit;
        $sql = "SELECT p.*, c.name as ten_danh_muc 
                FROM PRODUCTS p 
                LEFT JOIN CATEGORIES c ON p.category_id = c.category_id
                WHERE 1=1";

        $params = [];

        if ($keyword !== '') {
            $sql .= " AND p.ten LIKE :keyword";
            $params[':keyword'] = '%' . $keyword . '%';
        }

        if ($stockStatus !== '') {
            $sql .= " AND p.trang_thai = :stockStatus";
            $params[':stockStatus'] = (int)$stockStatus;
        }

        $sql .= " ORDER BY p.product_id DESC LIMIT :limit OFFSET :offset";

        $stmt = $this->db->prepare($sql);

        foreach ($params as $key => $val) {
            $stmt->bindValue($key, $val);
        }
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Đếm tổng số sản phẩm theo bộ lọc (để tính số trang)
    public function getTotalCount($keyword = '', $stockStatus = '') {
        $sql = "SELECT COUNT(*) FROM PRODUCTS p WHERE 1=1";
        $params = [];

        if ($keyword !== '') {
            $sql .= " AND p.ten LIKE :keyword";
            $params[':keyword'] = '%' . $keyword . '%';
        }

        if ($stockStatus !== '') {
            $sql .= " AND p.trang_thai = :stockStatus";
            $params[':stockStatus'] = (int)$stockStatus;
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return (int)$stmt->fetchColumn();
    }

    // Lấy chi tiết 1 sản phẩm theo ID
    public function getById($id) {
        $sql = "SELECT p.*, c.name as ten_danh_muc 
                FROM PRODUCTS p 
                LEFT JOIN CATEGORIES c ON p.category_id = c.category_id 
                WHERE p.product_id = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Thêm sản phẩm mới
    public function add($data) {
        $sql = "INSERT INTO PRODUCTS (category_id, ten, gia, giam_gia, trang_thai, anh, ngay_tao) 
                VALUES (:category_id, :ten, :gia, :giam_gia, :trang_thai, :anh, NOW())";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':category_id' => (int)$data['category_id'],
            ':ten' => $data['ten'],
            ':gia' => (float)$data['gia'],
            ':giam_gia' => (int)($data['giam_gia'] ?? 0),
            ':trang_thai' => (int)($data['trang_thai'] ?? 1),
            ':anh' => $data['anh'] ?? ''
        ]);
    }

    // Cập nhật sản phẩm
    public function update($id, $data) {
        $sql = "UPDATE PRODUCTS 
                SET category_id = :category_id, 
                    ten = :ten, 
                    gia = :gia, 
                    giam_gia = :giam_gia, 
                    trang_thai = :trang_thai, 
                    anh = :anh 
                WHERE product_id = :id";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':category_id' => (int)$data['category_id'],
            ':ten' => $data['ten'],
            ':gia' => (float)$data['gia'],
            ':giam_gia' => (int)($data['giam_gia'] ?? 0),
            ':trang_thai' => (int)($data['trang_thai'] ?? 1),
            ':anh' => $data['anh'],
            ':id' => (int)$id
        ]);
    }

    // Chuyển đổi nhanh trạng thái còn hàng / hết hàng
    public function toggleStockStatus($id) {
        $sql = "UPDATE PRODUCTS 
                SET trang_thai = CASE WHEN trang_thai = 1 THEN 0 ELSE 1 END 
                WHERE product_id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    // Xóa sản phẩm
    public function delete($id) {
        $sql = "DELETE FROM PRODUCTS WHERE product_id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}