<main class="max-w-7xl mx-auto w-full px-margin-mobile md:px-margin py-space-lg">
  <div class="flex items-center justify-center gap-3 text-xs font-bold mb-6 flex-wrap">
    <span class="flex items-center gap-2 text-primary"><span class="w-6 h-6 rounded-full bg-primary text-white flex items-center justify-center">1</span>Giỏ hàng</span><span class="w-10 h-px bg-slate-300"></span>
    <span class="flex items-center gap-2 text-slate-400"><span class="w-6 h-6 rounded-full bg-slate-200 flex items-center justify-center">2</span>Thanh toán</span><span class="w-10 h-px bg-slate-300"></span>
    <span class="flex items-center gap-2 text-slate-400"><span class="w-6 h-6 rounded-full bg-slate-200 flex items-center justify-center">3</span>Hoàn tất</span>
  </div>
  <h1 class="font-headline-xl-mobile md:font-headline-xl text-headline-xl-mobile md:text-headline-xl font-extrabold mb-4">Giỏ hàng của bạn <span class="text-base text-slate-500 font-semibold">(<?= count($items) ?> sản phẩm)</span></h1>
  <?php if (!$items): ?>
    <div class="text-center bg-surface-container-lowest rounded-xl card-resting py-16">
      <span class="material-symbols-outlined text-6xl text-slate-300">shopping_cart</span>
      <p class="mt-3 font-bold">Giỏ hàng của bạn đang trống</p>
      <a href="index.php?page=product" class="inline-block mt-4 px-5 py-2.5 rounded-lg bg-primary-container text-white font-bold text-sm">Tiếp tục mua sắm</a>
    </div>
  <?php else: ?>
  <div class="grid lg:grid-cols-12 gap-space-lg">
    <section class="lg:col-span-8 space-y-3">
      <div class="bg-green-50 border border-green-200 text-green-800 text-xs font-bold rounded-xl px-4 py-2 flex items-center gap-2"><span class="material-symbols-outlined text-base" data-weight="fill">verified</span>BẢO ĐẢM 100% LEGO CHÍNH HÃNG - ĐÓNG GÓI HỘP NGUYÊN SEAL</div>
      <?php foreach ($items as $it): $pct = discount_percent(['Gia' => $it['DonGia'], 'GiaGoc' => $it['GiaGoc']]); $bad = !$it['TrangThai'] || $it['SoLuongTonKho'] < $it['SoLuong']; ?>
        <div class="bg-surface-container-lowest rounded-xl custom-shadow-resting border border-slate-100 p-4 flex gap-4 <?= $bad ? 'ring-2 ring-error/40' : '' ?>">
          <a href="index.php?page=productdetail&id=<?= $it['MaSP'] ?>" class="w-24 h-24 md:w-32 md:h-32 bg-[#F8F9FA] rounded-lg p-2 flex-shrink-0"><img src="<?= e(img($it['HinhAnh'])) ?>" class="w-full h-full object-contain" alt=""></a>
          <div class="flex-1 min-w-0 flex flex-col justify-between">
            <div class="flex justify-between gap-2">
              <div class="min-w-0">
                <p class="text-[11px] font-label-md font-bold text-primary uppercase tracking-wider"><?= e($it['TenDM']) ?><?= $it['MaHang'] ? ' • ' . e($it['MaHang']) : '' ?></p>
                <a href="index.php?page=productdetail&id=<?= $it['MaSP'] ?>"><h2 class="font-headline-sm font-bold leading-snug line-clamp-2 hover:text-primary"><?= e($it['TenSP']) ?></h2></a>
                <p class="text-xs text-slate-500 mt-1"><?= $it['SoManh'] ? number_format($it['SoManh'], 0, ',', '.') . ' mảnh ghép • ' : '' ?>Độ tuổi <?= e($it['DoTuoi']) ?> • <?= $it['SoLuongTonKho'] > 0 ? 'Còn ' . $it['SoLuongTonKho'] . ' bộ trong kho' : '<span class="text-error font-bold">Hết hàng</span>' ?></p>
                <?php if ($bad): ?><p class="text-xs text-error font-bold mt-1">Số lượng vượt tồn kho - vui lòng giảm số lượng hoặc xóa.</p><?php endif; ?>
              </div>
              <form method="post" action="index.php?page=cart_remove"><?= csrf_field() ?><input type="hidden" name="id" value="<?= $it['MaSP'] ?>"><button title="Xóa" class="text-slate-400 hover:text-error p-1"><span class="material-symbols-outlined">delete</span></button></form>
            </div>
            <div class="flex items-end justify-between flex-wrap gap-2 mt-2">
              <div><span class="font-extrabold text-primary"><?= money($it['DonGia']) ?></span><?php if ($pct): ?> <span class="text-xs text-slate-400 line-through"><?= money($it['GiaGoc']) ?></span><?php endif; ?></div>
              <form method="post" action="index.php?page=cart_update" class="flex items-center border border-slate-300 rounded-lg overflow-hidden">
                <?= csrf_field() ?><input type="hidden" name="id" value="<?= $it['MaSP'] ?>">
                <button name="qty" value="<?= max(1, $it['SoLuong'] - 1) ?>" class="w-8 h-8 hover:bg-slate-100 font-bold">-</button>
                <span class="w-10 text-center font-bold text-sm"><?= $it['SoLuong'] ?></span>
                <button name="qty" value="<?= $it['SoLuong'] + 1 ?>" class="w-8 h-8 hover:bg-slate-100 font-bold">+</button>
              </form>
              <div class="text-sm">Thành tiền: <strong class="text-base"><?= money($it['DonGia'] * $it['SoLuong']) ?></strong></div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
      <div class="flex items-center justify-between pt-2">
        <a href="index.php?page=product" class="text-sm font-bold text-primary flex items-center gap-1"><span class="material-symbols-outlined text-base">arrow_back</span>Tiếp tục mua sắm</a>
        <form method="post" action="index.php?page=cart_clear" onsubmit="return confirm('Xóa toàn bộ giỏ hàng?')"><?= csrf_field() ?><button class="text-sm text-slate-500 hover:text-error flex items-center gap-1"><span class="material-symbols-outlined text-base">delete_outline</span>Xóa toàn bộ giỏ hàng</button></form>
      </div>
    </section>
    <aside class="lg:col-span-4">
      <div class="bg-surface-container-lowest rounded-xl custom-shadow-resting border border-slate-100 p-5 lg:sticky lg:top-44">
        <h2 class="font-headline-sm font-bold mb-4">Tóm tắt đơn hàng</h2>
        <div class="mb-4">
          <label class="text-xs font-bold text-slate-500 uppercase">Mã giảm giá / Voucher</label>
          <?php if ($t['coupon']): ?>
            <form method="post" action="index.php?page=cart_coupon" class="mt-1 flex items-center justify-between bg-green-50 border border-green-200 rounded-lg px-3 py-2">
              <?= csrf_field() ?><input type="hidden" name="remove" value="1">
              <span class="text-sm font-bold text-green-800"><?= e($t['coupon']['Code']) ?> • <?= e(Coupon::label($t['coupon'])) ?></span>
              <button class="text-xs text-error font-bold">Gỡ</button>
            </form>
          <?php else: ?>
            <form method="post" action="index.php?page=cart_coupon" class="mt-1 flex gap-2">
              <?= csrf_field() ?><input name="code" class="field uppercase" placeholder="Nhập mã (VD: RAMBOVIP)">
              <button class="bg-inverse-surface text-white font-bold px-4 rounded-lg text-sm">Áp dụng</button>
            </form>
            <a href="index.php?page=promotion" class="text-xs text-primary font-bold hover:underline">Xem mã khuyến mãi</a>
          <?php endif; ?>
        </div>
        <dl class="space-y-2 text-sm border-t border-slate-100 pt-4">
          <div class="flex justify-between"><dt class="text-slate-600">Tạm tính</dt><dd class="font-bold"><?= money($t['sub']) ?></dd></div>
          <div class="flex justify-between"><dt class="text-slate-600">Giảm giá</dt><dd class="font-bold text-green-700">-<?= money($t['discount']) ?></dd></div>
          <div class="flex justify-between"><dt class="text-slate-600">Phí vận chuyển</dt><dd class="font-bold"><?= $t['ship'] ? money($t['ship']) : 'Miễn phí' ?></dd></div>
          <div class="flex justify-between border-t border-slate-100 pt-3 text-base"><dt class="font-bold">Tổng cộng</dt><dd class="font-extrabold text-primary text-xl"><?= money($t['total']) ?></dd></div>
        </dl>
        <p class="text-[11px] text-slate-500 mt-2">Miễn phí vận chuyển cho đơn từ <?= money(SHIP_FREE_FROM) ?>.</p>
        <a href="index.php?page=checkout" class="mt-4 block text-center bg-primary-container hover:bg-primary text-white font-bold py-3.5 rounded-xl brick-btn-shadow">TIẾN HÀNH THANH TOÁN</a>
      </div>
    </aside>
  </div>
  <?php endif; ?>
  <?php if (!empty($suggest)): ?>
  <section class="mt-space-xl">
    <?php $eyebrow = 'CÓ THỂ BẠN THÍCH'; $title = 'Gợi ý cho bạn'; include __DIR__ . '/_title.php'; ?>
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-space-md"><?php foreach ($suggest as $p) include __DIR__ . '/_card.php'; ?></div>
  </section>
  <?php endif; ?>
</main>
