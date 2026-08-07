<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pickleball Store – Cửa Hàng Vợt, Giày & Phụ Kiện Pickleball Chính Hãng</title>
  <meta name="description" content="Khám phá bộ sưu tập Pickleball mới nhất mùa giải 26/27. Cung cấp vợt pickleball, giày thi đấu, bóng chuẩn quốc tế và trang phục thể thao chính hãng.">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="assets/css/style.css">
  <style>
    .home-catalog-link-bar {
      margin: 40px auto;
      text-align: center;
    }
    .btn-view-catalog {
      display: inline-flex;
      align-items: center;
      gap: 10px;
      background-color: #0f1115;
      color: #ffffff;
      font-family: var(--font-primary, sans-serif);
      font-weight: 800;
      font-size: 14px;
      padding: 14px 32px;
      border-radius: 4px;
      text-decoration: none;
      transition: background-color 0.25s ease;
    }
    .btn-view-catalog:hover {
      background-color: #1f6b52;
    }
  </style>
</head>
<body>

  <!-- Header Section -->
  <?php include 'views/header.php'; ?>

  <!-- Main Content -->
  <main>
    <!-- Hero Section -->
    <?php include 'views/hero.php'; ?>

    <!-- Section 1: Sản Phẩm Mới -->
    <?php include 'views/products_new.php'; ?>

    <!-- Xem Tất Cả Sản Phẩm Callout Button -->
    <div class="container home-catalog-link-bar">
      <a href="index.php?act=sanpham" class="btn-view-catalog">
        XEM TẤT CẢ SẢN PHẨM PHÂN TRANG (16 SẢN PHẨM / TRANG)
        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
        </svg>
      </a>
    </div>

    <!-- Banner Break: Kiến Tạo Lối Chơi -->
    <?php include 'views/banner_playstyle.php'; ?>

    <!-- Section 2: Bộ Sưu Tập PPA Tour 26/27 -->
    <?php include 'views/products_ppa.php'; ?>

    <!-- Section 3: Shop The Look -->
    <?php include 'views/shop_look.php'; ?>

    <!-- Section 4: What's Hot -->
    <?php include 'views/whats_hot.php'; ?>

    <!-- Section 5: Brand Story (SEO Paragraphs) -->
    <?php include 'views/brand_story.php'; ?>

    <!-- Section 6: Newsletter Bar -->
    <?php include 'views/newsletter.php'; ?>
  </main>

  <!-- Footer Section -->
  <?php include 'views/footer.php'; ?>

  <!-- Slide Cart Drawer -->
  <?php include 'views/cart_drawer.php'; ?>

  <!-- Quick View Modal -->
  <?php include 'views/quickview_modal.php'; ?>

  <!-- JavaScript App Logic -->
  <script src="assets/js/main.js"></script>
</body>
</html>
