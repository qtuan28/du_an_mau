<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập</title>
</head>
<body>
    <h2>ĐĂNG NHẬP HỆ THỐNG</h2>

    <?php if (isset($error) && !empty($error)): ?>
        <p style="color: red;"><?= $error ?></p>
    <?php endif; ?>

    <form action="index.php?act=post_login" method="POST">
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
        <button type="submit">Đăng nhập</button>
    </form>

    <p><a href="index.php?act=index">Quay lại Trang chủ</a></p>
    <hr>
    <p><em>Gợi ý tài khoản thử nghiệm:</em></p>
    <ul>
        <li>Admin: username: <code>admin</code> / password: <code>123456</code></li>
        <li>User: username: <code>user</code> / password: <code>123456</code></li>
    </ul>
</body>
</html>
