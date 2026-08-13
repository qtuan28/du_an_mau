<?php
require_once 'models/db.php';

class SanPham {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->conn;
        $this->checkAndMigrateColumns();
    }

    // Tá»± Ä‘á»™ng thÃªm cá»™t giam_gia, trang_thai, ngay_tao vÃ  báº£ng SPECIFICATION vÃ o CSDL náº¿u chÆ°a cÃ³
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

            // Tá»± Ä‘á»™ng thÃªm 4 cá»™t áº£nh chi tiáº¿t náº¿u chÆ°a cÃ³
            $galleryCols = ['anh_1', 'anh_2', 'anh_3', 'anh_4'];
            foreach ($galleryCols as $colName) {
                $chk = $this->db->query("SHOW COLUMNS FROM PRODUCTS LIKE '{$colName}'");
                if ($chk->rowCount() == 0) {
                    $this->db->exec("ALTER TABLE PRODUCTS ADD COLUMN {$colName} VARCHAR(255)");
                }
            }

            // Tá»± Ä‘á»™ng táº¡o báº£ng SPECIFICATION náº¿u chÆ°a cÃ³
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

            // Äáº£m báº£o bá»• sung cÃ¡c cá»™t náº¿u báº£ng SPECIFICATION Ä‘Ã£ tá»“n táº¡i tá»« trÆ°á»›c nhÆ°ng chÆ°a cÃ³ cá»™t má»›i
            $specCols = [
                'chieu_dai_tay_cam' => 'FLOAT',
                'chu_vi_tay_cam' => 'FLOAT',
                'trong_luong' => 'FLOAT',
                'do_day_loi' => 'FLOAT'
            ];
            foreach ($specCols as $colName => $colType) {
                $chk = $this->db->query("SHOW COLUMNS FROM SPECIFICATION LIKE '{$colName}'");
                if ($chk->rowCount() == 0) {
                    $this->db->exec("ALTER TABLE SPECIFICATION ADD COLUMN {$colName} {$colType}");
                }
            }

            // ChÃ¨n/cáº­p nháº­t dá»¯ liá»‡u máº«u thÃ´ng sá»‘ ká»¹ thuáº­t cho 3 sáº£n pháº©m ban Ä‘áº§u
            $stmtCheckSpec = $this->db->query("SELECT COUNT(*) FROM SPECIFICATION");
            if ((int)$stmtCheckSpec->fetchColumn() == 0) {
                $this->db->exec("INSERT INTO SPECIFICATION (product_id, chat_lieu, do_day_loi, loai_tay_cam, chieu_dai, chieu_rong, chieu_dai_tay_cam, chu_vi_tay_cam, trong_luong, chung_nhan, kich_thuoc) VALUES 
                (1, 'Carbon Fiber T700 & Fiberglass Surface', 16.0, 'Cán bọc da cao cấp (Standard Cushion)', 41.9, 19.0, 12.7, 10.8, 225.0, 'USAPA Approved (Thi đấu chuyên nghiệp)', 'Standard 16.5\" x 7.5\"'),
                (2, 'QuadCarbon Face & Polymer Honeycomb Core', 13.0, 'Selkirk Geo Grip Pro', 40.6, 20.3, 13.3, 10.5, 230.0, 'USAPA Approved & PPA Tour Official', 'Wide Body 16.0\" x 8.0\"'),
                (3, 'Nhựa Polyethylene cao cấp (40 lá»— Ä‘á»¥c chÃ­nh xÃ¡c)', 0, 'Không áp dụng', 7.4, 7.4, 0, 23.2, 26.0, 'USAPA Tournament Approved', 'Đường kính 74mm (Bộ 4 quả)')
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
                    kich_thuoc = VALUES(kich_thuoc)");
            }

            // Migration: ThÃªm cá»™t trang_thai vÃ o PRODUCT_DETAILS náº¿u chÆ°a cÃ³
            try {
                $chk = $this->db->query("SHOW COLUMNS FROM PRODUCT_DETAILS LIKE 'trang_thai'");
                if ($chk->rowCount() == 0) {
                    $this->db->exec("ALTER TABLE PRODUCT_DETAILS ADD COLUMN trang_thai ENUM('Còn hàng','Hỏng','Đã bán') DEFAULT 'Còn hàng'");
                }
            } catch (Exception $e) {}

            // Migration: ThÃªm cá»™t bien_the, so_luong vÃ  ma_sp vÃ o PRODUCTS náº¿u chÆ°a cÃ³
            try {
                $chk = $this->db->query("SHOW COLUMNS FROM PRODUCTS LIKE 'bien_the'");
                if ($chk->rowCount() == 0) {
                    $this->db->exec("ALTER TABLE PRODUCTS ADD COLUMN bien_the VARCHAR(255)");
                }
                $chkQty = $this->db->query("SHOW COLUMNS FROM PRODUCTS LIKE 'so_luong'");
                if ($chkQty->rowCount() == 0) {
                    $this->db->exec("ALTER TABLE PRODUCTS ADD COLUMN so_luong INT DEFAULT 0");
                }
                $chkMaSp = $this->db->query("SHOW COLUMNS FROM PRODUCTS LIKE 'ma_sp'");
                if ($chkMaSp->rowCount() == 0) {
                    $this->db->exec("ALTER TABLE PRODUCTS ADD COLUMN ma_sp VARCHAR(20) UNIQUE");
                    // Cáº­p nháº­t mÃ£ tá»± Ä‘á»™ng cho cÃ¡c sáº£n pháº©m cÅ©
                    $this->db->exec("UPDATE PRODUCTS SET ma_sp = CONCAT('P-', LPAD(product_id, 7, '0')) WHERE ma_sp IS NULL OR ma_sp = ''");
                }
            } catch (Exception $e) {}

            // Táº¡o báº£ng PRODUCT_INVENTORY_HISTORY
            $sqlHistoryTable = "CREATE TABLE IF NOT EXISTS PRODUCT_INVENTORY_HISTORY (
                history_id INT AUTO_INCREMENT PRIMARY KEY,
                product_id INT NOT NULL,
                so_luong_thay_doi INT NOT NULL,
                loai_thay_doi ENUM('nhap_hang', 'ban_hang', 'loi') NOT NULL,
                ngay_thay_doi DATETIME DEFAULT CURRENT_TIMESTAMP,
                ghi_chu VARCHAR(255),
                FOREIGN KEY (product_id) REFERENCES PRODUCTS(product_id) ON DELETE CASCADE
            )";
            $this->db->exec($sqlHistoryTable);

        } catch (Exception $e) {
            // Bá» qua lá»—i náº¿u trÃ¹ng láº­p
        }
    }

    // Láº¥y táº¥t cáº£ sáº£n pháº©m
    public function getAll($onlyActiveCategory = true) {
        $sql = "SELECT p.*, c.name as ten_danh_muc,
                    p.so_luong AS tong_ton_kho
                FROM PRODUCTS p 
                LEFT JOIN CATEGORIES c ON p.category_id = c.category_id";
        
        if ($onlyActiveCategory) {
            $sql .= " WHERE (c.trang_thai = 1 OR c.trang_thai IS NULL)";
        }
        
        $sql .= " ORDER BY p.product_id DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Láº¥y danh sÃ¡ch sáº£n pháº©m phÃ¢n trang & tÃ¬m kiáº¿m & lá»c danh má»¥c & lá»c tráº¡ng thÃ¡i & lá»c giÃ¡ & sáº¯p xáº¿p
    public function getAllWithPagination($keyword = '', $categoryId = 0, $stockStatus = '', $page = 1, $limit = 16, $priceRange = '', $sort = 'newest', $checkCategoryActive = true) {
        $offset = max(0, ($page - 1) * $limit);
        $sql = "SELECT p.*, c.name as ten_danh_muc 
                FROM PRODUCTS p 
                LEFT JOIN CATEGORIES c ON p.category_id = c.category_id
                WHERE 1=1";

        if ($checkCategoryActive) {
            $sql .= " AND (c.trang_thai = 1 OR c.trang_thai IS NULL)";
        }

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

        if ($priceRange === 'under_1m') {
            $sql .= " AND p.gia < 1000000";
        } elseif ($priceRange === '1m_3m') {
            $sql .= " AND p.gia >= 1000000 AND p.gia <= 3000000";
        } elseif ($priceRange === 'above_3m') {
            $sql .= " AND p.gia > 3000000";
        }

        if ($sort === 'price_asc') {
            $sql .= " ORDER BY p.gia ASC";
        } elseif ($sort === 'price_desc') {
            $sql .= " ORDER BY p.gia DESC";
        } else {
            $sql .= " ORDER BY p.product_id DESC";
        }

        $sql .= " LIMIT :limit OFFSET :offset";

        $stmt = $this->db->prepare($sql);

        foreach ($params as $key => $val) {
            $stmt->bindValue($key, $val);
        }
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Äáº¿m tá»•ng sá»‘ sáº£n pháº©m theo bá»™ lá»c (Ä‘á»ƒ tÃ­nh sá»‘ trang)
    public function getTotalCount($keyword = '', $categoryId = 0, $stockStatus = '', $priceRange = '', $checkCategoryActive = true) {
        $sql = "SELECT COUNT(*) FROM PRODUCTS p 
                LEFT JOIN CATEGORIES c ON p.category_id = c.category_id 
                WHERE 1=1";
        
        if ($checkCategoryActive) {
            $sql .= " AND (c.trang_thai = 1 OR c.trang_thai IS NULL)";
        }

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

        if ($priceRange === 'under_1m') {
            $sql .= " AND p.gia < 1000000";
        } elseif ($priceRange === '1m_3m') {
            $sql .= " AND p.gia >= 1000000 AND p.gia <= 3000000";
        } elseif ($priceRange === 'above_3m') {
            $sql .= " AND p.gia > 3000000";
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return (int)$stmt->fetchColumn();
    }

    // Láº¥y chi tiáº¿t 1 sáº£n pháº©m theo ID kÃ¨m thÃ´ng sá»‘ ká»¹ thuáº­t (CÃ³ há»— trá»£ kiá»ƒm tra danh má»¥c Ä‘ang hoáº¡t Ä‘á»™ng)
    public function getById($id, $checkActiveCategory = false) {
        $sql = "SELECT p.*, c.name as ten_danh_muc, c.trang_thai as category_trang_thai, c.thong_so_loai as category_thong_so_loai,
                       s.spec_id, s.kich_thuoc, s.chat_lieu, s.chung_nhan, s.loai_tay_cam,
                       s.chieu_dai, s.chieu_rong, s.chieu_dai_tay_cam, s.chu_vi_tay_cam,
                       s.trong_luong, s.do_day_loi
                FROM PRODUCTS p 
                LEFT JOIN CATEGORIES c ON p.category_id = c.category_id 
                LEFT JOIN SPECIFICATION s ON p.product_id = s.product_id
                WHERE p.product_id = :id";

        if ($checkActiveCategory) {
            $sql .= " AND (c.trang_thai = 1 OR c.trang_thai IS NULL)";
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // LÆ°u hoáº·c cáº­p nháº­t thÃ´ng sá»‘ ká»¹ thuáº­t sáº£n pháº©m
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

    // ThÃªm sáº£n pháº©m má»›i
    public function add($data) {
        $ma_sp = trim($data['ma_sp'] ?? '');
        if (empty($ma_sp)) {
            $ma_sp = 'P-' . strtoupper(substr(md5(uniqid(rand(), true)), 0, 8));
        }

        $sql = "INSERT INTO PRODUCTS (category_id, ma_sp, ten, gia, giam_gia, trang_thai, anh, anh_1, anh_2, anh_3, anh_4, bien_the, so_luong, ngay_tao) 
                VALUES (:category_id, :ma_sp, :ten, :gia, :giam_gia, :trang_thai, :anh, :anh_1, :anh_2, :anh_3, :anh_4, :bien_the, :so_luong, NOW())";

        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute([
            ':category_id' => (int)$data['category_id'],
            ':ma_sp' => $ma_sp,
            ':ten' => $data['ten'],
            ':gia' => (float)$data['gia'],
            ':giam_gia' => (int)($data['giam_gia'] ?? 0),
            ':trang_thai' => (int)($data['trang_thai'] ?? 1),
            ':anh' => $data['anh'] ?? '',
            ':anh_1' => $data['anh_1'] ?? '',
            ':anh_2' => $data['anh_2'] ?? '',
            ':anh_3' => $data['anh_3'] ?? '',
            ':anh_4' => $data['anh_4'] ?? '',
            ':bien_the' => $data['bien_the'] ?? '',
            ':so_luong' => (int)($data['so_luong'] ?? 0)
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

    // Cáº­p nháº­t sáº£n pháº©m
    public function update($id, $data) {
        $ma_sp = trim($data['ma_sp'] ?? '');
        if (empty($ma_sp)) {
            $ma_sp = 'P-' . strtoupper(substr(md5(uniqid(rand(), true)), 0, 8));
        }

        $sql = "UPDATE PRODUCTS 
                SET category_id = :category_id, 
                    ma_sp = :ma_sp,
                    ten = :ten, 
                    gia = :gia, 
                    giam_gia = :giam_gia, 
                    trang_thai = :trang_thai, 
                    anh = :anh,
                    anh_1 = :anh_1,
                    anh_2 = :anh_2,
                    anh_3 = :anh_3,
                    anh_4 = :anh_4,
                    bien_the = :bien_the
                WHERE product_id = :id";

        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute([
            ':category_id' => (int)$data['category_id'],
            ':ma_sp' => $ma_sp,
            ':ten' => $data['ten'],
            ':gia' => (float)$data['gia'],
            ':giam_gia' => (int)($data['giam_gia'] ?? 0),
            ':trang_thai' => (int)($data['trang_thai'] ?? 1),
            ':anh' => $data['anh'],
            ':anh_1' => $data['anh_1'] ?? '',
            ':anh_2' => $data['anh_2'] ?? '',
            ':anh_3' => $data['anh_3'] ?? '',
            ':anh_4' => $data['anh_4'] ?? '',
            ':bien_the' => $data['bien_the'] ?? '',
            ':id' => (int)$id
        ]);

        if ($result && isset($data['spec']) && is_array($data['spec'])) {
            $this->saveSpecification($id, $data['spec']);
        }

        return $result;
    }

    // Chuyá»ƒn Ä‘á»•i nhanh tráº¡ng thÃ¡i cÃ²n hÃ ng / háº¿t hÃ ng
    public function toggleStockStatus($id) {
        $sql = "UPDATE PRODUCTS 
                SET trang_thai = CASE WHEN trang_thai = 1 THEN 0 ELSE 1 END 
                WHERE product_id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    // XÃ³a sáº£n pháº©m
    public function delete($id) {
        $sql = "DELETE FROM PRODUCTS WHERE product_id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    // ============================================
    // LOGIC QUáº¢N LÃ Tá»’N KHO VÃ€ Lá»ŠCH Sá»¬ KHO
    // ============================================
    
    // Cáº­p nháº­t sá»‘ lÆ°á»£ng kho vÃ  lÆ°u lá»‹ch sá»­
    public function updateStock($productId, $quantityChange, $type, $note = '') {
        $productId = (int)$productId;
        $quantityChange = (int)$quantityChange;
        
        if ($quantityChange === 0) return true;

        // Cáº­p nháº­t sá»‘ lÆ°á»£ng trong PRODUCTS vÃ  tá»± Ä‘á»™ng chuyá»ƒn tráº¡ng thÃ¡i cÃ²n/háº¿t hÃ ng
        $sql = "UPDATE PRODUCTS SET 
                    so_luong = GREATEST(0, so_luong + :qty),
                    trang_thai = IF(so_luong + :qty > 0, 1, 0)
                WHERE product_id = :id";
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute([
            ':qty' => $quantityChange,
            ':id' => $productId
        ]);

        if ($result) {
            // LÆ°u lá»‹ch sá»­
            $sqlHist = "INSERT INTO PRODUCT_INVENTORY_HISTORY (product_id, so_luong_thay_doi, loai_thay_doi, ghi_chu) 
                        VALUES (:id, :qty, :type, :note)";
            $stmtHist = $this->db->prepare($sqlHist);
            $stmtHist->execute([
                ':id' => $productId,
                ':qty' => $quantityChange,
                ':type' => $type,
                ':note' => $note
            ]);
            return true;
        }
        return false;
    }

    // Láº¥y lá»‹ch sá»­ nháº­p/bÃ¡n cá»§a 1 sáº£n pháº©m
    public function getInventoryHistory($productId) {
        $sql = "SELECT * FROM PRODUCT_INVENTORY_HISTORY 
                WHERE product_id = :id 
                ORDER BY ngay_thay_doi DESC, history_id DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => (int)$productId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

