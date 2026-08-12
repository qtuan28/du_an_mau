<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hồ Sơ Cá Nhân & Lịch Sử Đơn Hàng | Pickleball Store</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .adi-profile-wrapper {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px 80px;
        }

        .adi-profile-breadcrumb {
            font-family: 'Roboto', sans-serif;
            font-size: 12px;
            font-weight: 500;
            text-transform: uppercase;
            color: #767677;
            margin-bottom: 24px;
        }

        .adi-profile-breadcrumb a {
            color: #000;
            text-decoration: underline;
        }

        .adi-profile-title {
            font-family: 'Oswald', sans-serif;
            font-size: 36px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: -0.5px;
            margin-bottom: 30px;
            padding-bottom: 16px;
            border-bottom: 1px solid #ebedee;
        }

        .adi-profile-grid {
            display: grid;
            grid-template-columns: 280px 1fr;
            gap: 40px;
            align-items: start;
        }

        @media (max-width: 868px) {
            .adi-profile-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Sidebar Profile Card */
        .adi-profile-sidebar {
            background-color: #fff;
            border: 1px solid #ebedee;
            padding: 30px 20px;
            text-align: center;
        }

        .adi-profile-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background-color: #000;
            color: #fff;
            font-family: 'Oswald', sans-serif;
            font-size: 32px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
        }

        .adi-profile-username {
            font-family: 'Oswald', sans-serif;
            font-size: 20px;
            font-weight: 700;
            color: #000;
            text-transform: uppercase;
            margin-bottom: 4px;
        }

        .adi-profile-role-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-family: 'Roboto', sans-serif;
            font-size: 12px;
            color: #666;
            background: #f1f3f5;
            padding: 4px 10px;
            border-radius: 20px;
            margin-bottom: 24px;
        }

        .adi-profile-menu {
            display: flex;
            flex-direction: column;
            gap: 8px;
            text-align: left;
            border-top: 1px solid #ebedee;
            padding-top: 20px;
        }

        .adi-profile-menu-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            font-family: 'Roboto', sans-serif;
            font-size: 14px;
            color: #333;
            text-decoration: none;
            transition: all 0.2s;
        }

        .adi-profile-menu-link:hover, .adi-profile-menu-link.active {
            background-color: #000;
            color: #fff;
            font-weight: 500;
        }

        .adi-profile-menu-link.danger {
            color: #e50010;
        }

        .adi-profile-menu-link.danger:hover {
            background-color: #e50010;
            color: #fff;
        }

        /* Profile Content Area */
        .adi-profile-section {
            background-color: #fff;
            border: 1px solid #ebedee;
            padding: 30px;
            margin-bottom: 30px;
        }

        .adi-section-head {
            font-family: 'Oswald', sans-serif;
            font-size: 20px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 1px solid #ebedee;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .adi-form-group {
            margin-bottom: 20px;
        }

        .adi-form-label {
            display: block;
            font-family: 'Oswald', sans-serif;
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #000;
            margin-bottom: 8px;
        }

        .adi-input-text {
            width: 100%;
            padding: 14px;
            font-family: 'Roboto', sans-serif;
            font-size: 14px;
            border: 1px solid #ccc;
            outline: none;
            transition: border-color 0.2s;
            background: #fff;
            box-sizing: border-box;
        }

        .adi-input-text:focus {
            border-color: #000;
        }

        .adi-btn-save {
            background-color: #000;
            color: #fff;
            font-family: 'Oswald', sans-serif;
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            padding: 14px 28px;
            border: 1px solid #000;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: background-color 0.2s;
        }

        .adi-btn-save:hover {
            background-color: #222;
        }

        /* Order History Table */
        .adi-order-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .adi-order-table th {
            font-family: 'Oswald', sans-serif;
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            text-align: left;
            padding: 12px 14px;
            background: #fafafa;
            border-bottom: 2px solid #000;
        }

        .adi-order-table td {
            padding: 16px 14px;
            border-bottom: 1px solid #ebedee;
            font-family: 'Roboto', sans-serif;
            font-size: 14px;
            vertical-align: middle;
        }

        .adi-status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            font-weight: 700;
            padding: 4px 10px;
            text-transform: uppercase;
        }

        .adi-status-badge.success {
            background: #d1fae5;
            color: #065f46;
        }

        .adi-status-badge.cancelled {
            background: #fee2e2;
            color: #991b1b;
        }

        .adi-status-badge.pending {
            background: #fef3c7;
            color: #92400e;
        }

        .adi-order-empty {
            text-align: center;
            padding: 40px 20px;
            color: #767677;
            font-family: 'Roboto', sans-serif;
        }

        /* Alert Notifications */
        .adi-alert {
            padding: 14px 18px;
            font-family: 'Roboto', sans-serif;
            font-size: 14px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
            border-left: 4px solid;
        }

        .adi-alert-success {
            background-color: #f0fdf4;
            border-color: #16a34a;
            color: #15803d;
        }

        .adi-alert-error {
            background-color: #fef2f2;
            border-color: #e50010;
            color: #991b1b;
        }

        /* Password Input Field with Eye Toggle */
        .adi-pwd-wrap {
            position: relative;
            display: flex;
            align-items: center;
        }

        .adi-pwd-wrap .adi-input-text {
            padding-right: 46px;
        }

        .adi-pwd-toggle {
            position: absolute;
            right: 14px;
            background: none;
            border: none;
            color: #767677;
            cursor: pointer;
            font-size: 16px;
            padding: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: color 0.2s;
        }

        .adi-pwd-toggle:hover {
            color: #000;
        }
    </style>
