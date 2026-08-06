<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hồ Sơ Cá Nhân & Lịch Sử Đơn Hàng | Pickleball Store</title>
    
    <!-- Google Fonts & FontAwesome Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- System & Profile Stylesheets -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/profile.css">
</head>
<body>

    <!-- Header Banner -->
    <div class="profile-page-header">
        <div class="container">
            <div class="profile-header-content">
                <div class="profile-title-group">
                    <h1>Tài Khoản Của Tôi</h1>
                    <div class="profile-breadcrumb">
                        <a href="index.php?act=index"><i class="fa-solid fa-house"></i> Trang chủ</a>
                        <i class="fa-solid fa-chevron-right"></i>
                        <span>Hồ sơ cá nhân</span>
                    </div>
                </div>
                <div>
                    <a href="index.php?act=index" class="btn-shop-now">
                        <i class="fa-solid fa-arrow-left"></i> Quay lại trang chủ
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Container -->
    <div class="container">
        <div class="profile-dashboard">
            
            <!-- Left Sidebar: Profile Summary -->
            <aside class="profile-sidebar-card">
                <div class="profile-avatar-banner"></div>
                <div class="profile-avatar-wrapper">
                    <div class="profile-avatar-circle">
                        <?= strtoupper(substr($user['username'] ?? 'U', 0, 1)) ?>
                    </div>
                    <div class="profile-user-name">
                        <?= htmlspecialchars($user['username'] ?? 'Người dùng') ?>
                    </div>
                    <div class="profile-user-role">
                        <i class="fa-solid fa-shield-halved"></i>
                        <?= htmlspecialchars($_SESSION['user']['ten_vai_tro'] ?? 'Thành viên') ?>
                    </div>
                </div>
                
                <nav class="profile-sidebar-menu">
                    <a href="#thong-tin-ca-nhan" class="profile-menu-item active">
                        <i class="fa-solid fa-user-gear"></i> Thông tin cá nhân
                    </a>
                    <a href="#lich-su-don-hang" class="profile-menu-item">
                        <i class="fa-solid fa-box-archive"></i> Lịch sử đơn hàng
                    </a>
                    <a href="index.php?act=giohang" class="profile-menu-item">
                        <i class="fa-solid fa-cart-shopping"></i> Giỏ hàng của tôi
                    </a>
                    <a href="index.php?act=logout" class="profile-menu-item danger">
                        <i class="fa-solid fa-right-from-bracket"></i> Đăng xuất
                    </a>
                </nav>
            </aside>

            <!-- Right Main Area -->
            <main class="profile-main-content">
                
                <!-- Section 1: Update Profile Form -->
                <section id="thong-tin-ca-nhan" class="profile-section-card">
                    <div class="card-header-title">
                        <h2>
                            <i class="fa-solid fa-id-card"></i> 
                            HỒ SƠ CÁ NHÂN
                        </h2>
                        <span class="section-subtitle">Quản lý thông tin tài khoản của bạn</span>
                    </div>

                    <form action="index.php?act=updateProfile" method="post">
                        <input type="hidden" name="user_id" value="<?= htmlspecialchars($user['user_id']) ?>">

                        <div class="profile-form-grid">
                            
                            <!-- Username Field (Readonly) -->
                            <div class="form-field">
                                <label><i class="fa-solid fa-user"></i> Tên đăng nhập</label>
                                <div class="input-with-icon">
                                    <input type="text" 
                                           value="<?= htmlspecialchars($user['username']) ?>" 
                                           readonly>
                                    <i class="fa-solid fa-lock"></i>
                                </div>
                            </div>

                            <!-- Email Field -->
                            <div class="form-field">
                                <label><i class="fa-solid fa-envelope"></i> Email liên hệ</label>
                                <div class="input-with-icon">
                                    <input type="email" 
                                           name="email" 
                                           value="<?= htmlspecialchars($user['email']) ?>" 
                                           placeholder="Nhập địa chỉ email..." 
                                           required>
                                    <i class="fa-solid fa-at"></i>
                                </div>
                            </div>

                            <!-- Address Field -->
                            <div class="form-field form-group-full">
                                <label><i class="fa-solid fa-location-dot"></i> Địa chỉ giao hàng</label>
                                <div class="input-with-icon">
                                    <input type="text" 
                                           name="address" 
                                           value="<?= htmlspecialchars($user['address'] ?? '') ?>" 
                                           placeholder="Nhập địa chỉ nhận hàng chi tiết..." 
                                           required>
                                    <i class="fa-solid fa-map-location-dot"></i>
                                </div>
                            </div>

                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn-update-profile">
                                <i class="fa-solid fa-floppy-disk"></i> Cập nhật hồ sơ
                            </button>
                        </div>
                    </form>
                </section>

                <!-- Section 2: Order History -->
                <section id="lich-su-don-hang" class="profile-section-card">
                    <div class="card-header-title">
                        <h2>
                            <i class="fa-solid fa-clock-rotate-left"></i> 
                            LỊCH SỬ ĐƠN HÀNG
                        </h2>
                        <span class="section-subtitle">Danh sách các đơn hàng đã đặt mua</span>
                    </div>

                    <?php if (!empty($orders)): ?>
                        <div class="table-responsive">
                            <table class="order-table">
                                <thead>
                                    <tr>
                                        <th>Mã đơn hàng</th>
                                        <th>Ngày đặt</th>
                                        <th>Trạng thái</th>
                                        <th>Tổng tiền</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($orders as $order): ?>
                                        <tr>
                                            <td class="order-id">#<?= htmlspecialchars($order['id'] ?? $order['ma_don_hang']) ?></td>
                                            <td><?= htmlspecialchars($order['ngay_dat'] ?? date('d/m/Y')) ?></td>
                                            <td>
                                                <?php 
                                                    $status = $order['trang_thai'] ?? 'Processing';
                                                    if ($status == 'Completed' || $status == 'Đã giao') {
                                                        echo '<span class="status-badge success"><i class="fa-solid fa-circle-check"></i> Đã giao</span>';
                                                    } elseif ($status == 'Cancelled' || $status == 'Đã hủy') {
                                                        echo '<span class="status-badge cancelled"><i class="fa-solid fa-circle-xmark"></i> Đã hủy</span>';
                                                    } else {
                                                        echo '<span class="status-badge pending"><i class="fa-solid fa-spinner fa-spin"></i> Đang xử lý</span>';
                                                    }
                                                ?>
                                            </td>
                                            <td class="order-total"><?= number_format($order['tong_tien'] ?? 0, 0, ',', '.') ?> đ</td>
                                            <td>
                                                <a href="#" class="profile-menu-item" style="padding: 4px 8px; font-size: 12px; display: inline-flex;">
                                                    <i class="fa-solid fa-eye"></i> Chi tiết
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="order-empty-state">
                            <div class="order-empty-icon">
                                <i class="fa-solid fa-box-open"></i>
                            </div>
                            <p>Bạn chưa có lịch sử đơn hàng nào.</p>
                            <a href="index.php?act=index" class="btn-shop-now">
                                <i class="fa-solid fa-bag-shopping"></i> Khám phá sản phẩm ngay
                            </a>
                        </div>
                    <?php endif; ?>

                </section>

            </main>
        </div>
    </div>

</body>
</html>
