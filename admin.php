<?php
// ===== FRONT CONTROLLER - KHU VỰC QUẢN TRỊ =====
session_set_cookie_params(['httponly' => true, 'samesite' => 'Lax']);
session_start();
require_once 'helpers.php';
require_once 'App/Model/Database.php';

// Phải đăng nhập và có vai trò admin (đọc lại từ DB để quyền/khóa tài khoản có hiệu lực ngay)
if (is_logged()) {
    $row = (new Database())->getOne("SELECT MaKH,HoTen,Email,VaiTro,TrangThai FROM khach_hang WHERE MaKH=?", [$_SESSION['user']['MaKH']]);
    if (!$row || !$row['TrangThai']) unset($_SESSION['user']); else $_SESSION['user'] = array_merge($_SESSION['user'], $row);
}
if (!is_logged()) { flash('error', 'Vui lòng đăng nhập tài khoản quản trị.'); redirect('index.php?page=login&next=' . urlencode('admin.php')); }
if (!is_admin()) { flash('error', 'Bạn không có quyền truy cập khu vực quản trị.'); redirect('index.php'); }

$routes = ['dashboard', 'category', 'product', 'user', 'order', 'orderdetail', 'coupon', 'comment'];
$page = $_GET['page'] ?? 'dashboard';
if (!in_array($page, $routes, true)) $page = 'dashboard';

require_once 'App/Controller/AdminController.php';
(new AdminController())->$page();
