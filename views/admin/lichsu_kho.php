<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lịch sử tồn kho | Bảng Điều Khiển Admin</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="adi-admin-wrapper">
        
        <!-- Sidebar -->
        <?php include 'views/admin_sidebar.php'; ?>

        <!-- Right Main Panel -->
        <div class="adi-main-panel">
            <!-- Top Navbar -->
            <header class="adi-main-header">
                <div class="adi-header-left">
                    <a href="index.php" class="adi-header-link"><i class="fa-solid fa-globe"></i> Xem website</a>
                </div>
                <div class="adi-header-right">
                    <div class="adi-header-user">
                        <i class="fa-solid fa-circle-user"></i>
                        <?= htmlspecialchars($_SESSION['user']['username'] ?? 'Admin') ?>
                    </div>
                    <a href="index.php?act=logout" class="adi-header-link" style="color: #dc3545;" title="Đăng xuất"><i class="fa-solid fa-power-off"></i></a>
                </div>
            </header>

            <!-- Page Content -->
            <div class="adi-content-wrapper">
                
                <div class="adi-content-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
                    <div>
                        <h1 class="adi-page-title">LỊCH SỬ NHẬP XUẤT KHO</h1>
                        <div class="adi-breadcrumb">
                            <a href="index.php?act=admin"><i class="fa-solid fa-house"></i> Trang chủ</a> > 
                            <a href="index.php?act=admin_sanpham">Quản lý Sản phẩm</a> > Lịch sử kho
                        </div>
                    </div>
                    <a href="index.php?act=admin_sanpham" class="adi-btn-secondary">
                        <i class="fa-solid fa-arrow-left"></i> Quay lại
                    </a>
                </div>

                <div class="adi-box" style="margin-bottom: 30px;">
                    <div class="adi-box-header">
                        <h3 style="font-family: 'Oswald', sans-serif; font-size: 16px; font-weight: 700; text-transform: uppercase; margin: 0;">
                            Sản phẩm: <?= htmlspecialchars($sanPham['ten']) ?> (<?= htmlspecialchars($sanPham['ma_sp'] ?? $sanPham['product_id']) ?>)
                        </h3>
                    </div>
                    <div style="padding: 20px;">
                        <p><strong>Tồn kho hiện tại:</strong> <span style="font-family: monospace; font-size: 16px; font-weight: bold; color: #10b981;"><?= $sanPham['so_luong'] ?? 0 ?></span></p>
                    </div>
                </div>

                <div class="adi-box">
                    <div class="adi-table-responsive">
                        <table class="adi-table">
                            <thead>
                                <tr>
                                    <th style="width: 150px;">THỜI GIAN</th>
                                    <th style="text-align: center;">LOẠI GIAO DỊCH</th>
                                    <th style="text-align: center;">SỐ LƯỢNG</th>
                                    <th>GHI CHÚ / MÃ ĐƠN</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($lichSu)): ?>
                                    <?php foreach ($lichSu as $ls): ?>
                                        <tr>
                                            <td><?= date('d/m/Y H:i:s', strtotime($ls['ngay_thay_doi'])) ?></td>
                                            <td style="text-align: center;">
                                                <?php if ($ls['loai_thay_doi'] == 'nhap_hang'): ?>
                                                    <span style="background: #e6f4ea; color: #137333; padding: 4px 8px; border-radius: 4px; font-weight: bold; font-size: 11px;">NHẬP KHO</span>
                                                <?php elseif ($ls['loai_thay_doi'] == 'ban_hang'): ?>
                                                    <span style="background: #fff8e1; color: #7d5200; padding: 4px 8px; border-radius: 4px; font-weight: bold; font-size: 11px;">BÁN HÀNG</span>
                                                <?php elseif ($ls['loai_thay_doi'] == 'loi'): ?>
                                                    <span style="background: #fce8e6; color: #c5221f; padding: 4px 8px; border-radius: 4px; font-weight: bold; font-size: 11px;">HÀNG LỖI</span>
                                                <?php else: ?>
                                                    <span style="background: #f8f9fa; color: #333; padding: 4px 8px; border-radius: 4px; font-weight: bold; font-size: 11px; text-transform: uppercase;"><?= htmlspecialchars($ls['loai_thay_doi']) ?></span>
                                                <?php endif; ?>
                                            </td>
                                            <td style="text-align: center;">
                                                <span style="font-family: monospace; font-size: 16px; font-weight: bold; color: <?= $ls['so_luong_thay_doi'] > 0 ? '#10b981' : '#dc3545' ?>;">
                                                    <?= $ls['so_luong_thay_doi'] > 0 ? '+' : '' ?><?= $ls['so_luong_thay_doi'] ?>
                                                </span>
                                            </td>
                                            <td><?= htmlspecialchars($ls['ghi_chu'] ?? '') ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" style="text-align: center; padding: 20px;">Chưa có lịch sử giao dịch nào cho sản phẩm này.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</body>
</html>
