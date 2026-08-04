<?php
session_start();
require_once 'controller/controller.php';

$sp_controller = new pickleballController();
$act = $_GET['act'] ?? 'index';

switch ($act) {
    // --- KHÁCH / NGƯỜI DÙNG ---
    case 'index':
        $sp_controller->trangChu();
        break;
    case 'login':
        $sp_controller->formLogin();
        break;
    case 'post_login':
        $sp_controller->postLogin();
        break;
    case 'register':
        $sp_controller->formRegister();
        break;
    case 'post_register':
        $sp_controller->postRegister();
        break;
    case 'logout':
        $sp_controller->logout();
        break;
    case 'sanpham_chitiet':
    case 'chitiet':
        $sp_controller->chiTietSanPham();
        break;
    case 'timkiem':
        $sp_controller->timKiemSanPham();
        break;
    case 'danhmuc':
        $sp_controller->xemDanhMuc();
        break;

    // --- GIỎ HÀNG & ĐƠN HÀNG ---
    case 'add_giohang':
        $sp_controller->themGioHang();
        break;
    case 'giohang':
        $sp_controller->xemGioHang();
        break;
    case 'update_giohang':
        $sp_controller->capNhatGioHang();
        break;
    case 'delete_giohang':
        $sp_controller->xoaGioHang();
        break;
    case 'thanhtoan':
        $sp_controller->thanhToan();
        break;
    case 'post_thanhtoan':
        $sp_controller->postThanhToan();
        break;
    case 'updateProfile':
        $sp_controller->capNhatHoSo();
        break;
    case 'profile':
    case 'lichsu_donhang':
        $sp_controller->hoSoCaNhan();
        break;

    // --- ADMIN: TRANG CHỦ ---
    case 'admin':
        $sp_controller->trangAdmin();
        break;

    // --- ADMIN: QUẢN LÝ DANH MỤC ---
    case 'admin_danhmuc':
        $sp_controller->adminQuanLyDanhMuc();
        break;
    case 'admin_danhmuc_add':
        $sp_controller->adminThemDanhMuc();
        break;
    case 'admin_danhmuc_edit':
        $sp_controller->adminSuaDanhMuc();
        break;
    case 'admin_danhmuc_delete':
        $sp_controller->adminXoaDanhMuc();
        break;
    case 'admin_danhmuc_search':
        $sp_controller->adminTimKiemDanhMuc();
        break;

    // --- ADMIN: QUẢN LÝ SẢN PHẨM ---
    case 'admin_sanpham':
        $sp_controller->adminQuanLySanPham();
        break;
    case 'admin_sanpham_add':
        $sp_controller->adminThemSanPham();
        break;
    case 'admin_sanpham_edit':
        $sp_controller->adminSuaSanPham();
        break;
    case 'admin_sanpham_delete':
        $sp_controller->adminXoaSanPham();
        break;
    case 'admin_sanpham_search':
        $sp_controller->adminTimKiemSanPham();
        break;

    // --- ADMIN: QUẢN LÝ NGƯỜI DÙNG ---
    case 'admin_nguoidung':
        $sp_controller->adminQuanLyNguoiDung();
        break;
    case 'admin_nguoidung_delete':
        $sp_controller->adminXoaNguoiDung();
        break;

    // --- ADMIN: THỐNG KÊ SỐ LIỆU ---
    case 'admin_thongke':
        $sp_controller->adminThongKe();
        break;

    default:
        $sp_controller->trangChu();
        break;
}