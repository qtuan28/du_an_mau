<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản Lý Sản Phẩm</title>
</head>
<style>
    table {
        border-collapse: collapse;
    }
</style>
<body>
    <h1>QUẢN LÝ SẢN PHẨM (ADMIN)</h1>
    <p><a href="index.php?act=admin">Về trang Admin tổng</a> | <a href="index.php?act=index">Về trang chủ</a></p>

    <!-- [USE CASE: TÌM KIẾM SẢN PHẨM] -->
    <form action="index.php?act=admin_sanpham_search" method="GET">
        <input type="hidden" name="act" value="admin_sanpham_search">
        <input type="text" name="keyword" placeholder="Tìm kiếm sản phẩm...">
        <button type="submit">Tìm kiếm</button>
    </form>

    <br>
    <!-- [USE CASE: THÊM SẢN PHẨM] -->
    <p><a href="index.php?act=admin_sanpham_add_form">+ THÊM SẢN PHẨM MỚI</a></p>

    <hr>
    <!-- [USE CASE: XEM / SỬA / XÓA SẢN PHẨM] -->
    <h3>DANH SÁCH SẢN PHẨM</h3>
    <table border="1">
        <tr>
            <th>Mã SP</th>
            <th>Tên sản phẩm</th>
            <th>Danh mục</th>
            <th>Giá</th>
            <th>Hình ảnh</th>
            <th>Chức năng</th>
        </tr>
        <!-- [TỰ CODE VÒNG LẶP FOREACH SẢN PHẨM] -->
        <tr>
            <td>1</td>
            <td>Vợt Pickleball Franklin</td>
            <td>Vợt Pickleball</td>
            <td>2,500,000 VNĐ</td>
            <td>vot.jpg</td>
            <td>
                <a href="index.php?act=admin_sanpham_edit&id=1">Sửa</a> | 
                <a href="index.php?act=admin_sanpham_delete&id=1" onclick="return confirm('Xóa sản phẩm?')">Xóa</a>
            </td>
        </tr>
    </table>
</body>
</html>
