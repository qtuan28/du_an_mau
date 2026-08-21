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
            $this->db->conn->exec("ALTER TABLE USER ADD COLUMN sdt VARCHAR(15) DEFAULT NULL");
        } catch (PDOException $e) {}

        try {
            $this->db->conn->exec("ALTER TABLE USER ADD COLUMN last_login DATETIME DEFAULT NULL");
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

    // Kiểm tra tên đăng nhập tồn tại
    public function checkUsernameExists($username) {
        $sql = "SELECT COUNT(*) FROM USER WHERE username = ?";
        $stmt = $this->db->conn->prepare($sql);
        $stmt->execute([$username]);
        return $stmt->fetchColumn() > 0;
    }

    // Kiểm tra email tồn tại
    public function checkEmailExists($email) {
        $sql = "SELECT COUNT(*) FROM USER WHERE email = ?";
        $stmt = $this->db->conn->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetchColumn() > 0;
    }

    // Đăng ký người dùng mới
    public function dangKy($username, $password, $email, $address, $sdt = '') {
        $sql = "INSERT INTO USER (vai_tro_id, username, password, email, address, sdt, trang_thai) VALUES (2, ?, ?, ?, ?, ?, 1)";
        $stmt = $this->db->conn->prepare($sql);
        return $stmt->execute([$username, $password, $email, $address, $sdt ?: null]);
    }

    // 1. Lấy danh sách người dùng (Có hỗ trợ tìm kiếm từ khóa & lọc theo vai trò)
    public function getAllUsers($keyword = '', $role = 'all') {
        $params = [];
        $where = [];

        if (!empty($keyword)) {
            $where[] = "(u.username LIKE ? OR u.email LIKE ? OR u.address LIKE ?)";
            $search = "%{$keyword}%";
            $params[] = $search;
            $params[] = $search;
            $params[] = $search;
        }

        if ($role === 'admin' || $role === '1') {
            $where[] = "u.vai_tro_id = 1";
        } elseif ($role === 'user' || $role === '2') {
            $where[] = "u.vai_tro_id != 1";
        }

        $whereClause = !empty($where) ? "WHERE " . implode(" AND ", $where) : "";

        $sql = "SELECT u.*, v.ten_vai_tro 
                FROM USER u 
                LEFT JOIN VAITRO v ON u.vai_tro_id = v.vai_tro_id 
                {$whereClause} 
                ORDER BY u.user_id DESC";

        $stmt = $this->db->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy số lượng tài khoản theo từng phân loại (Tất cả, Khách hàng, Quản trị viên)
    public function getUserCountsByRole($keyword = '') {
        return [
            'all' => count($this->getAllUsers($keyword, 'all')),
            'user' => count($this->getAllUsers($keyword, 'user')),
            'admin' => count($this->getAllUsers($keyword, 'admin'))
        ];
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
    public function updateProfile($id, $email, $address, $sdt = ''){
        $sql = "UPDATE USER
                SET email = ?, address = ?, sdt = ?
                WHERE user_id = ?";
        $stmt = $this->db->conn->prepare($sql);
        return $stmt->execute([$email, $address, $sdt ?: null, $id]);
    }

    // 3. Thêm tài khoản người dùng mới (Admin)
    public function addUser($username, $password, $email, $address, $vai_tro_id = 2, $sdt = '') {
        $sql = "INSERT INTO USER (username, password, email, address, sdt, vai_tro_id, trang_thai) VALUES (?, ?, ?, ?, ?, ?, 1)";
        $stmt = $this->db->conn->prepare($sql);
        return $stmt->execute([$username, $password, $email, $address, $sdt ?: null, $vai_tro_id]);
    }

    // 4. Sửa thông tin người dùng & Phân quyền (Admin)
    public function updateUser($userId, $email, $address, $vai_tro_id, $sdt = '') {
        $sql = "UPDATE USER SET email = ?, address = ?, sdt = ?, vai_tro_id = ? WHERE user_id = ?";
        $stmt = $this->db->conn->prepare($sql);
        return $stmt->execute([$email, $address, $sdt ?: null, $vai_tro_id, $userId]);
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

    // Lấy chi tiết lịch sử mua hàng của người dùng (Sản phẩm, giá, ngày, mã đơn, mã sp)
    public function getUserPurchaseHistory($userId) {
        $sql = "SELECT dh.ma_don_hang, dh.ngay_dat, dh.trang_thai, ct.ten_san_pham, ct.don_gia, ct.so_luong, ct.thanh_tien, p.ma_sp 
                FROM DONHANG dh
                JOIN CHITIETDONHANG ct ON dh.don_hang_id = ct.don_hang_id
                LEFT JOIN PRODUCTS p ON ct.product_id = p.product_id
                WHERE dh.user_id = ?
                ORDER BY dh.ngay_dat DESC";
        $stmt = $this->db->conn->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Cập nhật last_login sau khi đăng nhập thành công
    public function updateLastLogin($userId) {
        $sql = "UPDATE USER SET last_login = NOW() WHERE user_id = ?";
        $stmt = $this->db->conn->prepare($sql);
        return $stmt->execute([$userId]);
    }

    // Lấy danh sách tài khoản không hoạt động lâu (không đăng nhập trong X ngày)
    public function getInactiveUsers($days = 90) {
        $sql = "SELECT u.*, v.ten_vai_tro,
                    DATEDIFF(NOW(), u.last_login) AS so_ngay_khong_hoat_dong
                FROM USER u
                JOIN VAITRO v ON u.vai_tro_id = v.vai_tro_id
                WHERE u.last_login IS NULL 
                   OR u.last_login < DATE_SUB(NOW(), INTERVAL ? DAY)
                ORDER BY u.last_login ASC";
        $stmt = $this->db->conn->prepare($sql);
        $stmt->execute([$days]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Xác định trạng thái vòng đời của tài khoản dựa vào last_login và trang_thai.
     *
     * Luồng vòng đời:
     *   locked        => Admin đã chủ động khóa (trang_thai = 0)
     *   active        => 0 – 6 tháng (< 180 ngày)
     *   inactive      => 6 – 12 tháng (180 – 365 ngày)
     *   pending_review => 12 – 24 tháng (365 – 730 ngày)
     *   pending_delete => Trên 24 tháng (> 730 ngày) hoặc chưa đăng nhập bao giờ
     *
     * @param string|null $lastLogin  Giá trị cột last_login từ DB (datetime string hoặc null)
     * @param int         $trangThai  Giá trị cột trang_thai từ DB (1 = đang hoạt động, 0 = admin khóa)
     * @return string  Một trong: 'locked' | 'active' | 'inactive' | 'pending_review' | 'pending_delete'
     */
    public static function getAccountLifecycleStatus($lastLogin, $trangThai) {
        // Admin đã chủ động khóa tài khoản
        if ((int)$trangThai === 0) {
            return 'locked';
        }

        // Chưa đăng nhập bao giờ => coi như đã inactive từ lâu
        if (empty($lastLogin)) {
            return 'pending_delete';
        }

        $soNgay = (int)((time() - strtotime($lastLogin)) / 86400);

        if ($soNgay < 180) {        // < 6 tháng
            return 'active';
        } elseif ($soNgay < 365) {  // 6 – 12 tháng
            return 'inactive';
        } elseif ($soNgay < 730) {  // 12 – 24 tháng
            return 'pending_review';
        } else {                    // > 24 tháng
            return 'pending_delete';
        }
    }

    /**
     * Thống kê số lượng tài khoản theo từng mốc vòng đời.
     *
     * @param string $keyword Từ khóa tìm kiếm (nếu có)
     * @param string $role    Vai trò: 'all' | 'user' | 'admin'
     * @return array  ['active' => int, 'inactive' => int, 'pending_review' => int, 'pending_delete' => int, 'locked' => int]
     */
    public function getLifecycleCounts($keyword = '', $role = 'all') {
        $users = $this->getAllUsers($keyword, $role);
        $counts = [
            'active'         => 0,
            'inactive'       => 0,
            'pending_review' => 0,
            'pending_delete' => 0,
            'locked'         => 0,
        ];
        foreach ($users as $u) {
            $status = self::getAccountLifecycleStatus($u['last_login'] ?? null, $u['trang_thai'] ?? 1);
            if (isset($counts[$status])) {
                $counts[$status]++;
            }
        }
        return $counts;
    }

    /**
     * Lấy danh sách người dùng đã được lọc theo trạng thái vòng đời.
     *
     * @param string $lifecycleStatus  'active' | 'inactive' | 'pending_review' | 'pending_delete' | 'locked' | 'all'
     * @param string $keyword          Từ khóa tìm kiếm
     * @param string $role             Vai trò: 'all' | 'user' | 'admin'
     * @return array
     */
    public function getUsersByLifecycle($lifecycleStatus = 'all', $keyword = '', $role = 'all') {
        $users = $this->getAllUsers($keyword, $role);
        if ($lifecycleStatus === 'all') {
            return $users;
        }
        return array_values(array_filter($users, function($u) use ($lifecycleStatus) {
            return self::getAccountLifecycleStatus($u['last_login'] ?? null, $u['trang_thai'] ?? 1) === $lifecycleStatus;
        }));
    }
}

