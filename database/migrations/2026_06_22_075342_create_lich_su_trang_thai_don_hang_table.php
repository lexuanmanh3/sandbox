<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Bảng này lưu lịch sử đổi trạng thái đơn hàng.
     *
     * Ví dụ:
     * moi_tao → dang_xu_ly
     * dang_xu_ly → thanh_cong
     * dang_xu_ly → that_bai
     *
     * Sau này debug đơn rất cần bảng này.
     */
    public function up(): void
    {
        Schema::create('lich_su_trang_thai_don_hang', function (Blueprint $table) {
            $table->id();

            /**
             * Đơn hàng được thay đổi trạng thái.
             */
            $table->foreignId('don_hang_id')
                ->constrained('don_hang')
                ->cascadeOnDelete();

            /**
             * Trạng thái cũ và trạng thái mới.
             */
            $table->string('trang_thai_cu')->nullable();
            $table->string('trang_thai_moi');

            /**
             * Lý do đổi trạng thái.
             */
            $table->text('ly_do')->nullable();

            /**
             * du_lieu_json lưu thêm dữ liệu debug nếu cần.
             */
            $table->json('du_lieu_json')->nullable();

            /**
             * thay_doi_boi là user thực hiện thay đổi.
             * Với API/webhook/job tự động có thể để null.
             */
            $table->foreignId('thay_doi_boi')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            /**
             * nguon_thay_doi cho biết trạng thái đổi từ đâu.
             * Ví dụ: api_partner, he_thong, ncc_callback, admin.
             */
            $table->string('nguon_thay_doi')->default('he_thong');

            $table->timestamps();

            /**
             * Index để xem lịch sử của một đơn nhanh hơn.
             */
            $table->index(['don_hang_id', 'created_at'], 'idx_lich_su_don_hang');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lich_su_trang_thai_don_hang');
    }
};