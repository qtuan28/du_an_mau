<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    
    <title>Quản lý Danh mục</title>

    <link rel="stylesheet" href="assets/css/admin.css">
</head>

<body>

<div class="container">

    <h1>QUẢN LÝ DANH MỤC</h1>

    <?php
    if(isset($_SESSION['success'])){
        echo "<div class='success'>".$_SESSION['success']."</div>";
        unset($_SESSION['success']);
    }

    if(isset($_SESSION['error'])){
        echo "<div class='error'>".$_SESSION['error']."</div>";
        unset($_SESSION['error']);
    }
    ?>

    <div class="top-bar">

        <form method="GET" action="index.php">

            <input type="hidden" name="act" value="admin_danhmuc_search">

            <input
                type="text"
                name="keyword"
                placeholder="Nhập tên danh mục..."
            >

            <button>Tìm kiếm</button>

        </form>

    </div>

    <hr>

    <h3>Thêm danh mục</h3>

    <form class="add-form" method="POST"
        action="index.php?act=admin_danhmuc_add">

        <input
            type="text"
            name="name"
            placeholder="Tên danh mục"
            required
        >

        <button type="submit">
            Thêm
        </button>

    </form>

    <hr>

    <table class="table">

        <thead>

        <tr>

            <th>ID</th>

            <th>Tên danh mục</th>

            <th>Thao tác</th>

        </tr>

        </thead>

        <tbody>

        <?php foreach($dsDanhMuc as $dm): ?>

            <tr>

                <td><?= $dm['category_id'] ?></td>

                <td><?= htmlspecialchars($dm['name']) ?></td>

                <td>

                    <form
                        action="index.php?act=admin_danhmuc_edit"
                        method="POST"
                        style="display:inline"
                    >

                        <input
                            type="hidden"
                            name="category_id"
                            value="<?= $dm['category_id'] ?>"
                        >

                        <input
                            type="text"
                            name="name"
                            value="<?= htmlspecialchars($dm['name']) ?>"
                        >

                        <button>Lưu</button>

                    </form>

                    <a
                        href="index.php?act=admin_danhmuc_delete&id=<?= $dm['category_id'] ?>"
                        onclick="return confirm('Bạn có chắc muốn xóa?')"
                    >
                        Xóa
                    </a>

                </td>

            </tr>

        <?php endforeach; ?>

        </tbody>

    </table>

</div>

</body>

</html>