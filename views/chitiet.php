<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chi Tiết Sản Phẩm</title>
</head>
<body>
    <h2>CHI TIẾT SẢN PHẨM</h2>

    <!-- [TỰ CODE HIỂN THỊ CHI TIẾT SẢN PHẨM] -->
    <div>
        <p><strong>Mã sản phẩm:</strong> <?= $sp['product_id'] ?? 'ID' ?></p>
        <p><strong>Tên sản phẩm:</strong> <?= htmlspecialchars($sp['ten'] ?? 'Tên sản phẩm') ?></p>
        <p><strong>Giá:</strong> <?= $sp['gia'] ?? 0 ?> VNĐ</p>
        <p><strong>Hình ảnh:</strong> <?= $sp['anh'] ?? '' ?></p>

        <!-- Use Case mở rộng: Thêm vào giỏ hàng từ trang chi tiết -->
        <p><a href="index.php?act=add_giohang&id=<?= $sp['product_id'] ?? 0 ?>">THÊM VÀO GIỎ HÀNG</a></p>
    </div>

    <p><a href="index.php?act=index">Quay lại Trang chủ</a></p>
</body>
</html>
