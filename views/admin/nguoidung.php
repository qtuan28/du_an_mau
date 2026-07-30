<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản Lý Người Dùng</title>
</head>
<style>
    table {
        border-collapse: collapse;
    }
</style>
<body>
    <h1>QUẢN LÝ NGƯỜI DÙNG (ADMIN)</h1>
    <p><a href="index.php?act=admin">Về trang Admin tổng</a> | <a href="index.php?act=index">Về trang chủ</a></p>

    <hr>
    <!-- [USE CASE: XEM THÔNG TIN NGƯỜI DÙNG VÀ XÓA TÀI KHOẢN] -->
    <h3>DANH SÁCH TÀI KHOẢN NGƯỜI DÙNG</h3>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Tên đăng nhập</th>
            <th>Email</th>
            <th>Địa chỉ</th>
            <th>Vai trò</th>
            <th>Chức năng</th>
        </tr>
        <!-- [TỰ CODE VÒNG LẶP FOREACH USER] -->
        <tr>
            <td>2</td>
            <td>user</td>
            <td>user@example.com</td>
            <td>Hồ Chí Minh</td>
            <td>User</td>
            <td>
                <!-- USE CASE: XÓA TÀI KHOẢN -->
                <a href="index.php?act=admin_nguoidung_delete&id=2" onclick="return confirm('Xóa tài khoản này?')">Xóa tài khoản</a>
            </td>
        </tr>
    </table>
</body>
</html>
