<?php $maxM = max(1, max(array_column($months, 'value'))); $totalO = max(1, array_sum($byStatus));
$cards = [['payments', 'Doanh thu (đơn hoàn thành)', money($s['doanhthu']), 'Tháng này: ' . money($s['doanhthu_thang']), 'bg-primary'],
          ['receipt_long', 'Tổng đơn hàng', $s['tong_don'], $s['cho_xn'] . ' đơn chờ xác nhận', 'bg-blue-600'],
          ['group', 'Khách hàng', $s['khach'], 'Tài khoản khách đã đăng ký', 'bg-emerald-600'],
          ['inventory_2', 'Sản phẩm', $s['sanpham'], $s['binhluan'] . ' bình luận / đánh giá', 'bg-amber-500']]; ?>
<div class="grid sm:grid-cols-2 xl:grid-cols-4 gap-4">
  <?php foreach ($cards as [$ic, $lb, $v, $sub, $bg]): ?>
    <div class="bg-surface-container-lowest rounded-xl custom-shadow-card border border-slate-100 p-5 flex items-center gap-4">
      <div class="w-12 h-12 rounded-xl <?= $bg ?> text-white flex items-center justify-center flex-shrink-0"><span class="material-symbols-outlined"><?= $ic ?></span></div>
      <div class="min-w-0"><p class="text-xs text-slate-500 font-semibold"><?= $lb ?></p><p class="text-xl font-extrabold truncate"><?= $v ?></p><p class="text-xs text-slate-500"><?= $sub ?></p></div>
    </div>
  <?php endforeach; ?>
</div>
<div class="grid xl:grid-cols-3 gap-6">
  <section class="xl:col-span-2 bg-surface-container-lowest rounded-xl custom-shadow-card border border-slate-100 p-5">
    <h2 class="font-headline-sm font-bold mb-4">Doanh thu 6 tháng gần nhất</h2>
    <div class="flex items-end gap-3 h-56">
      <?php foreach ($months as $m): $h = round($m['value'] / $maxM * 100); ?>
        <div class="flex-1 flex flex-col items-center justify-end h-full gap-1">
          <span class="text-[10px] font-bold text-slate-600"><?= $m['value'] ? number_format($m['value'] / 1000000, 1, ',', '.') . 'tr' : '0' ?></span>
          <div class="w-full rounded-t-lg bg-primary-container hover:bg-primary transition-colors" style="height: <?= max($h, 2) ?>%" title="<?= money($m['value']) ?>"></div>
          <span class="text-[11px] text-slate-500"><?= $m['label'] ?></span>
        </div>
      <?php endforeach; ?>
    </div>
  </section>
  <section class="bg-surface-container-lowest rounded-xl custom-shadow-card border border-slate-100 p-5">
    <h2 class="font-headline-sm font-bold mb-4">Đơn hàng theo trạng thái</h2>
    <div class="space-y-3">
      <?php foreach (ORDER_STATUSES as $st): $n = (int)($byStatus[$st] ?? 0); ?>
        <a href="admin.php?page=order&amp;status=<?= urlencode($st) ?>" class="block">
          <div class="flex justify-between text-sm mb-1"><span><?= status_badge($st) ?></span><strong><?= $n ?></strong></div>
          <div class="h-2 rounded-full bg-slate-100"><div class="h-2 rounded-full bg-primary-container" style="width: <?= round($n / $totalO * 100) ?>%"></div></div>
        </a>
      <?php endforeach; ?>
    </div>
  </section>
</div>
<div class="grid xl:grid-cols-3 gap-6">
  <section class="xl:col-span-2 bg-surface-container-lowest rounded-xl custom-shadow-card border border-slate-100 p-5">
    <div class="flex items-center justify-between mb-3"><h2 class="font-headline-sm font-bold">Đơn hàng mới nhất</h2><a href="admin.php?page=order" class="text-sm text-primary font-bold">Xem tất cả</a></div>
    <div class="overflow-x-auto"><table class="w-full text-sm">
      <thead><tr class="text-left text-xs uppercase text-slate-500 border-b"><th class="py-2">Mã</th><th>Khách hàng</th><th>Ngày đặt</th><th class="text-right">Tổng tiền</th><th class="text-center">Trạng thái</th></tr></thead>
      <tbody class="divide-y"><?php foreach ($recent as $o): ?>
        <tr class="hover:bg-slate-50"><td class="py-2.5"><a class="font-bold text-primary" href="admin.php?page=orderdetail&amp;id=<?= $o['MaDH'] ?>">#RAMBO-<?= $o['MaDH'] ?></a></td><td><?= e($o['TenKH']) ?></td><td><?= dmy($o['NgayDat']) ?></td><td class="text-right font-bold"><?= money($o['TongTien']) ?></td><td class="text-center"><?= status_badge($o['TrangThai']) ?></td></tr>
      <?php endforeach; ?></tbody></table></div>
  </section>
  <div class="space-y-6">
    <section class="bg-surface-container-lowest rounded-xl custom-shadow-card border border-slate-100 p-5">
      <h2 class="font-headline-sm font-bold mb-3">Bán chạy nhất</h2>
      <?php if (!$top): ?><p class="text-sm text-slate-500">Chưa có dữ liệu.</p><?php endif; ?>
      <div class="space-y-3"><?php foreach ($top as $t): ?>
        <div class="flex items-center gap-3"><img src="<?= e(img($t['HinhAnh'])) ?>" class="w-11 h-11 object-contain bg-[#F8F9FA] rounded" alt=""><div class="flex-1 min-w-0"><p class="text-sm font-bold line-clamp-1"><?= e($t['TenSP']) ?></p><p class="text-xs text-slate-500">Đã bán <?= (int)$t['DaBan'] ?> • <?= money($t['DoanhThu']) ?></p></div></div>
      <?php endforeach; ?></div>
    </section>
    <section class="bg-surface-container-lowest rounded-xl custom-shadow-card border border-slate-100 p-5">
      <h2 class="font-headline-sm font-bold mb-3 flex items-center gap-2"><span class="material-symbols-outlined text-amber-500">warning</span>Sắp hết hàng</h2>
      <?php if (!$low): ?><p class="text-sm text-slate-500">Tồn kho đều ổn.</p><?php endif; ?>
      <div class="space-y-2"><?php foreach ($low as $l): ?>
        <a href="admin.php?page=product&amp;edit=<?= $l['MaSP'] ?>" class="flex items-center justify-between gap-2 text-sm hover:text-primary"><span class="line-clamp-1"><?= e($l['TenSP']) ?></span><span class="font-extrabold <?= $l['SoLuongTonKho'] <= 5 ? 'text-error' : 'text-amber-600' ?>"><?= (int)$l['SoLuongTonKho'] ?></span></a>
      <?php endforeach; ?></div>
    </section>
  </div>
</div>
