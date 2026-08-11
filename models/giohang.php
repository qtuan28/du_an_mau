<?php
class GioHang {

    // 1. Lấy danh sách sản phẩm trong giỏ hàng từ Session
    public function getGioHang() {
        return $_SESSION['cart'] ?? [];
    }

    // 2. Thêm sản phẩm vào giỏ hàng (nếu đã có thì cộng dồn số lượng)
    public function add($sp, $soLuong = 1) {
        $id = $sp['product_id'];

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['so_luong'] += $soLuong;
        } else {
            $_SESSION['cart'][$id] = [
                'product_id' => $sp['product_id'],
                'ten'        => $sp['ten'],
                'gia'        => $sp['gia'],
                'anh'        => $sp['anh'],
                'so_luong'   => $soLuong
            ];
        }
    }

    // 3. Cập nhật số lượng sản phẩm
    public function updateQuantity($id, $soLuong) {
        if ($soLuong <= 0) {
            $this->deleteItem($id);
        } else if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['so_luong'] = $soLuong;
        }
    }

    // 4. Xóa 1 sản phẩm khỏi giỏ hàng
    public function deleteItem($id) {
        if (isset($_SESSION['cart'][$id])) {
            unset($_SESSION['cart'][$id]);
        }
    }

    // 5. Xóa toàn bộ giỏ hàng
    public function clear() {
        unset($_SESSION['cart']);
    }

    // 6. Tính tổng tiền giỏ hàng
    public function getTongTien() {
        $tongTien = 0;
        $gioHang = $this->getGioHang();
        foreach ($gioHang as $item) {
            $tongTien += $item['gia'] * $item['so_luong'];
        }
        return $tongTien;
    }

    // 7. Tính tổng số lượng sản phẩm trong giỏ hàng
    public function getTongSoLuong() {
        $tongSoLuong = 0;
        $gioHang = $this->getGioHang();
        foreach ($gioHang as $item) {
            $tongSoLuong += (int)($item['so_luong'] ?? 1);
        }
        return $tongSoLuong;
    }
}

