<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= ($mode === 'edit') ? 'Sửa Danh mục' : 'Thêm Danh mục Mới' ?></title>
    <link rel="stylesheet" href="assets/css/admin.css">
</head>

<body>

<div class="container">

    <div class="header-action">
        <a href="index.php?act=admin_danhmuc" class="btn-back">
            &larr; Quay lại danh sách
        </a>
        <h1><?= ($mode === 'edit') ? 'CẬP NHẬT DANH MỤC' : 'THÊM DANH MỤC MỚI' ?></h1>
    </div>

    <?php if(isset($_SESSION['error'])): ?>
        <div class="error"><?= $_SESSION['error'] ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <div class="form-card">
        <form method="POST" action="index.php?act=<?= ($mode === 'edit') ? 'admin_danhmuc_edit' : 'admin_danhmuc_add' ?>">

            <?php if ($mode === 'edit'): ?>
                <input type="hidden" name="category_id" value="<?= $danhMuc['category_id'] ?>">
            <?php endif; ?>

            <div class="form-group">
                <label for="name">Tên danh mục <span class="required">*</span></label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    value="<?= htmlspecialchars($danhMuc['name'] ?? '') ?>"
                    placeholder="Nhập tên danh mục..."
                    required
                    autofocus
                >
            </div>

            <div class="form-group">
                <label for="trang_thai">Trạng thái hoạt động</label>
                <select id="trang_thai" name="trang_thai" class="form-select">
                    <option value="1" <?= (isset($danhMuc['trang_thai']) && $danhMuc['trang_thai'] == 1) ? 'selected' : '' ?>>
                        🟢 Hoạt động (Hiển thị)
                    </option>
                    <option value="0" <?= (isset($danhMuc['trang_thai']) && $danhMuc['trang_thai'] == 0) ? 'selected' : '' ?>>
                        🔴 Tạm ngưng (Ẩn)
                    </option>
                </select>
            </div>

            <?php if ($mode === 'edit' && !empty($danhMuc['ngay_tao'])): ?>
                <div class="form-group">
                    <label>Ngày khởi tạo</label>
                    <input
                        type="text"
                        value="<?= date('d/m/Y H:i:s', strtotime($danhMuc['ngay_tao'])) ?>"
                        readonly
                        class="readonly-input"
                    >
                </div>
            <?php endif; ?>

            <div class="form-actions">
                <button type="submit" class="btn-submit">
                    💾 <?= ($mode === 'edit') ? 'Cập nhật danh mục' : 'Lưu danh mục mới' ?>
                </button>
                <a href="index.php?act=admin_danhmuc" class="btn-cancel">
                    Hủy bỏ
                </a>
            </div>

        </form>
    </div>

</div>

</body>

</html>
