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
        Schema::create('vai_tro', function (Blueprint $table) {
            $table->id();

            // Mã vai trò: ADMIN, KE_TOAN, DOI_SOAT...
            $table->string('ma_vai_tro')->unique();

            // Tên hiển thị: Quản trị hệ thống, Kế toán...
            $table->string('ten_vai_tro');

            // Mô tả thêm nếu cần
            $table->text('mo_ta')->nullable();

            // Vai trò mặc định cho user mới hay không
            $table->boolean('mac_dinh')->default(false);

            // hoat_dong, tam_khoa
            $table->string('trang_thai')->default('hoat_dong')->index();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('vai_tro');
    }
};
