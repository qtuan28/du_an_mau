<div class="adi-section-wrapper" style="padding-top: 0;">
    <div class="adi-section-header">
        <h2 class="adi-section-title">BỘ SƯU TẬP PPA TOUR 2026</h2>
        <a href="index.php?act=sanpham" class="adi-section-link">KHÁM PHÁ THÊM →</a>
    </div>

    <?php 
        $listPpa = array_slice($dsSanPham, 4, 4);
        if (empty($listPpa)) {
            $listPpa = $dsSanPham;
        }
    ?>
    <?php if (!empty($listPpa)): ?>
        <div class="adi-grid-4">
            <?php foreach ($listPpa as $sp): ?>
                <?php
                    $imgPath = 'assets/images/hero_paddle.png';
                    if (!empty($sp['anh'])) {
                        if (strpos($sp['anh'], 'assets/') === 0 || strpos($sp['anh'], 'uploads/') === 0) {
                            $imgPath = $sp['anh'];
                        } elseif (file_exists('assets/images/' . $sp['anh'])) {
                            $imgPath = 'assets/images/' . $sp['anh'];
                        } elseif (file_exists('uploads/' . $sp['anh'])) {
                            $imgPath = 'uploads/' . $sp['anh'];
                        } else {
                            $imgPath = 'assets/images/' . $sp['anh'];
                        }
                    }
                ?>
                <div class="adi-card">
                    <div class="adi-card-media">
                        <a href="index.php?act=sanpham_chitiet&id=<?= $sp['product_id'] ?>" style="display: contents;">
                            <img src="<?= htmlspecialchars($imgPath) ?>" alt="<?= htmlspecialchars($sp['ten']) ?>" onerror="this.src='<?= BASE_URL ?>/assets/images/hero_paddle.png'">
                        </a>
                    </div>

                    <div class="adi-card-info">
                        <div class="adi-card-price"><?= number_format($sp['gia'], 0, ',', '.') ?>₫</div>
                        <a href="index.php?act=sanpham_chitiet&id=<?= $sp['product_id'] ?>" style="text-decoration: none;">
                            <div class="adi-card-title"><?= htmlspecialchars($sp['ten']) ?></div>
                        </a>
                        <div class="adi-card-sub"><?= htmlspecialchars($sp['ten_danh_muc'] ?? 'Thi đấu quốc tế') ?></div>

                        <a href="index.php?act=add_giohang&id=<?= $sp['product_id'] ?>" class="adi-card-btn">THÊM VÀO GIỎ HÀNG</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
