<style>
.adi-section-wrapper {
    padding: 60px 40px;
}

.adi-section-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    margin-bottom: 24px;
}

.adi-section-title {
    font-family: 'Oswald', sans-serif;
    font-size: 32px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin: 0;
}

.adi-section-link {
    font-family: 'Oswald', sans-serif;
    font-size: 14px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: #000;
    text-decoration: underline;
    text-underline-offset: 4px;
}

.adi-grid-4 {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
}

.adi-card {
    position: relative;
    background-color: #fff;
    text-decoration: none;
    color: #000;
    display: flex;
    flex-direction: column;
    border: 1px solid transparent;
    transition: border 0.1s ease-in-out;
}

.adi-card:hover {
    border: 1px solid #000;
}

.adi-card-media {
    position: relative;
    background-color: #fff;
    aspect-ratio: 1 / 1;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

.adi-card-media img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.adi-card:hover .adi-card-media img {
    transform: scale(1.05);
}

.adi-card-badge {
    position: absolute;
    top: 10px;
    left: 10px;
    background-color: #000;
    color: #fff;
    font-family: 'Oswald', sans-serif;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    padding: 4px 8px;
    z-index: 2;
}

.adi-card-info {
    padding: 14px 12px;
    display: flex;
    flex-direction: column;
    flex-grow: 1;
    justify-content: space-between;
}

.adi-card-price {
    font-family: 'Roboto', sans-serif;
    font-size: 15px;
    font-weight: 700;
    color: #000;
    margin-bottom: 4px;
}

.adi-card-title {
    font-family: 'Roboto', sans-serif;
    font-size: 14px;
    font-weight: 400;
    color: #000;
    line-height: 1.4;
    min-height: 40px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    margin-bottom: 4px;
}

.adi-card-sub {
    font-family: 'Roboto', sans-serif;
    font-size: 12px;
    color: #767677;
    text-transform: capitalize;
    margin-bottom: 12px;
}

.adi-card-btn {
    margin-top: auto;
    width: 100%;
    background-color: #000;
    color: #fff;
    font-family: 'Oswald', sans-serif;
    font-size: 13px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    text-align: center;
    padding: 12px 0;
    text-decoration: none;
    border: 1px solid #000;
    transition: all 0.2s ease-in-out;
}

.adi-card-btn:hover {
    color: #767677;
}
</style>

<div class="adi-section-wrapper">
    <div class="adi-section-header">
        <h2 class="adi-section-title">HÀNG MỚI VỀ</h2>
        <a href="index.php?act=sanpham" class="adi-section-link">XEM TẤT CẢ SẢN PHẨM PHÂN TRANG →</a>
    </div>

    <?php if (!empty($dsSanPham)): ?>
        <div class="adi-grid-4">
            <?php foreach (array_slice($dsSanPham, 0, 4) as $sp): ?>
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
                        <span class="adi-card-badge">MỚI</span>
                        <a href="index.php?act=sanpham_chitiet&id=<?= $sp['product_id'] ?>" style="display: contents;">
                            <img src="<?= htmlspecialchars($imgPath) ?>" alt="<?= htmlspecialchars($sp['ten']) ?>" onerror="this.src='assets/images/hero_paddle.png'">
                        </a>
                    </div>

                    <div class="adi-card-info">
                        <div class="adi-card-price"><?= number_format($sp['gia'], 0, ',', '.') ?>₫</div>
                        <a href="index.php?act=sanpham_chitiet&id=<?= $sp['product_id'] ?>" style="text-decoration: none;">
                            <div class="adi-card-title"><?= htmlspecialchars($sp['ten']) ?></div>
                        </a>
                        <div class="adi-card-sub"><?= htmlspecialchars($sp['ten_danh_muc'] ?? 'Pickleball Store') ?></div>

                        <a href="index.php?act=add_giohang&id=<?= $sp['product_id'] ?>" class="adi-card-btn">THÊM VÀO GIỎ HÀNG</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
