<?php
require_once 'models/db.php';

class GioHang {
    private $db;

    public function __construct() {
        $this->db = new Database();
        $this->checkAndMigrate();
    }

    private function checkAndMigrate() {
        try {
            // Thêm cột cart_data nếu chưa có
            $this->db->conn->exec("ALTER TABLE GIOHANG ADD COLUMN cart_data TEXT DEFAULT NULL");
        } catch (PDOException $e) {}
    }

    // Lấy ID người dùng hiện tại (nếu đã đăng nhập)
    private function getUserId() {
        return $_SESSION['user']['user_id'] ?? null;
    }

    // 1. Lấy danh sách sản phẩm trong giỏ hàng từ Session
    public function getGioHang() {
        return $_SESSION['cart'] ?? [];
    }

    // Lưu giỏ hàng hiện tại (Session) vào Database (nếu đã đăng nhập)
    private function saveCartToDB() {
        $userId = $this->getUserId();
        if ($userId) {
            $cartData = json_encode($this->getGioHang());
            
            // Kiểm tra xem đã có bản ghi trong GIOHANG chưa
            $sqlCheck = "SELECT COUNT(*) FROM GIOHANG WHERE user_id = ?";
            $stmtCheck = $this->db->conn->prepare($sqlCheck);
            $stmtCheck->execute([$userId]);
            
            if ($stmtCheck->fetchColumn() > 0) {
                // Update
                $sqlUpdate = "UPDATE GIOHANG SET cart_data = ? WHERE user_id = ?";
                $stmtUpdate = $this->db->conn->prepare($sqlUpdate);
                $stmtUpdate->execute([$cartData, $userId]);
            } else {
                // Insert
                $sqlInsert = "INSERT INTO GIOHANG (user_id, cart_data) VALUES (?, ?)";
                $stmtInsert = $this->db->conn->prepare($sqlInsert);
                $stmtInsert->execute([$userId, $cartData]);
            }
        }
    }

    // Đồng bộ giỏ hàng sau khi đăng nhập thành công
    public function syncAfterLogin($userId) {
        $sql = "SELECT cart_data FROM GIOHANG WHERE user_id = ?";
        $stmt = $this->db->conn->prepare($sql);
        $stmt->execute([$userId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $dbCart = [];
        if ($result && !empty($result['cart_data'])) {
            $dbCart = json_decode($result['cart_data'], true) ?: [];
        }

        $sessionCart = $_SESSION['cart'] ?? [];

        if (empty($sessionCart)) {
            // Trường hợp 1: Session trống -> Lấy từ DB đổ vào Session
            $_SESSION['cart'] = $dbCart;
        } else {
            // Trường hợp 2: Session có đồ -> Merge (Session ưu tiên hoặc gộp số lượng)
            foreach ($sessionCart as $id => $item) {
                if (isset($dbCart[$id])) {
                    // Nếu trùng, cộng dồn số lượng
                    $dbCart[$id]['so_luong'] += $item['so_luong'];
                    // Lấy giá mới nhất từ session
                    $dbCart[$id]['gia'] = $item['gia'];
                } else {
                    // Thêm mới
                    $dbCart[$id] = $item;
                }
            }
            $_SESSION['cart'] = $dbCart;
            // Lưu ngược lại DB
            $this->saveCartToDB();
        }
    }

    // 2. Thêm sản phẩm vào giỏ hàng
    public function add($sp, $soLuong = 1) {
        $id = $sp['product_id'];

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['so_luong'] += $soLuong;
            $_SESSION['cart'][$id]['gia'] = (float)$sp['gia'];
        } else {
            $_SESSION['cart'][$id] = [
                'product_id' => $sp['product_id'],
                'ten'        => $sp['ten'],
                'gia'        => (float)$sp['gia'],
                'anh'        => $sp['anh'],
                'so_luong'   => $soLuong
            ];
        }
        $this->saveCartToDB();
    }

    // 3. Cập nhật số lượng sản phẩm
    public function updateQuantity($id, $soLuong) {
        if ($soLuong <= 0) {
            $this->deleteItem($id);
        } else if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['so_luong'] = $soLuong;
            $this->saveCartToDB();
        }
    }

    // 4. Xóa 1 sản phẩm khỏi giỏ hàng
    public function deleteItem($id) {
        if (isset($_SESSION['cart'][$id])) {
            unset($_SESSION['cart'][$id]);
            $this->saveCartToDB();
        }
    }

    // 5. Xóa toàn bộ giỏ hàng
    public function clear() {
        unset($_SESSION['cart']);
        $this->saveCartToDB(); // Khi clear thì DB cũng sẽ lưu thành mảng rỗng []
    }

    // 6. Tính tổng tiền giỏ hàng
    public function getTongTien() {
        $tongTien = 0;
        $gioHang = $this->getGioHang();
        foreach ($gioHang as $item) {
            $tongTien += $item['gia'] * $item['so_luong'];
        }
        return $tongTien;
    }

    // 7. Tính tổng số lượng sản phẩm trong giỏ hàng
    public function getTongSoLuong() {
        $tongSoLuong = 0;
        $gioHang = $this->getGioHang();
        foreach ($gioHang as $item) {
            $tongSoLuong += (int)($item['so_luong'] ?? 1);
        }
        return $tongSoLuong;
    }
}
