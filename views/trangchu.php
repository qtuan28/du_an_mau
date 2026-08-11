<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pickleball Store | adidas Việt Nam</title>
  <meta name="description" content="Khám phá bộ sưu tập Pickleball mới nhất mùa giải 26/27. Cung cấp vợt pickleball, giày thi đấu, bóng chuẩn quốc tế và trang phục thể thao chính hãng.">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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

    <!-- Banner Break: Kiến Tạo Lối Chơi (Single Full-Width Banner) -->
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
