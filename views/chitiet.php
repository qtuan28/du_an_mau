<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= !empty($sp) ? htmlspecialchars($sp['ten']) : 'Chi tiết sản phẩm' ?> | adidas Việt Nam</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .adi-pdp-wrapper {
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px 40px 80px;
        }

        .adi-pdp-breadcrumb {
            font-family: 'Roboto', sans-serif;
            font-size: 12px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #767677;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .adi-pdp-breadcrumb a {
            color: #000;
            text-decoration: underline;
        }

        .adi-pdp-main-grid {
            display: grid;
            grid-template-columns: 7fr 5fr;
            gap: 50px;
        }

        .adi-pdp-gallery-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .adi-pdp-gallery-item {
            background-color: #fff;
            aspect-ratio: 1 / 1;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            padding: 0;
            border: 1px solid #ebedee;
        }

        .adi-pdp-gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .adi-pdp-gallery-item:hover img {
            transform: scale(1.06);
        }

        .adi-pdp-panel {
            position: sticky;
            top: 100px;
            align-self: flex-start;
        }

        .adi-pdp-category-tag {
            font-family: 'Roboto', sans-serif;
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            color: #767677;
            letter-spacing: 1px;
            margin-bottom: 8px;
        }

        .adi-pdp-title {
            font-family: 'Oswald', sans-serif;
            font-size: 38px;
            font-weight: 700;
            text-transform: uppercase;
            line-height: 1.1;
            margin-bottom: 12px;
            letter-spacing: -0.5px;
        }

        .adi-pdp-rating {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            margin-bottom: 20px;
        }

        .adi-pdp-rating .stars {
            color: #000;
        }

        .adi-pdp-price {
            font-family: 'Roboto', sans-serif;
            font-size: 24px;
            font-weight: 700;
            color: #000;
            margin-bottom: 30px;
        }

        .adi-pdp-size-section {
            margin-bottom: 30px;
        }

        .adi-pdp-size-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-family: 'Roboto', sans-serif;
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            margin-bottom: 12px;
        }

        .adi-pdp-size-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 8px;
        }

        .adi-size-box {
            height: 48px;
            border: 1px solid #ebedee;
            background-color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Roboto', sans-serif;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .adi-size-box:hover, .adi-size-box.selected {
            border-color: #000;
            background-color: #000;
            color: #fff;
        }

        .adi-pdp-qty-bar {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 24px;
        }

        .adi-qty-btn {
            width: 44px;
            height: 44px;
            border: 1px solid #000;
            background: #fff;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.2s;
        }

        .adi-qty-btn:hover {
            background-color: #000;
            color: #fff;
        }

        .adi-qty-input {
            width: 60px;
            height: 44px;
            border: 1px solid #ebedee;
            text-align: center;
            font-family: 'Roboto', sans-serif;
            font-size: 16px;
            font-weight: 700;
        }

        .adi-pdp-cta-full {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            height: 54px;
            background-color: #000;
            color: #fff;
            font-family: 'Oswald', sans-serif;
            font-size: 16px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            padding: 0 24px;
            text-decoration: none;
            border: 1px solid #000;
            transition: all 0.2s ease;
            margin-bottom: 16px;
        }

        .adi-pdp-cta-full:hover {
            background-color: #fff;
            color: #000;
        }

        .adi-pdp-benefits {
            margin-top: 30px;
            padding-top: 24px;
            border-top: 1px solid #ebedee;
            display: flex;
            flex-direction: column;
            gap: 14px;
            font-size: 13px;
        }

        .adi-benefit-item {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #363636;
        }

        .adi-pdp-accordion-box {
            margin-top: 40px;
            border-top: 1px solid #ebedee;
        }

        .adi-pdp-accordion-item {
            border-bottom: 1px solid #ebedee;
            padding: 20px 0;
        }

        .adi-pdp-accordion-title {
            font-family: 'Oswald', sans-serif;
            font-size: 18px;
            font-weight: 700;
            text-transform: uppercase;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
        }

        .adi-pdp-accordion-body {
            font-family: 'Roboto', sans-serif;
            font-size: 14px;
            line-height: 1.6;
            color: #363636;
            margin-top: 16px;
        }
    </style>
