<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Chi tiết sản phẩm</title>
</head>
<body>

<h2>CHI TIẾT SẢN PHẨM</h2>

<?php if($sp){ ?>

<p><b>ID:</b> <?= $sp['product_id'] ?></p>

<p><b>Tên:</b> <?= $sp['ten'] ?></p>

<p><b>Giá:</b> <?= number_format($sp['gia']) ?> VNĐ</p>

<p><b>Ảnh:</b></p>

<img src="images/<?= $sp['anh'] ?>" width="200">

<br><br>

<a href="index.php?act=add_giohang&id=<?= $sp['product_id'] ?>">
    Thêm vào giỏ hàng
</a>

<?php }else{ ?>

<p>Không có sản phẩm.</p>

<?php } ?>

<br><br>
<a href="index.php">Quay lại</a>

</body>
</html>