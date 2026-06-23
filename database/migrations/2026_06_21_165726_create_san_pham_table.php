<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * NOTE:
     * Hàm up() dùng để tạo bảng san_pham.
     * Bảng này lưu sản phẩm/gói/mệnh giá cụ thể như Viettel 10k, Viettel 20k.
     */
    public function up(): void
    {
        Schema::create('san_pham', function (Blueprint $table) {
            /**
             * NOTE:
             * id là khóa chính của bảng san_pham.
             * Sau này đơn hàng sẽ lưu san_pham_id để biết khách mua sản phẩm nào.
             */
            $table->id();

            /**
             * NOTE:
             * dich_vu_id cho biết sản phẩm thuộc dịch vụ nào.
             * Ví dụ Viettel 20.000đ thuộc dịch vụ PIN_CODE.
             */
            $table->foreignId('dich_vu_id')
                ->constrained('dich_vu')
                ->restrictOnDelete();

            /**
             * NOTE:
             * loai_san_pham_id cho biết sản phẩm thuộc nhóm nào.
             * Ví dụ Viettel 20.000đ thuộc loại sản phẩm Viettel.
             */
            $table->foreignId('loai_san_pham_id')
                ->constrained('loai_san_pham')
                ->restrictOnDelete();

            /**
             * NOTE:
             * ma_san_pham là mã duy nhất của sản phẩm.
             * Sau này dùng để mapping với nhà cung cấp hoặc API Partner gửi đơn.
             */
            $table->string('ma_san_pham')->unique();

            /**
             * NOTE:
             * ten_san_pham là tên hiển thị trên admin/web/app.
             * Ví dụ: Viettel 20.000đ.
             */
            $table->string('ten_san_pham');

            /**
             * NOTE:
             * menh_gia là mệnh giá sản phẩm.
             * Dùng decimal(18,2) để lưu tiền chính xác hơn float/double.
             */
            $table->decimal('menh_gia', 18, 2)->default(0);

            /**
             * NOTE:
             * don_vi là đơn vị của sản phẩm.
             * Ví dụ: VND, MB, GB, ngày.
             */
            $table->string('don_vi')->default('VND');

            /**
             * NOTE:
             * thu_tu dùng để sắp xếp sản phẩm trên giao diện.
             * Số nhỏ hơn hiển thị trước.
             */
            $table->integer('thu_tu')->default(0);

            /**
             * NOTE:
             * trang_thai dùng để bật/tắt sản phẩm.
             * Nếu sản phẩm tạm dừng bán thì đổi trạng thái.
             */
            $table->string('trang_thai')->default('hoat_dong');

            /**
             * NOTE:
             * hinh_anh lưu đường dẫn icon/logo sản phẩm nếu có.
             */
            $table->string('hinh_anh')->nullable();

            /**
             * NOTE:
             * mo_ta dùng để ghi chú ngắn cho sản phẩm.
             */
            $table->text('mo_ta')->nullable();

            /**
             * NOTE:
             * ho_tro_khach_hang dùng để lưu thông tin hỗ trợ.
             * Ví dụ điều kiện sử dụng, hotline, ghi chú riêng.
             */
            $table->text('ho_tro_khach_hang')->nullable();

            /**
             * NOTE:
             * huong_dan_su_dung dùng để lưu hướng dẫn sử dụng sản phẩm.
             * Ví dụ cách dùng mã thẻ sau khi mua.
             */
            $table->text('huong_dan_su_dung')->nullable();

            /**
             * NOTE:
             * so_tien_toi_thieu dùng cho sản phẩm nạp linh hoạt.
             * Ví dụ nạp điện thoại tối thiểu 10.000đ.
             */
            $table->decimal('so_tien_toi_thieu', 18, 2)->nullable();

            /**
             * NOTE:
             * so_tien_toi_da dùng để giới hạn số tiền nạp tối đa.
             */
            $table->decimal('so_tien_toi_da', 18, 2)->nullable();

            /**
             * NOTE:
             * hien_thi_web_app quyết định sản phẩm có hiển thị cho khách mua không.
             * Có sản phẩm chỉ dùng nội bộ thì đặt false.
             */
            $table->boolean('hien_thi_web_app')->default(true);

            /**
             * NOTE:
             * timestamps tạo created_at và updated_at.
             * Dùng để biết sản phẩm được tạo/cập nhật lúc nào.
             */
            $table->timestamps();
        });
    }

    /**
     * NOTE:
     * Hàm down() dùng để rollback migration.
     * Nếu rollback, Laravel sẽ xóa bảng san_pham.
     */
    public function down(): void
    {
        Schema::dropIfExists('san_pham');
    }
};