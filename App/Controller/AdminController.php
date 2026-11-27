<?php
require_once __DIR__ . '/../../helpers.php';
foreach (['Category', 'Product', 'User', 'Order', 'Coupon', 'Comment'] as $m) require_once __DIR__ . "/../Model/$m.php";

// Toàn bộ chức năng quản trị (theo use case Admin)
class AdminController {
    private $cat, $prod, $user, $order, $coupon, $comment;

    public function __construct() {
        $this->cat = new Category(); $this->prod = new Product(); $this->user = new User();
        $this->order = new Order(); $this->coupon = new Coupon(); $this->comment = new Comment();
    }

    private function render($view, $data = [], $title = 'Quản trị') {
        extract($data);
        $adminTitle = $title;
        $pendingOrders = (new Database())->value("SELECT COUNT(*) FROM don_hang WHERE TrangThai='Chờ xác nhận'");
        include __DIR__ . '/../View/admin/header.php';
        include __DIR__ . '/../View/admin/' . $view . '.php';
        include __DIR__ . '/../View/admin/footer.php';
    }
    private function isPost() { if ($_SERVER['REQUEST_METHOD'] === 'POST') { csrf_check(); return true; } return false; }
    private function to($page, $extra = '') { redirect('admin.php?page=' . $page . $extra); }

    // ===== Xem Dashboard =====
    public function dashboard() {
        $this->render('dashboard', [
            's' => $this->order->stats(), 'byStatus' => $this->order->byStatus(),
            'months' => $this->order->revenueByMonth(6), 'recent' => $this->order->recent(6),
            'top' => $this->prod->topSelling(5), 'low' => $this->prod->lowStock(5),
        ], 'Dashboard');
    }

    // ===== Quản lý danh mục: xem, thêm, sửa, ẩn/hiện, xóa =====
    public function category() {
        if ($this->isPost()) {
            $do = $_POST['do'] ?? ''; $id = (int)($_POST['id'] ?? 0);
            if ($do === 'save') {
                $ten = trim($_POST['TenDM'] ?? ''); $mota = trim($_POST['MoTa'] ?? ''); $icon = preg_replace('/[^a-z0-9_]/', '', strtolower($_POST['Icon'] ?? ''));
                if ($ten === '') flash('error', 'Tên danh mục không được để trống.');
                elseif ($id) { $this->cat->update($id, $ten, $mota, $icon); flash('success', 'Đã cập nhật danh mục.'); }
                else { $this->cat->add($ten, $mota, $icon); flash('success', 'Đã thêm danh mục mới.'); }
            } elseif ($do === 'toggle') { $this->cat->toggle($id); flash('success', 'Đã đổi trạng thái ẩn/hiện danh mục.'); }
            elseif ($do === 'delete') {
                if ($this->cat->countProducts($id) > 0) flash('error', 'Không thể xóa: danh mục còn sản phẩm. Hãy ẩn danh mục hoặc chuyển sản phẩm sang danh mục khác.');
                else { $this->cat->delete($id); flash('success', 'Đã xóa danh mục.'); }
            }
            $this->to('category');
        }
        $edit = isset($_GET['edit']) ? $this->cat->find((int)$_GET['edit']) : null;
        $this->render('category', ['rows' => $this->cat->all(), 'edit' => $edit], 'Quản lý danh mục');
    }

