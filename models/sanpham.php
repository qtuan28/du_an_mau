<?php
require_once 'models/db.php';

class SanPham {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->conn;
        $this->checkAndMigrateColumns();
    }

    // Tự động thêm cột giam_gia, trang_thai, ngay_tao và bảng SPECIFICATION vào CSDL nếu chưa có
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

            // Tự động tạo bảng SPECIFICATION nếu chưa có
            $sqlSpecTable = "CREATE TABLE IF NOT EXISTS SPECIFICATION (
                spec_id INT AUTO_INCREMENT PRIMARY KEY,
                product_id INT NOT NULL UNIQUE,
                kich_thuoc VARCHAR(50),
                chat_lieu VARCHAR(100),
                chung_nhan VARCHAR(100),
                loai_tay_cam VARCHAR(50),
                chieu_dai FLOAT,
                chieu_rong FLOAT,
                chieu_dai_tay_cam FLOAT,
                chu_vi_tay_cam FLOAT,
                trong_luong FLOAT,
                do_day_loi FLOAT,
                FOREIGN KEY (product_id) REFERENCES PRODUCTS(product_id) ON DELETE CASCADE
            )";
            $this->db->exec($sqlSpecTable);

            // Chèn dữ liệu mẫu thông số kỹ thuật cho 3 sản phẩm ban đầu nếu bảng đang trống
            $stmtCheckSpec = $this->db->query("SELECT COUNT(*) FROM SPECIFICATION");
            if ((int)$stmtCheckSpec->fetchColumn() == 0) {
                $this->db->exec("INSERT IGNORE INTO SPECIFICATION (product_id, chat_lieu, do_day_loi, loai_tay_cam, chieu_dai, chieu_rong, chieu_dai_tay_cam, chu_vi_tay_cam, trong_luong, chung_nhan, kich_thuoc) VALUES 
                (1, 'Carbon Fiber T700 & Fiberglass Surface', 16.0, 'Cán bọc da cao cấp (Standard Cushion)', 41.9, 19.0, 12.7, 10.8, 225.0, 'USAPA Approved (Thi đấu chuyên nghiệp)', 'Standard 16.5\" x 7.5\"'),
                (2, 'QuadCarbon Face & Polymer Honeycomb Core', 13.0, 'Selkirk Geo Grip Pro', 40.6, 20.3, 13.3, 10.5, 230.0, 'USAPA Approved & PPA Tour Official', 'Wide Body 16.0\" x 8.0\"'),
                (3, 'Nhựa Polyethylene cao cấp (40 lỗ đục chính xác)', 0, 'Không áp dụng', 7.4, 7.4, 0, 23.2, 26.0, 'USAPA Tournament Approved', 'Đường kính 74mm (Bộ 4 quả)')");
            }
        } catch (Exception $e) {
            // Bỏ qua lỗi nếu trùng lặp
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

    // Lấy danh sách sản phẩm phân trang & tìm kiếm & lọc danh mục & lọc trạng thái
    public function getAllWithPagination($keyword = '', $categoryId = 0, $stockStatus = '', $page = 1, $limit = 16) {
        $offset = max(0, ($page - 1) * $limit);
        $sql = "SELECT p.*, c.name as ten_danh_muc 
                FROM PRODUCTS p 
                LEFT JOIN CATEGORIES c ON p.category_id = c.category_id
                WHERE 1=1";

        $params = [];

        if ($keyword !== '') {
            $sql .= " AND p.ten LIKE :keyword";
            $params[':keyword'] = '%' . $keyword . '%';
        }

        if ($categoryId > 0) {
            $sql .= " AND p.category_id = :categoryId";
            $params[':categoryId'] = (int)$categoryId;
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
    public function getTotalCount($keyword = '', $categoryId = 0, $stockStatus = '') {
        $sql = "SELECT COUNT(*) FROM PRODUCTS p WHERE 1=1";
        $params = [];

        if ($keyword !== '') {
            $sql .= " AND p.ten LIKE :keyword";
            $params[':keyword'] = '%' . $keyword . '%';
        }

        if ($categoryId > 0) {
            $sql .= " AND p.category_id = :categoryId";
            $params[':categoryId'] = (int)$categoryId;
        }

        if ($stockStatus !== '') {
            $sql .= " AND p.trang_thai = :stockStatus";
            $params[':stockStatus'] = (int)$stockStatus;
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return (int)$stmt->fetchColumn();
    }

    // Lấy chi tiết 1 sản phẩm theo ID kèm thông số kỹ thuật
    public function getById($id) {
        $sql = "SELECT p.*, c.name as ten_danh_muc, 
                       s.spec_id, s.kich_thuoc, s.chat_lieu, s.chung_nhan, s.loai_tay_cam,
                       s.chieu_dai, s.chieu_rong, s.chieu_dai_tay_cam, s.chu_vi_tay_cam,
                       s.trong_luong, s.do_day_loi
                FROM PRODUCTS p 
                LEFT JOIN CATEGORIES c ON p.category_id = c.category_id 
                LEFT JOIN SPECIFICATION s ON p.product_id = s.product_id
                WHERE p.product_id = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Lưu hoặc cập nhật thông số kỹ thuật sản phẩm
    public function saveSpecification($productId, $specData) {
        $sql = "INSERT INTO SPECIFICATION (product_id, chat_lieu, do_day_loi, loai_tay_cam, chieu_dai, chieu_rong, chieu_dai_tay_cam, chu_vi_tay_cam, trong_luong, chung_nhan, kich_thuoc)
                VALUES (:product_id, :chat_lieu, :do_day_loi, :loai_tay_cam, :chieu_dai, :chieu_rong, :chieu_dai_tay_cam, :chu_vi_tay_cam, :trong_luong, :chung_nhan, :kich_thuoc)
                ON DUPLICATE KEY UPDATE 
                    chat_lieu = VALUES(chat_lieu),
                    do_day_loi = VALUES(do_day_loi),
                    loai_tay_cam = VALUES(loai_tay_cam),
                    chieu_dai = VALUES(chieu_dai),
                    chieu_rong = VALUES(chieu_rong),
                    chieu_dai_tay_cam = VALUES(chieu_dai_tay_cam),
                    chu_vi_tay_cam = VALUES(chu_vi_tay_cam),
                    trong_luong = VALUES(trong_luong),
                    chung_nhan = VALUES(chung_nhan),
                    kich_thuoc = VALUES(kich_thuoc)";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':product_id' => (int)$productId,
            ':chat_lieu' => $specData['chat_lieu'] ?? '',
            ':do_day_loi' => (float)($specData['do_day_loi'] ?? 0),
            ':loai_tay_cam' => $specData['loai_tay_cam'] ?? '',
            ':chieu_dai' => (float)($specData['chieu_dai'] ?? 0),
            ':chieu_rong' => (float)($specData['chieu_rong'] ?? 0),
            ':chieu_dai_tay_cam' => (float)($specData['chieu_dai_tay_cam'] ?? 0),
            ':chu_vi_tay_cam' => (float)($specData['chu_vi_tay_cam'] ?? 0),
            ':trong_luong' => (float)($specData['trong_luong'] ?? 0),
            ':chung_nhan' => $specData['chung_nhan'] ?? '',
            ':kich_thuoc' => $specData['kich_thuoc'] ?? ''
        ]);
    }

    // Thêm sản phẩm mới
    public function add($data) {
        $sql = "INSERT INTO PRODUCTS (category_id, ten, gia, giam_gia, trang_thai, anh, ngay_tao) 
                VALUES (:category_id, :ten, :gia, :giam_gia, :trang_thai, :anh, NOW())";

        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute([
            ':category_id' => (int)$data['category_id'],
            ':ten' => $data['ten'],
            ':gia' => (float)$data['gia'],
            ':giam_gia' => (int)($data['giam_gia'] ?? 0),
            ':trang_thai' => (int)($data['trang_thai'] ?? 1),
            ':anh' => $data['anh'] ?? ''
        ]);

        if ($result) {
            $productId = $this->db->lastInsertId();
            if (isset($data['spec']) && is_array($data['spec'])) {
                $this->saveSpecification($productId, $data['spec']);
            }
            return $productId;
        }
        return false;
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
        $result = $stmt->execute([
            ':category_id' => (int)$data['category_id'],
            ':ten' => $data['ten'],
            ':gia' => (float)$data['gia'],
            ':giam_gia' => (int)($data['giam_gia'] ?? 0),
            ':trang_thai' => (int)($data['trang_thai'] ?? 1),
            ':anh' => $data['anh'],
            ':id' => (int)$id
        ]);

        if ($result && isset($data['spec']) && is_array($data['spec'])) {
            $this->saveSpecification($id, $data['spec']);
        }

        return $result;
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

