<style>
.adi-hero-banner-wrapper {
    width: 100%;
}

.adi-hero-banner {
    position: relative;
    width: 100vw;
    margin-left: calc(-50vw + 50%);
    height: calc(100vh - 115px);
    min-height: 650px;
    background-color: #111;
    background-image: linear-gradient(to right, rgba(0,0,0,0.85) 0%, rgba(0,0,0,0.4) 40%, rgba(0,0,0,0) 100%), url('assets/images/hero_paddle.png');
    background-size: cover;
    background-position: center;
    display: flex;
    align-items: center;
    padding: 60px 80px;
    overflow: hidden;
}

.adi-hero-overlay-content {
    max-width: 650px;
    color: #fff;
    z-index: 2;
}

.adi-hero-tag {
    font-family: 'Oswald', sans-serif;
    font-size: 14px;
    font-weight: 700;
    letter-spacing: 2px;
    text-transform: uppercase;
    background: #000;
    color: #fff;
    padding: 6px 12px;
    display: inline-block;
    margin-bottom: 16px;
}

.adi-hero-title {
    font-family: 'Oswald', sans-serif;
    font-size: 54px;
    font-weight: 700;
    line-height: 1.05;
    text-transform: uppercase;
    letter-spacing: -0.5px;
    margin-bottom: 16px;
    text-shadow: 0 4px 12px rgba(0,0,0,0.5);
}

.adi-hero-desc {
    font-family: 'Roboto', sans-serif;
    font-size: 16px;
    color: #ddd;
    line-height: 1.5;
    margin-bottom: 30px;
}

.adi-hero-buttons {
    display: flex;
    gap: 16px;
    flex-wrap: wrap;
}

.adi-btn-sharp {
    display: inline-flex;
    align-items: center;
    gap: 16px;
    background-color: #000;
    color: #fff;
    font-family: 'Oswald', sans-serif;
    font-size: 14px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    padding: 16px 32px;
    text-decoration: none;
    border: 1px solid #000;
    outline: 1px solid transparent;
    outline-offset: 0px;
    transition: all 0.2s ease-in-out;
}

.adi-btn-sharp i {
    transition: transform 0.2s ease-in-out;
}

.adi-btn-sharp:hover {
    outline: 1px solid #000;
    outline-offset: 2px;
}

.adi-btn-sharp:hover i {
    transform: translateX(4px);
}

.adi-btn-sharp.secondary {
    background-color: #fff;
    color: #000;
    border: 1px solid #fff;
}

.adi-btn-sharp.secondary:hover {
    outline: 1px solid #fff;
    outline-offset: 2px;
}
</style>

<div class="adi-hero-banner-wrapper">
    <section class="adi-hero-banner">
        <div class="adi-hero-overlay-content">
            <div class="adi-hero-tag">BỘ SƯU TẬP CHÍNH HÃNG 2026</div>
            <h1 class="adi-hero-title">BỘ SƯU TẬP<br>PICKLEBALL PPA TOUR</h1>
            <p class="adi-hero-desc">Kiến tạo lối chơi làm chủ sân đấu. Trang bị công nghệ Carbon T700 chuẩn quốc tế cùng hiệu suất kiểm soát tối đa.</p>
            <div class="adi-hero-buttons">
                <a href="index.php?act=sanpham&id=1" class="adi-btn-sharp">MUA VỢT NGAY <i class="fa-solid fa-arrow-right-long"></i></a>
                <a href="index.php?act=sanpham&id=2" class="adi-btn-sharp secondary">MUA GIÀY THỂ THAO <i class="fa-solid fa-arrow-right-long"></i></a>
            </div>
        </div>
    </section>
</div>
