<?php /* Tiêu đề section: $eyebrow, $title, $link (tùy chọn), $linkText */ ?>
<div class="flex flex-col md:flex-row md:items-end justify-between gap-2 mb-space-lg">
  <div>
    <span class="font-label-md text-label-md text-primary font-bold tracking-widest uppercase"><?= e($eyebrow) ?></span>
    <h2 class="font-headline-xl-mobile md:font-headline-xl text-headline-xl-mobile md:text-headline-xl font-extrabold text-on-surface mt-1"><?= e($title) ?></h2>
  </div>
  <?php if (!empty($link)): ?>
    <a class="font-label-lg text-label-lg text-primary hover:text-primary-container font-bold flex items-center gap-1 transition-colors" href="<?= e($link) ?>"><span><?= e($linkText ?? 'Xem tất cả') ?></span><span class="material-symbols-outlined text-[18px]">chevron_right</span></a>
  <?php endif; ?>
</div>
