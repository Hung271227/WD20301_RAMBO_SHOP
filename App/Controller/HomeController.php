<?php
require_once 'BaseController.php';
// Các trang xem sản phẩm / nội dung
class HomeController extends BaseController {
    const PER_PAGE = 12;

    public function home() {
        $this->render('home', [
            'categories' => $this->categoryModel->visible(),
            'newest' => $this->productModel->newest(4),
            'sale' => $this->productModel->onSale(4),
            'best' => $this->productModel->bestSellers(8),
        ]);
    }

    public function product() {
        $f = [
            'q' => trim($_GET['q'] ?? ''),
            'cat' => array_values(array_filter((array)($_GET['cat'] ?? []), 'strlen')),
            'min' => (int)($_GET['min'] ?? 0), 'max' => (int)($_GET['max'] ?? 0),
            'age' => (array)($_GET['age'] ?? []), 'pieces' => (array)($_GET['pieces'] ?? []),
            'sale' => !empty($_GET['sale']), 'instock' => !empty($_GET['instock']),
            'sort' => $_GET['sort'] ?? 'new',
        ];
        $page = max(1, (int)($_GET['p'] ?? 1));
        $total = $this->productModel->countSearch($f);
        $pages = max(1, (int)ceil($total / self::PER_PAGE));
        $page = min($page, $pages);
        $items = $this->productModel->search($f, self::PER_PAGE, ($page - 1) * self::PER_PAGE);
        $this->render('product', [
            'f' => $f, 'items' => $items, 'total' => $total, 'page' => $page, 'pages' => $pages,
            'categories' => $this->categoryModel->visible(), 'perPage' => self::PER_PAGE,
        ], 'Tất cả sản phẩm');
    }

    public function productdetail() {
        $id = (int)($_GET['id'] ?? 0);
        $p = $this->productModel->visibleById($id);
        if (!$p) { http_response_code(404); flash('error', 'Không tìm thấy sản phẩm.'); redirect('index.php?page=product'); }
        $this->render('productdetail', [
            'p' => $p,
            'comments' => $this->commentModel->forProduct($id),
            'related' => $this->productModel->related($id, $p['MaDM']),
        ], $p['TenSP']);
    }

    public function promotion() {
        $this->render('promotion', [
            'sale' => $this->productModel->onSale(12),
            'coupons' => $this->couponModel->active(),
        ], 'Khuyến mãi Hot');
    }

    public function newarrival() {
        $items = $this->productModel->newest(12, 30);          // bộ mới trong 30 ngày
        if (count($items) < 4) $items = $this->productModel->newest(8);   // chưa đủ thì lấy 8 bộ mới nhất
        $this->render('newarrival', ['items' => $items], 'Bộ mới về');
    }

    public function about() { $this->render('about', [], 'Giới thiệu & Cửa hàng'); }

    // Bình luận (cần đăng nhập)
    public function comment_add() {
        $this->post(); $this->needLogin();
        $sp = (int)($_POST['MaSP'] ?? 0);
        $nd = trim($_POST['noidung'] ?? ''); $sao = (int)($_POST['sao'] ?? 5);
        if (!$this->productModel->visibleById($sp)) redirect('index.php');
        if (mb_strlen($nd) < 5) flash('error', 'Nội dung bình luận quá ngắn (tối thiểu 5 ký tự).');
        else {
            $this->commentModel->add(current_user()['MaKH'], $sp, mb_substr($nd, 0, 1000), max(1, min(5, $sao)));
            flash('success', 'Cảm ơn bạn đã gửi đánh giá!');
        }
        redirect('index.php?page=productdetail&id=' . $sp . '#reviews');
    }
}
