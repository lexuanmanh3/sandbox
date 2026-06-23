 
@extends('layout')
@section('content')
 <main class="main-content container">
    <section class="dashboard-card">
      <div class="quick-links">
        <a class="quick-link" href="#">
          <span class="material-symbols-outlined">description</span>
          <span>Thông tin tài khoản</span>
        </a>

        <a class="quick-link" href="#">
          <span class="material-symbols-outlined">payments</span>
          <span>Nạp tiền tài khoản</span>
        </a>

        <a class="quick-link" href="#">
          <span class="material-symbols-outlined">sync_alt</span>
          <span>Chuyển tiền đại lý</span>
        </a>

        <a class="quick-link" href="#">
          <span class="material-symbols-outlined">history</span>
          <span>Lịch sử giao dịch</span>
        </a>
      </div>

      <div class="section-heading">
        <h2>NẠP TIỀN - THANH TOÁN ĐƠN GIẢN CHỈ VỚI VÀI THAO TÁC</h2>
      </div>

      <div class="services-wrap">
        <div class="service-grid">
          <button class="service-item" type="button">
            <span class="material-symbols-outlined">mobile_friendly</span>
            <span>NẠP TIỀN ĐIỆN THOẠI</span>
          </button>

          <button class="service-item" type="button">
            <span class="material-symbols-outlined">phone_iphone</span>
            <span>NẠP TIỀN TRẢ SAU</span>
          </button>

          <button class="service-item" type="button">
            <span class="material-symbols-outlined">cell_wifi</span>
            <span>NẠP TOPUP DATA</span>
          </button>

          <button class="service-item" type="button">
            <span class="material-symbols-outlined">credit_card</span>
            <span>MUA THẺ ĐIỆN THOẠI</span>
          </button>

          <button class="service-item " type="button">
            <span class="material-symbols-outlined">sports_esports</span>
            <span>MUA THẺ GAME</span>
          </button>

          <button class="service-item" type="button">
            <span class="material-symbols-outlined">sim_card</span>
            <span>MUA THẺ DATA</span>
          </button>

          <button class="service-item" type="button">
            <span class="material-symbols-outlined">account_balance_wallet</span>
            <span>THANH TOÁN HÓA ĐƠN</span>
          </button>

          <div class="service-placeholder" aria-hidden="true"></div>
          <div class="service-placeholder" aria-hidden="true"></div>
        </div>
      </div>

      <section class="calendar-strip" aria-label="Lịch giao dịch">
        <div class="month-box">
          <span>Tháng 5</span>
          <strong>2026</strong>
        </div>

        <div class="calendar-days">
          <div class="day has-event">
            <span>Thứ 2</span>
            <strong>15</strong>
          </div>
          <div class="day has-event">
            <span>Thứ 3</span>
            <strong>16</strong>
          </div>
          <div class="day">
            <span>Thứ 4</span>
            <strong>17</strong>
          </div>
          <div class="day muted-event">
            <span>Thứ 5</span>
            <strong>18</strong>
          </div>
          <div class="day soft-bg">
            <span>Thứ 6</span>
            <strong>19</strong>
          </div>
          <div class="day soft-bg has-event">
            <span>Thứ 7</span>
            <strong>20</strong>
          </div>
          <div class="day sunday muted-event">
            <span>Chủ nhật</span>
            <strong>21</strong>
          </div>
        </div>
      </section>
    </section>
  </main>
  @endsection