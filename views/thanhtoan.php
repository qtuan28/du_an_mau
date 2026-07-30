<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thanh Toán Đơn Hàng</title>
</head>
<body>
    <h2>THANH TOÁN ĐƠN HÀNG</h2>

    <!-- [TỰ CODE GIAO DIỆN THANH TOÁN] -->
    <form action="index.php?act=post_thanhtoan" method="POST">
        <p><strong>Người nhận:</strong> <?= $_SESSION['user']['username'] ?? 'Khách' ?></p>
        <div>
            <label>Địa chỉ giao hàng:</label><br>
            <input type="text" name="address" value="<?= $_SESSION['user']['address'] ?? '' ?>" required>
        </div>
        <br>
        <button type="submit">Xác nhận thanh toán</button>
    </form>

    <p><a href="index.php?act=giohang">Quay lại Giỏ hàng</a></p>
</body>
</html>
