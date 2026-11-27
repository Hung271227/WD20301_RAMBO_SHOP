<?php
require_once 'BaseController.php';
class AuthController extends BaseController {

    public function login() {
        if (is_logged()) redirect(is_admin() ? 'admin.php' : 'index.php');
        $error = ''; $account = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            csrf_check();
            $account = trim($_POST['account'] ?? '');
            $pass = $_POST['password'] ?? '';
            $u = $account !== '' ? $this->userModel->findByAccount($account) : null;
            if (!$u || !password_verify($pass, $u['MatKhau'])) $error = 'Sai tài khoản hoặc mật khẩu.';
            elseif (!$u['TrangThai']) $error = 'Tài khoản của bạn đã bị khóa. Vui lòng liên hệ hotline 1900 8888.';
            else {
                session_regenerate_id(true);
                unset($u['MatKhau']);
                $_SESSION['user'] = $u;
                flash('success', 'Chào mừng ' . $u['HoTen'] . ' quay trở lại RAMBO STORE!');
                $_POST['back'] = $_POST['next'] ?? '';
                if ($u['VaiTro'] === 'admin' && ($_POST['next'] ?? '') === '') redirect('admin.php');
                redirect_back('index.php');
            }
        }
        $this->render('login', ['error' => $error, 'account' => $account, 'next' => $_GET['next'] ?? ''], 'Đăng nhập');
    }

    public function register() {
        if (is_logged()) redirect('index.php');
        $errors = []; $old = ['ten' => '', 'email' => $_GET['email'] ?? '', 'sdt' => ''];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            csrf_check();
            $old = ['ten' => trim($_POST['fullName'] ?? ''), 'email' => trim($_POST['email'] ?? ''), 'sdt' => preg_replace('/\s+/', '', $_POST['phone'] ?? '')];
            $pass = $_POST['password'] ?? ''; $conf = $_POST['confirmPassword'] ?? '';
            if (mb_strlen($old['ten']) < 2) $errors[] = 'Vui lòng nhập họ và tên.';
            if (!filter_var($old['email'], FILTER_VALIDATE_EMAIL)) $errors[] = 'Email không hợp lệ.';
            elseif ($this->userModel->emailExists($old['email'])) $errors[] = 'Email này đã được đăng ký.';
            if (!preg_match('/^0\d{9}$/', $old['sdt'])) $errors[] = 'Số điện thoại phải gồm 10 chữ số, bắt đầu bằng 0.';
            if (strlen($pass) < 8 || !preg_match('/[A-Za-z]/', $pass) || !preg_match('/\d/', $pass)) $errors[] = 'Mật khẩu tối thiểu 8 ký tự, gồm cả chữ và số.';
            if ($pass !== $conf) $errors[] = 'Mật khẩu xác nhận không khớp.';
            if (empty($_POST['agree'])) $errors[] = 'Bạn cần đồng ý với điều khoản dịch vụ.';
            if (!$errors) {
                $id = $this->userModel->register($old['ten'], $old['email'], $pass, $old['sdt']);
                $u = $this->userModel->find($id); unset($u['MatKhau']);
                session_regenerate_id(true);
                $_SESSION['user'] = $u;
                flash('success', 'Đăng ký thành công! Dùng mã WELCOME100 để được giảm 100.000đ cho đơn từ 1.000.000đ.');
                redirect('index.php');
            }
        }
        $this->render('register', ['errors' => $errors, 'old' => $old], 'Đăng ký');
    }

    public function logout() {
        unset($_SESSION['user'], $_SESSION['coupon']);
        session_regenerate_id(true);
        redirect('index.php');
    }
}
