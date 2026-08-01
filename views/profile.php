<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Hồ Sơ Cánh Nhân & Lịch Sử Đơn Hàng</title>
</head>
<style>
    table {
        border-collapse: collapse;
    }
</style>
<body>
    <h2>HỒ SƠ CÁ NHÂN</h2>
    <p>Tên đăng nhập: <strong><?= htmlspecialchars($user['username'] ?? '') ?></strong></p>
    <p>Email: <?= htmlspecialchars($user['email'] ?? '') ?></p>
    <p>Địa chỉ: <?= htmlspecialchars($user['address'] ?? '') ?></p>

    <hr>
    <h2>LỊCH SỬ ĐƠN HÀNG (USE CASE: LỊCH SỬ ĐƠN HÀNG)</h2>
    <!-- [TỰ CODE BẢNG LỊCH SỬ ĐƠN HÀNG] -->
    <table border="1">
        <tr>
            <th>Mã đơn hàng</th>
            <th>Ngày đặt</th>
            <th>Trạng thái</th>
            <th>Tổng tiền</th>
        </tr>
        <tr>
            <td colspan="4">Chưa có lịch sử đơn hàng.</td>
        </tr>
    </table>

    <p><a href="index.php?act=index">Về Trang chủ</a></p>
</body>
</html>
