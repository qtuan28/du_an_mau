<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Người Dùng | Bảng Điều Khiển Admin</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
    .adi-user-tabs {
        display: flex;
        gap: 8px;
        border-bottom: 2px solid #e9ecef;
        margin-bottom: 0;
        background: #f8f9fa;
        padding: 12px 15px 0 15px;
        border-radius: 4px 4px 0 0;
    }
    .adi-tab-item {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 9px 18px;
        font-size: 13px;
        font-weight: 700;
        color: #555;
        text-decoration: none;
        border-bottom: 3px solid transparent;
        transition: all 0.2s ease-in-out;
        border-radius: 4px 4px 0 0;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }
    .adi-tab-item:hover {
        color: #3c8dbc;
        background: #ffffff;
    }
    .adi-tab-item.active {
        color: #3c8dbc;
        border-bottom-color: #3c8dbc;
        background: #ffffff;
        box-shadow: 0 -2px 5px rgba(0,0,0,0.03);
    }
    .adi-badge-count {
        font-size: 11px;
        padding: 2px 7px;
        border-radius: 10px;
        background: #6c757d;
        color: #fff;
        font-weight: 700;
    }
    .adi-tab-item.active .adi-badge-count {
        background: #3c8dbc;
    }
    .adi-badge-count.bg-user {
        background: #6c757d;
    }
    .adi-tab-item.active .adi-badge-count.bg-user {
        background: #4b5563;
    }
    .adi-badge-count.bg-admin {
        background: #17a2b8;
    }
    .adi-tab-item.active .adi-badge-count.bg-admin {
        background: #0891b2;
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
                <div class="adi-content-header">
                    <h1 class="adi-page-title">Quản lý Người Dùng</h1>
                    <div class="adi-breadcrumb">
                        <a href="index.php?act=admin"><i class="fa-solid fa-house"></i> Trang chủ</a> > 
                        <a href="#">Quản lý hệ thống</a> > Người dùng
                    </div>
                </div>

                <?php
                if(isset($_SESSION['success'])){
                    echo "<div style='color: #155724; background: #d4edda; padding: 10px; margin-bottom: 20px; border: 1px solid #c3e6cb;'>".$_SESSION['success']."</div>";
                    unset($_SESSION['success']);
                }
                if(isset($_SESSION['error'])){
                    echo "<div style='color: #721c24; background: #f8d7da; padding: 10px; margin-bottom: 20px; border: 1px solid #f5c6cb;'>".$_SESSION['error']."</div>";
                    unset($_SESSION['error']);
                }
                ?>

                <!-- Main Box -->
                <div class="adi-box">
                    
                    <!-- Tab Phân Loại Tài Khoản -->
                    <?php
                        $currentRole = $roleFilter ?? 'all';
                        $kwQuery = !empty($keyword) ? '&keyword=' . urlencode($keyword) : '';
                    ?>
                    <div class="adi-user-tabs">
                        <a href="index.php?act=admin_nguoidung&role=all<?= $kwQuery ?>" 
                           class="adi-tab-item <?= ($currentRole == 'all') ? 'active' : '' ?>">
                            <i class="fa-solid fa-users"></i> Tất cả người dùng
                            <span class="adi-badge-count"><?= $userCounts['all'] ?? 0 ?></span>
                        </a>
                        <a href="index.php?act=admin_nguoidung&role=user<?= $kwQuery ?>" 
                           class="adi-tab-item <?= ($currentRole == 'user') ? 'active' : '' ?>">
                            <i class="fa-solid fa-user"></i> Tài khoản Khách hàng
                            <span class="adi-badge-count bg-user"><?= $userCounts['user'] ?? 0 ?></span>
                        </a>
                        <a href="index.php?act=admin_nguoidung&role=admin<?= $kwQuery ?>" 
                           class="adi-tab-item <?= ($currentRole == 'admin') ? 'active' : '' ?>">
                            <i class="fa-solid fa-user-shield"></i> Quản trị viên (Admin)
                            <span class="adi-badge-count bg-admin"><?= $userCounts['admin'] ?? 0 ?></span>
                        </a>
                    </div>

                    <!-- Complex Toolbar -->
                    <div class="adi-box-header" style="padding: 15px;">
                        <div class="adi-toolbar">
                            <form method="GET" action="index.php" style="display: flex; gap: 6px; align-items: center;">
                                <input type="hidden" name="act" value="admin_nguoidung">
                                <input type="hidden" name="role" value="<?= htmlspecialchars($currentRole) ?>">
                                <input type="text" name="keyword" value="<?= htmlspecialchars($keyword ?? '') ?>" placeholder="Tên, email, địa chỉ..." class="adi-form-control" style="width: 230px;">
                                <button type="submit" class="adi-btn-outline" style="padding: 6px 14px;"><i class="fa-solid fa-magnifying-glass"></i> Tìm kiếm</button>
                                <?php if (!empty($keyword)): ?>
                                    <a href="index.php?act=admin_nguoidung&role=<?= htmlspecialchars($currentRole) ?>" class="adi-btn-outline" style="padding: 6px 10px; color: #dc3545; text-decoration: none;" title="Xóa tìm kiếm">
                                        <i class="fa-solid fa-xmark"></i> Bỏ lọc
                                    </a>
                                <?php endif; ?>
                            </form>
                        </div>
                        
                        <div>
                            <a href="index.php?act=admin_nguoidung_add" class="adi-btn" style="background: #3c8dbc; border-color: #367fa9; color: #fff;">
                                <i class="fa-solid fa-plus"></i> Thêm mới
                            </a>
                        </div>
                    </div>

                    <!-- Complex Data Table -->
                    <div class="adi-table-responsive">
                        <table class="adi-table">
                            <thead>
                                <tr>
                                    <th style="width: 40px; text-align: center;"><input type="checkbox"></th>
                                    <th style="width: 60px; text-align: center;">STT</th>
                                    <th>NGƯỜI DÙNG</th>
                                    <th>EMAIL</th>
                                    <th>SỐ ĐIỆN THOẠI</th>
                                    <th style="text-align: center;">VAI TRÒ</th>
                                    <th style="text-align: center;">TRẠNG THÁI</th>
                                    <th style="text-align: center;">ĐĂNG NHẬP CUỐI</th>
                                    <th style="text-align: center;">TÁC VỤ</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php if (!empty($dsNguoiDung)): ?>
                                <?php $stt = 1; foreach ($dsNguoiDung as $u): ?>
                                    <?php 
                                        $isAdminRole = ($u['vai_tro_id'] == 1);
                                        $isActive = (($u['trang_thai'] ?? 1) == 1);
                                        $isSelf = (isset($_SESSION['user']['user_id']) && $u['user_id'] == $_SESSION['user']['user_id']);
                                        $userPass = $u['password'] ?? '';
                                    ?>
                                    <tr <?= $isSelf ? 'style="background: #fdfdfd;"' : (!$isActive ? 'style="background: #fef2f2;"' : '') ?>>
                                        <td style="text-align: center;"><input type="checkbox" <?= $isSelf ? 'disabled' : '' ?>></td>
                                        <td style="text-align: center; font-weight: bold;"><?= $stt++ ?></td>
                                        <td>
                                            <strong><?= htmlspecialchars($u['username']) ?></strong>
                                            <?php if ($isSelf): ?>
                                                <span style="font-size: 11px; color: #10b981; margin-left: 5px;">(Bạn)</span>
                                            <?php endif; ?>
                                            <?php if (!$isActive): ?>
                                                <span style="font-size: 10px; background: #e50010; color: #fff; padding: 2px 6px; margin-left: 6px; font-weight: 700;">ĐÃ KHÓA</span>
                                            <?php endif; ?>
                                            <?php
                                                // Cảnh báo không hoạt động >90 ngày
                                                $lastLogin = $u['last_login'] ?? null;
                                                $soNgay = $lastLogin ? (int)((time() - strtotime($lastLogin)) / 86400) : null;
                                                $isInactive = ($lastLogin === null || $soNgay > 90);
                                            ?>
                                            <?php if ($isInactive && !$isAdminRole): ?>
                                                <span style="font-size: 10px; background: #f89406; color: #fff; padding: 2px 6px; margin-left: 4px; font-weight: 700;">⚠ KHÔNG HOẠT ĐỘNG</span>
                                            <?php endif; ?>
                                            <div style="font-size: 11px; color: #777;">ID: <?= $u['user_id'] ?></div>
                                        </td>
                                        <td><?= htmlspecialchars($u['email']) ?></td>
                                        <td><?= htmlspecialchars($u['sdt'] ?? '—') ?></td>

                                        <td style="text-align: center;">
                                            <?php if ($isAdminRole): ?>
                                                <span style="background: #17a2b8; color: #fff; padding: 2px 6px; font-size: 11px; font-weight: bold;">ADMIN</span>
                                            <?php else: ?>
                                                <span style="background: #6c757d; color: #fff; padding: 2px 6px; font-size: 11px; font-weight: bold;">USER</span>
                                            <?php endif; ?>
                                        </td>

                                        <td style="text-align: center;">
                                            <?php if ($isActive): ?>
                                                <span style="background: #e6f4ea; color: #137333; padding: 4px 10px; font-weight: 700; font-size: 11px; display: inline-flex; align-items: center; gap: 6px;">
                                                    <i class="fa-solid fa-circle" style="font-size: 8px; color: #1e8e3e;"></i> Active
                                                </span>
                                            <?php else: ?>
                                                <span style="background: #fce8e6; color: #c5221f; padding: 4px 10px; font-weight: 700; font-size: 11px; display: inline-flex; align-items: center; gap: 6px;">
                                                    <i class="fa-solid fa-lock" style="font-size: 10px; color: #d93025;"></i> Locked
                                                </span>
                                            <?php endif; ?>
                                        </td>

                                        <td style="text-align: center; white-space: nowrap;">
                                            <?php if ($lastLogin): ?>
                                                <div style="font-size: 12px; color: #333;"><?= date('d/m/Y', strtotime($lastLogin)) ?></div>
                                                <div style="font-size: 11px; color: <?= $isInactive ? '#f89406' : '#777'; ?>">
                                                    <?= $soNgay > 0 ? $soNgay . ' ngày trước' : 'Hôm nay' ?>
                                                </div>
                                            <?php else: ?>
                                                <span style="color: #999; font-size: 11px;">Chưa đăng nhập</span>
                                            <?php endif; ?>
                                        </td>

                                        <td style="text-align: center;">
                                            <a href="index.php?act=admin_nguoidung_edit&id=<?= $u['user_id'] ?>" class="adi-action-btn edit" title="Sửa">Sửa <i class="fa-solid fa-pen"></i></a>
                                            <?php if (!$isSelf): ?>
                                                <?php if ($isActive): ?>
                                                    <a href="index.php?act=admin_nguoidung_toggle&id=<?= $u['user_id'] ?>" onclick="return confirm('Bạn có chắc muốn khóa tài khoản này?')" class="adi-action-btn warning" style="background: #ffc107; color: #000;" title="Khóa tài khoản">Khóa <i class="fa-solid fa-lock"></i></a>
                                                <?php else: ?>
                                                    <a href="index.php?act=admin_nguoidung_toggle&id=<?= $u['user_id'] ?>" onclick="return confirm('Bạn có chắc muốn mở khóa tài khoản này?')" class="adi-action-btn success" style="background: #28a745; color: #fff;" title="Mở khóa tài khoản">Mở <i class="fa-solid fa-lock-open"></i></a>
                                                <?php endif; ?>
                                                <a href="index.php?act=admin_nguoidung_delete&id=<?= $u['user_id'] ?>" onclick="return confirm('Bạn có chắc muốn xóa tài khoản này?')" class="adi-action-btn delete" title="Xóa">Xóa <i class="fa-solid fa-xmark"></i></a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="9" style="text-align: center; padding: 30px; color: #777;">
                                        <i class="fa-solid fa-user-slash" style="font-size: 24px; margin-bottom: 8px; color: #ccc;"></i><br>
                                        <?php if ($currentRole == 'admin'): ?>
                                            Không tìm thấy tài khoản Quản trị viên (Admin) nào.
                                        <?php elseif ($currentRole == 'user'): ?>
                                            Không tìm thấy tài khoản Khách hàng nào.
                                        <?php else: ?>
                                            Không tìm thấy người dùng nào.
                                        <?php endif; ?>
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

    <script>
    function togglePassVisibility(userId, realPass) {
        const passSpan = document.getElementById('pass_' + userId);
        const eyeIcon = document.getElementById('eye_icon_' + userId);
        if (passSpan.getAttribute('data-hidden') === 'true') {
            passSpan.textContent = realPass;
            passSpan.setAttribute('data-hidden', 'false');
            eyeIcon.className = 'fa-solid fa-eye';
        } else {
            passSpan.textContent = '••••••••';
            passSpan.setAttribute('data-hidden', 'true');
            eyeIcon.className = 'fa-solid fa-eye-slash';
        }
    }

    function updateUserStatus(userId, newStatus) {
        if (confirm(newStatus === 0 ? 'Bạn có chắc muốn KHÓA tài khoản này?' : 'Bạn có chắc muốn MỞ KHÓA tài khoản này?')) {
            window.location.href = 'index.php?act=admin_nguoidung_toggle&id=' + userId + '&status=' + newStatus;
        } else {
            window.location.reload();
        }
    }
    </script>
</body>
</html>
