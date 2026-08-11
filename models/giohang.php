<?php
class GioHang {

    // 1. Lấy danh sách sản phẩm trong giỏ hàng từ Session
    public function getGioHang() {
        return $_SESSION['cart'] ?? [];
    }

    // 2. Thêm sản phẩm vào giỏ hàng (Áp dụng giá sau giảm thực tế nếu có giảm giá %)
    public function add($sp, $soLuong = 1) {
        $id = $sp['product_id'];

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        $giaGoc = (float)$sp['gia'];
        $giamGia = (int)($sp['giam_gia'] ?? 0);
        $giaThucTe = $giamGia > 0 ? round($giaGoc * (1 - $giamGia / 100)) : $giaGoc;

        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['so_luong'] += $soLuong;
            $_SESSION['cart'][$id]['gia'] = $giaThucTe;
            $_SESSION['cart'][$id]['gia_goc'] = $giaGoc;
            $_SESSION['cart'][$id]['giam_gia'] = $giamGia;
        } else {
            $_SESSION['cart'][$id] = [
                'product_id' => $sp['product_id'],
                'ten'        => $sp['ten'],
                'gia_goc'    => $giaGoc,
                'giam_gia'   => $giamGia,
                'gia'        => $giaThucTe,
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

