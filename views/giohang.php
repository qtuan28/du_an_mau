<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ Hàng | Pickleball Store</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .adi-cart-wrapper {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px 80px;
        }

        .adi-cart-breadcrumb {
            font-family: 'Roboto', sans-serif;
            font-size: 12px;
            font-weight: 500;
            text-transform: uppercase;
            color: #767677;
            margin-bottom: 24px;
        }

        .adi-cart-breadcrumb a {
            color: #000;
            text-decoration: underline;
        }

        .adi-cart-title {
            font-family: 'Oswald', sans-serif;
            font-size: 36px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: -0.5px;
            margin-bottom: 30px;
            padding-bottom: 16px;
            border-bottom: 1px solid #ebedee;
            display: flex;
            align-items: baseline;
            gap: 12px;
        }

        .adi-cart-count {
            font-family: 'Roboto', sans-serif;
            font-size: 18px;
            color: #767677;
            font-weight: 400;
        }

        .adi-cart-grid {
            display: grid;
            grid-template-columns: 1fr 360px;
            gap: 40px;
            align-items: start;
        }

        @media (max-width: 992px) {
            .adi-cart-grid {
                grid-template-columns: 1fr;
            }
        }

        .adi-cart-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .adi-cart-table th {
            font-family: 'Oswald', sans-serif;
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            text-align: left;
            padding: 14px;
            border-bottom: 2px solid #000;
            background: #fafafa;
        }

        .adi-cart-table td {
            padding: 20px 14px;
            border-bottom: 1px solid #ebedee;
            vertical-align: middle;
        }

        .adi-cart-item-flex {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .adi-cart-thumb {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border: 1px solid #ebedee;
            flex-shrink: 0;
            background: #fff;
        }

        .adi-cart-item-name {
            font-family: 'Roboto', sans-serif;
            font-size: 15px;
            font-weight: 500;
            color: #000;
            text-decoration: none;
            line-height: 1.4;
            display: block;
        }

        .adi-cart-item-name:hover {
            text-decoration: underline;
        }

        .adi-cart-price {
            font-family: 'Roboto', sans-serif;
            font-size: 15px;
            font-weight: 700;
            color: #000;
        }

        .adi-qty-input {
            width: 60px;
            padding: 8px;
            text-align: center;
            font-family: 'Roboto', sans-serif;
            font-size: 14px;
            font-weight: 700;
            border: 1px solid #ccc;
            outline: none;
        }

        .adi-qty-input:focus {
            border-color: #000;
        }

        .adi-cart-btn-del {
            color: #888;
            font-size: 18px;
            text-decoration: none;
            transition: color 0.2s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
        }

        .adi-cart-btn-del:hover {
            color: #e50010;
        }

        .adi-cart-actions-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 16px;
        }

        .adi-btn-update {
            background-color: #fff;
            color: #000;
            font-family: 'Oswald', sans-serif;
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 12px 20px;
            border: 1px solid #000;
            cursor: pointer;
            transition: all 0.2s;
        }

        .adi-btn-update:hover {
            background-color: #000;
            color: #fff;
        }

        .adi-link-clear-all {
            font-family: 'Roboto', sans-serif;
            font-size: 13px;
            color: #e50010;
            text-decoration: underline;
            font-weight: 500;
        }

        /* Order Summary Box */
        .adi-cart-summary {
            background-color: #f8f9fa;
            border: 1px solid #ebedee;
            padding: 30px;
            position: sticky;
            top: 100px;
        }

        .adi-summary-title {
            font-family: 'Oswald', sans-serif;
            font-size: 20px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 1px solid #ddd;
        }

        .adi-summary-row {
            display: flex;
            justify-content: space-between;
            font-family: 'Roboto', sans-serif;
            font-size: 14px;
            margin-bottom: 14px;
            color: #444;
        }

        .adi-summary-row.total {
            font-size: 18px;
            font-weight: 700;
            color: #000;
            margin-top: 20px;
            padding-top: 16px;
            border-top: 2px solid #000;
        }

        .adi-checkout-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            width: 100%;
            background-color: #000;
            color: #fff;
            font-family: 'Oswald', sans-serif;
            font-size: 15px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            padding: 16px;
            text-decoration: none;
            border: 1px solid #000;
            margin-top: 24px;
            transition: background-color 0.2s;
        }

        .adi-checkout-btn:hover {
            background-color: #222;
        }

        .adi-continue-shopping {
            display: block;
            text-align: center;
            font-family: 'Roboto', sans-serif;
            font-size: 13px;
            color: #666;
            text-decoration: underline;
            margin-top: 16px;
        }

        .adi-cart-perks {
            margin-top: 24px;
            padding-top: 20px;
            border-top: 1px dashed #ccc;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .adi-perk-item {
            display: flex;
            align-items: center;
            gap: 10px;
            font-family: 'Roboto', sans-serif;
            font-size: 12px;
            color: #555;
        }

        .adi-perk-item i {
            color: #000;
            font-size: 14px;
        }

        /* Empty Cart State */
        .adi-empty-cart-card {
            text-align: center;
            padding: 80px 20px;
            background: #fff;
            border: 1px solid #ebedee;
        }

        .adi-empty-icon {
            font-size: 60px;
            color: #ccc;
            margin-bottom: 20px;
        }

        .adi-empty-title {
            font-family: 'Oswald', sans-serif;
            font-size: 24px;
            font-weight: 700;
            text-transform: uppercase;
            margin-bottom: 10px;
        }

        .adi-empty-desc {
            font-family: 'Roboto', sans-serif;
            font-size: 14px;
            color: #767677;
            margin-bottom: 30px;
        }
    </style>
