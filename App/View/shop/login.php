<main class="flex-grow grid lg:grid-cols-2 min-h-[70vh]">
  <section class="hidden lg:flex relative bg-inverse-surface text-white p-12 flex-col justify-center overflow-hidden">
    <div class="absolute inset-0 lego-stud-yellow opacity-30"></div>
    <div class="relative max-w-lg">
      <span class="inline-flex items-center gap-1 bg-secondary-container text-on-surface font-label-md font-extrabold px-3 py-1 rounded-full"><span class="material-symbols-outlined text-base" data-weight="fill">verified</span>VIP CLUB 2024</span>
      <h1 class="text-4xl font-black mt-4 leading-tight">Gia nhập cộng đồng RAMBO VIP Club</h1>
      <p class="mt-3 text-slate-300">Kết nối với hơn 50.000 nhà sưu tập và builder chuyên nghiệp trên toàn quốc.</p>
      <ul class="mt-6 space-y-4">
        <?php foreach ([['stars', 'Tích lũy điểm gạch', 'Quy đổi voucher giảm giá & quà tặng độc bản'], ['rocket_launch', 'Đặt trước bản UCS', 'Tiếp cận set Limited & Collector sớm nhất'], ['extension', 'Bảo hành mảnh thiếu', 'Cấp bù gạch thất lạc hoàn toàn miễn phí']] as [$i, $t, $d]): ?>
          <li class="flex gap-3"><span class="w-11 h-11 rounded-xl bg-white/10 flex items-center justify-center text-secondary-container"><span class="material-symbols-outlined" data-weight="fill"><?= $i ?></span></span><div><p class="font-bold"><?= $t ?></p><p class="text-sm text-slate-400"><?= $d ?></p></div></li>
        <?php endforeach; ?>
      </ul>
    </div>
  </section>
  <section class="flex items-center justify-center p-6 md:p-12">
    <div class="w-full max-w-md">
      <h2 class="font-headline-xl text-headline-xl font-extrabold">Đăng Nhập Tài Khoản</h2>
      <p class="text-on-surface-variant mt-1">Chào mừng bạn quay trở lại RAMBO STORE</p>
      <?php if ($error): ?><div class="mt-4 bg-error-container text-on-error-container rounded-xl px-4 py-3 text-sm font-semibold"><?= e($error) ?></div><?php endif; ?>
      <form method="post" action="index.php?page=login" class="mt-6 space-y-4">
        <?= csrf_field() ?><input type="hidden" name="next" value="<?= e($next) ?>">
        <label class="block text-sm font-semibold">Email hoặc số điện thoại *
          <input name="account" value="<?= e($account) ?>" required autofocus class="field mt-1" placeholder="Nhập email của bạn...">
        </label>
        <label class="block text-sm font-semibold">Mật khẩu *
          <div class="relative"><input id="pw" type="password" name="password" required class="field mt-1 pr-11" placeholder="••••••••">
          <button type="button" onclick="const i=document.getElementById('pw');i.type=i.type==='password'?'text':'password'" class="absolute right-3 top-1/2 -translate-y-1/4 text-slate-400"><span class="material-symbols-outlined">visibility</span></button></div>
        </label>
        <button class="w-full bg-primary-container hover:bg-primary text-white font-bold py-3.5 rounded-xl brick-btn-shadow flex items-center justify-center gap-2">ĐĂNG NHẬP <span class="material-symbols-outlined">arrow_forward</span></button>
      </form>
      <p class="text-center text-sm mt-6">Chưa có tài khoản RAMBO STORE? <a href="index.php?page=register" class="text-primary font-bold hover:underline">Đăng ký ngay tại đây</a></p>
      <p class="text-center text-xs text-slate-400 mt-4">Demo: khach@rambo.vn / 123456 &nbsp;•&nbsp; admin@rambo.vn / admin123</p>
    </div>
  </section>
</main>
