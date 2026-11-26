<section class="relative bg-secondary-container overflow-hidden">
  <div class="absolute inset-0 lego-stud-pattern opacity-40 pointer-events-none"></div>
  <div class="relative max-w-7xl mx-auto px-margin-mobile md:px-margin py-12 md:py-16 text-center">
    <span class="inline-flex items-center gap-1 bg-primary text-on-primary font-label-md px-3 py-1 rounded-full font-extrabold"><span class="material-symbols-outlined text-base" data-weight="fill">new_releases</span>NEW RELEASE</span>
    <h1 class="font-display-lg-mobile md:font-display-lg text-display-lg-mobile md:text-display-lg font-black uppercase mt-4 text-on-surface">Bộ LEGO mới về</h1>
    <p class="mt-3 max-w-2xl mx-auto text-on-secondary-container font-semibold">Những bộ LEGO vừa cập bến RAMBO STORE. Đặt sớm để sở hữu trước khi hết hàng!</p>
  </div>
</section>
<main class="max-w-7xl mx-auto w-full px-margin-mobile md:px-margin py-space-xl">
  <?php if (!$items): ?><p class="text-slate-500 text-center py-12">Chưa có bộ mới nào.</p><?php endif; ?>
  <div class="grid grid-cols-2 lg:grid-cols-4 gap-space-md md:gap-space-lg">
    <?php foreach ($items as $p) include __DIR__ . '/_card.php'; ?>
  </div>
  <div class="text-center mt-8"><a href="index.php?page=product" class="inline-block px-6 py-3 rounded-xl border-2 border-on-surface font-bold hover:bg-on-surface hover:text-white transition-colors">Xem toàn bộ sản phẩm</a></div>
</main>
