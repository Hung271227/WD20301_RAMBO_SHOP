<?php
require_once 'Database.php';
class Order {
    private $db;
    public function __construct() { $this->db = new Database(); }

    // Tạo đơn: kiểm tra tồn kho, trừ kho, trừ lượt mã, xóa giỏ - trong 1 transaction
    public function create($kh, $info, $items, $coupon, $subtotal, $discount) {
        $this->db->begin();
        try {
            foreach ($items as $it) {
                $stock = $this->db->getOne("SELECT SoLuongTonKho, TrangThai, TenSP FROM san_pham WHERE MaSP=? FOR UPDATE", [$it['MaSP']]);
                if (!$stock || !$stock['TrangThai'] || $stock['SoLuongTonKho'] < $it['SoLuong'])
                    throw new Exception('Sản phẩm "' . ($stock['TenSP'] ?? '#' . $it['MaSP']) . '" không đủ số lượng trong kho.');
            }
            if ($coupon) {
                $left = $this->db->value("SELECT SoLuong FROM ma_giam_gia WHERE MaGG=? FOR UPDATE", [$coupon['MaGG']]);
                if ($left <= 0) throw new Exception('Mã giảm giá đã hết lượt sử dụng.');
                $this->db->action("UPDATE ma_giam_gia SET SoLuong = SoLuong - 1 WHERE MaGG=?", [$coupon['MaGG']]);
            }
            $this->db->action("INSERT INTO don_hang (MaKH,MaGG,TenNguoiNhan,TongTien,GiamGia,TrangThai,DiaChi,Sdt,GhiChu,NgayDat,PhuongThuc)
                VALUES (?,?,?,?,?,'Chờ xác nhận',?,?,?,NOW(),?)",
                [$kh, $coupon ? $coupon['MaGG'] : null, $info['ten'], $subtotal - $discount, $discount, $info['diachi'], $info['sdt'], $info['ghichu'], $info['pt']]);
            $id = $this->db->lastId();
            foreach ($items as $it) {
                $this->db->action("INSERT INTO chi_tiet_don_hang (MaDH,MaSP,SoLuong,GiaBan) VALUES (?,?,?,?)", [$id, $it['MaSP'], $it['SoLuong'], $it['DonGia']]);
                $this->db->action("UPDATE san_pham SET SoLuongTonKho = SoLuongTonKho - ? WHERE MaSP=?", [$it['SoLuong'], $it['MaSP']]);
            }
            $this->db->action("DELETE c FROM chi_tiet_gio_hang c JOIN gio_hang g ON g.MaGH=c.MaGH WHERE g.MaKH=?", [$kh]);
            $this->db->commit();
            return $id;
        } catch (Exception $ex) {
            $this->db->rollBack();
            throw $ex;
        }
    }

