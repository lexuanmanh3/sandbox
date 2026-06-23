<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Bảng dai_ly_api_dich_vu_duoc_phep dùng để cấp quyền dịch vụ cho API Partner.
     * Ví dụ partner A chỉ được dùng PIN_CODE và TOPUP, không được dùng PAY_BILL.
     */
    public function up(): void
    {
        Schema::create('dai_ly_api_dich_vu_duoc_phep', function (Blueprint $table) {
            /**
             * id là khóa chính của dòng cấp quyền.
             */
            $table->id();

            /**
             * dai_ly_api_id cho biết quyền này thuộc về partner nào.
             */
            $table->foreignId('dai_ly_api_id')
                ->constrained('dai_ly_api')
                ->cascadeOnDelete();

            /**
             * dich_vu_id cho biết partner được phép dùng dịch vụ nào.
             */
            $table->foreignId('dich_vu_id')
                ->constrained('dich_vu')
                ->cascadeOnDelete();

            /**
             * timestamps giúp kiểm tra quyền này được cấp từ lúc nào.
             */
            $table->timestamps();

            /**
             * unique tránh cấp trùng cùng một dịch vụ cho cùng một partner.
             */
            $table->unique(
                ['dai_ly_api_id', 'dich_vu_id'],
                'uk_dai_ly_api_dich_vu'
            );
        });
    }

    /**
     * Rollback bảng cấp quyền dịch vụ API Partner.
     */
    public function down(): void
    {
        Schema::dropIfExists('dai_ly_api_dich_vu_duoc_phep');
    }
};