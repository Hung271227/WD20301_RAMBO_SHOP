<?php
// ===== FRONT CONTROLLER - PHÍA KHÁCH HÀNG =====
session_set_cookie_params(['httponly' => true, 'samesite' => 'Lax']);
session_start();

// Bảng định tuyến: ?page=xxx  =>  [Controller, phương thức]  (chỉ các trang khai báo ở đây mới chạy được)
$routes = [
    'home' => ['Home', 'home'], 'product' => ['Home', 'product'], 'productdetail' => ['Home', 'productdetail'],
    'promotion' => ['Home', 'promotion'], 'newarrival' => ['Home', 'newarrival'], 'about' => ['Home', 'about'],
    'comment_add' => ['Home', 'comment_add'],
    'cart' => ['Cart', 'cart'], 'cart_add' => ['Cart', 'cart_add'], 'cart_update' => ['Cart', 'cart_update'],
    'cart_remove' => ['Cart', 'cart_remove'], 'cart_clear' => ['Cart', 'cart_clear'], 'cart_coupon' => ['Cart', 'cart_coupon'],
    'checkout' => ['Cart', 'checkout'], 'thankyou' => ['Cart', 'thankyou'],
    'wishlist' => ['Cart', 'wishlist'], 'wishlist_toggle' => ['Cart', 'wishlist_toggle'],
    'login' => ['Auth', 'login'], 'register' => ['Auth', 'register'], 'logout' => ['Auth', 'logout'],
    'account' => ['Account', 'account'], 'history' => ['Account', 'history'],
    'orderdetail' => ['Account', 'orderdetail'], 'order_cancel' => ['Account', 'order_cancel'],
];

$page = $_GET['page'] ?? 'home';
if (!isset($routes[$page])) { http_response_code(404); $page = 'home'; }
[$name, $method] = $routes[$page];

require_once 'App/Controller/' . $name . 'Controller.php';
$class = $name . 'Controller';
(new $class())->$method();
