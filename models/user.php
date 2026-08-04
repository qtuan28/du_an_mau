<?php
require_once 'models/db.php';

class User {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function checkLogin($username, $password) {
        $sql = "SELECT u.*, v.ten_vai_tro 
                FROM USER u 
                JOIN VAITRO v ON u.vai_tro_id = v.vai_tro_id 
                WHERE u.username = :username AND u.password = :password";
        $stmt = $this->db->conn->prepare($sql);
        $stmt->execute([
            'username' => $username,
            'password' => $password
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function dangKy($username, $password, $email, $address) {
        $sql = "INSERT INTO USER (vai_tro_id, username, password, email, address) VALUES (2, ?, ?, ?, ?)";
        $stmt = $this->db->conn->prepare($sql);
        return $stmt->execute([$username, $password, $email, $address]);
    }

    // [TỰ CODE] Lấy danh sách tất cả người dùng (Admin)
    public function getAllUsers() {
        // SQL code...
    }

    // [TỰ CODE] Xóa tài khoản người dùng theo ID (Admin)
    public function deleteUser($userId) {
        // SQL code...
    }

    // [TỰ CODE] Lấy hồ sơ cá nhân người dùng
    public function getUserProfile($userId) {
        // SQL code...
        $sql = "SELECT * FROM USER WHERE user_id = ?";
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
}
