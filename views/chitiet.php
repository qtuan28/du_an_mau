<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= !empty($sp) ? htmlspecialchars($sp['ten']) : 'Chi tiết sản phẩm' ?> | Pickleball Store</title>

    <!-- Google Fonts & FontAwesome Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/product-detail.css">
</head>
<body>

<?php if (!empty($sp)): ?>

    <!-- Breadcrumb Header Navigation -->
    <div class="pdp-breadcrumb-wrapper">
        <div class="container">
            <div class="pdp-breadcrumb">
                <a href="index.php?act=index"><i class="fa-solid fa-house"></i> Trang chủ</a>
                <i class="fa-solid fa-chevron-right"></i>
                <a href="index.php?act=danhmuc&id=<?= $sp['category_id'] ?? 1 ?>">
                    <?= htmlspecialchars($sp['ten_danh_muc'] ?? 'Sản phẩm') ?>
                </a>
                <i class="fa-solid fa-chevron-right"></i>
                <span class="active"><?= htmlspecialchars($sp['ten']) ?></span>
            </div>
        </div>
    </div>

    <!-- Main Container -->
    <div class="container">
        
        <!-- Hero PDP Grid Showcase -->
        <div class="pdp-grid">
            
            <!-- Left: Product Image Gallery Card -->
            <div class="pdp-gallery-card">
                <div class="pdp-badge-sticker">
                    <span class="badge-tag authentic">
                        <i class="fa-solid fa-certificate"></i> Chính Hãng 100%
                    </span>
                    <span class="badge-tag hot">
                        <i class="fa-solid fa-fire"></i> Bán Chạy
                    </span>
                </div>

                <div class="pdp-main-image-wrapper">
                    <img src="assets/images/<?= htmlspecialchars($sp['anh']) ?>" 
                         alt="<?= htmlspecialchars($sp['ten']) ?>"
                         onerror="this.onerror=null; this.src='assets/images/paddle_aero.png';">
                </div>
            </div>

            <!-- Right: Product Meta Info & Purchase Actions -->
            <div class="pdp-info-card">
                <div class="pdp-category-chip">
                    <i class="fa-solid fa-table-tennis-paddle-ball"></i>
                    <?= htmlspecialchars($sp['ten_danh_muc'] ?? 'Dụng cụ Pickleball') ?>
                </div>

                <h1 class="pdp-product-title"><?= htmlspecialchars($sp['ten']) ?></h1>

                <div class="pdp-rating-bar">
                    <div class="stars-group">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                    </div>
                    <span class="rating-score">5.0 (128 đánh giá)</span>
                    <span class="product-sku">Mã SP: #PB-<?= StringPad($sp['product_id']) ?></span>
                </div>

                <!-- Price Highlight Box -->
                <div class="pdp-price-box">
                    <div class="pdp-current-price">
                        <?= number_format($sp['gia'], 0, ',', '.') ?> VNĐ
                    </div>
                    <div class="pdp-original-price">
                        <?= number_format($sp['gia'] * 1.15, 0, ',', '.') ?> VNĐ
                    </div>
                    <span class="pdp-discount-badge">-15% TIẾT KIỆM</span>
                </div>

                <!-- Product Guarantees & Features -->
                <div class="pdp-features-list">
                    <div class="feature-item">
                        <i class="fa-solid fa-truck-fast"></i>
                        <span>Giao hàng hỏa tốc 24h</span>
                    </div>
                    <div class="feature-item">
                        <i class="fa-solid fa-rotate-left"></i>
                        <span>Đổi trả 7 ngày miễn phí</span>
                    </div>
                    <div class="feature-item">
                        <i class="fa-solid fa-shield-check"></i>
                        <span>Bảo hành chính hãng 12T</span>
                    </div>
                    <div class="feature-item">
                        <i class="fa-solid fa-award"></i>
                        <span>Đạt chuẩn thi đấu USAPA</span>
                    </div>
                </div>

                <!-- Quantity & Purchase Buttons -->
                <div class="pdp-actions-box">
                    <div class="quantity-picker-wrapper">
                        <label>Số lượng:</label>
                        <div class="quantity-stepper">
                            <span class="btn-step" onclick="changeQty(-1)"><i class="fa-solid fa-minus"></i></span>
                            <input type="number" id="pdpQty" value="1" min="1" max="99" class="quantity-input" readonly>
                            <span class="btn-step" onclick="changeQty(1)"><i class="fa-solid fa-plus"></i></span>
                        </div>
                    </div>

                    <div class="pdp-buttons-group">
                        <a href="index.php?act=add_giohang&id=<?= $sp['product_id'] ?>" 
                           id="addToCartBtn"
                           class="btn-add-cart">
                            <i class="fa-solid fa-cart-plus"></i> THÊM VÀO GIỎ HÀNG
                        </a>
                        
                        <a href="index.php?act=add_giohang&id=<?= $sp['product_id'] ?>&redirect=thanhtoan" 
                           class="btn-buy-now">
                            <i class="fa-solid fa-bolt"></i> MUA NGAY 
                        </a>
                    </div>
                </div>

            </div>

        </div>

        <!-- Specifications Section -->
        <div class="pdp-specs-section">
            <h2 class="pdp-specs-title">
                <i class="fa-solid fa-sliders"></i> THÔNG SỐ KỸ THUẬT SẢN PHẨM
            </h2>

            <div class="specs-grid-table">
                <div class="spec-row-card">
                    <span class="spec-label"><i class="fa-solid fa-cube"></i> Chất liệu mặt vợt:</span>
                    <span class="spec-value"><?= htmlspecialchars($sp['chat_lieu'] ?? 'Carbon Fiber T700 cao cấp') ?></span>
                </div>

                <div class="spec-row-card">
                    <span class="spec-label"><i class="fa-solid fa-ruler-combined"></i> Kích thước / Độ dày:</span>
                    <span class="spec-value"><?= htmlspecialchars($sp['kich_thuoc'] ?? '16mm Core Polypropylene') ?></span>
                </div>

                <div class="spec-row-card">
                    <span class="spec-label"><i class="fa-solid fa-hand-holding"></i> Chu vi tay cầm:</span>
                    <span class="spec-value"><?= htmlspecialchars($sp['loai_tay_cam'] ?? '4.25 inches (Standard)') ?></span>
                </div>

                <div class="spec-row-card">
                    <span class="spec-label"><i class="fa-solid fa-arrows-left-right"></i> Chiều dài x Chiều rộng:</span>
                    <span class="spec-value">
                        <?= !empty($sp['chieu_dai']) ? $sp['chieu_dai'] . ' cm x ' . $sp['chieu_rong'] . ' cm' : '16.5" x 7.5"' ?>
                    </span>
                </div>

                <div class="spec-row-card">
                    <span class="spec-label"><i class="fa-solid fa-stamp"></i> Chứng nhận chất lượng:</span>
                    <span class="spec-value"><?= htmlspecialchars($sp['chung_nhan'] ?? 'USAPA Approved cho giải đấu') ?></span>
                </div>

                <div class="spec-row-card">
                    <span class="spec-label"><i class="fa-solid fa-warehouse"></i> Tình trạng kho:</span>
                    <span class="spec-value" style="color: var(--color-accent-teal);">
                        <i class="fa-solid fa-circle-check"></i> Còn hàng (Giao nhanh)
                    </span>
                </div>
            </div>
        </div>

    </div>

    <!-- Simple Quantity & Cart Script Helper -->
    <script>
        function changeQty(delta) {
            const input = document.getElementById('pdpQty');
            let current = parseInt(input.value) || 1;
            current += delta;
            if (current < 1) current = 1;
            if (current > 99) current = 99;
            input.value = current;

            // Sync quantity param with Add to Cart button
            const cartBtn = document.getElementById('addToCartBtn');
            const baseUrl = "index.php?act=add_giohang&id=<?= $sp['product_id'] ?>";
            cartBtn.href = baseUrl + "&soluong=" + current;
        }
    </script>

<?php else: ?>

    <div class="container">
        <div class="pdp-not-found-card">
            <div class="pdp-not-found-icon">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
            <h2>Không tìm thấy sản phẩm!</h2>
            <p style="color: var(--color-gray-600); margin: 12px 0 24px 0;">
                Sản phẩm bạn đang tìm kiếm không tồn tại hoặc đã bị ngừng kinh doanh.
            </p>
            <a href="index.php?act=index" class="btn-buy-now">
                <i class="fa-solid fa-arrow-left"></i> Quay lại trang chủ
            </a>
        </div>
    </div>

<?php endif; ?>

<?php
// Helper function to pad IDs cleanly
function StringPad($id) {
    return str_pad($id, 4, '0', STR_PAD_LEFT);
}
?>

</body>
</html>