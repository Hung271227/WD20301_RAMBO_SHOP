<?php
require_once 'Database.php';
class Wishlist {
    private $db;
    public function __construct() { $this->db = new Database(); }
    public function ids($kh) { return array_map('intval', array_column($this->db->getAll("SELECT MaSP FROM yeu_thich WHERE MaKH=?", [$kh]), 'MaSP')); }
    public function count($kh) { return (int)$this->db->value("SELECT COUNT(*) FROM yeu_thich WHERE MaKH=?", [$kh]); }
    // trả về true nếu đã thêm, false nếu đã bỏ
    public function toggle($kh, $sp) {
        if ($this->db->value("SELECT COUNT(*) FROM yeu_thich WHERE MaKH=? AND MaSP=?", [$kh, $sp])) {
            $this->db->action("DELETE FROM yeu_thich WHERE MaKH=? AND MaSP=?", [$kh, $sp]);
            return false;
        }
        $this->db->action("INSERT INTO yeu_thich (MaKH,MaSP) VALUES (?,?)", [$kh, $sp]);
        return true;
    }
    public function remove($kh, $sp) { return $this->db->action("DELETE FROM yeu_thich WHERE MaKH=? AND MaSP=?", [$kh, $sp]); }
}
