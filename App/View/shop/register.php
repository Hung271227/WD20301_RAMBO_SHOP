<main class="flex-grow grid lg:grid-cols-2 min-h-[70vh]">
  <section class="hidden lg:flex relative bg-primary text-white p-12 flex-col justify-center overflow-hidden">
    <div class="absolute inset-0 lego-stud-yellow opacity-30"></div>
    <div class="relative max-w-lg">
      <span class="inline-flex items-center gap-1 bg-secondary-container text-on-surface font-label-md font-extrabold px-3 py-1 rounded-full">RAMBO VIP CLUB • ƯU ĐÃI THÀNH VIÊN</span>
      <h1 class="text-4xl font-black mt-4 leading-tight">Đăng ký thành viên nhận ngay voucher <span class="text-secondary-container">100.000đ</span></h1>
      <ul class="mt-6 space-y-4">
        <?php foreach ([['redeem', 'Quà tặng sinh nhật độc quyền', 'Voucher ưu đãi 15% vào tháng sinh nhật.'], ['local_shipping', 'Miễn phí vận chuyển đơn từ 1.000.000đ', 'Giao hỏa tốc 2h tại TP.HCM & Hà Nội.'], ['notifications_active', 'Cập nhật sớm các bộ hiếm', 'Đặc quyền đặt trước 24h Star Wars UCS, Icons, Technic.']] as [$i, $t, $d]): ?>
          <li class="flex gap-3"><span class="w-11 h-11 rounded-xl bg-white/15 flex items-center justify-center"><span class="material-symbols-outlined" data-weight="fill"><?= $i ?></span></span><div><p class="font-bold"><?= $t ?></p><p class="text-sm text-primary-fixed"><?= $d ?></p></div></li>
        <?php endforeach; ?>
      </ul>
    </div>
  </section>
  <section class="flex items-center justify-center p-6 md:p-12">
    <div class="w-full max-w-md">
      <h2 class="font-headline-xl text-headline-xl font-extrabold">Tạo Tài Khoản Mới</h2>
      <p class="text-on-surface-variant mt-1">Tham gia cùng hơn <strong class="text-primary">45.000</strong> tín đồ LEGO trên toàn quốc</p>
      <?php if ($errors): ?><div class="mt-4 bg-error-container text-on-error-container rounded-xl px-4 py-3 text-sm font-semibold"><ul class="list-disc pl-5"><?php foreach ($errors as $er): ?><li><?= e($er) ?></li><?php endforeach; ?></ul></div><?php endif; ?>
      <form method="post" action="index.php?page=register" class="mt-6 space-y-4">
        <?= csrf_field() ?>
        <label class="block text-sm font-semibold">Họ và tên *<input name="fullName" required class="field mt-1" value="<?= e($old['ten']) ?>" placeholder="Ví dụ: Nguyễn Tuấn Anh"></label>
        <label class="block text-sm font-semibold">Email *<input name="email" type="email" required class="field mt-1" value="<?= e($old['email']) ?>" placeholder="tuananh@example.com"></label>
        <label class="block text-sm font-semibold">Số điện thoại *<input name="phone" type="tel" required class="field mt-1" value="<?= e($old['sdt']) ?>" placeholder="09xx xxx xxx"></label>
        <label class="block text-sm font-semibold">Mật khẩu *<input name="password" type="password" required minlength="8" class="field mt-1" placeholder="Tối thiểu 8 ký tự, gồm chữ và số"></label>
        <label class="block text-sm font-semibold">Xác nhận mật khẩu *<input name="confirmPassword" type="password" required class="field mt-1" placeholder="Nhập lại mật khẩu"></label>
        <label class="flex items-start gap-2 text-sm"><input type="checkbox" name="agree" value="1" class="mt-0.5 rounded text-primary focus:ring-primary">Tôi đồng ý với Điều khoản dịch vụ và Chính sách bảo mật của RAMBO STORE.</label>
        <button class="w-full bg-primary-container hover:bg-primary text-white font-bold py-3.5 rounded-xl brick-btn-shadow flex items-center justify-center gap-2">ĐĂNG KÝ TÀI KHOẢN <span class="material-symbols-outlined">arrow_forward</span></button>
      </form>
      <p class="text-center text-sm mt-6">Bạn đã có tài khoản? <a href="index.php?page=login" class="text-primary font-bold hover:underline">Đăng nhập tại đây</a></p>
    </div>
  </section>
</main>
