<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Quản Trị - Admin System</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Admin CSS -->
    <link rel="stylesheet" href="assets/css/admin.css">
</head>
<body>
    <div class="admin-layout">
        <!-- Top Navbar -->
        <header class="admin-navbar">
            <div class="admin-brand">
                <i class="fa-solid fa-shield-halved"></i>
                <span>Pickleball Admin</span>
            </div>
            <div class="admin-nav-links">
                <a href="index.php?act=index" class="nav-item-btn" target="_blank">
                    <i class="fa-solid fa-globe"></i> Trang chủ website
                </a>
                <a href="index.php?act=logout" class="nav-item-btn" style="color: var(--danger-600);">
                    <i class="fa-solid fa-right-from-bracket"></i> Đăng xuất
                </a>
            </div>
        </header>

        <!-- Main Container -->
        <main class="admin-container">
            <div class="page-header">
                <div class="page-title-group">
                    <h1>
                        <div class="title-icon">
                            <i class="fa-solid fa-gauge-high"></i>
                        </div>
                        Bảng Điều Khiển Quản Trị
                    </h1>
                    <p>Xin chào Admin: <strong><?= htmlspecialchars($_SESSION['user']['username'] ?? 'Admin') ?></strong> | Chúc bạn một ngày làm việc hiệu quả!</p>
                </div>
            </div>

            <!-- Management Feature Modules Grid -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 24px; margin-top: 10px;">
                <!-- Module 1: Danh Mục -->
                <a href="index.php?act=admin_danhmuc" class="content-card" style="padding: 24px; display: block; text-decoration: none; transition: var(--transition);">
                    <div style="width: 50px; height: 50px; border-radius: var(--radius-md); background: #eff6ff; color: #2563eb; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin-bottom: 16px;">
                        <i class="fa-solid fa-layer-group"></i>
                    </div>
                    <h3 style="font-family: var(--admin-font-heading); font-size: 1.2rem; color: var(--text-dark); margin-bottom: 6px;">1. Quản Lý Danh Mục</h3>
                    <p style="font-size: 0.875rem; color: var(--text-muted);">Xem, thêm mới, chỉnh sửa, xóa và tìm kiếm danh mục sản phẩm.</p>
                </a>

                <!-- Module 2: Sản Phẩm -->
                <a href="index.php?act=admin_sanpham" class="content-card" style="padding: 24px; display: block; text-decoration: none; transition: var(--transition);">
                    <div style="width: 50px; height: 50px; border-radius: var(--radius-md); background: #f0fdf4; color: #16a34a; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin-bottom: 16px;">
                        <i class="fa-solid fa-box-open"></i>
                    </div>
                    <h3 style="font-family: var(--admin-font-heading); font-size: 1.2rem; color: var(--text-dark); margin-bottom: 6px;">2. Quản Lý Sản Phẩm</h3>
                    <p style="font-size: 0.875rem; color: var(--text-muted);">Quản lý danh sách sản phẩm, cập nhật giá, hình ảnh và tồn kho.</p>
                </a>

                <!-- Module 3: Người Dùng -->
                <a href="index.php?act=admin_nguoidung" class="content-card" style="padding: 24px; display: block; text-decoration: none; border-color: var(--primary-500); box-shadow: var(--shadow-md); transition: var(--transition);">
                    <div style="width: 50px; height: 50px; border-radius: var(--radius-md); background: #f3e8ff; color: #7c3aed; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin-bottom: 16px;">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <h3 style="font-family: var(--admin-font-heading); font-size: 1.2rem; color: var(--text-dark); margin-bottom: 6px;">3. Quản Lý Người Dùng</h3>
                    <p style="font-size: 0.875rem; color: var(--text-muted);">Quản lý tài khoản người dùng, phân quyền Admin và khóa/mở khóa tài khoản.</p>
                </a>

                <!-- Module 4: Thống Kê -->
                <a href="index.php?act=admin_thongke" class="content-card" style="padding: 24px; display: block; text-decoration: none; transition: var(--transition);">
                    <div style="width: 50px; height: 50px; border-radius: var(--radius-md); background: #fffbeb; color: #d97706; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin-bottom: 16px;">
                        <i class="fa-solid fa-chart-pie"></i>
                    </div>
                    <h3 style="font-family: var(--admin-font-heading); font-size: 1.2rem; color: var(--text-dark); margin-bottom: 6px;">4. Thống Kê Số Liệu</h3>
                    <p style="font-size: 0.875rem; color: var(--text-muted);">Báo cáo tổng quan về sản phẩm, đơn hàng và lượng người dùng.</p>
                </a>
            </div>
        </main>

        <!-- Footer -->
        <footer class="admin-footer">
            &copy; <?= date('Y') ?> Pickleball Admin Management System.
        </footer>
    </div>
</body>
</html>
