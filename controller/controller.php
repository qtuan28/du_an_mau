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

        $keyword = trim($_GET['keyword'] ?? '');
        $stockStatus = isset($_GET['trang_thai']) && $_GET['trang_thai'] !== '' ? $_GET['trang_thai'] : '';
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($page < 1) $page = 1;
        $limit = 5; // Số sản phẩm hiển thị trên 1 trang

        $sanPhamModel = new SanPham();
        $totalCount = $sanPhamModel->getTotalCount($keyword, $stockStatus);
        $totalPages = ceil($totalCount / $limit);
        if ($totalPages < 1) $totalPages = 1;
        if ($page > $totalPages) $page = $totalPages;

        $dsSanPham = $sanPhamModel->getAllWithPagination($keyword, $stockStatus, $page, $limit);

        require_once 'views/admin/sanpham.php';
    }

    // Hiển thị Form Thêm sản phẩm (Form riêng)
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
            'anh' => ''
        ];

        require_once 'views/admin/sanpham_form.php';
    }

    // Xử lý Thêm sản phẩm
    public function adminThemSanPham() {
        $this->checkAdmin();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $ten = trim($_POST['ten'] ?? '');
            $category_id = (int)($_POST['category_id'] ?? 0);
            $gia = (float)($_POST['gia'] ?? 0);
            $giam_gia = (int)($_POST['giam_gia'] ?? 0);
            $trang_thai = (int)($_POST['trang_thai'] ?? 1);

            if ($ten == "" || $category_id == 0 || $gia <= 0) {
                $_SESSION['error'] = "Vui lòng nhập đầy đủ thông tin Tên sản phẩm, Danh mục và Giá!";
                header("Location: index.php?act=admin_sanpham_add_form");
                exit();
            }

            // Xử lý Upload Ảnh
            $anh = '';
            if (isset($_FILES['anh']) && $_FILES['anh']['error'] == 0) {
                $target_dir = "uploads/";
                if (!is_dir($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }
                $filename = time() . '_' . basename($_FILES['anh']['name']);
                $target_file = $target_dir . $filename;
                if (move_uploaded_file($_FILES['anh']['tmp_name'], $target_file)) {
                    $anh = $filename;
                }
            }

            $sanPhamModel = new SanPham();
            $sanPhamModel->add([
                'category_id' => $category_id,
                'ten' => $ten,
                'gia' => $gia,
                'giam_gia' => $giam_gia,
                'trang_thai' => $trang_thai,
                'anh' => $anh
            ]);

            $_SESSION['success'] = "Thêm sản phẩm '".$ten."' thành công!";
        }

        header("Location: index.php?act=admin_sanpham");
        exit();
    }

    // Hiển thị Form Sửa sản phẩm (Form riêng)
    public function adminFormSuaSanPham() {
        $this->checkAdmin();
        $id = $_GET['id'] ?? 0;

        $sanPhamModel = new SanPham();
        $sanPham = $sanPhamModel->getById($id);

        if (!$sanPham) {
            $_SESSION['error'] = "Sản phẩm không tồn tại!";
            header("Location: index.php?act=admin_sanpham");
            exit();
        }

        $danhMucModel = new DanhMuc();
        $dsDanhMuc = $danhMucModel->getAll();

        $mode = 'edit';
        require_once 'views/admin/sanpham_form.php';
    }

    // Xử lý Sửa sản phẩm
    public function adminSuaSanPham() {
        $this->checkAdmin();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = (int)($_POST['product_id'] ?? 0);
            $ten = trim($_POST['ten'] ?? '');
            $category_id = (int)($_POST['category_id'] ?? 0);
            $gia = (float)($_POST['gia'] ?? 0);
            $giam_gia = (int)($_POST['giam_gia'] ?? 0);
            $trang_thai = (int)($_POST['trang_thai'] ?? 1);
            $old_anh = $_POST['old_anh'] ?? '';

            if ($ten == "" || $category_id == 0 || $gia <= 0) {
                $_SESSION['error'] = "Vui lòng nhập đầy đủ thông tin Tên sản phẩm, Danh mục và Giá!";
                header("Location: index.php?act=admin_sanpham_edit_form&id=" . $id);
                exit();
            }

            // Xử lý upload ảnh mới nếu chọn
            $anh = $old_anh;
            if (isset($_FILES['anh']) && $_FILES['anh']['error'] == 0) {
                $target_dir = "uploads/";
                if (!is_dir($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }
                $filename = time() . '_' . basename($_FILES['anh']['name']);
                $target_file = $target_dir . $filename;
                if (move_uploaded_file($_FILES['anh']['tmp_name'], $target_file)) {
                    $anh = $filename;
                }
            }

            $sanPhamModel = new SanPham();
            $sanPhamModel->update($id, [
                'category_id' => $category_id,
                'ten' => $ten,
                'gia' => $gia,
                'giam_gia' => $giam_gia,
                'trang_thai' => $trang_thai,
                'anh' => $anh
            ]);

            $_SESSION['success'] = "Cập nhật sản phẩm thành công!";
        }

        header("Location: index.php?act=admin_sanpham");
        exit();
    }

    // Đổi nhanh trạng thái Còn hàng / Hết hàng
    public function adminToggleTrangThaiSanPham() {
        $this->checkAdmin();
        $id = $_GET['id'] ?? 0;

        if ($id > 0) {
            $sanPhamModel = new SanPham();
            $sanPhamModel->toggleStockStatus($id);
            $_SESSION['success'] = "Đã đổi trạng thái sản phẩm!";
        }

        header("Location: index.php?act=admin_sanpham");
        exit();
    }

    // Xóa sản phẩm
    public function adminXoaSanPham() {
        $this->checkAdmin();
        $id = $_GET['id'] ?? 0;

        if ($id > 0) {
            $sanPhamModel = new SanPham();
            $sanPhamModel->delete($id);
            $_SESSION['success'] = "Đã xóa sản phẩm thành công!";
        }

        header("Location: index.php?act=admin_sanpham");
        exit();
    }

    // Tìm kiếm sản phẩm
    public function adminTimKiemSanPham() {
        $this->adminQuanLySanPham();
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