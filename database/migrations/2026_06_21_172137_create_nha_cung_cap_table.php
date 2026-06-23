<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Bảng nha_cung_cap dùng để lưu danh sách nhà cung cấp xử lý giao dịch thật.
     * Ví dụ: AppotaPay, NCC Viettel, NCC Mobifone, NCC Game Card...
     * Sau này nếu muốn thêm/sửa thông tin NCC thì sửa ở bảng này.
     */
    public function up(): void
    {
        Schema::create('nha_cung_cap', function (Blueprint $table) {
            /**
             * id là khóa chính của nhà cung cấp.
             * Laravel dùng id này để liên kết với bảng kết nối API và cấu hình dịch vụ.
             */
            $table->id();

            /**
             * nha_cung_cap_cha_id dùng khi sau này một NCC có nhiều nhánh/con.
             * Hiện tại chưa cần thì có thể để null.
             */
            $table->foreignId('nha_cung_cap_cha_id')
                ->nullable()
                ->constrained('nha_cung_cap')
                ->nullOnDelete();

            /**
             * ma_ncc là mã duy nhất của nhà cung cấp.
             * Ví dụ: APPOTAPAY, NCC_VIETTEL, NCC_TEST.
             * Khi code xử lý API, mình nên dùng mã này thay vì dùng tên.
             */
            $table->string('ma_ncc')->unique();

            /**
             * ten_ncc là tên hiển thị trên admin.
             * Ví dụ: AppotaPay, Nhà cung cấp test nội bộ.
             */
            $table->string('ten_ncc');

            /**
             * Thông tin liên hệ của NCC.
             * Không bắt buộc nhưng hữu ích khi cần đối soát hoặc báo lỗi.
             */
            $table->string('so_dien_thoai')->nullable();
            $table->string('email')->nullable();

            /**
             * trang_thai dùng để bật/tắt NCC.
             * Ví dụ: hoat_dong, tam_dung, khoa.
             */
            $table->string('trang_thai')->default('hoat_dong');

            /**
             * timestamps tạo ra created_at và updated_at.
             * Giúp biết NCC được tạo lúc nào và cập nhật lần cuối khi nào.
             */
            $table->timestamps();
        });
    }

    /**
     * Hàm down dùng để rollback migration.
     * Nếu chạy php artisan migrate:rollback thì bảng này sẽ bị xóa.
     */
    public function down(): void
    {
        Schema::dropIfExists('nha_cung_cap');
    }
};