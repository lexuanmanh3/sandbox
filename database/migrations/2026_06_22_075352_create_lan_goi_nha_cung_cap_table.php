<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Bảng này lưu từng lần gọi nhà cung cấp.
     *
     * Một đơn hàng có thể gọi NCC nhiều lần:
     * - lần 1 gọi NCC chính
     * - nếu lỗi, sau này có thể retry hoặc fallback NCC khác
     */
    public function up(): void
    {
        Schema::create('lan_goi_nha_cung_cap', function (Blueprint $table) {
            $table->id();

            /**
             * Lần gọi này thuộc đơn hàng nào.
             */
            $table->foreignId('don_hang_id')
                ->constrained('don_hang')
                ->cascadeOnDelete();

            /**
             * NCC được gọi.
             */
            $table->foreignId('nha_cung_cap_id')
                ->nullable()
                ->constrained('nha_cung_cap')
                ->nullOnDelete();

            /**
             * Cấu hình dịch vụ được dùng để gọi NCC.
             */
            $table->foreignId('cau_hinh_dich_vu_id')
                ->nullable()
                ->constrained('cau_hinh_dich_vu')
                ->nullOnDelete();

            /**
             * lan_thu cho biết đây là lần gọi thứ mấy.
             */
            $table->integer('lan_thu')->default(1);

            /**
             * ma_giao_dich_ncc là mã giao dịch bên NCC trả về.
             */
            $table->string('ma_giao_dich_ncc')->nullable();

            /**
             * Lưu request/response để debug và đối soát.
             * Sau này nhớ che dữ liệu nhạy cảm trước khi lưu.
             */
            $table->json('request_json')->nullable();
            $table->json('response_json')->nullable();

            /**
             * Lỗi NCC và lỗi hệ thống sau khi map.
             */
            $table->string('ma_loi_ncc')->nullable();
            $table->string('ma_loi_he_thong')->nullable();

            /**
             * Trạng thái lần gọi NCC.
             * Ví dụ: dang_goi, thanh_cong, that_bai, timeout.
             */
            $table->string('trang_thai')->default('dang_goi');

            /**
             * Thời gian NCC xử lý.
             */
            $table->integer('thoi_gian_xu_ly_ms')->nullable();

            $table->timestamps();

            $table->index(['don_hang_id', 'lan_thu'], 'idx_lan_goi_don_hang');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lan_goi_nha_cung_cap');
    }
};