<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('users', function (Blueprint $table) {
    $table->id();

    // Thông tin đăng nhập
    $table->string('ten_dang_nhap')->unique();
    $table->string('email')->nullable()->unique();
    $table->string('so_dien_thoai')->nullable()->index();
    $table->string('password');

    // Thông tin cá nhân
    $table->string('ho')->nullable();
    $table->string('ten')->nullable();
    $table->string('name')->nullable();

    // Phân loại tài khoản
    // admin, ke_toan, doi_soat, sale, dai_ly, dai_ly_api, customer
    $table->string('loai_tai_khoan')->default('customer')->index();

    // Trạng thái xác thực
    $table->timestamp('email_verified_at')->nullable();
    $table->boolean('email_da_xac_nhan')->default(false);
    $table->boolean('tai_khoan_da_xac_thuc')->default(false);

    // Bảo mật tài khoản
    $table->boolean('bat_buoc_doi_mat_khau')->default(false);
    $table->boolean('tu_dong_khoa_tai_khoan')->default(false);
    $table->boolean('bi_khoa')->default(false);

    // hoat_dong, tam_khoa, cho_duyet, huy
    $table->string('trang_thai')->default('hoat_dong')->index();

    // Lần đăng nhập cuối
    $table->timestamp('lan_dang_nhap_cuoi')->nullable();

    $table->rememberToken();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
