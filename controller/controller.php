<?php
require_once 'models/user.php';
require_once 'models/sanpham.php';
require_once 'models/danhmuc.php';
require_once 'models/giohang.php';
require_once 'models/thongke.php';

class pickleballController {

    // Helper kiá»ƒm tra quyá»n Admin
    private function checkAdmin() {
        if (!isset($_SESSION['user']) || ($_SESSION['user']['vai_tro_id'] ?? 0) != 1) {
            header("HTTP/1.0 403 Forbidden");
            echo "<!DOCTYPE html><html lang='vi'><head><meta charset='UTF-8'><meta name='viewport' content='width=device-width, initial-scale=1.0'><title>403 - Tá»« chá»‘i truy cáº­p | Admin Panel</title><link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css'><link rel='stylesheet' href='assets/css/style.css'></head><body style='font-family: sans-serif; background: #f8f9fa; margin: 0;'>";
            require_once 'views/header.php';
            echo "<div style='display: flex; flex-direction: column; align-items: center; justify-content: center; min-height: 60vh; text-align: center; padding: 60px 20px;'>";
            echo "  <div style='width: 80px; height: 80px; background: #fef2f2; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-bottom: 24px; border: 2px solid #fee2e2;'>";
            echo "      <i class='fa-solid fa-user-lock' style='font-size: 36px; color: #e50010;'></i>";
            echo "  </div>";
            echo "  <span style='font-family: \"Oswald\", sans-serif; font-size: 14px; font-weight: 700; color: #e50010; letter-spacing: 2px; text-transform: uppercase; margin-bottom: 8px;'>Lá»–I 403 â€¢ FORBIDDEN</span>";
            echo "  <h1 style='font-family: \"Oswald\", sans-serif; font-size: 38px; font-weight: 700; color: #000; text-transform: uppercase; margin: 0 0 16px 0; letter-spacing: -0.5px;'>Tá»ª CHá»I TRUY Cáº¬P ADMIN</h1>";
            echo "  <p style='font-family: \"Roboto\", sans-serif; font-size: 15px; color: #666; max-width: 520px; line-height: 1.6; margin: 0 0 32px 0;'>TÃ i khoáº£n hiá»‡n táº¡i cá»§a báº¡n khÃ´ng cÃ³ Ä‘áº·c quyá»n Quáº£n trá»‹ viÃªn (Admin) Ä‘á»ƒ truy cáº­p vÃ o Báº£ng Ä‘iá»u khiá»ƒn nÃ y.</p>";
            echo "  <div style='display: flex; gap: 16px; flex-wrap: wrap; justify-content: center;'>";
            echo "      <a href='index.php' style='background: #000; color: #fff; font-family: \"Oswald\", sans-serif; font-size: 14px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; padding: 14px 28px; text-decoration: none; border: 1px solid #000; display: inline-flex; align-items: center; gap: 10px;'><i class='fa-solid fa-house'></i> Vá»€ TRANG CHá»¦</a>";
            echo "      <a href='index.php?act=login' style='background: #fff; color: #000; font-family: \"Oswald\", sans-serif; font-size: 14px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; padding: 14px 28px; text-decoration: none; border: 1px solid #000; display: inline-flex; align-items: center; gap: 10px;'><i class='fa-solid fa-right-to-bracket'></i> ÄÄ‚NG NHáº¬P ADMIN</a>";
            echo "  </div>";
            echo "</div>";
            require_once 'views/footer.php';
            echo "</body></html>";
            exit();
        }
    }

    // --- USE CASES: NGÆ¯á»œI DÃ™NG / KHÃCH ---

    public function trangChu() {
        $sanPhamModel = new SanPham();
        $dsSanPham = $sanPhamModel->getAll();
        require_once 'views/trangchu.php';
    }

    public function formLogin() {
        require_once 'views/login.php';
    }

    public function postLogin() {
        $username = trim($_POST['username'] ?? '');
        $password = trim($_POST['password'] ?? '');

        $userModel = new User();
        $user = $userModel->getUserByUsernameAndPassword($username, $password);

        if ($user) {
            if (isset($user['trang_thai']) && (int)$user['trang_thai'] === 0) {
                $error = "TÃ i khoáº£n '".$user['username']."' cá»§a báº¡n Ä‘Ã£ bá»‹ KHÃ“A bá»Ÿi Quáº£n trá»‹ viÃªn! Vui lÃ²ng liÃªn há»‡ bá»™ pháº­n há»— trá»£.";
                require_once 'views/login.php';
                return;
            }
            $_SESSION['user'] = $user;
            // Cáº­p nháº­t thá»i gian Ä‘Äƒng nháº­p cuá»‘i
            $userModel->updateLastLogin($user['user_id']);
            // Redirect vá» trang thanh toÃ¡n náº¿u user báº¥m thanh toÃ¡n khi chÆ°a Ä‘Äƒng nháº­p
            $redirect = $_GET['redirect'] ?? $_POST['redirect'] ?? '';
            if ($redirect === 'thanhtoan') {
                header("Location: index.php?act=thanhtoan");
            } else {
                header("Location: index.php");
            }
            exit();
        } else {
            $error = "TÃªn Ä‘Äƒng nháº­p hoáº·c máº­t kháº©u khÃ´ng chÃ­nh xÃ¡c!";
            require_once 'views/login.php';
        }
    }

    public function formRegister() {
        require_once 'views/register.php';
    }

