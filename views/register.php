<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký tài khoản | Pickleball Store</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .adi-auth-wrapper {
            min-height: calc(100vh - 280px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 60px 20px;
            background-color: #f8f9fa;
        }

        .adi-auth-card {
            background: #ffffff;
            width: 100%;
            max-width: 480px;
            padding: 40px;
            border: 1px solid #ebedee;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            position: relative;
        }

        .adi-auth-header {
            text-align: center;
            margin-bottom: 32px;
        }

        .adi-auth-logo {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 16px;
        }

        .adi-auth-logo svg {
            height: 32px;
            width: auto;
        }

        .adi-auth-title {
            font-family: 'Oswald', sans-serif;
            font-size: 28px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #000;
            margin: 0 0 6px 0;
        }

        .adi-auth-subtitle {
            font-family: 'Roboto', sans-serif;
            font-size: 14px;
            color: #767677;
            margin: 0;
        }

        .adi-alert-error {
            background-color: #fef2f2;
            border-left: 4px solid #e50010;
            color: #991b1b;
            padding: 12px 16px;
            font-family: 'Roboto', sans-serif;
            font-size: 14px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .adi-form-group {
            margin-bottom: 20px;
        }

        .adi-form-label {
            display: block;
            font-family: 'Oswald', sans-serif;
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #000;
            margin-bottom: 8px;
        }

        .adi-input-field-wrap {
            position: relative;
            display: flex;
            align-items: center;
        }

        .adi-input-icon {
            position: absolute;
            left: 14px;
            color: #999;
            font-size: 15px;
        }

        .adi-input-text {
            width: 100%;
            padding: 14px 14px 14px 44px;
            font-family: 'Roboto', sans-serif;
            font-size: 14px;
            border: 1px solid #ccc;
            outline: none;
            transition: border-color 0.2s;
            background: #fff;
        }

        .adi-input-text:focus {
            border-color: #000;
        }

        .adi-auth-btn {
            width: 100%;
            background-color: #000;
            color: #fff;
            font-family: 'Oswald', sans-serif;
            font-size: 15px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            padding: 16px;
            border: 1px solid #000;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            transition: all 0.2s ease-in-out;
            margin-top: 8px;
        }

        .adi-auth-btn:hover {
            background-color: #222;
        }

        .adi-auth-footer-links {
            margin-top: 28px;
            text-align: center;
            font-family: 'Roboto', sans-serif;
            font-size: 14px;
            color: #666;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .adi-auth-footer-links a {
            color: #000;
            font-weight: 700;
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <!-- Header bar -->
    <?php include 'views/header.php'; ?>

    <div class="adi-auth-wrapper">
        <div class="adi-auth-card">
            <div class="adi-auth-header">
                <div class="adi-auth-logo">
                    <svg viewBox="0 0 60 40" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0,32.5 L13,32.5 L26,7.5 L13,7.5 Z" fill="#000"/>
                        <path d="M15,32.5 L28,32.5 L41,0 L28,0 Z" fill="#000"/>
                        <path d="M30,32.5 L43,32.5 L56,-7.5 L43,-7.5 Z" fill="#000"/>
                    </svg>
                </div>
                <h1 class="adi-auth-title">ĐĂNG KÝ TÀI KHOẢN</h1>
                <p class="adi-auth-subtitle">Tạo tài khoản người dùng để mua sắm và nhận nhiều ưu đãi</p>
            </div>

            <?php if (isset($error) && !empty($error)): ?>
                <div class="adi-alert-error">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <span><?= htmlspecialchars($error) ?></span>
                </div>
            <?php endif; ?>

            <form action="index.php?act=post_register" method="POST">
                <div class="adi-form-group">
                    <label class="adi-form-label">Tên đăng nhập *</label>
                    <div class="adi-input-field-wrap">
                        <i class="fa-regular fa-user adi-input-icon"></i>
                        <input type="text" name="username" class="adi-input-text" placeholder="Nhập tên đăng nhập" required>
                    </div>
                </div>

                <div class="adi-form-group">
                    <label class="adi-form-label">Mật khẩu *</label>
                    <div class="adi-input-field-wrap">
                        <i class="fa-solid fa-lock adi-input-icon"></i>
                        <input type="password" name="password" class="adi-input-text" placeholder="Nhập mật khẩu" required>
                    </div>
                </div>

                <div class="adi-form-group">
                    <label class="adi-form-label">Email *</label>
                    <div class="adi-input-field-wrap">
                        <i class="fa-regular fa-envelope adi-input-icon"></i>
                        <input type="email" name="email" class="adi-input-text" placeholder="Nhập địa chỉ email (VD: name@gmail.com)" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.(com|vn|net|org|edu|gov|io|co|me|info|biz|us|uk)" title="Email phải đúng định dạng chuẩn như name@gmail.com, name@yahoo.com, name@fpt.edu.vn..." required>
                    </div>
                </div>

                <div class="adi-form-group">
                    <label class="adi-form-label">Địa chỉ</label>
                    <div class="adi-input-field-wrap">
                        <i class="fa-solid fa-location-dot adi-input-icon"></i>
                        <input type="text" name="address" class="adi-input-text" placeholder="Nhập địa chỉ của bạn">
                    </div>
                </div>

                <button type="submit" class="adi-auth-btn">
                    ĐĂNG KÝ NGAY <i class="fa-solid fa-arrow-right-long"></i>
                </button>
            </form>

            <div class="adi-auth-footer-links">
                <div>Đã có tài khoản? <a href="index.php?act=login">Đăng nhập ngay</a></div>
                <div><a href="index.php?act=index" style="color: #767677; font-weight: 400;">← Quay lại Trang chủ</a></div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include 'views/footer.php'; ?>

</body>
</html>
