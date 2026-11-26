<?php $sub = 0; foreach ($details as $d) $sub += $d['GiaBan'] * $d['SoLuong']; $ship = $o['TongTien'] - ($sub - $o['GiamGia']); $next = Order::nextStatuses($o['TrangThai']); ?>
<a href="admin.php?page=order" class="text-sm font-bold text-primary flex items-center gap-1"><span class="material-symbols-outlined text-base">arrow_back</span>Danh sách đơn hàng</a>
<div class="grid xl:grid-cols-3 gap-6">
  <section class="xl:col-span-2 bg-surface-container-lowest rounded-xl custom-shadow-card border border-slate-100 p-5">
    <div class="flex items-center justify-between mb-4"><h2 class="font-headline-sm font-bold">Sản phẩm trong đơn</h2><?= status_badge($o['TrangThai']) ?></div>
    <div class="space-y-3"><?php foreach ($details as $d): ?>
      <div class="flex items-center gap-3"><img src="<?= e(img($d['HinhAnh'])) ?>" class="w-14 h-14 object-contain bg-[#F8F9FA] rounded" alt="">
        <div class="flex-1 min-w-0"><p class="font-bold text-sm"><?= e($d['TenSP']) ?></p><p class="text-xs text-slate-500"><?= e($d['TenDM']) ?> • <?= money($d['GiaBan']) ?> × <?= $d['SoLuong'] ?></p></div><strong><?= money($d['GiaBan'] * $d['SoLuong']) ?></strong></div>
    <?php endforeach; ?></div>
    <dl class="text-sm border-t mt-4 pt-3 space-y-1">
      <div class="flex justify-between"><dt>Tạm tính</dt><dd><?= money($sub) ?></dd></div>
      <div class="flex justify-between"><dt>Giảm giá<?= $o['Code'] ? ' (' . e($o['Code']) . ')' : '' ?></dt><dd>-<?= money($o['GiamGia']) ?></dd></div>
      <div class="flex justify-between"><dt>Phí vận chuyển</dt><dd><?= $ship > 0 ? money($ship) : 'Miễn phí' ?></dd></div>
      <div class="flex justify-between text-base"><dt class="font-bold">Tổng cộng</dt><dd class="font-extrabold text-primary text-xl"><?= money($o['TongTien']) ?></dd></div>
    </dl>
  </section>
  <div class="space-y-6">
    <section class="bg-surface-container-lowest rounded-xl custom-shadow-card border border-slate-100 p-5">
      <h2 class="font-headline-sm font-bold mb-3">Cập nhật trạng thái</h2>
      <?php if ($next): ?>
        <form method="post" action="admin.php?page=orderdetail&amp;id=<?= $o['MaDH'] ?>" class="space-y-2"><?= csrf_field() ?><input type="hidden" name="id" value="<?= $o['MaDH'] ?>">
          <?php foreach ($next as $n): $cancel = $n === 'Đã hủy'; ?>
            <button name="status" value="<?= e($n) ?>" <?= $cancel ? "onclick=\"return confirm('Hủy đơn hàng này? Kho sẽ được hoàn lại.')\"" : '' ?> class="w-full py-2.5 rounded-lg font-bold text-sm <?= $cancel ? 'bg-error-container text-on-error-container hover:bg-red-200' : 'bg-primary-container hover:bg-primary text-white' ?>"><?= $cancel ? 'Hủy đơn hàng' : 'Chuyển sang "' . e($n) . '"' ?></button>
          <?php endforeach; ?></form>
      <?php else: ?><p class="text-sm text-slate-500">Đơn hàng đã ở trạng thái cuối, không thể thay đổi.</p><?php endif; ?>
    </section>
    <section class="bg-surface-container-lowest rounded-xl custom-shadow-card border border-slate-100 p-5 text-sm space-y-2">
      <h2 class="font-headline-sm font-bold mb-1">Thông tin đơn hàng</h2>
      <p><span class="text-slate-500">Mã đơn:</span> <strong>#RAMBO-<?= $o['MaDH'] ?></strong></p>
      <p><span class="text-slate-500">Ngày đặt:</span> <?= dmyhi($o['NgayDat']) ?></p>
      <p><span class="text-slate-500">Khách hàng:</span> <?= e($o['TenKH']) ?> (<?= e($o['Email']) ?>)</p>
      <p><span class="text-slate-500">Người nhận:</span> <?= e($o['TenNguoiNhan']) ?> - <?= e($o['Sdt']) ?></p>
      <p><span class="text-slate-500">Địa chỉ:</span> <?= e($o['DiaChi']) ?></p>
      <p><span class="text-slate-500">Thanh toán:</span> <?= e(PAY_METHODS[$o['PhuongThuc']] ?? $o['PhuongThuc']) ?></p>
      <?php if ($o['GhiChu']): ?><p><span class="text-slate-500">Ghi chú:</span> <?= e($o['GhiChu']) ?></p><?php endif; ?>
    </section>
  </div>
</div>

