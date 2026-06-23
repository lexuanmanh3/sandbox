<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * NOTE:
     * Hàm up() dùng để tạo bảng loai_san_pham.
     * Bảng này lưu nhóm sản phẩm thuộc từng dịch vụ, ví dụ Viettel thuộc PIN_CODE.
     */
    public function up(): void
    {
        Schema::create('loai_san_pham', function (Blueprint $table) {
            /**
             * NOTE:
             * id là khóa chính của bảng loai_san_pham.
             * Các bảng như san_pham, don_hang sẽ liên kết về id này.
             */
            $table->id();

            /**
             * NOTE:
             * loai_san_pham_cha_id dùng để tạo danh mục cha/con.
             * Ví dụ nhóm cha là Thẻ điện thoại, nhóm con là Viettel/Mobifone.
             * Hiện tại chưa cần dùng thì cho phép null.
             */
            $table->foreignId('loai_san_pham_cha_id')
                ->nullable()
                ->constrained('loai_san_pham')
                ->nullOnDelete();

            /**
             * NOTE:
             * dich_vu_id dùng để biết loại sản phẩm này thuộc dịch vụ nào.
             * Ví dụ Viettel thuộc dịch vụ PIN_CODE hoặc TOPUP.
             */
            $table->foreignId('dich_vu_id')
                ->constrained('dich_vu')
                ->restrictOnDelete();

            /**
             * NOTE:
             * ma_loai_san_pham là mã duy nhất của loại sản phẩm.
             * Sau này có thể dùng để mapping với nhà cung cấp hoặc API Partner.
             */
            $table->string('ma_loai_san_pham')->unique();

            /**
             * NOTE:
             * ten_loai_san_pham là tên hiển thị.
             * Ví dụ: Viettel, Mobifone, Vinaphone.
             */
            $table->string('ten_loai_san_pham');

            /**
             * NOTE:
             * thu_tu dùng để sắp xếp loại sản phẩm trên giao diện.
             * Số nhỏ hơn hiển thị trước.
             */
            $table->integer('thu_tu')->default(0);

            /**
             * NOTE:
             * trang_thai dùng để bật/tắt loại sản phẩm.
             * Ví dụ một nhà mạng đang bảo trì thì có thể chuyển tạm dừng.
             */
            $table->string('trang_thai')->default('hoat_dong');

            /**
             * NOTE:
             * hinh_anh lưu đường dẫn logo/icon nếu sau này hiển thị ngoài web/app.
             * Ví dụ logo Viettel, Mobifone.
             */
            $table->string('hinh_anh')->nullable();

            /**
             * NOTE:
             * mo_ta dùng để ghi chú thêm cho loại sản phẩm.
             * Có thể để trống.
             */
            $table->text('mo_ta')->nullable();

            /**
             * NOTE:
             * timestamps tạo created_at và updated_at.
             * Dùng để biết loại sản phẩm được tạo/cập nhật lúc nào.
             */
            $table->timestamps();
        });
    }

    /**
     * NOTE:
     * Hàm down() dùng để rollback migration.
     * Nếu rollback, Laravel sẽ xóa bảng loai_san_pham.
     */
    public function down(): void
    {
        Schema::dropIfExists('loai_san_pham');
    }
};