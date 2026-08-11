<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= ($mode === 'edit') ? 'Sửa Sản Phẩm' : 'Thêm Sản Phẩm Mới' ?> | Admin Panel</title>
    <link rel="stylesheet" href="assets/css/admin.css">
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
                                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                                        <div class="adi-field-group">
                                            <label class="adi-field-label" for="gia">Giá bán gốc (VNĐ) <span class="req">*</span></label>
                                            <input
                                                type="number"
                                                id="gia"
                                                name="gia"
                                                class="adi-field-input"
                                                value="<?= htmlspecialchars($sanPham['gia'] ?? '') ?>"
                                                placeholder="Ví dụ: 2500000"
                                                min="0"
                                                step="1000"
                                                required
                                            >
                                        </div>

                                        <div class="adi-field-group">
                                            <label class="adi-field-label" for="giam_gia">Giảm giá (%)</label>
                                            <input
                                                type="number"
                                                id="giam_gia"
                                                name="giam_gia"
                                                class="adi-field-input"
                                                value="<?= htmlspecialchars($sanPham['giam_gia'] ?? 0) ?>"
                                                placeholder="0 - 100"
                                                min="0"
                                                max="100"
                                            >
                                        </div>
                                    </div>

                                    <div class="adi-field-group">
                                        <label class="adi-field-label" for="anh">Hình ảnh sản phẩm</label>
                                        <input type="file" id="anh" name="anh" accept="image/*" class="adi-field-input" style="padding: 10px;">
                                        <?php if ($mode === 'edit' && !empty($sanPham['anh'])): ?>
                                            <div class="adi-image-upload-preview">
                                                <img src="<?= (strpos($sanPham['anh'], 'assets/') === 0) ? $sanPham['anh'] : 'assets/images/' . $sanPham['anh'] ?>"
                                                     alt="Thumbnail"
                                                     onerror="this.src='assets/images/hero_paddle.png'">
                                                <div>
                                                    <span style="font-family: 'Roboto', sans-serif; font-size: 12px; color: #666; display: block;">Ảnh hiện tại:</span>
                                                    <strong style="font-family: 'Roboto', sans-serif; font-size: 13px; color: #000;"><?= htmlspecialchars($sanPham['anh']) ?></strong>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
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
