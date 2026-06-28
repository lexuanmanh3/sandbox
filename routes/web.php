<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\AuthController;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ===== TRANG CHỦ (yêu cầu đăng nhập) =====
Route::get('/', [HomeController::class, 'index'])->middleware('auth');
Route::get('/nap-tien-dien-thoai', [HomeController::class, 'loaisanpham'])->middleware('auth');

// ===== XÁC THỰC — Chỉ truy cập khi CHƯA đăng nhập =====
Route::middleware('guest')->group(function () {
    // Đăng nhập
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

    // Đăng ký
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
});

// Đăng xuất — chỉ khi đang đăng nhập
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ===== QUẢN TRỊ =====
Route::get('/admin', function () {
    return view('admin.dashboard');
})->name('admin.dashboard')->middleware(['auth', 'vai_tro:user,admin']);

Route::get('/admin/accounts', function () {
    $users = User::with('vaiTro')
        ->latest()
        ->paginate(10);

    $stats = [
        'total' => User::count(),
        'active' => User::where('trang_thai', 'hoat_dong')->where('bi_khoa', false)->count(),
        'locked' => User::where('bi_khoa', true)->count(),
        'new_this_month' => User::where('created_at', '>=', now()->startOfMonth())->count(),
    ];

    return view('admin.accounts', compact('users', 'stats'));
})->name('admin.accounts')->middleware(['auth', 'vai_tro:user,admin']);

// ===== ROUTE TEST (chỉ dùng khi phát triển) =====
Route::get('/test-admin', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'vai_tro:admin']);

Route::get('/test-quyen', function () {
    return 'Bạn có quyền xem người dùng';
})->middleware(['auth', 'quyen:nguoi_dung.view']);

// Đăng nhập nhanh bằng ID (chỉ dùng khi dev)
Route::get('/login-test', function () {
    Auth::loginUsingId(1);
    return 'Đã đăng nhập tạm bằng user ID = 1';
});
