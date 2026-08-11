<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Sản phẩm | Bảng Điều Khiển Admin</title>
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
                    <h1 class="adi-page-title">Quản lý Sản phẩm</h1>
                    <div class="adi-breadcrumb">
                        <a href="index.php?act=admin"><i class="fa-solid fa-house"></i> Trang chủ</a> > 
                        <a href="#">Bán hàng</a> > Sản phẩm
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
                                <input type="hidden" name="act" value="admin_sanpham">
                                
                                <select name="trang_thai" class="adi-form-control">
                                    <option value="">Tất cả trạng thái</option>
                                    <option value="1" <?= (isset($_GET['trang_thai']) && $_GET['trang_thai'] === '1') ? 'selected' : '' ?>>Còn hàng</option>
                                    <option value="0" <?= (isset($_GET['trang_thai']) && $_GET['trang_thai'] === '0') ? 'selected' : '' ?>>Hết hàng</option>
                                </select>

                                <input type="text" name="keyword" value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>" placeholder="Nhập tên sản phẩm..." class="adi-form-control" style="width: 200px;">
                                <button type="submit" class="adi-btn-outline" style="padding: 6px 12px;"><i class="fa-solid fa-magnifying-glass"></i></button>
                            </form>
                        </div>
                        
                        <div>
                            <a href="index.php?act=admin_sanpham_add_form" class="adi-btn" style="background: #3c8dbc; border-color: #367fa9; color: #fff;">
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
                                    <th>SẢN PHẨM</th>
                                    <th style="text-align: center;">HÌNH ẢNH</th>
                                    <th>DANH MỤC</th>
                                    <th>GIÁ BÁN</th>
                                    <th>TRẠNG THÁI</th>
                                    <th style="text-align: center;">TÁC VỤ</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php if (!empty($dsSanPham)): ?>
                                <?php $stt = 1; foreach($dsSanPham as $sp): ?>
                                    <?php
                                        $giaGoc = (float)$sp['gia'];
                                        $giamGia = (int)($sp['giam_gia'] ?? 0);
                                        $giaSauGiam = $giamGia > 0 ? $giaGoc * (1 - $giamGia / 100) : $giaGoc;
                                    ?>
                                    <tr>
                                        <td style="text-align: center;"><input type="checkbox"></td>
                                        <td style="text-align: center; font-weight: bold;"><?= $stt++ ?></td>
                                        <td>
                                            <strong><?= htmlspecialchars($sp['ten']) ?></strong>
                                            <div style="font-size: 11px; color: #777;">ID: <?= $sp['product_id'] ?></div>
                                        </td>
                                        <td style="text-align: center;">
                                            <?php 
                                                $imgSrc = BASE_URL . '/assets/images/hero_paddle.png';
                                                if (!empty($sp['anh'])) {
                                                    if (strpos($sp['anh'], 'assets/') === 0 || strpos($sp['anh'], 'uploads/') === 0) {
                                                        $imgSrc = BASE_URL . '/' . $sp['anh'];
                                                    } elseif (file_exists('assets/images/' . $sp['anh'])) {
                                                        $imgSrc = BASE_URL . '/assets/images/' . $sp['anh'];
                                                    } elseif (file_exists('uploads/' . $sp['anh'])) {
                                                        $imgSrc = BASE_URL . '/uploads/' . $sp['anh'];
                                                    } else {
                                                        $imgSrc = BASE_URL . '/assets/images/' . $sp['anh'];
                                                    }
                                                }
                                            ?>
                                            <img src="<?= htmlspecialchars($imgSrc) ?>" alt="<?= htmlspecialchars($sp['ten']) ?>" style="width: 50px; height: 50px; object-fit: cover; border: 1px solid #eee;" onerror="this.src='<?= BASE_URL ?>/assets/images/hero_paddle.png'">
                                        </td>
                                        <td><?= htmlspecialchars($sp['ten_danh_muc'] ?? 'Chưa phân loại') ?></td>
                                        <td>
                                            <div style="font-weight: bold; font-family: monospace; font-size: 14px;"><?= number_format($sp['gia'], 0, ',', '.') ?>đ</div>
                                        </td>
                                        
                                        <td>
                                            <div class="adi-status-radio">
                                                <label><input type="radio" name="status_<?= $sp['product_id'] ?>" <?= (isset($sp['trang_thai']) && $sp['trang_thai'] == 1) ? 'checked' : '' ?>> Còn hàng</label>
                                                <label><input type="radio" name="status_<?= $sp['product_id'] ?>" <?= (!isset($sp['trang_thai']) || $sp['trang_thai'] != 1) ? 'checked' : '' ?>> Hết hàng</label>
                                            </div>
                                        </td>

                                        <td style="text-align: center;">
                                            <a href="index.php?act=admin_sanpham_edit_form&id=<?= $sp['product_id'] ?>" class="adi-action-btn edit" title="Sửa">Sửa <i class="fa-solid fa-pen"></i></a>
                                            <a href="index.php?act=admin_sanpham_delete&id=<?= $sp['product_id'] ?>" onclick="return confirm('Xóa?')" class="adi-action-btn delete" title="Xóa">Xóa <i class="fa-solid fa-xmark"></i></a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" style="text-align: center; padding: 20px;">Chưa có sản phẩm nào.</td>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <?php if (isset($totalPages) && $totalPages > 1): ?>
                        <div style="padding: 15px; border-top: 1px solid #ebedee; display: flex; justify-content: flex-end;">
                            <div style="display: flex; gap: 5px;">
                                <?php
                                    $queryParams = $_GET;
                                    unset($queryParams['page']);
                                    $queryString = http_build_query($queryParams);
                                ?>
                                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                    <a href="index.php?<?= $queryString ?>&page=<?= $i ?>" class="adi-btn" style="min-width: 32px; padding: 4px 8px; <?= ($i == $page) ? '' : 'background: #fff; color: #000; border-color: #ccc;' ?>">
                                        <?= $i ?>
                                    </a>
                                <?php endfor; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                </div>

            </div>
        </div>
    </div>
</body>
</html>
