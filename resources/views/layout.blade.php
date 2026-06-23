<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sandbox</title>
    <link rel="stylesheet" href="{{ asset('frontend/css/root.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/home.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
</head>
<body>
  <header class="site-header">
    <nav class="topbar container">
      <a class="brand" href="#" aria-label="VietFin trang chủ"><img src="{{ asset('frontend/img/TV9TECH_logo_transparent – Đã sửa.png') }}" alt="VietFin"></a>

      <button class="menu-toggle" type="button" aria-label="Mở menu" aria-expanded="false">
        <span class="material-symbols-outlined">menu</span>
      </button>

      <div class="nav-menu" id="mainMenu">
        <a class="nav-link active" href="#">TRANG CHỦ</a>
        <a class="nav-link" href="#">NẠP TIỀN ĐIỆN THOẠI</a>
        <a class="nav-link" href="#">MUA MÃ THẺ</a>
        <a class="nav-link" href="#">THANH TOÁN HÓA ĐƠN</a>
        <a class="nav-link" href="#">TOPUP DATA</a>
      </div>

      <div class="user-area">
        <div class="user-info">
          <strong>LÊ VƯƠNG</strong>
          <span>A6844870</span>
        </div>

        <button class="icon-btn" type="button" aria-label="Thông báo">
          <span class="material-symbols-outlined">notifications</span>
        </button>

        <button class="icon-btn" type="button" aria-label="Tài khoản">
          <span class="material-symbols-outlined">account_circle</span>
        </button>
      </div>
    </nav>
  </header>

  <section class="hero">
    <div class="hero-bg"></div>
    <div class="hero-overlay"></div>

    <div class="hero-content container">
      <div class="hero-title">
        <span class="material-symbols-outlined hero-icon">home</span>
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

  <script src="{{ asset('frontend/js/home.js') }}"></script>
  <script src="./assets/js/main.js"></script>
</body>
</html>
