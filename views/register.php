<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng ký tài khoản</title>
</head>
<body>
    <h2>ĐĂNG KÝ TÀI KHOẢN NGƯỜI DÙNG</h2>

    <form action="index.php?act=post_register" method="POST">
        <div>
            <label>Tên đăng nhập:</label><br>
            <input type="text" name="username" required>
        </div>
        <br>
        <div>
            <label>Mật khẩu:</label><br>
            <input type="password" name="password" required>
        </div>
        <br>
        <div>
            <label>Email:</label><br>
            <input type="email" name="email" required>
        </div>
        <br>
        <div>
            <label>Địa chỉ:</label><br>
            <input type="text" name="address">
        </div>
        <br>
        <button type="submit">Đăng ký</button>
    </form>

    <p><a href="index.php?act=login">Đã có tài khoản? Đăng nhập ngay</a> | <a href="index.php?act=index">Quay lại Trang chủ</a></p>
</body>
</html>
