<?php
$__cur = $_GET['page'] ?? 'dashboard'; if ($__cur === 'orderdetail') $__cur = 'order';
$menu = [['dashboard', 'dashboard', 'Dashboard'], ['category', 'category', 'Danh mục'], ['product', 'inventory_2', 'Sản phẩm'], ['user', 'group', 'Khách hàng'],
         ['order', 'receipt_long', 'Đơn hàng'], ['coupon', 'sell', 'Mã giảm giá'], ['comment', 'forum', 'Bình luận']];
$__au = current_user();
?>
<!doctype html>
<html class="light" lang="vi">
<head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= e($adminTitle) ?> - RAMBO Admin</title>
  <link href="https://fonts.googleapis.com" rel="preconnect"><link crossorigin href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&amp;family=Space+Grotesk:wght@500;700&amp;display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
  <?php include __DIR__ . '/../layout/tailwind.php'; ?>
  <link href="Public/css/rambo.css" rel="stylesheet">
</head>
<body class="bg-surface-container-low text-on-surface font-body-md antialiased">
<div class="flex min-h-screen">
  <!-- Sidebar -->
  <aside id="sidebar" class="fixed lg:sticky top-0 left-0 z-40 h-screen w-64 bg-inverse-surface text-white flex flex-col -translate-x-full lg:translate-x-0 transition-transform">
    <a href="admin.php" class="flex items-center gap-2 px-5 h-16 border-b border-white/10"><img src="Public/images/logo.png" class="h-9 w-auto bg-white rounded px-1" alt="RAMBO"><span class="font-extrabold tracking-wide text-sm">ADMIN</span></a>
    <nav class="flex-1 overflow-y-auto p-3 space-y-1">
      <?php foreach ($menu as [$__pg, $__ic, $__lb]): $__on = $__cur === $__pg; ?>
        <a href="admin.php?page=<?= $__pg ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-semibold transition-colors <?= $__on ? 'bg-primary-container text-white' : 'text-slate-300 hover:bg-white/10' ?>">
          <span class="material-symbols-outlined text-[20px]"><?= $__ic ?></span><span class="flex-1"><?= $__lb ?></span>
          <?php if ($__pg === 'order' && $pendingOrders > 0): ?><span class="bg-secondary-container text-on-surface text-[11px] font-extrabold rounded-full px-2 py-0.5"><?= (int)$pendingOrders ?></span><?php endif; ?>
        </a>
      <?php endforeach; ?>
    </nav>
    <div class="p-3 border-t border-white/10 space-y-1">
      <a href="index.php" target="_blank" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-semibold text-slate-300 hover:bg-white/10"><span class="material-symbols-outlined text-[20px]">open_in_new</span>Xem website</a>
      <a href="logout.php" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-semibold text-red-300 hover:bg-white/10"><span class="material-symbols-outlined text-[20px]">logout</span>Đăng xuất Admin</a>
    </div>
  </aside>
  <div class="flex-1 min-w-0 flex flex-col">
    <header class="sticky top-0 z-30 h-16 bg-surface-container-lowest border-b border-outline-variant/30 flex items-center justify-between px-4 md:px-8">
      <div class="flex items-center gap-3">
        <button class="lg:hidden p-1" onclick="document.getElementById('sidebar').classList.toggle('-translate-x-full')"><span class="material-symbols-outlined">menu</span></button>
        <h1 class="font-headline-sm font-extrabold text-lg"><?= e($adminTitle) ?></h1>
      </div>
      <div class="flex items-center gap-3 text-sm"><span class="hidden sm:block text-right"><strong class="block leading-tight"><?= e($__au['HoTen']) ?></strong><span class="text-xs text-slate-500">Quản trị viên</span></span>
        <span class="w-9 h-9 rounded-full bg-primary text-white font-extrabold flex items-center justify-center"><?= e(mb_strtoupper(mb_substr($__au['HoTen'], 0, 1))) ?></span></div>
    </header>
    <main class="p-4 md:p-8 space-y-6">
      <?php foreach (get_flash() as $__f): $__ok = $__f['type'] === 'success'; ?>
        <div class="toast-in flex items-start gap-2 rounded-xl px-4 py-3 text-sm font-semibold border <?= $__ok ? 'bg-green-50 text-green-800 border-green-200' : 'bg-error-container text-on-error-container border-error/30' ?>"><span class="material-symbols-outlined text-[20px]"><?= $__ok ? 'check_circle' : 'error' ?></span><span><?= e($__f['msg']) ?></span></div>
      <?php endforeach; ?>