</head>
<body>

    <!-- Header bar -->
    <?php include 'views/header.php'; ?>

    <div class="adi-profile-wrapper">
        <div class="adi-profile-breadcrumb">
            <a href="index.php">TRANG CHỦ</a> / <span>HỒ SƠ CÁ NHÂN</span>
        </div>

        <h1 class="adi-profile-title">TÀI KHOẢN CỦA TÔI</h1>

        <div class="adi-profile-grid">
            <!-- Left Sidebar Card -->
            <aside class="adi-profile-sidebar">
                <div class="adi-profile-avatar">
                    <?= strtoupper(substr($user['username'] ?? 'U', 0, 1)) ?>
                </div>
                <div class="adi-profile-username">
                    <?= htmlspecialchars($user['username'] ?? 'Người dùng') ?>
                </div>
                <div class="adi-profile-role-badge">
                    <i class="fa-solid fa-shield-halved"></i>
                    <?= htmlspecialchars($_SESSION['user']['ten_vai_tro'] ?? 'Thành viên') ?>
                </div>

                <nav class="adi-profile-menu">
                    <a href="#thong-tin" class="adi-profile-menu-link active">
                        <i class="fa-regular fa-user"></i> Thông tin cá nhân
                    </a>
                    <a href="#doi-mat-khau" class="adi-profile-menu-link">
                        <i class="fa-solid fa-key"></i> Đổi mật khẩu
                    </a>
                    <a href="#lich-su" class="adi-profile-menu-link">
                        <i class="fa-solid fa-clock-rotate-left"></i> Lịch sử đơn hàng
                    </a>
                    <a href="index.php?act=giohang" class="adi-profile-menu-link">
                        <i class="fa-solid fa-bag-shopping"></i> Giỏ hàng của tôi
                    </a>
                    <a href="index.php?act=logout" class="adi-profile-menu-link danger">
                        <i class="fa-solid fa-power-off"></i> Đăng xuất
                    </a>
                </nav>
            </aside>

            <!-- Main Content Area -->
            <main>
                <?php if (!empty($msg)): ?>
                    <div class="adi-alert <?= ($msg_type === 'error') ? 'adi-alert-error' : 'adi-alert-success' ?>">
                        <i class="fa-solid <?= ($msg_type === 'error') ? 'fa-circle-exclamation' : 'fa-circle-check' ?>" style="font-size: 18px;"></i>
                        <span><?= htmlspecialchars($msg) ?></span>
                    </div>
                <?php endif; ?>

                <!-- Form Profile Update -->
                <section id="thong-tin" class="adi-profile-section">
                    <h2 class="adi-section-head">
                        <i class="fa-regular fa-id-card"></i> HỒ SƠ CÁ NHÂN
                    </h2>

                    <form action="index.php?act=updateProfile" method="post">
                        <input type="hidden" name="user_id" value="<?= htmlspecialchars($user['user_id']) ?>">

                        <div class="adi-form-group">
                            <label class="adi-form-label">Tên đăng nhập</label>
                            <input type="text" class="adi-input-text" value="<?= htmlspecialchars($user['username']) ?>" readonly style="background: #f5f5f5; color: #777;">
                        </div>

                        <div class="adi-form-group">
                            <label class="adi-form-label">Email liên hệ <span style="color: #e50010;">*</span></label>
                            <input type="email" name="email" class="adi-input-text" value="<?= htmlspecialchars($user['email']) ?>" placeholder="Nhập email..." required>
                        </div>

                        <div class="adi-form-group">
                            <label class="adi-form-label">Địa chỉ nhận hàng <span style="color: #e50010;">*</span></label>
                            <input type="text" name="address" class="adi-input-text" value="<?= htmlspecialchars($user['address'] ?? '') ?>" placeholder="Nhập địa chỉ nhận hàng chi tiết..." required>
                        </div>

                        <button type="submit" class="adi-btn-save">
                            <i class="fa-solid fa-floppy-disk"></i> CẬP NHẬT HỒ SƠ
                        </button>
                    </form>
                </section>

                <!-- Change Password Form -->
                <section id="doi-mat-khau" class="adi-profile-section">
                    <h2 class="adi-section-head">
                        <i class="fa-solid fa-key"></i> ĐỔI MẬT KHẨU
                    </h2>

                    <?php if (!empty($msg)): ?>
                        <div class="adi-alert <?= ($msg_type === 'error') ? 'adi-alert-error' : 'adi-alert-success' ?>">
                            <i class="fa-solid <?= ($msg_type === 'error') ? 'fa-circle-exclamation' : 'fa-circle-check' ?>" style="font-size: 18px;"></i>
                            <span><?= htmlspecialchars($msg) ?></span>
                        </div>
                    <?php endif; ?>

                    <form action="index.php?act=doi_mat_khau" method="post" onsubmit="return validatePasswordForm()">
                        <div class="adi-form-group">
                            <label class="adi-form-label">Mật khẩu hiện tại <span style="color: #e50010;">*</span></label>
                            <div class="adi-pwd-wrap">
                                <input type="password" name="old_password" id="old_password" class="adi-input-text" placeholder="Nhập mật khẩu hiện tại..." required>
                                <button type="button" class="adi-pwd-toggle" onclick="togglePasswordVisibility('old_password', this)" title="Ẩn/Hiện mật khẩu">
                                    <i class="fa-regular fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="adi-form-group">
                            <label class="adi-form-label">Mật khẩu mới <span style="color: #e50010;">*</span></label>
                            <div class="adi-pwd-wrap">
                                <input type="password" name="new_password" id="new_password" class="adi-input-text" placeholder="Tối thiểu 6 ký tự..." required minlength="6">
                                <button type="button" class="adi-pwd-toggle" onclick="togglePasswordVisibility('new_password', this)" title="Ẩn/Hiện mật khẩu">
                                    <i class="fa-regular fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="adi-form-group">
                            <label class="adi-form-label">Xác nhận mật khẩu mới <span style="color: #e50010;">*</span></label>
                            <div class="adi-pwd-wrap">
                                <input type="password" name="confirm_password" id="confirm_password" class="adi-input-text" placeholder="Nhập lại mật khẩu mới..." required minlength="6">
                                <button type="button" class="adi-pwd-toggle" onclick="togglePasswordVisibility('confirm_password', this)" title="Ẩn/Hiện mật khẩu">
                                    <i class="fa-regular fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <button type="submit" class="adi-btn-save">
                            <i class="fa-solid fa-shield-halved"></i> CẬP NHẬT MẬT KHẨU
                        </button>
                    </form>
                </section>

                <!-- Order History -->
                <section id="lich-su" class="adi-profile-section">
                    <h2 class="adi-section-head">
                        <i class="fa-solid fa-box-archive"></i> LỊCH SỬ ĐƠN HÀNG
                    </h2>

                    <?php if (!empty($orders)): ?>
                        <div style="overflow-x: auto;">
                            <table class="adi-order-table">
                                <thead>
                                    <tr>
                                        <th>MÃ ĐƠN</th>
                                        <th>NGÀY ĐẶT</th>
                                        <th>TRẠNG THÁI</th>
                                        <th>TỔNG TIỀN</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($orders as $order): ?>
                                        <tr>
                                            <td><strong>#<?= htmlspecialchars($order['id'] ?? $order['don_hang_id'] ?? $order['ma_don_hang']) ?></strong></td>
                                            <td><?= htmlspecialchars($order['ngay_dat'] ?? date('d/m/Y')) ?></td>
                                            <td>
                                                <?php 
                                                    $status = $order['trang_thai'] ?? 'Processing';
                                                    if ($status == 'Completed' || $status == 'Đã giao') {
                                                        echo '<span class="adi-status-badge success"><i class="fa-solid fa-circle-check"></i> Đã giao</span>';
                                                     } elseif ($status == 'Cancelled' || $status == 'Đã hủy') {
                                                        echo '<span class="adi-status-badge cancelled"><i class="fa-solid fa-circle-xmark"></i> Đã hủy</span>';
                                                    } else {
                                                        echo '<span class="adi-status-badge pending"><i class="fa-solid fa-spinner fa-spin"></i> Đang xử lý</span>';
                                                    }
                                                ?>
                                            </td>
                                            <td><strong><?= number_format($order['tong_tien'] ?? 0, 0, ',', '.') ?>₫</strong></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="adi-order-empty">
                            <i class="fa-solid fa-inbox" style="font-size: 40px; margin-bottom: 12px; display: block; color: #ccc;"></i>
                            <p>Bạn chưa có lịch sử đơn hàng nào.</p>
                        </div>
                    <?php endif; ?>
                </section>
            </main>
        </div>
    </div>

    <!-- Footer -->
    <?php include 'views/footer.php'; ?>

    <script>
        function validatePasswordForm() {
            const newPass = document.getElementById('new_password').value;
            const confirmPass = document.getElementById('confirm_password').value;

            if (newPass.length < 6) {
                alert('Mật khẩu mới phải có ít nhất 6 ký tự!');
                return false;
            }
            if (newPass !== confirmPass) {
                alert('Mật khẩu xác nhận không trùng khớp với mật khẩu mới!');
                return false;
            }
            return true;
        }

        function togglePasswordVisibility(inputId, btn) {
            const input = document.getElementById(inputId);
            const icon = btn.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        // Active state handling for sidebar navigation links
        document.addEventListener('DOMContentLoaded', function() {
            const menuLinks = document.querySelectorAll('.adi-profile-menu-link');
            
            function updateActiveLink() {
                const currentHash = window.location.hash || '#thong-tin';
                menuLinks.forEach(link => {
                    if (link.getAttribute('href') === currentHash) {
                        link.classList.add('active');
                    } else if (link.getAttribute('href').startsWith('#')) {
                        link.classList.remove('active');
                    }
                });
            }

            window.addEventListener('hashchange', updateActiveLink);
            updateActiveLink();
        });
    </script>
</body>
</html>
