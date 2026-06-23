<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Bảng ket_noi_nha_cung_cap dùng để lưu thông tin kết nối API của từng NCC.
     * Ví dụ: api_url, api_user, api_password, timeout.
     * Lưu ý: password/secret/private key không lưu plain text, sau này model sẽ dùng encrypted cast.
     */
    public function up(): void
    {
        Schema::create('ket_noi_nha_cung_cap', function (Blueprint $table) {
            /**
             * id là khóa chính của cấu hình kết nối.
             */
            $table->id();

            /**
             * nha_cung_cap_id liên kết kết nối này với một NCC cụ thể.
             * Nếu xóa NCC thì kết nối cũng bị xóa theo.
             */
            $table->foreignId('nha_cung_cap_id')
                ->constrained('nha_cung_cap')
                ->cascadeOnDelete();

            /**
             * username/password_ma_hoa dùng cho tài khoản đăng nhập nếu NCC có portal riêng.
             * password_ma_hoa phải được mã hóa, không lưu password thật dạng text thường.
             */
            $table->string('username')->nullable();
            $table->text('password_ma_hoa')->nullable();

            /**
             * api_user/api_password_ma_hoa dùng để gọi API NCC.
             * Ví dụ AppotaPay có thể có partner code, username, password, secret...
             */
            $table->string('api_user')->nullable();
            $table->text('api_password_ma_hoa')->nullable();

            /**
             * api_url là URL endpoint chính của NCC.
             * Ví dụ sandbox hoặc production URL.
             */
            $table->string('api_url')->nullable();

            /**
             * public_key_file và private_key_file_ma_hoa dùng cho NCC cần ký RSA/private key.
             * private key phải mã hóa hoặc lưu file bảo mật, không đưa thẳng vào code.
             */
            $table->string('public_key_file')->nullable();
            $table->text('private_key_file_ma_hoa')->nullable();

            /**
             * timeout_he_thong là thời gian hệ thống mình chờ.
             * timeout_ncc là thời gian gửi sang NCC.
             * Tách ra để sau này dễ chỉnh khi NCC chậm.
             */
            $table->integer('timeout_he_thong')->default(30);
            $table->integer('timeout_ncc')->default(25);

            /**
             * trang_thai dùng để bật/tắt kết nối API này.
             */
            $table->string('trang_thai')->default('hoat_dong');

            /**
             * timestamps giúp biết cấu hình kết nối được tạo/cập nhật khi nào.
             */
            $table->timestamps();
        });
    }

    /**
     * Rollback bảng kết nối NCC.
     */
    public function down(): void
    {
        Schema::dropIfExists('ket_noi_nha_cung_cap');
    }
};