    public function find($id) {
        return $this->db->getOne("SELECT o.*, g.Code, k.HoTen AS TenKH, k.Email FROM don_hang o
            JOIN khach_hang k ON k.MaKH=o.MaKH LEFT JOIN ma_giam_gia g ON g.MaGG=o.MaGG WHERE o.MaDH=?", [$id]);
    }
    public function details($id) {
        return $this->db->getAll("SELECT c.*, s.TenSP, s.HinhAnh, s.MaHang, s.SoManh, s.DoTuoi, d.TenDM
            FROM chi_tiet_don_hang c JOIN san_pham s ON s.MaSP=c.MaSP JOIN danh_muc d ON d.MaDM=s.MaDM WHERE c.MaDH=?", [$id]);
    }

    // ===== Khách =====
    public function byUser($kh, $status = '', $q = '') {
        $w = ['o.MaKH=?']; $p = [$kh];
        if ($status !== '') { $w[] = 'o.TrangThai=?'; $p[] = $status; }
        if ($q !== '') {
            $w[] = '(o.MaDH = ? OR EXISTS (SELECT 1 FROM chi_tiet_don_hang c JOIN san_pham s ON s.MaSP=c.MaSP WHERE c.MaDH=o.MaDH AND s.TenSP LIKE ?))';
            $p[] = (int)ltrim(strtoupper($q), '#RAMBO-'); $p[] = "%$q%";
        }
        return $this->db->getAll("SELECT o.*, (SELECT COALESCE(SUM(SoLuong),0) FROM chi_tiet_don_hang c WHERE c.MaDH=o.MaDH) AS SoMon
                                   FROM don_hang o WHERE " . implode(' AND ', $w) . " ORDER BY o.MaDH DESC", $p);
    }
    public function statusCounts($kh) {
        $r = $this->db->getAll("SELECT TrangThai, COUNT(*) n FROM don_hang WHERE MaKH=? GROUP BY TrangThai", [$kh]);
        return array_column($r, 'n', 'TrangThai');
    }
    // Hủy đơn (chỉ khi chưa xác nhận)
    public function cancelByUser($id, $kh) {
        $o = $this->db->getOne("SELECT * FROM don_hang WHERE MaDH=? AND MaKH=?", [$id, $kh]);
        if (!$o) return 'Không tìm thấy đơn hàng.';
        if ($o['TrangThai'] !== 'Chờ xác nhận') return 'Chỉ có thể hủy đơn hàng đang ở trạng thái "Chờ xác nhận".';
        $this->setStatus($id, 'Đã hủy');
        return true;
    }

    // ===== Admin =====
    public function all($status = '', $q = '', $from = '', $to = '') {
        $w = ['1=1']; $p = [];
        if ($status !== '') { $w[] = 'o.TrangThai=?'; $p[] = $status; }
        if ($q !== '') { $w[] = '(o.MaDH = ? OR k.HoTen LIKE ? OR k.Email LIKE ? OR o.Sdt LIKE ?)'; $p[] = (int)$q; array_push($p, "%$q%", "%$q%", "%$q%"); }
        if ($from !== '') { $w[] = 'DATE(o.NgayDat) >= ?'; $p[] = $from; }
        if ($to !== '') { $w[] = 'DATE(o.NgayDat) <= ?'; $p[] = $to; }
        return $this->db->getAll("SELECT o.*, k.HoTen AS TenKH, k.Email,
              (SELECT COALESCE(SUM(SoLuong),0) FROM chi_tiet_don_hang c WHERE c.MaDH=o.MaDH) AS SoMon
              FROM don_hang o JOIN khach_hang k ON k.MaKH=o.MaKH WHERE " . implode(' AND ', $w) . " ORDER BY o.MaDH DESC", $p);
    }
    // Quy tắc chuyển trạng thái
    public static function nextStatuses($cur) {
        switch ($cur) {
            case 'Chờ xác nhận': return ['Đã xác nhận', 'Đã hủy'];
            case 'Đã xác nhận': return ['Đang giao', 'Đã hủy'];
            case 'Đang giao': return ['Hoàn thành', 'Đã hủy'];
        }
        return [];
    }
    public function setStatus($id, $new) {
        $o = $this->db->getOne("SELECT * FROM don_hang WHERE MaDH=?", [$id]);
        if (!$o) return false;
        $this->db->begin();
        try {
            // hủy đơn => hoàn lại kho và lượt mã giảm giá
            if ($new === 'Đã hủy' && $o['TrangThai'] !== 'Đã hủy') {
                foreach ($this->db->getAll("SELECT MaSP, SoLuong FROM chi_tiet_don_hang WHERE MaDH=?", [$id]) as $d)
                    $this->db->action("UPDATE san_pham SET SoLuongTonKho = SoLuongTonKho + ? WHERE MaSP=?", [$d['SoLuong'], $d['MaSP']]);
                if ($o['MaGG']) $this->db->action("UPDATE ma_giam_gia SET SoLuong = SoLuong + 1 WHERE MaGG=?", [$o['MaGG']]);
            }
            $this->db->action("UPDATE don_hang SET TrangThai=? WHERE MaDH=?", [$new, $id]);
            $this->db->commit();
            return true;
        } catch (Exception $ex) { $this->db->rollBack(); return false; }
    }

    // ===== Thống kê dashboard =====
    public function stats() {
        return [
            'doanhthu' => (float)$this->db->value("SELECT COALESCE(SUM(TongTien),0) FROM don_hang WHERE TrangThai='Hoàn thành'"),
            'doanhthu_thang' => (float)$this->db->value("SELECT COALESCE(SUM(TongTien),0) FROM don_hang WHERE TrangThai='Hoàn thành' AND YEAR(NgayDat)=YEAR(CURDATE()) AND MONTH(NgayDat)=MONTH(CURDATE())"),
            'tong_don' => (int)$this->db->value("SELECT COUNT(*) FROM don_hang"),
            'cho_xn' => (int)$this->db->value("SELECT COUNT(*) FROM don_hang WHERE TrangThai='Chờ xác nhận'"),
            'khach' => (int)$this->db->value("SELECT COUNT(*) FROM khach_hang WHERE VaiTro='khach'"),
            'sanpham' => (int)$this->db->value("SELECT COUNT(*) FROM san_pham"),
            'binhluan' => (int)$this->db->value("SELECT COUNT(*) FROM binh_luan"),
        ];
    }
    public function byStatus() {
        return array_column($this->db->getAll("SELECT TrangThai, COUNT(*) n FROM don_hang GROUP BY TrangThai"), 'n', 'TrangThai');
    }
    public function revenueByMonth($months = 6) {
        $rows = array_column($this->db->getAll("SELECT DATE_FORMAT(NgayDat,'%Y-%m') ym, SUM(TongTien) t FROM don_hang
            WHERE TrangThai='Hoàn thành' AND NgayDat >= DATE_SUB(DATE_FORMAT(CURDATE(),'%Y-%m-01'), INTERVAL " . ((int)$months - 1) . " MONTH)
            GROUP BY ym"), 't', 'ym');
        $out = [];
        for ($i = $months - 1; $i >= 0; $i--) {
            $k = date('Y-m', strtotime("first day of -$i month"));
            $out[] = ['label' => date('m/Y', strtotime($k . '-01')), 'value' => (float)($rows[$k] ?? 0)];
        }
        return $out;
    }
    public function recent($limit = 6) {
        return $this->db->getAll("SELECT o.*, k.HoTen AS TenKH FROM don_hang o JOIN khach_hang k ON k.MaKH=o.MaKH ORDER BY o.MaDH DESC LIMIT " . (int)$limit);
    }
}
