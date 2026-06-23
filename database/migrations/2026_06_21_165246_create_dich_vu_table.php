<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * NOTE:
     * Hàm up() dùng để tạo bảng dich_vu khi chạy php artisan migrate.
     * Bảng này lưu các dịch vụ lớn của hệ thống như TOPUP, PIN_CODE, PAY_BILL.
     */
    public function up(): void
    {
        Schema::create('dich_vu', function (Blueprint $table) {
            /**
             * NOTE:
             * id là khóa chính của bảng.
             * Các bảng khác như loai_san_pham, san_pham, don_hang sẽ liên kết về id này.
             */
            $table->id();

            /**
             * NOTE:
             * ma_dich_vu là mã định danh duy nhất của dịch vụ.
             * Sau này code sẽ dùng mã này để xử lý logic, ví dụ TOPUP hoặc PIN_CODE.
             */
            $table->string('ma_dich_vu')->unique();

            /**
             * NOTE:
             * ten_dich_vu là tên hiển thị trên admin/web.
             * Ví dụ: Nạp tiền điện thoại, Mua mã thẻ.
             */
            $table->string('ten_dich_vu');

            /**
             * NOTE:
             * trang_thai dùng để bật/tắt dịch vụ.
             * Nếu dịch vụ đang bán thì để hoat_dong.
             */
            $table->string('trang_thai')->default('hoat_dong');

            /**
             * NOTE:
             * thu_tu dùng để sắp xếp dịch vụ trên giao diện.
             * Số nhỏ hơn sẽ hiển thị trước.
             */
            $table->integer('thu_tu')->default(0);

            /**
             * NOTE:
             * mo_ta dùng để ghi chú thêm cho dịch vụ.
             * Có thể để trống nên dùng nullable().
             */
            $table->text('mo_ta')->nullable();

            /**
             * NOTE:
             * timestamps tạo created_at và updated_at.
             * Dùng để biết dịch vụ được tạo/cập nhật lúc nào.
             */
            $table->timestamps();
        });
    }

    /**
     * NOTE:
     * Hàm down() dùng khi rollback migration.
     * Nếu chạy php artisan migrate:rollback thì bảng dich_vu sẽ bị xóa.
     */
    public function down(): void
    {
        Schema::dropIfExists('dich_vu');
    }
};