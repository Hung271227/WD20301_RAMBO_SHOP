<?php $sub = 0; foreach ($details as $d) $sub += $d['GiaBan'] * $d['SoLuong']; $ship = $o['TongTien'] - ($sub - $o['GiamGia']);
$steps = ['Chờ xác nhận', 'Đã xác nhận', 'Đang giao', 'Hoàn thành']; $idx = array_search($o['TrangThai'], $steps); ?>
<main class="max-w-7xl mx-auto w-full px-margin-mobile md:px-margin py-space-lg grid lg:grid-cols-12 gap-space-lg">
  <?php $navActive = 'history'; include __DIR__ . '/_accnav.php'; ?>
  <section class="lg:col-span-9 space-y-space-md">
    <a href="index.php?page=history" class="text-sm font-bold text-primary flex items-center gap-1"><span class="material-symbols-outlined text-base">arrow_back</span>Quay lại danh sách</a>
    <div class="flex flex-wrap items-center justify-between gap-2"><h1 class="font-headline-lg text-headline-lg font-extrabold">Đơn hàng #RAMBO-<?= $o['MaDH'] ?></h1><?= status_badge($o['TrangThai']) ?></div>
    <?php if ($idx !== false): ?>
      <div class="bg-surface-container-lowest rounded-xl custom-shadow-card border border-slate-100 p-5 grid grid-cols-4 gap-2 text-center text-xs font-bold">
        <?php foreach ($steps as $i => $s): ?><div class="<?= $i <= $idx ? 'text-primary' : 'text-slate-400' ?>"><div class="w-9 h-9 mx-auto rounded-full flex items-center justify-center <?= $i <= $idx ? 'bg-primary text-white' : 'bg-slate-200' ?>"><?= $i + 1 ?></div><p class="mt-1"><?= $s ?></p></div><?php endforeach; ?>
      </div>
    <?php endif; ?>
    <div class="bg-surface-container-lowest rounded-xl custom-shadow-card border border-slate-100 p-5 grid sm:grid-cols-2 gap-4 text-sm">
      <div><p class="text-xs uppercase text-slate-500 font-bold">Người nhận</p><p class="font-semibold"><?= e($o['TenNguoiNhan']) ?> - <?= e($o['Sdt']) ?></p></div>
      <div><p class="text-xs uppercase text-slate-500 font-bold">Ngày đặt</p><p class="font-semibold"><?= dmyhi($o['NgayDat']) ?></p></div>
      <div><p class="text-xs uppercase text-slate-500 font-bold">Địa chỉ</p><p class="font-semibold"><?= e($o['DiaChi']) ?></p></div>
      <div><p class="text-xs uppercase text-slate-500 font-bold">Thanh toán</p><p class="font-semibold"><?= e(PAY_METHODS[$o['PhuongThuc']] ?? $o['PhuongThuc']) ?></p></div>
      <?php if ($o['GhiChu']): ?><div class="sm:col-span-2"><p class="text-xs uppercase text-slate-500 font-bold">Ghi chú</p><p><?= e($o['GhiChu']) ?></p></div><?php endif; ?>
    </div>
    <div class="bg-surface-container-lowest rounded-xl custom-shadow-card border border-slate-100 p-5 space-y-3">
      <?php foreach ($details as $d): ?>
        <div class="flex gap-3 items-center"><img src="<?= e(img($d['HinhAnh'])) ?>" class="w-16 h-16 object-contain bg-[#F8F9FA] rounded-lg p-1" alt="">
          <div class="flex-1 min-w-0"><a class="font-bold text-sm hover:text-primary" href="index.php?page=productdetail&id=<?= $d['MaSP'] ?>"><?= e($d['TenSP']) ?></a><p class="text-xs text-slate-500"><?= money($d['GiaBan']) ?> × <?= $d['SoLuong'] ?></p></div><strong><?= money($d['GiaBan'] * $d['SoLuong']) ?></strong></div>
      <?php endforeach; ?>
      <dl class="text-sm border-t border-slate-100 pt-3 space-y-1">
        <div class="flex justify-between"><dt>Tạm tính</dt><dd><?= money($sub) ?></dd></div>
        <div class="flex justify-between"><dt>Giảm giá<?= $o['Code'] ? ' (' . e($o['Code']) . ')' : '' ?></dt><dd>-<?= money($o['GiamGia']) ?></dd></div>
        <div class="flex justify-between"><dt>Phí vận chuyển</dt><dd><?= $ship > 0 ? money($ship) : 'Miễn phí' ?></dd></div>
        <div class="flex justify-between text-base"><dt class="font-bold">Tổng cộng</dt><dd class="font-extrabold text-primary text-xl"><?= money($o['TongTien']) ?></dd></div>
      </dl>
      <?php if ($o['TrangThai'] === 'Chờ xác nhận'): ?>
        <form method="post" action="index.php?page=order_cancel" onsubmit="return confirm('Bạn chắc chắn muốn hủy đơn hàng này?')"><?= csrf_field() ?><input type="hidden" name="id" value="<?= $o['MaDH'] ?>"><button class="px-5 py-2.5 rounded-lg bg-error-container text-on-error-container text-sm font-bold hover:bg-red-200">Hủy đơn hàng</button></form>
      <?php endif; ?>
    </div>
  </section>
</main>
