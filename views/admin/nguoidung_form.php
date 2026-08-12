<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php 
        if ($mode === 'add') echo "ThÃªm NgÆ°á»i DÃ¹ng Má»›i";
        elseif ($mode === 'edit') echo "Sá»­a ThÃ´ng Tin & PhÃ¢n Quyá»n";
        elseif ($mode === 'reset_pass') echo "Äáº·t Láº¡i Máº­t Kháº©u";
        ?> | Admin Panel
    </title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .adi-form-card {
            background: #fff;
            padding: 30px;
            border: 1px solid #ebedee;
            max-width: 750px;
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

        .adi-field-input:disabled {
            background-color: #f5f5f5;
            color: #777;
            cursor: not-allowed;
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
                    <a href="index.php?act=logout" class="adi-header-link" style="color: #dc3545;" title="ÄÄƒng xuáº¥t"><i class="fa-solid fa-power-off"></i></a>
                </div>
            </header>

            <!-- Page Content -->
            <div class="adi-content-wrapper">
                
                <!-- Page Header & Breadcrumb -->
                <div class="adi-content-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
                    <div>
                        <h1 class="adi-page-title">
                            <?php 
                            if ($mode === 'add') echo "THÃŠM NGÆ¯á»œI DÃ™NG Má»šI";
                            elseif ($mode === 'edit') echo "Sá»¬A THÃ”NG TIN & PHÃ‚N QUYá»€N";
                            elseif ($mode === 'reset_pass') echo "Äáº¶T Láº I Máº¬T KHáº¨U";
                            ?>
                        </h1>
                        <div class="adi-breadcrumb">
                            <a href="index.php?act=admin"><i class="fa-solid fa-house"></i> Trang chá»§</a> > 
                            <a href="index.php?act=admin_nguoidung">Quáº£n lÃ½ NgÆ°á»i dÃ¹ng</a> > 
                            <?php 
                            if ($mode === 'add') echo "ThÃªm má»›i";
                            elseif ($mode === 'edit') echo "Chá»‰nh sá»­a";
                            elseif ($mode === 'reset_pass') echo "Äá»•i máº­t kháº©u";
                            ?>
                        </div>
                    </div>
                    <a href="index.php?act=admin_nguoidung" class="adi-btn-secondary">
                        <i class="fa-solid fa-arrow-left"></i> Quay láº¡i danh sÃ¡ch
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
                <div class="adi-box" style="max-width: 750px;">
                    <div class="adi-box-header">
                        <h3 style="font-family: 'Oswald', sans-serif; font-size: 16px; font-weight: 700; text-transform: uppercase; margin: 0;">
                            <i class="fa-solid fa-user-gear"></i> 
                            <?php 
                            if ($mode === 'add') echo "Táº¡o tÃ i khoáº£n ngÆ°á»i dÃ¹ng má»›i";
                            elseif ($mode === 'edit') echo "Cáº­p nháº­t thÃ´ng tin: " . htmlspecialchars($user['username'] ?? '');
                            elseif ($mode === 'reset_pass') echo "Äáº·t láº¡i máº­t kháº©u cho: " . htmlspecialchars($user['username'] ?? '');
                            ?>
                        </h3>
                    </div>

                    <div class="adi-form-card">
                        <?php if ($mode === 'add'): ?>
                            <form action="index.php?act=admin_nguoidung_add" method="POST">
                                <div class="adi-field-group">
                                    <label class="adi-field-label" for="username">TÃªn Ä‘Äƒng nháº­p <span class="req">*</span></label>
                                    <input type="text" id="username" name="username" class="adi-field-input" required placeholder="Nháº­p tÃªn Ä‘Äƒng nháº­p..." autofocus>
                                </div>

                                <div class="adi-field-group">
                                    <label class="adi-field-label" for="password">Máº­t kháº©u <span class="req">*</span></label>
                                    <input type="password" id="password" name="password" class="adi-field-input" required placeholder="Nháº­p máº­t kháº©u...">
                                </div>

                                <div class="adi-field-group">
                                    <label class="adi-field-label" for="email">Email <span class="req">*</span></label>
                                    <input type="email" id="email" name="email" class="adi-field-input" required placeholder="Nháº­p email...">
                                </div>

                                <div class="adi-field-group">
                                    <label class="adi-field-label" for="address">Sá» Äiá»‡n Thoáº¡i</label>
                                    <input type="tel" id="sdt" name="sdt" class="adi-field-input" placeholder="Nháº­p sá»‘ Ä‘iá»‡n thoáº¡i (9-11 chá»¯ sá»‘)..." pattern="[0-9]{9,11}" title="Sá»‘ Ä‘iá»‡n thoáº¡i pháº£i cÃ³ 9-11 chá»¯ sá»‘">
                                </div>

                                <div class="adi-field-group">
                                    <label class="adi-field-label" for="address">Äá»‹a chá»‰</label>
                                    <input type="text" id="address" name="address" class="adi-field-input" placeholder="Nháº­p Ä‘á»‹a chá»‰ nháº­n hÃ ng...">
                                </div>

                                <div class="adi-field-group">
                                    <label class="adi-field-label" for="vai_tro_id">Vai trÃ² (PhÃ¢n quyá»n há»‡ thá»‘ng) <span class="req">*</span></label>
                                    <select id="vai_tro_id" name="vai_tro_id" class="adi-field-input">
                                        <option value="2">User (KhÃ¡ch hÃ ng)</option>
                                        <option value="1">Admin (Quáº£n trá»‹ viÃªn)</option>
                                    </select>
                                </div>

                                <div class="adi-form-actions-bar">
                                    <button type="submit" class="adi-btn-primary">
                                        <i class="fa-solid fa-floppy-disk"></i> LÆ°u ngÆ°á»i dÃ¹ng
                                    </button>
                                    <a href="index.php?act=admin_nguoidung" class="adi-btn-secondary">Há»§y bá»</a>
                                </div>
                            </form>

                        <?php elseif ($mode === 'edit'): ?>
                            <form action="index.php?act=admin_nguoidung_edit" method="POST">
                                <input type="hidden" name="user_id" value="<?= $user['user_id'] ?>">

                                <div class="adi-field-group">
                                    <label class="adi-field-label">TÃªn Ä‘Äƒng nháº­p</label>
                                    <input type="text" class="adi-field-input" value="<?= htmlspecialchars($user['username']) ?>" disabled>
                                    <span style="font-size: 12px; color: #767677; margin-top: 4px; display: block;">(KhÃ´ng thá»ƒ sá»­a tÃªn Ä‘Äƒng nháº­p)</span>
                                </div>

                                <div class="adi-field-group">
                                    <label class="adi-field-label" for="email">Email <span class="req">*</span></label>
                                    <input type="email" id="email" name="email" class="adi-field-input" value="<?= htmlspecialchars($user['email']) ?>" required>
                                </div>

                                <div class="adi-field-group">
                                    <label class="adi-field-label" for="sdt">Sá» Äiá»‡n Thoáº¡i</label>
                                    <input type="tel" id="sdt" name="sdt" class="adi-field-input" value="<?= htmlspecialchars($user['sdt'] ?? '') ?>" placeholder="Nháº­p sá»‘ Ä‘iá»‡n thoáº¡i..." pattern="[0-9]{9,11}" title="Sá»‘ Ä‘iá»‡n thoáº¡i pháº£i cÃ³ 9-11 chá»¯ sá»‘">
                                </div>

                                <div class="adi-field-group">
                                    <label class="adi-field-label" for="address">Äá»‹a chá»‰</label>
                                    <input type="text" id="address" name="address" class="adi-field-input" value="<?= htmlspecialchars($user['address'] ?? '') ?>">
                                </div>

                                <div class="adi-field-group">
                                    <label class="adi-field-label" for="vai_tro_id">Vai trÃ² (PhÃ¢n quyá»n há»‡ thá»‘ng)</label>
                                    <select id="vai_tro_id" name="vai_tro_id" class="adi-field-input">
                                        <option value="2" <?= $user['vai_tro_id'] == 2 ? 'selected' : '' ?>>User (KhÃ¡ch hÃ ng)</option>
                                        <option value="1" <?= $user['vai_tro_id'] == 1 ? 'selected' : '' ?>>Admin (Quáº£n trá»‹ viÃªn)</option>
                                    </select>
                                </div>

                                <div class="adi-form-actions-bar">
                                    <button type="submit" class="adi-btn-primary">
                                        <i class="fa-solid fa-floppy-disk"></i> Cáº­p nháº­t thÃ´ng tin
                                    </button>
                                    <a href="index.php?act=admin_nguoidung" class="adi-btn-secondary">Há»§y bá»</a>
                                </div>
                            </form>

                        <?php elseif ($mode === 'reset_pass'): ?>
                            <form action="index.php?act=admin_nguoidung_reset_pass" method="POST">
                                <input type="hidden" name="user_id" value="<?= $user['user_id'] ?>">

                                <div class="adi-field-group">
                                    <label class="adi-field-label" for="new_password">Máº­t kháº©u má»›i <span class="req">*</span></label>
                                    <input type="password" id="new_password" name="new_password" class="adi-field-input" required placeholder="Nháº­p máº­t kháº©u má»›i..." autofocus>
                                </div>

                                <div class="adi-form-actions-bar">
                                    <button type="submit" class="adi-btn-primary">
                                        <i class="fa-solid fa-key"></i> XÃ¡c nháº­n Ä‘á»•i máº­t kháº©u
                                    </button>
                                    <a href="index.php?act=admin_nguoidung" class="adi-btn-secondary">Há»§y bá»</a>
                                </div>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</body>
</html>
