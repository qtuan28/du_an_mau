<?php
class GioHang {

    // 1. Láº¥y danh sÃ¡ch sáº£n pháº©m trong giá» hÃ ng tá»« Session
    public function getGioHang() {
        return $_SESSION['cart'] ?? [];
    }

    // 2. ThÃªm sáº£n pháº©m vÃ o giá» hÃ ng (Chá»‰ sá»­ dá»¥ng 1 giÃ¡ bÃ¡n duy nháº¥t cá»§a sáº£n pháº©m)
    public function add($sp, $soLuong = 1) {
        $id = $sp['product_id'];

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['so_luong'] += $soLuong;
            $_SESSION['cart'][$id]['gia'] = (float)$sp['gia'];
        } else {
            $_SESSION['cart'][$id] = [
                'product_id' => $sp['product_id'],
                'ten'        => $sp['ten'],
                'gia'        => (float)$sp['gia'],
                'anh'        => $sp['anh'],
                'so_luong'   => $soLuong
            ];
        }
    }

    // 3. Cáº­p nháº­t sá»‘ lÆ°á»£ng sáº£n pháº©m
    public function updateQuantity($id, $soLuong) {
        if ($soLuong <= 0) {
            $this->deleteItem($id);
        } else if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['so_luong'] = $soLuong;
        }
    }

    // 4. XÃ³a 1 sáº£n pháº©m khá»i giá» hÃ ng
    public function deleteItem($id) {
        if (isset($_SESSION['cart'][$id])) {
            unset($_SESSION['cart'][$id]);
        }
    }

    // 5. XÃ³a toÃ n bá»™ giá» hÃ ng
    public function clear() {
        unset($_SESSION['cart']);
    }

    // 6. TÃ­nh tá»•ng tiá»n giá» hÃ ng
    public function getTongTien() {
        $tongTien = 0;
        $gioHang = $this->getGioHang();
        foreach ($gioHang as $item) {
            $tongTien += $item['gia'] * $item['so_luong'];
        }
        return $tongTien;
    }

    // 7. TÃ­nh tá»•ng sá»‘ lÆ°á»£ng sáº£n pháº©m trong giá» hÃ ng
    public function getTongSoLuong() {
        $tongSoLuong = 0;
        $gioHang = $this->getGioHang();
        foreach ($gioHang as $item) {
            $tongSoLuong += (int)($item['so_luong'] ?? 1);
        }
        return $tongSoLuong;
    }
}

