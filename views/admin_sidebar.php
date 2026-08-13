<!-- Left Sidebar -->
<aside class="adi-main-sidebar">
    <!-- Logo Area -->
    <a href="index.php?act=admin" class="adi-logo-area" title="Bảng điều khiển Admin">
        <svg viewBox="0 0 60 40" xmlns="http://www.w3.org/2000/svg" style="fill: #fff; height: 38px; width: auto;">
            <path d="M0,32.5 L13,32.5 L26,7.5 L13,7.5 Z"/>
            <path d="M15,32.5 L28,32.5 L41,0 L28,0 Z"/>
            <path d="M30,32.5 L43,32.5 L56,-7.5 L43,-7.5 Z"/>
        </svg>
    </a>

    <!-- User Panel -->
    <div class="adi-user-panel">
        <img src="<?= BASE_URL ?>/assets/images/hero_paddle.png" alt="User Image">
        <div class="adi-user-info">
            <p><?= htmlspecialchars($_SESSION['user']['username'] ?? 'Admin') ?></p>
            <span>Online</span>
        </div>
    </div>

    <!-- Sidebar Menu -->
    <ul class="adi-sidebar-menu">
        <li class="adi-sidebar-menu-header">MAIN NAVIGATION</li>
        
        <li class="<?= (!isset($_GET['act']) || strpos($_GET['act'], 'admin_thongke') !== false || $_GET['act'] == 'admin') ? 'active' : '' ?>">
            <a href="index.php?act=admin_thongke">
                <i class="fa-solid fa-chart-pie menu-icon"></i> 
                Báo cáo Thống kê
            </a>
        </li>
        


        <li class="<?= (isset($_GET['act']) && $_GET['act'] == 'admin_danhmuc') ? 'active' : '' ?>">
            <a href="index.php?act=admin_danhmuc">
                <i class="fa-solid fa-layer-group menu-icon"></i> 
                Quản lý Danh mục
            </a>
        </li>

        <li class="<?= (isset($_GET['act']) && $_GET['act'] == 'admin_sanpham') ? 'active' : '' ?>">
            <a href="index.php?act=admin_sanpham">
                <i class="fa-solid fa-box-open menu-icon"></i> 
                Quản lý Sản phẩm
            </a>
        </li>



        <li class="<?= (isset($_GET['act']) && strpos($_GET['act'], 'admin_nguoidung') !== false) ? 'active' : '' ?>">
            <a href="index.php?act=admin_nguoidung">
                <i class="fa-solid fa-users menu-icon"></i> 
                Quản lý User
            </a>
        </li>
        

    </ul>
</aside>
