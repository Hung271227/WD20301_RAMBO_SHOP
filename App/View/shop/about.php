<section class="relative bg-surface-container-highest overflow-hidden border-b border-outline-variant/30">
  <div class="absolute inset-0 lego-stud-pattern opacity-40 pointer-events-none"></div>
  <div class="relative max-w-7xl mx-auto px-margin-mobile md:px-margin py-14 md:py-20 grid lg:grid-cols-2 gap-space-xl items-center">
    <div>
      <span class="inline-flex items-center gap-1 bg-primary/10 border border-primary/20 text-primary font-label-md font-bold px-3 py-1 rounded-full"><span class="material-symbols-outlined text-base">verified_user</span>VỀ RAMBO STORE</span>
      <h1 class="font-display-lg-mobile md:font-display-lg text-display-lg-mobile md:text-display-lg font-black uppercase mt-4">Nơi đam mê <span class="text-primary">gạch LEGO</span> bắt đầu</h1>
      <p class="mt-4 text-body-lg text-on-surface-variant max-w-xl">RAMBO STORE là hệ thống phân phối mô hình LEGO chính hãng, mang đến cho người chơi Việt Nam những bộ gạch nhập khẩu nguyên seal, giá minh bạch và dịch vụ hậu mãi tận tâm.</p>
      <div class="flex gap-3 mt-6">
        <a href="index.php?page=product" class="bg-primary-container hover:bg-primary text-white font-bold px-7 py-3.5 rounded-xl brick-btn-shadow">Mua sắm ngay</a>
        <a href="#showroom" class="bg-white border border-slate-200 hover:border-on-surface font-bold px-7 py-3.5 rounded-xl">Xem showroom</a>
      </div>
    </div>
    <div class="rounded-3xl overflow-hidden shadow-2xl border border-outline-variant/30"><img src="<?= e(HERO_IMG) ?>" alt="RAMBO STORE" class="w-full h-full object-cover"></div>
  </div>
</section>
<main class="max-w-7xl mx-auto w-full px-margin-mobile md:px-margin py-space-xl space-y-space-xl">
  <section class="grid grid-cols-2 lg:grid-cols-4 gap-space-md text-center">
    <?php foreach ([['1.500+', 'Bộ LEGO sẵn có'], ['100%', 'Hàng chính hãng'], ['45K+', 'Khách hàng VIP'], ['2H', 'Giao hỏa tốc nội thành']] as [$n, $l]): ?>
      <div class="bg-surface-container-lowest card-resting rounded-xl p-6"><p class="text-3xl font-black text-primary font-label-lg"><?= $n ?></p><p class="text-sm text-slate-600 mt-1"><?= $l ?></p></div>
    <?php endforeach; ?>
  </section>
  <section>
    <?php $eyebrow = 'CÂU CHUYỆN CỦA CHÚNG TÔI'; $title = 'Sứ mệnh & Giá trị cốt lõi'; include __DIR__ . '/_title.php'; ?>
    <div class="grid md:grid-cols-3 gap-space-md">
      <?php foreach ([['verified', '100% Chính hãng', 'Nhập khẩu trực tiếp, tem phụ phân phối độc quyền. Cam kết hoàn tiền gấp đôi nếu phát hiện hàng giả.'],
                      ['published_with_changes', 'Đổi trả 30 ngày', 'Hỗ trợ đổi mới nếu phát hiện thiếu mảnh hoặc móp méo hộp do lỗi vận chuyển.'],
                      ['stars', 'RAMBO VIP Club', 'Tích lũy 5% điểm gạch, quà sinh nhật và quyền đặt trước các bộ Limited / Collector.']] as [$ic, $t, $d]): ?>
        <div class="bg-surface-container-lowest card-resting rounded-xl p-6">
          <div class="w-12 h-12 rounded-xl bg-primary/10 text-primary flex items-center justify-center mb-3"><span class="material-symbols-outlined text-[28px]" data-weight="fill"><?= $ic ?></span></div>
          <h3 class="font-headline-sm font-bold mb-1"><?= $t ?></h3><p class="text-sm text-on-surface-variant"><?= $d ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </section>
  <section id="showroom">
    <?php $eyebrow = 'HỆ THỐNG CỬA HÀNG'; $title = 'Showroom RAMBO STORE'; include __DIR__ . '/_title.php'; ?>
    <div class="grid md:grid-cols-3 gap-space-md">
      <?php foreach ([['Showroom Quận 1 - TP.HCM', '25 Nguyễn Huệ, Phường Bến Nghé, Quận 1', '8:30 - 21:30 hằng ngày', '028 3822 8888'],
                      ['Showroom Hoàn Kiếm - Hà Nội', '88 Phố Huế, Phường Hàng Trống, Hoàn Kiếm', '8:30 - 21:30 hằng ngày', '024 3944 8888'],
                      ['Showroom Hải Châu - Đà Nẵng', '12 Trần Phú, Quận Hải Châu', '9:00 - 21:00 hằng ngày', '0236 3888 888']] as [$n, $a, $h, $t]): ?>
        <div class="bg-surface-container-lowest card-resting rounded-xl p-5">
          <h3 class="font-headline-sm font-bold flex items-center gap-2"><span class="material-symbols-outlined text-primary">storefront</span><?= $n ?></h3>
          <p class="text-sm mt-2 flex gap-2"><span class="material-symbols-outlined text-base text-slate-400">location_on</span><?= $a ?></p>
          <p class="text-sm mt-1 flex gap-2"><span class="material-symbols-outlined text-base text-slate-400">schedule</span><?= $h ?></p>
          <p class="text-sm mt-1 flex gap-2"><span class="material-symbols-outlined text-base text-slate-400">call</span><?= $t ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </section>
  <section id="lien-he" class="bg-inverse-surface text-white rounded-2xl p-8 md:p-10 flex flex-col md:flex-row items-center justify-between gap-4">
    <div><h2 class="text-2xl font-extrabold">Cần hỗ trợ? Chúng tôi luôn sẵn sàng</h2><p class="text-slate-300 mt-1">CSKH trực 8:00 - 22:00 hằng ngày • support@rambo.vn</p></div>
    <a href="tel:19008888" class="bg-secondary-container text-on-surface font-bold px-6 py-3 rounded-xl flex items-center gap-2"><span class="material-symbols-outlined">call</span>Hotline 1900 8888</a>
  </section>
</main>
