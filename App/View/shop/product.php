<?php
// Trang danh sách sản phẩm + bộ lọc (GET)
$qs = $_GET; unset($qs['p']);
function pg_url($qs, $n) { return 'index.php?' . http_build_query(array_merge($qs, ['p' => $n])); }
$ageOpts = [4 => '4 - 7 tuổi', 8 => '8 - 11 tuổi', 12 => '12 - 16 tuổi', 18 => '16+ / 18+ (AFOL)'];
$pcsOpts = ['lt500' => 'Dưới 500 pcs', '500-1500' => '500 - 1500 pcs', '1500-3000' => '1500 - 3000 pcs', 'gt3000' => 'Trên 3000 pcs (Chuyên gia)'];
$sorts = ['new' => 'Mới nhất', 'best' => 'Bán chạy nhất', 'price_asc' => 'Giá: Thấp đến Cao', 'price_desc' => 'Giá: Cao đến Thấp', 'rating' => 'Đánh giá cao nhất', 'sale' => 'Giảm nhiều nhất'];
$quick = [[0, 1000000, 'Dưới 1 triệu'], [1000000, 3000000, '1 - 3 triệu'], [3000000, 5000000, '3 - 5 triệu'], [5000000, 10000000, '5 - 10 triệu'], [10000000, 0, 'Trên 10 triệu']];
$from = $total ? ($page - 1) * $perPage + 1 : 0; $to = min($total, $page * $perPage);
?>
<main class="max-w-7xl mx-auto w-full px-margin-mobile md:px-margin py-space-lg">
  <nav class="flex items-center gap-1 text-xs text-slate-500 mb-4">
    <a href="index.php" class="hover:text-primary">Trang chủ</a><span class="material-symbols-outlined text-sm">chevron_right</span><span class="text-on-surface font-semibold">Tất cả sản phẩm</span>
  </nav>
  <div class="grid grid-cols-1 lg:grid-cols-12 gap-space-lg">
    <!-- Bộ lọc -->
    <aside class="lg:col-span-3">
      <form method="get" action="index.php" id="filterForm" class="bg-surface-container-lowest rounded-xl card-resting p-5 space-y-6 lg:sticky lg:top-44">
        <input type="hidden" name="page" value="product">
        <div class="flex items-center justify-between">
          <h2 class="font-headline-sm font-bold flex items-center gap-2"><span class="material-symbols-outlined text-primary">tune</span>Bộ Lọc Tìm Kiếm</h2>
          <a href="index.php?page=product" class="text-xs text-primary font-bold hover:underline">Đặt lại</a>
        </div>
        <div>
          <h3 class="font-label-lg text-label-lg uppercase text-on-surface-variant mb-2">Từ khóa</h3>
          <input class="field" type="text" name="q" value="<?= e($f['q']) ?>" placeholder="Tên bộ, mã sản phẩm...">
        </div>
        <div>
          <h3 class="font-label-lg text-label-lg uppercase text-on-surface-variant mb-2">Chủ đề (Themes)</h3>
          <div class="space-y-1.5">
            <?php foreach ($categories as $c): ?>
              <label class="flex items-center justify-between gap-2 text-sm cursor-pointer hover:text-primary">
                <span class="flex items-center gap-2"><input type="checkbox" name="cat[]" value="<?= $c['MaDM'] ?>" class="rounded text-primary focus:ring-primary" <?= in_array($c['MaDM'], $f['cat']) ? 'checked' : '' ?>><?= e($c['TenDM']) ?></span>
                <span class="text-slate-400 text-xs">(<?= (int)$c['SoSP'] ?>)</span>
              </label>
            <?php endforeach; ?>
          </div>
        </div>
        <div>
          <h3 class="font-label-lg text-label-lg uppercase text-on-surface-variant mb-2">Khoảng giá (VNĐ)</h3>
          <div class="flex items-center gap-2">
            <input class="field" type="number" min="0" step="10000" name="min" value="<?= $f['min'] ?: '' ?>" placeholder="Từ">
            <span class="text-slate-400">-</span>
            <input class="field" type="number" min="0" step="10000" name="max" value="<?= $f['max'] ?: '' ?>" placeholder="Đến">
          </div>
          <div class="flex flex-wrap gap-1.5 mt-2">
            <?php foreach ($quick as [$a, $b, $l]):
              $u = 'index.php?' . http_build_query(array_merge($qs, ['min' => $a ?: null, 'max' => $b ?: null])); ?>
              <a href="<?= e($u) ?>" class="px-2.5 py-1 rounded-full text-[11px] font-bold <?= ($f['min'] == $a && $f['max'] == $b) ? 'bg-inverse-surface text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' ?>"><?= $l ?></a>
            <?php endforeach; ?>
          </div>
        </div>
        <div>
          <h3 class="font-label-lg text-label-lg uppercase text-on-surface-variant mb-2">Độ tuổi</h3>
          <div class="space-y-1.5">
            <?php foreach ($ageOpts as $k => $l): ?>
              <label class="flex items-center gap-2 text-sm cursor-pointer hover:text-primary"><input type="checkbox" name="age[]" value="<?= $k ?>" class="rounded text-primary focus:ring-primary" <?= in_array((string)$k, array_map('strval', $f['age'])) ? 'checked' : '' ?>><?= $l ?></label>
            <?php endforeach; ?>
          </div>
        </div>
        <div>
          <h3 class="font-label-lg text-label-lg uppercase text-on-surface-variant mb-2">Số mảnh ghép</h3>
          <div class="space-y-1.5">
            <?php foreach ($pcsOpts as $k => $l): ?>
              <label class="flex items-center gap-2 text-sm cursor-pointer hover:text-primary"><input type="checkbox" name="pieces[]" value="<?= $k ?>" class="rounded text-primary focus:ring-primary" <?= in_array($k, $f['pieces']) ? 'checked' : '' ?>><?= $l ?></label>
            <?php endforeach; ?>
          </div>
        </div>
        <div>
          <h3 class="font-label-lg text-label-lg uppercase text-on-surface-variant mb-2">Tình trạng</h3>
          <label class="flex items-center gap-2 text-sm cursor-pointer mb-1.5"><input type="checkbox" name="instock" value="1" class="rounded text-primary focus:ring-primary" <?= $f['instock'] ? 'checked' : '' ?>>Còn hàng</label>
          <label class="flex items-center gap-2 text-sm cursor-pointer"><input type="checkbox" name="sale" value="1" class="rounded text-primary focus:ring-primary" <?= $f['sale'] ? 'checked' : '' ?>>Đang khuyến mãi</label>
        </div>
        <button type="submit" class="w-full bg-primary-container hover:bg-primary text-white font-bold py-3 rounded-xl brick-btn-shadow transition-all">Áp dụng bộ lọc</button>
      </form>
    </aside>
    <!-- Kết quả -->
    <section class="lg:col-span-9">
      <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4 bg-surface-container-lowest rounded-xl card-resting px-4 py-3">
        <p class="text-sm text-on-surface-variant">Tìm thấy <strong class="text-primary text-base"><?= $total ?></strong> sản phẩm<?= $total ? ' | Hiển thị ' . $from . ' - ' . $to : '' ?><?= $f['q'] !== '' ? ' cho "<strong>' . e($f['q']) . '</strong>"' : '' ?></p>
        <label class="flex items-center gap-2 text-sm">Sắp xếp:
          <select name="sort" form="filterForm" class="field !py-1.5 !w-auto" onchange="document.getElementById('filterForm').submit()">
            <?php foreach ($sorts as $k => $l): ?><option value="<?= $k ?>" <?= $f['sort'] === $k ? 'selected' : '' ?>><?= $l ?></option><?php endforeach; ?>
          </select>
        </label>
      </div>
      <?php if (!$items): ?>
        <div class="text-center bg-surface-container-lowest rounded-xl card-resting py-16">
          <span class="material-symbols-outlined text-6xl text-slate-300">search_off</span>
          <p class="mt-3 font-bold">Không tìm thấy sản phẩm phù hợp</p>
          <p class="text-sm text-slate-500">Hãy thử đổi từ khóa hoặc bỏ bớt bộ lọc.</p>
          <a href="index.php?page=product" class="inline-block mt-4 px-5 py-2.5 rounded-lg bg-primary-container text-white font-bold text-sm">Xem tất cả sản phẩm</a>
        </div>
      <?php else: ?>
        <div class="grid grid-cols-2 xl:grid-cols-3 gap-space-md md:gap-space-lg">
          <?php foreach ($items as $p) include __DIR__ . '/_card.php'; ?>
        </div>
        <?php if ($pages > 1): ?>
          <div class="flex items-center justify-center gap-1.5 mt-8 flex-wrap">
            <?php if ($page > 1): ?><a class="w-10 h-10 rounded-lg border border-slate-200 flex items-center justify-center hover:border-primary" href="<?= e(pg_url($qs, $page - 1)) ?>"><span class="material-symbols-outlined">chevron_left</span></a><?php endif; ?>
            <?php for ($i = 1; $i <= $pages; $i++): ?>
              <a class="w-10 h-10 rounded-lg flex items-center justify-center font-bold text-sm <?= $i == $page ? 'bg-primary-container text-white' : 'border border-slate-200 hover:border-primary' ?>" href="<?= e(pg_url($qs, $i)) ?>"><?= $i ?></a>
            <?php endfor; ?>
            <?php if ($page < $pages): ?><a class="w-10 h-10 rounded-lg border border-slate-200 flex items-center justify-center hover:border-primary" href="<?= e(pg_url($qs, $page + 1)) ?>"><span class="material-symbols-outlined">chevron_right</span></a><?php endif; ?>
          </div>
        <?php endif; ?>
      <?php endif; ?>
    </section>
  </div>
</main>
