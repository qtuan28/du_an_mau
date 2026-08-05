<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Giỏ Hàng</title>
</head>
<style>
    table {
        border-collapse: collapse;
        width: 100%;
    }
    th, td {
        padding: 8px 12px;
        text-align: center;
    }
</style>
<body>
    <h2>GIỎ HÀNG CỦA BẠN</h2>

    <?php if (!empty($gioHang)): ?>
        <form action="index.php?act=update_giohang" method="POST">
            <table border="1">
                <tr>
                    <th>Hình ảnh</th>
                    <th>Tên sản phẩm</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Thành tiền</th>
                    <th>Chức năng</th>
                </tr>
                <?php 
                $tongTien = 0;
                foreach ($gioHang as $item): 
                    $thanhTien = $item['gia'] * $item['so_luong'];
                    $tongTien += $thanhTien;
                ?>
                <tr>
                    <td>
                        <?php if (!empty($item['anh'])): ?>
                            <img src="assets/images/<?= htmlspecialchars($item['anh']) ?>" width="60" alt="<?= htmlspecialchars($item['ten']) ?>">
                        <?php else: ?>
                            Không có ảnh
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($item['ten']) ?></td>
                    <td><?= number_format($item['gia'], 0, ',', '.') ?> VNĐ</td>
                    <td>
                        <input type="number" name="so_luong[<?= $item['product_id'] ?>]" value="<?= $item['so_luong'] ?>" min="1" style="width: 50px; text-align: center;">
                    </td>
                    <td><?= number_format($thanhTien, 0, ',', '.') ?> VNĐ</td>
                    <td>
                        <a href="index.php?act=delete_giohang&id=<?= $item['product_id'] ?>" onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này?')">Xóa</a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="4" align="right"><strong>TỔNG TIỀN:</strong></td>
                    <td colspan="2"><strong style="color: red; font-size: 18px;"><?= number_format($tongTien, 0, ',', '.') ?> VNĐ</strong></td>
                </tr>
            </table>

            <br>
            <button type="submit">Cập nhật số lượng</button>
            <a href="index.php?act=delete_giohang&id=all" onclick="return confirm('Xóa toàn bộ giỏ hàng?')">Xóa tất cả</a>
        </form>
    <?php else: ?>
        <p style="color: red;">Chưa có sản phẩm nào trong giỏ hàng.</p>
    <?php endif; ?>

    <br><hr>
    <div>
        <a href="index.php?act=thanhtoan">👉 TIẾN HÀNH THANH TOÁN</a> |
        <a href="index.php?act=index">Tiếp tục mua hàng</a>
    </div>
</body>
</html>
