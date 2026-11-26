<main class="max-w-7xl mx-auto w-full px-margin-mobile md:px-margin py-space-lg grid lg:grid-cols-12 gap-space-lg">
  <?php $navActive = 'history'; include __DIR__ . '/_accnav.php'; $all = array_sum($counts); ?>
  <section class="lg:col-span-9">
    <h1 class="font-headline-lg text-headline-lg font-extrabold">Đơn hàng của tôi</h1>
    <p class="text-sm text-on-surface-variant mb-4">Theo dõi hành trình các bộ LEGO bạn đã đặt.</p>
    <div class="flex gap-2 overflow-x-auto no-scrollbar pb-2">
      <a href="index.php?page=history" class="whitespace-nowrap px-4 py-2 rounded-full text-sm font-bold <?= $status === '' ? 'bg-inverse-surface text-white' : 'bg-slate-100 hover:bg-slate-200' ?>">Tất cả (<?= $all ?>)</a>
      <?php foreach (ORDER_STATUSES as $s): ?>
        <a href="index.php?page=history&amp;status=<?= urlencode($s) ?>" class="whitespace-nowrap px-4 py-2 rounded-full text-sm font-bold <?= $status === $s ? 'bg-inverse-surface text-white' : 'bg-slate-100 hover:bg-slate-200' ?>"><?= $s ?> (<?= (int)($counts[$s] ?? 0) ?>)</a>
      <?php endforeach; ?>
    </div>
    <form method="get" class="mt-3 flex gap-2"><input type="hidden" name="page" value="history"><?php if ($status): ?><input type="hidden" name="status" value="<?= e($status) ?>"><?php endif; ?>
      <input name="q" value="<?= e($q) ?>" class="field" placeholder="Tìm theo mã đơn hàng hoặc tên bộ LEGO..."><button class="bg-primary-container text-white font-bold px-5 rounded-lg">Tìm</button></form>
    <?php if (!$orders): ?>
      <div class="text-center bg-surface-container-lowest rounded-xl card-resting py-14 mt-4"><span class="material-symbols-outlined text-6xl text-slate-300">package_2</span><p class="mt-2 font-bold">Chưa có đơn hàng nào</p><a href="index.php?page=product" class="inline-block mt-3 px-5 py-2.5 rounded-lg bg-primary-container text-white font-bold text-sm">Mua sắm ngay</a></div>
    <?php endif; ?>
    <div class="space-y-4 mt-4">
      <?php foreach ($orders as $o): ?>
        <div class="bg-surface-container-lowest rounded-xl custom-shadow-card border border-slate-100 overflow-hidden">
          <div class="flex flex-wrap items-center justify-between gap-2 px-5 py-3 bg-slate-50 border-b border-slate-100 text-sm">
            <div><strong>#RAMBO-<?= $o['MaDH'] ?></strong> <span class="text-slate-400 mx-1">|</span> Ngày đặt: <?= dmyhi($o['NgayDat']) ?></div><?= status_badge($o['TrangThai']) ?>
          </div>
          <div class="p-5 space-y-3">
            <?php foreach ($o['items'] as $d): ?>
              <div class="flex gap-3 items-center"><img src="<?= e(img($d['HinhAnh'])) ?>" class="w-16 h-16 object-contain bg-[#F8F9FA] rounded-lg p-1" alt="">
                <div class="flex-1 min-w-0"><p class="text-[11px] text-primary font-bold uppercase"><?= e($d['TenDM']) ?></p><a class="font-bold text-sm line-clamp-1 hover:text-primary" href="index.php?page=productdetail&id=<?= $d['MaSP'] ?>"><?= e($d['TenSP']) ?></a><p class="text-xs text-slate-500">Số lượng: <?= $d['SoLuong'] ?></p></div>
                <strong class="text-sm"><?= money($d['GiaBan']) ?></strong></div>
            <?php endforeach; ?>
          </div>
          <div class="flex flex-wrap items-center justify-between gap-3 px-5 py-3 border-t border-slate-100">
            <p class="text-sm">Tổng tiền (<?= (int)$o['SoMon'] ?> món): <strong class="text-primary text-lg"><?= money($o['TongTien']) ?></strong></p>
            <div class="flex gap-2">
              <a href="index.php?page=orderdetail&amp;id=<?= $o['MaDH'] ?>" class="px-4 py-2 rounded-lg border border-slate-300 hover:border-on-surface text-sm font-bold">Xem chi tiết</a>
              <?php if ($o['TrangThai'] === 'Chờ xác nhận'): ?>
                <form method="post" action="index.php?page=order_cancel" onsubmit="return confirm('Bạn chắc chắn muốn hủy đơn hàng này?')"><?= csrf_field() ?><?= back_field() ?><input type="hidden" name="id" value="<?= $o['MaDH'] ?>"><button class="px-4 py-2 rounded-lg bg-error-container text-on-error-container text-sm font-bold hover:bg-red-200">Hủy đơn</button></form>
              <?php endif; ?>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </section>
</main>
