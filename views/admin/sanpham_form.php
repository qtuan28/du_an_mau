<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= ($mode === 'edit') ? 'Sửa Sản Phẩm' : 'Thêm Sản Phẩm Mới' ?> | Admin Panel</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .adi-form-card {
            background: #fff;
            padding: 30px;
            border: 1px solid #ebedee;
        }

        .adi-form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
        }

        @media (max-width: 768px) {
            .adi-form-grid {
                grid-template-columns: 1fr;
            }
        }

        .adi-field-group {
            margin-bottom: 20px;
        }

        .adi-field-label {
            display: block;
            font-family: 'Oswald', sans-serif;
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #000;
            margin-bottom: 8px;
        }

        .adi-field-label span.req {
            color: #e50010;
        }

        .adi-field-input {
            width: 100%;
            padding: 12px 14px;
            font-family: 'Roboto', sans-serif;
            font-size: 14px;
            border: 1px solid #ccc;
            outline: none;
            transition: border-color 0.2s;
            background: #fff;
            box-sizing: border-box;
        }

        .adi-field-input:focus {
            border-color: #000;
        }

        .adi-image-upload-preview {
            margin-top: 10px;
            padding: 10px;
            border: 1px dashed #ccc;
            display: inline-flex;
            align-items: center;
            gap: 12px;
            background: #fafafa;
        }

        .adi-image-upload-preview img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border: 1px solid #ddd;
        }

        .adi-form-actions-bar {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ebedee;
        }

        .adi-btn-primary {
            background-color: #000;
            color: #fff;
            font-family: 'Oswald', sans-serif;
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 12px 24px;
            border: 1px solid #000;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
            text-decoration: none;
        }

        .adi-btn-primary:hover {
            background-color: #333;
        }

        .adi-btn-secondary {
            background-color: #fff;
            color: #333;
            font-family: 'Oswald', sans-serif;
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 12px 24px;
            border: 1px solid #ccc;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
            text-decoration: none;
        }

        .adi-btn-secondary:hover {
            border-color: #000;
            color: #000;
        }
    </style>
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
                <div class="adi-content-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
                    <div>
                        <h1 class="adi-page-title"><?= ($mode === 'edit') ? 'CẬP NHẬT SẢN PHẨM' : 'THÊM SẢN PHẨM MỚI' ?></h1>
                        <div class="adi-breadcrumb">
                            <a href="index.php?act=admin"><i class="fa-solid fa-house"></i> Trang chủ</a> > 
                            <a href="index.php?act=admin_sanpham">Quản lý Sản phẩm</a> > 
                            <?= ($mode === 'edit') ? 'Chỉnh sửa' : 'Thêm mới' ?>
                        </div>
                    </div>
                    <a href="index.php?act=admin_sanpham" class="adi-btn-secondary">
                        <i class="fa-solid fa-arrow-left"></i> Quay lại danh sách
                    </a>
                </div>

                <!-- Error Message Alert -->
                <?php if(isset($_SESSION['error'])): ?>
                    <div style="background: #fef2f2; color: #991b1b; padding: 14px 18px; margin-bottom: 24px; border-left: 4px solid #e50010; font-family: 'Roboto', sans-serif; font-size: 14px;">
                        <i class="fa-solid fa-circle-exclamation"></i> <?= htmlspecialchars($_SESSION['error']) ?>
                    </div>
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>

                <!-- Form Card Box -->
                <div class="adi-box">
                    <div class="adi-box-header">
                        <h3 style="font-family: 'Oswald', sans-serif; font-size: 16px; font-weight: 700; text-transform: uppercase; margin: 0;">
                            <i class="fa-solid fa-box-open"></i> Thông tin sản phẩm
                        </h3>
                    </div>

                    <div class="adi-form-card">
                        <form method="POST"
                              action="index.php?act=<?= ($mode === 'edit') ? 'admin_sanpham_edit' : 'admin_sanpham_add' ?>"
                              enctype="multipart/form-data">

                            <?php if ($mode === 'edit'): ?>
                                <input type="hidden" name="product_id" value="<?= $sanPham['product_id'] ?>">
                                <input type="hidden" name="old_anh" value="<?= htmlspecialchars($sanPham['anh'] ?? '') ?>">
                                <input type="hidden" name="old_anh_1" value="<?= htmlspecialchars($sanPham['anh_1'] ?? '') ?>">
                                <input type="hidden" name="old_anh_2" value="<?= htmlspecialchars($sanPham['anh_2'] ?? '') ?>">
                                <input type="hidden" name="old_anh_3" value="<?= htmlspecialchars($sanPham['anh_3'] ?? '') ?>">
                                <input type="hidden" name="old_anh_4" value="<?= htmlspecialchars($sanPham['anh_4'] ?? '') ?>">
                            <?php endif; ?>

                            <div class="adi-form-grid">
                                <!-- Column 1 -->
                                <div>
                                    <div class="adi-field-group">
                                        <label class="adi-field-label" for="ten">Tên sản phẩm <span class="req">*</span></label>
                                        <input
                                            type="text"
                                            id="ten"
                                            name="ten"
                                            class="adi-field-input"
                                            value="<?= htmlspecialchars($sanPham['ten'] ?? '') ?>"
                                            placeholder="Ví dụ: Vợt Pickleball Force 1 Pro"
                                            required
                                            autofocus
                                        >
                                    </div>

                                    <div class="adi-field-group">
                                        <label class="adi-field-label" for="ma_sp">Mã sản phẩm (SKU)</label>
                                        <input
                                            type="text"
                                            id="ma_sp"
                                            name="ma_sp"
                                            class="adi-field-input"
                                            value="<?= htmlspecialchars($sanPham['ma_sp'] ?? '') ?>"
                                            placeholder="Nếu để trống sẽ tự động sinh mã"
                                        >
                                        <div style="font-size: 11px; color: #777; margin-top: 4px;">Khoảng 8 ký tự, dùng để định danh duy nhất.</div>
                                    </div>

                                    <div class="adi-field-group">
                                        <label class="adi-field-label" for="category_id">Danh mục sản phẩm <span class="req">*</span></label>
                                        <select id="category_id" name="category_id" class="adi-field-input" required>
                                            <option value="">-- Chọn danh mục --</option>
                                            <?php if (!empty($dsDanhMuc)): ?>
                                                <?php foreach ($dsDanhMuc as $dm): ?>
                                                    <option value="<?= $dm['category_id'] ?>"
                                                        <?= (isset($sanPham['category_id']) && $sanPham['category_id'] == $dm['category_id']) ? 'selected' : '' ?>>
                                                        <?= htmlspecialchars($dm['name']) ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>

                                    <div class="adi-field-group">
                                        <label class="adi-field-label" for="trang_thai">Trạng thái kinh doanh</label>
                                        <select id="trang_thai" name="trang_thai" class="adi-field-input">
                                            <option value="1" <?= (isset($sanPham['trang_thai']) && $sanPham['trang_thai'] == 1) ? 'selected' : '' ?>>
                                                🟢 Còn hàng (Đang kinh doanh)
                                            </option>
                                            <option value="0" <?= (isset($sanPham['trang_thai']) && $sanPham['trang_thai'] == 0) ? 'selected' : '' ?>>
                                                🔴 Hết hàng (Tạm ngưng)
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Column 2 -->
                                <div>
                                    <div class="adi-field-group">
                                        <label class="adi-field-label" for="gia">Giá bán (VNĐ) <span class="req">*</span></label>
                                        <input
                                            type="number"
                                            id="gia"
                                            name="gia"
                                            class="adi-field-input"
                                            value="<?= htmlspecialchars($sanPham['gia'] ?? '') ?>"
                                            min="0"
                                            placeholder="0"
                                            required
                                        >
                                    </div>

                                    <div class="adi-field-group">
                                        <label class="adi-field-label" for="so_luong_nhap">
                                            <?= ($mode === 'edit') ? 'Thêm số lượng tồn kho' : 'Số lượng nhập kho ban đầu' ?>
                                        </label>
                                        <input
                                            type="number"
                                            id="so_luong_nhap"
                                            name="so_luong_nhap"
                                            class="adi-field-input"
                                            value="0"
                                            min="0"
                                            placeholder="Nhập số lượng để cập nhật kho"
                                        >
                                        <?php if ($mode === 'edit'): ?>
                                            <div style="font-size: 11px; color: #10b981; margin-top: 4px; font-weight: bold;">
                                                Số lượng tồn kho hiện tại: <?= htmlspecialchars($sanPham['so_luong'] ?? 0) ?>
                                            </div>
                                            <div style="font-size: 11px; color: #777; margin-top: 2px;">
                                                Nhập số lượng muốn nhập thêm. Để 0 nếu không đổi tồn kho.
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="adi-field-group">
                                        <label class="adi-field-label" for="anh">Hình ảnh sản phẩm chính (Ảnh bìa)</label>
                                        <input type="file" id="anh" name="anh" accept="image/*" class="adi-field-input" style="padding: 10px;">
                                        <?php if ($mode === 'edit' && !empty($sanPham['anh'])): ?>
                                            <div class="adi-image-upload-preview">
                                                <img src="<?= (strpos($sanPham['anh'], 'assets/') === 0 || strpos($sanPham['anh'], 'uploads/') === 0) ? BASE_URL . '/' . $sanPham['anh'] : BASE_URL . '/assets/images/' . $sanPham['anh'] ?>"
                                                     alt="Thumbnail"
                                                     onerror="this.src='<?= BASE_URL ?>/assets/images/hero_paddle.png'">
                                                <div>
                                                    <span style="font-family: 'Roboto', sans-serif; font-size: 12px; color: #666; display: block;">Ảnh hiện tại:</span>
                                                    <strong style="font-family: 'Roboto', sans-serif; font-size: 13px; color: #000;"><?= htmlspecialchars($sanPham['anh']) ?></strong>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <!-- 4 Detail Images Gallery Section -->
                            <div style="margin-top: 32px; padding-top: 24px; border-top: 1px dashed #ccc;">
                                <h4 style="font-family: 'Oswald', sans-serif; font-size: 16px; font-weight: 700; text-transform: uppercase; margin: 0 0 20px 0; color: #000;">
                                    <i class="fa-regular fa-images"></i> 4 Hình ảnh chi tiết sản phẩm (Album Lưới 2x2)
                                </h4>

                                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
                                    <!-- Image 1 -->
                                    <div class="adi-field-group" style="background: #fafafa; padding: 16px; border: 1px dashed #ddd;">
                                        <label class="adi-field-label" for="anh_1">Ảnh chi tiết 1 (Góc trên bên trái)</label>
                                        <input type="file" id="anh_1" name="anh_1" accept="image/*" class="adi-field-input" style="padding: 8px;">
                                        <?php if ($mode === 'edit' && !empty($sanPham['anh_1'])): ?>
                                            <div class="adi-image-upload-preview" style="margin-top: 8px;">
                                                <img src="<?= (strpos($sanPham['anh_1'], 'assets/') === 0 || strpos($sanPham['anh_1'], 'uploads/') === 0) ? BASE_URL . '/' . $sanPham['anh_1'] : BASE_URL . '/uploads/' . $sanPham['anh_1'] ?>" alt="Detail 1" onerror="this.src='<?= BASE_URL ?>/assets/images/hero_paddle.png'">
                                                <span style="font-size: 12px; color: #666;"><?= htmlspecialchars($sanPham['anh_1']) ?></span>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Image 2 -->
                                    <div class="adi-field-group" style="background: #fafafa; padding: 16px; border: 1px dashed #ddd;">
                                        <label class="adi-field-label" for="anh_2">Ảnh chi tiết 2 (Góc trên bên phải)</label>
                                        <input type="file" id="anh_2" name="anh_2" accept="image/*" class="adi-field-input" style="padding: 8px;">
                                        <?php if ($mode === 'edit' && !empty($sanPham['anh_2'])): ?>
                                            <div class="adi-image-upload-preview" style="margin-top: 8px;">
                                                <img src="<?= (strpos($sanPham['anh_2'], 'assets/') === 0 || strpos($sanPham['anh_2'], 'uploads/') === 0) ? BASE_URL . '/' . $sanPham['anh_2'] : BASE_URL . '/uploads/' . $sanPham['anh_2'] ?>" alt="Detail 2" onerror="this.src='<?= BASE_URL ?>/assets/images/hero_paddle.png'">
                                                <span style="font-size: 12px; color: #666;"><?= htmlspecialchars($sanPham['anh_2']) ?></span>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Image 3 -->
                                    <div class="adi-field-group" style="background: #fafafa; padding: 16px; border: 1px dashed #ddd;">
                                        <label class="adi-field-label" for="anh_3">Ảnh chi tiết 3 (Góc dưới bên trái)</label>
                                        <input type="file" id="anh_3" name="anh_3" accept="image/*" class="adi-field-input" style="padding: 8px;">
                                        <?php if ($mode === 'edit' && !empty($sanPham['anh_3'])): ?>
                                            <div class="adi-image-upload-preview" style="margin-top: 8px;">
                                                <img src="<?= (strpos($sanPham['anh_3'], 'assets/') === 0 || strpos($sanPham['anh_3'], 'uploads/') === 0) ? BASE_URL . '/' . $sanPham['anh_3'] : BASE_URL . '/uploads/' . $sanPham['anh_3'] ?>" alt="Detail 3" onerror="this.src='<?= BASE_URL ?>/assets/images/hero_paddle.png'">
                                                <span style="font-size: 12px; color: #666;"><?= htmlspecialchars($sanPham['anh_3']) ?></span>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Image 4 -->
                                    <div class="adi-field-group" style="background: #fafafa; padding: 16px; border: 1px dashed #ddd;">
                                        <label class="adi-field-label" for="anh_4">Ảnh chi tiết 4 (Góc dưới bên phải)</label>
                                        <input type="file" id="anh_4" name="anh_4" accept="image/*" class="adi-field-input" style="padding: 8px;">
                                        <?php if ($mode === 'edit' && !empty($sanPham['anh_4'])): ?>
                                            <div class="adi-image-upload-preview" style="margin-top: 8px;">
                                                <img src="<?= (strpos($sanPham['anh_4'], 'assets/') === 0 || strpos($sanPham['anh_4'], 'uploads/') === 0) ? BASE_URL . '/' . $sanPham['anh_4'] : BASE_URL . '/uploads/' . $sanPham['anh_4'] ?>" alt="Detail 4" onerror="this.src='<?= BASE_URL ?>/assets/images/hero_paddle.png'">
                                                <span style="font-size: 12px; color: #666;"><?= htmlspecialchars($sanPham['anh_4']) ?></span>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <!-- Specification Section -->
                            <div style="margin-top: 32px; padding-top: 24px; border-top: 1px dashed #ccc;">
                                <h4 style="font-family: 'Oswald', sans-serif; font-size: 16px; font-weight: 700; text-transform: uppercase; margin: 0 0 20px 0; color: #000;">
                                    <i class="fa-solid fa-list-check"></i> Thông số kỹ thuật chi tiết
                                </h4>

                                <div class="adi-form-grid">
                                    <div>
                                        <div class="adi-field-group">
                                            <label class="adi-field-label" for="spec_chat_lieu">Chất liệu sản phẩm</label>
                                            <input type="text" id="spec_chat_lieu" name="spec_chat_lieu" class="adi-field-input" value="<?= htmlspecialchars($sanPham['chat_lieu'] ?? '') ?>" placeholder="Ví dụ: Carbon Fiber T700 / Fiberglass">
                                        </div>

                                        <div class="adi-field-group">
                                            <label class="adi-field-label" for="spec_do_day_loi">Độ dày lõi (mm)</label>
                                            <input type="number" step="0.1" id="spec_do_day_loi" name="spec_do_day_loi" class="adi-field-input" value="<?= htmlspecialchars($sanPham['do_day_loi'] ?? '') ?>" placeholder="Ví dụ: 16.0">
                                        </div>

                                        <div class="adi-field-group">
                                            <label class="adi-field-label" for="spec_loai_tay_cam">Loại / Kiểu tay cầm</label>
                                            <input type="text" id="spec_loai_tay_cam" name="spec_loai_tay_cam" class="adi-field-input" value="<?= htmlspecialchars($sanPham['loai_tay_cam'] ?? '') ?>" placeholder="Ví dụ: Selkirk Geo Grip Pro / Standard Cushion">
                                        </div>

                                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                                            <div class="adi-field-group">
                                                <label class="adi-field-label" for="spec_chieu_dai">Chiều dài (cm)</label>
                                                <input type="number" step="0.1" id="spec_chieu_dai" name="spec_chieu_dai" class="adi-field-input" value="<?= htmlspecialchars($sanPham['chieu_dai'] ?? '') ?>" placeholder="41.9">
                                            </div>

                                            <div class="adi-field-group">
                                                <label class="adi-field-label" for="spec_chieu_rong">Chiều rộng (cm)</label>
                                                <input type="number" step="0.1" id="spec_chieu_rong" name="spec_chieu_rong" class="adi-field-input" value="<?= htmlspecialchars($sanPham['chieu_rong'] ?? '') ?>" placeholder="19.0">
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                                            <div class="adi-field-group">
                                                <label class="adi-field-label" for="spec_chieu_dai_tay_cam">Dài tay cầm (cm)</label>
                                                <input type="number" step="0.1" id="spec_chieu_dai_tay_cam" name="spec_chieu_dai_tay_cam" class="adi-field-input" value="<?= htmlspecialchars($sanPham['chieu_dai_tay_cam'] ?? '') ?>" placeholder="12.7">
                                            </div>

                                            <div class="adi-field-group">
                                                <label class="adi-field-label" for="spec_chu_vi_tay_cam">Chu vi tay cầm (cm)</label>
                                                <input type="number" step="0.1" id="spec_chu_vi_tay_cam" name="spec_chu_vi_tay_cam" class="adi-field-input" value="<?= htmlspecialchars($sanPham['chu_vi_tay_cam'] ?? '') ?>" placeholder="10.8">
                                            </div>
                                        </div>

                                        <div class="adi-field-group">
                                            <label class="adi-field-label" for="spec_trong_luong">Trọng lượng (Gam)</label>
                                            <input type="number" step="0.1" id="spec_trong_luong" name="spec_trong_luong" class="adi-field-input" value="<?= htmlspecialchars($sanPham['trong_luong'] ?? '') ?>" placeholder="Ví dụ: 225.0">
                                        </div>

                                        <div class="adi-field-group">
                                            <label class="adi-field-label" for="spec_chung_nhan">Chứng nhận / Chuẩn thi đấu</label>
                                            <input type="text" id="spec_chung_nhan" name="spec_chung_nhan" class="adi-field-input" value="<?= htmlspecialchars($sanPham['chung_nhan'] ?? '') ?>" placeholder="Ví dụ: USAPA Approved">
                                        </div>

                                        <div class="adi-field-group">
                                            <label class="adi-field-label" for="spec_kich_thuoc">Mô tả kích thước tổng thể</label>
                                            <input type="text" id="spec_kich_thuoc" name="spec_kich_thuoc" class="adi-field-input" value="<?= htmlspecialchars($sanPham['kich_thuoc'] ?? '') ?>" placeholder="Ví dụ: Standard 16.5' x 7.5'">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- =====================================================
                                 BIẾN THỂ SẢN PHẨM
                                 ===================================================== -->
                            <div style="margin-top: 32px; padding-top: 24px; border-top: 1px dashed #ccc;">
                                <h4 style="font-family: 'Oswald', sans-serif; font-size: 16px; font-weight: 700; text-transform: uppercase; margin: 0 0 20px 0; color: #000;">
                                    <i class="fa-solid fa-sliders"></i> Tùy chọn Biến Thể Sản Phẩm
                                </h4>
                                <div class="adi-field-group">
                                    <label class="adi-field-label" for="bien_the">Các lựa chọn biến thể (Cách nhau bằng dấu phẩy)</label>
                                    <input type="text" id="bien_the" name="bien_the" class="adi-field-input" value="<?= htmlspecialchars($sanPham['bien_the'] ?? '') ?>" placeholder="VD: Đỏ, Xanh, Vàng hoặc 14mm, 16mm, 20mm">
                                    <div style="font-size:11px;color:#777;margin-top:5px;"><i class="fa-solid fa-circle-info"></i> Để trống nếu sản phẩm không có biến thể.</div>
                                </div>
                            </div>

                            <div class="adi-form-actions-bar">
                                <button type="submit" class="adi-btn-primary">
                                    <i class="fa-solid fa-floppy-disk"></i> <?= ($mode === 'edit') ? 'Cập nhật sản phẩm' : 'Lưu sản phẩm mới' ?>
                                </button>
                                <a href="index.php?act=admin_sanpham" class="adi-btn-secondary">
                                    Hủy bỏ
                                </a>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</body>
</html>
