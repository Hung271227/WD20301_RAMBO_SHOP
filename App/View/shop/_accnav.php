<?php /* Menu bên trái khu vực tài khoản. Biến: $navActive */
$__au = current_user(); $__items = [['account', 'person', 'Thông tin cá nhân'], ['history', 'package_2', 'Đơn hàng của tôi'], ['wishlist', 'favorite', 'Sản phẩm yêu thích'], ['promotion', 'loyalty', 'Ưu đãi & Voucher']]; ?>
<aside class="lg:col-span-3">
  <div class="bg-surface-container-lowest rounded-xl custom-shadow-card border border-slate-100 p-5 lg:sticky lg:top-44">
    <div class="flex items-center gap-3 pb-4 border-b border-slate-100">
      <div class="w-12 h-12 rounded-full bg-primary text-white font-extrabold text-lg flex items-center justify-center"><?= e(mb_strtoupper(mb_substr($__au['HoTen'], 0, 1))) ?></div>
      <div class="min-w-0"><p class="font-bold truncate"><?= e($__au['HoTen']) ?></p><p class="text-xs text-slate-500 truncate"><?= e($__au['Email']) ?></p></div>
    </div>
    <nav class="mt-3 space-y-1">
      <?php foreach ($__items as [$pg, $ic, $lb]): ?>
        <a href="index.php?page=<?= $pg ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-semibold <?= $navActive === $pg ? 'bg-primary/10 text-primary' : 'hover:bg-slate-50' ?>"><span class="material-symbols-outlined text-[20px]"><?= $ic ?></span><?= $lb ?></a>
      <?php endforeach; ?>
      <a href="logout.php" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-semibold text-error hover:bg-error-container"><span class="material-symbols-outlined text-[20px]">logout</span>Đăng xuất</a>
    </nav>
  </div>
</aside>
