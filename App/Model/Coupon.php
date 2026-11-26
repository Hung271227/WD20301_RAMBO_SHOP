<?php
require_once 'Database.php';
class Coupon {
    private $db;
    public function __construct() { $this->db = new Database(); }

    public function findByCode($code) { return $this->db->getOne("SELECT * FROM ma_giam_gia WHERE Code=?", [strtoupper(trim($code))]); }
    public function find($id) { return $this->db->getOne("SELECT * FROM ma_giam_gia WHERE MaGG=?", [$id]); }

    // Trả về [coupon, lỗi]
    public function validate($code, $subtotal) {
        $c = $this->findByCode($code);
        if (!$c) return [null, 'Mã giảm giá không tồn tại.'];
        if ($c['NgayHetHan'] < date('Y-m-d')) return [null, 'Mã giảm giá đã hết hạn.'];
        if ($c['SoLuong'] <= 0) return [null, 'Mã giảm giá đã hết lượt sử dụng.'];
        if ($subtotal < $c['DieuKienGiam']) return [null, 'Đơn hàng cần tối thiểu ' . money($c['DieuKienGiam']) . ' để dùng mã này.'];
        return [$c, null];
    }
    public static function amount($c, $subtotal) {
        if (!$c) return 0;
        $d = $c['LoaiGiam'] === 'phantram' ? floor($subtotal * $c['MucGiaGiam'] / 100) : $c['MucGiaGiam'];
        return (float)min($d, $subtotal);
    }
    public static function label($c) {
        return $c['LoaiGiam'] === 'phantram' ? 'Giảm ' . (int)$c['MucGiaGiam'] . '%' : 'Giảm ' . money($c['MucGiaGiam']);
    }
    // trang khuyến mãi: mã còn hạn & còn lượt
    public function active() {
        return $this->db->getAll("SELECT * FROM ma_giam_gia WHERE NgayHetHan >= CURDATE() AND SoLuong > 0 ORDER BY NgayHetHan ASC");
    }
    // admin
    public function all($q = '') {
        $w = '1=1'; $p = [];
        if ($q !== '') { $w = 'Code LIKE ?'; $p = ["%$q%"]; }
        return $this->db->getAll("SELECT * FROM ma_giam_gia WHERE $w ORDER BY MaGG DESC", $p);
    }
    public function codeExists($code, $except = 0) {
        return (int)$this->db->value("SELECT COUNT(*) FROM ma_giam_gia WHERE Code=? AND MaGG<>?", [strtoupper($code), $except]) > 0;
    }
    public function add($d) {
        return $this->db->action("INSERT INTO ma_giam_gia (Code,LoaiGiam,MucGiaGiam,DieuKienGiam,SoLuong,NgayHetHan) VALUES (?,?,?,?,?,?)",
            [strtoupper($d['Code']), $d['LoaiGiam'], $d['MucGiaGiam'], $d['DieuKienGiam'], $d['SoLuong'], $d['NgayHetHan']]);
    }
    public function update($id, $d) {
        return $this->db->action("UPDATE ma_giam_gia SET Code=?,LoaiGiam=?,MucGiaGiam=?,DieuKienGiam=?,SoLuong=?,NgayHetHan=? WHERE MaGG=?",
            [strtoupper($d['Code']), $d['LoaiGiam'], $d['MucGiaGiam'], $d['DieuKienGiam'], $d['SoLuong'], $d['NgayHetHan'], $id]);
    }
    public function delete($id) { return $this->db->action("DELETE FROM ma_giam_gia WHERE MaGG=?", [$id]); }
}