</head>
<body>

    <!-- Header bar -->
    <?php include 'views/header.php'; ?>

    <div class="adi-cart-wrapper">
        <div class="adi-cart-breadcrumb">
            <a href="index.php">TRANG CHỦ</a> / <span>GIỎ HÀNG</span>
        </div>

        <?php if (!empty($gioHang)): ?>
            <?php 
                $tongTien = 0;
                $totalItemsCount = 0;
                foreach ($gioHang as $item) {
                    $tongTien += $item['gia'] * $item['so_luong'];
                    $totalItemsCount += $item['so_luong'];
                }
            ?>
            <h1 class="adi-cart-title">
                GIỎ HÀNG CỦA BẠN <span class="adi-cart-count">[<?= $totalItemsCount ?> sản phẩm]</span>
            </h1>

            <div class="adi-cart-grid">
                <!-- Cart Items List -->
                <div>
                    <form action="index.php?act=update_giohang" method="POST">
                        <table class="adi-cart-table">
                            <thead>
                                <tr>
                                    <th>SẢN PHẨM</th>
                                    <th>ĐƠN GIÁ</th>
                                    <th>SỐ LƯỢNG</th>
                                    <th>THÀNH TIỀN</th>
                                    <th style="text-align: center;">XÓA</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($gioHang as $item): 
                                    $thanhTien = $item['gia'] * $item['so_luong'];
                                    
                                    $imgPath = 'assets/images/hero_paddle.png';
                                    if (!empty($item['anh'])) {
                                        if (strpos($item['anh'], 'assets/') === 0 || strpos($item['anh'], 'uploads/') === 0) {
                                            $imgPath = $item['anh'];
                                        } elseif (file_exists('uploads/' . $item['anh'])) {
                                            $imgPath = 'uploads/' . $item['anh'];
                                        } elseif (file_exists('assets/images/' . $item['anh'])) {
                                            $imgPath = 'assets/images/' . $item['anh'];
                                        } else {
                                            $imgPath = 'uploads/' . $item['anh'];
                                        }
                                    }
                                ?>
                                <tr>
                                    <td>
                                        <div class="adi-cart-item-flex">
                                            <img src="<?= htmlspecialchars($imgPath) ?>" alt="<?= htmlspecialchars($item['ten']) ?>" class="adi-cart-thumb" onerror="this.src='<?= BASE_URL ?>/assets/images/hero_paddle.png'">
                                            <div>
                                                <a href="index.php?act=sanpham_chitiet&id=<?= $item['product_id'] ?>" class="adi-cart-item-name">
                                                    <?= htmlspecialchars($item['ten']) ?>
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="adi-cart-price"><?= number_format($item['gia'], 0, ',', '.') ?>₫</span>
                                    </td>
                                    <td>
                                        <input type="number" name="so_luong[<?= $item['product_id'] ?>]" value="<?= $item['so_luong'] ?>" min="1" class="adi-qty-input">
                                    </td>
                                    <td>
                                        <span class="adi-cart-price"><?= number_format($thanhTien, 0, ',', '.') ?>₫</span>
                                    </td>
                                    <td style="text-align: center;">
                                        <a href="index.php?act=delete_giohang&id=<?= $item['product_id'] ?>" 
                                           class="adi-cart-btn-del"
                                           title="Xóa sản phẩm"
                                           onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này?')">
                                           <i class="fa-regular fa-trash-can"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>

                        <div class="adi-cart-actions-row">
                            <button type="submit" class="adi-btn-update">
                                <i class="fa-solid fa-rotate"></i> CẬP NHẬT SỐ LƯỢNG
                            </button>
                            <a href="index.php?act=delete_giohang&id=all" class="adi-link-clear-all" onclick="return confirm('Xóa toàn bộ giỏ hàng?')">
                                Xóa tất cả sản phẩm
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Order Summary Panel -->
                <div class="adi-cart-summary">
                    <h3 class="adi-summary-title">TỔNG ĐƠN HÀNG</h3>
                    
                    <div class="adi-summary-row">
                        <span>Tạm tính</span>
                        <strong><?= number_format($tongTien, 0, ',', '.') ?>₫</strong>
                    </div>
                    
                    <div class="adi-summary-row">
                        <span>Giao hàng</span>
                        <span style="color: #10b981; font-weight: 700;">MIỄN PHÍ</span>
                    </div>

                    <div class="adi-summary-row total">
                        <span>TỔNG CỘNG</span>
                        <span><?= number_format($tongTien, 0, ',', '.') ?>₫</span>
                    </div>

                    <a href="index.php?act=thanhtoan" class="adi-checkout-btn">
                        TIẾN HÀNH THANH TOÁN <i class="fa-solid fa-arrow-right-long"></i>
                    </a>

                    <a href="index.php?act=sanpham" class="adi-continue-shopping">
                        ← Tiếp tục mua hàng
                    </a>

                    <div class="adi-cart-perks">
                        <div class="adi-perk-item">
                            <i class="fa-solid fa-truck-fast"></i>
                            <span>Giao hàng miễn phí cho đơn từ 1.600.000đ</span>
                        </div>
                        <div class="adi-perk-item">
                            <i class="fa-solid fa-rotate-left"></i>
                            <span>Đổi trả miễn phí trong 30 ngày</span>
                        </div>
                        <div class="adi-perk-item">
                            <i class="fa-solid fa-shield-halved"></i>
                            <span>Sản phẩm chính hãng 100%</span>
                        </div>
                    </div>
                </div>
            </div>

        <?php else: ?>
            <!-- Empty Cart -->
            <div class="adi-empty-cart-card">
                <i class="fa-solid fa-bag-shopping adi-empty-icon"></i>
                <h2 class="adi-empty-title">GIỎ HÀNG CỦA BẠN ĐANG TRỐNG</h2>
                <p class="adi-empty-desc">Chưa có sản phẩm nào trong giỏ hàng. Hãy khám phá các bộ sưu tập Pickleball mới nhất của chúng tôi.</p>
                <a href="index.php?act=sanpham" class="adi-checkout-btn" style="display: inline-flex; width: auto; padding: 16px 36px;">
                    KHÁM PHÁ SẢN PHẨM NGAY <i class="fa-solid fa-arrow-right-long"></i>
                </a>
            </div>
        <?php endif; ?>
    </div>

    <!-- Footer -->
    <?php include 'views/footer.php'; ?>

</body>
</html>
