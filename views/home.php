<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pickleball Store – Cửa Hàng Vợt, Giày & Phụ Kiện Pickleball Chính Hãng</title>
  <meta name="description" content="Khám phá bộ sưu tập Pickleball mới nhất mùa giải 26/27. Cung cấp vợt pickleball, giày thi đấu, bóng chuẩn quốc tế và trang phục thể thao chính hãng.">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

  <!-- Header Section -->
  <?php include __DIR__ . '/header.php'; ?>

  <!-- Main Content -->
  <main>
    <!-- Hero Section -->
    <?php include __DIR__ . '/hero.php'; ?>

    <!-- Section 1: Sản Phẩm Mới -->
    <?php include __DIR__ . '/products_new.php'; ?>

    <!-- Banner Break: Kiến Tạo Lối Chơi -->
    <?php include __DIR__ . '/banner_playstyle.php'; ?>

    <!-- Section 2: Bộ Sưu Tập PPA Tour 26/27 -->
    <?php include __DIR__ . '/products_ppa.php'; ?>

    <!-- Section 3: Shop The Look -->
    <?php include __DIR__ . '/shop_look.php'; ?>

    <!-- Section 4: What's Hot -->
    <?php include __DIR__ . '/whats_hot.php'; ?>

    <!-- Section 5: Brand Story (SEO Paragraphs) -->
    <?php include __DIR__ . '/brand_story.php'; ?>

    <!-- Section 6: Newsletter Bar -->
    <?php include __DIR__ . '/newsletter.php'; ?>
  </main>

  <!-- Footer Section -->
  <?php include __DIR__ . '/footer.php'; ?>

  <!-- Slide Cart Drawer -->
  <?php include __DIR__ . '/cart_drawer.php'; ?>

  <!-- Quick View Modal -->
  <?php include __DIR__ . '/quickview_modal.php'; ?>

  <!-- JavaScript App Logic -->
  <script src="assets/js/main.js"></script>
</body>
</html>
