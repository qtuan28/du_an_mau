<<<<<<< HEAD
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Người Dùng - Admin System</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Admin External CSS & Embedded Fallback -->
    <link rel="stylesheet" href="assets/css/admin.css">
    <style>
        :root {
            --admin-font: 'Plus Jakarta Sans', sans-serif;
            --admin-font-heading: 'Outfit', sans-serif;
            --bg-primary: #f8fafc;
            --bg-surface: #ffffff;
            --primary-50: #eff6ff;
            --primary-100: #dbeafe;
            --primary-600: #2563eb;
            --primary-700: #1d4ed8;
            --accent-purple: #7c3aed;
            --accent-purple-light: #f3e8ff;
            --success-50: #f0fdf4;
            --success-100: #dcfce7;
            --success-600: #16a34a;
            --success-700: #15803d;
            --danger-50: #fef2f2;
            --danger-100: #fee2e2;
            --danger-600: #dc2626;
            --warning-50: #fffbeb;
            --warning-600: #d97706;
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
        .admin-navbar { background: var(--bg-surface); border-bottom: 1px solid var(--border-color); padding: 16px 32px; display: flex; align-items: center; justify-content: space-between; box-shadow: var(--shadow-sm); position: sticky; top: 0; z-index: 100; }
        .admin-brand { display: flex; align-items: center; gap: 12px; font-family: var(--admin-font-heading); font-size: 1.35rem; font-weight: 700; color: var(--primary-700); }
        .admin-nav-links { display: flex; align-items: center; gap: 16px; }
        .nav-item-btn { display: inline-flex; align-items: center; gap: 8px; padding: 8px 16px; border-radius: var(--radius-md); font-size: 0.875rem; font-weight: 600; color: var(--text-muted); background: #f1f5f9; transition: var(--transition); }
        .nav-item-btn:hover { background: var(--primary-50); color: var(--primary-600); transform: translateY(-1px); }

        .admin-container { max-width: 1280px; margin: 0 auto; padding: 32px 24px 60px; width: 100%; flex: 1; }
        .page-header { display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 20px; margin-bottom: 28px; }
        .page-title-group h1 { font-family: var(--admin-font-heading); font-size: 1.75rem; font-weight: 700; color: var(--text-dark); display: flex; align-items: center; gap: 12px; }
        .page-title-group p { color: var(--text-muted); font-size: 0.9rem; margin-top: 4px; }
        .title-icon { width: 44px; height: 44px; border-radius: var(--radius-md); background: linear-gradient(135deg, var(--primary-600), var(--accent-purple)); color: white; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25); }

        .btn-primary { display: inline-flex; align-items: center; gap: 8px; background: linear-gradient(135deg, var(--primary-600), var(--primary-700)); color: white; padding: 10px 20px; border-radius: var(--radius-md); font-weight: 600; font-size: 0.9rem; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2); transition: var(--transition); border: none; cursor: pointer; }
        .btn-primary:hover { background: linear-gradient(135deg, var(--primary-700), #1e40af); transform: translateY(-2px); box-shadow: 0 6px 16px rgba(37, 99, 235, 0.3); }

        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; margin-bottom: 28px; }
        .stat-card { background: var(--bg-surface); padding: 20px; border-radius: var(--radius-lg); border: 1px solid var(--border-color); box-shadow: var(--shadow-sm); display: flex; align-items: center; gap: 16px; transition: var(--transition); }
        .stat-card:hover { transform: translateY(-3px); box-shadow: var(--shadow-md); }
        .stat-icon-wrapper { width: 48px; height: 48px; border-radius: var(--radius-md); display: flex; align-items: center; justify-content: center; font-size: 1.35rem; }
        .stat-icon-wrapper.blue { background: var(--primary-50); color: var(--primary-600); }
        .stat-icon-wrapper.green { background: var(--success-50); color: var(--success-600); }
        .stat-icon-wrapper.red { background: var(--danger-50); color: var(--danger-600); }
        .stat-icon-wrapper.purple { background: var(--accent-purple-light); color: var(--accent-purple); }
        .stat-info .stat-value { font-size: 1.4rem; font-weight: 800; color: var(--text-dark); line-height: 1.2; }
        .stat-info .stat-label { font-size: 0.825rem; color: var(--text-muted); font-weight: 500; }

        .content-card { background: var(--bg-surface); border-radius: var(--radius-lg); border: 1px solid var(--border-color); box-shadow: var(--shadow-sm); overflow: hidden; margin-bottom: 30px; }
        .card-header-actions { padding: 20px 24px; border-bottom: 1px solid var(--border-color); display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 16px; background: #fafbfc; }

        .search-form { display: flex; align-items: center; gap: 10px; flex: 1; max-width: 480px; }
        .search-input-wrapper { position: relative; width: 100%; }
        .search-input-wrapper i { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: var(--text-light); font-size: 0.95rem; pointer-events: none; }
        .search-input { width: 100%; padding: 10px 14px 10px 40px; border-radius: var(--radius-md); border: 1px solid var(--border-color); font-size: 0.875rem; font-family: inherit; outline: none; transition: var(--transition); }
        .search-input:focus { border-color: var(--primary-600); box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15); }
        .btn-search { padding: 10px 18px; background: var(--text-dark); color: white; border-radius: var(--radius-md); font-size: 0.875rem; font-weight: 600; border: none; cursor: pointer; transition: var(--transition); white-space: nowrap; }
        .btn-search:hover { background: #1e293b; }
        .btn-clear-search { font-size: 0.85rem; color: var(--danger-600); font-weight: 600; display: inline-flex; align-items: center; gap: 4px; padding: 8px 12px; border-radius: 6px; }

        .table-responsive { width: 100%; overflow-x: auto; }
        .admin-table { width: 100%; border-collapse: collapse; text-align: left; font-size: 0.9rem; }
        .admin-table th { background: #f8fafc; padding: 14px 20px; font-weight: 700; color: var(--text-muted); font-size: 0.775rem; text-transform: uppercase; letter-spacing: 0.05em; border-bottom: 1px solid var(--border-color); }
        .admin-table td { padding: 16px 20px; border-bottom: 1px solid var(--border-color); vertical-align: middle; color: #334155; }
        .admin-table tbody tr { transition: var(--transition); }
        .admin-table tbody tr:hover { background-color: #f1f5f9; }

        .user-cell { display: flex; align-items: center; gap: 12px; }
        .user-avatar { width: 38px; height: 38px; border-radius: 50%; background: linear-gradient(135deg, #6366f1, #3b82f6); color: white; font-weight: 700; font-size: 0.95rem; display: flex; align-items: center; justify-content: center; text-transform: uppercase; }
        .user-avatar.admin { background: linear-gradient(135deg, #8b5cf6, #ec4899); }
        .user-details .username { font-weight: 700; color: var(--text-dark); font-size: 0.925rem; }
        .user-details .user-id { font-size: 0.75rem; color: var(--text-light); }

        .badge { display: inline-flex; align-items: center; gap: 6px; padding: 4px 10px; border-radius: 9999px; font-size: 0.775rem; font-weight: 700; }
        .badge-role-admin { background: var(--accent-purple-light); color: var(--accent-purple); border: 1px solid rgba(124, 58, 237, 0.2); }
        .badge-role-user { background: var(--primary-50); color: var(--primary-700); border: 1px solid var(--primary-100); }
        .badge-status-active { background: var(--success-50); color: var(--success-700); border: 1px solid var(--success-100); }
        .badge-status-locked { background: var(--danger-50); color: var(--danger-600); border: 1px solid var(--danger-100); }
        .badge-dot { width: 6px; height: 6px; border-radius: 50%; background-color: currentColor; }

        .action-buttons { display: flex; align-items: center; gap: 6px; }
        .action-btn { display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; border-radius: var(--radius-md); color: var(--text-muted); background: white; border: 1px solid var(--border-color); font-size: 0.85rem; transition: var(--transition); }
        .action-btn:hover { transform: translateY(-1px); box-shadow: var(--shadow-sm); }
        .action-btn.edit:hover { background: var(--primary-50); color: var(--primary-600); border-color: var(--primary-100); }
        .action-btn.lock:hover { background: var(--warning-50); color: var(--warning-600); }
        .action-btn.unlock:hover { background: var(--success-50); color: var(--success-600); }
        .action-btn.key:hover { background: #f3e8ff; color: #7c3aed; }
        .action-btn.delete:hover { background: var(--danger-50); color: var(--danger-600); }

        .empty-state { text-align: center; padding: 48px 24px; }
        .empty-state i { font-size: 3rem; color: var(--text-light); margin-bottom: 12px; }
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
                <a href="index.php?act=admin" class="nav-item-btn">
                    <i class="fa-solid fa-gauge-high"></i> Dashboard
                </a>
                <a href="index.php?act=index" class="nav-item-btn" target="_blank">
                    <i class="fa-solid fa-globe"></i> Trang chủ website
                </a>
                <a href="index.php?act=logout" class="nav-item-btn" style="color: var(--danger-600);">
                    <i class="fa-solid fa-right-from-bracket"></i> Đăng xuất
                </a>
            </div>
        </header>

        <!-- Main Content Area -->
        <main class="admin-container">
            <!-- Page Header -->
            <div class="page-header">
                <div class="page-title-group">
                    <h1>
                        <div class="title-icon">
                            <i class="fa-solid fa-users"></i>
                        </div>
                        QUẢN LÝ NGƯỜI DÙNG (ADMIN)
                    </h1>
                    <p>Quản lý danh sách tài khoản, phân quyền quản trị và trạng thái người dùng</p>
                </div>
                <a href="index.php?act=admin_nguoidung_add" class="btn-primary">
                    <i class="fa-solid fa-user-plus"></i> + Thêm người dùng mới
                </a>
            </div>

            <?php
            // Calculated Stats
            $totalUsers = !empty($dsNguoiDung) ? count($dsNguoiDung) : 0;
            $activeUsers = 0;
            $lockedUsers = 0;
            $adminUsers = 0;

            if (!empty($dsNguoiDung)) {
                foreach ($dsNguoiDung as $userItem) {
                    if (($userItem['trang_thai'] ?? 1) == 1) $activeUsers++;
                    else $lockedUsers++;
                    if ($userItem['vai_tro_id'] == 1) $adminUsers++;
                }
            }
            ?>

            <!-- Stats Overview Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon-wrapper blue">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <div class="stat-info">
                        <div class="stat-value"><?= $totalUsers ?></div>
                        <div class="stat-label">Tổng người dùng</div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon-wrapper purple">
                        <i class="fa-solid fa-user-shield"></i>
                    </div>
                    <div class="stat-info">
                        <div class="stat-value"><?= $adminUsers ?></div>
                        <div class="stat-label">Quản trị viên (Admin)</div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon-wrapper green">
                        <i class="fa-solid fa-user-check"></i>
                    </div>
                    <div class="stat-info">
                        <div class="stat-value"><?= $activeUsers ?></div>
                        <div class="stat-label">Tài khoản hoạt động</div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon-wrapper red">
                        <i class="fa-solid fa-user-lock"></i>
                    </div>
                    <div class="stat-info">
                        <div class="stat-value"><?= $lockedUsers ?></div>
                        <div class="stat-label">Tài khoản bị khóa</div>
                    </div>
                </div>
            </div>

            <!-- Content Card with Search and Table -->
            <div class="content-card">
                <!-- Search & Filters Header -->
                <div class="card-header-actions">
                    <form action="index.php" method="GET" class="search-form">
                        <input type="hidden" name="act" value="admin_nguoidung">
                        <div class="search-input-wrapper">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <input type="text" 
                                   name="keyword" 
                                   class="search-input"
                                   placeholder="Nhập tên đăng nhập, email, địa chỉ..." 
                                   value="<?= htmlspecialchars($keyword ?? '') ?>">
                        </div>
                        <button type="submit" class="btn-search">Tìm kiếm</button>
                        <?php if (!empty($keyword)): ?>
                            <a href="index.php?act=admin_nguoidung" class="btn-clear-search">
                                <i class="fa-solid fa-xmark"></i> Xóa tìm kiếm
                            </a>
                        <?php endif; ?>
                    </form>
                </div>

                <!-- Table -->
                <div class="table-responsive">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>ID & Người dùng</th>
                                <th>Email</th>
                                <th>Địa chỉ</th>
                                <th>Vai trò (Phân quyền)</th>
                                <th>Trạng thái</th>
                                <th style="text-align: center;">Chức năng</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($dsNguoiDung)): ?>
                                <?php foreach ($dsNguoiDung as $u): ?>
                                    <?php 
                                        $initial = strtoupper(substr($u['username'], 0, 1));
                                        $isAdminRole = ($u['vai_tro_id'] == 1);
                                        $isActive = (($u['trang_thai'] ?? 1) == 1);
                                        $isSelf = (isset($_SESSION['user']['user_id']) && $u['user_id'] == $_SESSION['user']['user_id']);
                                    ?>
                                    <tr>
                                        <td>
                                            <div class="user-cell">
                                                <div class="user-avatar <?= $isAdminRole ? 'admin' : '' ?>">
                                                    <?= $initial ?>
                                                </div>
                                                <div class="user-details">
                                                    <div class="username">
                                                        <?= htmlspecialchars($u['username']) ?>
                                                        <?php if ($isSelf): ?>
                                                            <span style="font-size: 0.75rem; color: var(--primary-600); font-weight: normal;">(Bạn)</span>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="user-id">ID: #<?= $u['user_id'] ?></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <i class="fa-regular fa-envelope" style="color: var(--text-light); margin-right: 6px;"></i>
                                            <?= htmlspecialchars($u['email']) ?>
                                        </td>
                                        <td>
                                            <?php if (!empty($u['address'])): ?>
                                                <i class="fa-solid fa-location-dot" style="color: var(--text-light); margin-right: 6px;"></i>
                                                <?= htmlspecialchars($u['address']) ?>
                                            <?php else: ?>
                                                <span style="color: var(--text-light); font-style: italic;">Chưa cập nhật</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($isAdminRole): ?>
                                                <span class="badge badge-role-admin">
                                                    <i class="fa-solid fa-user-shield"></i> <?= htmlspecialchars($u['ten_vai_tro'] ?? 'Admin') ?>
                                                </span>
                                            <?php else: ?>
                                                <span class="badge badge-role-user">
                                                    <i class="fa-solid fa-user"></i> <?= htmlspecialchars($u['ten_vai_tro'] ?? 'User') ?>
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($isActive): ?>
                                                <span class="badge badge-status-active">
                                                    <span class="badge-dot"></span> Hoạt động
                                                </span>
                                            <?php else: ?>
                                                <span class="badge badge-status-locked">
                                                    <span class="badge-dot"></span> Đã bị khóa
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="action-buttons" style="justify-content: center;">
                                                <!-- Sửa & Phân quyền -->
                                                <a href="index.php?act=admin_nguoidung_edit&id=<?= $u['user_id'] ?>" 
                                                   class="action-btn edit" 
                                                   title="Sửa & Phân quyền">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </a>

                                                <!-- Đặt lại MK -->
                                                <a href="index.php?act=admin_nguoidung_reset_pass&id=<?= $u['user_id'] ?>" 
                                                   class="action-btn key" 
                                                   title="Đặt lại MK">
                                                    <i class="fa-solid fa-key"></i>
                                                </a>

                                                <!-- Khóa / Mở khóa -->
                                                <?php if (!$isSelf): ?>
                                                    <?php if ($isActive): ?>
                                                        <a href="index.php?act=admin_nguoidung_toggle&id=<?= $u['user_id'] ?>" 
                                                           class="action-btn lock" 
                                                           title="Khóa"
                                                           onclick="return confirm('Khóa tài khoản này?')">
                                                            <i class="fa-solid fa-lock"></i>
                                                        </a>
                                                    <?php else: ?>
                                                        <a href="index.php?act=admin_nguoidung_toggle&id=<?= $u['user_id'] ?>" 
                                                           class="action-btn unlock" 
                                                           title="Mở khóa"
                                                           onclick="return confirm('Mở khóa tài khoản này?')">
                                                            <i class="fa-solid fa-lock-open"></i>
                                                        </a>
                                                    <?php endif; ?>

                                                    <!-- Xóa -->
                                                    <a href="index.php?act=admin_nguoidung_delete&id=<?= $u['user_id'] ?>" 
                                                       class="action-btn delete" 
                                                       title="Xóa"
                                                       onclick="return confirm('Xóa vĩnh viễn tài khoản này?')">
                                                        <i class="fa-solid fa-trash-can"></i>
                                                    </a>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6">
                                        <div class="empty-state">
                                            <i class="fa-solid fa-user-slash"></i>
                                            <h3>Không tìm thấy người dùng nào.</h3>
                                            <p>Hãy thử tìm kiếm từ khóa khác hoặc quay lại danh sách đầy đủ.</p>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="admin-footer">
            &copy; <?= date('Y') ?> Pickleball Admin Management System.
        </footer>
    </div>
</body>
</html>
=======
>>>>>>> bdfd4d39a6713ed9d504e3106382d0191df6bd33