    public function postRegister() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $password = trim($_POST['password'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $address = trim($_POST['address'] ?? '');
            $sdt = trim($_POST['sdt'] ?? '');

            if (!empty($username) && !empty($password) && !empty($email)) {
                // Kiá»ƒm tra Ä‘á»‹nh dáº¡ng Email chuáº©n vÃ  Ä‘uÃ´i tÃªn miá»n há»£p lá»‡ (@gmail.com, @yahoo.com, @fpt.edu.vn, ...)
                $emailPattern = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.(com|vn|net|org|edu|gov|io|co|me|info|biz|us|uk)$/i';
                if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !preg_match($emailPattern, $email)) {
                    $error = "Äá»‹a chá»‰ email khÃ´ng há»£p lá»‡! Vui lÃ²ng nháº­p email cÃ³ cáº¥u trÃºc vÃ  Ä‘uÃ´i tÃªn miá»n chuáº©n (VÃ­ dá»¥: @gmail.com, @yahoo.com, @fpt.edu.vn...).";
                    require_once 'views/register.php';
                    return;
                }

                // Kiá»ƒm tra sá»‘ Ä‘iá»‡n thoáº¡i náº¿u nháº­p
                if (!empty($sdt) && !preg_match('/^[0-9]{9,11}$/', $sdt)) {
                    $error = "Sá»‘ Ä‘iá»‡n thoáº¡i khÃ´ng há»£p lá»‡! Vui lÃ²ng nháº­p 9-11 chá»¯ sá»‘.";
                    require_once 'views/register.php';
                    return;
                }

                $userModel = new User();
                $userModel->dangKy($username, $password, $email, $address, $sdt);
                header("Location: index.php?act=login");
                exit();
            } else {
                $error = "Vui lÃ²ng nháº­p Ä‘áº§y Ä‘á»§ TÃªn Ä‘Äƒng nháº­p, Máº­t kháº©u vÃ  Email!";
                require_once 'views/register.php';
                return;
            }
        }
        header("Location: index.php?act=register");
        exit();
    }

    public function logout() {
        unset($_SESSION['user']);
        session_destroy();
        header("Location: index.php");
        exit();
    }

    public function chiTietSanPham() {
        $id = $_GET['id'] ?? 0;
        $sanPhamModel = new SanPham();
        $sp = $sanPhamModel->getById($id, true); // True checks if parent category is active

        if (!$sp) {
            header("HTTP/1.0 404 Not Found");
            echo "<!DOCTYPE html><html lang='vi'><head><meta charset='UTF-8'><title>Danh má»¥c hoáº·c sáº£n pháº©m khÃ´ng tá»“n táº¡i</title><link rel='stylesheet' href='assets/css/style.css'></head><body style='font-family: sans-serif; background: #f8f9fa; margin: 0;'>";
            require_once 'views/header.php';
            echo "<div style='text-align: center; padding: 120px 20px; min-height: 50vh;'>";
            echo "<h1 style='font-family: \"Oswald\", sans-serif; font-size: 36px; color: #000; text-transform: uppercase; margin-bottom: 16px;'>DANH Má»¤C HOáº¶C Sáº¢N PHáº¨M KHÃ”NG Tá»’N Táº I</h1>";
            echo "<p style='font-family: \"Roboto\", sans-serif; font-size: 16px; color: #666; max-width: 600px; margin: 0 auto 30px;'>Danh má»¥c sáº£n pháº©m nÃ y Ä‘Ã£ bá»‹ áº©n hoáº·c khÃ´ng tá»“n táº¡i trÃªn há»‡ thá»‘ng. Vui lÃ²ng tham kháº£o cÃ¡c sáº£n pháº©m khÃ¡c.</p>";
            echo "<a href='index.php?act=sanpham' style='display: inline-block; background: #000; color: #fff; font-family: \"Oswald\", sans-serif; font-size: 14px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; padding: 14px 28px; text-decoration: none;'>QUAY Láº I Cá»¬A HÃ€NG â†’</a>";
            echo "</div>";
            require_once 'views/footer.php';
            echo "</body></html>";
            exit();
        }
        require_once 'views/chitiet.php';
    }

    public function danhSachSanPham() {
        $keyword = trim($_GET['keyword'] ?? '');
        $categoryId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $priceRange = trim($_GET['price_range'] ?? '');
        $sort = trim($_GET['sort'] ?? 'newest');
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($page < 1) $page = 1;
        $limit = 16; // Má»—i trang 16 sáº£n pháº©m (4 dÃ²ng x 4 sáº£n pháº©m)

        $sanPhamModel = new SanPham();
        $danhMucModel = new DanhMuc();

        // Lá»c danh má»¥c náº¿u truy cáº­p trá»±c tiáº¿p báº±ng ID
        if ($categoryId > 0) {
            $currentCategory = $danhMucModel->getById($categoryId);
            if (!$currentCategory || (isset($currentCategory['trang_thai']) && (int)$currentCategory['trang_thai'] === 0)) {
                header("HTTP/1.0 404 Not Found");
                echo "<!DOCTYPE html><html lang='vi'><head><meta charset='UTF-8'><title>Danh má»¥c khÃ´ng tá»“n táº¡i</title><link rel='stylesheet' href='assets/css/style.css'></head><body style='font-family: sans-serif; background: #f8f9fa; margin: 0;'>";
                require_once 'views/header.php';
                echo "<div style='text-align: center; padding: 120px 20px; min-height: 50vh;'>";
                echo "<h1 style='font-family: \"Oswald\", sans-serif; font-size: 36px; color: #000; text-transform: uppercase; margin-bottom: 16px;'>DANH Má»¤C KHÃ”NG Tá»’N Táº I</h1>";
                echo "<p style='font-family: \"Roboto\", sans-serif; font-size: 16px; color: #666; max-width: 600px; margin: 0 auto 30px;'>Danh má»¥c sáº£n pháº©m nÃ y Ä‘Ã£ bá»‹ áº©n hoáº·c khÃ´ng cÃ²n tá»“n táº¡i trÃªn há»‡ thá»‘ng.</p>";
                echo "<a href='index.php?act=sanpham' style='display: inline-block; background: #000; color: #fff; font-family: \"Oswald\", sans-serif; font-size: 14px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; padding: 14px 28px; text-decoration: none;'>XEM Táº¤T Cáº¢ Sáº¢N PHáº¨M â†’</a>";
                echo "</div>";
                require_once 'views/footer.php';
                echo "</body></html>";
                exit();
            }
        }

        $allCategories = $danhMucModel->getAll();
        $dsDanhMuc = array_filter($allCategories, function($cat) {
            return !isset($cat['trang_thai']) || (int)$cat['trang_thai'] === 1;
        });

        $dsSanPham = $sanPhamModel->getAllWithPagination($keyword, $categoryId, 1, $page, $limit, $priceRange, $sort, true);
        $totalCount = $sanPhamModel->getTotalCount($keyword, $categoryId, 1, $priceRange, true);
        $totalPages = max(1, (int)ceil($totalCount / $limit));

        $currentCategory = null;
        if ($categoryId > 0) {
            $currentCategory = $danhMucModel->getById($categoryId);
        }

        require_once 'views/sanpham.php';
    }

    public function timKiemSanPham() {
        $this->danhSachSanPham();
    }

    public function xemDanhMuc() {
        $this->danhSachSanPham();
    }

    public function themGioHang() {
        $id = $_GET['id'] ?? 0;
        $soLuong = isset($_GET['soluong']) ? (int)$_GET['soluong'] : 1;
        if ($soLuong <= 0) $soLuong = 1;

        $gioHangModel = new GioHang();

        if ($id > 0) {
            $sanPhamModel = new SanPham();
            $sp = $sanPhamModel->getById($id);
            if ($sp) {
                $gioHangModel->add($sp, $soLuong);
            }
        }

        $totalItems = $gioHangModel->getTongSoLuong();
        $isAjax = isset($_GET['ajax']) || (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest');

        if ($isAjax) {
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode([
                'status' => 'success',
                'cart_count' => $totalItems,
                'message' => 'ÄÃ£ thÃªm sáº£n pháº©m vÃ o giá» hÃ ng!'
            ]);
            exit();
        }

        $redirect = $_GET['redirect'] ?? 'back';
        if ($redirect === 'thanhtoan') {
            header("Location: index.php?act=thanhtoan");
        } else if ($redirect === 'giohang') {
            header("Location: index.php?act=giohang");
        } else {
            $referer = $_SERVER['HTTP_REFERER'] ?? 'index.php?act=sanpham';
            header("Location: " . $referer);
        }
        exit();
    }

    public function xemGioHang() {
        $gioHangModel = new GioHang();
        $gioHang = $gioHangModel->getGioHang();
        $tongTien = $gioHangModel->getTongTien();
        require_once 'views/giohang.php';
    }

    public function capNhatGioHang() {
        if (isset($_POST['so_luong']) && is_array($_POST['so_luong'])) {
            $gioHangModel = new GioHang();
            foreach ($_POST['so_luong'] as $id => $qty) {
                $gioHangModel->updateQuantity((int)$id, (int)$qty);
            }
        }
        header("Location: index.php?act=giohang");
        exit();
    }

    public function xoaGioHang() {
        $id = $_GET['id'] ?? '';
        $gioHangModel = new GioHang();
        if ($id === 'all') {
            $gioHangModel->clear();
        } else if ($id > 0) {
            $gioHangModel->deleteItem((int)$id);
        }
        header("Location: index.php?act=giohang");
        exit();
    }

    public function thanhToan() {
        // YÃªu cáº§u Ä‘Äƒng nháº­p trÆ°á»›c khi thanh toÃ¡n
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?act=login&redirect=thanhtoan");
            exit();
        }
        require_once 'views/thanhtoan.php';
    }

    public function postThanhToan() {
        // YÃªu cáº§u Ä‘Äƒng nháº­p
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?act=login&redirect=thanhtoan");
            exit();
        }

        $gioHangModel = new GioHang();
        $gioHang = $gioHangModel->getGioHang();

        if (empty($gioHang)) {
            header("Location: index.php?act=giohang");
            exit();
        }

        $userId = $_SESSION['user']['user_id'] ?? 0;
        // Láº¥y thÃ´ng tin tá»« form POST (cÃ³ thá»ƒ Ä‘iá»n sáºµn tá»« session)
        $hoTen   = trim($_POST['ho_ten']  ?? ($_SESSION['user']['username'] ?? 'KhÃ¡ch hÃ ng'));
        $email   = trim($_POST['email']   ?? ($_SESSION['user']['email']    ?? ''));
        $sdt     = trim($_POST['sdt']     ?? ($_SESSION['user']['sdt']      ?? ''));
        $diaChi  = trim($_POST['address'] ?? ($_SESSION['user']['address']  ?? 'ChÆ°a cáº­p nháº­t'));
        $tongTien = $gioHangModel->getTongTien();

        $db = new Database();
        
        // Sinh mÃ£ Ä‘Æ¡n hÃ ng
        $maDonHang = 'DH-' . date('ymd') . '-' . strtoupper(substr(uniqid(), -4));

        $sqlDon = "INSERT INTO DONHANG (ma_don_hang, user_id, ho_ten, sdt, email, dia_chi, tong_tien, trang_thai, ngay_dat) 
                   VALUES (?, ?, ?, ?, ?, ?, ?, 'ÄÃ£ giao', NOW())";

        $stmt = $db->conn->prepare($sqlDon);
        $stmt->execute([$maDonHang, $userId, $hoTen, $sdt, $email, $diaChi, $tongTien]);
        $donHangId = $db->conn->lastInsertId();

        $sqlChiTiet = "INSERT INTO CHITIETDONHANG (don_hang_id, product_id, ten_san_pham, don_gia, so_luong, thanh_tien) 
                       VALUES (?, ?, ?, ?, ?, ?)";
        $stmtCT = $db->conn->prepare($sqlChiTiet);

        $sanPhamModel = new SanPham();

        foreach ($gioHang as $item) {
            $thanhTien = $item['gia'] * $item['so_luong'];
            $stmtCT->execute([$donHangId, $item['product_id'], $item['ten'], $item['gia'], $item['so_luong'], $thanhTien]);
            
            // Trá»« sá»‘ lÆ°á»£ng kho vÃ  ghi lá»‹ch sá»­
            $sanPhamModel->updateStock($item['product_id'], -$item['so_luong'], 'ban_hang', "ÄÆ¡n hÃ ng $maDonHang");
        }

        $gioHangModel->clear();

        header("Location: index.php?act=profile");
        exit();
    }

    public function hoSoCaNhan() {
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?act=login");
            exit();
        }
        $userModel = new User();
        $user = $userModel->getUserProfile($_SESSION['user']['user_id']);
        $orders = $userModel->getOrdersByUserId($_SESSION['user']['user_id']);

        $msg = $_SESSION['profile_msg'] ?? null;
        $msg_type = $_SESSION['profile_msg_type'] ?? 'success';
        unset($_SESSION['profile_msg'], $_SESSION['profile_msg_type']);

        require_once 'views/profile.php';
    }

    public function capNhatHoSo() {
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?act=login");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_SESSION['user']['user_id'];
            $email = trim($_POST['email'] ?? '');
            $address = trim($_POST['address'] ?? '');
            $sdt = trim($_POST['sdt'] ?? '');

            if (empty($email)) {
                $_SESSION['profile_msg'] = "Email khÃ´ng Ä‘Æ°á»£c Ä‘á»ƒ trá»‘ng!";
                $_SESSION['profile_msg_type'] = "error";
                header("Location: index.php?act=profile#thong-tin");
                exit();
            }

            $userModel = new User();
            $userModel->updateProfile($id, $email, $address, $sdt);

            // Cáº­p nháº­t láº¡i session
            $_SESSION['user']['email'] = $email;
            $_SESSION['user']['address'] = $address;
            $_SESSION['user']['sdt'] = $sdt;
            $_SESSION['profile_msg'] = "Cáº­p nháº­t thÃ´ng tin cÃ¡ nhÃ¢n thÃ nh cÃ´ng!";
            $_SESSION['profile_msg_type'] = "success";
        }

        header("Location: index.php?act=profile#thong-tin");
        exit();
    }

    public function doiMatKhau() {
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?act=login");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_SESSION['user']['user_id'];
            $oldPass = $_POST['old_password'] ?? '';
            $newPass = $_POST['new_password'] ?? '';
            $confirmPass = $_POST['confirm_password'] ?? '';

            if (empty($oldPass) || empty($newPass) || empty($confirmPass)) {
                $_SESSION['profile_msg'] = "Vui lÃ²ng nháº­p Ä‘áº§y Ä‘á»§ táº¥t cáº£ cÃ¡c trÆ°á»ng máº­t kháº©u!";
                $_SESSION['profile_msg_type'] = "error";
                header("Location: index.php?act=profile#doi-mat-khau");
                exit();
            }

            $userModel = new User();
            $currentUser = $userModel->getUserById($userId);

            // Kiá»ƒm tra máº­t kháº©u hiá»‡n táº¡i vá»›i máº­t kháº©u lÆ°u trong CSDL
            if (!$currentUser || $currentUser['password'] !== $oldPass) {
                $_SESSION['profile_msg'] = "Máº­t kháº©u hiá»‡n táº¡i khÃ´ng chÃ­nh xÃ¡c! Máº­t kháº©u má»›i KHÃ”NG Ä‘Æ°á»£c cáº­p nháº­t.";
                $_SESSION['profile_msg_type'] = "error";
                header("Location: index.php?act=profile#doi-mat-khau");
                exit();
            }

            if (strlen($newPass) < 6) {
                $_SESSION['profile_msg'] = "Máº­t kháº©u má»›i pháº£i cÃ³ Ã­t nháº¥t 6 kÃ½ tá»±!";
                $_SESSION['profile_msg_type'] = "error";
                header("Location: index.php?act=profile#doi-mat-khau");
                exit();
            }

            if ($newPass !== $confirmPass) {
                $_SESSION['profile_msg'] = "Máº­t kháº©u xÃ¡c nháº­n khÃ´ng khá»›p vá»›i máº­t kháº©u má»›i!";
                $_SESSION['profile_msg_type'] = "error";
                header("Location: index.php?act=profile#doi-mat-khau");
                exit();
            }

            if ($oldPass === $newPass) {
                $_SESSION['profile_msg'] = "Máº­t kháº©u má»›i khÃ´ng Ä‘Æ°á»£c trÃ¹ng vá»›i máº­t kháº©u cÅ©!";
                $_SESSION['profile_msg_type'] = "error";
                header("Location: index.php?act=profile#doi-mat-khau");
                exit();
            }

            // Thá»±c hiá»‡n Ä‘á»•i máº­t kháº©u trong DB chá»‰ khi máº­t kháº©u hiá»‡n táº¡i ÄÃšNG
            $userModel->resetPassword($userId, $newPass);
            $_SESSION['user']['password'] = $newPass;

            $_SESSION['profile_msg'] = "Äá»•i máº­t kháº©u thÃ nh cÃ´ng!";
            $_SESSION['profile_msg_type'] = "success";
            header("Location: index.php?act=profile#doi-mat-khau");
            exit();
        }

        header("Location: index.php?act=profile");
        exit();
    }


    // --- USE CASES: ADMIN (Báº¢O Máº¬T Bá»žI checkAdmin) ---

    public function trangAdmin() {
        $this->checkAdmin();
        require_once 'models/thongke.php';
        $thongKeModel = new ThongKe();

        $tkSanPham = $thongKeModel->thongKeSanPham();
        $tkKhachHang = $thongKeModel->thongKeKhachHang();
        $tkDonHang = $thongKeModel->thongKeDonHang();
        $tkTonKho = $thongKeModel->thongKeTonKho();

        $countSanPham = $tkSanPham['tong_san_pham'] ?? 0;
        $countKhachHang = $tkKhachHang['tong_khach_hang'] ?? 0;
        $countDonHang = $tkDonHang['tong_don_hang'] ?? 0;
        $tongTonKho = $tkTonKho['tong_ton_kho'] ?? 0;

        require_once 'views/admin.php';
    }

    // 1. Quáº£n lÃ½ danh má»¥c
    public function adminQuanLyDanhMuc()
    {
        $this->checkAdmin();
        $danhMucModel = new DanhMuc();

        $keyword = trim($_GET['keyword'] ?? '');
        if ($keyword !== '') {
            $dsDanhMuc = $danhMucModel->search($keyword);
        } else {
            $dsDanhMuc = $danhMucModel->getAll();
        }

        require_once 'views/admin/danhmuc.php';
    }

    // Hiá»ƒn thá»‹ Form ThÃªm Danh má»¥c (Form riÃªng)
    public function adminFormThemDanhMuc()
    {
        $this->checkAdmin();
        $mode = 'add';
        $danhMuc = [
            'name' => '',
            'trang_thai' => 1
        ];
        require_once 'views/admin/danhmuc_form.php';
    }

    // Xá»­ lÃ½ ThÃªm Danh má»¥c
    public function adminThemDanhMuc()
    {
        $this->checkAdmin();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = trim($_POST['name'] ?? '');
            $trang_thai = isset($_POST['trang_thai']) ? (int)$_POST['trang_thai'] : 1;
            $thong_so_loai = trim($_POST['thong_so_loai'] ?? 'do_day_vot');

            $danhMucModel = new DanhMuc();

            if ($name == "") {
                $_SESSION['error'] = "TÃªn danh má»¥c khÃ´ng Ä‘Æ°á»£c Ä‘á»ƒ trá»‘ng!";
                header("Location: index.php?act=admin_danhmuc_add_form");
                exit();
            } elseif ($danhMucModel->checkExists($name)) {
                $_SESSION['error'] = "Danh má»¥c '".$name."' Ä‘Ã£ tá»“n táº¡i!";
                header("Location: index.php?act=admin_danhmuc_add_form");
                exit();
            } else {
                $danhMucModel->add($name, $trang_thai, $thong_so_loai);
                $_SESSION['success'] = "ThÃªm danh má»¥c '".$name."' thÃ nh cÃ´ng!";
            }
        }

        header("Location: index.php?act=admin_danhmuc");
        exit();
    }

    // Hiá»ƒn thá»‹ Form Sá»­a Danh má»¥c (Form riÃªng)
    public function adminFormSuaDanhMuc()
    {
        $this->checkAdmin();
        $id = $_GET['id'] ?? 0;

        $danhMucModel = new DanhMuc();
        $danhMuc = $danhMucModel->getById($id);

        if (!$danhMuc) {
            $_SESSION['error'] = "Danh má»¥c khÃ´ng tá»“n táº¡i!";
            header("Location: index.php?act=admin_danhmuc");
            exit();
        }

        $mode = 'edit';
        require_once 'views/admin/danhmuc_form.php';
    }

    // Xá»­ lÃ½ Sá»­a Danh má»¥c
    public function adminSuaDanhMuc()
    {
        $this->checkAdmin();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['category_id'] ?? 0;
            $name = trim($_POST['name'] ?? '');
            $trang_thai = isset($_POST['trang_thai']) ? (int)$_POST['trang_thai'] : 1;
            $thong_so_loai = trim($_POST['thong_so_loai'] ?? 'do_day_vot');

            $danhMucModel = new DanhMuc();

            if ($name == "") {
                $_SESSION['error'] = "TÃªn danh má»¥c khÃ´ng Ä‘Æ°á»£c Ä‘á»ƒ trá»‘ng!";
                header("Location: index.php?act=admin_danhmuc_edit_form&id=" . $id);
                exit();
            } elseif ($danhMucModel->checkExists($name, $id)) {
                $_SESSION['error'] = "TÃªn danh má»¥c '".$name."' Ä‘Ã£ trÃ¹ng vá»›i danh má»¥c khÃ¡c!";
                header("Location: index.php?act=admin_danhmuc_edit_form&id=" . $id);
                exit();
            } else {
                $danhMucModel->update($id, $name, $trang_thai, $thong_so_loai);
                $_SESSION['success'] = "Cáº­p nháº­t danh má»¥c thÃ nh cÃ´ng!";
            }
        }

        header("Location: index.php?act=admin_danhmuc");
        exit();
    }

    // Äá»•i tráº¡ng thÃ¡i danh má»¥c nhanh
    public function adminToggleTrangThaiDanhMuc()
    {
        $this->checkAdmin();
        $id = $_GET['id'] ?? 0;

        if ($id > 0) {
            $danhMucModel = new DanhMuc();
            $danhMucModel->toggleStatus($id);
            $_SESSION['success'] = "ÄÃ£ cáº­p nháº­t tráº¡ng thÃ¡i danh má»¥c!";
        }

        header("Location: index.php?act=admin_danhmuc");
        exit();
    }

    // XÃ³a danh má»¥c
    public function adminXoaDanhMuc()
    {
        $this->checkAdmin();

        if (isset($_GET['id'])) {
            $danhMucModel = new DanhMuc();
            $danhMucModel->delete($_GET['id']);
            $_SESSION['success'] = "ÄÃ£ xÃ³a danh má»¥c thÃ nh cÃ´ng!";
        }

        header("Location: index.php?act=admin_danhmuc");
        exit();
    }

    // TÃ¬m kiáº¿m danh má»¥c
    public function adminTimKiemDanhMuc() {
        $this->adminQuanLyDanhMuc();
    }

    // 2. Quáº£n lÃ½ sáº£n pháº©m
    public function adminQuanLySanPham() {
        $this->checkAdmin();

        $keyword = trim($_GET['keyword'] ?? '');
        $stockStatus = isset($_GET['trang_thai']) && $_GET['trang_thai'] !== '' ? $_GET['trang_thai'] : '';
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($page < 1) $page = 1;
        $limit = 5; // Sá»‘ sáº£n pháº©m hiá»ƒn thá»‹ trÃªn 1 trang

        $sanPhamModel = new SanPham();
        $totalCount = $sanPhamModel->getTotalCount($keyword, 0, $stockStatus);
        $totalPages = ceil($totalCount / $limit);
        if ($totalPages < 1) $totalPages = 1;
        if ($page > $totalPages) $page = $totalPages;

        $dsSanPham = $sanPhamModel->getAllWithPagination($keyword, 0, $stockStatus, $page, $limit);

        require_once 'views/admin/sanpham.php';
    }

    // Lá»‹ch sá»­ tá»“n kho cá»§a má»™t sáº£n pháº©m
    public function adminLichSuKho() {
        $this->checkAdmin();
        $id = (int)($_GET['id'] ?? 0);
        
        $sanPhamModel = new SanPham();
        $sanPham = $sanPhamModel->getById($id);
        
        if (!$sanPham) {
            $_SESSION['error'] = "Sáº£n pháº©m khÃ´ng tá»“n táº¡i!";
            header("Location: index.php?act=admin_sanpham");
            exit();
        }
        
        $lichSu = $sanPhamModel->getInventoryHistory($id);
        
        require_once 'views/admin/lichsu_kho.php';
    }

    // Hiá»ƒn thá»‹ Form ThÃªm sáº£n pháº©m (Form riÃªng)
    public function adminFormThemSanPham() {
        $this->checkAdmin();
        $danhMucModel = new DanhMuc();
        $dsDanhMuc = $danhMucModel->getAll();

        $mode = 'add';
        $sanPham = [
            'ten' => '',
            'category_id' => 0,
            'gia' => '',
            'giam_gia' => 0,
            'trang_thai' => 1,
            'anh' => '',
            'bien_the' => ''
        ];

        require_once 'views/admin/sanpham_form.php';
    }

    // Xá»­ lÃ½ ThÃªm sáº£n pháº©m
    public function adminThemSanPham() {
        $this->checkAdmin();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $ten = trim($_POST['ten'] ?? '');
            $ma_sp = trim($_POST['ma_sp'] ?? '');
            $so_luong_nhap = (int)($_POST['so_luong_nhap'] ?? 0);
            $category_id = (int)($_POST['category_id'] ?? 0);
            $gia = (float)($_POST['gia'] ?? 0);
            $giam_gia = (int)($_POST['giam_gia'] ?? 0);
            $trang_thai = (int)($_POST['trang_thai'] ?? 1);

            if ($ten == "" || $category_id == 0 || $gia <= 0) {
                $_SESSION['error'] = "Vui lÃ²ng nháº­p Ä‘áº§y Ä‘á»§ thÃ´ng tin TÃªn sáº£n pháº©m, Danh má»¥c vÃ  GiÃ¡!";
                header("Location: index.php?act=admin_sanpham_add_form");
                exit();
            }

            // Xá»­ lÃ½ Upload áº¢nh chÃ­nh & 4 áº£nh chi tiáº¿t
            $target_dir = "uploads/";
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true);
            }

            $anh = '';
            if (isset($_FILES['anh']) && $_FILES['anh']['error'] == 0) {
                $filename = time() . '_' . basename($_FILES['anh']['name']);
                if (move_uploaded_file($_FILES['anh']['tmp_name'], $target_dir . $filename)) {
                    $anh = $filename;
                }
            }

            $anh_1 = '';
            if (isset($_FILES['anh_1']) && $_FILES['anh_1']['error'] == 0) {
                $filename = time() . '_1_' . basename($_FILES['anh_1']['name']);
                if (move_uploaded_file($_FILES['anh_1']['tmp_name'], $target_dir . $filename)) {
                    $anh_1 = $filename;
                }
            }

            $anh_2 = '';
            if (isset($_FILES['anh_2']) && $_FILES['anh_2']['error'] == 0) {
                $filename = time() . '_2_' . basename($_FILES['anh_2']['name']);
                if (move_uploaded_file($_FILES['anh_2']['tmp_name'], $target_dir . $filename)) {
                    $anh_2 = $filename;
                }
            }

            $anh_3 = '';
            if (isset($_FILES['anh_3']) && $_FILES['anh_3']['error'] == 0) {
                $filename = time() . '_3_' . basename($_FILES['anh_3']['name']);
                if (move_uploaded_file($_FILES['anh_3']['tmp_name'], $target_dir . $filename)) {
                    $anh_3 = $filename;
                }
            }

            $anh_4 = '';
            if (isset($_FILES['anh_4']) && $_FILES['anh_4']['error'] == 0) {
                $filename = time() . '_4_' . basename($_FILES['anh_4']['name']);
                if (move_uploaded_file($_FILES['anh_4']['tmp_name'], $target_dir . $filename)) {
                    $anh_4 = $filename;
                }
            }

            $specData = [
                'chat_lieu' => trim($_POST['spec_chat_lieu'] ?? ''),
                'do_day_loi' => (float)($_POST['spec_do_day_loi'] ?? 0),
                'loai_tay_cam' => trim($_POST['spec_loai_tay_cam'] ?? ''),
                'chieu_dai' => (float)($_POST['spec_chieu_dai'] ?? 0),
                'chieu_rong' => (float)($_POST['spec_chieu_rong'] ?? 0),
                'chieu_dai_tay_cam' => (float)($_POST['spec_chieu_dai_tay_cam'] ?? 0),
                'chu_vi_tay_cam' => (float)($_POST['spec_chu_vi_tay_cam'] ?? 0),
                'trong_luong' => (float)($_POST['spec_trong_luong'] ?? 0),
                'chung_nhan' => trim($_POST['spec_chung_nhan'] ?? ''),
                'kich_thuoc' => trim($_POST['spec_kich_thuoc'] ?? '')
            ];

            $sanPhamModel = new SanPham();
            $productId = $sanPhamModel->add([
                'ma_sp' => $ma_sp,
                'so_luong' => $so_luong_nhap,
                'category_id' => $category_id,
                'ten' => $ten,
                'gia' => $gia,
                'giam_gia' => $giam_gia,
                'trang_thai' => $trang_thai,
                'anh' => $anh,
                'anh_1' => $anh_1,
                'anh_2' => $anh_2,
                'anh_3' => $anh_3,
                'anh_4' => $anh_4,
                'bien_the' => trim($_POST['bien_the'] ?? ''),
                'spec' => $specData
            ]);

            if ($productId > 0 && $so_luong_nhap > 0) {
                $sanPhamModel->updateStock($productId, $so_luong_nhap, 'nhap_hang', 'Nháº­p kho ban Ä‘áº§u');
            }

            $_SESSION['success'] = "ThÃªm sáº£n pháº©m '".$ten."' thÃ nh cÃ´ng!";
        }

        header("Location: index.php?act=admin_sanpham");
        exit();
    }

    // Hiá»ƒn thá»‹ Form Sá»­a sáº£n pháº©m (Form riÃªng)
    public function adminFormSuaSanPham() {
        $this->checkAdmin();
        $id = $_GET['id'] ?? 0;

        $sanPhamModel = new SanPham();
        $sanPham = $sanPhamModel->getById($id);

        if (!$sanPham) {
            $_SESSION['error'] = "Sáº£n pháº©m khÃ´ng tá»“n táº¡i!";
            header("Location: index.php?act=admin_sanpham");
            exit();
        }

        $danhMucModel = new DanhMuc();
        $dsDanhMuc = $danhMucModel->getAll();

        $mode = 'edit';
        require_once 'views/admin/sanpham_form.php';
    }

    // Xá»­ lÃ½ Sá»­a sáº£n pháº©m
    public function adminSuaSanPham() {
        $this->checkAdmin();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = (int)($_POST['product_id'] ?? 0);
            $ten = trim($_POST['ten'] ?? '');
            $ma_sp = trim($_POST['ma_sp'] ?? '');
            $so_luong_nhap = (int)($_POST['so_luong_nhap'] ?? 0);
            $category_id = (int)($_POST['category_id'] ?? 0);
            $gia = (float)($_POST['gia'] ?? 0);
            $giam_gia = (int)($_POST['giam_gia'] ?? 0);
            $trang_thai = (int)($_POST['trang_thai'] ?? 1);
            $old_anh = $_POST['old_anh'] ?? '';
            $old_anh_1 = $_POST['old_anh_1'] ?? '';
            $old_anh_2 = $_POST['old_anh_2'] ?? '';
            $old_anh_3 = $_POST['old_anh_3'] ?? '';
            $old_anh_4 = $_POST['old_anh_4'] ?? '';

            if ($ten == "" || $category_id == 0 || $gia <= 0) {
                $_SESSION['error'] = "Vui lÃ²ng nháº­p Ä‘áº§y Ä‘á»§ thÃ´ng tin TÃªn sáº£n pháº©m, Danh má»¥c vÃ  GiÃ¡!";
                header("Location: index.php?act=admin_sanpham_edit_form&id=" . $id);
                exit();
            }

            $target_dir = "uploads/";
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true);
            }

            // Xá»­ lÃ½ upload áº£nh má»›i náº¿u chá»n
            $anh = $old_anh;
            if (isset($_FILES['anh']) && $_FILES['anh']['error'] == 0) {
                $filename = time() . '_' . basename($_FILES['anh']['name']);
                if (move_uploaded_file($_FILES['anh']['tmp_name'], $target_dir . $filename)) {
                    $anh = $filename;
                }
            }

            $anh_1 = $old_anh_1;
            if (isset($_FILES['anh_1']) && $_FILES['anh_1']['error'] == 0) {
                $filename = time() . '_1_' . basename($_FILES['anh_1']['name']);
                if (move_uploaded_file($_FILES['anh_1']['tmp_name'], $target_dir . $filename)) {
                    $anh_1 = $filename;
                }
            }

            $anh_2 = $old_anh_2;
            if (isset($_FILES['anh_2']) && $_FILES['anh_2']['error'] == 0) {
                $filename = time() . '_2_' . basename($_FILES['anh_2']['name']);
                if (move_uploaded_file($_FILES['anh_2']['tmp_name'], $target_dir . $filename)) {
                    $anh_2 = $filename;
                }
            }

            $anh_3 = $old_anh_3;
            if (isset($_FILES['anh_3']) && $_FILES['anh_3']['error'] == 0) {
                $filename = time() . '_3_' . basename($_FILES['anh_3']['name']);
                if (move_uploaded_file($_FILES['anh_3']['tmp_name'], $target_dir . $filename)) {
                    $anh_3 = $filename;
                }
            }

            $anh_4 = $old_anh_4;
            if (isset($_FILES['anh_4']) && $_FILES['anh_4']['error'] == 0) {
                $filename = time() . '_4_' . basename($_FILES['anh_4']['name']);
                if (move_uploaded_file($_FILES['anh_4']['tmp_name'], $target_dir . $filename)) {
                    $anh_4 = $filename;
                }
            }

            $specData = [
                'chat_lieu' => trim($_POST['spec_chat_lieu'] ?? ''),
                'do_day_loi' => (float)($_POST['spec_do_day_loi'] ?? 0),
                'loai_tay_cam' => trim($_POST['spec_loai_tay_cam'] ?? ''),
                'chieu_dai' => (float)($_POST['spec_chieu_dai'] ?? 0),
                'chieu_rong' => (float)($_POST['spec_chieu_rong'] ?? 0),
                'chieu_dai_tay_cam' => (float)($_POST['spec_chieu_dai_tay_cam'] ?? 0),
                'chu_vi_tay_cam' => (float)($_POST['spec_chu_vi_tay_cam'] ?? 0),
                'trong_luong' => (float)($_POST['spec_trong_luong'] ?? 0),
                'chung_nhan' => trim($_POST['spec_chung_nhan'] ?? ''),
                'kich_thuoc' => trim($_POST['spec_kich_thuoc'] ?? '')
            ];

            $sanPhamModel = new SanPham();
            $sanPhamModel->update($id, [
                'ma_sp' => $ma_sp,
                'category_id' => $category_id,
                'ten' => $ten,
                'gia' => $gia,
                'giam_gia' => $giam_gia,
                'trang_thai' => $trang_thai,
                'anh' => $anh,
                'anh_1' => $anh_1,
                'anh_2' => $anh_2,
                'anh_3' => $anh_3,
                'anh_4' => $anh_4,
                'bien_the' => trim($_POST['bien_the'] ?? ''),
                'spec' => $specData
            ]);

            if ($so_luong_nhap > 0) {
                $sanPhamModel->updateStock($id, $so_luong_nhap, 'nhap_hang', 'Nháº­p kho thÃªm');
            }

            $_SESSION['success'] = "Cáº­p nháº­t sáº£n pháº©m thÃ nh cÃ´ng!";
        }

        header("Location: index.php?act=admin_sanpham");
        exit();
    }

    // Äá»•i nhanh tráº¡ng thÃ¡i CÃ²n hÃ ng / Háº¿t hÃ ng
    public function adminToggleTrangThaiSanPham() {
        $this->checkAdmin();
        $id = $_GET['id'] ?? 0;

        if ($id > 0) {
            $sanPhamModel = new SanPham();
            $sanPhamModel->toggleStockStatus($id);
            $_SESSION['success'] = "ÄÃ£ Ä‘á»•i tráº¡ng thÃ¡i sáº£n pháº©m!";
        }

        header("Location: index.php?act=admin_sanpham");
        exit();
    }

    // XÃ³a sáº£n pháº©m
    public function adminXoaSanPham() {
        $this->checkAdmin();
        $id = $_GET['id'] ?? 0;

        if ($id > 0) {
            $sanPhamModel = new SanPham();
            $sanPhamModel->delete($id);
            $_SESSION['success'] = "ÄÃ£ xÃ³a sáº£n pháº©m thÃ nh cÃ´ng!";
        }

        header("Location: index.php?act=admin_sanpham");
        exit();
    }

    // TÃ¬m kiáº¿m sáº£n pháº©m
    public function adminTimKiemSanPham() {
        $this->adminQuanLySanPham();
    }

    // 3. Quáº£n lÃ½ ngÆ°á»i dÃ¹ng
    public function adminQuanLyNguoiDung() {
        $this->checkAdmin();
        $keyword = $_GET['keyword'] ?? '';
        $userModel = new User();
        $dsNguoiDung = $userModel->getAllUsers($keyword);
        require_once 'views/admin/nguoidung.php';
    }

    public function adminThemNguoiDung() {
        $this->checkAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            $email = $_POST['email'] ?? '';
            $address = $_POST['address'] ?? '';
            $sdt = trim($_POST['sdt'] ?? '');
            $vai_tro_id = $_POST['vai_tro_id'] ?? 2;

            if (!empty($username) && !empty($password)) {
                $userModel = new User();
                $userModel->addUser($username, $password, $email, $address, $vai_tro_id, $sdt);
            }
            header("Location: index.php?act=admin_nguoidung");
            exit();
        }
        $mode = 'add';
        require_once 'views/admin/nguoidung_form.php';
    }

    public function adminSuaNguoiDung() {
        $this->checkAdmin();
        $userModel = new User();
        $id = $_GET['id'] ?? 0;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['user_id'] ?? 0;
            $email = $_POST['email'] ?? '';
            $address = $_POST['address'] ?? '';
            $sdt = trim($_POST['sdt'] ?? '');
            $vai_tro_id = $_POST['vai_tro_id'] ?? 2;

            $userModel->updateUser($id, $email, $address, $vai_tro_id, $sdt);
            header("Location: index.php?act=admin_nguoidung");
            exit();
        }

        $user = $userModel->getUserById($id);
        if (!$user) {
            header("Location: index.php?act=admin_nguoidung");
            exit();
        }
        $mode = 'edit';
        require_once 'views/admin/nguoidung_form.php';
    }

    public function adminXoaNguoiDung() {
        $this->checkAdmin();
        $id = $_GET['id'] ?? 0;
        if ($id > 0) {
            // KhÃ´ng cho phÃ©p Admin tá»± xÃ³a tÃ i khoáº£n cá»§a chÃ­nh mÃ¬nh
            if ($id != $_SESSION['user']['user_id']) {
                $userModel = new User();
                $userModel->deleteUser($id);
            }
        }
        header("Location: index.php?act=admin_nguoidung");
        exit();
    }

    public function adminKhoaNguoiDung() {
        $this->checkAdmin();
        $id = $_GET['id'] ?? 0;
        if ($id > 0) {
            // KhÃ´ng cho phÃ©p Admin tá»± khÃ³a tÃ i khoáº£n cá»§a chÃ­nh mÃ¬nh
            if ($id != $_SESSION['user']['user_id']) {
                $userModel = new User();
                $userModel->toggleStatus($id);
            }
        }
        header("Location: index.php?act=admin_nguoidung");
        exit();
    }

    public function adminDatLaiMatKhau() {
        $this->checkAdmin();
        $userModel = new User();
        $id = $_GET['id'] ?? 0;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['user_id'] ?? 0;
            $new_password = $_POST['new_password'] ?? '';
            if (!empty($new_password) && $id > 0) {
                $userModel->resetPassword($id, $new_password);
            }
            header("Location: index.php?act=admin_nguoidung");
            exit();
        }

        $user = $userModel->getUserById($id);
        if (!$user) {
            header("Location: index.php?act=admin_nguoidung");
            exit();
        }
        $mode = 'reset_pass';
        require_once 'views/admin/nguoidung_form.php';
    }

    // 4. Thá»‘ng kÃª sá»‘ liá»‡u
    public function adminThongKe() {
        $this->checkAdmin();
        require_once 'models/thongke.php';
        $thongKeModel = new ThongKe();

        $lichSuDonHang = $thongKeModel->getLichSuDonHang();
        $sanPhamStats = $thongKeModel->thongKeSanPham();
        $donHangStats = $thongKeModel->thongKeDonHang();
        $khachHangStats = $thongKeModel->thongKeKhachHang();
        $tonKhoStats = $thongKeModel->thongKeTonKho();

        require_once 'views/admin/thongke.php';
    }
}