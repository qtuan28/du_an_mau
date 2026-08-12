<style>
.adi-footer-main {
    background-color: #000;
    color: #fff;
    padding: 50px 40px 40px;
    border-top: 1px solid #222;
}

.adi-footer-simple {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 60px;
    max-width: 1200px;
    margin: 0 auto;
    flex-wrap: wrap;
}

.adi-footer-brand {
    flex: 1;
    min-width: 300px;
}

.adi-footer-brand-title {
    font-family: 'Oswald', sans-serif;
    font-size: 24px;
    font-weight: 700;
    letter-spacing: 1px;
    text-transform: uppercase;
    margin: 0 0 12px 0;
    color: #fff;
    display: flex;
    align-items: center;
    gap: 10px;
}

.adi-footer-brand p {
    font-family: 'Roboto', sans-serif;
    color: #aaa;
    font-size: 14px;
    line-height: 1.6;
    margin: 0;
    max-width: 460px;
}

.adi-footer-nav-col {
    min-width: 220px;
}

.adi-footer-nav-col h3 {
    font-family: 'Oswald', sans-serif;
    font-size: 16px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin: 0 0 18px 0;
    color: #fff;
}

.adi-footer-nav-col ul {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.adi-footer-nav-col a {
    font-family: 'Roboto', sans-serif;
    color: #ccc;
    text-decoration: none;
    font-size: 14px;
    transition: color 0.2s, padding-left 0.2s;
}

.adi-footer-nav-col a:hover {
    color: #fff;
    font-weight: 500;
    padding-left: 4px;
}

.adi-footer-bottom {
    background-color: #000;
    color: #777;
    padding: 20px 40px;
    font-family: 'Roboto', sans-serif;
    font-size: 13px;
    text-align: center;
    letter-spacing: 0.5px;
    border-top: 1px solid #1a1a1a;
}
</style>

<!-- Main Simplified Footer -->
<footer class="adi-footer-main">
    <div class="adi-footer-simple">
        <!-- Shop Brand Info -->
        <div class="adi-footer-brand">
            <h2 class="adi-footer-brand-title">
                <svg viewBox="0 0 60 40" xmlns="http://www.w3.org/2000/svg" style="height: 36px; width: auto; display: block;">
                    <path d="M0,32.5 L13,32.5 L26,7.5 L13,7.5 Z" fill="#fff"/>
                    <path d="M15,32.5 L28,32.5 L41,0 L28,0 Z" fill="#fff"/>
                    <path d="M30,32.5 L43,32.5 L56,-7.5 L43,-7.5 Z" fill="#fff"/>
                </svg>
            </h2>
            <p>Há»‡ thá»‘ng cung cáº¥p trang thiáº¿t bá»‹ Pickleball chÃ­nh hÃ£ng. Cung cáº¥p vá»£t thi Ä‘áº¥u, giÃ y thá»ƒ thao vÃ  phá»¥ kiá»‡n Ä‘áº¡t chuáº©n quá»‘c táº¿.</p>
        </div>
        
        <!-- Pickleball Categories -->
        <div class="adi-footer-nav-col">
            <h3>Sáº¢N PHáº¨M PICKLEBALL</h3>
            <ul>
                <li><a href="index.php?act=sanpham&id=1">Vá»£t Pickleball</a></li>
                <li><a href="index.php?act=sanpham&id=2">GiÃ y Thá»ƒ Thao</a></li>
                <li><a href="index.php?act=sanpham&id=3">Phá»¥ Kiá»‡n Thá»ƒ Thao</a></li>
                <li><a href="index.php?act=sanpham">BÃ³ng Pickleball</a></li>
                <li><a href="index.php?act=sanpham">Bá»™ SÆ°u Táº­p PPA Tour</a></li>
            </ul>
        </div>
    </div>
</footer>

<!-- Bottom Copyright Bar -->
<div class="adi-footer-bottom">
    &copy; <?= date('Y') ?> PICKLEBALL STORE. Táº¥t cáº£ quyá»n Ä‘Æ°á»£c báº£o lÆ°u.
</div>
