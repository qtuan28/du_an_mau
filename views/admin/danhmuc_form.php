<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= ($mode === 'edit') ? 'Sửa Danh Mục' : 'Thêm Danh Mục Mới' ?> | Admin Panel</title>
    <link rel="stylesheet" href="assets/css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .adi-form-card {
            background: #fff;
            padding: 30px;
            border: 1px solid #ebedee;
            max-width: 650px;
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
                        <h1 class="adi-page-title"><?= ($mode === 'edit') ? 'CẬP NHẬT DANH MỤC' : 'THÊM DANH MỤC MỚI' ?></h1>
                        <div class="adi-breadcrumb">
                            <a href="index.php?act=admin"><i class="fa-solid fa-house"></i> Trang chủ</a> > 
                            <a href="index.php?act=admin_danhmuc">Quản lý Danh mục</a> > 
                            <?= ($mode === 'edit') ? 'Chỉnh sửa' : 'Thêm mới' ?>
                        </div>
                    </div>
                    <a href="index.php?act=admin_danhmuc" class="adi-btn-secondary">
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
                <div class="adi-box" style="max-width: 700px;">
                    <div class="adi-box-header">
                        <h3 style="font-family: 'Oswald', sans-serif; font-size: 16px; font-weight: 700; text-transform: uppercase; margin: 0;">
                            <i class="fa-solid fa-layer-group"></i> Thông tin danh mục
                        </h3>
                    </div>

                    <div class="adi-form-card">
                        <form method="POST" action="index.php?act=<?= ($mode === 'edit') ? 'admin_danhmuc_edit' : 'admin_danhmuc_add' ?>">

                            <?php if ($mode === 'edit'): ?>
                                <input type="hidden" name="category_id" value="<?= $danhMuc['category_id'] ?>">
                            <?php endif; ?>

                            <div class="adi-field-group">
                                <label class="adi-field-label" for="name">Tên danh mục <span class="req">*</span></label>
                                <input
                                    type="text"
                                    id="name"
                                    name="name"
                                    class="adi-field-input"
                                    value="<?= htmlspecialchars($danhMuc['name'] ?? '') ?>"
                                    placeholder="Ví dụ: Vợt Pickleball"
                                    required
                                    autofocus
                                >
                            </div>

                            <div class="adi-field-group">
                                <label class="adi-field-label" for="trang_thai">Trạng thái hoạt động</label>
                                <select id="trang_thai" name="trang_thai" class="adi-field-input">
                                    <option value="1" <?= (isset($danhMuc['trang_thai']) && $danhMuc['trang_thai'] == 1) ? 'selected' : '' ?>>
                                        🟢 Hoạt động (Hiển thị)
                                    </option>
                                    <option value="0" <?= (isset($danhMuc['trang_thai']) && $danhMuc['trang_thai'] == 0) ? 'selected' : '' ?>>
                                        🔴 Tạm ngưng (Ẩn)
                                    </option>
                                </select>
                            </div>

                            <?php if ($mode === 'edit' && !empty($danhMuc['ngay_tao'])): ?>
                                <div class="adi-field-group">
                                    <label class="adi-field-label">Ngày khởi tạo</label>
                                    <input
                                        type="text"
                                        value="<?= date('d/m/Y H:i:s', strtotime($danhMuc['ngay_tao'])) ?>"
                                        readonly
                                        class="adi-field-input"
                                        style="background: #f5f5f5; color: #777;"
                                    >
                                </div>
                            <?php endif; ?>

                            <div class="adi-form-actions-bar">
                                <button type="submit" class="adi-btn-primary">
                                    <i class="fa-solid fa-floppy-disk"></i> <?= ($mode === 'edit') ? 'Cập nhật danh mục' : 'Lưu danh mục mới' ?>
                                </button>
                                <a href="index.php?act=admin_danhmuc" class="adi-btn-secondary">
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
