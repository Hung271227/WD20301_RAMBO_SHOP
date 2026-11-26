<?php
require_once 'Database.php';
// Giỏ hàng lưu trong DB (gio_hang + chi_tiet_gio_hang) - yêu cầu đăng nhập
class Cart {
    private $db;
    public function __construct() { $this->db = new Database(); }

    public function cartId($kh) {
        $id = $this->db->value("SELECT MaGH FROM gio_hang WHERE MaKH=?", [$kh]);
        if ($id) return (int)$id;
        $this->db->action("INSERT INTO gio_hang (MaKH) VALUES (?)", [$kh]);
        return $this->db->lastId();
    }
    // Đơn giá luôn lấy theo giá hiện tại của sản phẩm
    public function items($kh) {
        return $this->db->getAll("SELECT c.MaCTGH, c.MaSP, c.SoLuong, s.Gia AS DonGia, s.GiaGoc, s.TenSP, s.HinhAnh, s.MaHang,
                s.SoManh, s.DoTuoi, s.SoLuongTonKho, s.TrangThai, d.TenDM
            FROM gio_hang g JOIN chi_tiet_gio_hang c ON c.MaGH=g.MaGH
            JOIN san_pham s ON s.MaSP=c.MaSP JOIN danh_muc d ON d.MaDM=s.MaDM
            WHERE g.MaKH=? ORDER BY c.MaCTGH DESC", [$kh]);
    }
    public function add($kh, $sp, $qty) {
        $p = $this->db->getOne("SELECT Gia, SoLuongTonKho, TrangThai FROM san_pham WHERE MaSP=?", [$sp]);
        if (!$p || !$p['TrangThai']) return 'Sản phẩm không tồn tại hoặc đã ngừng bán.';
        if ($p['SoLuongTonKho'] <= 0) return 'Sản phẩm đã hết hàng.';
        $gh = $this->cartId($kh);
        $cur = (int)$this->db->value("SELECT SoLuong FROM chi_tiet_gio_hang WHERE MaGH=? AND MaSP=?", [$gh, $sp]);
        $new = min($cur + $qty, (int)$p['SoLuongTonKho']);
        if ($cur) $this->db->action("UPDATE chi_tiet_gio_hang SET SoLuong=?, GiaBan=? WHERE MaGH=? AND MaSP=?", [$new, $p['Gia'], $gh, $sp]);
        else $this->db->action("INSERT INTO chi_tiet_gio_hang (MaGH,MaSP,SoLuong,GiaBan) VALUES (?,?,?,?)", [$gh, $sp, $new, $p['Gia']]);
        return ($cur + $qty > $p['SoLuongTonKho']) ? 'Đã thêm vào giỏ (tối đa theo tồn kho: ' . $p['SoLuongTonKho'] . ').' : true;
    }
    public function setQty($kh, $sp, $qty) {
        $stock = (int)$this->db->value("SELECT SoLuongTonKho FROM san_pham WHERE MaSP=?", [$sp]);
        $qty = max(1, min((int)$qty, max($stock, 1)));
        $gh = $this->cartId($kh);
        return $this->db->action("UPDATE chi_tiet_gio_hang SET SoLuong=? WHERE MaGH=? AND MaSP=?", [$qty, $gh, $sp]);
    }
    public function remove($kh, $sp) {
        return $this->db->action("DELETE c FROM chi_tiet_gio_hang c JOIN gio_hang g ON g.MaGH=c.MaGH WHERE g.MaKH=? AND c.MaSP=?", [$kh, $sp]);
    }
    public function clear($kh) {
        return $this->db->action("DELETE c FROM chi_tiet_gio_hang c JOIN gio_hang g ON g.MaGH=c.MaGH WHERE g.MaKH=?", [$kh]);
    }
    public function count($kh) {
        return (int)$this->db->value("SELECT COALESCE(SUM(c.SoLuong),0) FROM gio_hang g JOIN chi_tiet_gio_hang c ON c.MaGH=g.MaGH WHERE g.MaKH=?", [$kh]);
    }
    public function total($kh) {
        return (float)$this->db->value("SELECT COALESCE(SUM(c.SoLuong*s.Gia),0) FROM gio_hang g JOIN chi_tiet_gio_hang c ON c.MaGH=g.MaGH JOIN san_pham s ON s.MaSP=c.MaSP WHERE g.MaKH=?", [$kh]);
    }
}
