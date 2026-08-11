<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh mục | Bảng Điều Khiển Admin</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/admin.css">
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
                    <h1 class="adi-page-title">Danh mục</h1>
                    <div class="adi-breadcrumb">
                        <a href="index.php?act=admin"><i class="fa-solid fa-house"></i> Trang chủ</a> > 
                        <a href="#">Cấu hình website</a> > Danh mục
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
                    
                    <!-- Complex Toolbar (Matching mockup) -->
                    <div class="adi-box-header">
                        <div class="adi-toolbar">
                            <form method="GET" action="index.php" style="display: flex; gap: 5px;">
                                <input type="hidden" name="act" value="admin_danhmuc_search">
                                <input type="text" name="keyword" value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>" placeholder="Nhập nội dung cần tìm" class="adi-form-control" style="width: 200px;">
                                <select class="adi-form-control">
                                    <option>Tìm theo...</option>
                                    <option>Tên danh mục</option>
                                </select>
                                <button type="submit" class="adi-btn-outline" style="padding: 6px 12px;"><i class="fa-solid fa-rotate"></i></button>
                            </form>
                        </div>
                        
                        <div>
                            <a href="index.php?act=admin_danhmuc_add_form" class="adi-btn" style="background: #3c8dbc; border-color: #367fa9; color: #fff;">
                                <i class="fa-solid fa-plus"></i> Thêm mới
                            </a>
                        </div>
                    </div>

                    <!-- Complex Data Table (Matching mockup) -->
                    <div class="adi-table-responsive">
                        <table class="adi-table">
                            <thead>
                                <tr>
                                    <th style="width: 40px; text-align: center;"><input type="checkbox"></th>
                                    <th style="width: 60px; text-align: center;">STT</th>
                                    <th>DANH MỤC</th>
                                    <th style="text-align: center;">TRẠNG THÁI HIỂN THỊ</th>
                                    <th style="text-align: center;">TÁC VỤ</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php if (!empty($dsDanhMuc)): ?>
                                <?php $stt = 1; foreach($dsDanhMuc as $dm): ?>
                                    <?php $isShowing = isset($dm['trang_thai']) ? ($dm['trang_thai'] == 1) : true; ?>
                                    <tr>
                                        <td style="text-align: center;"><input type="checkbox"></td>
                                        <td style="text-align: center; font-weight: bold;"><?= $stt++ ?></td>
                                        <td><strong><?= htmlspecialchars($dm['name']) ?></strong></td>
                                        
                                        <td style="text-align: center;">
                                            <?php if ($isShowing): ?>
                                                <span style="background: #e6f4ea; color: #137333; padding: 4px 12px; font-weight: 700; font-size: 11px; display: inline-flex; align-items: center; gap: 6px;">
                                                    <i class="fa-solid fa-circle" style="font-size: 8px; color: #1e8e3e;"></i> HIỂN THỊ
                                                </span>
                                            <?php else: ?>
                                                <span style="background: #fce8e6; color: #c5221f; padding: 4px 12px; font-weight: 700; font-size: 11px; display: inline-flex; align-items: center; gap: 6px;">
                                                    <i class="fa-solid fa-eye-slash" style="font-size: 10px; color: #d93025;"></i> ẨN (KHÔNG HIỂN THỊ)
                                                </span>
                                            <?php endif; ?>
                                        </td>

                                        <td style="text-align: center;">
                                            <a href="index.php?act=admin_danhmuc_edit_form&id=<?= $dm['category_id'] ?>" class="adi-action-btn edit" title="Sửa">Sửa <i class="fa-solid fa-pen"></i></a>
                                            <a href="index.php?act=admin_danhmuc_delete&id=<?= $dm['category_id'] ?>" onclick="return confirm('Bạn có chắc muốn xóa danh mục này?')" class="adi-action-btn delete" title="Xóa">Xóa <i class="fa-solid fa-xmark"></i></a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" style="text-align: center; padding: 20px;">Chưa có danh mục nào.</td>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</body>
</html>