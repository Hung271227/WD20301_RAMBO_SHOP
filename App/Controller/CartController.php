<?php
require_once 'BaseController.php';
// Giỏ hàng, mã giảm giá, thanh toán, yêu thích
class CartController extends BaseController {

    private function totals($items) {
        $sub = 0; foreach ($items as $it) $sub += $it['DonGia'] * $it['SoLuong'];
        $coupon = null; $couponErr = null; $discount = 0;
        if (!empty($_SESSION['coupon'])) {
            [$coupon, $couponErr] = $this->couponModel->validate($_SESSION['coupon'], $sub);
            if ($coupon) $discount = Coupon::amount($coupon, $sub); else unset($_SESSION['coupon']);
        }
        $ship = ($sub - $discount >= SHIP_FREE_FROM || $sub == 0) ? 0 : SHIP_FEE;
        return ['sub' => $sub, 'coupon' => $coupon, 'couponErr' => $couponErr, 'discount' => $discount, 'ship' => $ship, 'total' => $sub - $discount + $ship];
    }

    public function cart() {
        require_login();
        $items = $this->cartModel->items(current_user()['MaKH']);
        $t = $this->totals($items);
        if (!empty($t['couponErr'])) flash('error', $t['couponErr']);
        $this->render('cart', ['items' => $items, 't' => $t, 'suggest' => $this->productModel->bestSellers(4)], 'Giỏ hàng');
    }

    public function cart_add() {
        $this->post(); $this->needLogin();
        $sp = (int)($_POST['id'] ?? 0); $qty = max(1, (int)($_POST['qty'] ?? 1));
        $r = $this->cartModel->add(current_user()['MaKH'], $sp, $qty);
        if ($r !== true) flash(is_string($r) && strpos($r, 'Đã thêm') === 0 ? 'success' : 'error', $r);
        else flash('success', 'Đã thêm sản phẩm vào giỏ hàng.');
        if (!empty($_POST['buy_now']) && ($r === true || strpos((string)$r, 'Đã thêm') === 0)) redirect('index.php?page=checkout');
        redirect_back('index.php?page=cart');
    }

    public function cart_update() {
        $this->post(); $this->needLogin();
        $this->cartModel->setQty(current_user()['MaKH'], (int)$_POST['id'], (int)$_POST['qty']);
        redirect('index.php?page=cart');
    }
    public function cart_remove() {
        $this->post(); $this->needLogin();
        $this->cartModel->remove(current_user()['MaKH'], (int)$_POST['id']);
        flash('success', 'Đã xóa sản phẩm khỏi giỏ hàng.');
        redirect('index.php?page=cart');
    }
    public function cart_clear() {
        $this->post(); $this->needLogin();
        $this->cartModel->clear(current_user()['MaKH']);
        unset($_SESSION['coupon']);
        redirect('index.php?page=cart');
    }

    // Áp dụng / gỡ mã giảm giá
    public function cart_coupon() {
        $this->post(); $this->needLogin();
        if (!empty($_POST['remove'])) { unset($_SESSION['coupon']); flash('success', 'Đã gỡ mã giảm giá.'); }
        else {
            $code = strtoupper(trim($_POST['code'] ?? ''));
            $sub = $this->cartModel->total(current_user()['MaKH']);
            [$c, $err] = $this->couponModel->validate($code, $sub);
            if ($c) { $_SESSION['coupon'] = $c['Code']; flash('success', 'Áp dụng mã ' . $c['Code'] . ' thành công: ' . Coupon::label($c) . '.'); }
            else flash('error', $err);
        }
        redirect_back('index.php?page=cart');
    }

    public function checkout() {
        require_login();
        $u = current_user(); $kh = $u['MaKH'];
        $items = $this->cartModel->items($kh);
        if (!$items) { flash('error', 'Giỏ hàng đang trống.'); redirect('index.php?page=cart'); }
        $t = $this->totals($items);
        $errors = [];
        $old = ['ten' => $u['HoTen'], 'sdt' => $u['Sdt'], 'diachi' => $u['DiaChi'], 'ghichu' => '', 'pt' => 'COD'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            csrf_check();
            $old = ['ten' => trim($_POST['ten'] ?? ''), 'sdt' => preg_replace('/\s+/', '', $_POST['sdt'] ?? ''),
                    'diachi' => trim($_POST['diachi'] ?? ''), 'ghichu' => trim($_POST['ghichu'] ?? ''), 'pt' => $_POST['pt'] ?? 'COD'];
            if (mb_strlen($old['ten']) < 2) $errors[] = 'Vui lòng nhập họ tên người nhận.';
            if (!preg_match('/^0\d{9}$/', $old['sdt'])) $errors[] = 'Số điện thoại phải gồm 10 chữ số, bắt đầu bằng 0.';
            if (mb_strlen($old['diachi']) < 8) $errors[] = 'Vui lòng nhập địa chỉ giao hàng đầy đủ.';
            if (!isset(PAY_METHODS[$old['pt']])) $errors[] = 'Phương thức thanh toán không hợp lệ.';
            foreach ($items as $it) {
                if (!$it['TrangThai'] || $it['SoLuongTonKho'] < $it['SoLuong'])
                    $errors[] = '"' . $it['TenSP'] . '" chỉ còn ' . max(0, $it['SoLuongTonKho']) . ' sản phẩm trong kho - vui lòng cập nhật giỏ hàng.';
            }
            if (!$errors) {
                try {
                    $id = $this->orderModel->create($kh, ['ten' => $old['ten'], 'sdt' => $old['sdt'], 'diachi' => $old['diachi'], 'ghichu' => mb_substr($old['ghichu'], 0, 250), 'pt' => $old['pt']],
                        $items, $t['coupon'], $t['sub'] + $t['ship'], $t['discount']);
                    unset($_SESSION['coupon']);
                    if (!$u['DiaChi'] || !$u['Sdt']) $this->userModel->updateProfile($kh, $u['HoTen'], $u['Sdt'] ?: $old['sdt'], $u['DiaChi'] ?: $old['diachi'], $u['GioiTinh'], $u['Ngaysinh']);
                    redirect('index.php?page=thankyou&id=' . $id);
                } catch (Exception $ex) { $errors[] = $ex->getMessage(); }
            }
        }
        $this->render('checkout', ['items' => $items, 't' => $t, 'errors' => $errors, 'old' => $old], 'Thanh toán');
    }

    public function thankyou() {
        require_login();
        $o = $this->orderModel->find((int)($_GET['id'] ?? 0));
        if (!$o || $o['MaKH'] != current_user()['MaKH']) redirect('index.php');
        $this->render('thankyou', ['o' => $o, 'details' => $this->orderModel->details($o['MaDH'])], 'Đặt hàng thành công');
    }

    // ===== Yêu thích =====
    public function wishlist() {
        require_login();
        $this->render('wishlist', ['items' => $this->productModel->wishlistOf(current_user()['MaKH'])], 'Sản phẩm yêu thích');
    }
    public function wishlist_toggle() {
        $this->post(); $this->needLogin();
        $sp = (int)($_POST['id'] ?? 0);
        if ($this->productModel->visibleById($sp)) {
            $added = $this->wishModel->toggle(current_user()['MaKH'], $sp);
            flash('success', $added ? 'Đã thêm vào danh sách yêu thích.' : 'Đã bỏ khỏi danh sách yêu thích.');
        }
        redirect_back('index.php?page=wishlist');
    }
}
