<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php 
        if ($mode === 'add') echo "Thêm Người Dùng Mới";
        elseif ($mode === 'edit') echo "Sửa Thông Tin & Phân Quyền";
        elseif ($mode === 'reset_pass') echo "Đặt Lại Mật Khẩu";
        ?> | Admin Panel
    </title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .adi-form-card {
            background: #fff;
            padding: 30px;
            border: 1px solid #ebedee;
            max-width: 750px;
        }

        .adi-field-group {
            margin-bottom: 20px;
        }

        .adi-field-label {
            display: block;
            font-family: 'Oswald', sans-serif;
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #000;
            margin-bottom: 8px;
        }

        .adi-field-label span.req {
            color: #e50010;
        }

        .adi-field-input {
            width: 100%;
            padding: 12px 14px;
            font-family: 'Roboto', sans-serif;
            font-size: 14px;
            border: 1px solid #ccc;
            outline: none;
            transition: border-color 0.2s;
            background: #fff;
            box-sizing: border-box;
        }

        .adi-field-input:focus {
            border-color: #000;
        }

        .adi-field-input:disabled {
            background-color: #f5f5f5;
            color: #777;
            cursor: not-allowed;
        }

        .adi-form-actions-bar {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ebedee;
        }

        .adi-btn-primary {
            background-color: #000;
            color: #fff;
            font-family: 'Oswald', sans-serif;
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 12px 24px;
            border: 1px solid #000;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
            text-decoration: none;
        }

        .adi-btn-primary:hover {
            background-color: #333;
        }

        .adi-btn-secondary {
            background-color: #fff;
            color: #333;
            font-family: 'Oswald', sans-serif;
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 12px 24px;
            border: 1px solid #ccc;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
            text-decoration: none;
        }

        .adi-btn-secondary:hover {
            border-color: #000;
            color: #000;
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
                    <a href="index.php?act=logout" class="adi-header-link" style="color: #dc3545;" title="Đăng xuất"><i class="fa-solid fa-power-off"></i></a>
                </div>
            </header>

            <!-- Page Content -->
            <div class="adi-content-wrapper">
                
                <!-- Page Header & Breadcrumb -->
                <div class="adi-content-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
                    <div>
                        <h1 class="adi-page-title">
                            <?php 
                            if ($mode === 'add') echo "THÊM NGƯỜI DÙNG MỚI";
                            elseif ($mode === 'edit') echo "SỬA THÔNG TIN & PHÂN QUYỀN";
                            elseif ($mode === 'reset_pass') echo "ĐẶT LẠI MẬT KHẨU";
                            ?>
                        </h1>
                        <div class="adi-breadcrumb">
                            <a href="index.php?act=admin"><i class="fa-solid fa-house"></i> Trang chủ</a> > 
                            <a href="index.php?act=admin_nguoidung">Quản lý Người dùng</a> > 
                            <?php 
                            if ($mode === 'add') echo "Thêm mới";
                            elseif ($mode === 'edit') echo "Chỉnh sửa";
                            elseif ($mode === 'reset_pass') echo "Đổi mật khẩu";
                            ?>
                        </div>
                    </div>
                    <a href="index.php?act=admin_nguoidung" class="adi-btn-secondary">
                        <i class="fa-solid fa-arrow-left"></i> Quay lại danh sách
                    </a>
                </div>

                <!-- Error Message Alert -->
                <?php if(isset($_SESSION['error'])): ?>
                    <div style="background: #fef2f2; color: #991b1b; padding: 14px 18px; margin-bottom: 24px; border-left: 4px solid #e50010; font-family: 'Roboto', sans-serif; font-size: 14px;">
                        <i class="fa-solid fa-circle-exclamation"></i> <?= htmlspecialchars($_SESSION['error']) ?>
                    </div>
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>

                <!-- Form Card Box -->
                <div class="adi-box" style="max-width: 750px;">
                    <div class="adi-box-header">
                        <h3 style="font-family: 'Oswald', sans-serif; font-size: 16px; font-weight: 700; text-transform: uppercase; margin: 0;">
                            <i class="fa-solid fa-user-gear"></i> 
                            <?php 
                            if ($mode === 'add') echo "Tạo tài khoản người dùng mới";
                            elseif ($mode === 'edit') echo "Cập nhật thông tin: " . htmlspecialchars($user['username'] ?? '');
                            elseif ($mode === 'reset_pass') echo "Đặt lại mật khẩu cho: " . htmlspecialchars($user['username'] ?? '');
                            ?>
                        </h3>
                    </div>

                    <div class="adi-form-card">
                        <?php if ($mode === 'add'): ?>
                            <form action="index.php?act=admin_nguoidung_add" method="POST">
                                <div class="adi-field-group">
                                    <label class="adi-field-label" for="username">Tên đăng nhập <span class="req">*</span></label>
                                    <input type="text" id="username" name="username" class="adi-field-input" required placeholder="Nhập tên đăng nhập..." autofocus>
                                </div>

                                <div class="adi-field-group">
                                    <label class="adi-field-label" for="password">Mật khẩu <span class="req">*</span></label>
                                    <input type="password" id="password" name="password" class="adi-field-input" required placeholder="Nhập mật khẩu...">
                                </div>

                                <div class="adi-field-group">
                                    <label class="adi-field-label" for="email">Email <span class="req">*</span></label>
                                    <input type="email" id="email" name="email" class="adi-field-input" required placeholder="Nhập email...">
                                </div>

                                <div class="adi-field-group">
                                    <label class="adi-field-label" for="address">SỐ Điện Thoại</label>
                                    <input type="tel" id="sdt" name="sdt" class="adi-field-input" placeholder="Nhập số điện thoại (9-11 chữ số)..." pattern="[0-9]{9,11}" title="Số điện thoại phải có 9-11 chữ số">
                                </div>

                                <div class="adi-field-group">
                                    <label class="adi-field-label" for="address">Địa chỉ</label>
                                    <input type="text" id="address" name="address" class="adi-field-input" placeholder="Nhập địa chỉ nhận hàng...">
                                </div>

                                <div class="adi-field-group">
                                    <label class="adi-field-label" for="vai_tro_id">Vai trò (Phân quyền hệ thống) <span class="req">*</span></label>
                                    <select id="vai_tro_id" name="vai_tro_id" class="adi-field-input">
                                        <option value="2">User (Khách hàng)</option>
                                        <option value="1">Admin (Quản trị viên)</option>
                                    </select>
                                </div>

                                <div class="adi-form-actions-bar">
                                    <button type="submit" class="adi-btn-primary">
                                        <i class="fa-solid fa-floppy-disk"></i> Lưu người dùng
                                    </button>
                                    <a href="index.php?act=admin_nguoidung" class="adi-btn-secondary">Hủy bỏ</a>
                                </div>
                            </form>

                        <?php elseif ($mode === 'edit'): ?>
                            <form action="index.php?act=admin_nguoidung_edit" method="POST">
                                <input type="hidden" name="user_id" value="<?= $user['user_id'] ?>">

                                <div class="adi-field-group">
                                    <label class="adi-field-label">Tên đăng nhập</label>
                                    <input type="text" class="adi-field-input" value="<?= htmlspecialchars($user['username']) ?>" disabled>
                                    <span style="font-size: 12px; color: #767677; margin-top: 4px; display: block;">(Không thể sửa tên đăng nhập)</span>
                                </div>

                                <div class="adi-field-group">
                                    <label class="adi-field-label" for="email">Email <span class="req">*</span></label>
                                    <input type="email" id="email" name="email" class="adi-field-input" value="<?= htmlspecialchars($user['email']) ?>" required>
                                </div>

                                <div class="adi-field-group">
                                    <label class="adi-field-label" for="sdt">SỐ Điện Thoại</label>
                                    <input type="tel" id="sdt" name="sdt" class="adi-field-input" value="<?= htmlspecialchars($user['sdt'] ?? '') ?>" placeholder="Nhập số điện thoại..." pattern="[0-9]{9,11}" title="Số điện thoại phải có 9-11 chữ số">
                                </div>

                                <div class="adi-field-group">
                                    <label class="adi-field-label" for="address">Địa chỉ</label>
                                    <input type="text" id="address" name="address" class="adi-field-input" value="<?= htmlspecialchars($user['address'] ?? '') ?>">
                                </div>

                                <div class="adi-field-group">
                                    <label class="adi-field-label" for="vai_tro_id">Vai trò (Phân quyền hệ thống)</label>
                                    <select id="vai_tro_id" name="vai_tro_id" class="adi-field-input">
                                        <option value="2" <?= $user['vai_tro_id'] == 2 ? 'selected' : '' ?>>User (Khách hàng)</option>
                                        <option value="1" <?= $user['vai_tro_id'] == 1 ? 'selected' : '' ?>>Admin (Quản trị viên)</option>
                                    </select>
                                </div>

                                <div class="adi-form-actions-bar">
                                    <button type="submit" class="adi-btn-primary">
                                        <i class="fa-solid fa-floppy-disk"></i> Cập nhật thông tin
                                    </button>
                                    <a href="index.php?act=admin_nguoidung" class="adi-btn-secondary">Hủy bỏ</a>
                                </div>
                            </form>

                        <?php elseif ($mode === 'reset_pass'): ?>
                            <form action="index.php?act=admin_nguoidung_reset_pass" method="POST">
                                <input type="hidden" name="user_id" value="<?= $user['user_id'] ?>">

                                <div class="adi-field-group">
                                    <label class="adi-field-label" for="new_password">Mật khẩu mới <span class="req">*</span></label>
                                    <input type="password" id="new_password" name="new_password" class="adi-field-input" required placeholder="Nhập mật khẩu mới..." autofocus>
                                </div>

                                <div class="adi-form-actions-bar">
                                    <button type="submit" class="adi-btn-primary">
                                        <i class="fa-solid fa-key"></i> Xác nhận đổi mật khẩu
                                    </button>
                                    <a href="index.php?act=admin_nguoidung" class="adi-btn-secondary">Hủy bỏ</a>
                                </div>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</body>
</html>
