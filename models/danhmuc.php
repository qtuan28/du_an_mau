<?php
require_once 'models/db.php';

class DanhMuc
{
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->conn;
        $this->checkAndMigrateColumns();
    }

    // Tự động kiểm tra và nâng cấp bảng CATEGORIES nếu chưa có cột ngay_tao, trang_thai
    private function checkAndMigrateColumns()
    {
        try {
            $stmt = $this->db->query("SHOW COLUMNS FROM CATEGORIES LIKE 'ngay_tao'");
            if ($stmt->rowCount() == 0) {
                $this->db->exec("ALTER TABLE CATEGORIES ADD COLUMN ngay_tao DATETIME DEFAULT CURRENT_TIMESTAMP");
            }

            $stmt = $this->db->query("SHOW COLUMNS FROM CATEGORIES LIKE 'trang_thai'");
            if ($stmt->rowCount() == 0) {
                $this->db->exec("ALTER TABLE CATEGORIES ADD COLUMN trang_thai TINYINT(1) DEFAULT 1");
            }
        } catch (Exception $e) {
            // Bỏ qua lỗi nếu bảng chưa sẵn sàng hoặc đã được nâng cấp
        }
    }

    // Lấy tất cả danh mục
    public function getAll()
    {
        $sql = "SELECT * FROM CATEGORIES ORDER BY category_id DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Thêm danh mục
    public function add($name, $trang_thai = 1)
    {
        $sql = "INSERT INTO CATEGORIES(name, trang_thai, ngay_tao)
                VALUES(:name, :trang_thai, NOW())";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':name' => $name,
            ':trang_thai' => (int)$trang_thai
        ]);
    }

    // Lấy theo ID
    public function getById($id)
    {
        $sql = "SELECT * FROM CATEGORIES WHERE category_id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Cập nhật danh mục
    public function update($id, $name, $trang_thai)
    {
        $sql = "UPDATE CATEGORIES
                SET name = :name, trang_thai = :trang_thai
                WHERE category_id = :id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':name' => $name,
            ':trang_thai' => (int)$trang_thai,
            ':id' => $id
        ]);
    }

    // Chuyển đổi trạng thái hoạt động nhanh
    public function toggleStatus($id)
    {
        $sql = "UPDATE CATEGORIES
                SET trang_thai = CASE WHEN trang_thai = 1 THEN 0 ELSE 1 END
                WHERE category_id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    // Xóa danh mục
    public function delete($id)
    {
        $sql = "DELETE FROM CATEGORIES WHERE category_id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    // Tìm kiếm danh mục
    public function search($keyword)
    {
        $sql = "SELECT * FROM CATEGORIES
                WHERE name LIKE :keyword
                ORDER BY category_id DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':keyword' => '%' . $keyword . '%']);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Kiểm tra trùng tên danh mục
    public function checkExists($name, $ignoreId = 0)
    {
        $sql = "SELECT * FROM CATEGORIES WHERE name = :name AND category_id != :ignoreId";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':name' => $name,
            ':ignoreId' => (int)$ignoreId
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

