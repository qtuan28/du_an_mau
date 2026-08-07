<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh Sách Sản Phẩm - Pickleball Store</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .catalog-container {
            max-width: 1400px;
            margin: 40px auto;
            padding: 0 24px;
        }

        .catalog-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #f1f5f9;
            padding-bottom: 16px;
        }

        .catalog-title {
            font-family: var(--font-primary, 'Montserrat', sans-serif);
            font-size: 24px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: -0.5px;
        }

        .catalog-filter-bar {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 30px;
            background-color: #f8fafc;
            padding: 16px 20px;
            border-radius: 8px;
        }

        .filter-chip {
            padding: 8px 16px;
            border-radius: 20px;
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            font-size: 13px;
            font-weight: 600;
            color: #334155;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .filter-chip:hover, .filter-chip.active {
            background-color: #0f1115;
            color: #ffffff;
            border-color: #0f1115;
        }

        /* 4 Products per row layout */
        .catalog-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
            margin-bottom: 40px;
        }

        @media (max-width: 1024px) {
            .catalog-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 640px) {
            .catalog-grid {
                grid-template-columns: 1fr;
            }
        }

        .product-card-item {
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .product-card-item:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
        }

        .product-card-img-wrapper {
            position: relative;
            aspect-ratio: 1 / 1;
            background-color: #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 16px;
            overflow: hidden;
        }

        .product-card-img-wrapper img {
            max-height: 85%;
            width: auto;
            object-fit: contain;
            transition: transform 0.3s ease;
        }

        .product-card-item:hover .product-card-img-wrapper img {
            transform: scale(1.06);
        }

        .product-card-info {
            padding: 16px;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .product-card-category {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            color: #1f6b52;
            margin-bottom: 6px;
        }

        .product-card-name {
            font-size: 14px;
            font-weight: 700;
            color: #0f1115;
            margin-bottom: 8px;
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            height: 40px;
        }

        .product-card-price {
            font-family: var(--font-primary, sans-serif);
            font-size: 16px;
            font-weight: 800;
            color: #000000;
            margin-bottom: 14px;
        }

        .product-card-actions {
            margin-top: auto;
            display: flex;
            gap: 8px;
        }

        .btn-view-detail {
            flex: 1;
            text-align: center;
            padding: 9px 12px;
            background-color: #f1f5f9;
            color: #0f1115;
            font-size: 12px;
            font-weight: 700;
            border-radius: 4px;
            text-decoration: none;
            transition: background-color 0.2s ease;
        }

        .btn-view-detail:hover {
            background-color: #e2e8f0;
        }

        .btn-add-cart {
            flex: 1;
            text-align: center;
            padding: 9px 12px;
            background-color: #0f1115;
            color: #ffffff;
            font-size: 12px;
            font-weight: 700;
            border-radius: 4px;
            text-decoration: none;
            transition: background-color 0.2s ease;
        }

        .btn-add-cart:hover {
            background-color: #1f6b52;
        }

        /* Pagination Controls Bar */
        .pagination-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            margin: 40px 0;
        }

        .page-link-btn {
            min-width: 40px;
            height: 40px;
            padding: 0 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #ffffff;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            color: #1e293b;
            font-size: 14px;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .page-link-btn:hover {
            background-color: #f1f5f9;
            border-color: #0f1115;
            color: #0f1115;
        }

        .page-link-btn.active {
            background-color: #0f1115;
            border-color: #0f1115;
            color: #ffffff;
        }

        .page-link-btn.disabled {
            opacity: 0.4;
            pointer-events: none;
        }
    </style>
</head>
<body>

    <!-- Header bar -->
    <?php include 'views/header.php'; ?>

    <div class="catalog-container">
        <div class="catalog-header">
            <div>
                <h1 class="catalog-title">
                    <?= $currentCategory ? htmlspecialchars($currentCategory['name']) : ($keyword !== '' ? 'Kết quả tìm kiếm: "' . htmlspecialchars($keyword) . '"' : 'TẤT CẢ SẢN PHẨM') ?>
                </h1>
                <p style="font-size: 13px; color: #64748b; margin-top: 4px;">
                    Hiển thị <?= count($dsSanPham) ?> / <?= $totalCount ?> sản phẩm (Trang <?= $page ?> / <?= $totalPages ?>)
                </p>
            </div>

            <!-- Top Search Form -->
            <form action="index.php" method="GET" style="display: flex; gap: 8px;">
                <input type="hidden" name="act" value="sanpham">
                <?php if ($categoryId > 0): ?>
                    <input type="hidden" name="id" value="<?= $categoryId ?>">
                <?php endif; ?>
                <input type="text" name="keyword" value="<?= htmlspecialchars($keyword) ?>" placeholder="Tìm sản phẩm..." style="padding: 10px 16px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 13px; outline: none;">
                <button type="submit" style="padding: 10px 18px; background-color: #0f1115; color: #fff; border: none; border-radius: 6px; font-weight: 700; font-size: 13px; cursor: pointer;">Tìm</button>
            </form>
        </div>

        <!-- Filter Chips Bar -->
        <div class="catalog-filter-bar">
            <span style="font-weight: 700; font-size: 13px; color: #0f1115;">Danh mục:</span>
            <a href="index.php?act=sanpham<?= $keyword !== '' ? '&keyword=' . urlencode($keyword) : '' ?>" class="filter-chip <?= $categoryId == 0 ? 'active' : '' ?>">Tất cả sản phẩm</a>
            <?php if (!empty($dsDanhMuc)): ?>
                <?php foreach ($dsDanhMuc as $dm): ?>
                    <a href="index.php?act=sanpham&id=<?= $dm['category_id'] ?><?= $keyword !== '' ? '&keyword=' . urlencode($keyword) : '' ?>" class="filter-chip <?= $categoryId == $dm['category_id'] ? 'active' : '' ?>">
                        <?= htmlspecialchars($dm['name']) ?>
                    </a>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- Product Grid (4 items per row, 16 items per page max) -->
        <?php if (!empty($dsSanPham)): ?>
            <div class="catalog-grid">
                <?php foreach ($dsSanPham as $sp): ?>
                    <?php 
                        $imgPath = !empty($sp['anh']) ? (strpos($sp['anh'], 'assets/') === 0 ? $sp['anh'] : 'assets/images/' . $sp['anh']) : 'assets/images/hero_paddle.png';
                    ?>
                    <div class="product-card-item">
                        <div class="product-card-img-wrapper">
                            <img src="<?= htmlspecialchars($imgPath) ?>" alt="<?= htmlspecialchars($sp['ten']) ?>" onerror="this.src='assets/images/hero_paddle.png'">
                        </div>
                        <div class="product-card-info">
                            <div class="product-card-category"><?= htmlspecialchars($sp['ten_danh_muc'] ?? 'Pickleball') ?></div>
                            <h3 class="product-card-name"><?= htmlspecialchars($sp['ten']) ?></h3>
                            <div class="product-card-price"><?= number_format($sp['gia'], 0, ',', '.') ?> VNĐ</div>
                            <div class="product-card-actions">
                                <a href="index.php?act=sanpham_chitiet&id=<?= $sp['product_id'] ?>" class="btn-view-detail">Chi tiết</a>
                                <a href="index.php?act=add_giohang&id=<?= $sp['product_id'] ?>" class="btn-add-cart">Thêm giỏ</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Pagination Bar -->
            <?php if ($totalPages > 1): ?>
                <?php 
                    // Build base URL for pagination links
                    $queryParams = ['act' => 'sanpham'];
                    if ($categoryId > 0) $queryParams['id'] = $categoryId;
                    if ($keyword !== '') $queryParams['keyword'] = $keyword;
                ?>
                <div class="pagination-wrapper">
                    <!-- First & Previous -->
                    <?php $queryParams['page'] = 1; ?>
                    <a href="index.php?<?= http_build_query($queryParams) ?>" class="page-link-btn <?= $page <= 1 ? 'disabled' : '' ?>" title="Trang đầu">«</a>
                    
                    <?php $queryParams['page'] = max(1, $page - 1); ?>
                    <a href="index.php?<?= http_build_query($queryParams) ?>" class="page-link-btn <?= $page <= 1 ? 'disabled' : '' ?>" title="Trang trước">‹</a>

                    <!-- Page Numbers -->
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <?php $queryParams['page'] = $i; ?>
                        <a href="index.php?<?= http_build_query($queryParams) ?>" class="page-link-btn <?= $page == $i ? 'active' : '' ?>">
                            <?= $i ?>
                        </a>
                    <?php endfor; ?>

                    <!-- Next & Last -->
                    <?php $queryParams['page'] = min($totalPages, $page + 1); ?>
                    <a href="index.php?<?= http_build_query($queryParams) ?>" class="page-link-btn <?= $page >= $totalPages ? 'disabled' : '' ?>" title="Trang sau">›</a>

                    <?php $queryParams['page'] = $totalPages; ?>
                    <a href="index.php?<?= http_build_query($queryParams) ?>" class="page-link-btn <?= $page >= $totalPages ? 'disabled' : '' ?>" title="Trang cuối">»</a>
                </div>
            <?php endif; ?>

        <?php else: ?>
            <div style="text-align: center; padding: 80px 0; background-color: #f8fafc; border-radius: 8px;">
                <svg width="48" height="48" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" style="margin: 0 auto 16px; color: #94a3b8; display: block;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <h3 style="font-size: 18px; font-weight: 700; color: #334155; margin-bottom: 8px;">Không tìm thấy sản phẩm phù hợp</h3>
                <p style="color: #64748b; font-size: 14px; margin-bottom: 20px;">Rất tiếc, chưa có sản phẩm nào thuộc tiêu chí lọc này.</p>
                <a href="index.php?act=sanpham" class="filter-chip active" style="display: inline-block;">Xem tất cả sản phẩm</a>
            </div>
        <?php endif; ?>
    </div>

    <!-- Footer -->
    <?php include 'views/footer.php'; ?>

    <!-- Cart Drawer & Quick View Modal -->
    <?php include 'views/cart_drawer.php'; ?>
    <?php include 'views/quickview_modal.php'; ?>

    <script src="assets/js/main.js"></script>
</body>
</html>
