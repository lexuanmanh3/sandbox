@extends('admin.layout')

@section('title', 'VietFin - Quản lý tài khoản hệ thống')

@push('styles')
  <link rel="stylesheet" href="{{ asset('frontend/css/admin-accounts.css') }}">
@endpush

@section('content')
  <section class="account-page">
    <header class="account-header">
      <div>
        <nav class="account-breadcrumb" aria-label="Breadcrumb">
          <a href="{{ route('admin.dashboard') }}">Trang chủ</a>
          <span>/</span>
          <a href="#">Quản trị</a>
          <span>/</span>
          <strong>Quản lý tài khoản hệ thống</strong>
        </nav>
        <h1>Quản lý tài khoản hệ thống</h1>
        <p>Quản lý tài khoản người dùng và phân quyền truy cập ứng dụng.</p>
      </div>

      <div class="account-actions">
        <button class="account-btn account-btn--muted" type="button">
          <x-icon name="description" />
          <span>Hoạt động Excel</span>
          <svg class="account-btn__chevron" viewBox="0 0 20 20" aria-hidden="true" focusable="false">
            <path d="M5 7.5 10 12.5 15 7.5" />
          </svg>
        </button>
        <button class="account-btn account-btn--primary" type="button">
          <x-icon name="person" />
          <span>Tạo tài khoản người dùng mới</span>
        </button>
      </div>
    </header>

    <section class="account-stats" aria-label="Thống kê tài khoản">
      <article class="account-stat">
        <span><x-icon name="account_circle" /></span>
        <div>
          <p>Tổng tài khoản</p>
          <strong>{{ $stats['total'] }}</strong>
        </div>
      </article>
      <article class="account-stat">
        <span><x-icon name="check_circle" /></span>
        <div>
          <p>Đang hoạt động</p>
          <strong>{{ $stats['active'] }}</strong>
        </div>
      </article>
      <article class="account-stat">
        <span><x-icon name="error" /></span>
        <div>
          <p>Bị khóa</p>
          <strong>{{ $stats['locked'] }}</strong>
        </div>
      </article>
      <article class="account-stat">
        <span><x-icon name="history" /></span>
        <div>
          <p>Mới trong tháng</p>
          <strong>{{ $stats['new_this_month'] }}</strong>
        </div>
      </article>
    </section>

    <section class="account-card account-filter-section">
      <button class="account-filter-toggle" type="button" data-account-filter-toggle aria-expanded="false">
        <span><x-icon name="menu" /> Hiển thị bộ lọc nâng cao</span>
        <svg class="account-filter-toggle__chevron" viewBox="0 0 20 20" aria-hidden="true" focusable="false">
          <path d="M5 7.5 10 12.5 15 7.5" />
        </svg>
      </button>

      <form class="account-filter" data-account-filter hidden>
        <label>
          <span>Tên truy cập</span>
          <input type="text" placeholder="backend, 0967..." data-account-search>
        </label>
        <label>
          <span>Vai trò</span>
          <select>
            <option>Tất cả</option>
            <option>Admin</option>
            <option>User</option>
            <option>MasterAgent</option>
          </select>
        </label>
        <label>
          <span>Trạng thái</span>
          <select>
            <option>Tất cả</option>
            <option>Hoạt động</option>
            <option>Bị khóa</option>
          </select>
        </label>
        <button class="account-btn account-btn--primary" type="submit">
          <x-icon name="visibility" />
          Tìm kiếm
        </button>
      </form>
    </section>

    <section class="account-card account-table-card">
      <div class="account-table-wrap">
        <table class="account-table">
          <thead>
            <tr>
              <th>Hành động</th>
              <th>
                <button type="button">Tên truy cập <x-icon name="sync_alt" /></button>
              </th>
              <th>
                <button type="button">Họ và tên <x-icon name="sync_alt" /></button>
              </th>
              <th>Vai trò</th>
              <th>Địa chỉ email</th>
              <th>Email xác nhận</th>
              <th>Hoạt động</th>
              <th>Thời gian tạo</th>
            </tr>
          </thead>
          <tbody data-account-table-body>
            @forelse ($users as $user)
              @php
                $roleNames = $user->vaiTro->pluck('ten_vai_tro')->filter()->values();
                $roleLabel = $roleNames->isNotEmpty() ? $roleNames->join(', ') : ucfirst($user->loai_tai_khoan ?? 'User');
                $isActive = $user->trang_thai === 'hoat_dong' && ! $user->bi_khoa;
              @endphp
              <tr data-account-row>
                <td>
                  <div class="account-row-actions">
                    <button class="account-row-action" type="button" data-row-action>
                      Hành động
                      <svg viewBox="0 0 20 20" aria-hidden="true" focusable="false">
                        <path d="M5 7.5 10 12.5 15 7.5" />
                      </svg>
                    </button>
                    <div class="account-row-menu" hidden>
                      <button type="button">Xem chi tiết</button>
                      <button type="button">Phân quyền</button>
                      <button type="button">{{ $user->bi_khoa ? 'Mở khóa' : 'Khóa tài khoản' }}</button>
                    </div>
                  </div>
                </td>
                <td class="account-username">{{ $user->ten_dang_nhap }}</td>
                <td>{{ $user->ten_hien_thi ?: '-' }}</td>
                <td><span class="account-role">{{ $roleLabel }}</span></td>
                <td>{{ $user->email ?: ($user->so_dien_thoai ? $user->so_dien_thoai . '@default.com' : '-') }}</td>
                <td>
                  <span class="account-status-pill {{ $user->email_da_xac_nhan ? 'is-yes' : 'is-no' }}">
                    {{ $user->email_da_xac_nhan ? 'Đồng ý' : 'Không' }}
                  </span>
                </td>
                <td>
                  <span class="account-status-pill {{ $isActive ? 'is-yes' : 'is-no' }}">
                    {{ $isActive ? 'Đồng ý' : 'Không' }}
                  </span>
                </td>
                <td>{{ optional($user->created_at)->format('d/m/Y') ?: '-' }}</td>
              </tr>
            @empty
              <tr>
                <td class="account-empty" colspan="8">Chưa có tài khoản nào trong hệ thống.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <footer class="account-pagination">
        <div>
          <span>
            Đang xem {{ $users->firstItem() ?? 0 }} đến {{ $users->lastItem() ?? 0 }} trong tổng số {{ $users->total() }} mục
          </span>
          <label>
            Xem
            <select>
              <option>10</option>
              <option>25</option>
              <option>50</option>
            </select>
            mục
          </label>
        </div>

        <nav aria-label="Phân trang tài khoản">
          <a class="{{ $users->onFirstPage() ? 'is-disabled' : '' }}" href="{{ $users->url(1) }}">«</a>
          <a class="{{ $users->onFirstPage() ? 'is-disabled' : '' }}" href="{{ $users->previousPageUrl() ?: '#' }}">‹</a>
          @for ($page = 1; $page <= min($users->lastPage(), 3); $page++)
            <a class="{{ $users->currentPage() === $page ? 'is-active' : '' }}" href="{{ $users->url($page) }}">{{ $page }}</a>
          @endfor
          <a class="{{ $users->hasMorePages() ? '' : 'is-disabled' }}" href="{{ $users->nextPageUrl() ?: '#' }}">›</a>
          <a class="{{ $users->hasMorePages() ? '' : 'is-disabled' }}" href="{{ $users->url($users->lastPage()) }}">»</a>
        </nav>
      </footer>
    </section>
  </section>
@endsection

@push('scripts')
  <script src="{{ asset('frontend/js/admin-accounts.js') }}"></script>
@endpush
