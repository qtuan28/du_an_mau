<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php 
        if ($mode === 'add') echo "Thêm người dùng mới";
        elseif ($mode === 'edit') echo "Sửa thông tin & Phân quyền người dùng";
        elseif ($mode === 'reset_pass') echo "Đặt lại mật khẩu người dùng";
        ?> - Admin System
    </title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Admin CSS Link & Embedded Fallback -->
    <link rel="stylesheet" href="assets/css/admin.css">
    <style>
        :root {
            --admin-font: 'Plus Jakarta Sans', sans-serif;
            --admin-font-heading: 'Outfit', sans-serif;
            --bg-primary: #f8fafc;
            --bg-surface: #ffffff;
            --primary-50: #eff6ff;
            --primary-600: #2563eb;
            --primary-700: #1d4ed8;
            --text-dark: #0f172a;
            --text-muted: #64748b;
            --text-light: #94a3b8;
            --border-color: #e2e8f0;
            --radius-md: 10px;
            --radius-lg: 16px;
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.05);
            --shadow-md: 0 4px 6px -1px rgba(0,0,0,0.07);
            --transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: var(--admin-font); background-color: var(--bg-primary); color: var(--text-dark); line-height: 1.6; }
        a { color: inherit; text-decoration: none; }

        .admin-layout { min-height: 100vh; display: flex; flex-direction: column; }
        .admin-navbar { background: var(--bg-surface); border-bottom: 1px solid var(--border-color); padding: 16px 32px; display: flex; align-items: center; justify-content: space-between; box-shadow: var(--shadow-sm); }
        .admin-brand { display: flex; align-items: center; gap: 12px; font-family: var(--admin-font-heading); font-size: 1.35rem; font-weight: 700; color: var(--primary-700); }
        .admin-nav-links { display: flex; align-items: center; gap: 16px; }
        .nav-item-btn { display: inline-flex; align-items: center; gap: 8px; padding: 8px 16px; border-radius: var(--radius-md); font-size: 0.875rem; font-weight: 600; color: var(--text-muted); background: #f1f5f9; transition: var(--transition); }
        .nav-item-btn:hover { background: var(--primary-50); color: var(--primary-600); }

        .admin-container { max-width: 900px; margin: 0 auto; padding: 32px 24px 60px; width: 100%; flex: 1; }
        .btn-secondary { display: inline-flex; align-items: center; gap: 8px; background: white; color: var(--text-dark); border: 1px solid var(--border-color); padding: 9px 16px; border-radius: var(--radius-md); font-weight: 600; font-size: 0.875rem; transition: var(--transition); cursor: pointer; }
        .btn-secondary:hover { background: #f8fafc; border-color: var(--text-light); color: var(--primary-600); }

        .btn-primary { display: inline-flex; align-items: center; gap: 8px; background: linear-gradient(135deg, var(--primary-600), var(--primary-700)); color: white; padding: 10px 20px; border-radius: var(--radius-md); font-weight: 600; font-size: 0.9rem; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2); transition: var(--transition); border: none; cursor: pointer; }
        .btn-primary:hover { background: linear-gradient(135deg, var(--primary-700), #1e40af); transform: translateY(-1px); }

        .form-card { background: var(--bg-surface); border-radius: var(--radius-lg); border: 1px solid var(--border-color); box-shadow: var(--shadow-md); overflow: hidden; margin-top: 20px; }
        .form-card-header { padding: 24px 32px; background: linear-gradient(to right, #f8fafc, #f1f5f9); border-bottom: 1px solid var(--border-color); display: flex; align-items: center; gap: 16px; }
        .form-card-header h2 { font-family: var(--admin-font-heading); font-size: 1.35rem; font-weight: 700; color: var(--text-dark); }
        .title-icon { width: 44px; height: 44px; border-radius: var(--radius-md); background: linear-gradient(135deg, var(--primary-600), #7c3aed); color: white; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; flex-shrink: 0; }

        .form-card-body { padding: 32px; }
        .form-group { margin-bottom: 22px; }
        .form-label { display: block; font-weight: 600; font-size: 0.875rem; color: var(--text-dark); margin-bottom: 8px; }
        .form-label span.required { color: #dc2626; }
        
        .input-with-icon { position: relative; }
        .input-with-icon i { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: var(--text-light); font-size: 1rem; pointer-events: none; }
        .form-control { width: 100%; padding: 11px 16px 11px 42px; border-radius: var(--radius-md); border: 1px solid var(--border-color); font-size: 0.9rem; font-family: inherit; background: white; transition: var(--transition); outline: none; color: var(--text-dark); }
        .form-control:focus { border-color: var(--primary-600); box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.12); }
        .form-control:disabled { background-color: #f1f5f9; color: #94a3b8; cursor: not-allowed; }
        .form-hint { font-size: 0.8rem; color: var(--text-muted); margin-top: 6px; display: block; }
        .form-actions { display: flex; align-items: center; justify-content: flex-end; gap: 12px; margin-top: 32px; padding-top: 20px; border-top: 1px solid var(--border-color); }
        .admin-footer { text-align: center; padding: 24px; color: var(--text-light); font-size: 0.825rem; border-top: 1px solid var(--border-color); background: var(--bg-surface); margin-top: auto; }
    </style>
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
                <a href="index.php?act=admin_nguoidung" class="nav-item-btn">
                    <i class="fa-solid fa-arrow-left"></i> ← Quay lại Danh sách người dùng
                </a>
            </div>
        </header>

        <!-- Main Content Area -->
        <main class="admin-container">
            <div class="form-card">
                <?php if ($mode === 'add'): ?>
                    <!-- Form Header -->
                    <div class="form-card-header">
                        <div class="title-icon">
                            <i class="fa-solid fa-user-plus"></i>
                        </div>
                        <div>
                            <h2>THÊM TÀI KHOẢN NGƯỜI DÙNG MỚI</h2>
                            <p style="font-size: 0.85rem; color: var(--text-muted);">Nhập đầy đủ thông tin để khởi tạo người dùng trong hệ thống</p>
                        </div>
                    </div>

                    <!-- Form Body -->
                    <div class="form-card-body">
                        <form action="index.php?act=admin_nguoidung_add" method="POST">
                            <div class="form-group">
                                <label class="form-label">Tên đăng nhập <span class="required">*</span></label>
                                <div class="input-with-icon">
                                    <i class="fa-solid fa-user"></i>
                                    <input type="text" name="username" class="form-control" required placeholder="Nhập tên đăng nhập...">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Mật khẩu <span class="required">*</span></label>
                                <div class="input-with-icon">
                                    <i class="fa-solid fa-lock"></i>
                                    <input type="password" name="password" class="form-control" required placeholder="Nhập mật khẩu...">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Email <span class="required">*</span></label>
                                <div class="input-with-icon">
                                    <i class="fa-solid fa-envelope"></i>
                                    <input type="email" name="email" class="form-control" required placeholder="Nhập email...">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Địa chỉ</label>
                                <div class="input-with-icon">
                                    <i class="fa-solid fa-location-dot"></i>
                                    <input type="text" name="address" class="form-control" placeholder="Nhập địa chỉ...">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Vai trò (Phân quyền) <span class="required">*</span></label>
                                <div class="input-with-icon">
                                    <i class="fa-solid fa-user-shield"></i>
                                    <select name="vai_tro_id" class="form-control">
                                        <option value="2">User (Khách hàng)</option>
                                        <option value="1">Admin (Quản trị viên)</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-actions">
                                <a href="index.php?act=admin_nguoidung" class="btn-secondary">Hủy bỏ</a>
                                <button type="submit" class="btn-primary">Thêm người dùng</button>
                            </div>
                        </form>
                    </div>

                <?php elseif ($mode === 'edit'): ?>
                    <!-- Form Header -->
                    <div class="form-card-header">
                        <div class="title-icon" style="background: linear-gradient(135deg, #059669, #10b981);">
                            <i class="fa-solid fa-user-pen"></i>
                        </div>
                        <div>
                            <h2>SỬA THÔNG TIN & PHÂN QUYỀN: <?= htmlspecialchars($user['username']) ?></h2>
                            <p style="font-size: 0.85rem; color: var(--text-muted);">Cập nhật email, địa chỉ và phân quyền hệ thống</p>
                        </div>
                    </div>

                    <!-- Form Body -->
                    <div class="form-card-body">
                        <form action="index.php?act=admin_nguoidung_edit" method="POST">
                            <input type="hidden" name="user_id" value="<?= $user['user_id'] ?>">

                            <div class="form-group">
                                <label class="form-label">Tên đăng nhập</label>
                                <div class="input-with-icon">
                                    <i class="fa-solid fa-user"></i>
                                    <input type="text" class="form-control" value="<?= htmlspecialchars($user['username']) ?>" disabled>
                                </div>
                                <span class="form-hint">(Không thể sửa tên đăng nhập)</span>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Email <span class="required">*</span></label>
                                <div class="input-with-icon">
                                    <i class="fa-solid fa-envelope"></i>
                                    <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Địa chỉ</label>
                                <div class="input-with-icon">
                                    <i class="fa-solid fa-location-dot"></i>
                                    <input type="text" name="address" class="form-control" value="<?= htmlspecialchars($user['address'] ?? '') ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Vai trò (Phân quyền)</label>
                                <div class="input-with-icon">
                                    <i class="fa-solid fa-user-shield"></i>
                                    <select name="vai_tro_id" class="form-control">
                                        <option value="2" <?= $user['vai_tro_id'] == 2 ? 'selected' : '' ?>>User (Khách hàng)</option>
                                        <option value="1" <?= $user['vai_tro_id'] == 1 ? 'selected' : '' ?>>Admin (Quản trị viên)</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-actions">
                                <a href="index.php?act=admin_nguoidung" class="btn-secondary">Hủy bỏ</a>
                                <button type="submit" class="btn-primary">Cập nhật thông tin</button>
                            </div>
                        </form>
                    </div>

                <?php elseif ($mode === 'reset_pass'): ?>
                    <!-- Form Header -->
                    <div class="form-card-header">
                        <div class="title-icon" style="background: linear-gradient(135deg, #7c3aed, #a855f7);">
                            <i class="fa-solid fa-key"></i>
                        </div>
                        <div>
                            <h2>ĐẶT LẠI MẬT KHẨU TÀI KHOẢN: <?= htmlspecialchars($user['username']) ?></h2>
                            <p style="font-size: 0.85rem; color: var(--text-muted);">Cập nhật mật khẩu mới cho tài khoản người dùng</p>
                        </div>
                    </div>

                    <!-- Form Body -->
                    <div class="form-card-body">
                        <form action="index.php?act=admin_nguoidung_reset_pass" method="POST">
                            <input type="hidden" name="user_id" value="<?= $user['user_id'] ?>">

                            <div class="form-group">
                                <label class="form-label">Mật khẩu mới <span class="required">*</span></label>
                                <div class="input-with-icon">
                                    <i class="fa-solid fa-lock"></i>
                                    <input type="password" name="new_password" class="form-control" required placeholder="Nhập mật khẩu mới...">
                                </div>
                            </div>

                            <div class="form-actions">
                                <a href="index.php?act=admin_nguoidung" class="btn-secondary">Hủy bỏ</a>
                                <button type="submit" class="btn-primary" style="background: linear-gradient(135deg, #7c3aed, #6d28d9);">
                                    Xác nhận đổi mật khẩu
                                </button>
                            </div>
                        </form>
                    </div>
                <?php endif; ?>
            </div>
        </main>

        <!-- Footer -->
        <footer class="admin-footer">
            &copy; <?= date('Y') ?> Pickleball Admin Management System.
        </footer>
    </div>
</body>
</html>
