<?php
require_once 'Database.php';
class User {
    private $db;
    public function __construct() { $this->db = new Database(); }

    public function find($id) { return $this->db->getOne("SELECT * FROM khach_hang WHERE MaKH=?", [$id]); }
    public function findByAccount($acc) {
        return $this->db->getOne("SELECT * FROM khach_hang WHERE Email=? OR Sdt=? LIMIT 1", [$acc, $acc]);
    }
    public function emailExists($email, $exceptId = 0) {
        return (int)$this->db->value("SELECT COUNT(*) FROM khach_hang WHERE Email=? AND MaKH<>?", [$email, $exceptId]) > 0;
    }
    public function register($ten, $email, $pass, $sdt) {
        $this->db->action("INSERT INTO khach_hang (HoTen,Email,MatKhau,Sdt,VaiTro,TrangThai) VALUES (?,?,?,?, 'khach',1)",
            [$ten, $email, password_hash($pass, PASSWORD_DEFAULT), $sdt]);
        return $this->db->lastId();
    }
    public function updateProfile($id, $ten, $sdt, $diachi, $gt, $ns) {
        return $this->db->action("UPDATE khach_hang SET HoTen=?, Sdt=?, DiaChi=?, GioiTinh=?, Ngaysinh=? WHERE MaKH=?",
            [$ten, $sdt, $diachi, $gt ?: null, $ns ?: null, $id]);
    }
    public function setPassword($id, $pass) {
        return $this->db->action("UPDATE khach_hang SET MatKhau=? WHERE MaKH=?", [password_hash($pass, PASSWORD_DEFAULT), $id]);
    }
    // admin
    public function all($q = '') {
        $w = '1=1'; $p = [];
        if ($q !== '') { $w = '(HoTen LIKE ? OR Email LIKE ? OR Sdt LIKE ?)'; $p = ["%$q%", "%$q%", "%$q%"]; }
        return $this->db->getAll("SELECT k.*, (SELECT COUNT(*) FROM don_hang o WHERE o.MaKH=k.MaKH) AS SoDon,
              (SELECT COALESCE(SUM(TongTien),0) FROM don_hang o WHERE o.MaKH=k.MaKH AND o.TrangThai='Hoàn thành') AS TongMua
              FROM khach_hang k WHERE $w ORDER BY k.MaKH DESC", $p);
    }
    public function setRole($id, $role) { return $this->db->action("UPDATE khach_hang SET VaiTro=? WHERE MaKH=?", [$role, $id]); }
    public function toggleLock($id) { return $this->db->action("UPDATE khach_hang SET TrangThai = 1 - TrangThai WHERE MaKH=?", [$id]); }
    public function countAdmins() { return (int)$this->db->value("SELECT COUNT(*) FROM khach_hang WHERE VaiTro='admin' AND TrangThai=1"); }
    public function count() { return (int)$this->db->value("SELECT COUNT(*) FROM khach_hang WHERE VaiTro='khach'"); }
}
