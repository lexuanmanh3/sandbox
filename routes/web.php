<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', [HomeController::class, 'index']);
Route::get('/nap-tien-dien-thoai', [HomeController::class, 'loaisanpham']);
Route::get('/test-admin', function () {
    return 'Bạn là admin';
})->middleware(['auth', 'vai_tro:admin']);

Route::get('/test-quyen', function () {
    return 'Bạn có quyền xem người dùng';
})->middleware(['auth', 'quyen:nguoi_dung.view']);


Route::get('/login', function () {
    return 'Trang login tạm thời. Sau này mình sẽ làm form đăng nhập thật.';
})->name('login');
use Illuminate\Support\Facades\Auth;

Route::get('/login-test', function () {
    Auth::loginUsingId(1);

    return 'Đã đăng nhập tạm bằng user ID = 1';
});