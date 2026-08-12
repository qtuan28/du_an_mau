<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thống Kê | Bảng Điều Khiển Admin</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                
                <!-- Page Header & Breadcrumb -->
                <div class="adi-content-header">
                    <h1 class="adi-page-title">Báo cáo Thống Kê</h1>
                    <div class="adi-breadcrumb">
                        <a href="index.php?act=admin"><i class="fa-solid fa-house"></i> Trang chủ</a> > 
                        <a href="#">Báo cáo</a> > Thống kê tổng hợp
                    </div>
                </div>

                <div class="adidas-dashboard-grid" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 30px;">
                    <div class="adi-box" style="margin-bottom: 0;">
                        <div style="padding: 20px; text-align: center;">
                            <div style="font-family: 'Oswald', sans-serif; font-size: 16px; font-weight: 700; text-transform: uppercase; color: #777; margin-bottom: 10px;">Sản Phẩm</div>
                            <div style="font-family: 'Oswald', sans-serif; font-size: 32px; font-weight: 700;">
                                <?= number_format($sanPhamStats['tong_san_pham'] ?? 0) ?>
                            </div>
                            <div style="font-size: 12px; color: #777; margin-top: 5px;">Đang kinh doanh</div>
                        </div>
                    </div>
                    <div class="adi-box" style="margin-bottom: 0;">
                        <div style="padding: 20px; text-align: center;">
                            <div style="font-family: 'Oswald', sans-serif; font-size: 16px; font-weight: 700; text-transform: uppercase; color: #777; margin-bottom: 10px;">Đơn Hàng</div>
                            <div style="font-family: 'Oswald', sans-serif; font-size: 32px; font-weight: 700;">
                                <?= number_format($donHangStats['tong_don_hang'] ?? 0) ?>
                            </div>
                            <div style="font-size: 12px; color: #777; margin-top: 5px;">Tổng đơn phát sinh</div>
                        </div>
                    </div>
                    <div class="adi-box" style="margin-bottom: 0;">
                        <div style="padding: 20px; text-align: center;">
                            <div style="font-family: 'Oswald', sans-serif; font-size: 16px; font-weight: 700; text-transform: uppercase; color: #777; margin-bottom: 10px;">Khách Hàng</div>
                            <div style="font-family: 'Oswald', sans-serif; font-size: 32px; font-weight: 700;">
                                <?= number_format($khachHangStats['tong_khach_hang'] ?? 0) ?>
                            </div>
                            <div style="font-size: 12px; color: #777; margin-top: 5px;">Người dùng đã đăng ký</div>
                        </div>
                    </div>
                </div>

                <!-- Card Tổng tồn kho -->
                <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 30px;">
                    <div class="adi-box" style="margin-bottom: 0; border-top: 3px solid #10b981;">
                        <div style="padding: 16px 20px; text-align: center;">
                            <div style="font-size: 12px; font-weight: 700; color: #777; text-transform: uppercase; margin-bottom: 6px;">Tổng tồn kho</div>
                            <div style="font-size: 28px; font-weight: 700; color: #10b981;"><?= number_format($tonKhoStats['tong_ton_kho'] ?? 0) ?></div>
                            <div style="font-size: 11px; color: #777;">sản phẩm</div>
                        </div>
                    </div>
                    <div class="adi-box" style="margin-bottom: 0; border-top: 3px solid #10b981;">
                        <div style="padding: 16px 20px; text-align: center;">
                            <div style="font-size: 12px; font-weight: 700; color: #777; text-transform: uppercase; margin-bottom: 6px;">🟢 Còn hàng</div>
                            <div style="font-size: 28px; font-weight: 700; color: #137333;"><?= $tonKhoStats['con_hang'] ?? 0 ?></div>
                            <div style="font-size: 11px; color: #777;">loại sản phẩm (>0)</div>
                        </div>
                    </div>
                    <div class="adi-box" style="margin-bottom: 0; border-top: 3px solid #f89406;">
                        <div style="padding: 16px 20px; text-align: center;">
                            <div style="font-size: 12px; font-weight: 700; color: #777; text-transform: uppercase; margin-bottom: 6px;">🟡 Sắp hết</div>
                            <div style="font-size: 28px; font-weight: 700; color: #7d5200;"><?= $tonKhoStats['sap_het'] ?? 0 ?></div>
                            <div style="font-size: 11px; color: #777;">loại sản phẩm (1–10)</div>
                        </div>
                    </div>
                    <div class="adi-box" style="margin-bottom: 0; border-top: 3px solid #dc3545;">
                        <div style="padding: 16px 20px; text-align: center;">
                            <div style="font-size: 12px; font-weight: 700; color: #777; text-transform: uppercase; margin-bottom: 6px;">🔴 Hết hàng</div>
                            <div style="font-size: 28px; font-weight: 700; color: #c5221f;"><?= $tonKhoStats['het_hang'] ?? 0 ?></div>
                            <div style="font-size: 11px; color: #777;">loại sản phẩm (= 0)</div>
                        </div>
                    </div>
                </div>

                <!-- Lịch sử đơn hàng chi tiết -->
                <div class="adi-box" style="margin-bottom: 30px;">
                    <div class="adi-box-header">
                        <h3 style="font-family: 'Roboto', sans-serif; font-size: 15px; font-weight: 700; margin: 0;">Lịch Sử Đơn Hàng Gần Đây</h3>
                    </div>
                    <div class="adi-table-responsive" style="max-height: 400px; overflow-y: auto;">
                        <table class="adi-table">
                            <thead style="position: sticky; top: 0; background: #fff; z-index: 1;">
                                <tr>
                                    <th style="width: 120px; text-align: center;">MÃ ĐƠN HÀNG</th>
                                    <th>KHÁCH HÀNG</th>
                                    <th>SẢN PHẨM</th>
                                    <th style="text-align: right;">TỔNG TIỀN</th>
                                    <th style="text-align: center;">TRẠNG THÁI</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($lichSuDonHang)): ?>
                                    <?php foreach ($lichSuDonHang as $don): ?>
                                        <tr>
                                            <td style="text-align: center; font-weight: bold; color: #007bff;"><?= htmlspecialchars($don['ma_don_hang']) ?></td>
                                            <td>
                                                <strong><?= htmlspecialchars($don['ho_ten']) ?></strong><br>
                                                <span style="font-size: 11px; color: #777;"><?= date('d/m/Y H:i', strtotime($don['ngay_dat'])) ?></span>
                                            </td>
                                            <td style="font-size: 12px; line-height: 1.4;"><?= $don['san_pham'] ?></td>
                                            <td style="text-align: right; font-weight: bold; color: #10b981;"><?= number_format($don['tong_tien'], 0, ',', '.') ?>đ</td>
                                            <td style="text-align: center;">
                                                <?php
                                                    $badgeBg = '#f8f9fa'; $badgeColor = '#333';
                                                    if ($don['trang_thai'] == 'Đã giao') { $badgeBg = '#e6f4ea'; $badgeColor = '#137333'; }
                                                    elseif ($don['trang_thai'] == 'Đang xử lý') { $badgeBg = '#fff8e1'; $badgeColor = '#7d5200'; }
                                                    elseif ($don['trang_thai'] == 'Đã hủy') { $badgeBg = '#fce8e6'; $badgeColor = '#c5221f'; }
                                                ?>
                                                <span style="background: <?= $badgeBg ?>; color: <?= $badgeColor ?>; padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: bold;">
                                                    <?= $don['trang_thai'] ?>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr><td colspan="5" style="text-align: center;">Chưa có đơn hàng nào.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Bảng tồn kho chi tiết -->
                <div class="adi-box" style="margin-top: 0;">
                    <div class="adi-box-header">
                        <h3 style="font-family: 'Roboto', sans-serif; font-size: 15px; font-weight: 700; margin: 0;">📦 Tồn Kho Theo Sản Phẩm</h3>
                    </div>
                    <div class="adi-table-responsive">
                        <table class="adi-table">
                            <thead>
                                <tr>
                                    <th style="width: 60px; text-align: center;">MÃ SP</th>
                                    <th>TÊN SẢN PHẨM</th>
                                    <th style="text-align: center; width: 120px;">TỒN KHO</th>
                                    <th style="text-align: center;">TRẠNG THÁI</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php if (!empty($tonKhoStats['ds_san_pham'])): ?>
                                <?php foreach ($tonKhoStats['ds_san_pham'] as $sp): ?>
                                    <?php
                                        $qty = (int)$sp['tong_ton_kho'];
                                        if ($qty > 10) { $bg='#e6f4ea'; $cl='#137333'; $label='🟢 Còn hàng'; }
                                        elseif ($qty > 0) { $bg='#fff8e1'; $cl='#7d5200'; $label='🟡 Sắp hết hàng'; }
                                        else { $bg='#fce8e6'; $cl='#c5221f'; $label='🔴 Hết hàng'; }
                                    ?>
                                    <tr style="background: <?= $qty == 0 ? '#fef2f2' : ($qty <= 10 ? '#fffbf0' : 'transparent') ?>;">
                                        <td style="text-align: center; font-weight: bold;"><?= $sp['ma_sp'] ?></td>
                                        <td><strong><?= htmlspecialchars($sp['ten']) ?></strong></td>
                                        <td style="text-align: center;">
                                            <span style="font-family: monospace; font-size: 20px; font-weight: 700; color: <?= $cl ?>;"><?= $qty ?></span>
                                        </td>
                                        <td style="text-align: center;">
                                            <span style="background: <?= $bg ?>; color: <?= $cl ?>; padding: 4px 12px; font-weight: 700; font-size: 11px;">
                                                <?= $label ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="4" style="text-align: center; padding: 20px;">Chưa có dữ liệu tồn kho.</td></tr>
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
