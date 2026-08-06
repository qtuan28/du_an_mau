<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Sản phẩm</title>
    <link rel="stylesheet" href="assets/css/admin.css">
</head>

<body>

<div class="container">

    <div class="header-action">
        <a href="index.php?act=admin" class="btn-back">&larr; Về Bảng Quản Trị</a>
        <h1>QUẢN LÝ SẢN PHẨM</h1>
    </div>

    <?php
    if(isset($_SESSION['success'])){
        echo "<div class='success'>".$_SESSION['success']."</div>";
        unset($_SESSION['success']);
    }

    if(isset($_SESSION['error'])){
        echo "<div class='error'>".$_SESSION['error']."</div>";
        unset($_SESSION['error']);
    }
    ?>

    <div class="top-bar">
        <a href="index.php?act=admin_sanpham_add_form" class="btn-add">
            ➕ Thêm sản phẩm mới
        </a>

        <form method="GET" action="index.php" class="search-form">
            <input type="hidden" name="act" value="admin_sanpham">

            <select name="trang_thai" class="form-select" style="padding: 9px 12px;">
                <option value="">-- Tất cả trạng thái --</option>
                <option value="1" <?= (isset($_GET['trang_thai']) && $_GET['trang_thai'] === '1') ? 'selected' : '' ?>>🟢 Còn hàng</option>
                <option value="0" <?= (isset($_GET['trang_thai']) && $_GET['trang_thai'] === '0') ? 'selected' : '' ?>>🔴 Hết hàng</option>
            </select>

            <input
                type="text"
                name="keyword"
                value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>"
                placeholder="Nhập tên sản phẩm..."
            >
            <button type="submit" class="btn-search">🔍 Tìm kiếm</button>
            <?php if (!empty($_GET['keyword']) || (isset($_GET['trang_thai']) && $_GET['trang_thai'] !== '')): ?>
                <a href="index.php?act=admin_sanpham" class="btn-reset">Đặt lại</a>
            <?php endif; ?>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th style="width: 50px;">ID</th>
                    <th style="width: 70px;">Hình ảnh</th>
                    <th>Tên sản phẩm</th>
                    <th style="width: 140px;">Danh mục</th>
                    <th style="width: 160px;">Giá bán</th>
                    <th style="width: 90px;">Giảm giá</th>
                    <th style="width: 150px;">Trạng thái</th>
                    <th style="width: 140px;">Thao tác</th>
                </tr>
            </thead>
            <tbody>
            <?php if (!empty($dsSanPham)): ?>
                <?php foreach($dsSanPham as $sp): ?>
                    <?php
                        $giaGoc = (float)$sp['gia'];
                        $giamGia = (int)($sp['giam_gia'] ?? 0);
                        $giaSauGiam = $giamGia > 0 ? $giaGoc * (1 - $giamGia / 100) : $giaGoc;
                    ?>
                    <tr>
                        <td class="text-center"><strong><?= $sp['product_id'] ?></strong></td>

                        <td class="text-center">
                            <?php if (!empty($sp['anh'])): ?>
                                <img src="uploads/<?= htmlspecialchars($sp['anh']) ?>"
                                     alt="Thumb"
                                     class="prod-img"
                                     onerror="this.src='assets/images/no-image.png'">
                            <?php else: ?>
                                <span class="text-muted" style="font-size: 11px;">[Không ảnh]</span>
                            <?php endif; ?>
                        </td>

                        <td>
                            <strong class="cat-name"><?= htmlspecialchars($sp['ten']) ?></strong>
                        </td>

                        <td>
                            <span class="badge-category"><?= htmlspecialchars($sp['ten_danh_muc'] ?? 'Chưa phân loại') ?></span>
                        </td>

                        <td>
                            <?php if ($giamGia > 0): ?>
                                <span class="price-new"><?= number_format($giaSauGiam, 0, ',', '.') ?>đ</span><br>
                                <span class="price-old"><?= number_format($giaGoc, 0, ',', '.') ?>đ</span>
                            <?php else: ?>
                                <strong class="price-normal"><?= number_format($giaGoc, 0, ',', '.') ?>đ</strong>
                            <?php endif; ?>
                        </td>

                        <td class="text-center">
                            <?php if ($giamGia > 0): ?>
                                <span class="discount-badge">-<?= $giamGia ?>%</span>
                            <?php else: ?>
                                <span class="text-muted">0%</span>
                            <?php endif; ?>
                        </td>

                        <td class="text-center">
                            <?php if (isset($sp['trang_thai']) && $sp['trang_thai'] == 1): ?>
                                <span class="badge badge-active">🟢 Còn hàng</span>
                                <a href="index.php?act=admin_sanpham_toggle&id=<?= $sp['product_id'] ?>"
                                   class="btn-toggle" title="Đổi sang Hết hàng">
                                    [Hết]
                                </a>
                            <?php else: ?>
                                <span class="badge badge-inactive">🔴 Hết hàng</span>
                                <a href="index.php?act=admin_sanpham_toggle&id=<?= $sp['product_id'] ?>"
                                   class="btn-toggle" title="Đổi sang Còn hàng">
                                    [Còn]
                                </a>
                            <?php endif; ?>
                        </td>

                        <td class="text-center actions-cell">
                            <a href="index.php?act=admin_sanpham_edit_form&id=<?= $sp['product_id'] ?>"
                               class="btn-action btn-edit">
                                ✏️ Sửa
                            </a>

                            <a href="index.php?act=admin_sanpham_delete&id=<?= $sp['product_id'] ?>"
                               class="btn-action btn-delete"
                               onclick="return confirm('Bạn có chắc muốn xóa sản phẩm \'<?= htmlspecialchars($sp['ten']) ?>\'?')">
                                🗑️ Xóa
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" class="empty-state">
                        Chưa có sản phẩm nào phù hợp với bộ lọc.
                    </td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Thanh phân trang (Pagination) -->
    <?php if ($totalPages > 1): ?>
        <?php
            $queryParams = $_GET;
            unset($queryParams['page']);
            $queryString = http_build_query($queryParams);
        ?>
        <div class="pagination">
            <span class="pagination-info">Trang <?= $page ?> / <?= $totalPages ?> (Tổng <?= $totalCount ?> sản phẩm)</span>

            <div class="pagination-links">
                <?php if ($page > 1): ?>
                    <a href="index.php?<?= $queryString ?>&page=<?= $page - 1 ?>" class="page-link">&laquo; Trước</a>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <a href="index.php?<?= $queryString ?>&page=<?= $i ?>"
                       class="page-link <?= ($i == $page) ? 'active' : '' ?>">
                        <?= $i ?>
                    </a>
                <?php endfor; ?>

                <?php if ($page < $totalPages): ?>
                    <a href="index.php?<?= $queryString ?>&page=<?= $page + 1 ?>" class="page-link">Sau &raquo;</a>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>

</div>

</body>

</html>
