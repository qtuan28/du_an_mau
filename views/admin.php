<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Báº£ng Äiá»u Khiá»ƒn Admin | adidas System</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="adi-admin-wrapper">
        
        <!-- Sidebar -->
        <?php include 'views/admin_sidebar.php'; ?>

        <!-- Right Main Panel -->
        <div class="adi-main-panel">
            <!-- Top Navbar -->
            <header class="adi-main-header">
                <div class="adi-header-left">
                    <a href="index.php" class="adi-header-link"><i class="fa-solid fa-globe"></i> Xem website</a>
                </div>
                <div class="adi-header-right">
                    <div class="adi-header-user">
                        <i class="fa-solid fa-circle-user"></i>
                        <?= htmlspecialchars($_SESSION['user']['username'] ?? 'Admin') ?>
                    </div>
                    <a href="index.php?act=logout" class="adi-header-link" style="color: #dc3545;" title="ÄÄƒng xuáº¥t"><i class="fa-solid fa-power-off"></i></a>
                </div>
            </header>

            <!-- Page Content -->
            <div class="adi-content-wrapper">
                
                <!-- Page Header & Breadcrumb -->
                <div class="adi-content-header">
                    <h1 class="adi-page-title">Dashboard</h1>
                    <div class="adi-breadcrumb">
                        <a href="index.php?act=admin"><i class="fa-solid fa-house"></i> Trang chá»§</a> > Dashboard
                    </div>
                </div>

                <!-- Dashboard Content Box -->
                <div class="adi-box">
                    <div class="adi-box-header">
                        <h3 style="font-family: 'Roboto', sans-serif; font-size: 15px; font-weight: 700; margin: 0;">Tá»•ng Quan Há»‡ Thá»‘ng</h3>
                    </div>
                    <div style="padding: 20px;">
                        <p style="margin-bottom: 20px; font-size: 14px;">ChÃ o má»«ng báº¡n Ä‘áº¿n vá»›i há»‡ thá»‘ng quáº£n trá»‹ láº¥y cáº£m há»©ng tá»« thiáº¿t káº¿ AdminLTE káº¿t há»£p phong cÃ¡ch adidas UI. HÃ£y chá»n cÃ¡c chá»©c nÄƒng bÃªn trÃ¡i Ä‘á»ƒ báº¯t Ä‘áº§u quáº£n lÃ½.</p>
                        
                        <!-- Mini stat cards placeholder -->
                        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px;">
                            <div style="background: #10b981; color: #fff; padding: 20px; text-align: center;">
                                <i class="fa-solid fa-box-open" style="font-size: 30px; margin-bottom: 10px;"></i>
                                <div style="font-family: 'Oswald', sans-serif; font-size: 24px; font-weight: 700;"><?= number_format($countSanPham ?? 0) ?></div>
                                <div style="font-size: 13px; text-transform: uppercase;">Sáº£n pháº©m</div>
                            </div>
                            <div style="background: #000; color: #fff; padding: 20px; text-align: center;">
                                <i class="fa-solid fa-users" style="font-size: 30px; margin-bottom: 10px;"></i>
                                <div style="font-family: 'Oswald', sans-serif; font-size: 24px; font-weight: 700;"><?= number_format($countKhachHang ?? 0) ?></div>
                                <div style="font-size: 13px; text-transform: uppercase;">NgÆ°á»i dÃ¹ng</div>
                            </div>
                            <div style="background: #f89406; color: #fff; padding: 20px; text-align: center;">
                                <i class="fa-solid fa-shopping-cart" style="font-size: 30px; margin-bottom: 10px;"></i>
                                <div style="font-family: 'Oswald', sans-serif; font-size: 24px; font-weight: 700;"><?= number_format($countDonHang ?? 0) ?></div>
                                <div style="font-size: 13px; text-transform: uppercase;">ÄÆ¡n hÃ ng</div>
                            </div>
                            <div style="background: #dc3545; color: #fff; padding: 20px; text-align: center;">
                                <i class="fa-solid fa-boxes-stacked" style="font-size: 30px; margin-bottom: 10px;"></i>
                                <div style="font-family: 'Oswald', sans-serif; font-size: 24px; font-weight: 700;"><?= number_format($tongTonKho ?? 0) ?></div>
                                <div style="font-size: 13px; text-transform: uppercase;">Tá»“n kho</div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</body>
</html>
