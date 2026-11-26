<main class="max-w-7xl mx-auto w-full px-margin-mobile md:px-margin py-space-lg">
  <div class="flex items-center justify-center gap-3 text-xs font-bold mb-6 flex-wrap">
    <span class="flex items-center gap-2 text-slate-400"><span class="w-6 h-6 rounded-full bg-slate-200 flex items-center justify-center">1</span>Giỏ hàng</span><span class="w-10 h-px bg-slate-300"></span>
    <span class="flex items-center gap-2 text-primary"><span class="w-6 h-6 rounded-full bg-primary text-white flex items-center justify-center">2</span>Thanh toán</span><span class="w-10 h-px bg-slate-300"></span>
    <span class="flex items-center gap-2 text-slate-400"><span class="w-6 h-6 rounded-full bg-slate-200 flex items-center justify-center">3</span>Hoàn tất</span>
  </div>
  <?php if ($errors): ?>
    <div class="mb-4 bg-error-container text-on-error-container rounded-xl px-4 py-3 text-sm font-semibold"><ul class="list-disc pl-5"><?php foreach ($errors as $er): ?><li><?= e($er) ?></li><?php endforeach; ?></ul></div>
  <?php endif; ?>
  <form method="post" action="index.php?page=checkout" class="grid lg:grid-cols-12 gap-space-lg">
    <?= csrf_field() ?>
    <div class="lg:col-span-8 space-y-space-md">
      <section class="bg-surface-container-lowest rounded-xl custom-shadow-card border border-slate-100 p-5">
        <h2 class="font-headline-sm font-bold flex items-center gap-2 mb-4"><span class="material-symbols-outlined text-primary">person</span>1. Thông tin người nhận</h2>
        <div class="grid sm:grid-cols-2 gap-4">
          <label class="text-sm font-semibold">Họ và tên *<input name="ten" required class="field mt-1" value="<?= e($old['ten']) ?>" placeholder="Nhập họ và tên"></label>
          <label class="text-sm font-semibold">Số điện thoại *<input name="sdt" required class="field mt-1" value="<?= e($old['sdt']) ?>" placeholder="09xx xxx xxx"></label>
        </div>
      </section>
      <section class="bg-surface-container-lowest rounded-xl custom-shadow-card border border-slate-100 p-5">
        <h2 class="font-headline-sm font-bold flex items-center gap-2 mb-4"><span class="material-symbols-outlined text-primary">location_on</span>2. Địa chỉ giao nhận hàng</h2>
        <label class="text-sm font-semibold block">Địa chỉ đầy đủ *<input name="diachi" required class="field mt-1" value="<?= e($old['diachi']) ?>" placeholder="Số nhà, đường, phường/xã, quận/huyện, tỉnh/thành phố"></label>
        <label class="text-sm font-semibold block mt-4">Ghi chú đơn hàng<textarea name="ghichu" rows="2" class="field mt-1" placeholder="Yêu cầu đóng gói, giờ giao..."><?= e($old['ghichu']) ?></textarea></label>
      </section>
      <section class="bg-surface-container-lowest rounded-xl custom-shadow-card border border-slate-100 p-5">
        <h2 class="font-headline-sm font-bold flex items-center gap-2 mb-4"><span class="material-symbols-outlined text-primary">payments</span>3. Phương thức thanh toán</h2>
        <div class="space-y-2">
          <?php foreach (PAY_METHODS as $k => $l): ?>
            <label class="flex items-center gap-3 border border-slate-200 rounded-xl px-4 py-3 cursor-pointer hover:border-primary has-[:checked]:border-primary has-[:checked]:bg-primary/5">
              <input type="radio" name="pt" value="<?= e($k) ?>" class="text-primary focus:ring-primary" <?= $old['pt'] === $k ? 'checked' : '' ?>><span class="text-sm font-semibold"><?= e($l) ?></span>
            </label>
          <?php endforeach; ?>
        </div>
        <p class="text-xs text-slate-500 mt-2">Đây là bản demo: các phương thức online chỉ ghi nhận lựa chọn, chưa kết nối cổng thanh toán thật.</p>
      </section>
    </div>
    <aside class="lg:col-span-4">
      <div class="bg-surface-container-lowest rounded-xl custom-shadow-elevated border border-slate-100 p-5 lg:sticky lg:top-44">
        <h3 class="font-headline-sm font-bold mb-3">Tóm tắt đơn hàng <span class="text-xs bg-slate-100 rounded-full px-2 py-0.5 ml-1"><?= count($items) ?> MÓN</span></h3>
        <div class="space-y-3 max-h-64 overflow-y-auto pr-1">
          <?php foreach ($items as $it): ?>
            <div class="flex gap-3">
              <div class="relative w-14 h-14 bg-[#F8F9FA] rounded-lg p-1 flex-shrink-0"><img src="<?= e(img($it['HinhAnh'])) ?>" class="w-full h-full object-contain" alt=""><span class="absolute -top-2 -right-2 bg-inverse-surface text-white text-[10px] font-bold rounded-full w-5 h-5 flex items-center justify-center"><?= $it['SoLuong'] ?></span></div>
              <div class="flex-1 min-w-0"><p class="text-sm font-bold line-clamp-2"><?= e($it['TenSP']) ?></p></div>
              <div class="text-sm font-bold"><?= money($it['DonGia'] * $it['SoLuong']) ?></div>
            </div>
          <?php endforeach; ?>
        </div>
        <dl class="space-y-2 text-sm border-t border-slate-100 mt-4 pt-4">
          <div class="flex justify-between"><dt>Tạm tính</dt><dd class="font-bold"><?= money($t['sub']) ?></dd></div>
          <div class="flex justify-between"><dt>Giảm giá<?= $t['coupon'] ? ' (' . e($t['coupon']['Code']) . ')' : '' ?></dt><dd class="font-bold text-green-700">-<?= money($t['discount']) ?></dd></div>
          <div class="flex justify-between"><dt>Phí vận chuyển</dt><dd class="font-bold"><?= $t['ship'] ? money($t['ship']) : 'Miễn phí' ?></dd></div>
          <div class="flex justify-between border-t border-slate-100 pt-3 text-base"><dt class="font-bold">Tổng cộng</dt><dd class="font-extrabold text-primary text-xl"><?= money($t['total']) ?></dd></div>
        </dl>
        <?php if (!$t['coupon']): ?><a href="index.php?page=cart" class="text-xs text-primary font-bold hover:underline">Có mã giảm giá? Nhập tại giỏ hàng</a><?php endif; ?>
        <button type="submit" class="mt-4 w-full bg-primary-container hover:bg-primary text-white font-bold py-3.5 rounded-xl brick-btn-shadow">XÁC NHẬN ĐẶT HÀNG</button>
        <a href="index.php?page=cart" class="mt-2 block text-center text-sm text-slate-500 hover:text-primary">← Quay lại giỏ hàng</a>
      </div>
    </aside>
  </form>
</main>
