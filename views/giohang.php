<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Giỏ Hàng</title>
</head>
<style>
    table {
        border-collapse: collapse;
    }
</style>
<body>
    <h2>GIỎ HÀNG CỦA BẠN</h2>

    <!-- [TỰ CODE HIỂN THỊ DANH SÁCH GIỎ HÀNG DẠNG BẢNG] -->
    <table border="1">
        <tr>
            <th>Tên sản phẩm</th>
            <th>Giá</th>
            <th>Số lượng</th>
            <th>Thành tiền</th>
            <th>Chức năng</th>
        </tr>
        <!-- Vòng lặp foreach tự code... -->
        <tr>
            <td colspan="5">Chưa có sản phẩm trong giỏ hàng.</td>
        </tr>
    </table>

    <br>
    <div>
        <!-- Link tới các Use Case trong sơ đồ -->
        <a href="index.php?act=thanhtoan">👉 TIẾN HÀNH THANH TOÁN</a> |
        <a href="index.php?act=index">Tiếp tục mua hàng</a>
    </div>
</body>
</html>
