<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Bảng này dùng để cấp quyền loại sản phẩm cho API Partner.
     * Ví dụ partner chỉ được dùng loại sản phẩm Viettel, Mobifone.
     */
    public function up(): void
    {
        Schema::create('dai_ly_api_loai_san_pham_duoc_phep', function (Blueprint $table) {
            $table->id();

            /**
             * API Partner được cấp quyền.
             */
            $table->foreignId('dai_ly_api_id')
                ->constrained('dai_ly_api')
                ->cascadeOnDelete();

            /**
             * Loại sản phẩm được phép dùng.
             * Ví dụ: Viettel, Mobifone, Garena.
             */
            $table->foreignId('loai_san_pham_id')
                ->constrained('loai_san_pham')
                ->cascadeOnDelete();

            $table->timestamps();

            /**
             * Tránh cấp trùng cùng một loại sản phẩm cho cùng một partner.
             */
            $table->unique(
                ['dai_ly_api_id', 'loai_san_pham_id'],
                'uk_dai_ly_api_loai_san_pham'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dai_ly_api_loai_san_pham_duoc_phep');
    }
};