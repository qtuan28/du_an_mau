<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Danh mục</title>
    <link rel="stylesheet" href="assets/css/admin.css">
</head>

<body>

<div class="container">

    <div class="header-action">
        <a href="index.php?act=admin" class="btn-back">&larr; Về Bảng Quản Trị</a>
        <h1>QUẢN LÝ DANH MỤC</h1>
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
        <a href="index.php?act=admin_danhmuc_add_form" class="btn-add">
            ➕ Thêm danh mục mới
        </a>

        <form method="GET" action="index.php" class="search-form">
            <input type="hidden" name="act" value="admin_danhmuc_search">
            <input
                type="text"
                name="keyword"
                value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>"
                placeholder="Nhập tên danh mục để tìm..."
            >
            <button type="submit" class="btn-search">🔍 Tìm kiếm</button>
            <?php if (!empty($_GET['keyword'])): ?>
                <a href="index.php?act=admin_danhmuc" class="btn-reset">Đặt lại</a>
            <?php endif; ?>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th style="width: 60px;">ID</th>
                    <th>Tên danh mục</th>
                    <th style="width: 170px;">Ngày tạo</th>
                    <th style="width: 180px;">Trạng thái hoạt động</th>
                    <th style="width: 160px;">Thao tác</th>
                </tr>
            </thead>
            <tbody>
            <?php if (!empty($dsDanhMuc)): ?>
                <?php foreach($dsDanhMuc as $dm): ?>
                    <tr>
                        <td class="text-center"><strong><?= $dm['category_id'] ?></strong></td>

                        <td>
                            <strong class="cat-name"><?= htmlspecialchars($dm['name']) ?></strong>
                        </td>

                        <td class="text-center text-muted">
                            <?= !empty($dm['ngay_tao']) ? date('d/m/Y H:i', strtotime($dm['ngay_tao'])) : 'Chưa cập nhật' ?>
                        </td>

                        <td class="text-center">
                            <?php if (isset($dm['trang_thai']) && $dm['trang_thai'] == 1): ?>
                                <span class="badge badge-active">🟢 Hoạt động</span>
                                <a href="index.php?act=admin_danhmuc_toggle&id=<?= $dm['category_id'] ?>"
                                   class="btn-toggle" title="Click để tạm ngưng">
                                    [Tắt]
                                </a>
                            <?php else: ?>
                                <span class="badge badge-inactive">🔴 Tạm ngưng</span>
                                <a href="index.php?act=admin_danhmuc_toggle&id=<?= $dm['category_id'] ?>"
                                   class="btn-toggle" title="Click để bật hoạt động">
                                    [Bật]
                                </a>
                            <?php endif; ?>
                        </td>

                        <td class="text-center actions-cell">
                            <a href="index.php?act=admin_danhmuc_edit_form&id=<?= $dm['category_id'] ?>"
                               class="btn-action btn-edit">
                                ✏️ Sửa
                            </a>

                            <a href="index.php?act=admin_danhmuc_delete&id=<?= $dm['category_id'] ?>"
                               class="btn-action btn-delete"
                               onclick="return confirm('Bạn có chắc chắn muốn xóa danh mục \'<?= htmlspecialchars($dm['name']) ?>\'?')">
                                🗑️ Xóa
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="empty-state">
                        Chưa có danh mục nào<?= !empty($_GET['keyword']) ? ' phù hợp với từ khóa search' : '' ?>.
                    </td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>

</body>

</html>