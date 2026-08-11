<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh Toán Đơn Hàng | Pickleball Store</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .adi-checkout-wrapper {
            max-width: 1000px;
            margin: 0 auto;
            padding: 40px 20px 80px;
        }

        .adi-checkout-breadcrumb {
            font-family: 'Roboto', sans-serif;
            font-size: 12px;
            font-weight: 500;
            text-transform: uppercase;
            color: #767677;
            margin-bottom: 24px;
        }

        .adi-checkout-breadcrumb a {
            color: #000;
            text-decoration: underline;
        }

        .adi-checkout-title {
            font-family: 'Oswald', sans-serif;
            font-size: 36px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: -0.5px;
            margin-bottom: 30px;
            padding-bottom: 16px;
            border-bottom: 1px solid #ebedee;
        }

        .adi-checkout-card {
            background: #fff;
            border: 1px solid #ebedee;
            padding: 40px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.04);
        }

        .adi-checkout-header-box {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 24px;
            padding-bottom: 16px;
            border-bottom: 1px solid #ebedee;
        }

        .adi-checkout-header-box i {
            font-size: 24px;
            color: #000;
        }

        .adi-checkout-header-box h3 {
            font-family: 'Oswald', sans-serif;
            font-size: 20px;
            font-weight: 700;
            text-transform: uppercase;
            margin: 0;
        }

        .adi-form-group {
            margin-bottom: 24px;
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

        .adi-input-text {
            width: 100%;
            padding: 14px;
            font-family: 'Roboto', sans-serif;
            font-size: 14px;
            border: 1px solid #ccc;
            outline: none;
            transition: border-color 0.2s;
            background: #fff;
            box-sizing: border-box;
        }

        .adi-input-text:focus {
            border-color: #000;
        }

        .adi-order-confirm-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            width: 100%;
            background-color: #000;
            color: #fff;
            font-family: 'Oswald', sans-serif;
            font-size: 16px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            padding: 18px;
            border: 1px solid #000;
            cursor: pointer;
            transition: background-color 0.2s;
            margin-top: 20px;
        }

        .adi-order-confirm-btn:hover {
            background-color: #222;
        }
    </style>
</head>
<body>

    <!-- Header bar -->
    <?php include 'views/header.php'; ?>

    <div class="adi-checkout-wrapper">
        <div class="adi-checkout-breadcrumb">
            <a href="index.php">TRANG CHỦ</a> / <a href="index.php?act=giohang">GIỎ HÀNG</a> / <span>THANH TOÁN</span>
        </div>

        <h1 class="adi-checkout-title">THANH TOÁN ĐƠN HÀNG</h1>

        <div class="adi-checkout-card">
            <div class="adi-checkout-header-box">
                <i class="fa-solid fa-truck-ramp-box"></i>
                <h3>THÔNG TIN GIAO HÀNG & XÁC NHẬN</h3>
            </div>

            <form action="index.php?act=post_thanhtoan" method="POST">
                <div class="adi-form-group">
                    <label class="adi-form-label">Người nhận hàng</label>
                    <input type="text" class="adi-input-text" value="<?= htmlspecialchars($_SESSION['user']['username'] ?? 'Khách hàng') ?>" readonly style="background: #f5f5f5; color: #555;">
                </div>

                <div class="adi-form-group">
                    <label class="adi-form-label">Địa chỉ giao hàng <span style="color: #e50010;">*</span></label>
                    <input type="text" name="address" class="adi-input-text" value="<?= htmlspecialchars($_SESSION['user']['address'] ?? '') ?>" placeholder="Nhập số nhà, tên đường, phường/xã, quận/huyện, tỉnh/thành phố..." required autofocus>
                </div>

                <button type="submit" class="adi-order-confirm-btn">
                    XÁC NHẬN ĐẶT HÀNG <i class="fa-solid fa-arrow-right-long"></i>
                </button>
            </form>

            <div style="text-align: center; margin-top: 20px;">
                <a href="index.php?act=giohang" style="font-family: 'Roboto', sans-serif; font-size: 13px; color: #666; text-decoration: underline;">← Quay lại Giỏ hàng</a>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include 'views/footer.php'; ?>

</body>
</html>
