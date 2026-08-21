<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi Tiết Người Dùng | Admin Panel</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .adi-card-container {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 20px;
        }
        
        .adi-profile-card {
            background: #fff;
            padding: 24px;
            border: 1px solid #ebedee;
            border-top: 3px solid #3c8dbc;
        }

        .adi-history-card {
            background: #fff;
            padding: 24px;
            border: 1px solid #ebedee;
        }

        .adi-profile-item {
            margin-bottom: 16px;
            padding-bottom: 12px;
            border-bottom: 1px dashed #eee;
        }

        .adi-profile-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .adi-profile-label {
            font-size: 12px;
            color: #777;
            text-transform: uppercase;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .adi-profile-value {
            font-size: 15px;
            color: #222;
            font-weight: 500;
        }
        
        .adi-order-table th {
            background-color: #f8f9fa;
            color: #333;
            font-size: 12px;
            text-transform: uppercase;
            border-bottom: 2px solid #ddd;
        }
    </style>
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
                    <a href="index.php?act=logout" class="adi-header-link" style="color: #dc3545;"><i class="fa-solid fa-power-off"></i></a>
                </div>
            </header>

            <!-- Page Content -->
            <div class="adi-content-wrapper">
                <div class="adi-content-header" style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <h1 class="adi-page-title">CHI TIẾT NGƯỜI DÙNG</h1>
                        <div class="adi-breadcrumb">
                            <a href="index.php?act=admin"><i class="fa-solid fa-house"></i> Trang chủ</a> > 
                            <a href="index.php?act=admin_nguoidung">Quản lý Người dùng</a> > 
                            Chi tiết
                        </div>
                    </div>
                    <a href="index.php?act=admin_nguoidung" class="adi-btn-outline">
                        <i class="fa-solid fa-arrow-left"></i> Quay lại
                    </a>
                </div>

                <div class="adi-card-container">
                    <!-- Thông tin cá nhân -->
                    <div class="adi-profile-card">
                        <h3 style="margin-top: 0; margin-bottom: 20px; font-size: 18px; border-bottom: 1px solid #eee; padding-bottom: 10px;">
                            <i class="fa-solid fa-address-card" style="color: #3c8dbc;"></i> Thông tin tài khoản
                        </h3>
                        
                        <div style="text-align: center; margin-bottom: 24px;">
                            <div style="width: 80px; height: 80px; background: #e9ecef; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 10px;">
                                <i class="fa-solid fa-user" style="font-size: 36px; color: #adb5bd;"></i>
                            </div>
                            <h2 style="margin: 0; font-size: 20px; color: #000;"><?= htmlspecialchars($user['username']) ?></h2>
                            <span style="font-size: 12px; background: <?= $user['vai_tro_id'] == 1 ? '#17a2b8' : '#6c757d' ?>; color: #fff; padding: 2px 8px; border-radius: 12px; display: inline-block; margin-top: 6px;">
                                <?= $user['vai_tro_id'] == 1 ? 'ADMIN' : 'USER' ?>
                            </span>
                        </div>

                        <div class="adi-profile-item">
                            <div class="adi-profile-label">Email</div>
                            <div class="adi-profile-value"><?= htmlspecialchars($user['email']) ?></div>
                        </div>
                        <div class="adi-profile-item">
                            <div class="adi-profile-label">Số điện thoại</div>
                            <div class="adi-profile-value"><?= htmlspecialchars($user['sdt'] ?? 'Chưa cập nhật') ?></div>
                        </div>
                        <div class="adi-profile-item">
                            <div class="adi-profile-label">Địa chỉ</div>
                            <div class="adi-profile-value"><?= htmlspecialchars($user['address'] ?? 'Chưa cập nhật') ?></div>
                        </div>
                        <div class="adi-profile-item">
                            <div class="adi-profile-label">Ngày tạo</div>
                            <div class="adi-profile-value"><?= date('d/m/Y H:i', strtotime($user['ngay_tao'])) ?></div>
                        </div>
                        <div class="adi-profile-item">
                            <div class="adi-profile-label">Đăng nhập cuối</div>
                            <div class="adi-profile-value">
                                <?= $user['last_login'] ? date('d/m/Y H:i', strtotime($user['last_login'])) : 'Chưa từng đăng nhập' ?>
                            </div>
                        </div>
                    </div>

                    <!-- Lịch sử mua hàng -->
                    <div class="adi-history-card">
                        <h3 style="margin-top: 0; margin-bottom: 20px; font-size: 18px; border-bottom: 1px solid #eee; padding-bottom: 10px;">
                            <i class="fa-solid fa-cart-shopping" style="color: #28a745;"></i> Lịch sử mua hàng
                        </h3>
                        
                        <div class="adi-table-responsive">
                            <table class="adi-table adi-order-table">
                                <thead>
                                    <tr>
                                        <th>Mã đơn</th>
                                        <th>Ngày mua</th>
                                        <th>Mã SP</th>
                                        <th>Sản phẩm</th>
                                        <th style="text-align: right;">Giá</th>
                                        <th style="text-align: center;">SL</th>
                                        <th style="text-align: right;">Thành tiền</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($history)): ?>
                                        <?php foreach ($history as $item): ?>
                                        <tr>
                                            <td><span style="font-weight: 700; color: #3c8dbc;"><?= htmlspecialchars($item['ma_don_hang']) ?></span></td>
                                            <td><?= date('d/m/Y', strtotime($item['ngay_dat'])) ?></td>
                                            <td><span style="background: #e9ecef; padding: 2px 6px; font-size: 11px; border-radius: 4px; font-weight: bold;"><?= htmlspecialchars($item['ma_sp'] ?? 'N/A') ?></span></td>
                                            <td><?= htmlspecialchars($item['ten_san_pham']) ?></td>
                                            <td style="text-align: right;"><?= number_format($item['don_gia'], 0, ',', '.') ?>đ</td>
                                            <td style="text-align: center; font-weight: bold;"><?= $item['so_luong'] ?></td>
                                            <td style="text-align: right; color: #e50010; font-weight: 700;"><?= number_format($item['thanh_tien'], 0, ',', '.') ?>đ</td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="7" style="text-align: center; padding: 30px; color: #777;">
                                                <i class="fa-solid fa-box-open" style="font-size: 24px; color: #ddd; margin-bottom: 10px;"></i><br>
                                                Người dùng này chưa có lịch sử mua hàng nào.
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</body>
</html>
