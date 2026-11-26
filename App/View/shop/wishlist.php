<main class="max-w-7xl mx-auto w-full px-margin-mobile md:px-margin py-space-xl">
  <?php $eyebrow = 'DANH SÁCH CỦA BẠN'; $title = 'Sản phẩm yêu thích (' . count($items) . ')'; include __DIR__ . '/_title.php'; ?>
  <?php if (!$items): ?>
    <div class="text-center bg-surface-container-lowest rounded-xl card-resting py-16">
      <span class="material-symbols-outlined text-6xl text-slate-300">favorite</span>
      <p class="mt-3 font-bold">Bạn chưa có sản phẩm yêu thích nào</p>
      <p class="text-sm text-slate-500">Bấm biểu tượng trái tim trên sản phẩm để lưu lại xem sau.</p>
      <a href="index.php?page=product" class="inline-block mt-4 px-5 py-2.5 rounded-lg bg-primary-container text-white font-bold text-sm">Khám phá sản phẩm</a>
    </div>
  <?php else: ?>
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-space-md md:gap-space-lg">
      <?php foreach ($items as $p) include __DIR__ . '/_card.php'; ?>
    </div>
  <?php endif; ?>
</main>
