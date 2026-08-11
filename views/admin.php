<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bảng Điều Khiển Admin | adidas System</title>
    <link rel="stylesheet" href="assets/css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="adi-admin-wrapper">
        
        <!-- Sidebar -->
        <?php include 'views/admin_sidebar.php'; ?>

        <!-- Right Main Panel -->
        <div class="adi-main-panel">
            <!-- Top Navbar -->
            <header class="adi-main-header">
                <div class="adi-header-left">
                    <a href="index.php" class="adi-header-link"><i class="fa-solid fa-globe"></i> Xem website</a>
                </div>
                <div class="adi-header-right">
                    <div class="adi-header-user">
                        <i class="fa-solid fa-circle-user"></i>
                        <?= htmlspecialchars($_SESSION['user']['username'] ?? 'Admin') ?>
                    </div>
                    <a href="index.php?act=logout" class="adi-header-link" style="color: #dc3545;" title="Đăng xuất"><i class="fa-solid fa-power-off"></i></a>
                </div>
            </header>

            <!-- Page Content -->
            <div class="adi-content-wrapper">
                
                <!-- Page Header & Breadcrumb -->
                <div class="adi-content-header">
                    <h1 class="adi-page-title">Dashboard</h1>
                    <div class="adi-breadcrumb">
                        <a href="index.php?act=admin"><i class="fa-solid fa-house"></i> Trang chủ</a> > Dashboard
                    </div>
                </div>

                <!-- Dashboard Content Box -->
                <div class="adi-box">
                    <div class="adi-box-header">
                        <h3 style="font-family: 'Roboto', sans-serif; font-size: 15px; font-weight: 700; margin: 0;">Tổng Quan Hệ Thống</h3>
                    </div>
                    <div style="padding: 20px;">
                        <p style="margin-bottom: 20px; font-size: 14px;">Chào mừng bạn đến với hệ thống quản trị lấy cảm hứng từ thiết kế AdminLTE kết hợp phong cách adidas UI. Hãy chọn các chức năng bên trái để bắt đầu quản lý.</p>
                        
                        <!-- Mini stat cards placeholder -->
                        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px;">
                            <div style="background: #10b981; color: #fff; padding: 20px; text-align: center;">
                                <i class="fa-solid fa-box-open" style="font-size: 30px; margin-bottom: 10px;"></i>
                                <div style="font-family: 'Oswald', sans-serif; font-size: 24px; font-weight: 700;"><?= number_format($countSanPham ?? 0) ?></div>
                                <div style="font-size: 13px; text-transform: uppercase;">Sản phẩm</div>
                            </div>
                            <div style="background: #000; color: #fff; padding: 20px; text-align: center;">
                                <i class="fa-solid fa-users" style="font-size: 30px; margin-bottom: 10px;"></i>
                                <div style="font-family: 'Oswald', sans-serif; font-size: 24px; font-weight: 700;"><?= number_format($countKhachHang ?? 0) ?></div>
                                <div style="font-size: 13px; text-transform: uppercase;">Người dùng</div>
                            </div>
                            <div style="background: #f89406; color: #fff; padding: 20px; text-align: center;">
                                <i class="fa-solid fa-shopping-cart" style="font-size: 30px; margin-bottom: 10px;"></i>
                                <div style="font-family: 'Oswald', sans-serif; font-size: 24px; font-weight: 700;"><?= number_format($countDonHang ?? 0) ?></div>
                                <div style="font-size: 13px; text-transform: uppercase;">Đơn hàng</div>
                            </div>
                            <div style="background: #dc3545; color: #fff; padding: 20px; text-align: center;">
                                <i class="fa-solid fa-chart-line" style="font-size: 30px; margin-bottom: 10px;"></i>
                                <div style="font-family: 'Oswald', sans-serif; font-size: 20px; font-weight: 700;"><?= number_format($tongDoanhThu ?? 0, 0, ',', '.') ?>₫</div>
                                <div style="font-size: 13px; text-transform: uppercase;">Doanh thu</div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</body>
</html>
