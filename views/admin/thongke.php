<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thống Kê | Bảng Điều Khiển Admin</title>
    <link rel="stylesheet" href="assets/css/admin.css">
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

                <div class="adidas-dashboard-grid" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 30px;">
                    <div class="adi-box" style="margin-bottom: 0;">
                        <div style="padding: 20px; text-align: center;">
                            <div style="font-family: 'Oswald', sans-serif; font-size: 16px; font-weight: 700; text-transform: uppercase; color: #777; margin-bottom: 10px;">Doanh Thu</div>
                            <div style="font-family: 'Oswald', sans-serif; font-size: 32px; font-weight: 700; color: #10b981;">
                                <?= number_format($doanhThuStats['tong_doanh_thu'] ?? 0, 0, ',', '.') ?>đ
                            </div>
                            <div style="font-size: 12px; color: #777; margin-top: 5px;">Tổng doanh thu hệ thống</div>
                        </div>
                    </div>
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

                <div style="display: flex; gap: 20px;">
                    <!-- Doanh thu chi tiết -->
                    <div class="adi-box" style="flex: 2;">
                        <div class="adi-box-header">
                            <h3 style="font-family: 'Roboto', sans-serif; font-size: 15px; font-weight: 700; margin: 0;">Doanh Thu Theo Sản Phẩm</h3>
                            <button class="adi-btn-outline" style="padding: 4px 8px; font-size: 11px;"><i class="fa-solid fa-download"></i> Xuất Báo Cáo</button>
                        </div>
                        <div class="adi-table-responsive">
                            <table class="adi-table">
                                <thead>
                                    <tr>
                                        <th style="width: 80px; text-align: center;">MÃ SP</th>
                                        <th>TÊN SẢN PHẨM</th>
                                        <th style="text-align: center;">SỐ LƯỢNG BÁN</th>
                                        <th style="text-align: right;">DOANH THU</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($doanhThuStats['theo_san_pham'])): ?>
                                        <?php foreach (array_slice($doanhThuStats['theo_san_pham'], 0, 5) as $sp): ?>
                                            <tr>
                                                <td style="text-align: center; font-weight: bold;"><?= $sp['product_id'] ?></td>
                                                <td><strong><?= htmlspecialchars($sp['ten']) ?></strong></td>
                                                <td style="text-align: center; font-weight: bold;"><?= number_format($sp['tong_so_luong']) ?></td>
                                                <td style="text-align: right; font-weight: bold; color: #10b981;"><?= number_format($sp['tong_doanh_thu'], 0, ',', '.') ?>đ</td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr><td colspan="4" style="text-align: center;">Chưa có dữ liệu giao dịch.</td></tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Chart Box -->
                    <div class="adi-box" style="flex: 1;">
                        <div class="adi-box-header">
                            <h3 style="font-family: 'Roboto', sans-serif; font-size: 15px; font-weight: 700; margin: 0;">Trạng Thái Đơn Hàng</h3>
                        </div>
                        <div style="padding: 20px; text-align: center;">
                            <div style="height: 250px; position: relative;">
                                <canvas id="orderChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const ctx = document.getElementById('orderChart').getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Đang xử lý', 'Đã giao', 'Đã hủy'],
                    datasets: [{
                        data: [
                            <?= (int)($donHangStats['dang_xu_ly'] ?? 0) ?>,
                            <?= (int)($donHangStats['da_giao'] ?? 0) ?>,
                            <?= (int)($donHangStats['da_huy'] ?? 0) ?>
                        ],
                        backgroundColor: ['#f89406', '#10b981', '#dc3545'],
                        borderWidth: 2,
                        borderColor: '#fff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { 
                            position: 'bottom',
                            labels: {
                                font: {
                                    family: "'Roboto', sans-serif"
                                }
                            }
                        }
                    },
                    cutout: '65%'
                }
            });
        });
    </script>
</body>
</html>
