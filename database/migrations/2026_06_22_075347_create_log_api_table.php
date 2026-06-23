<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Bảng log_api lưu request/response API vào và ra.
     *
     * Với API Partner:
     * - log request partner gửi vào
     * - log response hệ thống trả ra
     *
     * Với NCC:
     * - cũng có thể log request gửi sang NCC nếu cần.
     */
    public function up(): void
    {
        Schema::create('log_api', function (Blueprint $table) {
            $table->id();

            /**
             * huong cho biết log là inbound hay outbound.
             * inbound: partner gọi vào hệ thống
             * outbound: hệ thống gọi ra NCC
             */
            $table->string('huong');

            /**
             * doi_tuong và doi_tuong_id cho biết log thuộc về ai.
             * Ví dụ: dai_ly_api / 1, nha_cung_cap / 2.
             */
            $table->string('doi_tuong')->nullable();
            $table->unsignedBigInteger('doi_tuong_id')->nullable();

            /**
             * Nếu log liên quan đến đơn hàng thì lưu don_hang_id.
             */
            $table->foreignId('don_hang_id')
                ->nullable()
                ->constrained('don_hang')
                ->nullOnDelete();

            /**
             * endpoint và method giúp biết API nào được gọi.
             */
            $table->string('endpoint')->nullable();
            $table->string('method')->nullable();

            /**
             * request_body_json và response_body_json lưu nội dung request/response.
             * Sau này cần chú ý che secret/token trước khi lưu log.
             */
            $table->json('request_body_json')->nullable();
            $table->integer('response_status')->nullable();
            $table->json('response_body_json')->nullable();

            /**
             * IP và thời gian xử lý giúp debug lỗi chậm/lỗi bảo mật.
             */
            $table->string('dia_chi_ip')->nullable();
            $table->integer('thoi_gian_xu_ly_ms')->nullable();

            $table->timestamps();

            $table->index(['doi_tuong', 'doi_tuong_id'], 'idx_log_api_doi_tuong');
            $table->index(['don_hang_id', 'created_at'], 'idx_log_api_don_hang');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('log_api');
    }
};