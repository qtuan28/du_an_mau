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
        // [TỰ CODE] Thêm sản phẩm vào giỏ hàng
        header("Location: index.php?act=giohang");
        exit();
    }

    public function xemGioHang() {
        // [TỰ CODE] Gọi Model lấy sản phẩm trong giỏ hàng
        require_once 'views/giohang.php';
    }

    public function capNhatGioHang() {
        // [TỰ CODE] Cập nhật số lượng giỏ hàng
        header("Location: index.php?act=giohang");
        exit();
    }

    public function xoaGioHang() {
        // [TỰ CODE] Xóa mặt hàng khỏi giỏ
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
    public function capNhatHoSo(){
    if (!isset($_SESSION['user'])) {
        header("Location:index.php?act=login");
        exit();
    }

    $userModel = new User();

    $id = $_POST['user_id'];
    $email = $_POST['email'];
    $address = $_POST['address'];

    $userModel->updateProfile($id, $email, $address);

    // cập nhật lại session
    $_SESSION['user']['email'] = $email;
    $_SESSION['user']['address'] = $address;

    header("Location:index.php?act=profile");
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

        $dsDanhMuc = $danhMucModel->getAll();

        require_once 'views/admin/danhmuc.php';
    }

    public function adminThemDanhMuc()
    {
        $this->checkAdmin();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $name = trim($_POST['name']);

            $danhMucModel = new DanhMuc();

            if ($name == "") {

                $_SESSION['error'] = "Tên danh mục không được để trống!";

            } elseif ($danhMucModel->checkExists($name)) {

                $_SESSION['error'] = "Danh mục đã tồn tại!";

            } else {

                $danhMucModel->add($name);

                $_SESSION['success'] = "Thêm danh mục thành công!";
            }
        }

        header("Location: index.php?act=admin_danhmuc");
        exit();
    }

    public function adminSuaDanhMuc()
    {
        $this->checkAdmin();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $id = $_POST['category_id'];

            $name = trim($_POST['name']);

            $danhMucModel = new DanhMuc();

            $danhMucModel->update($id, $name);

            $_SESSION['success'] = "Cập nhật thành công!";
        }

        header("Location: index.php?act=admin_danhmuc");
        exit();
    }

    public function adminXoaDanhMuc()
    {
        $this->checkAdmin();

        if (isset($_GET['id'])) {

            $danhMucModel = new DanhMuc();

            $danhMucModel->delete($_GET['id']);

            $_SESSION['success'] = "Đã xóa danh mục!";
        }

        header("Location: index.php?act=admin_danhmuc");
        exit();
    }

    public function adminTimKiemDanhMuc() {
        $this->checkAdmin();
        // [TỰ CODE] Xử lý tìm kiếm danh mục
        require_once 'views/admin/danhmuc.php';
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
        require_once 'views/admin/nguoidung.php';
    }

    public function adminXoaNguoiDung() {
        $this->checkAdmin();
        // [TỰ CODE] Xử lý xóa người dùng
        header("Location: index.php?act=admin_nguoidung");
        exit();
    }

    // 4. Thống kê số liệu
    public function adminThongKe() {
        $this->checkAdmin();
        require_once 'views/admin/thongke.php';
    }
}