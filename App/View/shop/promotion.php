<section class="relative bg-primary text-on-primary overflow-hidden">
  <div class="absolute inset-0 lego-stud-yellow opacity-40 pointer-events-none"></div>
  <div class="relative max-w-7xl mx-auto px-margin-mobile md:px-margin py-12 md:py-16 text-center">
    <span class="inline-flex items-center gap-1 bg-secondary-container text-on-secondary-container font-label-md px-3 py-1 rounded-full font-extrabold animate-pulse"><span class="material-symbols-outlined text-base" data-weight="fill">local_fire_department</span>KHUYẾN MÃI HOT</span>
    <h1 class="font-display-lg-mobile md:font-display-lg text-display-lg-mobile md:text-display-lg font-black uppercase mt-4">Ưu đãi LEGO chính hãng</h1>
    <p class="mt-3 max-w-2xl mx-auto text-primary-fixed">Săn mã giảm giá và các bộ LEGO đang giảm giá sâu. Số lượng có hạn!</p>
  </div>
</section>
<main class="max-w-7xl mx-auto w-full px-margin-mobile md:px-margin py-space-xl">
  <?php $eyebrow = 'MÃ GIẢM GIÁ'; $title = 'Voucher dành cho bạn'; include __DIR__ . '/_title.php'; ?>
  <?php if (!$coupons): ?><p class="text-slate-500">Hiện chưa có mã giảm giá nào đang hoạt động.</p><?php endif; ?>
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-space-md mb-space-xl">
    <?php foreach ($coupons as $c): ?>
      <div class="bg-surface-container-lowest rounded-xl card-resting overflow-hidden flex">
        <div class="bg-secondary-container w-28 flex flex-col items-center justify-center p-3 text-center">
          <span class="material-symbols-outlined text-3xl text-on-secondary-container" data-weight="fill">sell</span>
          <span class="font-extrabold text-lg leading-tight"><?= $c['LoaiGiam'] === 'phantram' ? (int)$c['MucGiaGiam'] . '%' : number_format($c['MucGiaGiam'] / 1000) . 'K' ?></span>
        </div>
        <div class="p-4 flex-1">
          <p class="font-label-lg font-bold text-primary tracking-widest text-base"><?= e($c['Code']) ?></p>
          <p class="text-sm font-semibold"><?= e(Coupon::label($c)) ?><?= $c['DieuKienGiam'] > 0 ? ' cho đơn từ ' . money($c['DieuKienGiam']) : '' ?></p>
          <p class="text-xs text-slate-500 mt-1">HSD: <?= dmy($c['NgayHetHan']) ?> • Còn <?= (int)$c['SoLuong'] ?> lượt</p>
          <button type="button" onclick="navigator.clipboard.writeText('<?= e($c['Code']) ?>'); this.textContent='Đã sao chép!'" class="mt-2 text-xs font-bold bg-primary-container text-white px-3 py-1.5 rounded-lg hover:bg-primary">Sao chép mã</button>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
  <?php $eyebrow = 'GIẢM GIÁ SÂU'; $title = 'Sản phẩm đang khuyến mãi'; $link = 'index.php?page=product&sale=1'; $linkText = 'Lọc theo khuyến mãi'; include __DIR__ . '/_title.php'; ?>
  <?php if (!$sale): ?><p class="text-slate-500">Hiện chưa có sản phẩm khuyến mãi.</p><?php endif; ?>
  <div class="grid grid-cols-2 lg:grid-cols-4 gap-space-md md:gap-space-lg">
    <?php foreach ($sale as $p) include __DIR__ . '/_card.php'; ?>
  </div>
</main>
