<?php /* TRANG CHỦ */ $maxSale = 0; foreach ($sale as $__s) $maxSale = max($maxSale, discount_percent($__s)); $maxSale = $maxSale ?: 20; ?>
<!-- Hero -->
<section
  class="relative overflow-hidden border-b border-outline-variant/30"
  style="background-image: linear-gradient(rgba(20, 10, 10, 0.06), rgba(20, 10, 10, 0.09)), url('Public/images/banner1.webp'); background-size: cover; background-position: center;"
>
      <div
        class="max-w-7xl mx-auto px-margin-mobile md:px-margin py-space-xl md:py-20 relative z-10"
      >
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-space-xl items-center">
          <!-- Hero Left Column: Copy & CTAs -->
          <div class="lg:col-span-6 flex flex-col gap-space-md">
            <div
              class="inline-flex items-center gap-space-xs bg-primary/10 border border-primary/20 px-3 py-1 rounded-full w-fit"
            >
              <span class="material-symbols-outlined text-primary text-[18px]"
                >verified_user</span
              >
              <span
                class="font-label-md text-label-md font-bold text-primary tracking-wide"
                >ĐẠI LÝ ỦY QUYỀN CHÍNH THỨC</span
              >
            </div>
            <h1
              class="font-headline-xl-mobile md:font-headline-xl text-headline-xl-mobile md:text-headline-xl text-on-surface uppercase font-black leading-tight tracking-tight"
            >
              KHƠI NGUỒN SÁNG TẠO
              <span class="text-primary tracking-normal">BẤT TẬN</span>
              <span
                class="block font-headline-lg text-headline-lg text-on-surface-variant font-extrabold mt-1"
                >BỘ SƯU TẬP LEGO CHÍNH HÃNG 2024</span
              >
            </h1>
            <p
              class="font-body-lg text-body-lg text-on-surface-variant max-w-xl"
            >
              Ưu đãi độc quyền lên tới 35% cho các siêu phẩm LEGO Technic, Star
              Wars &amp; Icons. Tặng kèm túi vải LEGO VIP độc quyền và hỗ trợ
              trả góp 0% lãi suất.
            </p>
            <div class="flex flex-wrap items-center gap-space-md pt-space-sm">
              <a
                class="bg-primary-container hover:bg-primary text-on-primary font-label-lg text-label-lg px-8 py-3.5 rounded-xl brick-btn-shadow flex items-center gap-space-xs transition-all duration-200"
                href="#featured-products"
              >
                <span>Khám phá ngay</span>
                <span class="material-symbols-outlined text-[20px]"
                  >arrow_forward</span
                >
              </a>
              <a
                class="bg-secondary-container hover:bg-secondary-fixed text-on-surface font-label-lg text-label-lg px-7 py-3.5 rounded-xl border border-secondary/40 shadow-sm transition-all duration-200 flex items-center gap-space-xs active:scale-95"
                href="#flash-sale"
              >
                <span
                  class="material-symbols-outlined text-primary text-[20px]"
                  data-weight="fill"
                  >local_fire_department</span
                >
                <span>Xem ưu đãi Hot</span>
              </a>
            </div>
            <!-- Hero Micro Stats -->
            <div
              class="grid grid-cols-3 gap-space-md pt-space-lg border-t border-outline-variant/40 mt-space-md"
            >
              <div>
                <p
                  class="font-headline-lg text-headline-lg font-black text-on-surface font-label-lg"
                >
                  1.500+
                </p>
                <p class="font-label-sm text-label-sm text-outline">
                  Bộ LEGO có sẵn
                </p>
              </div>
              <div>
                <p
                  class="font-headline-lg text-headline-lg font-black text-primary font-label-lg"
                >
                  100%
                </p>
                <p class="font-label-sm text-label-sm text-outline">
                  Tem mác Đan Mạch
                </p>
              </div>
              <div>
                <p
                  class="font-headline-lg text-headline-lg font-black text-on-surface font-label-lg"
                >
                  45K+
                </p>
                <p class="font-label-sm text-label-sm text-outline">
                  Khách hàng VIP
                </p>
              </div>
            </div>
          </div>
          <!-- Hero Right Column: Dynamic Visual Spotlight -->
          <div class="lg:col-span-6 relative">
            <div
              class="relative bg-surface-container-lowest rounded-3xl p-4 md:p-6 shadow-2xl border border-outline-variant/30 overflow-hidden group"
            >
              <div class="absolute top-4 left-4 z-20 flex gap-2">
                <span
                  class="bg-primary text-on-primary font-label-md text-label-md px-3 py-1 rounded-full font-bold shadow"
                >
                  FLAGSHIP 2024
                </span>
                <span
                  class="bg-inverse-surface text-secondary-fixed font-label-md text-label-md px-3 py-1 rounded-full font-bold flex items-center gap-1 shadow"
                >
                  <span
                    class="material-symbols-outlined text-[16px]"
                    data-weight="fill"
                    >hotel_class</span
                  >
                  UCS Series
                </span>
              </div>
              <!-- Master Showcase Image -->
              <div
                class="relative aspect-video md:aspect-[4/3] rounded-2xl overflow-hidden bg-surface-container flex items-center justify-center"
              >
                <img
                  class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500"
                  data-alt="Epic dynamic display of high-end LEGO Technic race cars speeding on a luminous track alongside the Star Wars Millennium Falcon in a dark cinematic hangar. Bright light accents in intense crimson red and golden yellow highlight the precision structural bricks with crisp reflections, delivering a premium toy collector atmosphere."
                  src="Public/images/banner1.webp"
                />
              </div>
              <!-- Highlight Caption Ribbon -->
              <div
                class="mt-4 flex items-center justify-between bg-surface-container-low p-3 rounded-xl border border-outline-variant/30"
              >
                <div class="flex items-center gap-3">
                  <div
                    class="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center text-primary"
                  >
                    <span class="material-symbols-outlined">speed</span>
                  </div>
                  <div>
                    <h4
                      class="font-headline-sm text-headline-sm font-bold leading-tight"
                    >
                      LEGO Technic &amp; Star Wars UCS
                    </h4>
                    <p class="font-body-sm text-body-sm text-outline">
                      Trải nghiệm đỉnh cao của kỹ thuật lắp ghép cơ khí
                    </p>
                  </div>
                </div>
                <span class="font-label-lg text-label-lg font-bold text-primary"
                  >-20% TUẦN NÀY</span
                >
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Subtle Background Grid Effect -->

    </section>
