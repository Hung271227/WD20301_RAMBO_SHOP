<main class="max-w-7xl mx-auto w-full px-margin-mobile md:px-margin py-space-lg grid lg:grid-cols-12 gap-space-lg">
  <?php $navActive = 'account'; include __DIR__ . '/_accnav.php'; ?>
  <section class="lg:col-span-9 space-y-space-md">
    <div class="bg-surface-container-lowest rounded-xl custom-shadow-card border border-slate-100 p-6">
      <h1 class="font-headline-lg text-headline-lg font-extrabold">Hồ sơ của tôi</h1>
      <p class="text-sm text-on-surface-variant">Quản lý thông tin cá nhân để nhận hàng nhanh hơn.</p>
      <?php if ($errors): ?><div class="mt-4 bg-error-container text-on-error-container rounded-xl px-4 py-3 text-sm font-semibold"><ul class="list-disc pl-5"><?php foreach ($errors as $er): ?><li><?= e($er) ?></li><?php endforeach; ?></ul></div><?php endif; ?>
      <form method="post" action="index.php?page=account" class="mt-5 grid sm:grid-cols-2 gap-4">
        <?= csrf_field() ?><input type="hidden" name="action" value="profile">
        <label class="text-sm font-semibold">Họ và tên *<input name="ten" required class="field mt-1" value="<?= e($u['HoTen']) ?>"></label>
        <label class="text-sm font-semibold">Email (không thể đổi)<input class="field mt-1 bg-slate-50" value="<?= e($u['Email']) ?>" disabled></label>
        <label class="text-sm font-semibold">Số điện thoại *<input name="sdt" required class="field mt-1" value="<?= e($u['Sdt']) ?>"></label>
        <label class="text-sm font-semibold">Ngày sinh<input type="date" name="ngaysinh" class="field mt-1" value="<?= e($u['Ngaysinh']) ?>"></label>
        <div class="text-sm font-semibold">Giới tính
          <div class="flex gap-5 mt-2 font-normal"><?php foreach (['nam' => 'Nam', 'nu' => 'Nữ', 'khac' => 'Khác'] as $k => $l): ?><label class="flex items-center gap-1.5"><input type="radio" name="gioitinh" value="<?= $k ?>" class="text-primary focus:ring-primary" <?= $u['GioiTinh'] === $k ? 'checked' : '' ?>><?= $l ?></label><?php endforeach; ?></div>
        </div>
        <label class="text-sm font-semibold sm:col-span-2">Địa chỉ giao hàng mặc định<input name="diachi" class="field mt-1" value="<?= e($u['DiaChi']) ?>" placeholder="Số nhà, đường, phường/xã, quận/huyện, tỉnh/thành"></label>
        <div class="sm:col-span-2"><button class="bg-primary-container hover:bg-primary text-white font-bold px-8 py-3 rounded-xl brick-btn-shadow">Lưu thay đổi</button></div>
      </form>
    </div>
    <div class="bg-surface-container-lowest rounded-xl custom-shadow-card border border-slate-100 p-6">
      <h2 class="font-headline-sm font-bold flex items-center gap-2"><span class="material-symbols-outlined text-primary">lock</span>Đổi mật khẩu</h2>
      <?php if ($pwErrors): ?><div class="mt-4 bg-error-container text-on-error-container rounded-xl px-4 py-3 text-sm font-semibold"><ul class="list-disc pl-5"><?php foreach ($pwErrors as $er): ?><li><?= e($er) ?></li><?php endforeach; ?></ul></div><?php endif; ?>
      <form method="post" action="index.php?page=account" class="mt-4 grid sm:grid-cols-3 gap-4">
        <?= csrf_field() ?><input type="hidden" name="action" value="password">
        <label class="text-sm font-semibold">Mật khẩu hiện tại<input type="password" name="old" required class="field mt-1"></label>
        <label class="text-sm font-semibold">Mật khẩu mới<input type="password" name="new" required minlength="8" class="field mt-1"></label>
        <label class="text-sm font-semibold">Xác nhận mật khẩu<input type="password" name="confirm" required class="field mt-1"></label>
        <div class="sm:col-span-3"><button class="bg-inverse-surface text-white font-bold px-8 py-3 rounded-xl hover:bg-black">Cập nhật mật khẩu</button></div>
      </form>
    </div>
  </section>
</main>
