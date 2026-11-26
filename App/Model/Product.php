<?php
require_once 'Database.php';
class Product {
    private $db;
    public function __construct() { $this->db = new Database(); }

    // SELECT chung có điểm đánh giá trung bình + số đánh giá
    private function base() {
        return "SELECT s.*, d.TenDM,
                  (SELECT ROUND(AVG(DanhGia),1) FROM binh_luan b WHERE b.MaSP=s.MaSP) AS Diem,
                  (SELECT COUNT(*) FROM binh_luan b WHERE b.MaSP=s.MaSP) AS SoDG
                FROM san_pham s JOIN danh_muc d ON d.MaDM=s.MaDM ";
    }

    // ===== PHÍA KHÁCH =====
    // Lọc: q, cat (mảng), min, max, age(mảng), pieces(mảng), sale, instock ; sort ; phân trang
    public function search($f, $limit = 12, $offset = 0) {
        [$where, $p] = $this->filterSql($f);
        $order = $this->orderSql($f['sort'] ?? 'new');
        $sql = $this->base() . "WHERE $where ORDER BY $order LIMIT " . (int)$limit . " OFFSET " . (int)$offset;
        return $this->db->getAll($sql, $p);
    }
    public function countSearch($f) {
        [$where, $p] = $this->filterSql($f);
        return (int)$this->db->value("SELECT COUNT(*) FROM san_pham s JOIN danh_muc d ON d.MaDM=s.MaDM WHERE $where", $p);
    }
    private function filterSql($f) {
        $w = ['s.TrangThai=1', 'd.TrangThai=1']; $p = [];
        if (!empty($f['q'])) { $w[] = '(s.TenSP LIKE ? OR s.MaHang LIKE ? OR d.TenDM LIKE ?)'; $k = '%' . $f['q'] . '%'; array_push($p, $k, $k, $k); }
        if (!empty($f['cat'])) {
            $ids = array_map('intval', (array)$f['cat']);
            $w[] = 's.MaDM IN (' . implode(',', $ids) . ')';
        }
        if (!empty($f['min'])) { $w[] = 's.Gia >= ?'; $p[] = (int)$f['min']; }
        if (!empty($f['max'])) { $w[] = 's.Gia <= ?'; $p[] = (int)$f['max']; }
        if (!empty($f['age'])) {
            $c = [];
            foreach ((array)$f['age'] as $a) {
                $n = (int)$a;  // tuổi tối thiểu của sản phẩm
                if ($n == 4) $c[] = '(CAST(s.DoTuoi AS UNSIGNED) BETWEEN 1 AND 7)';
                elseif ($n == 8) $c[] = '(CAST(s.DoTuoi AS UNSIGNED) BETWEEN 8 AND 11)';
                elseif ($n == 12) $c[] = '(CAST(s.DoTuoi AS UNSIGNED) BETWEEN 12 AND 17)';
                elseif ($n == 18) $c[] = '(CAST(s.DoTuoi AS UNSIGNED) >= 16)';
            }
            if ($c) $w[] = '(' . implode(' OR ', $c) . ')';
        }
        if (!empty($f['pieces'])) {
            $c = [];
            foreach ((array)$f['pieces'] as $a) {
                if ($a == 'lt500') $c[] = '(s.SoManh > 0 AND s.SoManh < 500)';
                elseif ($a == '500-1500') $c[] = '(s.SoManh BETWEEN 500 AND 1500)';
                elseif ($a == '1500-3000') $c[] = '(s.SoManh BETWEEN 1501 AND 3000)';
                elseif ($a == 'gt3000') $c[] = '(s.SoManh > 3000)';
            }
            if ($c) $w[] = '(' . implode(' OR ', $c) . ')';
        }
        if (!empty($f['sale'])) $w[] = 's.GiaGoc > s.Gia';
        if (!empty($f['instock'])) $w[] = 's.SoLuongTonKho > 0';
        return [implode(' AND ', $w), $p];
    }
    private function orderSql($s) {
        switch ($s) {
            case 'price_asc': return 's.Gia ASC';
            case 'price_desc': return 's.Gia DESC';
            case 'rating': return 'Diem DESC, SoDG DESC';
            case 'sale': return '(s.GiaGoc - s.Gia) / NULLIF(s.GiaGoc,0) DESC';
            case 'best': return '(SELECT COALESCE(SUM(c.SoLuong),0) FROM chi_tiet_don_hang c WHERE c.MaSP=s.MaSP) DESC';
            default: return 's.NgayTao DESC';
        }
    }
    public function newest($limit = 8, $days = null) {
        $w = "s.TrangThai=1 AND d.TrangThai=1" . ($days ? " AND s.NgayTao >= NOW() - INTERVAL " . (int)$days . " DAY" : "");
        return $this->db->getAll($this->base() . "WHERE $w ORDER BY s.NgayTao DESC LIMIT " . (int)$limit);
    }
    public function onSale($limit = 50) {
        return $this->db->getAll($this->base() . "WHERE s.TrangThai=1 AND d.TrangThai=1 AND s.GiaGoc > s.Gia
                ORDER BY (s.GiaGoc - s.Gia) / s.GiaGoc DESC LIMIT " . (int)$limit);
    }
    public function bestSellers($limit = 8) {
        return $this->db->getAll($this->base() . "WHERE s.TrangThai=1 AND d.TrangThai=1
            ORDER BY (SELECT COALESCE(SUM(c.SoLuong),0) FROM chi_tiet_don_hang c WHERE c.MaSP=s.MaSP) DESC, s.NgayTao DESC LIMIT " . (int)$limit);
    }
    public function visibleById($id) {
        return $this->db->getOne($this->base() . "WHERE s.MaSP=? AND s.TrangThai=1 AND d.TrangThai=1", [$id]);
    }
    public function related($id, $cat, $limit = 4) {
        return $this->db->getAll($this->base() . "WHERE s.MaSP<>? AND s.MaDM=? AND s.TrangThai=1 AND d.TrangThai=1 ORDER BY s.NgayTao DESC LIMIT " . (int)$limit, [$id, $cat]);
    }
    public function wishlistOf($kh) {
        return $this->db->getAll($this->base() . "JOIN yeu_thich y ON y.MaSP=s.MaSP WHERE y.MaKH=? AND s.TrangThai=1 ORDER BY y.MaYT DESC", [$kh]);
    }

    // ===== ADMIN =====
    public function adminList($q = '', $cat = 0, $status = '') {
        $w = ['1=1']; $p = [];
        if ($q !== '') { $w[] = '(s.TenSP LIKE ? OR s.MaHang LIKE ?)'; $p[] = "%$q%"; $p[] = "%$q%"; }
        if ($cat) { $w[] = 's.MaDM=?'; $p[] = $cat; }
        if ($status !== '') { $w[] = 's.TrangThai=?'; $p[] = (int)$status; }
        return $this->db->getAll($this->base() . "WHERE " . implode(' AND ', $w) . " ORDER BY s.MaSP DESC", $p);
    }
    public function find($id) { return $this->db->getOne("SELECT * FROM san_pham WHERE MaSP=?", [$id]); }
    public function add($d) {
        return $this->db->action("INSERT INTO san_pham (MaDM,MaHang,TenSP,Gia,GiaGoc,SoLuongTonKho,SoManh,DoTuoi,MoTa,HinhAnh,TrangThai)
            VALUES (?,?,?,?,?,?,?,?,?,?,?)",
            [$d['MaDM'], $d['MaHang'], $d['TenSP'], $d['Gia'], $d['GiaGoc'], $d['SoLuongTonKho'], $d['SoManh'], $d['DoTuoi'], $d['MoTa'], $d['HinhAnh'], $d['TrangThai']]);
    }
    public function update($id, $d) {
        return $this->db->action("UPDATE san_pham SET MaDM=?,MaHang=?,TenSP=?,Gia=?,GiaGoc=?,SoLuongTonKho=?,SoManh=?,DoTuoi=?,MoTa=?,HinhAnh=?,TrangThai=? WHERE MaSP=?",
            [$d['MaDM'], $d['MaHang'], $d['TenSP'], $d['Gia'], $d['GiaGoc'], $d['SoLuongTonKho'], $d['SoManh'], $d['DoTuoi'], $d['MoTa'], $d['HinhAnh'], $d['TrangThai'], $id]);
    }
    public function toggle($id) { return $this->db->action("UPDATE san_pham SET TrangThai = 1 - TrangThai WHERE MaSP=?", [$id]); }
    public function hasOrders($id) { return (int)$this->db->value("SELECT COUNT(*) FROM chi_tiet_don_hang WHERE MaSP=?", [$id]) > 0; }
    public function delete($id) { return $this->db->action("DELETE FROM san_pham WHERE MaSP=?", [$id]); }
    public function lowStock($limit = 5) {
        return $this->db->getAll("SELECT * FROM san_pham WHERE SoLuongTonKho <= 10 AND TrangThai=1 ORDER BY SoLuongTonKho ASC LIMIT " . (int)$limit);
    }
    public function topSelling($limit = 5) {
        return $this->db->getAll("SELECT s.MaSP,s.TenSP,s.HinhAnh, SUM(c.SoLuong) AS DaBan, SUM(c.SoLuong*c.GiaBan) AS DoanhThu
            FROM chi_tiet_don_hang c JOIN don_hang o ON o.MaDH=c.MaDH JOIN san_pham s ON s.MaSP=c.MaSP
            WHERE o.TrangThai <> 'Đã hủy' GROUP BY s.MaSP ORDER BY DaBan DESC LIMIT " . (int)$limit);
    }
}
