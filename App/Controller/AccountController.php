<?php
require_once 'BaseController.php';
// Tài khoản, lịch sử đơn hàng
class AccountController extends BaseController {

    public function account() {
        require_login();
        $u = current_user(); $errors = []; $pwErrors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            csrf_check();
            if (($_POST['action'] ?? '') === 'profile') {
                $ten = trim($_POST['ten'] ?? ''); $sdt = preg_replace('/\s+/', '', $_POST['sdt'] ?? '');
                $dc = trim($_POST['diachi'] ?? ''); $gt = $_POST['gioitinh'] ?? '';
                $ns = $_POST['ngaysinh'] ?? '';
                if (mb_strlen($ten) < 2) $errors[] = 'Vui lòng nhập họ và tên.';
                if (!preg_match('/^0\d{9}$/', $sdt)) $errors[] = 'Số điện thoại phải gồm 10 chữ số, bắt đầu bằng 0.';
                if (!in_array($gt, ['nam', 'nu', 'khac'])) $gt = null;
                if ($ns && !strtotime($ns)) $ns = null;
                if (!$errors) {
                    $this->userModel->updateProfile($u['MaKH'], $ten, $sdt, $dc, $gt, $ns);
                    flash('success', 'Đã cập nhật thông tin cá nhân.');
                    redirect('index.php?page=account');
                }
                $u = array_merge($u, ['HoTen' => $ten, 'Sdt' => $sdt, 'DiaChi' => $dc, 'GioiTinh' => $gt, 'Ngaysinh' => $ns]);
            } else {
                $row = $this->userModel->find($u['MaKH']);
                $old = $_POST['old'] ?? ''; $new = $_POST['new'] ?? ''; $conf = $_POST['confirm'] ?? '';
                if (!password_verify($old, $row['MatKhau'])) $pwErrors[] = 'Mật khẩu hiện tại không đúng.';
                if (strlen($new) < 8 || !preg_match('/[A-Za-z]/', $new) || !preg_match('/\d/', $new)) $pwErrors[] = 'Mật khẩu mới tối thiểu 8 ký tự, gồm cả chữ và số.';
                if ($new !== $conf) $pwErrors[] = 'Mật khẩu xác nhận không khớp.';
                if (!$pwErrors) { $this->userModel->setPassword($u['MaKH'], $new); flash('success', 'Đổi mật khẩu thành công.'); redirect('index.php?page=account'); }
            }
        }
        $this->render('account', ['u' => $u, 'errors' => $errors, 'pwErrors' => $pwErrors, 'counts' => $this->orderModel->statusCounts($u['MaKH'])], 'Tài khoản của tôi');
    }

    public function history() {
        require_login();
        $kh = current_user()['MaKH'];
        $status = $_GET['status'] ?? ''; if (!in_array($status, ORDER_STATUSES)) $status = '';
        $q = trim($_GET['q'] ?? '');
        $orders = $this->orderModel->byUser($kh, $status, $q);
        foreach ($orders as &$o) $o['items'] = $this->orderModel->details($o['MaDH']);
        unset($o);
        $this->render('history', ['orders' => $orders, 'status' => $status, 'q' => $q, 'counts' => $this->orderModel->statusCounts($kh)], 'Đơn hàng của tôi');
    }

    public function orderdetail() {
        require_login();
        $o = $this->orderModel->find((int)($_GET['id'] ?? 0));
        if (!$o || $o['MaKH'] != current_user()['MaKH']) { flash('error', 'Không tìm thấy đơn hàng.'); redirect('index.php?page=history'); }
        $this->render('orderdetail', ['o' => $o, 'details' => $this->orderModel->details($o['MaDH'])], 'Đơn hàng #RAMBO-' . $o['MaDH']);
    }

    public function order_cancel() {
        $this->post(); $this->needLogin();
        $r = $this->orderModel->cancelByUser((int)($_POST['id'] ?? 0), current_user()['MaKH']);
        if ($r === true) flash('success', 'Đã hủy đơn hàng. Sản phẩm đã được hoàn lại kho.'); else flash('error', $r);
        redirect_back('index.php?page=history');
    }
}