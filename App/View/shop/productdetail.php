<?php
$pct = discount_percent($p); $out = $p['SoLuongTonKho'] <= 0;
$fav = in_array((int)$p['MaSP'], $wishIds);
$diem = (float)($p['Diem'] ?? 0); $soDG = (int)$p['SoDG'];
$maxQty = max(1, (int)$p['SoLuongTonKho']);
?>
<main class="max-w-7xl mx-auto w-full px-margin-mobile md:px-margin py-space-lg">
  <nav class="flex items-center flex-wrap gap-1 text-xs text-slate-500 mb-4">
    <a href="index.php" class="hover:text-primary flex items-center gap-1"><span class="material-symbols-outlined text-sm">home</span>Trang chủ</a>
    <span class="material-symbols-outlined text-sm">chevron_right</span>
    <a href="index.php?page=product&amp;cat[]=<?= $p['MaDM'] ?>" class="hover:text-primary"><?= e($p['TenDM']) ?></a>
    <span class="material-symbols-outlined text-sm">chevron_right</span>
    <span class="text-on-surface font-semibold line-clamp-1"><?= e($p['TenSP']) ?></span>
  </nav>

  <section class="grid grid-cols-1 lg:grid-cols-2 gap-space-xl">
    <!-- Ảnh -->
    <div>
      <div class="relative bg-surface-container-lowest rounded-2xl brick-glow border border-slate-100 aspect-square p-6 flex items-center justify-center overflow-hidden">
        <div class="absolute top-4 left-4 flex flex-col gap-2 z-10">
          <span class="bg-inverse-surface text-secondary-fixed text-[11px] font-label-md font-bold px-3 py-1 rounded-full flex items-center gap-1"><span class="material-symbols-outlined text-sm fill">verified</span>100% AUTHENTIC LEGO®</span>
          <?php if ($pct): ?><span class="bg-primary text-white text-[11px] font-label-md font-bold px-3 py-1 rounded-full w-fit">TIẾT KIỆM <?= $pct ?>%</span><?php endif; ?>
        </div>
        <img src="<?= e(img($p['HinhAnh'])) ?>" alt="<?= e($p['TenSP']) ?>" class="w-full h-full object-contain">
        <?php if ($p['SoManh'] > 0): ?><div class="absolute bottom-4 left-4 bg-white/85 backdrop-blur-md rounded-lg px-3 py-1.5 text-xs font-label-md font-bold flex items-center gap-1"><span class="material-symbols-outlined text-sm text-primary">extension</span><?= number_format($p['SoManh'], 0, ',', '.') ?> PCS</div><?php endif; ?>
      </div>
      <div class="grid grid-cols-2 gap-3 mt-4">
        <div class="bg-surface-container-lowest rounded-xl brick-glow border border-slate-100 p-3 flex items-center gap-3"><span class="material-symbols-outlined text-primary fill">verified</span><div><p class="text-sm font-bold">Chính hãng 100%</p><p class="text-xs text-slate-500">Tem chống giả & phân phối độc quyền</p></div></div>
        <div class="bg-surface-container-lowest rounded-xl brick-glow border border-slate-100 p-3 flex items-center gap-3"><span class="material-symbols-outlined text-primary">extension</span><div><p class="text-sm font-bold">Bảo hành mảnh ghép</p><p class="text-xs text-slate-500">Cấp bù mảnh thiếu miễn phí</p></div></div>
      </div>
    </div>

    <!-- Thông tin -->
    <div>
      <div class="flex flex-wrap items-center gap-2 text-xs font-label-md font-bold uppercase text-primary tracking-wider"><?= e($p['TenDM']) ?><?php if ($p['MaHang']): ?><span class="text-slate-400 normal-case font-medium">• SKU: <?= e($p['MaHang']) ?></span><?php endif; ?></div>
      <h1 class="font-headline-xl-mobile md:font-headline-lg text-headline-xl-mobile md:text-headline-lg font-extrabold mt-1"><?= e($p['TenSP']) ?></h1>
      <div class="flex flex-wrap items-center gap-3 mt-3 text-sm">
        <div class="flex items-center gap-1"><div class="flex"><?= stars($diem) ?></div><strong><?= $soDG ? number_format($diem, 1) : '—' ?></strong></div>
        <a href="#reviews" class="text-slate-500 hover:text-primary">(<?= $soDG ?> nhận xét)</a>
        <span class="text-slate-300">|</span>
        <?php if ($out): ?><span class="text-error font-bold">Hết hàng</span><?php else: ?><span class="text-green-700 font-bold">Còn hàng (<?= (int)$p['SoLuongTonKho'] ?> sản phẩm)</span><?php endif; ?>
      </div>
      <div class="bg-surface-container-low rounded-xl p-4 mt-4 flex items-baseline flex-wrap gap-3">
        <span class="text-3xl font-extrabold text-primary font-label-lg"><?= money($p['Gia']) ?></span>
        <?php if ($pct): ?><span class="text-slate-400 line-through"><?= money($p['GiaGoc']) ?></span><span class="bg-primary text-white text-xs font-bold px-2 py-1 rounded-md">-<?= $pct ?>% GIẢM</span><?php endif; ?>
      </div>
      <div class="grid grid-cols-2 gap-3 mt-4">
        <?php if ($p['SoManh'] > 0): ?><div class="border border-slate-200 rounded-xl p-3 flex items-center gap-3"><span class="material-symbols-outlined text-primary">extension</span><div><p class="text-[11px] text-slate-500 uppercase font-label-md">Số mảnh ghép</p><p class="font-bold"><?= number_format($p['SoManh'], 0, ',', '.') ?> PCS</p></div></div><?php endif; ?>
        <?php if ($p['DoTuoi']): ?><div class="border border-slate-200 rounded-xl p-3 flex items-center gap-3"><span class="material-symbols-outlined text-primary">cake</span><div><p class="text-[11px] text-slate-500 uppercase font-label-md">Độ tuổi</p><p class="font-bold"><?= e($p['DoTuoi']) ?></p></div></div><?php endif; ?>
      </div>
      <?php if ($p['MoTa']): ?><p class="mt-4 text-on-surface-variant leading-relaxed"><?= nl2br(e($p['MoTa'])) ?></p><?php endif; ?>
      <div class="mt-4 bg-secondary-container/30 border border-secondary-container rounded-xl p-3 text-sm flex gap-2"><span class="material-symbols-outlined text-secondary">card_giftcard</span><span>Tích lũy <strong><?= number_format(floor($p['Gia'] * 0.05 / 1000)) ?> điểm gạch</strong> LEGO VIP (5% giá trị đơn hàng). Miễn phí vận chuyển cho đơn từ <?= money(SHIP_FREE_FROM) ?>.</span></div>

      <!-- Mua hàng -->
      <form method="post" action="index.php?page=cart_add" class="mt-5">
        <?= csrf_field() ?><?= back_field() ?><input type="hidden" name="id" value="<?= $p['MaSP'] ?>">
        <div class="flex items-center gap-4 mb-4">
          <span class="font-bold text-sm">Số lượng:</span>
          <div class="flex items-center border border-slate-300 rounded-lg overflow-hidden">
            <button type="button" class="w-10 h-10 hover:bg-slate-100 font-bold" onclick="chg(-1)">-</button>
            <input id="qtyInput" name="qty" value="1" class="w-14 h-10 text-center border-0 focus:ring-0 font-bold" readonly>
            <button type="button" class="w-10 h-10 hover:bg-slate-100 font-bold" onclick="chg(1)">+</button>
          </div>
          <?php if (!$out && $p['SoLuongTonKho'] <= 10): ?><span class="text-xs text-primary font-bold">Chỉ còn <?= (int)$p['SoLuongTonKho'] ?> bộ tại kho</span><?php endif; ?>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
          <button type="submit" <?= $out ? 'disabled' : '' ?> class="<?= $out ? 'bg-slate-300 cursor-not-allowed' : 'bg-primary-container hover:bg-primary brick-btn-shadow' ?> text-white font-bold py-3.5 rounded-xl flex items-center justify-center gap-2"><span class="material-symbols-outlined">add_shopping_cart</span>THÊM VÀO GIỎ HÀNG</button>
          <button type="submit" name="buy_now" value="1" <?= $out ? 'disabled' : '' ?> class="<?= $out ? 'bg-slate-300 cursor-not-allowed' : 'bg-secondary-container hover:bg-secondary-fixed' ?> text-on-surface font-bold py-3.5 rounded-xl flex items-center justify-center gap-2 border border-secondary/30"><span class="material-symbols-outlined">bolt</span>MUA NGAY</button>
        </div>
      </form>
      <form method="post" action="index.php?page=wishlist_toggle" class="mt-3">
        <?= csrf_field() ?><?= back_field() ?><input type="hidden" name="id" value="<?= $p['MaSP'] ?>">
        <button type="submit" class="w-full border border-slate-300 hover:border-primary hover:text-primary py-3 rounded-xl font-bold text-sm flex items-center justify-center gap-2 transition-colors <?= $fav ? 'text-primary border-primary' : '' ?>">
          <span class="material-symbols-outlined" <?= $fav ? 'data-weight="fill"' : '' ?>>favorite</span><?= $fav ? 'Đã trong danh sách yêu thích (bấm để bỏ)' : 'Thêm vào danh sách yêu thích' ?>
        </button>
      </form>
    </div>
  </section>

  <!-- Đánh giá -->
  <section id="reviews" class="mt-space-xl grid grid-cols-1 lg:grid-cols-3 gap-space-lg">
    <div class="lg:col-span-2">
      <h2 class="font-headline-lg text-headline-lg font-extrabold mb-4">Đánh giá & bình luận (<?= $soDG ?>)</h2>
      <?php if (!$comments): ?>
        <div class="bg-surface-container-lowest rounded-xl card-resting p-8 text-center text-slate-500">Chưa có đánh giá nào. Hãy là người đầu tiên chia sẻ cảm nhận!</div>
      <?php endif; ?>
      <div class="space-y-3">
        <?php foreach ($comments as $c): ?>
          <div class="bg-surface-container-lowest rounded-xl card-resting p-4">
            <div class="flex items-center justify-between gap-2">
              <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-primary/10 text-primary font-bold flex items-center justify-center"><?= e(mb_strtoupper(mb_substr($c['HoTen'], 0, 1))) ?></div>
                <div><p class="font-bold text-sm"><?= e($c['HoTen']) ?></p><div class="flex"><?= stars((float)$c['DanhGia'], 'text-[14px]') ?></div></div>
              </div>
              <span class="text-xs text-slate-400"><?= dmy($c['NgayBL']) ?></span>
            </div>
            <p class="mt-3 text-sm text-on-surface-variant"><?= nl2br(e($c['NoiDung'])) ?></p>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
    <div>
      <div class="bg-surface-container-lowest rounded-xl card-resting p-5 lg:sticky lg:top-44">
        <h3 class="font-headline-sm font-bold mb-3">Viết đánh giá của bạn</h3>
        <?php if (is_logged()): ?>
          <form method="post" action="index.php?page=comment_add" class="space-y-3">
            <?= csrf_field() ?><input type="hidden" name="MaSP" value="<?= $p['MaSP'] ?>">
            <label class="block text-sm font-semibold">Chấm điểm
              <select name="sao" class="field mt-1"><?php for ($i = 5; $i >= 1; $i--): ?><option value="<?= $i ?>"><?= str_repeat('★', $i) . str_repeat('☆', 5 - $i) ?> (<?= $i ?>/5)</option><?php endfor; ?></select>
            </label>
            <label class="block text-sm font-semibold">Nội dung
              <textarea name="noidung" rows="4" required minlength="5" maxlength="1000" class="field mt-1" placeholder="Chia sẻ cảm nhận về bộ LEGO này..."></textarea>
            </label>
            <button class="w-full bg-primary-container hover:bg-primary text-white font-bold py-3 rounded-xl brick-btn-shadow">Gửi đánh giá</button>
          </form>
        <?php else: ?>
          <p class="text-sm text-slate-600 mb-3">Bạn cần đăng nhập để bình luận.</p>
          <a href="index.php?page=login&amp;next=<?= urlencode('index.php?page=productdetail&id=' . $p['MaSP']) ?>" class="block text-center bg-primary-container hover:bg-primary text-white font-bold py-3 rounded-xl">Đăng nhập</a>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <?php if ($related): ?>
  <section class="mt-space-xl">
    <?php $eyebrow = 'GỢI Ý CHO BẠN'; $title = 'Sản phẩm liên quan'; $link = 'index.php?page=product&cat[]=' . $p['MaDM']; $linkText = 'Xem thêm cùng chủ đề'; include __DIR__ . '/_title.php'; ?>
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-space-md md:gap-space-lg">
      <?php foreach ($related as $p2) { $pp = $p; $p = $p2; include __DIR__ . '/_card.php'; $p = $pp; } ?>
    </div>
  </section>
  <?php endif; ?>
</main>
<script>
  const MAXQ = <?= $maxQty ?>;
  function chg(d) { const i = document.getElementById('qtyInput'); i.value = Math.max(1, Math.min(MAXQ, (parseInt(i.value) || 1) + d)); }
</script>