<!-- SECTION 1: KHÁM PHÁ THẾ GIỚI LEGO -->
<section class="py-space-xl bg-surface">
  <div class="max-w-7xl mx-auto px-margin-mobile md:px-margin">
    <div class="text-center max-w-2xl mx-auto mb-space-xl">
      <span class="font-label-md text-label-md text-primary font-bold tracking-widest uppercase">
        THẾ GIỚI SÁNG TẠO
      </span>
      <h2 class="font-headline-xl-mobile md:font-headline-xl text-headline-xl-mobile md:text-headline-xl font-extrabold text-on-surface mt-2">
        Khám Phá Thế Giới LEGO
      </h2>
      <p class="font-body-md text-body-md text-on-surface-variant mt-3">
        Chọn chủ đề yêu thích và bắt đầu hành trình sáng tạo của riêng bạn.
      </p>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-space-md">
      <?php foreach ($categories as $c): ?>
        <a href="index.php?page=product&amp;cat[]=<?= (int)$c['MaDM'] ?>"
           class="group bg-surface-container-lowest border border-outline-variant/30 rounded-2xl p-space-lg text-center hover:-translate-y-2 hover:shadow-xl transition-all duration-300 flex flex-col items-center">
          <div class="w-16 h-16 rounded-2xl bg-primary/10 text-primary flex items-center justify-center mb-space-sm group-hover:bg-primary group-hover:text-on-primary group-hover:scale-110 transition-all">
            <span class="material-symbols-outlined text-[34px]"><?= e($c['Icon']) ?></span>
          </div>
          <h3 class="font-headline-sm text-headline-sm font-bold text-on-surface">
            <?= e($c['TenDM']) ?>
          </h3>
          <p class="font-body-sm text-body-sm text-on-surface-variant mt-2">
            <?= e($c['MoTa']) ?>
          </p>
          <span class="font-label-md text-label-md text-primary font-bold mt-4">
            Khám phá ngay →
          </span>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- SECTION 2: CÂU CHUYỆN RAMBO STORE -->
