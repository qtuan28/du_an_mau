<?php
require_once 'models/user.php';
require_once 'models/sanpham.php';
require_once 'models/danhmuc.php';
require_once 'models/giohang.php';
require_once 'models/thongke.php';

class pickleballController {

    // Helper kiểm tra quyền Admin
    private function checkAdmin() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['vai_tro_id'] != 1) {
            echo "<h3 style='color: red;'>TỪ CHỐI TRUY CẬP: Bạn không có quyền Admin!</h3>";
            echo "<p><a href='index.php?act=index'>Về Trang Chủ</a></p>";
            exit();
        }
    }

    // --- USE CASES: NGƯỜI DÙNG / KHÁCH ---

    public function trangChu() {
        $sanPhamModel = new SanPham();
        $dsSanPham = $sanPhamModel->getAll();
        require_once 'views/trangchu.php';
    }

    public function formLogin() {
        require_once 'views/login.php';
    }

    public function postLogin() {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        $userModel = new User();
        $user = $userModel->checkLogin($username, $password);

        if ($user) {
            $_SESSION['user'] = $user;
            header("Location: index.php");
            exit();
        } else {
            $error = "Tên đăng nhập hoặc mật khẩu không chính xác!";
            require_once 'views/login.php';
        }
    }

    public function formRegister() {
        require_once 'views/register.php';
    }

    public function postRegister() {
        // [TỰ CODE] Xử lý đăng ký tài khoản mới
        header("Location: index.php?act=login");
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
        // [TỰ CODE] Gọi Model lấy chi tiết sản phẩm
         $sanPhamModel = new SanPham();
         $sp = $sanPhamModel->getById($id);
        require_once 'views/chitiet.php';
    }

    public function timKiemSanPham() {
        $keyword = $_GET['keyword'] ?? '';
        // [TỰ CODE] Gọi Model tìm kiếm sản phẩm
        require_once 'views/trangchu.php';
    }

    public function xemDanhMuc() {
        $id = $_GET['id'] ?? 0;
        // [TỰ CODE] Gọi Model lọc sản phẩm theo danh mục
        require_once 'views/trangchu.php';
    }

    public function themGioHang() {
        $id = $_GET['id'] ?? 0;
        if ($id > 0) {
            $sanPhamModel = new SanPham();
            $sp = $sanPhamModel->getById($id);
            if ($sp) {
                // Khởi tạo giỏ hàng trong Session nếu chưa tồn tại
                if (!isset($_SESSION['cart'])) {
                    $_SESSION['cart'] = [];
                }
                
                // Nếu sản phẩm đã có trong giỏ, tăng số lượng lên 1
                if (isset($_SESSION['cart'][$id])) {
                    $_SESSION['cart'][$id]['so_luong'] += 1;
                } else {
                    // Nếu chưa có, thêm sản phẩm mới vào giỏ
                    $_SESSION['cart'][$id] = [
                        'product_id' => $sp['product_id'],
                        'ten'        => $sp['ten'],
                        'gia'        => $sp['gia'],
                        'anh'        => $sp['anh'],
                        'so_luong'   => 1
                    ];
                }
            }
        }
        header("Location: index.php?act=giohang");
        exit();
    }

    public function xemGioHang() {
        $gioHang = $_SESSION['cart'] ?? [];
        require_once 'views/giohang.php';
    }

    public function capNhatGioHang() {
        if (isset($_POST['so_luong']) && is_array($_POST['so_luong'])) {
            foreach ($_POST['so_luong'] as $id => $qty) {
                $qty = (int)$qty;
                if ($qty <= 0) {
                    unset($_SESSION['cart'][$id]);
                } else if (isset($_SESSION['cart'][$id])) {
                    $_SESSION['cart'][$id]['so_luong'] = $qty;
                }
            }
        }
        header("Location: index.php?act=giohang");
        exit();
    }

    public function xoaGioHang() {
        $id = $_GET['id'] ?? '';
        if ($id === 'all') {
            unset($_SESSION['cart']);
        } else if ($id > 0 && isset($_SESSION['cart'][$id])) {
            unset($_SESSION['cart'][$id]);
        }
        header("Location: index.php?act=giohang");
        exit();
    }

    public function thanhToan() {
        require_once 'views/thanhtoan.php';
    }

    public function postThanhToan() {
        // [TỰ CODE] Xử lý lưu đơn hàng và thanh toán
        header("Location: index.php?act=profile");
        exit();
    }

    public function hoSoCaNhan() {
        // [TỰ CODE] Lấy hồ sơ cá nhân và lịch sử đơn hàng
        if(!isset($_SESSION['user'])){
            header("Location:index.php?act=login");
            exit();
    }
        $userModel = new User();
        $user = $userModel->getUserProfile($_SESSION['user']['user_id']);

        require_once 'views/profile.php';
    }


    // --- USE CASES: ADMIN (BẢO MẬT BỞI checkAdmin) ---

    public function trangAdmin() {
        $this->checkAdmin();
        require_once 'views/admin.php';
    }

    // 1. Quản lý danh mục
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

    // Hiển thị Form Thêm Danh mục (Form riêng)
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

    // Xử lý Thêm Danh mục
    public function adminThemDanhMuc()
    {
        $this->checkAdmin();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = trim($_POST['name'] ?? '');
            $trang_thai = isset($_POST['trang_thai']) ? (int)$_POST['trang_thai'] : 1;

            $danhMucModel = new DanhMuc();

            if ($name == "") {
                $_SESSION['error'] = "Tên danh mục không được để trống!";
                header("Location: index.php?act=admin_danhmuc_add_form");
                exit();
            } elseif ($danhMucModel->checkExists($name)) {
                $_SESSION['error'] = "Danh mục '".$name."' đã tồn tại!";
                header("Location: index.php?act=admin_danhmuc_add_form");
                exit();
            } else {
                $danhMucModel->add($name, $trang_thai);
                $_SESSION['success'] = "Thêm danh mục '".$name."' thành công!";
            }
        }

        header("Location: index.php?act=admin_danhmuc");
        exit();
    }

    // Hiển thị Form Sửa Danh mục (Form riêng)
    public function adminFormSuaDanhMuc()
    {
        $this->checkAdmin();
        $id = $_GET['id'] ?? 0;

        $danhMucModel = new DanhMuc();
        $danhMuc = $danhMucModel->getById($id);

        if (!$danhMuc) {
            $_SESSION['error'] = "Danh mục không tồn tại!";
            header("Location: index.php?act=admin_danhmuc");
            exit();
        }

        $mode = 'edit';
        require_once 'views/admin/danhmuc_form.php';
    }

    // Xử lý Sửa Danh mục
    public function adminSuaDanhMuc()
    {
        $this->checkAdmin();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['category_id'] ?? 0;
            $name = trim($_POST['name'] ?? '');
            $trang_thai = isset($_POST['trang_thai']) ? (int)$_POST['trang_thai'] : 1;

            $danhMucModel = new DanhMuc();

            if ($name == "") {
                $_SESSION['error'] = "Tên danh mục không được để trống!";
                header("Location: index.php?act=admin_danhmuc_edit_form&id=" . $id);
                exit();
            } elseif ($danhMucModel->checkExists($name, $id)) {
                $_SESSION['error'] = "Tên danh mục '".$name."' đã trùng với danh mục khác!";
                header("Location: index.php?act=admin_danhmuc_edit_form&id=" . $id);
                exit();
            } else {
                $danhMucModel->update($id, $name, $trang_thai);
                $_SESSION['success'] = "Cập nhật danh mục thành công!";
            }
        }

        header("Location: index.php?act=admin_danhmuc");
        exit();
    }

    // Đổi trạng thái danh mục nhanh
    public function adminToggleTrangThaiDanhMuc()
    {
        $this->checkAdmin();
        $id = $_GET['id'] ?? 0;

        if ($id > 0) {
            $danhMucModel = new DanhMuc();
            $danhMucModel->toggleStatus($id);
            $_SESSION['success'] = "Đã cập nhật trạng thái danh mục!";
        }

        header("Location: index.php?act=admin_danhmuc");
        exit();
    }

    // Xóa danh mục
    public function adminXoaDanhMuc()
    {
        $this->checkAdmin();

        if (isset($_GET['id'])) {
            $danhMucModel = new DanhMuc();
            $danhMucModel->delete($_GET['id']);
            $_SESSION['success'] = "Đã xóa danh mục thành công!";
        }

        header("Location: index.php?act=admin_danhmuc");
        exit();
    }

    // Tìm kiếm danh mục
    public function adminTimKiemDanhMuc() {
        $this->adminQuanLyDanhMuc();
    }

    // 2. Quản lý sản phẩm
    public function adminQuanLySanPham() {
        $this->checkAdmin();
        require_once 'views/admin/sanpham.php';
    }

    public function adminThemSanPham() {
        $this->checkAdmin();
        // [TỰ CODE] Xử lý thêm sản phẩm
        header("Location: index.php?act=admin_sanpham");
        exit();
    }

    public function adminSuaSanPham() {
        $this->checkAdmin();
        // [TỰ CODE] Xử lý sửa sản phẩm
        header("Location: index.php?act=admin_sanpham");
        exit();
    }

    public function adminXoaSanPham() {
        $this->checkAdmin();
        // [TỰ CODE] Xử lý xóa sản phẩm
        header("Location: index.php?act=admin_sanpham");
        exit();
    }

    public function adminTimKiemSanPham() {
        $this->checkAdmin();
        // [TỰ CODE] Xử lý tìm kiếm sản phẩm
        require_once 'views/admin/sanpham.php';
    }

    // 3. Quản lý người dùng
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
            $vai_tro_id = $_POST['vai_tro_id'] ?? 2;

            if (!empty($username) && !empty($password)) {
                $userModel = new User();
                $userModel->addUser($username, $password, $email, $address, $vai_tro_id);
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
            $vai_tro_id = $_POST['vai_tro_id'] ?? 2;

            $userModel->updateUser($id, $email, $address, $vai_tro_id);
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
            // Không cho phép Admin tự xóa tài khoản của chính mình
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
            // Không cho phép Admin tự khóa tài khoản của chính mình
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

    // 4. Thống kê số liệu
    public function adminThongKe() {
        $this->checkAdmin();
        require_once 'views/admin/thongke.php';
    }
}