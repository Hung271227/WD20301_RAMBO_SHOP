<?php
require_once 'Database.php';
class Comment {
    private $db;
    public function __construct() { $this->db = new Database(); }
    public function forProduct($sp) {
        return $this->db->getAll("SELECT b.*, k.HoTen FROM binh_luan b JOIN khach_hang k ON k.MaKH=b.MaKH WHERE b.MaSP=? ORDER BY b.MaBL DESC", [$sp]);
    }
    public function add($kh, $sp, $noidung, $sao) {
        return $this->db->action("INSERT INTO binh_luan (MaKH,MaSP,NgayBL,NoiDung,DanhGia) VALUES (?,?,CURDATE(),?,?)", [$kh, $sp, $noidung, $sao]);
    }
    // admin
    public function all($q = '') {
        $w = '1=1'; $p = [];
        if ($q !== '') { $w = '(b.NoiDung LIKE ? OR k.HoTen LIKE ? OR s.TenSP LIKE ?)'; $p = ["%$q%", "%$q%", "%$q%"]; }
        return $this->db->getAll("SELECT b.*, k.HoTen, s.TenSP FROM binh_luan b JOIN khach_hang k ON k.MaKH=b.MaKH JOIN san_pham s ON s.MaSP=b.MaSP WHERE $w ORDER BY b.MaBL DESC", $p);
    }
    public function find($id) { return $this->db->getOne("SELECT b.*, k.HoTen, s.TenSP FROM binh_luan b JOIN khach_hang k ON k.MaKH=b.MaKH JOIN san_pham s ON s.MaSP=b.MaSP WHERE b.MaBL=?", [$id]); }
    public function update($id, $noidung, $sao) { return $this->db->action("UPDATE binh_luan SET NoiDung=?, DanhGia=? WHERE MaBL=?", [$noidung, $sao, $id]); }
    public function delete($id) { return $this->db->action("DELETE FROM binh_luan WHERE MaBL=?", [$id]); }
}
