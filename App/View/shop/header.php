<?php
// Header dùng chung của phía khách hàng (cắt từ index.html gốc, đã gắn dữ liệu động)
$__cur = $_GET['page'] ?? 'home';
$__u = current_user();
function nav_cls($pages, $cur) {
    return in_array($cur, (array)$pages)
        ? 'border-b-2 border-primary text-primary font-bold pb-1'
        : 'text-on-surface font-medium hover:text-primary pb-1 transition-colors';
}
?>
<!doctype html>
<html class="light" lang="vi">
  <head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title><?= e($pageTitle ?? 'RAMBO STORE - Hệ Thống LEGO Chính Hãng Số 1 Việt Nam') ?></title>
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&amp;family=Space+Grotesk:wght@500;700&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <?php include __DIR__ . '/../layout/tailwind.php'; ?>
    <link href="Public/css/rambo.css" rel="stylesheet" />
  </head>
  <body class="bg-surface text-on-surface font-body-md text-body-md antialiased selection:bg-primary selection:text-on-primary min-h-screen flex flex-col">
    <?php include __DIR__ . '/../layout/topbar.php'; ?>
    <!-- Header -->
    <header class="bg-surface-container-lowest sticky top-0 z-50 shadow-sm transition-shadow">
      <div class="w-full mx-auto px-margin-mobile md:px-margin max-w-7xl flex flex-col justify-between py-space-sm md:py-space-md">
        <div class="flex items-center justify-between gap-space-md">
          <a class="flex items-center gap-space-sm flex-shrink-0 transition-transform active:scale-95" href="index.php">
            <img alt="Logo RAMBO STORE" class="h-10 md:h-12 w-auto object-contain" src="Public/images/logo.png" />
          </a>
          <!-- Tìm kiếm -->
          <div class="hidden md:flex flex-1 max-w-2xl mx-space-md">
            <form action="index.php" method="get" class="flex w-full items-center bg-surface-container-low border border-outline-variant/60 rounded-xl overflow-hidden focus-within:ring-2 focus-within:ring-primary focus-within:border-primary transition-all shadow-inner">
              <input type="hidden" name="page" value="product" />
              <div class="px-space-md flex items-center text-on-surface-variant"><span class="material-symbols-outlined text-outline">search</span></div>
              <input name="q" value="<?= e($_GET['q'] ?? '') ?>" class="w-full bg-transparent border-0 py-2.5 px-0 text-on-surface font-body-sm text-body-sm focus:ring-0 placeholder:text-outline-variant" placeholder="Tìm kiếm bộ LEGO, mã sản phẩm, chủ đề..." type="text" />
              <div class="h-6 w-[1px] bg-outline-variant/60"></div>
              <select name="cat[]" class="bg-transparent border-0 font-label-md text-label-md text-on-surface-variant py-2.5 pl-space-sm pr-space-md focus:ring-0 cursor-pointer">
                <option value="">Tất cả danh mục</option>
                <?php foreach ($navCats as $__c): ?>
                  <option value="<?= $__c['MaDM'] ?>" <?= (($_GET['cat'][0] ?? '') == $__c['MaDM']) ? 'selected' : '' ?>><?= e($__c['TenDM']) ?></option>
                <?php endforeach; ?>
              </select>
              <button class="bg-primary-container hover:bg-primary text-on-primary px-space-lg py-2.5 font-label-lg text-label-lg flex items-center gap-space-xs transition-colors" type="submit"><span>Tìm kiếm</span></button>
            </form>
          </div>
          <!-- Icon bên phải -->
          <div class="flex items-center gap-space-sm md:gap-space-md">
            <a aria-label="Tìm kiếm" class="md:hidden p-space-xs text-on-surface hover:text-primary transition-colors" href="index.php?page=product"><span class="material-symbols-outlined text-[28px]">search</span></a>
            <a aria-label="Danh sách yêu thích" class="relative p-2 text-on-surface hover:text-primary hover:bg-surface-container-low rounded-lg transition-colors flex items-center" href="index.php?page=wishlist">
              <span class="material-symbols-outlined text-[26px]">favorite</span>
              <?php if ($wishCount > 0): ?><span class="absolute top-1 right-1 bg-primary text-on-primary font-label-sm text-label-sm rounded-full h-4 min-w-[16px] px-1 flex items-center justify-center font-bold"><?= $wishCount ?></span><?php endif; ?>
            </a>
            <a aria-label="Giỏ hàng" class="relative p-2 text-on-surface hover:text-primary hover:bg-surface-container-low rounded-lg transition-colors flex items-center gap-space-xs group" href="index.php?page=cart">
              <div class="relative">
                <span class="material-symbols-outlined text-[26px] text-primary">shopping_cart</span>
                <?php if ($cartCount > 0): ?><span class="absolute -top-1 -right-1 bg-secondary-container text-on-secondary-container font-label-sm text-label-sm rounded-full h-4 min-w-[16px] px-1 flex items-center justify-center font-bold"><?= $cartCount ?></span><?php endif; ?>
              </div>
              <div class="hidden xl:flex flex-col text-left pl-1">
                <span class="font-label-sm text-label-sm text-outline">Giỏ hàng</span>
                <span class="font-label-md text-label-md text-primary font-bold"><?= money($cartTotal) ?></span>
              </div>
            </a>
            <?php if ($__u): ?>
              <div class="relative group">
                <a class="flex items-center gap-space-xs p-1.5 md:px-space-md md:py-2 rounded-lg bg-surface-container-low hover:bg-surface-container transition-all text-on-surface" href="index.php?page=account">
                  <span class="material-symbols-outlined text-primary text-[24px]">person</span>
                  <span class="hidden md:inline font-label-md text-label-md font-bold max-w-[110px] truncate"><?= e($__u['HoTen']) ?></span>
                </a>
                <div class="absolute right-0 top-full pt-2 w-56 hidden group-hover:block z-50">
                  <div class="bg-surface-container-lowest border border-outline-variant/30 rounded-xl shadow-xl p-space-sm flex flex-col gap-1 font-body-sm text-body-sm">
                    <a class="px-space-md py-space-sm hover:bg-surface-container-low rounded-lg" href="index.php?page=account">Thông tin tài khoản</a>
                    <a class="px-space-md py-space-sm hover:bg-surface-container-low rounded-lg" href="index.php?page=history">Đơn hàng của tôi</a>
                    <a class="px-space-md py-space-sm hover:bg-surface-container-low rounded-lg" href="index.php?page=wishlist">Sản phẩm yêu thích</a>
                    <?php if (is_admin()): ?><a class="px-space-md py-space-sm hover:bg-surface-container-low rounded-lg text-primary font-bold" href="admin.php">Trang quản trị</a><?php endif; ?>
                    <a class="px-space-md py-space-sm hover:bg-error-container text-error rounded-lg" href="logout.php">Đăng xuất</a>
                  </div>
                </div>
              </div>
            <?php else: ?>
              <a class="flex items-center gap-space-xs p-1.5 md:px-space-md md:py-2 rounded-lg bg-surface-container-low hover:bg-surface-container transition-all active:scale-95 text-on-surface" href="index.php?page=login">
                <span class="material-symbols-outlined text-primary text-[24px]">person</span>
                <span class="hidden md:inline font-label-md text-label-md font-bold">Đăng nhập</span>
              </a>
            <?php endif; ?>
          </div>
        </div>
        <!-- Menu -->
        <nav class="hidden md:flex items-center justify-between border-t border-surface-container pt-space-sm mt-space-sm">
          <ul class="flex items-center gap-space-lg font-label-lg text-label-lg">
            <li><a class="<?= nav_cls('home', $__cur) ?> flex items-center gap-1" href="index.php"><span class="material-symbols-outlined text-[18px]">home</span><span>Trang chủ</span></a></li>
            <li><a class="<?= nav_cls(['product', 'productdetail'], $__cur) ?>" href="index.php?page=product">Tất cả sản phẩm</a></li>
            <li class="relative group">
              <a class="text-on-surface font-medium hover:text-primary pb-1 transition-colors flex items-center gap-0.5" href="index.php?page=product"><span>LEGO Themes</span><span class="material-symbols-outlined text-[16px] group-hover:rotate-180 transition-transform">expand_more</span></a>
              <div class="absolute top-full left-0 pt-2 w-64 hidden group-hover:block z-50">
                <div class="bg-surface-container-lowest border border-outline-variant/30 rounded-xl shadow-xl p-space-sm flex flex-col gap-1">
                  <?php foreach ($navCats as $__c): ?>
                    <a class="px-space-md py-space-sm hover:bg-surface-container-low rounded-lg transition-colors font-body-sm text-body-sm" href="index.php?page=product&amp;cat[]=<?= $__c['MaDM'] ?>"><?= e($__c['TenDM']) ?></a>
                  <?php endforeach; ?>
                </div>
              </div>
            </li>
            <li><a class="<?= nav_cls('promotion', $__cur) ?> flex items-center gap-space-xs" href="index.php?page=promotion"><span>Khuyến mãi Hot</span><span class="bg-secondary-container text-on-secondary-container font-label-sm text-label-sm px-1.5 py-0.5 rounded-full uppercase tracking-wider font-extrabold animate-pulse">HOT</span></a></li>
            <li><a class="<?= nav_cls('newarrival', $__cur) ?>" href="index.php?page=newarrival">Bộ mới về</a></li>
            <li><a class="<?= nav_cls('about', $__cur) ?>" href="index.php?page=about">Giới thiệu &amp; Cửa hàng</a></li>
          </ul>
          <div class="flex items-center gap-space-sm text-on-surface-variant font-label-sm text-label-sm">
            <span class="material-symbols-outlined text-secondary-container text-[18px]" data-weight="fill">loyalty</span>
            <span>RAMBO VIP: <strong>Tích điểm gạch 5%</strong></span>
          </div>
        </nav>
        <!-- Menu mobile -->
        <nav class="md:hidden flex items-center gap-space-md overflow-x-auto no-scrollbar border-t border-surface-container pt-space-sm mt-space-sm font-label-md text-label-md whitespace-nowrap">
          <a class="<?= nav_cls('home', $__cur) ?>" href="index.php">Trang chủ</a>
          <a class="<?= nav_cls('product', $__cur) ?>" href="index.php?page=product">Sản phẩm</a>
          <a class="<?= nav_cls('promotion', $__cur) ?>" href="index.php?page=promotion">Khuyến mãi</a>
          <a class="<?= nav_cls('newarrival', $__cur) ?>" href="index.php?page=newarrival">Bộ mới về</a>
          <a class="<?= nav_cls('about', $__cur) ?>" href="index.php?page=about">Giới thiệu</a>
        </nav>
      </div>
    </header>
    <!-- Thông báo -->
    <?php $__fl = get_flash(); if ($__fl): ?>
      <div class="max-w-7xl mx-auto w-full px-margin-mobile md:px-margin pt-space-md space-y-2">
        <?php foreach ($__fl as $__f): $__ok = $__f['type'] === 'success'; ?>
          <div class="toast-in flex items-start gap-2 rounded-xl px-4 py-3 text-sm font-semibold border <?= $__ok ? 'bg-green-50 text-green-800 border-green-200' : 'bg-error-container text-on-error-container border-error/30' ?>">
            <span class="material-symbols-outlined text-[20px]"><?= $__ok ? 'check_circle' : 'error' ?></span><span><?= e($__f['msg']) ?></span>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
    <div class="flex-grow">
