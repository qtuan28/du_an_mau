<style>
/* Adidas Authentic Header System */
@import url('https://fonts.googleapis.com/css2?family=Oswald:wght@500;600;700&family=Roboto:ital,wght@0,400;0,500;0,700;1,400&display=swap');

:root {
    --adi-black: #000000;
    --adi-white: #ffffff;
    --adi-gray-bg: #ebedee;
    --adi-gray-light: #f5f5f5;
    --adi-gray-text: #767677;
    --adi-red: #e50010;
    --adi-font-title: 'Oswald', sans-serif;
    --adi-font-body: 'Roboto', sans-serif;
}

.adi-announcement-bar {
    background-color: #000;
    color: #fff;
    font-family: var(--adi-font-title);
    font-size: 12px;
    letter-spacing: 1.5px;
    font-weight: 600;
    text-transform: uppercase;
    padding: 8px 0;
    text-align: center;
    border-bottom: 1px solid #222;
}

.adi-announcement-bar span {
    display: inline-flex;
    align-items: center;
    gap: 15px;
}

.adi-top-utility {
    background-color: #000;
    color: #fff;
    font-family: var(--adi-font-body);
    font-size: 11px;
    font-weight: 500;
    padding: 4px 40px;
    display: flex;
    justify-content: flex-end;
    gap: 24px;
    border-bottom: 1px solid #111;
}

.adi-top-utility a {
    color: #fff;
    text-decoration: none;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    transition: opacity 0.2s;
}

.adi-top-utility a:hover {
    opacity: 0.7;
}

.adi-main-header {
    background-color: #fff;
    height: 80px;
    padding: 0 40px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    position: sticky;
    top: 0;
    z-index: 10000;
    border-bottom: 1px solid var(--adi-gray-bg);
}

.adi-logo-container {
    display: flex;
    align-items: center;
    gap: 12px;
    text-decoration: none;
    color: #000;
}

.adi-logo-svg {
    height: 38px;
    width: auto;
}

.adi-logo-text {
    font-family: var(--adi-font-title);
    font-size: 26px;
    font-weight: 700;
    letter-spacing: -0.5px;
    text-transform: uppercase;
    line-height: 1;
}

.adi-nav-menu {
    display: flex;
    align-items: center;
    gap: 32px;
    height: 100%;
}

.adi-nav-item {
    font-family: var(--adi-font-title);
    font-size: 15px;
    font-weight: 600;
    color: #000;
    text-decoration: none;
    text-transform: uppercase;
    letter-spacing: 1.2px;
    height: 100%;
    display: flex;
    align-items: center;
    position: relative;
}

.adi-nav-item::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 0%;
    height: 3px;
    background-color: #000;
    transition: width 0.2s ease-in-out;
}

.adi-nav-item:hover::after,
.adi-nav-item.active::after {
    width: 100%;
}

.adi-nav-item.sale {
    color: var(--adi-red);
}

.adi-nav-item.sale::after {
    background-color: var(--adi-red);
}

.adi-header-actions {
    display: flex;
    align-items: center;
    gap: 16px;
}

.adi-search-box {
    position: relative;
    display: flex;
    align-items: center;
    background-color: var(--adi-gray-light);
    border: 1px solid transparent;
    padding: 6px 14px;
    width: 220px;
    transition: all 0.2s ease;
}

.adi-search-box:focus-within {
    background-color: #fff;
    border-color: #000;
}

.adi-search-input {
    border: none;
    background: transparent;
    outline: none;
    font-family: var(--adi-font-body);
    font-size: 13px;
    width: 100%;
    color: #000;
}

.adi-search-btn {
    border: none;
    background: transparent;
    cursor: pointer;
    color: #000;
    font-size: 14px;
}

.adi-icon-link {
    color: #000;
    font-size: 18px;
    text-decoration: none;
    position: relative;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background 0.2s;
}

.adi-icon-link:hover {
    background-color: var(--adi-gray-light);
}

