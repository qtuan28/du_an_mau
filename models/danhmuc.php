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

    // Tự động kiểm tra và nâng cấp bảng CATEGORIES nếu chưa có cột ngay_tao, trang_thai, thong_so_loai
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

            $stmt = $this->db->query("SHOW COLUMNS FROM CATEGORIES LIKE 'thong_so_loai'");
            if ($stmt->rowCount() == 0) {
                $this->db->exec("ALTER TABLE CATEGORIES ADD COLUMN thong_so_loai VARCHAR(50) DEFAULT 'do_day_vot'");
                
                // Cập nhật giá trị thông số mặc định cho danh mục ban đầu
                $this->db->exec("UPDATE CATEGORIES SET thong_so_loai = 'do_day_vot' WHERE LOWER(name) LIKE '%vợt%'");
                $this->db->exec("UPDATE CATEGORIES SET thong_so_loai = 'size_giay' WHERE LOWER(name) LIKE '%gi�y%'");
                $this->db->exec("UPDATE CATEGORIES SET thong_so_loai = 'so_lo_bong' WHERE LOWER(name) LIKE '%b�ng%''");
                $this->db->exec("UPDATE CATEGORIES SET thong_so_loai = 'loai_phu_kien' WHERE LOWER(name) LIKE '%phụ kiện%'");
            }
        } catch (Exception $e) {
            // Bỏ qua lỗi nếu bảng chưa sẵn sàng hoặc đã được nâng cấp
        }
    }

    // Lấy tất cả danh mục (kèm số lượng sản phẩm)
    public function getAll()
    {
        $sql = "SELECT c.*, 
                    COUNT(p.product_id) AS so_san_pham
                FROM CATEGORIES c
                LEFT JOIN PRODUCTS p ON p.category_id = c.category_id
                GROUP BY c.category_id
                ORDER BY c.category_id DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Thêm danh mục
    public function add($name, $trang_thai = 1, $thong_so_loai = 'do_day_vot')
    {
        $sql = "INSERT INTO CATEGORIES(name, trang_thai, thong_so_loai, ngay_tao)
                VALUES(:name, :trang_thai, :thong_so_loai, NOW())";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':name' => $name,
            ':trang_thai' => (int)$trang_thai,
            ':thong_so_loai' => $thong_so_loai
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
    public function update($id, $name, $trang_thai, $thong_so_loai = 'do_day_vot')
    {
        $sql = "UPDATE CATEGORIES
                SET name = :name, trang_thai = :trang_thai, thong_so_loai = :thong_so_loai
                WHERE category_id = :id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':name' => $name,
            ':trang_thai' => (int)$trang_thai,
            ':thong_so_loai' => $thong_so_loai,
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

    // Kiểm tra danh mục có sản phẩm không
    public function hasProducts($id)
    {
        $sql = "SELECT COUNT(*) as count FROM PRODUCTS WHERE category_id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['count'] > 0;
    }

    // Xóa danh mục
    public function delete($id)
    {
        $sql = "DELETE FROM CATEGORIES WHERE category_id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    // Tìm kiếm danh mục (kèm số lượng sản phẩm)
    public function search($keyword)
    {
        $sql = "SELECT c.*,
                    COUNT(p.product_id) AS so_san_pham
                FROM CATEGORIES c
                LEFT JOIN PRODUCTS p ON p.category_id = c.category_id
                WHERE c.name LIKE :keyword
                GROUP BY c.category_id
                ORDER BY c.category_id DESC";

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