<section class="py-space-xl bg-surface-container-low">
  <div class="max-w-7xl mx-auto px-margin-mobile md:px-margin">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-space-xl items-center">
      <div>
        <span class="font-label-md text-label-md text-primary font-bold tracking-widest uppercase">
          VỀ RAMBO STORE
        </span>
        <h2 class="font-headline-xl-mobile md:font-headline-xl text-headline-xl-mobile md:text-headline-xl font-extrabold text-on-surface mt-3 leading-tight">
          Không Chỉ Là Đồ Chơi,
          <span class="text-primary">Đó Là Niềm Đam Mê</span>
        </h2>
        <p class="font-body-lg text-body-lg text-on-surface-variant mt-4 leading-relaxed">
          RAMBO STORE là nơi dành cho những người yêu thích lắp ráp và khám phá.
          Dù bạn mới bắt đầu hay là nhà sưu tầm lâu năm, mỗi bộ LEGO đều mở ra
          một cơ hội để sáng tạo, học hỏi và thể hiện cá tính.
        </p>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-space-lg mt-space-xl">
          <div class="flex items-start gap-3">
            <div class="w-11 h-11 rounded-xl bg-primary/10 text-primary flex items-center justify-center flex-shrink-0">
              <span class="material-symbols-outlined text-[26px]">verified</span>
            </div>
            <div>
              <h3 class="font-headline-sm text-headline-sm font-bold text-on-surface">Sản phẩm chính hãng</h3>
              <p class="font-body-sm text-body-sm text-on-surface-variant mt-1">Thông tin sản phẩm rõ ràng, nguồn gốc minh bạch.</p>
            </div>
          </div>
          <div class="flex items-start gap-3">
            <div class="w-11 h-11 rounded-xl bg-primary/10 text-primary flex items-center justify-center flex-shrink-0">
              <span class="material-symbols-outlined text-[26px]">local_shipping</span>
            </div>
            <div>
              <h3 class="font-headline-sm text-headline-sm font-bold text-on-surface">Giao hàng an toàn</h3>
              <p class="font-body-sm text-body-sm text-on-surface-variant mt-1">Đóng gói cẩn thận để bảo vệ hộp và sản phẩm.</p>
            </div>
          </div>
          <div class="flex items-start gap-3">
            <div class="w-11 h-11 rounded-xl bg-primary/10 text-primary flex items-center justify-center flex-shrink-0">
              <span class="material-symbols-outlined text-[26px]">support_agent</span>
            </div>
            <div>
              <h3 class="font-headline-sm text-headline-sm font-bold text-on-surface">Tư vấn tận tâm</h3>
              <p class="font-body-sm text-body-sm text-on-surface-variant mt-1">Hỗ trợ tìm bộ LEGO phù hợp với nhu cầu.</p>
            </div>
          </div>
          <div class="flex items-start gap-3">
            <div class="w-11 h-11 rounded-xl bg-primary/10 text-primary flex items-center justify-center flex-shrink-0">
              <span class="material-symbols-outlined text-[26px]">favorite</span>
            </div>
            <div>
              <h3 class="font-headline-sm text-headline-sm font-bold text-on-surface">Cộng đồng đam mê</h3>
              <p class="font-body-sm text-body-sm text-on-surface-variant mt-1">Cùng chia sẻ ý tưởng và tình yêu lắp ráp.</p>
            </div>
          </div>
        </div>

        <a href="index.php?page=product"
           class="inline-flex items-center gap-2 mt-space-xl bg-primary-container hover:bg-primary text-on-primary font-label-lg text-label-lg px-7 py-3 rounded-xl transition-colors">
          Mua sắm ngay
          <span class="material-symbols-outlined">arrow_forward</span>
        </a>
      </div>

      <div class="grid grid-cols-2 gap-space-md items-center">
        <img src="Public/images/banner2.webp" alt="Không gian trưng bày LEGO"
             class="w-full h-56 md:h-72 object-cover rounded-2xl shadow-lg">
        <img src="Public/images/banner3.jpg" alt="Các mô hình LEGO sáng tạo"
             class="w-full h-56 md:h-72 object-cover rounded-2xl shadow-lg mt-10">
      </div>
    </div>
  </div>
</section>

