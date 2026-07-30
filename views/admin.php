<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Trang Quản Trị (Admin)</title>
</head>
<body>
    <h1>TRANG QUẢN TRỊ ADMIN (WEB ADMIN)</h1>
    <p>Xin chào Admin: <strong><?= htmlspecialchars($_SESSION['user']['username']) ?></strong></p>

    <p><a href="index.php?act=index">Về Trang Chủ</a> | <a href="index.php?act=logout">Đăng xuất</a></p>

    <hr>
    <h3>DANH SÁCH CHỨC NĂNG QUẢN TRỊ (THEO SƠ ĐỒ USE CASE):</h3>
    <ul>
        <li>👉 <a href="index.php?act=admin_danhmuc">1. QUẢN LÝ DANH MỤC</a> (Xem, Thêm, Sửa, Xóa, Tìm kiếm)</li>
        <li>👉 <a href="index.php?act=admin_sanpham">2. QUẢN LÝ SẢN PHẨM</a> (Xem, Thêm, Sửa, Xóa, Tìm kiếm)</li>
        <li>👉 <a href="index.php?act=admin_nguoidung">3. QUẢN LÝ NGƯỜI DÙNG</a> (Xem thông tin, Xóa tài khoản)</li>
        <li>👉 <a href="index.php?act=admin_thongke">4. THỐNG KÊ SỐ LIỆU</a> (Sản phẩm, Đơn hàng, Người dùng)</li>
    </ul>
</body>
</html>