    // ===== Quản lý sản phẩm =====
    private function uploadImage($old) {
        $url = trim($_POST['HinhAnhUrl'] ?? '');
        if (!empty($_FILES['HinhAnh']['name']) && $_FILES['HinhAnh']['error'] === UPLOAD_ERR_OK) {
            $f = $_FILES['HinhAnh'];
            $ext = strtolower(pathinfo($f['name'], PATHINFO_EXTENSION));
            if (!in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'gif']) || !@getimagesize($f['tmp_name'])) throw new Exception('Ảnh không hợp lệ (chỉ nhận jpg, png, webp, gif).');
            if ($f['size'] > 3 * 1024 * 1024) throw new Exception('Ảnh quá lớn (tối đa 3MB).');
            if (!is_dir(UPLOAD_DIR)) mkdir(UPLOAD_DIR, 0777, true);
            $name = 'sp_' . date('YmdHis') . '_' . bin2hex(random_bytes(3)) . '.' . $ext;
            if (!move_uploaded_file($f['tmp_name'], UPLOAD_DIR . $name)) throw new Exception('Không lưu được file ảnh vào thư mục uploads/.');
            return $name;
        }
        if ($url !== '') {
            if (!preg_match('#^https?://#i', $url)) throw new Exception('Link ảnh phải bắt đầu bằng http:// hoặc https://');
            return $url;
        }
        return $old;
    }
    public function product() {
        if ($this->isPost()) {
            $do = $_POST['do'] ?? ''; $id = (int)($_POST['id'] ?? 0);
            if ($do === 'save') {
                try {
                    $old = $id ? ($this->prod->find($id)['HinhAnh'] ?? null) : null;
                    $d = [
                        'MaDM' => (int)$_POST['MaDM'], 'MaHang' => trim($_POST['MaHang'] ?? ''), 'TenSP' => trim($_POST['TenSP'] ?? ''),
                        'Gia' => max(0, (int)$_POST['Gia']), 'GiaGoc' => max(0, (int)($_POST['GiaGoc'] ?? 0)),
                        'SoLuongTonKho' => max(0, (int)$_POST['SoLuongTonKho']), 'SoManh' => max(0, (int)($_POST['SoManh'] ?? 0)),
                        'DoTuoi' => trim($_POST['DoTuoi'] ?? ''), 'MoTa' => trim($_POST['MoTa'] ?? ''), 'TrangThai' => empty($_POST['TrangThai']) ? 0 : 1,
                    ];
                    if ($d['TenSP'] === '' || !$d['MaDM']) throw new Exception('Vui lòng nhập tên sản phẩm và chọn danh mục.');
                    if ($d['Gia'] <= 0) throw new Exception('Giá bán phải lớn hơn 0.');
                    if ($d['GiaGoc'] && $d['GiaGoc'] < $d['Gia']) throw new Exception('Giá gốc phải lớn hơn hoặc bằng giá bán (để trống nếu không khuyến mãi).');
                    $d['HinhAnh'] = $this->uploadImage($old);
                    if ($id) { $this->prod->update($id, $d); flash('success', 'Đã cập nhật sản phẩm.'); }
                    else { $this->prod->add($d); flash('success', 'Đã thêm sản phẩm mới.'); }
                } catch (Exception $ex) {
                    flash('error', $ex->getMessage());
                    $this->to('product', $id ? '&edit=' . $id : '&new=1');
                }
            } elseif ($do === 'toggle') { $this->prod->toggle($id); flash('success', 'Đã đổi trạng thái ẩn/hiện sản phẩm.'); }
            elseif ($do === 'delete') {
                if ($this->prod->hasOrders($id)) flash('error', 'Sản phẩm đã có trong đơn hàng nên không thể xóa. Hãy ẩn sản phẩm thay thế.');
                else {
                    $p = $this->prod->find($id);
                    $this->prod->delete($id);
                    if ($p && $p['HinhAnh'] && !preg_match('#^https?://#', $p['HinhAnh']) && is_file(UPLOAD_DIR . basename($p['HinhAnh']))) @unlink(UPLOAD_DIR . basename($p['HinhAnh']));
                    flash('success', 'Đã xóa sản phẩm.');
                }
            }
            $this->to('product');
        }
        $form = null;
        if (isset($_GET['edit'])) { $form = $this->prod->find((int)$_GET['edit']); if (!$form) $this->to('product'); }
        elseif (isset($_GET['new'])) $form = [];
        $q = trim($_GET['q'] ?? ''); $cat = (int)($_GET['cat'] ?? 0); $st = $_GET['st'] ?? '';
        $this->render('product', ['rows' => $this->prod->adminList($q, $cat, $st), 'cats' => $this->cat->all(), 'form' => $form, 'q' => $q, 'cat' => $cat, 'st' => $st], 'Quản lý sản phẩm');
    }

    // ===== Quản lý khách hàng: xem, phân quyền, khóa tài khoản =====
    public function user() {
        if ($this->isPost()) {
            $id = (int)($_POST['id'] ?? 0); $do = $_POST['do'] ?? ''; $me = current_user()['MaKH'];
            $t = $this->user->find($id);
            if (!$t) flash('error', 'Không tìm thấy tài khoản.');
            elseif ($id === (int)$me) flash('error', 'Bạn không thể tự đổi quyền hoặc tự khóa tài khoản của mình.');
            elseif ($do === 'role') {
                $role = $_POST['VaiTro'] === 'admin' ? 'admin' : 'khach';
                if ($t['VaiTro'] === 'admin' && $role !== 'admin' && $this->user->countAdmins() <= 1) flash('error', 'Phải còn ít nhất một quản trị viên.');
                else { $this->user->setRole($id, $role); flash('success', 'Đã cập nhật quyền cho ' . $t['HoTen'] . '.'); }
            } elseif ($do === 'lock') {
                $this->user->toggleLock($id);
                flash('success', ($t['TrangThai'] ? 'Đã khóa tài khoản ' : 'Đã mở khóa tài khoản ') . $t['HoTen'] . '.');
            }
            $this->to('user', !empty($_GET['q']) ? '&q=' . urlencode($_GET['q']) : '');
        }
        $q = trim($_GET['q'] ?? '');
        $this->render('user', ['rows' => $this->user->all($q), 'q' => $q], 'Quản lý khách hàng');
    }

    // ===== Quản lý đơn hàng: xem, tìm kiếm, chi tiết, đổi trạng thái =====
    public function order() {
        $status = $_GET['status'] ?? ''; if (!in_array($status, ORDER_STATUSES)) $status = '';
        $q = trim($_GET['q'] ?? ''); $from = $_GET['from'] ?? ''; $to = $_GET['to'] ?? '';
        $this->render('order', ['rows' => $this->order->all($status, $q, $from, $to), 'status' => $status, 'q' => $q, 'from' => $from, 'to' => $to,
            'counts' => $this->order->byStatus()], 'Quản lý đơn hàng');
    }
    public function orderdetail() {
        $id = (int)($_GET['id'] ?? $_POST['id'] ?? 0);
        $o = $this->order->find($id);
        if (!$o) { flash('error', 'Không tìm thấy đơn hàng.'); $this->to('order'); }
        if ($this->isPost()) {
            $new = $_POST['status'] ?? '';
            if (in_array($new, Order::nextStatuses($o['TrangThai']), true)) {
                $this->order->setStatus($id, $new);
                flash('success', 'Đơn #RAMBO-' . $id . ' đã chuyển sang "' . $new . '".');
            } else flash('error', 'Không thể chuyển trạng thái này.');
            $this->to('orderdetail', '&id=' . $id);
        }
        $this->render('orderdetail', ['o' => $o, 'details' => $this->order->details($id)], 'Đơn hàng #RAMBO-' . $id);
    }

    // ===== Quản lý mã giảm giá: xem, thêm, sửa, xóa =====
    public function coupon() {
        if ($this->isPost()) {
            $do = $_POST['do'] ?? ''; $id = (int)($_POST['id'] ?? 0);
            if ($do === 'save') {
                $d = ['Code' => strtoupper(preg_replace('/[^A-Za-z0-9_-]/', '', $_POST['Code'] ?? '')), 'LoaiGiam' => ($_POST['LoaiGiam'] ?? '') === 'tien' ? 'tien' : 'phantram',
                      'MucGiaGiam' => max(0, (int)$_POST['MucGiaGiam']), 'DieuKienGiam' => max(0, (int)$_POST['DieuKienGiam']),
                      'SoLuong' => max(0, (int)$_POST['SoLuong']), 'NgayHetHan' => $_POST['NgayHetHan'] ?? ''];
                $err = null;
                if ($d['Code'] === '') $err = 'Vui lòng nhập mã code (chữ, số).';
                elseif ($this->coupon->codeExists($d['Code'], $id)) $err = 'Mã code này đã tồn tại.';
                elseif ($d['MucGiaGiam'] <= 0 || ($d['LoaiGiam'] === 'phantram' && $d['MucGiaGiam'] > 100)) $err = 'Mức giảm không hợp lệ (phần trăm: 1-100).';
                elseif (!strtotime($d['NgayHetHan'])) $err = 'Vui lòng chọn ngày hết hạn.';
                if ($err) { flash('error', $err); $this->to('coupon', $id ? '&edit=' . $id : '&new=1'); }
                if ($id) { $this->coupon->update($id, $d); flash('success', 'Đã cập nhật mã giảm giá.'); }
                else { $this->coupon->add($d); flash('success', 'Đã thêm mã giảm giá.'); }
            } elseif ($do === 'delete') { $this->coupon->delete($id); flash('success', 'Đã xóa mã giảm giá (các đơn cũ vẫn được giữ nguyên).'); }
            $this->to('coupon');
        }
        $form = null;
        if (isset($_GET['edit'])) { $form = $this->coupon->find((int)$_GET['edit']); if (!$form) $this->to('coupon'); }
        elseif (isset($_GET['new'])) $form = [];
        $q = trim($_GET['q'] ?? '');
        $this->render('coupon', ['rows' => $this->coupon->all($q), 'form' => $form, 'q' => $q], 'Quản lý mã giảm giá');
    }

    // ===== Quản lý bình luận: xem, sửa, xóa =====
    public function comment() {
        if ($this->isPost()) {
            $do = $_POST['do'] ?? ''; $id = (int)($_POST['id'] ?? 0);
            if ($do === 'save') {
                $nd = trim($_POST['NoiDung'] ?? ''); $sao = max(1, min(5, (int)($_POST['DanhGia'] ?? 5)));
                if ($nd === '') { flash('error', 'Nội dung bình luận không được để trống.'); $this->to('comment', '&edit=' . $id); }
                $this->comment->update($id, $nd, $sao); flash('success', 'Đã cập nhật bình luận.');
            } elseif ($do === 'delete') { $this->comment->delete($id); flash('success', 'Đã xóa bình luận.'); }
            $this->to('comment');
        }
        $edit = isset($_GET['edit']) ? $this->comment->find((int)$_GET['edit']) : null;
        $q = trim($_GET['q'] ?? '');
        $this->render('comment', ['rows' => $this->comment->all($q), 'edit' => $edit, 'q' => $q], 'Quản lý bình luận');
    }
}
