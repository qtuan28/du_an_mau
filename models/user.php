<?php
require_once 'models/db.php';

class User {
    private $db;

    public function __construct() {
        $this->db = new Database();
        $this->checkAndMigrate();
    }

    private function checkAndMigrate() {
        try {
            $this->db->conn->exec("ALTER TABLE USER ADD COLUMN trang_thai INT DEFAULT 1");
        } catch (PDOException $e) {}

        try {
            // Khởi tạo bảng VAITRO nếu trống
            $countStmt = $this->db->conn->query("SELECT COUNT(*) FROM VAITRO");
            if ($countStmt && $countStmt->fetchColumn() == 0) {
                $this->db->conn->exec("INSERT INTO VAITRO (vai_tro_id, ten_vai_tro) VALUES (1, 'Admin'), (2, 'Khách hàng')");
            }

            // Khởi tạo tài khoản mẫu nếu USER trống
            $countUser = $this->db->conn->query("SELECT COUNT(*) FROM USER");
            if ($countUser && $countUser->fetchColumn() == 0) {
                $this->db->conn->exec("INSERT INTO USER (user_id, vai_tro_id, username, password, email, address, trang_thai) VALUES
                    (1, 1, 'admin', '123456', 'admin@example.com', 'Hà Nội', 1),
                    (2, 2, 'user', '123456', 'user@example.com', 'Hồ Chí Minh', 1)");
            }
        } catch (PDOException $e) {}
    }


    // Lấy thông tin tài khoản theo username và password (không lọc trang_thai)
    public function getUserByUsernameAndPassword($username, $password) {
        $sql = "SELECT u.*, v.ten_vai_tro 
                FROM USER u 
                JOIN VAITRO v ON u.vai_tro_id = v.vai_tro_id 
                WHERE (u.username = :username OR u.email = :username) 
                  AND u.password = :password";
        $stmt = $this->db->conn->prepare($sql);
        $stmt->execute([
            'username' => $username,
            'password' => $password
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Kiểm tra đăng nhập (Chỉ cho phép tài khoản đang hoạt động trang_thai = 1 hoặc IS NULL)
    public function checkLogin($username, $password) {
        $sql = "SELECT u.*, v.ten_vai_tro 
                FROM USER u 
                JOIN VAITRO v ON u.vai_tro_id = v.vai_tro_id 
                WHERE (u.username = :username OR u.email = :username) 
                  AND u.password = :password 
                  AND (u.trang_thai = 1 OR u.trang_thai IS NULL)";
        $stmt = $this->db->conn->prepare($sql);
        $stmt->execute([
            'username' => $username,
            'password' => $password
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Đăng ký người dùng mới
    public function dangKy($username, $password, $email, $address) {
        $sql = "INSERT INTO USER (vai_tro_id, username, password, email, address, trang_thai) VALUES (2, ?, ?, ?, ?, 1)";
        $stmt = $this->db->conn->prepare($sql);
        return $stmt->execute([$username, $password, $email, $address]);
    }

    // 1. Lấy danh sách tất cả người dùng (Có hỗ trợ tìm kiếm theo từ khóa)
    public function getAllUsers($keyword = '') {
        if (!empty($keyword)) {
            $sql = "SELECT u.*, v.ten_vai_tro 
                    FROM USER u 
                    JOIN VAITRO v ON u.vai_tro_id = v.vai_tro_id 
                    WHERE u.username LIKE ? OR u.email LIKE ? OR u.address LIKE ? 
                    ORDER BY u.user_id DESC";
            $search = "%{$keyword}%";
            $stmt = $this->db->conn->prepare($sql);
            $stmt->execute([$search, $search, $search]);
        } else {
            $sql = "SELECT u.*, v.ten_vai_tro 
                    FROM USER u 
                    JOIN VAITRO v ON u.vai_tro_id = v.vai_tro_id 
                    ORDER BY u.user_id DESC";
            $stmt = $this->db->conn->query($sql);
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 2. Lấy thông tin 1 người dùng theo ID
    public function getUserById($userId) {
        $sql = "SELECT u.*, v.ten_vai_tro 
                FROM USER u 
                JOIN VAITRO v ON u.vai_tro_id = v.vai_tro_id 
                WHERE u.user_id = ?";
        $stmt = $this->db->conn->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function updateProfile($id, $email, $address){
        $sql = "UPDATE USER
                SET email = ?, address = ?
                WHERE user_id = ?";
        $stmt = $this->db->conn->prepare($sql);
        return $stmt->execute([$email, $address, $id]);
    }

    // 3. Thêm tài khoản người dùng mới (Admin)
    public function addUser($username, $password, $email, $address, $vai_tro_id = 2) {
        $sql = "INSERT INTO USER (username, password, email, address, vai_tro_id, trang_thai) VALUES (?, ?, ?, ?, ?, 1)";
        $stmt = $this->db->conn->prepare($sql);
        return $stmt->execute([$username, $password, $email, $address, $vai_tro_id]);
    }

    // 4. Sửa thông tin người dùng & Phân quyền (Admin)
    public function updateUser($userId, $email, $address, $vai_tro_id) {
        $sql = "UPDATE USER SET email = ?, address = ?, vai_tro_id = ? WHERE user_id = ?";
        $stmt = $this->db->conn->prepare($sql);
        return $stmt->execute([$email, $address, $vai_tro_id, $userId]);
    }

    // 5. Xóa tài khoản người dùng
    public function deleteUser($userId) {
        $sql = "DELETE FROM USER WHERE user_id = ?";
        $stmt = $this->db->conn->prepare($sql);
        return $stmt->execute([$userId]);
    }

    // 6. Khóa / Mở khóa tài khoản người dùng
    public function toggleStatus($userId, $targetStatus = null) {
        if ($targetStatus !== null) {
            $sql = "UPDATE USER SET trang_thai = ? WHERE user_id = ?";
            $stmt = $this->db->conn->prepare($sql);
            return $stmt->execute([(int)$targetStatus, (int)$userId]);
        } else {
            $sql = "UPDATE USER SET trang_thai = CASE WHEN trang_thai = 1 THEN 0 ELSE 1 END WHERE user_id = ?";
            $stmt = $this->db->conn->prepare($sql);
            return $stmt->execute([(int)$userId]);
        }
    }

    // 7. Đặt lại / Đổi mật khẩu người dùng
    public function resetPassword($userId, $newPassword) {
        $sql = "UPDATE USER SET password = ? WHERE user_id = ?";
        $stmt = $this->db->conn->prepare($sql);
        return $stmt->execute([$newPassword, $userId]);
    }

    // Lấy hồ sơ cá nhân người dùng
    public function getUserProfile($userId) {
        return $this->getUserById($userId);
    }

    // Lấy danh sách đơn hàng của người dùng
    public function getOrdersByUserId($userId) {
        $sql = "SELECT * FROM DONHANG WHERE user_id = ? ORDER BY don_hang_id DESC";
        $stmt = $this->db->conn->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

