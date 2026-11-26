<?php
require_once 'Database.php';
class Category {
    private $db;
    public function __construct() { $this->db = new Database(); }

    // phía khách: chỉ danh mục đang hiện
    public function visible() {
        return $this->db->getAll("SELECT d.*, (SELECT COUNT(*) FROM san_pham s WHERE s.MaDM=d.MaDM AND s.TrangThai=1) AS SoSP
                                   FROM danh_muc d WHERE d.TrangThai=1 ORDER BY d.MaDM");
    }
    // admin
    public function all() {
        return $this->db->getAll("SELECT d.*, (SELECT COUNT(*) FROM san_pham s WHERE s.MaDM=d.MaDM) AS SoSP FROM danh_muc d ORDER BY d.MaDM");
    }
    public function find($id) { return $this->db->getOne("SELECT * FROM danh_muc WHERE MaDM=?", [$id]); }
    public function add($ten, $mota, $icon) {
        return $this->db->action("INSERT INTO danh_muc (TenDM,MoTa,Icon,TrangThai) VALUES (?,?,?,1)", [$ten, $mota, $icon ?: 'extension']);
    }
    public function update($id, $ten, $mota, $icon) {
        return $this->db->action("UPDATE danh_muc SET TenDM=?, MoTa=?, Icon=? WHERE MaDM=?", [$ten, $mota, $icon ?: 'extension', $id]);
    }
    public function toggle($id) { return $this->db->action("UPDATE danh_muc SET TrangThai = 1 - TrangThai WHERE MaDM=?", [$id]); }
    public function countProducts($id) { return (int)$this->db->value("SELECT COUNT(*) FROM san_pham WHERE MaDM=?", [$id]); }
    public function delete($id) { return $this->db->action("DELETE FROM danh_muc WHERE MaDM=?", [$id]); }
}
