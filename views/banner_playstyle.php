<style>
.adi-full-banner-wrapper {
    width: 100%;
    margin: 0;
    padding: 0;
}

.adi-full-banner {
    position: relative;
    width: 100%;
    margin: 0;
    height: 460px;
    background-color: #000;
    overflow: hidden;
    display: flex;
    align-items: flex-end;
    padding: 50px 80px;
}

.adi-full-banner img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    opacity: 0.75;
}

.adi-full-banner-content {
    position: relative;
    z-index: 2;
    max-width: 650px;
    color: #fff;
}

.adi-full-banner-title {
    font-family: 'Oswald', sans-serif;
    font-size: 42px;
    font-weight: 700;
    text-transform: uppercase;
    line-height: 1.1;
    letter-spacing: -0.5px;
    margin-bottom: 12px;
    text-shadow: 0 4px 10px rgba(0,0,0,0.6);
}

.adi-full-banner-desc {
    font-family: 'Roboto', sans-serif;
    font-size: 15px;
    color: #eee;
    line-height: 1.5;
    margin-bottom: 24px;
    text-shadow: 0 2px 6px rgba(0,0,0,0.6);
}
</style>

<div class="adi-full-banner-wrapper">
    <div class="adi-full-banner">
        <img src="<?= BASE_URL ?>/assets/images/hero_paddle.png" alt="Kiáº¿n Táº¡o Lá»‘i ChÆ¡i" onerror="this.src='<?= BASE_URL ?>/assets/images/hero_paddle.png'">
        <div class="adi-full-banner-content">
            <h2 class="adi-full-banner-title">KIáº¾N Táº O Lá»I CHÆ I Báº®T Máº®T & CHUYÃŠN NGHIá»†P</h2>
            <p class="adi-full-banner-desc">Lá»±a chá»n dÃ²ng vá»£t phÃ¹ há»£p vá»›i phong cÃ¡ch táº¥n cÃ´ng hay kiá»ƒm soÃ¡t bÃ³ng linh hoáº¡t. Thiáº¿t káº¿ cÃ´ng nghá»‡ tá»‘i Æ°u cho tá»«ng cÃº Ä‘Ã¡nh chuáº©n xÃ¡c.</p>
            <a href="index.php?act=sanpham" class="adi-btn-sharp secondary">KHÃM PHÃ Bá»˜ SÆ¯U Táº¬P NGAY <i class="fa-solid fa-arrow-right-long"></i></a>
        </div>
    </div>
</div>