</head>
<body>

<?php include 'views/header.php'; ?>

<?php if (!empty($sp)): ?>
    <div class="adi-pdp-wrapper">
        <!-- Breadcrumb Navigation -->
        <div class="adi-pdp-breadcrumb">
            <a href="index.php">TRANG CHỦ</a> / 
            <a href="index.php?act=sanpham">PICKLEBALL</a> / 
            <span><?= htmlspecialchars($sp['ten_danh_muc'] ?? 'SẢN PHẨM') ?></span>
        </div>

        <div class="adi-pdp-main-grid">
            <!-- Left: 2x2 Product Image Showcase Grid -->
            <div class="adi-pdp-gallery-grid">
                <?php 
                    $img = !empty($sp['anh']) ? (strpos($sp['anh'], 'assets/') === 0 ? $sp['anh'] : 'assets/images/' . $sp['anh']) : 'assets/images/hero_paddle.png';
                ?>
                <div class="adi-pdp-gallery-item">
                    <img src="<?= htmlspecialchars($img) ?>" alt="Image 1" onerror="this.src='assets/images/hero_paddle.png'">
                </div>
                <div class="adi-pdp-gallery-item">
                    <img src="<?= htmlspecialchars($img) ?>" alt="Image 2" onerror="this.src='assets/images/hero_paddle.png'">
                </div>
                <div class="adi-pdp-gallery-item">
                    <img src="<?= htmlspecialchars($img) ?>" alt="Image 3" onerror="this.src='assets/images/hero_paddle.png'">
                </div>
                <div class="adi-pdp-gallery-item">
                    <img src="<?= htmlspecialchars($img) ?>" alt="Image 4" onerror="this.src='assets/images/hero_paddle.png'">
                </div>
            </div>

            <!-- Right: Product Purchase Panel -->
            <div class="adi-pdp-panel">
                <div class="adi-pdp-category-tag">NAM • PICKLEBALL PROFESSIONAL</div>
                <h1 class="adi-pdp-title"><?= htmlspecialchars($sp['ten']) ?></h1>

                <div class="adi-pdp-rating">
                    <div class="stars">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                    </div>
                    <strong>5.0</strong>
                    <span style="color: #767677;">(128 đánh giá)</span>
                </div>

                <div class="adi-pdp-price"><?= number_format($sp['gia'], 0, ',', '.') ?>₫</div>

                <!-- Size Selector Box Grid -->
                <div class="adi-pdp-size-section">
                    <div class="adi-pdp-size-header">
                        <span>CHỌN KÍCH CỠ / PHÂN LOẠI</span>
                        <a href="#" style="color: #000; text-underline-offset: 3px;">Bảng quy đổi cỡ</a>
                    </div>
                    <div class="adi-pdp-size-grid">
                        <div class="adi-size-box selected">39</div>
                        <div class="adi-size-box">40</div>
                        <div class="adi-size-box">41</div>
                        <div class="adi-size-box">42</div>
                        <div class="adi-size-box">43</div>
                    </div>
                </div>

                <!-- Quantity Stepper -->
                <div class="adi-pdp-qty-bar">
                    <span style="font-family: 'Roboto', sans-serif; font-size: 13px; font-weight: 700; text-transform: uppercase;">Số lượng:</span>
                    <button type="button" class="adi-qty-btn" onclick="changeQty(-1)"><i class="fa-solid fa-minus"></i></button>
                    <input type="text" id="pdpQty" class="adi-qty-input" value="1" readonly>
                    <button type="button" class="adi-qty-btn" onclick="changeQty(1)"><i class="fa-solid fa-plus"></i></button>
                </div>

                <!-- Primary Action Buttons -->
                <a href="index.php?act=add_giohang&id=<?= $sp['product_id'] ?>" id="addToCartBtn" class="adi-pdp-cta-full">
                    <span>THÊM VÀO GIỎ HÀNG</span>
                    <i class="fa-solid fa-arrow-right-long"></i>
                </a>

                <!-- Benefits Box -->
                <div class="adi-pdp-benefits">
                    <div class="adi-benefit-item">
                        <i class="fa-solid fa-truck-fast" style="font-size: 16px;"></i>
                        <span>Giao hàng miễn phí cho đơn hàng từ 1.600.000 VNĐ</span>
                    </div>
                    <div class="adi-benefit-item">
                        <i class="fa-solid fa-rotate-left" style="font-size: 16px;"></i>
                        <span>Trả hàng miễn phí trong vòng 30 ngày</span>
                    </div>
                    <div class="adi-benefit-item">
                        <i class="fa-solid fa-shield-check" style="font-size: 16px;"></i>
                        <span>Cam kết sản phẩm chính hãng 100% đạt chuẩn USAPA</span>
                    </div>
                </div>

                <!-- Collapsible Details Accordion -->
                <div class="adi-pdp-accordion-box">
                    <div class="adi-pdp-accordion-item">
                        <div class="adi-pdp-accordion-title">
                            MÔ TẢ SẢN PHẨM <i class="fa-solid fa-chevron-down"></i>
                        </div>
                        <div class="adi-pdp-accordion-body">
                            Sản phẩm sở hữu thiết kế đột phá cho lối chơi pickleball hiện đại. Lõi tổ ong cao cấp kết hợp mặt Carbon T700 đảm bảo kiểm soát lực xoáy tối ưu và độ bền thi đấu vượt trội.
                        </div>
                    </div>
                    
                    <div class="adi-pdp-accordion-item">
                        <div class="adi-pdp-accordion-title">
                            THÔNG SỐ KỸ THUẬT <i class="fa-solid fa-chevron-down"></i>
                        </div>
                        <div class="adi-pdp-accordion-body">
                            <ul style="padding-left: 20px; margin: 0;">
                                <li>Mặt vợt: Carbon Fiber T700</li>
                                <li>Độ dày lõi: 16mm Polypropylene Core</li>
                                <li>Chiều dài tay cầm: Standard 4.25"</li>
                                <li>Chứng nhận: USAPA Approved</li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        function changeQty(delta) {
            const input = document.getElementById('pdpQty');
            let current = parseInt(input.value) || 1;
            current += delta;
            if (current < 1) current = 1;
            if (current > 99) current = 99;
            input.value = current;

            const cartBtn = document.getElementById('addToCartBtn');
            const baseUrl = "index.php?act=add_giohang&id=<?= $sp['product_id'] ?>";
            cartBtn.href = baseUrl + "&soluong=" + current;
        }

        // Toggle Size selection
        document.querySelectorAll('.adi-size-box').forEach(box => {
            box.addEventListener('click', function() {
                document.querySelectorAll('.adi-size-box').forEach(b => b.classList.remove('selected'));
                this.classList.add('selected');
            });
        });
    </script>
<?php else: ?>
    <div style="text-align: center; padding: 100px 0;">
        <h2 style="font-family: 'Oswald', sans-serif; font-size: 32px; text-transform: uppercase;">KHÔNG TÌM THẤY SẢN PHẨM</h2>
        <p style="color: #767677; margin-bottom: 24px;">Sản phẩm không tồn tại hoặc đã bị gỡ khỏi hệ thống.</p>
        <a href="index.php?act=sanpham" class="adi-btn-sharp">XEM TẤT CẢ SẢN PHẨM →</a>
    </div>
<?php endif; ?>

<?php include 'views/footer.php'; ?>

</body>
</html>