<!-- SECTION 3: HÀNH TRÌNH SÁNG TẠO -->
<section class="py-space-xl bg-surface">
  <div class="max-w-7xl mx-auto px-margin-mobile md:px-margin">
    <div class="text-center max-w-2xl mx-auto mb-space-xl">
      <span class="font-label-md text-label-md text-primary font-bold tracking-widest uppercase">
        BUILD YOUR WORLD
      </span>
      <h2 class="font-headline-xl-mobile md:font-headline-xl text-headline-xl-mobile md:text-headline-xl font-extrabold text-on-surface mt-2">
        Mỗi Mảnh Ghép, Một Câu Chuyện
      </h2>
      <p class="font-body-md text-body-md text-on-surface-variant mt-3">
        Dù ở độ tuổi nào, bạn cũng có thể tạo nên thế giới của riêng mình.
      </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-space-lg">
      <article class="group bg-surface-container-lowest rounded-2xl overflow-hidden border border-outline-variant/30 hover:shadow-xl transition-all duration-300">
        <div class="overflow-hidden">
          <img src="assets/images/lego-beginner.jpg" alt="Bộ LEGO dành cho người mới bắt đầu"
               class="w-full h-56 object-cover group-hover:scale-105 transition-transform duration-500">
        </div>
        <div class="p-space-lg">
          <span class="font-label-sm text-label-sm text-primary font-bold tracking-wider">01 / BẮT ĐẦU</span>
          <h3 class="font-headline-md text-headline-md font-bold text-on-surface mt-2">Dành Cho Người Mới</h3>
          <p class="font-body-md text-body-md text-on-surface-variant mt-3">
            Những bộ lắp ráp thú vị giúp bạn làm quen với thế giới LEGO và thỏa sức sáng tạo.
          </p>
          <a href="index.php?page=product" class="inline-flex items-center gap-1 text-primary font-bold mt-5">
            Khám phá sản phẩm <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
          </a>
        </div>
      </article>

      <article class="group bg-surface-container-lowest rounded-2xl overflow-hidden border border-outline-variant/30 hover:shadow-xl transition-all duration-300">
        <div class="overflow-hidden">
          <img src="assets/images/lego-collector.jpg" alt="Mô hình LEGO dành cho nhà sưu tầm"
               class="w-full h-56 object-cover group-hover:scale-105 transition-transform duration-500">
        </div>
        <div class="p-space-lg">
          <span class="font-label-sm text-label-sm text-primary font-bold tracking-wider">02 / SƯU TẦM</span>
          <h3 class="font-headline-md text-headline-md font-bold text-on-surface mt-2">Dành Cho Nhà Sưu Tầm</h3>
          <p class="font-body-md text-body-md text-on-surface-variant mt-3">
            Khám phá những mô hình có thiết kế ấn tượng, nhiều chi tiết và giá trị trưng bày.
          </p>
          <a href="index.php?page=product" class="inline-flex items-center gap-1 text-primary font-bold mt-5">
            Khám phá sản phẩm <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
          </a>
        </div>
      </article>

      <article class="group bg-surface-container-lowest rounded-2xl overflow-hidden border border-outline-variant/30 hover:shadow-xl transition-all duration-300">
        <div class="overflow-hidden">
          <img src="assets/images/lego-family.jpg" alt="Gia đình cùng nhau lắp ráp LEGO"
               class="w-full h-56 object-cover group-hover:scale-105 transition-transform duration-500">
        </div>
        <div class="p-space-lg">
          <span class="font-label-sm text-label-sm text-primary font-bold tracking-wider">03 / KẾT NỐI</span>
          <h3 class="font-headline-md text-headline-md font-bold text-on-surface mt-2">Sáng Tạo Cùng Gia Đình</h3>
          <p class="font-body-md text-body-md text-on-surface-variant mt-3">
            Cùng người thân lắp ráp, chia sẻ niềm vui và lưu giữ những khoảnh khắc đáng nhớ.
          </p>
          <a href="index.php?page=product" class="inline-flex items-center gap-1 text-primary font-bold mt-5">
            Khám phá sản phẩm <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
          </a>
        </div>
      </article>
    </div>
  </div>
</section>

