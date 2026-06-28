<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sandbox</title>
    <link rel="stylesheet" href="{{ asset('frontend/css/root.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/home.css') }}">
    {{-- Font local: Be Vietnam Pro (không dùng Google CDN) --}}
    <link rel="stylesheet" href="{{ asset('frontend/css/fonts.css') }}">
</head>
<body>
  <x-icon-sprite />

  <header class="site-header">
    <nav class="topbar container">
      <a class="brand" href="#" aria-label="VietFin trang chủ"><img src="{{ asset('frontend/img/TV9TECH_logo_transparent – Đã sửa.png') }}" alt="VietFin"></a>

      <button class="menu-toggle" type="button" aria-label="Mở menu" aria-expanded="false">
        <x-icon name="menu" class="menu-icon" />
        <x-icon name="close" class="close-icon" />
      </button>

      <div class="nav-menu" id="mainMenu">
        <a class="nav-link active" href="#">TRANG CHỦ</a>
        <a class="nav-link" href="#">NẠP TIỀN ĐIỆN THOẠI</a>
        <a class="nav-link" href="#">MUA MÃ THẺ</a>
        <a class="nav-link" href="#">THANH TOÁN HÓA ĐƠN</a>
        <a class="nav-link" href="#">TOPUP DATA</a>
      </div>

        <button class="icon-btn" type="button" aria-label="Thông báo">
          <x-icon name="notifications" />
        </button>

        {{-- Nút tài khoản + menu cấp 2 --}}
        <div class="user-dropdown" id="userDropdown">
          <button
            class="icon-btn"
            type="button"
            id="accountBtn"
            aria-label="Tài khoản"
            aria-expanded="false"
            aria-controls="accountMenu"
          >
            <x-icon name="account_circle" />
          </button>

          {{-- Menu cấp 2 --}}
          <div class="dropdown-menu" id="accountMenu" role="menu" aria-hidden="true">
            {{-- Header: tên + username --}}
            <div class="dropdown-header">
              <x-icon name="account_circle" class="dropdown-header__icon" />
              <div>
                <strong>{{ auth()->user()->ten_hien_thi }}</strong>
                <span>{{ auth()->user()->ten_dang_nhap }}</span>
              </div>
            </div>

            <hr class="dropdown-divider" />

            <a href="#" class="dropdown-item" role="menuitem">
              <x-icon name="person" />
              Thông tin tài khoản
            </a>
            <a href="#" class="dropdown-item" role="menuitem">
              <x-icon name="lock_reset" />
              Đổi mật khẩu
            </a>

            <hr class="dropdown-divider" />

            {{-- Nút đăng xuất — trigger JS submit form ẩn bên dưới --}}
            <button
              type="button"
              class="dropdown-item dropdown-item--danger"
              id="logoutBtn"
              role="menuitem"
            >
              <x-icon name="logout" />
              Đăng xuất
            </button>
          </div>
        </div>
      </div>
    </nav>
  </header>

  <section class="hero">
    <div class="hero-bg"></div>
    <div class="hero-overlay"></div>

    <div class="hero-content container">
      <div class="hero-title">
        <x-icon name="home" class="hero-icon" />
        <h1>WELCOME</h1>
      </div>

      <div class="balance-card">
        <p>Mã ĐL: <strong>A6844870</strong></p>
        <p>Số dư: <strong>55.630.069.900đ</strong></p>
        <button class="outline-btn" type="button">NẠP TIỀN TÀI KHOẢN</button>
      </div>
    </div>
  </section>
  {{-- Dịch vụ --}}
@yield('content')
  {{-- Footer --}}
  <footer class="site-footer">
    <div class="footer-inner container">
      <div class="footer-brand">
        <strong>VietFin</strong>
        <p>© 2024 VietFin. Cổng thanh toán tài chính chuyên nghiệp.</p>
      </div>

      <div class="footer-links">
        <div>
          <a href="#">Về chúng tôi</a>
          <a href="#">Điều khoản sử dụng</a>
        </div>
        <div>
          <a href="#">Chính sách bảo mật</a>
          <a href="#">Liên hệ hỗ trợ</a>
        </div>
      </div>
    </div>
  </footer>

  {{-- Form đăng xuất ẩn — submit bằng JS --}}
  <form id="logoutForm" method="POST" action="{{ route('logout') }}" style="display:none">
    @csrf
  </form>

  <script src="{{ asset('frontend/js/home.js') }}"></script>
</body>
</html>
