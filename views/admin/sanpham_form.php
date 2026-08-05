<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= ($mode === 'edit') ? 'Sửa Sản phẩm' : 'Thêm Sản phẩm Mới' ?></title>
    <link rel="stylesheet" href="assets/css/admin.css">
</head>

<body>

<div class="container">

    <div class="header-action">
        <a href="index.php?act=admin_sanpham" class="btn-back">
            &larr; Quay lại danh sách
        </a>
        <h1><?= ($mode === 'edit') ? 'CẬP NHẬT SẢN PHẨM' : 'THÊM SẢN PHẨM MỚI' ?></h1>
    </div>

    <?php if(isset($_SESSION['error'])): ?>
        <div class="error"><?= $_SESSION['error'] ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <div class="form-card">
        <form method="POST"
              action="index.php?act=<?= ($mode === 'edit') ? 'admin_sanpham_edit' : 'admin_sanpham_add' ?>"
              enctype="multipart/form-data">

            <?php if ($mode === 'edit'): ?>
                <input type="hidden" name="product_id" value="<?= $sanPham['product_id'] ?>">
                <input type="hidden" name="old_anh" value="<?= htmlspecialchars($sanPham['anh'] ?? '') ?>">
            <?php endif; ?>

            <div class="form-group">
                <label for="ten">Tên sản phẩm <span class="required">*</span></label>
                <input
                    type="text"
                    id="ten"
                    name="ten"
                    value="<?= htmlspecialchars($sanPham['ten'] ?? '') ?>"
                    placeholder="Nhập tên sản phẩm..."
                    required
                    autofocus
                >
            </div>

            <div class="form-group">
                <label for="category_id">Danh mục sản phẩm <span class="required">*</span></label>
                <select id="category_id" name="category_id" class="form-select" required>
                    <option value="">-- Chọn danh mục --</option>
                    <?php if (!empty($dsDanhMuc)): ?>
                        <?php foreach ($dsDanhMuc as $dm): ?>
                            <option value="<?= $dm['category_id'] ?>"
                                <?= (isset($sanPham['category_id']) && $sanPham['category_id'] == $dm['category_id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($dm['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>

            <div class="form-row" style="display: flex; gap: 15px;">
                <div class="form-group" style="flex: 1;">
                    <label for="gia">Giá bán gốc (VNĐ) <span class="required">*</span></label>
                    <input
                        type="number"
                        id="gia"
                        name="gia"
                        value="<?= htmlspecialchars($sanPham['gia'] ?? '') ?>"
                        placeholder="Ví dụ: 2500000"
                        min="0"
                        step="1000"
                        required
                    >
                </div>

                <div class="form-group" style="flex: 1;">
                    <label for="giam_gia">Giảm giá (%)</label>
                    <input
                        type="number"
                        id="giam_gia"
                        name="giam_gia"
                        value="<?= htmlspecialchars($sanPham['giam_gia'] ?? 0) ?>"
                        placeholder="0 - 100"
                        min="0"
                        max="100"
                    >
                </div>
            </div>

            <div class="form-group">
                <label for="trang_thai">Trạng thái hàng</label>
                <select id="trang_thai" name="trang_thai" class="form-select">
                    <option value="1" <?= (isset($sanPham['trang_thai']) && $sanPham['trang_thai'] == 1) ? 'selected' : '' ?>>
                        🟢 Còn hàng (Đang kinh doanh)
                    </option>
                    <option value="0" <?= (isset($sanPham['trang_thai']) && $sanPham['trang_thai'] == 0) ? 'selected' : '' ?>>
                        🔴 Hết hàng (Tạm ngưng)
                    </option>
                </select>
            </div>

            <div class="form-group">
                <label for="anh">Hình ảnh sản phẩm</label>
                <input type="file" id="anh" name="anh" accept="image/*">
                <?php if ($mode === 'edit' && !empty($sanPham['anh'])): ?>
                    <div style="margin-top: 10px;">
                        <span class="text-muted">Ảnh hiện tại:</span><br>
                        <img src="uploads/<?= htmlspecialchars($sanPham['anh']) ?>"
                             alt="Thumbnail"
                             style="width: 80px; height: 80px; object-fit: cover; border-radius: 6px; border: 1px solid #ddd; margin-top: 5px;"
                             onerror="this.src='assets/images/no-image.png'">
                    </div>
                <?php endif; ?>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-submit">
                    💾 <?= ($mode === 'edit') ? 'Cập nhật sản phẩm' : 'Lưu sản phẩm mới' ?>
                </button>
                <a href="index.php?act=admin_sanpham" class="btn-cancel">
                    Hủy bỏ
                </a>
            </div>

        </form>
    </div>

</div>

</body>

</html>
