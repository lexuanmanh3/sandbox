<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Bảng cau_hinh_dich_vu dùng để quyết định dịch vụ/loại sản phẩm/sản phẩm nào
     * sẽ chạy qua nhà cung cấp nào.
     *
     * Ví dụ:
     * - Viettel 20k chạy qua AppotaPay
     * - Viettel 50k chạy qua NCC khác
     * - Nếu AppotaPay lỗi thì sau này có thể fallback qua NCC ưu tiên 2
     */
    public function up(): void
    {
        Schema::create('cau_hinh_dich_vu', function (Blueprint $table) {
            /**
             * id là khóa chính của cấu hình.
             */
            $table->id();

            /**
             * ten_cau_hinh là tên dễ hiểu để admin nhìn trên màn hình.
             * Ví dụ: "Viettel PIN_CODE qua AppotaPay".
             */
            $table->string('ten_cau_hinh');

            /**
             * nha_cung_cap_id cho biết cấu hình này chạy qua NCC nào.
             */
            $table->foreignId('nha_cung_cap_id')
                ->constrained('nha_cung_cap')
                ->cascadeOnDelete();

            /**
             * dich_vu_id là dịch vụ lớn.
             * Ví dụ: TOPUP, PIN_CODE, TOPUP_DATA.
             */
            $table->foreignId('dich_vu_id')
                ->constrained('dich_vu')
                ->cascadeOnDelete();

            /**
             * loai_san_pham_id là nhóm sản phẩm con.
             * Ví dụ: Viettel, Mobifone, Garena.
             * Có thể null nếu cấu hình áp dụng cho toàn bộ dịch vụ.
             */
            $table->foreignId('loai_san_pham_id')
                ->nullable()
                ->constrained('loai_san_pham')
                ->nullOnDelete();

            /**
             * san_pham_id là sản phẩm cụ thể.
             * Ví dụ: Viettel 20k, Viettel 50k.
             * Có thể null nếu cấu hình áp dụng cho toàn bộ loại sản phẩm.
             */
            $table->foreignId('san_pham_id')
                ->nullable()
                ->constrained('san_pham')
                ->nullOnDelete();

            /**
             * dai_ly_ap_dung_id và tai_khoan_ap_dung_id để sau này cấu hình riêng cho từng đại lý/tài khoản.
             * Hiện tại chưa tạo bảng đại lý nên mình để unsignedBigInteger + index trước.
             * Khi tạo bảng dai_ly xong có thể bổ sung foreign key sau.
             */
            $table->unsignedBigInteger('dai_ly_ap_dung_id')->nullable()->index();
            $table->unsignedBigInteger('tai_khoan_ap_dung_id')->nullable()->index();

            /**
             * muc_uu_tien dùng để chọn NCC ưu tiên.
             * Số càng nhỏ càng ưu tiên cao.
             * Ví dụ: 1 là NCC chính, 2 là NCC dự phòng.
             */
            $table->integer('muc_uu_tien')->default(1);

            /**
             * dang_mo cho biết cấu hình này có đang được phép chạy không.
             * Nếu false thì hệ thống không chọn cấu hình này để xử lý đơn.
             */
            $table->boolean('dang_mo')->default(true);

            /**
             * timeout riêng cho từng cấu hình.
             * Có sản phẩm/NCC chạy nhanh, có cái chạy chậm nên tách riêng để dễ chỉnh.
             */
            $table->integer('timeout_he_thong_giay')->default(30);
            $table->integer('timeout_gui_ncc_giay')->default(25);
            $table->integer('thoi_gian_tra_ket_qua_giay')->default(60);

            /**
             * che_do_chay dùng để phân biệt cách xử lý.
             * Ví dụ: api, kho_the, thu_cong.
             */
            $table->string('che_do_chay')->default('api');

            /**
             * ket_thuc_cau_hinh dùng để chặn không tìm tiếp NCC khác sau cấu hình này.
             * Hiện tại để false, sau này làm fallback NCC sẽ dùng tới.
             */
            $table->boolean('ket_thuc_cau_hinh')->default(false);

            /**
             * timestamps giúp biết cấu hình được tạo/cập nhật khi nào.
             */
            $table->timestamps();

            /**
             * Index giúp truy vấn nhanh khi tìm cấu hình theo dịch vụ, loại sản phẩm, sản phẩm.
             */
            $table->index([
                'dich_vu_id',
                'loai_san_pham_id',
                'san_pham_id',
                'dang_mo',
                'muc_uu_tien'
            ], 'idx_cau_hinh_dich_vu_lookup');
        });
    }

    /**
     * Rollback bảng cấu hình dịch vụ.
     */
    public function down(): void
    {
        Schema::dropIfExists('cau_hinh_dich_vu');
    }
};