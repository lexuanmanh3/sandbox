<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Bảng dai_ly_api_san_pham_duoc_phep dùng để cấp quyền sản phẩm cụ thể cho API Partner.
     *
     * Ví dụ:
     * - Partner A được dùng Viettel 20k
     * - Partner A được dùng Viettel 50k
     * - Partner A không được dùng Viettel 100k nếu chưa được cấp trong bảng này
     */
    public function up(): void
    {
        Schema::create('dai_ly_api_san_pham_duoc_phep', function (Blueprint $table) {
            /**
             * id là khóa chính của dòng cấp quyền.
             */
            $table->id();

            /**
             * dai_ly_api_id cho biết quyền sản phẩm này thuộc về API Partner nào.
             */
            $table->foreignId('dai_ly_api_id')
                ->constrained('dai_ly_api')
                ->cascadeOnDelete();

            /**
             * san_pham_id cho biết partner được phép dùng sản phẩm cụ thể nào.
             */
            $table->foreignId('san_pham_id')
                ->constrained('san_pham')
                ->cascadeOnDelete();

            /**
             * Ghi lại thời điểm cấp quyền/cập nhật quyền.
             */
            $table->timestamps();

            /**
             * Không cho cấp trùng một sản phẩm cho cùng một partner.
             */
            $table->unique(
                ['dai_ly_api_id', 'san_pham_id'],
                'uk_dai_ly_api_san_pham_duoc_phep'
            );
        });
    }

    /**
     * Rollback bảng sản phẩm được phép của API Partner.
     */
    public function down(): void
    {
        Schema::dropIfExists('dai_ly_api_san_pham_duoc_phep');
    }
};
