</div><!-- /flex-grow -->
<section
      class="bg-surface-container-highest border-t border-outline-variant/30 py-space-xl"
    >
      <div class="max-w-7xl mx-auto px-margin-mobile md:px-margin">
        <div
          class="bg-gradient-to-r from-primary to-primary-container rounded-3xl p-space-lg md:p-space-xl text-on-primary shadow-xl flex flex-col lg:flex-row items-center justify-between gap-space-lg"
        >
          <div class="max-w-xl text-center lg:text-left">
            <span
              class="bg-secondary-container text-on-secondary-container font-label-sm text-label-sm px-2.5 py-1 rounded font-black uppercase tracking-wider"
            >
              QUÀ TẶNG THÀNH VIÊN MỚI
            </span>
            <h3
              class="font-headline-xl-mobile md:font-headline-xl text-headline-xl-mobile md:text-headline-xl font-black mt-2 leading-tight"
            >
              Đăng ký nhận mã giảm giá 100.000đ
            </h3>
            <p class="font-body-md text-body-md text-primary-fixed mt-1">
              Cập nhật sớm nhất thông tin các bộ LEGO giới hạn sắp về hàng và ưu
              đãi dành riêng cho VIP.
            </p>
          </div>
          <form action="index.php" method="get"
            class="w-full lg:w-auto flex-1 max-w-md flex flex-col sm:flex-row gap-2"
          ><input type="hidden" name="page" value="register" />
            <input
              class="w-full bg-on-primary text-on-surface px-4 py-3.5 rounded-xl border-0 focus:ring-2 focus:ring-secondary-container font-body-sm text-body-sm placeholder:text-outline"
              name="email" placeholder="Nhập email của bạn..."
              required=""
              type="email"
            />
            <button
              class="bg-secondary-container hover:bg-secondary-fixed text-on-surface font-label-lg text-label-lg px-6 py-3.5 rounded-xl font-bold shadow-md transition-all active:scale-95 whitespace-nowrap"
              type="submit"
            >
              Đăng ký
            </button>
          </form>
        </div>
      </div>
    </section>
    <!-- 10. Footer Thương Mại Điện Tử Chuyên Nghiệp (Footer Component Anchor) -->
    <footer
      class="bg-surface-container text-on-surface border-t border-outline-variant/20 pt-space-xl pb-space-lg"
    >
      <div
        class="w-full mx-auto px-margin-mobile md:px-margin max-w-7xl flex flex-col gap-space-lg"
      >
        <!-- Upper Section: Brand, Address Showrooms & Navigation Links -->
        <div
          class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-space-lg"
        >
          <!-- Col 1: Brand Info -->
          <div class="lg:col-span-2 flex flex-col gap-space-md">
            <div class="flex items-center gap-space-sm">
              <span
                class="font-headline-lg text-headline-lg font-black text-primary tracking-tight"
                >RAMBO STORE</span
              >
            </div>
            <p
              class="font-body-sm text-body-sm text-on-surface-variant max-w-sm"
            >
              Hệ thống phân phối LEGO chính hãng hàng đầu tại Việt Nam. Nơi hội
              tụ các siêu phẩm dành cho cộng đồng đam mê gạch lắp ghép và nhà
              sưu tầm chuyên nghiệp.
            </p>
            <div
              class="flex flex-col gap-2 font-body-sm text-body-sm text-on-surface-variant"
            >
              <div class="flex items-start gap-2">
                <span class="material-symbols-outlined text-primary text-[20px]"
                  >store</span
                >
                <span
                  ><strong>Showroom Hà Nội:</strong> 88 Phố Huế, Q. Hai Bà
                  Trưng, Hà Nội</span
                >
              </div>
              <div class="flex items-start gap-2">
                <span class="material-symbols-outlined text-primary text-[20px]"
                  >store</span
                >
                <span
                  ><strong>Showroom TP.HCM:</strong> 124 Nguyễn Thị Minh Khai,
                  P.6, Quận 3, TP.HCM</span
                >
              </div>
              <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-primary text-[20px]"
                  >call</span
                >
                <span
                  >Hotline CSKH: <strong>1900 8888</strong> (8h00 - 21h30)</span
                >
              </div>
              <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-primary text-[20px]"
                  >mail</span
                >
                <span>Email: contact@rambostore.vn</span>
              </div>
            </div>
          </div>
          <!-- Col 2: Dịch Vụ & Cam Kết (From JSON Footer Links) -->
          <div>
            <h4
              class="font-headline-sm text-headline-sm font-bold text-on-surface mb-space-md"
            >
              Dịch Vụ &amp; Cam Kết
            </h4>
            <ul class="flex flex-col gap-2 font-label-md text-label-md">
              <li>
                <a
                  class="text-on-surface-variant hover:text-primary transition-colors"
                  href="index.php?page=about"
                  >100% Chính Hãng</a>
              </li>
              <li>
                <a
                  class="text-on-surface-variant hover:text-primary transition-colors"
                  href="index.php?page=about"
                  >Giao hàng hỏa tốc</a>
              </li>
              <li>
                <a
                  class="text-on-surface-variant hover:text-primary transition-colors"
                  href="index.php?page=about"
                  >Đổi trả 30 ngày</a>
              </li>
              <li>
                <a
                  class="text-on-surface-variant hover:text-primary transition-colors"
                  href="index.php?page=about"
                  >Bảo mật thông tin</a>
              </li>
            </ul>
          </div>
          <!-- Col 3: Hỗ Trợ Khách Hàng (From JSON Footer Links) -->
          <div>
            <h4
              class="font-headline-sm text-headline-sm font-bold text-on-surface mb-space-md"
            >
              Hỗ Trợ Khách Hàng
            </h4>
            <ul class="flex flex-col gap-2 font-label-md text-label-md">
              <li>
                <a
                  class="text-on-surface-variant hover:text-primary transition-colors"
                  href="index.php?page=about"
                  >Điều khoản dịch vụ</a>
              </li>
              <li>
                <a
                  class="text-on-surface-variant hover:text-primary transition-colors"
                  href="index.php?page=about"
                  >Hướng dẫn mua hàng</a>
              </li>
              <li>
                <a
                  class="text-on-surface-variant hover:text-primary transition-colors"
                  href="index.php?page=about#showroom"
                  >Hệ thống showroom</a>
              </li>
              <li>
                <a
                  class="text-on-surface-variant hover:text-primary transition-colors"
                  href="index.php?page=history"
                  >Tra cứu đơn hàng</a>
              </li>
            </ul>
          </div>
          <!-- Col 4: Cổng Thanh Toán & Kết Nối -->
          <div>
            <h4
              class="font-headline-sm text-headline-sm font-bold text-on-surface mb-space-md"
            >
              Thanh Toán &amp; Kết Nối
            </h4>
            <div class="flex flex-wrap gap-2 mb-space-md">
              <span
                class="bg-surface-container-lowest px-2 py-1 rounded border border-outline-variant/40 font-label-sm text-label-sm font-bold"
                >VNPAY</span
              >
              <span
                class="bg-surface-container-lowest px-2 py-1 rounded border border-outline-variant/40 font-label-sm text-label-sm font-bold text-primary"
                >MoMo</span
              >
              <span
                class="bg-surface-container-lowest px-2 py-1 rounded border border-outline-variant/40 font-label-sm text-label-sm font-bold"
                >VISA</span
              >
              <span
                class="bg-surface-container-lowest px-2 py-1 rounded border border-outline-variant/40 font-label-sm text-label-sm font-bold"
                >Mastercard</span
              >
              <span
                class="bg-surface-container-lowest px-2 py-1 rounded border border-outline-variant/40 font-label-sm text-label-sm font-bold"
                >COD</span
              >
            </div>
            <p class="font-label-sm text-label-sm text-outline mb-2">
              Mạng xã hội LEGO VIP Club:
            </p>
            <div class="flex items-center gap-space-sm text-on-surface-variant">
              <a
                aria-label="Facebook"
                class="w-9 h-9 rounded-full bg-surface-container-lowest flex items-center justify-center hover:bg-primary hover:text-on-primary transition-colors"
                href="#"
              >
                <span class="font-bold text-sm">f</span>
              </a>
              <a
                aria-label="YouTube"
                class="w-9 h-9 rounded-full bg-surface-container-lowest flex items-center justify-center hover:bg-primary hover:text-on-primary transition-colors"
                href="#"
              >
                <span class="font-bold text-sm">YT</span>
              </a>
              <a
                aria-label="Instagram"
                class="w-9 h-9 rounded-full bg-surface-container-lowest flex items-center justify-center hover:bg-primary hover:text-on-primary transition-colors"
                href="#"
              >
                <span class="font-bold text-sm">IG</span>
              </a>
              <a
                aria-label="TikTok"
                class="w-9 h-9 rounded-full bg-surface-container-lowest flex items-center justify-center hover:bg-primary hover:text-on-primary transition-colors"
                href="#"
              >
                <span class="font-bold text-sm">TT</span>
              </a>
            </div>
          </div>
        </div>
        <!-- Copyright Sub-bar -->
        <div
          class="border-t border-outline-variant/30 pt-space-md flex flex-col md:flex-row items-center justify-between text-center md:text-left gap-space-sm font-body-sm text-body-sm text-on-surface-variant"
        >
          <p>
            © 2024 RAMBO STORE Vietnam. Đối tác phân phối chính hãng LEGO. Giấy
            phép ĐKKD số 0108888888.
          </p>
          <p class="font-label-sm text-label-sm text-outline">
            LEGO, the LEGO logo are trademarks of the LEGO Group. All rights
            reserved.
          </p>
        </div>
      </div>
    </footer>

  </body>
</html>
