<?php
require_once 'models/db.php';

class User {
    private $db;

    public function __construct() {
        $this->db = new Database();
        // Tự động bổ sung cột trang_thai nếu bảng USER trong MySQL chưa có
        try {
            $this->db->conn->exec("ALTER TABLE USER ADD COLUMN trang_thai INT DEFAULT 1");
        } catch (PDOException $e) {
            // Cột trang_thai đã tồn tại trong MySQL DB
        }
    }

    // Kiểm tra đăng nhập (Chỉ cho phép tài khoản đang hoạt động trang_thai = 1 hoặc IS NULL)
    public function checkLogin($username, $password) {
        $sql = "SELECT u.*, v.ten_vai_tro 
                FROM USER u 
                JOIN VAITRO v ON u.vai_tro_id = v.vai_tro_id 
                WHERE u.username = :username 
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
    public function toggleStatus($userId) {
        $sql = "UPDATE USER SET trang_thai = CASE WHEN trang_thai = 1 THEN 0 ELSE 1 END WHERE user_id = ?";
        $stmt = $this->db->conn->prepare($sql);
        return $stmt->execute([$userId]);
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
}
