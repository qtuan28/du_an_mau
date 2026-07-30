<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản Lý Danh Mục</title>
</head>
<style>
    table {
        border-collapse: collapse;
    }
</style>
<body>
    <h1>QUẢN LÝ DANH MỤC (ADMIN)</h1>
    <p><a href="index.php?act=admin">Về trang Admin tổng</a> | <a href="index.php?act=index">Về trang chủ</a></p>

    <!-- [USE CASE: TÌM KIẾM DANH MỤC] -->
    <form action="index.php?act=admin_danhmuc_search" method="GET">
        <input type="hidden" name="act" value="admin_danhmuc_search">
        <input type="text" name="keyword" placeholder="Nhập từ khóa tìm kiếm...">
        <button type="submit">Tìm kiếm</button>
    </form>

    <br>
    <!-- [USE CASE: THÊM DANH MỤC] -->
    <h3>THÊM DANH MỤC MỚI</h3>
    <form action="index.php?act=admin_danhmuc_add" method="POST">
        <input type="text" name="name" placeholder="Tên danh mục..." required>
        <button type="submit">Thêm danh mục</button>
    </form>

    <hr>
    <!-- [USE CASE: XEM / SỬA / XÓA DANH MỤC] -->
    <h3>DANH SÁCH DANH MỤC</h3>
    <table border="1">
        <tr>
            <th>Mã danh mục</th>
            <th>Tên danh mục</th>
            <th>Chức năng</th>
        </tr>
        <!-- [TỰ CODE VÒNG LẶP FOREACH] -->
        <tr>
            <td>1</td>
            <td>Vợt Pickleball</td>
            <td>
                <a href="index.php?act=admin_danhmuc_edit&id=1">Sửa</a> | 
                <a href="index.php?act=admin_danhmuc_delete&id=1" onclick="return confirm('Xóa danh mục?')">Xóa</a>
            </td>
        </tr>
    </table>
</body>
</html>