<!-- Sản phẩm khuyến mãi -->
<?php if ($sale): ?>
<section class="py-space-xl bg-surface-container-low">
  <div class="max-w-7xl mx-auto px-margin-mobile md:px-margin">
    <?php $eyebrow='ƯU ĐÃI ĐANG DIỄN RA'; $title='Khuyến Mãi Hot'; $link='index.php?page=promotion'; $linkText='Xem tất cả khuyến mãi'; include __DIR__ . '/_title.php'; ?>
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-space-md md:gap-space-lg">
      <?php foreach ($sale as $p) include __DIR__ . '/_card.php'; ?>
    </div>
  </div>
</section>
<?php endif; ?>
<!-- Bộ mới về -->
<section class="py-space-xl bg-surface">
  <div class="max-w-7xl mx-auto px-margin-mobile md:px-margin">
    <?php $eyebrow='VỪA CẬP BẾN'; $title='Bộ LEGO Mới Về'; $link='index.php?page=newarrival'; $linkText='Xem tất cả bộ mới'; include __DIR__ . '/_title.php'; ?>
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-space-md md:gap-space-lg">
      <?php foreach ($newest as $p) include __DIR__ . '/_card.php'; ?>
    </div>
  </div>
</section>
<!-- Bán chạy -->
<section class="py-space-xl bg-surface-container-low" id="featured-products">
  <div class="max-w-7xl mx-auto px-margin-mobile md:px-margin">
    <?php $eyebrow='SIÊU PHẨM LEGO CHÍNH HÃNG'; $title='Sản Phẩm Nổi Bật'; $link='index.php?page=product&sort=best'; $linkText='Xem thêm'; include __DIR__ . '/_title.php'; ?>
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-space-md md:gap-space-lg">
      <?php foreach ($best as $p) include __DIR__ . '/_card.php'; ?>
    </div>
  </div>
