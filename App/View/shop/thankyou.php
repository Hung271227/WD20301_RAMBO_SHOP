<?php $sub = 0; foreach ($details as $d) $sub += $d['GiaBan'] * $d['SoLuong']; $ship = $o['TongTien'] - ($sub - $o['GiamGia']); ?>
<main class="max-w-3xl mx-auto w-full px-margin-mobile py-space-xl">
  <div class="text-center">
    <div class="w-20 h-20 mx-auto rounded-full bg-green-100 text-green-700 flex items-center justify-center"><span class="material-symbols-outlined text-5xl" data-weight="fill">check_circle</span></div>
    <h1 class="font-headline-xl text-headline-xl font-extrabold mt-4">Đặt hàng thành công!</h1>
    <p class="text-on-surface-variant mt-1">Mã đơn hàng của bạn: <strong class="text-primary">#RAMBO-<?= $o['MaDH'] ?></strong>. Chúng tôi sẽ sớm liên hệ xác nhận.</p>
  </div>
  <div class="bg-surface-container-lowest rounded-xl custom-shadow-card border border-slate-100 p-5 mt-6 space-y-4">
    <div class="grid sm:grid-cols-2 gap-4 text-sm">
      <div><p class="text-xs uppercase text-slate-500 font-bold">Người nhận</p><p class="font-semibold"><?= e($o['TenNguoiNhan']) ?> - <?= e($o['Sdt']) ?></p></div>
      <div><p class="text-xs uppercase text-slate-500 font-bold">Thanh toán</p><p class="font-semibold"><?= e(PAY_METHODS[$o['PhuongThuc']] ?? $o['PhuongThuc']) ?></p></div>
      <div class="sm:col-span-2"><p class="text-xs uppercase text-slate-500 font-bold">Địa chỉ giao hàng</p><p class="font-semibold"><?= e($o['DiaChi']) ?></p></div>
    </div>
    <div class="border-t border-slate-100 pt-3 space-y-2">
      <?php foreach ($details as $d): ?>
        <div class="flex items-center gap-3 text-sm"><img src="<?= e(img($d['HinhAnh'])) ?>" class="w-12 h-12 object-contain bg-[#F8F9FA] rounded" alt=""><span class="flex-1 line-clamp-1"><?= e($d['TenSP']) ?> × <?= $d['SoLuong'] ?></span><strong><?= money($d['GiaBan'] * $d['SoLuong']) ?></strong></div>
      <?php endforeach; ?>
    </div>
    <dl class="text-sm border-t border-slate-100 pt-3 space-y-1">
      <div class="flex justify-between"><dt>Giảm giá</dt><dd>-<?= money($o['GiamGia']) ?></dd></div>
      <div class="flex justify-between"><dt>Phí vận chuyển</dt><dd><?= $ship > 0 ? money($ship) : 'Miễn phí' ?></dd></div>
      <div class="flex justify-between text-base"><dt class="font-bold">Tổng thanh toán</dt><dd class="font-extrabold text-primary text-xl"><?= money($o['TongTien']) ?></dd></div>
    </dl>
  </div>
  <div class="flex flex-wrap gap-3 justify-center mt-6">
    <a href="index.php?page=orderdetail&amp;id=<?= $o['MaDH'] ?>" class="px-6 py-3 rounded-xl bg-primary-container hover:bg-primary text-white font-bold">Xem đơn hàng</a>
    <a href="index.php?page=product" class="px-6 py-3 rounded-xl border border-slate-300 hover:border-on-surface font-bold">Tiếp tục mua sắm</a>
  </div>
</main>
