<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thống Kê Số Liệu - Admin Management</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Admin External CSS -->
    <link rel="stylesheet" href="assets/css/admin.css">

    <style>
        :root {
            --admin-font: 'Plus Jakarta Sans', sans-serif;
            --admin-font-heading: 'Outfit', sans-serif;
            --bg-primary: #f8fafc;
            --bg-surface: #ffffff;
            --primary-50: #eff6ff;
            --primary-100: #dbeafe;
            --primary-600: #2563eb;
            --accent-purple: #7c3aed;
            --accent-purple-light: #f3e8ff;
            --success-50: #f0fdf4;
            --success-600: #16a34a;
            --danger-50: #fef2f2;
            --danger-600: #dc2626;
            --warning-50: #fffbeb;
            --warning-600: #d97706;
            --text-dark: #0f172a;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
            --radius-md: 12px;
            --radius-lg: 16px;
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.05);
            --shadow-md: 0 4px 6px -1px rgba(0,0,0,0.07);
        }

        body {
            font-family: var(--admin-font);
            background-color: var(--bg-primary);
            color: var(--text-dark);
            margin: 0;
            padding: 0;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 28px;
        }

        .stat-card {
            background: var(--bg-surface);
            border-radius: var(--radius-lg);
            padding: 22px 24px;
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-sm);
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: all 0.25s ease;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-md);
        }

        .stat-info h4 {
            font-size: 0.875rem;
            color: var(--text-muted);
            margin: 0 0 6px 0;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-info .stat-value {
            font-family: var(--admin-font-heading);
            font-size: 1.65rem;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0;
        }

        .stat-info .stat-subtext {
            font-size: 0.8rem;
            color: var(--text-muted);
            margin-top: 4px;
        }

        .stat-icon {
            width: 54px;
            height: 54px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .icon-blue { background: #eff6ff; color: #2563eb; }
        .icon-green { background: #f0fdf4; color: #16a34a; }
        .icon-purple { background: #f3e8ff; color: #7c3aed; }
        .icon-amber { background: #fffbeb; color: #d97706; }

        .dashboard-row {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 24px;
            margin-bottom: 28px;
        }

        @media (max-width: 1024px) {
            .dashboard-row {
                grid-template-columns: 1fr;
            }
        }

        .card-panel {
            background: var(--bg-surface);
            border-radius: var(--radius-lg);
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-sm);
            padding: 24px;
            margin-bottom: 28px;
        }

        .card-panel-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
            padding-bottom: 14px;
            border-bottom: 1px solid var(--border-color);
        }

        .card-panel-title {
            font-family: var(--admin-font-heading);
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--text-dark);
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 0;
        }

        .card-panel-title i {
            color: var(--primary-600);
        }

        .revenue-time-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 20px;
        }

        @media (max-width: 768px) {
            .revenue-time-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .time-box {
            background: #f8fafc;
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 16px;
            text-align: center;
        }

        .time-box span {
            display: block;
            font-size: 0.8rem;
            color: var(--text-muted);
            font-weight: 600;
            margin-bottom: 4px;
        }

        .time-box strong {
            font-family: var(--admin-font-heading);
            font-size: 1.15rem;
            color: var(--primary-600);
        }

        .custom-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.9rem;
        }

        .custom-table th {
            background: #f1f5f9;
            color: #475569;
            font-weight: 700;
            text-align: left;
            padding: 12px 16px;
            border-bottom: 2px solid var(--border-color);
        }

        .custom-table td {
            padding: 14px 16px;
            border-bottom: 1px solid var(--border-color);
            color: var(--text-dark);
            vertical-align: middle;
        }

        .custom-table tr:hover {
            background-color: #f8fafc;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .badge-success { background: #dcfce7; color: #15803d; }
        .badge-warning { background: #fef3c7; color: #b45309; }
        .badge-danger { background: #fee2e2; color: #b91c1c; }
        .badge-primary { background: #dbeafe; color: #1d4ed8; }

        .product-thumb {
            width: 42px;
            height: 42px;
            border-radius: 8px;
            object-fit: cover;
            border: 1px solid var(--border-color);
        }
    </style>
</head>
<body>
    <div class="admin-layout">
        <!-- Top Navbar -->
        <header class="admin-navbar">
            <div class="admin-brand">
                <i class="fa-solid fa-chart-line"></i>
                <span>Pickleball Admin - Thống Kê</span>
            </div>
            <div class="admin-nav-links">
                <a href="index.php?act=admin" class="nav-item-btn">
                    <i class="fa-solid fa-gauge-high"></i> Dashboard Quản trị
                </a>
                <a href="index.php?act=logout" class="nav-item-btn" style="color: var(--danger-600);">
                    <i class="fa-solid fa-right-from-bracket"></i> Đăng xuất
                </a>
            </div>
        </header>

        <!-- Main Container -->
        <main class="admin-container" style="max-width: 1320px; margin: 0 auto; padding: 28px 20px;">
            
            <!-- Page Header -->
            <div class="page-header" style="margin-bottom: 24px;">
                <div class="page-title-group">
                    <h1 style="font-family: var(--admin-font-heading); font-size: 1.75rem; font-weight: 700; margin: 0 0 6px 0;">
                        <i class="fa-solid fa-chart-pie" style="color: var(--warning-600); margin-right: 8px;"></i>
                        Báo Cáo & Thống Kê Số Liệu Hệ Thống
                    </h1>
                    <p style="color: var(--text-muted); margin: 0;">Tổng hợp doanh thu, sản phẩm, trạng thái đơn hàng và phân tích người dùng.</p>
                </div>
            </div>

            <!-- Top Metric Cards (Overview) -->
            <div class="stats-grid">
                <!-- 1. Revenue -->
                <div class="stat-card">
                    <div class="stat-info">
                        <h4>Tổng Doanh Thu</h4>
                        <div class="stat-value" style="color: #16a34a;"><?= number_format($doanhThuStats['tong_doanh_thu'], 0, ',', '.') ?> đ</div>
                        <div class="stat-subtext">Đã hoàn thành giao hàng</div>
                    </div>
                    <div class="stat-icon icon-green">
                        <i class="fa-solid fa-sack-dollar"></i>
                    </div>
                </div>

                <!-- 2. Products -->
                <div class="stat-card">
                    <div class="stat-info">
                        <h4>Tổng Sản Phẩm</h4>
                        <div class="stat-value"><?= number_format($sanPhamStats['tong_san_pham']) ?></div>
                        <div class="stat-subtext">Còn hàng: <?= $sanPhamStats['con_hang'] ?> | Hết: <?= $sanPhamStats['het_hang'] ?></div>
                    </div>
                    <div class="stat-icon icon-blue">
                        <i class="fa-solid fa-boxes-stacked"></i>
                    </div>
                </div>

                <!-- 3. Orders -->
                <div class="stat-card">
                    <div class="stat-info">
                        <h4>Tổng Đơn Hàng</h4>
                        <div class="stat-value"><?= number_format($donHangStats['tong_don_hang']) ?></div>
                        <div class="stat-subtext">Đang xử lý: <?= $donHangStats['dang_xu_ly'] ?> đơn</div>
                    </div>
                    <div class="stat-icon icon-amber">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </div>
                </div>

                <!-- 4. Customers -->
                <div class="stat-card">
                    <div class="stat-info">
                        <h4>Tổng Khách Hàng</h4>
                        <div class="stat-value" style="color: #7c3aed;"><?= number_format($khachHangStats['tong_khach_hang']) ?></div>
                        <div class="stat-subtext">Mới trong tháng: <?= $khachHangStats['khach_hang_moi'] ?> user</div>
                    </div>
                    <div class="stat-icon icon-purple">
                        <i class="fa-solid fa-users"></i>
                    </div>
                </div>
            </div>

            <!-- SECTION 1: THỐNG KÊ DOANH THU -->
            <div class="card-panel">
                <div class="card-panel-header">
                    <h3 class="card-panel-title">
                        <i class="fa-solid fa-chart-line" style="color: #16a34a;"></i>
                        1. Thống Kê Doanh Thu Chu Kỳ & Theo Sản Phẩm
                    </h3>
                </div>

                <!-- Revenue breakdown by time -->
                <div class="revenue-time-grid">
                    <div class="time-box">
                        <span>DOANH THU HÔM NAY</span>
                        <strong><?= number_format($doanhThuStats['ngay'], 0, ',', '.') ?> đ</strong>
                    </div>
                    <div class="time-box">
                        <span>DOANH THU TUẦN NÀY</span>
                        <strong><?= number_format($doanhThuStats['tuan'], 0, ',', '.') ?> đ</strong>
                    </div>
                    <div class="time-box">
                        <span>DOANH THU THÁNG NÀY</span>
                        <strong><?= number_format($doanhThuStats['thang'], 0, ',', '.') ?> đ</strong>
                    </div>
                    <div class="time-box">
                        <span>DOANH THU NĂM NÀY</span>
                        <strong><?= number_format($doanhThuStats['nam'], 0, ',', '.') ?> đ</strong>
                    </div>
                </div>

                <!-- Revenue Per Product Table -->
                <h4 style="font-size: 1rem; color: var(--text-dark); margin: 20px 0 12px 0; font-weight: 700;">
                    <i class="fa-solid fa-list-ol" style="color: var(--primary-600); margin-right: 6px;"></i>
                    Chi Tiết Doanh Thu Theo Từng Sản Phẩm
                </h4>
                <div style="overflow-x: auto;">
                    <table class="custom-table">
                        <thead>
                            <tr>
                                <th>Mã SP</th>
                                <th>Tên Sản Phẩm</th>
                                <th>Đơn Giá</th>
                                <th>Tổng Số Lượng Bán</th>
                                <th>Tổng Doanh Thu</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($doanhThuStats['theo_san_pham'])): ?>
                                <?php foreach ($doanhThuStats['theo_san_pham'] as $sp): ?>
                                    <tr>
                                        <td><strong>#SP<?= $sp['product_id'] ?></strong></td>
                                        <td><strong><?= htmlspecialchars($sp['ten']) ?></strong></td>
                                        <td><?= number_format($sp['gia'], 0, ',', '.') ?> đ</td>
                                        <td><span class="badge badge-primary"><?= number_format($sp['tong_so_luong']) ?> cái</span></td>
                                        <td style="font-weight: 700; color: #16a34a;"><?= number_format($sp['tong_doanh_thu'], 0, ',', '.') ?> đ</td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" style="text-align: center; color: var(--text-muted);">Chưa có dữ liệu bán hàng.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- DASHBOARD ROW: SECTION 2 (SẢN PHẨM) & SECTION 3 (ĐƠN HÀNG) -->
            <div class="dashboard-row">
                
                <!-- SECTION 2: THỐNG KÊ SẢN PHẨM (BÁN CHẠY & TỒN KHO) -->
                <div class="card-panel" style="margin-bottom: 0;">
                    <div class="card-panel-header">
                        <h3 class="card-panel-title">
                            <i class="fa-solid fa-fire" style="color: #dc2626;"></i>
                            2. Sản Phẩm Bán Chạy Nhất & Trạng Thái Tồn Kho
                        </h3>
                    </div>

                    <div style="overflow-x: auto;">
                        <table class="custom-table">
                            <thead>
                                <tr>
                                    <th>Sản Phẩm</th>
                                    <th>Danh Mục</th>
                                    <th>Đơn Giá</th>
                                    <th>Đã Bán</th>
                                    <th>Doanh Thu</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($sanPhamStats['ban_chay'])): ?>
                                    <?php foreach ($sanPhamStats['ban_chay'] as $bc): ?>
                                        <tr>
                                            <td>
                                                <div style="display: flex; align-items: center; gap: 10px;">
                                                    <img src="assets/images/<?= htmlspecialchars($bc['anh'] ?? 'paddle_aero.png') ?>" 
                                                         class="product-thumb" 
                                                         onerror="this.src='https://via.placeholder.com/42';" 
                                                         alt="<?= htmlspecialchars($bc['ten']) ?>">
                                                    <div>
                                                        <strong style="display: block; font-size: 0.9rem;"><?= htmlspecialchars($bc['ten']) ?></strong>
                                                        <small style="color: var(--text-muted);">#SP<?= $bc['product_id'] ?></small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><?= htmlspecialchars($bc['ten_danh_muc'] ?? 'N/A') ?></td>
                                            <td><?= number_format($bc['gia'], 0, ',', '.') ?> đ</td>
                                            <td><span class="badge badge-success"><?= number_format($bc['so_luong_ban']) ?> sp</span></td>
                                            <td style="font-weight: 700; color: #2563eb;"><?= number_format($bc['tong_doanh_thu'], 0, ',', '.') ?> đ</td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" style="text-align: center; color: var(--text-muted);">Chưa có sản phẩm bán chạy.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- SECTION 3: THỐNG KÊ ĐƠN HÀNG (BIỂU ĐỒ TRẠNG THÁI) -->
                <div class="card-panel" style="margin-bottom: 0;">
                    <div class="card-panel-header">
                        <h3 class="card-panel-title">
                            <i class="fa-solid fa-pie-chart" style="color: var(--warning-600);"></i>
                            3. Phân Loại Đơn Hàng
                        </h3>
                    </div>

                    <div style="height: 240px; position: relative; margin-bottom: 16px;">
                        <canvas id="orderChart"></canvas>
                    </div>

                    <div style="display: flex; flex-direction: column; gap: 8px;">
                        <div style="display: flex; justify-content: space-between; font-size: 0.875rem;">
                            <span><i class="fa-solid fa-circle" style="color: #f59e0b; margin-right: 6px;"></i>Đơn Đang Xử Lý</span>
                            <strong><?= $donHangStats['dang_xu_ly'] ?> đơn</strong>
                        </div>
                        <div style="display: flex; justify-content: space-between; font-size: 0.875rem;">
                            <span><i class="fa-solid fa-circle" style="color: #10b981; margin-right: 6px;"></i>Đơn Đã Giao</span>
                            <strong><?= $donHangStats['da_giao'] ?> đơn</strong>
                        </div>
                        <div style="display: flex; justify-content: space-between; font-size: 0.875rem;">
                            <span><i class="fa-solid fa-circle" style="color: #ef4444; margin-right: 6px;"></i>Đơn Đã Hủy</span>
                            <strong><?= $donHangStats['da_huy'] ?> đơn</strong>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECTION 4: THỐNG KÊ KHÁCH HÀNG -->
            <div class="card-panel" style="margin-top: 28px;">
                <div class="card-panel-header">
                    <h3 class="card-panel-title">
                        <i class="fa-solid fa-users-gear" style="color: #7c3aed;"></i>
                        4. Thống Kê Khách Hàng & Khách Hàng Mua Nhiều Nhất
                    </h3>
                </div>

                <div style="overflow-x: auto;">
                    <table class="custom-table">
                        <thead>
                            <tr>
                                <th>Hạng</th>
                                <th>Tên Đăng Nhập</th>
                                <th>Email</th>
                                <th>Địa Chỉ</th>
                                <th>Số Đơn Hàng</th>
                                <th>Tổng Chi Tiêu</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($khachHangStats['mua_nhieu_nhat'])): ?>
                                <?php $rank = 1; foreach ($khachHangStats['mua_nhieu_nhat'] as $kh): ?>
                                    <tr>
                                        <td>
                                            <?php if ($rank == 1): ?>
                                                <span class="badge badge-warning"><i class="fa-solid fa-trophy"></i> Top 1</span>
                                            <?php elseif ($rank == 2): ?>
                                                <span class="badge badge-primary"><i class="fa-solid fa-medal"></i> Top 2</span>
                                            <?php elseif ($rank == 3): ?>
                                                <span class="badge badge-success"><i class="fa-solid fa-award"></i> Top 3</span>
                                            <?php else: ?>
                                                <span class="badge" style="background: #f1f5f9; color: #475569;">#<?= $rank ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td><strong><?= htmlspecialchars($kh['username']) ?></strong></td>
                                        <td><?= htmlspecialchars($kh['email']) ?></td>
                                        <td><?= htmlspecialchars($kh['address'] ?? 'N/A') ?></td>
                                        <td><span class="badge badge-primary"><?= number_format($kh['so_don_hang']) ?> đơn</span></td>
                                        <td style="font-weight: 700; color: #7c3aed;"><?= number_format($kh['tong_chi_tieu'], 0, ',', '.') ?> đ</td>
                                    </tr>
                                <?php $rank++; endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" style="text-align: center; color: var(--text-muted);">Chưa có thông tin mua hàng.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </main>

        <!-- Footer -->
        <footer class="admin-footer">
            &copy; <?= date('Y') ?> Pickleball Admin Management System. All Rights Reserved.
        </footer>
    </div>

    <!-- Render Chart.js Donut for Order Status breakdown -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const ctx = document.getElementById('orderChart').getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Đang xử lý', 'Đã giao', 'Đã hủy'],
                    datasets: [{
                        data: [
                            <?= (int)$donHangStats['dang_xu_ly'] ?>,
                            <?= (int)$donHangStats['da_giao'] ?>,
                            <?= (int)$donHangStats['da_huy'] ?>
                        ],
                        backgroundColor: ['#f59e0b', '#10b981', '#ef4444'],
                        borderWidth: 2,
                        borderColor: '#ffffff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    cutout: '70%'
                }
            });
        });
    </script>
</body>
</html>
