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

    // Tá»± Ä‘á»™ng kiá»ƒm tra vÃ  nÃ¢ng cáº¥p báº£ng CATEGORIES náº¿u chÆ°a cÃ³ cá»™t ngay_tao, trang_thai, thong_so_loai
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
                
                // Cáº­p nháº­t giÃ¡ trá»‹ thÃ´ng sá»‘ máº·c Ä‘á»‹nh cho danh má»¥c ban Ä‘áº§u
                $this->db->exec("UPDATE CATEGORIES SET thong_so_loai = 'do_day_vot' WHERE LOWER(name) LIKE '%vợt%'");
                $this->db->exec("UPDATE CATEGORIES SET thong_so_loai = 'size_giay' WHERE LOWER(name) LIKE '%giày%'");
                $this->db->exec("UPDATE CATEGORIES SET thong_so_loai = 'so_lo_bong' WHERE LOWER(name) LIKE '%bóng%''");
                $this->db->exec("UPDATE CATEGORIES SET thong_so_loai = 'loai_phu_kien' WHERE LOWER(name) LIKE '%phụ kiện%'");
            }
        } catch (Exception $e) {
            // Bá» qua lá»—i náº¿u báº£ng chÆ°a sáºµn sÃ ng hoáº·c Ä‘Ã£ Ä‘Æ°á»£c nÃ¢ng cáº¥p
        }
    }

    // Láº¥y táº¥t cáº£ danh má»¥c (kÃ¨m sá»‘ lÆ°á»£ng sáº£n pháº©m)
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

    // ThÃªm danh má»¥c
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

    // Láº¥y theo ID
    public function getById($id)
    {
        $sql = "SELECT * FROM CATEGORIES WHERE category_id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Cáº­p nháº­t danh má»¥c
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

    // Chuyá»ƒn Ä‘á»•i tráº¡ng thÃ¡i hoáº¡t Ä‘á»™ng nhanh
    public function toggleStatus($id)
    {
        $sql = "UPDATE CATEGORIES
                SET trang_thai = CASE WHEN trang_thai = 1 THEN 0 ELSE 1 END
                WHERE category_id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    // XÃ³a danh má»¥c
    public function delete($id)
    {
        $sql = "DELETE FROM CATEGORIES WHERE category_id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    // TÃ¬m kiáº¿m danh má»¥c (kÃ¨m sá»‘ lÆ°á»£ng sáº£n pháº©m)
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

    // Kiá»ƒm tra trÃ¹ng tÃªn danh má»¥c
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

