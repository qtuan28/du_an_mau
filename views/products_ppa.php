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
                <div class="adi-card">
                    <div class="adi-card-media">
                        <span class="adi-card-badge" style="background-color: #e50010;">HOT</span>
                        <button type="button" class="adi-card-fav" title="Yêu thích"><i class="fa-regular fa-heart"></i></button>
                        <a href="index.php?act=sanpham_chitiet&id=<?= $sp['product_id'] ?>" style="display: contents;">
                            <img src="<?= !empty($sp['anh']) ? (strpos($sp['anh'], 'assets/') === 0 ? $sp['anh'] : 'assets/images/' . $sp['anh']) : 'assets/images/hero_paddle.png' ?>" alt="<?= htmlspecialchars($sp['ten']) ?>" onerror="this.src='assets/images/hero_paddle.png'">
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
