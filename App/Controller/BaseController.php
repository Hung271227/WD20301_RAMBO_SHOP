<?php
require_once __DIR__ . '/../../helpers.php';
require_once __DIR__ . '/../Model/Category.php';
require_once __DIR__ . '/../Model/Product.php';
require_once __DIR__ . '/../Model/User.php';
require_once __DIR__ . '/../Model/Cart.php';
require_once __DIR__ . '/../Model/Wishlist.php';
require_once __DIR__ . '/../Model/Coupon.php';
require_once __DIR__ . '/../Model/Order.php';
require_once __DIR__ . '/../Model/Comment.php';

// Lớp cha của các controller phía khách: nạp view + dữ liệu chung cho header
abstract class BaseController {
    protected $categoryModel, $productModel, $userModel, $cartModel, $wishModel, $couponModel, $orderModel, $commentModel;

    public function __construct() {
        $this->categoryModel = new Category();
        $this->productModel = new Product();
        $this->userModel = new User();
        $this->cartModel = new Cart();
        $this->wishModel = new Wishlist();
        $this->couponModel = new Coupon();
        $this->orderModel = new Order();
        $this->commentModel = new Comment();
        $this->refreshSession();
    }

    // Đồng bộ thông tin user từ DB mỗi request (bị khóa / đổi quyền có hiệu lực ngay)
    protected function refreshSession() {
        if (!is_logged()) return;
        $u = $this->userModel->find($_SESSION['user']['MaKH']);
        if (!$u || !$u['TrangThai']) { unset($_SESSION['user']); flash('error', 'Tài khoản của bạn đã bị khóa hoặc không còn tồn tại.'); return; }
        unset($u['MatKhau']);
        $_SESSION['user'] = $u;
    }

    protected function render($view, $data = [], $title = null) {
        extract($data);
        $pageTitle = $title ? $title . ' - RAMBO STORE' : 'RAMBO STORE - Hệ Thống LEGO Chính Hãng Số 1 Việt Nam';
        $navCats = $this->categoryModel->visible();
        $logoUrl = LOGO_URL;
        $__u = current_user();
        $cartCount = $cartTotal = $wishCount = 0; $wishIds = [];
        if ($__u) {
            $cartCount = $this->cartModel->count($__u['MaKH']);
            $cartTotal = $this->cartModel->total($__u['MaKH']);
            $wishIds = $this->wishModel->ids($__u['MaKH']);
            $wishCount = count($wishIds);
        }
        include __DIR__ . '/../View/shop/header.php';
        include __DIR__ . '/../View/shop/' . $view . '.php';
        include __DIR__ . '/../View/shop/footer.php';
    }

    protected function post() { if ($_SERVER['REQUEST_METHOD'] !== 'POST') redirect('index.php'); csrf_check(); }

    // Dùng cho các thao tác POST cần đăng nhập: quay lại trang đăng nhập rồi về lại trang cũ
    protected function needLogin() {
        if (is_logged()) return;
        flash('error', 'Vui lòng đăng nhập để thực hiện thao tác này.');
        $b = $_POST['back'] ?? 'index.php';
        redirect('index.php?page=login&next=' . urlencode($b));
    }
}