.adi-badge-num {
    position: absolute;
    top: 4px;
    right: 4px;
    background-color: #000;
    color: #fff;
    font-family: var(--adi-font-body);
    font-size: 10px;
    font-weight: 700;
    width: 16px;
    height: 16px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>

<!-- Top Announcement Banner -->
<div class="adi-announcement-bar">
    <span>
        <i class="fa-solid fa-truck"></i> GIAO HÀNG MIỄN PHÍ CHO ĐƠN HÀNG TỪ 1.600.000 VNĐ &nbsp;|&nbsp; 
        <i class="fa-solid fa-rotate-left"></i> TRẢ HÀNG MIỄN PHÍ TRONG 30 NGÀY
    </span>
</div>

<!-- Utility Links Bar -->
<div class="adi-top-utility">
    <?php if (isset($_SESSION['user'])): ?>
        <a href="index.php?act=profile">Xin chào, <strong><?= htmlspecialchars($_SESSION['user']['username']) ?></strong></a>
        <a href="index.php?act=logout">Đăng xuất</a>
    <?php else: ?>
        <a href="index.php?act=login">Đăng nhập</a>
        <a href="index.php?act=register">Đăng ký</a>
    <?php endif; ?>
</div>

<!-- Main Sticky Header -->
<header class="adi-main-header">
    <a href="index.php?act=index" class="adi-logo-container">
        <!-- Authentic Adidas 3-Stripes SVG Logo -->
        <svg class="adi-logo-svg" viewBox="0 0 60 40" xmlns="http://www.w3.org/2000/svg">
            <path d="M0,32.5 L13,32.5 L26,7.5 L13,7.5 Z" fill="#000"/>
            <path d="M15,32.5 L28,32.5 L41,0 L28,0 Z" fill="#000"/>
            <path d="M30,32.5 L43,32.5 L56,-7.5 L43,-7.5 Z" fill="#000"/>
        </svg>
        <span class="adi-logo-text">PICKLEBALL</span>
    </a>
    
    <nav class="adi-nav-menu">
        <?php 
            require_once 'models/danhmuc.php';
            $headerDmModel = new DanhMuc();
            $headerCategories = $headerDmModel->getAll();
            if (!empty($headerCategories)):
                foreach ($headerCategories as $hCategory):
                    if (isset($hCategory['trang_thai']) && (int)$hCategory['trang_thai'] === 0) continue;
        ?>
            <a href="index.php?act=sanpham&id=<?= $hCategory['category_id'] ?>" class="adi-nav-item"><?= htmlspecialchars(mb_strtoupper($hCategory['name'])) ?></a>
        <?php 
                endforeach;
            endif;
        ?>
        <?php if (isset($_SESSION['user']) && ($_SESSION['user']['vai_tro_id'] ?? 0) == 1): ?>
            <a href="index.php?act=admin" class="adi-nav-item" style="color: #7c3aed;">ADMIN PANEL</a>
        <?php endif; ?>
    </nav>
    
    <div class="adi-header-actions">
        <form action="index.php" method="GET" class="adi-search-box">
            <input type="hidden" name="act" value="sanpham">
            <input type="text" name="keyword" class="adi-search-input" placeholder="Tìm kiếm sản phẩm..." value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>">
            <button type="submit" class="adi-search-btn"><i class="fa-solid fa-magnifying-glass"></i></button>
        </form>

        <a href="index.php?act=profile" class="adi-icon-link" title="Tài khoản"><i class="fa-regular fa-user"></i></a>
        <a href="index.php?act=giohang" class="adi-icon-link" title="Giỏ hàng">
            <i class="fa-solid fa-bag-shopping"></i>
            <span class="adi-badge-num" id="headerCartBadge">
                <?php 
                    $cartQtyCount = 0;
                    if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
                        foreach ($_SESSION['cart'] as $cItem) {
                            $cartQtyCount += (int)($cItem['so_luong'] ?? 1);
                        }
                    }
                    echo $cartQtyCount;
                ?>
            </span>
        </a>
    </div>
</header>

<!-- Toast Notification Bar -->
<div id="adiToast" class="adi-toast-notification">
    <i class="fa-solid fa-circle-check" style="color: #10b981; font-size: 16px;"></i>
    <span id="adiToastText">Đã thêm sản phẩm vào giỏ hàng!</span>
</div>

<style>
@keyframes badgePop {
    0% { transform: scale(1); }
    50% { transform: scale(1.4); }
    100% { transform: scale(1); }
}

.adi-badge-pop {
    animation: badgePop 0.35s ease-in-out !important;
}

.adi-toast-notification {
    position: fixed;
    bottom: 30px;
    right: 30px;
    background-color: #000;
    color: #fff;
    font-family: 'Roboto', sans-serif;
    font-size: 14px;
    font-weight: 500;
    padding: 14px 24px;
    box-shadow: 0 8px 24px rgba(0,0,0,0.25);
    z-index: 999999;
    display: flex;
    align-items: center;
    gap: 12px;
    transform: translateY(100px);
    opacity: 0;
    pointer-events: none;
    transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

.adi-toast-notification.show {
    transform: translateY(0);
    opacity: 1;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.body.addEventListener('click', function(e) {
        const btn = e.target.closest('a[href*="act=add_giohang"]');
        if (!btn) return;
        
        const href = btn.getAttribute('href');
        if (!href || href.includes('redirect=thanhtoan') || href.includes('redirect=giohang')) {
            return;
        }
        
        e.preventDefault();
        
        const ajaxUrl = href + (href.includes('?') ? '&ajax=1' : '?ajax=1');
        
        fetch(ajaxUrl, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data && data.status === 'success') {
                const badge = document.getElementById('headerCartBadge') || document.querySelector('.adi-badge-num');
                if (badge) {
                    badge.textContent = data.cart_count;
                    badge.classList.remove('adi-badge-pop');
                    void badge.offsetWidth;
                    badge.classList.add('adi-badge-pop');
                }
                
                showAdiToast(data.message || 'Đã thêm sản phẩm vào giỏ hàng!');
            }
        })
        .catch(err => {
            window.location.href = href;
        });
    });
});

function showAdiToast(message) {
    const toast = document.getElementById('adiToast');
    const toastText = document.getElementById('adiToastText');
    if (!toast || !toastText) return;
    
    toastText.textContent = message;
    toast.classList.add('show');
    
    if (window.adiToastTimer) clearTimeout(window.adiToastTimer);
    window.adiToastTimer = setTimeout(function() {
        toast.classList.remove('show');
    }, 2800);
}
</script>
