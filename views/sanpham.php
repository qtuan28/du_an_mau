<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh Sách Sản Phẩm | adidas Việt Nam</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .adi-plp-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px 40px 80px;
        }

        .adi-plp-breadcrumb {
            font-family: 'Roboto', sans-serif;
            font-size: 12px;
            font-weight: 500;
            text-transform: uppercase;
            color: #767677;
            margin-bottom: 20px;
        }

        .adi-plp-breadcrumb a {
            color: #000;
            text-decoration: underline;
        }

        .adi-plp-title-row {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            margin-bottom: 30px;
            border-bottom: 1px solid #ebedee;
            padding-bottom: 20px;
        }

        .adi-plp-title {
            font-family: 'Oswald', sans-serif;
            font-size: 38px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: -0.5px;
            margin: 0;
        }

        .adi-plp-count {
            font-family: 'Roboto', sans-serif;
            font-size: 16px;
            color: #767677;
            font-weight: 400;
        }

        .adi-plp-layout {
            display: grid;
            grid-template-columns: 260px 1fr;
            gap: 32px;
        }

        .adi-plp-sidebar {
            width: 100%;
        }

        .adi-filter-group {
            border-bottom: 1px solid #ebedee;
            padding: 20px 0;
        }

        .adi-filter-title {
            font-family: 'Oswald', sans-serif;
            font-size: 16px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .adi-filter-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .adi-filter-item {
            margin-bottom: 10px;
        }

        .adi-filter-item a {
            font-family: 'Roboto', sans-serif;
            font-size: 14px;
            color: #363636;
            text-decoration: none;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: color 0.2s;
        }

        .adi-filter-item a:hover, .adi-filter-item.active a {
            color: #000;
            font-weight: 700;
            text-decoration: underline;
        }

        .adi-plp-content {
            min-width: 0;
        }

        .adi-plp-toolbar {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            margin-bottom: 24px;
        }

        .adi-sort-select {
            font-family: 'Roboto', sans-serif;
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            padding: 10px 16px;
            border: 1px solid #000;
            background: #fff;
            outline: none;
            cursor: pointer;
        }

        .adi-grid-3 {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            align-items: stretch;
            margin-bottom: 50px;
        }

        @media (max-width: 1024px) {
            .adi-grid-3 {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 820px) {
            .adi-plp-layout {
                grid-template-columns: 1fr;
            }
            .adi-grid-3 {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 520px) {
            .adi-grid-3 {
                grid-template-columns: 1fr;
            }
        }

        .adi-pagination-wrap {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            margin-top: 40px;
        }

        .adi-card {
            position: relative;
            background-color: #fff;
            text-decoration: none;
            color: #000;
            display: flex;
            flex-direction: column;
            height: 100%;
            border: 1px solid #ebedee;
            transition: all 0.2s ease-in-out;
        }

        .adi-card:hover {
            border-color: #000;
            box-shadow: 0 4px 16px rgba(0,0,0,0.06);
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
</head>
<body>

<?php
if (!function_exists('buildPlpUrl')) {
    function buildPlpUrl($overrides = []) {
        $params = $_GET;
        $params['act'] = 'sanpham';
        foreach ($overrides as $k => $v) {
            if ($v === null || $v === '') {
                unset($params[$k]);
            } else {
                $params[$k] = $v;
            }
        }
        if (isset($overrides['id']) || isset($overrides['keyword']) || isset($overrides['price_range'])) {
            $params['page'] = 1;
        }
        return 'index.php?' . http_build_query($params);
    }
}
?>

    <!-- Header bar -->
    <?php include 'views/header.php'; ?>

    <div class="adi-plp-container">
        <!-- Breadcrumb -->
        <div class="adi-plp-breadcrumb">
            <a href="index.php">TRANG CHỦ</a> / <span><?= $currentCategory ? mb_strtoupper($currentCategory['name']) : 'TẤT CẢ SẢN PHẨM' ?></span>
        </div>

        <!-- Title Row -->
        <div class="adi-plp-title-row">
            <h1 class="adi-plp-title">
                <?= $currentCategory ? htmlspecialchars($currentCategory['name']) : ($keyword !== '' ? 'KẾT QUẢ: "' . htmlspecialchars($keyword) . '"' : 'TẤT CẢ SẢN PHẨM') ?>
                <span class="adi-plp-count">[<?= $totalCount ?>]</span>
            </h1>

            <div class="adi-plp-toolbar">
                <select class="adi-sort-select" onchange="location = this.value;">
                    <option value="<?= buildPlpUrl(['sort' => 'newest']) ?>" <?= $sort === 'newest' ? 'selected' : '' ?>>SẮP XẾP THEO: MỚI NHẤT</option>
                    <option value="<?= buildPlpUrl(['sort' => 'price_asc']) ?>" <?= $sort === 'price_asc' ? 'selected' : '' ?>>GIÁ: TỪ THẤP ĐẾN CAO</option>
                    <option value="<?= buildPlpUrl(['sort' => 'price_desc']) ?>" <?= $sort === 'price_desc' ? 'selected' : '' ?>>GIÁ: TỪ CAO ĐẾN THẤP</option>
                </select>
            </div>
        </div>

        <!-- Layout Sidebar + Content -->
        <div class="adi-plp-layout">
            <!-- Left Filter Sidebar -->
            <aside class="adi-plp-sidebar">
                <!-- Search Box Filter -->
                <div class="adi-filter-group" style="padding-top: 0;">
                    <div class="adi-filter-title">TÌM KIẾM SẢN PHẨM</div>
                    <form action="index.php" method="GET" style="display: flex; gap: 8px;">
                        <input type="hidden" name="act" value="sanpham">
                        <?php if ($categoryId > 0): ?>
                            <input type="hidden" name="id" value="<?= $categoryId ?>">
                        <?php endif; ?>
                        <?php if (!empty($priceRange)): ?>
                            <input type="hidden" name="price_range" value="<?= htmlspecialchars($priceRange) ?>">
                        <?php endif; ?>
                        <?php if (!empty($sort)): ?>
                            <input type="hidden" name="sort" value="<?= htmlspecialchars($sort) ?>">
                        <?php endif; ?>
                        <input type="text" name="keyword" value="<?= htmlspecialchars($keyword) ?>" placeholder="Nhập tên sản phẩm..." style="width: 100%; padding: 10px; border: 1px solid #ebedee; font-family: 'Roboto', sans-serif; font-size: 13px; outline: none;">
                        <button type="submit" style="padding: 10px 14px; background: #000; color: #fff; border: none; cursor: pointer;"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </form>
                </div>

                <!-- Categories Filter -->
                <div class="adi-filter-group">
                    <div class="adi-filter-title">DANH MỤC <i class="fa-solid fa-minus" style="font-size: 12px;"></i></div>
                    <ul class="adi-filter-list">
                        <li class="adi-filter-item <?= $categoryId == 0 ? 'active' : '' ?>">
                            <a href="<?= buildPlpUrl(['id' => null]) ?>">Tất cả sản phẩm</a>
                        </li>
                        <?php if (!empty($dsDanhMuc)): ?>
                            <?php foreach ($dsDanhMuc as $dm): ?>
                                <li class="adi-filter-item <?= $categoryId == $dm['category_id'] ? 'active' : '' ?>">
                                    <a href="<?= buildPlpUrl(['id' => $dm['category_id']]) ?>">
                                        <?= htmlspecialchars($dm['name']) ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                </div>

                <!-- Price Filter -->
                <div class="adi-filter-group">
                    <div class="adi-filter-title">MỨC GIÁ <i class="fa-solid fa-minus" style="font-size: 12px;"></i></div>
                    <ul class="adi-filter-list">
                        <li class="adi-filter-item <?= empty($priceRange) ? 'active' : '' ?>">
                            <a href="<?= buildPlpUrl(['price_range' => null]) ?>">Tất cả mức giá</a>
                        </li>
                        <li class="adi-filter-item <?= $priceRange === 'under_1m' ? 'active' : '' ?>">
                            <a href="<?= buildPlpUrl(['price_range' => 'under_1m']) ?>">Dưới 1.000.000₫</a>
                        </li>
                        <li class="adi-filter-item <?= $priceRange === '1m_3m' ? 'active' : '' ?>">
                            <a href="<?= buildPlpUrl(['price_range' => '1m_3m']) ?>">1.000.000₫ - 3.000.000₫</a>
                        </li>
                        <li class="adi-filter-item <?= $priceRange === 'above_3m' ? 'active' : '' ?>">
                            <a href="<?= buildPlpUrl(['price_range' => 'above_3m']) ?>">Trên 3.000.000₫</a>
                        </li>
                    </ul>
                </div>
            </aside>

            <!-- Main Product Grid Content -->
            <main class="adi-plp-content">
                <?php if (!empty($dsSanPham)): ?>
                    <div class="adi-grid-3">
                        <?php foreach ($dsSanPham as $sp): ?>
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
                                    <div class="adi-card-sub"><?= htmlspecialchars($sp['ten_danh_muc'] ?? 'Pickleball Store') ?></div>

                                    <a href="index.php?act=add_giohang&id=<?= $sp['product_id'] ?>" class="adi-card-btn">THÊM VÀO GIỎ HÀNG</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Pagination -->
                    <?php if ($totalPages > 1): ?>
                        <div class="adi-pagination-wrap">
                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                <a href="<?= buildPlpUrl(['page' => $i]) ?>" class="adi-page-btn <?= $page == $i ? 'active' : '' ?>">
                                    <?= $i ?>
                                </a>
                            <?php endfor; ?>
                        </div>
                    <?php endif; ?>

                <?php else: ?>
                    <div style="text-align: center; padding: 100px 0; background-color: #ebedee;">
                        <h2 style="font-family: 'Oswald', sans-serif; font-size: 28px; text-transform: uppercase; margin-bottom: 12px;">KHÔNG TÌM THẤY SẢN PHẨM PHÙ HỢP</h2>
                        <p style="color: #767677; margin-bottom: 24px;">Rất tiếc, chưa có sản phẩm nào thuộc bộ lọc này.</p>
                        <a href="index.php?act=sanpham" class="adi-btn-sharp">XEM TẤT CẢ SẢN PHẨM →</a>
                    </div>
                <?php endif; ?>
            </main>
        </div>
    </div>

    <!-- Footer -->
    <?php include 'views/footer.php'; ?>

    <script src="<?= BASE_URL ?>/assets/js/main.js"></script>
</body>
</html>
