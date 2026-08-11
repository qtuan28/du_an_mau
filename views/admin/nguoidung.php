<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Người Dùng | Bảng Điều Khiển Admin</title>
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
                    
                    <!-- Complex Toolbar -->
                    <div class="adi-box-header">
                        <div class="adi-toolbar">
                            <form method="GET" action="index.php" style="display: flex; gap: 5px;">
                                <input type="hidden" name="act" value="admin_nguoidung">
                                <input type="text" name="keyword" value="<?= htmlspecialchars($keyword ?? '') ?>" placeholder="Tên, email..." class="adi-form-control" style="width: 200px;">
                                <select class="adi-form-control">
                                    <option>Tìm theo...</option>
                                    <option>Tên người dùng</option>
                                    <option>Email</option>
                                </select>
                                <button type="submit" class="adi-btn-outline" style="padding: 6px 12px;"><i class="fa-solid fa-magnifying-glass"></i></button>
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
                                    <th>MẬT KHẨU</th>
                                    <th style="text-align: center;">VAI TRÒ</th>
                                    <th style="text-align: center;">XÁC THỰC</th>
                                    <th>TRẠNG THÁI</th>
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
                                    <tr <?= $isSelf ? 'style="background: #fdfdfd;"' : '' ?>>
                                        <td style="text-align: center;"><input type="checkbox" <?= $isSelf ? 'disabled' : '' ?>></td>
                                        <td style="text-align: center; font-weight: bold;"><?= $stt++ ?></td>
                                        <td>
                                            <strong><?= htmlspecialchars($u['username']) ?></strong>
                                            <?php if ($isSelf): ?>
                                                <span style="font-size: 11px; color: #10b981; margin-left: 5px;">(Bạn)</span>
                                            <?php endif; ?>
                                            <div style="font-size: 11px; color: #777;">ID: <?= $u['user_id'] ?></div>
                                        </td>
                                        <td><?= htmlspecialchars($u['email']) ?></td>

                                        <td>
                                            <div style="display: flex; align-items: center; gap: 8px;">
                                                <span id="pass_<?= $u['user_id'] ?>" style="font-family: monospace; font-weight: 700; background: #000; color: #fff; padding: 3px 8px; font-size: 13px; letter-spacing: 0.5px;">
                                                    <?= htmlspecialchars($userPass) ?>
                                                </span>
                                                <button type="button" onclick="togglePassVisibility(<?= $u['user_id'] ?>, '<?= htmlspecialchars(addslashes($userPass)) ?>')" style="background: none; border: none; cursor: pointer; color: #333; padding: 2px 4px;" title="Ẩn/Hiện mật khẩu">
                                                    <i id="eye_icon_<?= $u['user_id'] ?>" class="fa-solid fa-eye"></i>
                                                </button>
                                            </div>
                                        </td>
                                        
                                        <td style="text-align: center;">
                                            <?php if ($isAdminRole): ?>
                                                <span style="background: #17a2b8; color: #fff; padding: 2px 6px; font-size: 11px; font-weight: bold;">ADMIN</span>
                                            <?php else: ?>
                                                <span style="background: #6c757d; color: #fff; padding: 2px 6px; font-size: 11px; font-weight: bold;">USER</span>
                                            <?php endif; ?>
                                        </td>
                                        
                                        <!-- Mock Checkboxes -->
                                        <td style="text-align: center;"><i class="fa-solid fa-check" style="color: #28a745;"></i></td>
                                        
                                        <td>
                                            <div class="adi-status-radio">
                                                <label><input type="radio" name="status_<?= $u['user_id'] ?>" <?= $isActive ? 'checked' : '' ?> <?= $isSelf ? 'disabled' : '' ?>> Active</label>
                                                <label><input type="radio" name="status_<?= $u['user_id'] ?>" <?= !$isActive ? 'checked' : '' ?> <?= $isSelf ? 'disabled' : '' ?>> Locked</label>
                                            </div>
                                        </td>

                                        <td style="text-align: center;">
                                            <a href="index.php?act=admin_nguoidung_edit&id=<?= $u['user_id'] ?>" class="adi-action-btn edit" title="Sửa">Sửa <i class="fa-solid fa-pen"></i></a>
                                            <?php if (!$isSelf): ?>
                                                <?php if ($isActive): ?>
                                                    <a href="index.php?act=admin_nguoidung_toggle&id=<?= $u['user_id'] ?>" onclick="return confirm('Khóa?')" class="adi-action-btn warning" style="background: #ffc107; color: #000;" title="Khóa">Khóa <i class="fa-solid fa-lock"></i></a>
                                                <?php else: ?>
                                                    <a href="index.php?act=admin_nguoidung_toggle&id=<?= $u['user_id'] ?>" onclick="return confirm('Mở khóa?')" class="adi-action-btn success" style="background: #28a745; color: #fff;" title="Mở khóa">Mở <i class="fa-solid fa-lock-open"></i></a>
                                                <?php endif; ?>
                                                <a href="index.php?act=admin_nguoidung_delete&id=<?= $u['user_id'] ?>" onclick="return confirm('Xóa?')" class="adi-action-btn delete" title="Xóa">Xóa <i class="fa-solid fa-xmark"></i></a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="9" style="text-align: center; padding: 20px;">Chưa có người dùng nào.</td>
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
    </script>
</body>
</html>
