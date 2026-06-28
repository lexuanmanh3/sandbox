@extends('admin.layout')

@section('title', 'VietFin - Quản lý lô hàng')

@section('content')
  <div class="admin-page-header">
    <div>
      <nav class="admin-breadcrumb" aria-label="Breadcrumb">
        <a href="{{ url('/admin') }}">Trang chủ</a>
        <span>/</span>
        <a href="#">Quản lý kho</a>
        <span>/</span>
        <strong>Quản lý lô hàng</strong>
      </nav>
      <h1>Quản lý lô hàng</h1>
    </div>

    <div class="admin-actions">
      <button class="btn btn--muted" type="button"><x-icon name="description" /> Xuất sang excel</button>
      <button class="btn btn--soft" type="button"><x-icon name="credit_card" /> Nhập thẻ từ file</button>
      <button class="btn btn--primary" type="button"><x-icon name="sync_alt" /> Nhập thẻ từ API</button>
    </div>
  </div>

  <section class="summary-grid" aria-label="Thống kê nhanh">
    <article class="summary-card summary-card--wide">
      <p>Tổng số lô hàng trong tháng</p>
      <strong>1,284</strong>
      <div class="summary-card__trend">
        <x-icon name="sync_alt" />
        <span>+12.5%</span>
        <small>so với tháng trước</small>
      </div>
      <div class="summary-card__chips">
        <span>API: 742</span>
        <span>FILE: 542</span>
      </div>
    </article>

    <article class="summary-card summary-card--green">
      <p>Giá trị tồn kho hiện tại</p>
      <strong>15.420.000.000đ</strong>
      <div class="summary-card__live">
        <span></span>
        Đang cập nhật thời gian thực
      </div>
    </article>
  </section>

  <section class="filter-panel">
    <button class="filter-panel__toggle" type="button" data-filter-toggle aria-expanded="true">
      <span><x-icon name="menu" /> Hiển thị bộ lọc nâng cao</span>
      <x-icon name="sync_alt" />
    </button>

    <form class="filter-panel__body" data-filter-body>
      <label>
        <span>Nhà cung cấp</span>
        <select>
          <option>Tất cả</option>
          <option>IRIS-TEST</option>
          <option>PBATELCO</option>
        </select>
      </label>
      <label>
        <span>Hình thức nhập</span>
        <select>
          <option>Tất cả</option>
          <option>API</option>
          <option>FILE</option>
        </select>
      </label>
      <label>
        <span>Trạng thái</span>
        <select>
          <option>Tất cả</option>
          <option>Hoạt động</option>
          <option>Hoàn thành</option>
          <option>Lỗi xử lý</option>
        </select>
      </label>
      <button class="btn btn--primary" type="submit"><x-icon name="visibility" /> Tìm kiếm</button>
    </form>
  </section>

  <section class="data-card" aria-label="Danh sách lô hàng">
    <div class="table-wrap">
      <table class="admin-table">
        <thead>
          <tr>
            <th>Hành động</th>
            <th>Thời gian</th>
            <th>Mã lô</th>
            <th>Nhà cung cấp</th>
            <th class="text-right">Số lượng</th>
            <th class="text-right">Tổng cộng</th>
            <th class="text-center">Hình thức nhập</th>
            <th>Trạng thái</th>
          </tr>
        </thead>
        <tbody>
          @php
            $rows = [
              ['time' => '25/05/2026 10:11:20', 'code' => 'FileImport_20260525101120762', 'provider' => 'IRIS-TEST', 'qty' => '1,000', 'total' => '19.000.000đ', 'type' => 'FILE', 'status' => 'Hoạt động', 'tone' => 'success'],
              ['time' => '25/05/2026 09:45:12', 'code' => 'API_POST_99218277312', 'provider' => 'PBATELCO', 'qty' => '500', 'total' => '4.500.000đ', 'type' => 'API', 'status' => 'Hoạt động', 'tone' => 'success'],
              ['time' => '24/05/2026 18:22:05', 'code' => 'FileImport_20260524182205551', 'provider' => 'IRIS-TEST', 'qty' => '2,500', 'total' => '47.500.000đ', 'type' => 'FILE', 'status' => 'Hoàn thành', 'tone' => 'neutral'],
              ['time' => '24/05/2026 15:30:00', 'code' => 'API_POST_88172635122', 'provider' => 'PBATELCO', 'qty' => '1,200', 'total' => '10.800.000đ', 'type' => 'API', 'status' => 'Lỗi xử lý', 'tone' => 'danger'],
            ];
          @endphp

          @foreach ($rows as $row)
            <tr>
              <td>
                <button class="table-action" type="button">
                  Hành động
                  <x-icon name="sync_alt" />
                </button>
              </td>
              <td>{{ $row['time'] }}</td>
              <td><a class="code-link" href="#">{{ $row['code'] }}</a></td>
              <td>{{ $row['provider'] }}</td>
              <td class="text-right">{{ $row['qty'] }}</td>
              <td class="text-right table-total">{{ $row['total'] }}</td>
              <td class="text-center">
                <span class="type-badge type-badge--{{ strtolower($row['type']) }}">{{ $row['type'] }}</span>
              </td>
              <td>
                <span class="status status--{{ $row['tone'] }}">
                  <i></i>
                  {{ $row['status'] }}
                </span>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <footer class="table-pagination">
      <p>Đang xem <strong>1</strong> đến <strong>10</strong> trong tổng số <strong>29</strong> mục</p>
      <div>
        <button type="button" disabled>«</button>
        <button type="button" disabled>‹</button>
        <button class="is-active" type="button">1</button>
        <button type="button">2</button>
        <button type="button">3</button>
        <button type="button">›</button>
        <button type="button">»</button>
      </div>
    </footer>
  </section>
@endsection