</section>
<!-- Đánh giá khách hàng -->
    <section class="py-space-xl bg-surface border-t border-outline-variant/30">
      <div class="max-w-7xl mx-auto px-margin-mobile md:px-margin">
        <div class="text-center max-w-2xl mx-auto mb-space-xl">
          <span
            class="font-label-md text-label-md text-primary font-bold tracking-widest uppercase"
            >CỘNG ĐỒNG NGƯỜI CHƠI LEGO</span
          >
          <h2
            class="font-headline-xl-mobile md:font-headline-xl text-headline-xl-mobile md:text-headline-xl font-extrabold text-on-surface mt-1"
          >
            Đánh Giá Từ Khách Hàng VIP
          </h2>
          <p class="font-body-md text-body-md text-on-surface-variant mt-2">
            Hơn 45.000 người yêu thích LEGO trên khắp Việt Nam tin tưởng lựa
            chọn RAMBO STORE cho bộ sưu tập của mình.
          </p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-space-lg">
          <!-- Review 1 -->
          <div
            class="bg-surface-container-lowest p-space-lg rounded-2xl border border-outline-variant/30 shadow-sm flex flex-col justify-between"
          >
            <div>
              <div class="flex text-secondary-container mb-3">
                <span
                  class="material-symbols-outlined text-[20px]"
                  data-weight="fill"
                  >star</span
                >
                <span
                  class="material-symbols-outlined text-[20px]"
                  data-weight="fill"
                  >star</span
                >
                <span
                  class="material-symbols-outlined text-[20px]"
                  data-weight="fill"
                  >star</span
                >
                <span
                  class="material-symbols-outlined text-[20px]"
                  data-weight="fill"
                  >star</span
                >
                <span
                  class="material-symbols-outlined text-[20px]"
                  data-weight="fill"
                  >star</span
                >
              </div>
              <p class="font-body-md text-body-md text-on-surface italic">
                "Mua con Ferrari Daytona SP3 giao hỏa tốc 1h30 phút tại Q1 là
                nhận được rồi. Đóng hộp 2 lớp xốp bong bóng dày dặn, góc cạnh
                nguyên seal không tì vết. Sẽ ủng hộ dài dài!"
              </p>
            </div>
            <div
              class="flex items-center gap-3 mt-6 pt-4 border-t border-surface-container"
            >
              <div
                class="w-10 h-10 rounded-full bg-primary/10 text-primary font-bold flex items-center justify-center font-label-md"
              >
                TH
              </div>
              <div>
                <h4
                  class="font-headline-sm text-headline-sm font-bold leading-none"
                >
                  Trần Hoàng Long
                </h4>
                <p class="font-label-sm text-label-sm text-outline mt-0.5">
                  Hội LEGO Technic Sài Gòn • VIP Gold
                </p>
              </div>
            </div>
          </div>
          <!-- Review 2 -->
          <div
            class="bg-surface-container-lowest p-space-lg rounded-2xl border border-outline-variant/30 shadow-sm flex flex-col justify-between"
          >
            <div>
              <div class="flex text-secondary-container mb-3">
                <span
                  class="material-symbols-outlined text-[20px]"
                  data-weight="fill"
                  >star</span
                >
                <span
                  class="material-symbols-outlined text-[20px]"
                  data-weight="fill"
                  >star</span
                >
                <span
                  class="material-symbols-outlined text-[20px]"
                  data-weight="fill"
                  >star</span
                >
                <span
                  class="material-symbols-outlined text-[20px]"
                  data-weight="fill"
                  >star</span
                >
                <span
                  class="material-symbols-outlined text-[20px]"
                  data-weight="fill"
                  >star</span
                >
              </div>
              <p class="font-body-md text-body-md text-on-surface italic">
                "Bộ Millennium Falcon UCS 75192 nặng cả chục ký mà shop hỗ trợ
                mang tận lên tầng 5 chung cư. Hàng chính hãng có tem Đan Mạch an
                tâm tuyệt đối."
              </p>
            </div>
            <div
              class="flex items-center gap-3 mt-6 pt-4 border-t border-surface-container"
            >
              <div
                class="w-10 h-10 rounded-full bg-secondary-container/40 text-on-secondary-container font-bold flex items-center justify-center font-label-md"
              >
                NA
              </div>
              <div>
                <h4
                  class="font-headline-sm text-headline-sm font-bold leading-none"
                >
                  Nguyễn Tuấn Anh
                </h4>
                <p class="font-label-sm text-label-sm text-outline mt-0.5">
                  Collector Hà Nội • VIP Diamond
                </p>
              </div>
            </div>
          </div>
          <!-- Review 3 -->
          <div
            class="bg-surface-container-lowest p-space-lg rounded-2xl border border-outline-variant/30 shadow-sm flex flex-col justify-between"
          >
            <div>
              <div class="flex text-secondary-container mb-3">
                <span
                  class="material-symbols-outlined text-[20px]"
                  data-weight="fill"
                  >star</span
                >
                <span
                  class="material-symbols-outlined text-[20px]"
                  data-weight="fill"
                  >star</span
                >
                <span
                  class="material-symbols-outlined text-[20px]"
                  data-weight="fill"
                  >star</span
                >
                <span
                  class="material-symbols-outlined text-[20px]"
                  data-weight="fill"
                  >star</span
                >
                <span
                  class="material-symbols-outlined text-[20px]"
                  data-weight="fill"
                  >star</span
                >
              </div>
              <p class="font-body-md text-body-md text-on-surface italic">
                "Chính sách tích điểm gạch VIP siêu hời! Mình đổi được set quà
                mini figure độc quyền dịp sinh nhật. Nhân viên tư vấn am hiểu
                từng dòng sản phẩm."
              </p>
            </div>
            <div
              class="flex items-center gap-3 mt-6 pt-4 border-t border-surface-container"
            >
              <div
                class="w-10 h-10 rounded-full bg-primary/10 text-primary font-bold flex items-center justify-center font-label-md"
              >
                ML
              </div>
              <div>
                <h4
                  class="font-headline-sm text-headline-sm font-bold leading-none"
                >
                  Lê Mai Lan
                </h4>
                <p class="font-label-sm text-label-sm text-outline mt-0.5">
                  Kiến trúc sư • VIP Silver
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

<script>
  // Đếm ngược đến hết ngày hôm nay
  (function () {
    const h = document.getElementById("cd-hours"), m = document.getElementById("cd-minutes"), s = document.getElementById("cd-seconds");
    if (!h) return;
    function tick() {
      const now = new Date(), end = new Date(); end.setHours(23, 59, 59, 999);
      let d = Math.max(0, Math.floor((end - now) / 1000));
      h.textContent = String(Math.floor(d / 3600)).padStart(2, "0");
      m.textContent = String(Math.floor(d % 3600 / 60)).padStart(2, "0");
      s.textContent = String(d % 60).padStart(2, "0");
    }
    tick(); setInterval(tick, 1000);
  })();
</script>
