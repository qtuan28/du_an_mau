<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= !empty($sp) ? htmlspecialchars($sp['ten']) : 'Chi tiáº¿t sáº£n pháº©m' ?> | adidas Viá»‡t Nam</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
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
            align-items: start;
        }

        .adi-pdp-gallery-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2px;
            background-color: #ebedee;
            align-self: start;
            align-content: start;
        }

        .adi-pdp-gallery-item {
            background-color: #fff;
            aspect-ratio: 1 / 1;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            padding: 0;
            border: none;
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
            <a href="index.php">TRANG CHá»¦</a> / 
            <a href="index.php?act=sanpham">PICKLEBALL</a> / 
            <span><?= htmlspecialchars($sp['ten_danh_muc'] ?? 'Sáº¢N PHáº¨M') ?></span>
        </div>

        <div class="adi-pdp-main-grid">
            <!-- Left: 2x2 Product Image Showcase Grid -->
            <div class="adi-pdp-gallery-grid">
                <?php 
                    $resolveImg = function($val) {
                        if (empty($val)) return 'assets/images/hero_paddle.png';
                        if (strpos($val, 'assets/') === 0 || strpos($val, 'uploads/') === 0) return $val;
                        if (file_exists('assets/images/' . $val)) return 'assets/images/' . $val;
                        if (file_exists('uploads/' . $val)) return 'uploads/' . $val;
                        return 'assets/images/' . $val;
                    };

                    $mainImg = $resolveImg($sp['anh'] ?? '');
                    $img1 = !empty($sp['anh_1']) ? $resolveImg($sp['anh_1']) : $mainImg;
                    $img2 = !empty($sp['anh_2']) ? $resolveImg($sp['anh_2']) : $mainImg;
                    $img3 = !empty($sp['anh_3']) ? $resolveImg($sp['anh_3']) : $mainImg;
                    $img4 = !empty($sp['anh_4']) ? $resolveImg($sp['anh_4']) : $mainImg;
                ?>
                <div class="adi-pdp-gallery-item">
                    <img src="<?= htmlspecialchars($img1) ?>" alt="Detail Image 1" onerror="this.src='<?= BASE_URL ?>/assets/images/hero_paddle.png'">
                </div>
                <div class="adi-pdp-gallery-item">
                    <img src="<?= htmlspecialchars($img2) ?>" alt="Detail Image 2" onerror="this.src='<?= BASE_URL ?>/assets/images/hero_paddle.png'">
                </div>
                <div class="adi-pdp-gallery-item">
                    <img src="<?= htmlspecialchars($img3) ?>" alt="Detail Image 3" onerror="this.src='<?= BASE_URL ?>/assets/images/hero_paddle.png'">
                </div>
                <div class="adi-pdp-gallery-item">
                    <img src="<?= htmlspecialchars($img4) ?>" alt="Detail Image 4" onerror="this.src='<?= BASE_URL ?>/assets/images/hero_paddle.png'">
                </div>
            </div>

            <!-- Right: Product Purchase Panel -->
            <div class="adi-pdp-panel">
                <div class="adi-pdp-category-tag">NAM â€¢ PICKLEBALL PROFESSIONAL</div>
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
                    <span style="color: #767677;">(128 Ä‘Ã¡nh giÃ¡)</span>
                </div>

                <div class="adi-pdp-price"><?= number_format($sp['gia'], 0, ',', '.') ?>â‚«</div>

                <?php 
                    $bien_the_str = trim($sp['bien_the'] ?? '');
                    $variants = [];
                    if (!empty($bien_the_str)) {
                        // TÃ¡ch báº±ng dáº¥u pháº©y vÃ  loáº¡i bá» khoáº£ng tráº¯ng thá»«a
                        $variants = array_filter(array_map('trim', explode(',', $bien_the_str)));
                    }
                ?>

                <!-- Dynamic Variant Selector -->
                <?php if (!empty($variants)): ?>
                <div class="adi-pdp-size-section">
                    <div class="adi-pdp-size-header">
                        <span>CHá»ŒN BIáº¾N THá»‚ Sáº¢N PHáº¨M</span>
                    </div>
                    <div class="adi-pdp-size-grid" style="grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));">
                        <?php foreach ($variants as $index => $variant): ?>
                            <div class="adi-size-box <?= $index === 0 ? 'selected' : '' ?>"><?= htmlspecialchars($variant) ?></div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Quantity Stepper -->
                <div class="adi-pdp-qty-bar">
                    <span style="font-family: 'Roboto', sans-serif; font-size: 13px; font-weight: 700; text-transform: uppercase;">Sá»‘ lÆ°á»£ng:</span>
                    <button type="button" class="adi-qty-btn" onclick="changeQty(-1)"><i class="fa-solid fa-minus"></i></button>
                    <input type="text" id="pdpQty" class="adi-qty-input" value="1" readonly>
                    <button type="button" class="adi-qty-btn" onclick="changeQty(1)"><i class="fa-solid fa-plus"></i></button>
                </div>

                <!-- Primary Action Buttons -->
                <a href="index.php?act=add_giohang&id=<?= $sp['product_id'] ?>" id="addToCartBtn" class="adi-pdp-cta-full">
                    <span>THÃŠM VÃ€O GIá»Ž HÃ€NG</span>
                    <i class="fa-solid fa-arrow-right-long"></i>
                </a>

                <!-- Benefits Box -->
                <div class="adi-pdp-benefits">
                    <div class="adi-benefit-item">
                        <i class="fa-solid fa-truck-fast" style="font-size: 16px;"></i>
                        <span>Giao hÃ ng miá»…n phÃ­ cho Ä‘Æ¡n hÃ ng tá»« 1.600.000 VNÄ</span>
                    </div>
                    <div class="adi-benefit-item">
                        <i class="fa-solid fa-rotate-left" style="font-size: 16px;"></i>
                        <span>Tráº£ hÃ ng miá»…n phÃ­ trong vÃ²ng 30 ngÃ y</span>
                    </div>
                    <div class="adi-benefit-item">
                        <i class="fa-solid fa-shield-check" style="font-size: 16px;"></i>
                        <span>Cam káº¿t sáº£n pháº©m chÃ­nh hÃ£ng 100% Ä‘áº¡t chuáº©n USAPA</span>
                    </div>
                </div>

                <!-- Collapsible Details Accordion -->
                <div class="adi-pdp-accordion-box">
                    <div class="adi-pdp-accordion-item">
                        <div class="adi-pdp-accordion-title">
                            MÃ” Táº¢ Sáº¢N PHáº¨M
                        </div>
                        <div class="adi-pdp-accordion-body">
                            Sáº£n pháº©m sá»Ÿ há»¯u thiáº¿t káº¿ Ä‘á»™t phÃ¡ cho lá»‘i chÆ¡i pickleball hiá»‡n Ä‘áº¡i. LÃµi tá»• ong cao cáº¥p káº¿t há»£p máº·t Carbon T700 Ä‘áº£m báº£o kiá»ƒm soÃ¡t lá»±c xoÃ¡y tá»‘i Æ°u vÃ  Ä‘á»™ bá»n thi Ä‘áº¥u vÆ°á»£t trá»™i.
                        </div>
                    </div>
                    
                    <div class="adi-pdp-accordion-item">
                        <div class="adi-pdp-accordion-title">
                            THÃ”NG Sá» Ká»¸ THUáº¬T
                        </div>
                        <div class="adi-pdp-accordion-body">
                            <ul style="padding-left: 20px; margin: 0; display: flex; flex-direction: column; gap: 8px;">
                                <?php if (!empty($sp['chat_lieu'])): ?>
                                    <li><strong>Cháº¥t liá»‡u:</strong> <?= htmlspecialchars($sp['chat_lieu']) ?></li>
                                <?php endif; ?>

                                <?php if (!empty($sp['do_day_loi']) && $sp['do_day_loi'] > 0): ?>
                                    <li><strong>Äá»™ dÃ y lÃµi:</strong> <?= htmlspecialchars($sp['do_day_loi']) ?>mm</li>
                                <?php endif; ?>

                                <?php if (!empty($sp['loai_tay_cam'])): ?>
                                    <li><strong>Loáº¡i tay cáº§m:</strong> <?= htmlspecialchars($sp['loai_tay_cam']) ?></li>
                                <?php endif; ?>

                                <?php if (!empty($sp['chieu_dai']) && $sp['chieu_dai'] > 0): ?>
                                    <li><strong>KÃ­ch thÆ°á»›c (DÃ i x Rá»™ng):</strong> <?= htmlspecialchars($sp['chieu_dai']) ?> cm <?= (!empty($sp['chieu_rong']) && $sp['chieu_rong'] > 0) ? 'x ' . htmlspecialchars($sp['chieu_rong']) . ' cm' : '' ?></li>
                                <?php endif; ?>

                                <?php if (!empty($sp['chieu_dai_tay_cam']) && $sp['chieu_dai_tay_cam'] > 0): ?>
                                    <li><strong>Chiá»u dÃ i tay cáº§m:</strong> <?= htmlspecialchars($sp['chieu_dai_tay_cam']) ?> cm</li>
                                <?php endif; ?>

                                <?php if (!empty($sp['chu_vi_tay_cam']) && $sp['chu_vi_tay_cam'] > 0): ?>
                                    <li><strong>Chu vi tay cáº§m:</strong> <?= htmlspecialchars($sp['chu_vi_tay_cam']) ?> cm</li>
                                <?php endif; ?>

                                <?php if (!empty($sp['trong_luong']) && $sp['trong_luong'] > 0): ?>
                                    <li><strong>Trá»ng lÆ°á»£ng:</strong> <?= htmlspecialchars($sp['trong_luong']) ?>g</li>
                                <?php endif; ?>

                                <?php if (!empty($sp['chung_nhan'])): ?>
                                    <li><strong>Chá»©ng nháº­n:</strong> <?= htmlspecialchars($sp['chung_nhan']) ?></li>
                                <?php endif; ?>

                                <?php if (!empty($sp['kich_thuoc'])): ?>
                                    <li><strong>KÃ­ch thÆ°á»›c tá»•ng thá»ƒ:</strong> <?= htmlspecialchars($sp['kich_thuoc']) ?></li>
                                <?php endif; ?>

                                <?php if (empty($sp['chat_lieu']) && empty($sp['chung_nhan']) && empty($sp['loai_tay_cam']) && empty($sp['kich_thuoc']) && empty($sp['trong_luong'])): ?>
                                    <li>Máº·t vá»£t: Carbon Fiber T700</li>
                                    <li>Äá»™ dÃ y lÃµi: 16mm Polypropylene Core</li>
                                    <li>Chiá»u dÃ i tay cáº§m: Standard 4.25"</li>
                                    <li>Chá»©ng nháº­n: USAPA Approved</li>
                                <?php endif; ?>
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
        <h2 style="font-family: 'Oswald', sans-serif; font-size: 32px; text-transform: uppercase;">KHÃ”NG TÃŒM THáº¤Y Sáº¢N PHáº¨M</h2>
        <p style="color: #767677; margin-bottom: 24px;">Sáº£n pháº©m khÃ´ng tá»“n táº¡i hoáº·c Ä‘Ã£ bá»‹ gá»¡ khá»i há»‡ thá»‘ng.</p>
        <a href="index.php?act=sanpham" class="adi-btn-sharp">XEM Táº¤T Cáº¢ Sáº¢N PHáº¨M â†’</a>
    </div>
<?php endif; ?>

<?php include 'views/footer.php'; ?>

</body>
</html>