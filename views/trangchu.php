<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Trang Chủ - Pickleball</title>
</head>
<style>
    table {
        border-collapse: collapse;
    }
</style>
<body>
    <h1>TRANG CHỦ WEBSITE BÁN PICKLEBALL</h1>

    <div>
        <?php if (isset($_SESSION['user'])): ?>
            <p>Xin chào: <strong><?= htmlspecialchars($_SESSION['user']['username']) ?></strong> (Vai trò: <?= htmlspecialchars($_SESSION['user']['ten_vai_tro']) ?>)</p>
            
            <p>
                <a href="index.php?act=profile">Hồ sơ cá nhân & Lịch sử đơn hàng</a> | 
                <a href="index.php?act=giohang">Giỏ hàng</a> | 
                <a href="index.php?act=logout">Đăng xuất</a>
            </p>

            <?php if ($_SESSION['user']['vai_tro_id'] == 1): ?>
                <p>👉 <a href="index.php?act=admin">VÀO TRANG QUẢN TRỊ ADMIN</a></p>
            <?php endif; ?>

        <?php else: ?>
            <p>
                <a href="index.php?act=login">Đăng nhập</a> | 
                <a href="index.php?act=register">Đăng ký</a> | 
                <a href="index.php?act=giohang">Giỏ hàng</a>
            </p>
        <?php endif; ?>
    </div>

    <hr>
    <!-- [USE CASE: TÌM KIẾM SẢN PHẨM] -->
    <form action="index.php?act=timkiem" method="GET">
        <input type="hidden" name="act" value="timkiem">
        <input type="text" name="keyword" placeholder="Nhập tên sản phẩm cần tìm...">
        <button type="submit">Tìm kiếm</button>
    </form>

    <br>
    <!-- [USE CASE: XEM DANH MỤC] -->
    <div>
        <strong>Lọc theo danh mục:</strong>
        <a href="index.php?act=index">Tất cả</a> | 
        <a href="index.php?act=danhmuc&id=1">Vợt Pickleball</a> | 
        <a href="index.php?act=danhmuc&id=2">Bóng Pickleball</a>
    </div>

    <hr>
    <h2>DANH SÁCH SẢN PHẨM (USE CASE: XEM SẢN PHẨM)</h2>
    <table border="1">
        <tr>
            <th>Mã sản phẩm</th>
            <th>Tên sản phẩm</th>
            <th>Danh mục</th>
            <th>Giá</th>
            <th>Hình ảnh</th>
            <th>Xem chi tiết</th>
            <th>Chức năng</th>
        </tr>
        <?php if (!empty($dsSanPham)): ?>
            <?php foreach ($dsSanPham as $sp): ?>
            <tr>
                <td><?= $sp['product_id'] ?></td>
                <td><?= htmlspecialchars($sp['ten']) ?></td>
                <td><?= htmlspecialchars($sp['ten_danh_muc'] ?? 'Chưa phân loại') ?></td>
                <td><?= number_format($sp['gia'], 0, ',', '.') ?> VNĐ</td>
                <td><?= htmlspecialchars($sp['anh']) ?></td>
                <!-- USE CASE: XEM CHI TIẾT SẢN PHẨM -->
                <td><a href="index.php?act=sanpham_chitiet&id=<?= $sp['product_id'] ?>">Xem chi tiết</a></td>
                <!-- USE CASE: THÊM GIỎ HÀNG -->
                <td><a href="index.php?act=add_giohang&id=<?= $sp['product_id'] ?>">Thêm vào giỏ hàng</a></td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="7">Chưa có sản phẩm nào.</td>
            </tr>
        <?php endif; ?>
    </table>
</body>
</html>
