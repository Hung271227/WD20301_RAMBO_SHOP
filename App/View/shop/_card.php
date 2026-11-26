<?php
// Thẻ sản phẩm dùng chung. Biến cần có: $p (sản phẩm), $wishIds (mảng MaSP yêu thích)
$pct = discount_percent($p);
$isNew = isset($p['NgayTao']) && strtotime($p['NgayTao']) >= strtotime('-30 days');
$out = $p['SoLuongTonKho'] <= 0;
$fav = in_array((int)$p['MaSP'], $wishIds ?? []);
$detail = 'index.php?page=productdetail&id=' . $p['MaSP'];
?>
<article class="bg-surface-container-lowest rounded-xl card-resting overflow-hidden flex flex-col justify-between group transition-all duration-300 relative border border-slate-100">
  <div class="absolute top-3 left-3 z-20 flex flex-col gap-1.5">
    <?php if ($pct): ?><span class="bg-primary text-white text-[10px] font-label-md font-bold px-2.5 py-1 rounded-md shadow-sm uppercase tracking-wider">Giảm <?= $pct ?>%</span><?php endif; ?>
    <?php if ($isNew): ?><span class="bg-secondary-container text-on-surface text-[10px] font-label-md font-bold px-2.5 py-1 rounded-md shadow-sm uppercase tracking-wider">Mới về</span><?php endif; ?>
    <?php if ($out): ?><span class="bg-inverse-surface text-white text-[10px] font-label-md font-bold px-2.5 py-1 rounded-md uppercase tracking-wider">Hết hàng</span><?php endif; ?>
  </div>
  <form method="post" action="index.php?page=wishlist_toggle" class="absolute top-3 right-3 z-20">
    <?= csrf_field() ?><?= back_field() ?><input type="hidden" name="id" value="<?= $p['MaSP'] ?>">
    <button type="submit" title="<?= $fav ? 'Bỏ yêu thích' : 'Thêm vào yêu thích' ?>" class="w-8 h-8 rounded-full bg-white/90 hover:bg-white shadow-sm flex items-center justify-center transition-colors <?= $fav ? 'text-primary' : 'text-slate-600 hover:text-primary' ?>">
      <span class="material-symbols-outlined text-base" <?= $fav ? 'data-weight="fill"' : '' ?>>favorite</span>
    </button>
  </form>
  <a href="<?= $detail ?>" class="block">
    <div class="relative w-full aspect-square bg-[#F8F9FA] p-4 flex items-center justify-center overflow-hidden">
      <img alt="<?= e($p['TenSP']) ?>" class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-300" loading="lazy" src="<?= e(img($p['HinhAnh'])) ?>" />
      <?php if ($p['SoManh'] > 0 || $p['DoTuoi']): ?>
        <div class="absolute bottom-2.5 right-2.5 bg-white/80 backdrop-blur-md px-2 py-1 rounded-md text-[10px] font-label-md font-bold text-slate-800 shadow-xs border border-white/60">
          <?= $p['SoManh'] > 0 ? number_format($p['SoManh'], 0, ',', '.') . ' pcs' : '' ?><?= ($p['SoManh'] > 0 && $p['DoTuoi']) ? ' • ' : '' ?><?= e($p['DoTuoi']) ?>
        </div>
      <?php endif; ?>
    </div>
  </a>
  <div class="p-4 flex-1 flex flex-col justify-between">
    <div>
      <div class="text-[11px] font-label-md uppercase text-primary font-bold tracking-wider mb-1"><?= e($p['TenDM']) ?></div>
      <a href="<?= $detail ?>"><h3 class="font-headline-sm text-sm text-on-surface font-bold leading-snug line-clamp-2 group-hover:text-primary transition-colors"><?= e($p['TenSP']) ?></h3></a>
      <div class="flex items-center gap-1 mt-2 mb-3">
        <div class="flex"><?= stars((float)($p['Diem'] ?? 0)) ?></div>
        <span class="text-[11px] text-slate-500 font-label-sm">(<?= (int)($p['SoDG'] ?? 0) ?> đánh giá)</span>
      </div>
    </div>
    <div class="pt-3 border-t border-slate-100 mt-2">
      <div class="flex items-baseline gap-2 mb-2">
        <span class="text-base font-extrabold text-primary font-label-lg"><?= money($p['Gia']) ?></span>
        <?php if ($pct): ?><span class="text-xs text-slate-400 line-through font-label-sm"><?= money($p['GiaGoc']) ?></span><?php endif; ?>
      </div>
      <form method="post" action="index.php?page=cart_add">
        <?= csrf_field() ?><?= back_field() ?><input type="hidden" name="id" value="<?= $p['MaSP'] ?>"><input type="hidden" name="qty" value="1">
        <button type="submit" <?= $out ? 'disabled' : '' ?> class="w-full <?= $out ? 'bg-slate-300 cursor-not-allowed' : 'bg-primary-container hover:bg-primary active:scale-95' ?> text-white font-bold py-2.5 px-3 rounded-lg text-xs transition-all duration-200 flex items-center justify-center gap-2 shadow-sm font-headline-sm">
          <span class="material-symbols-outlined text-base">shopping_bag</span><?= $out ? 'Hết hàng' : 'Thêm vào giỏ hàng' ?>
        </button>
      </form>
    </div>
  </div>
</article>
