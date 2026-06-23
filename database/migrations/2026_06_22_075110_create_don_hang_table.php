<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Bảng don_hang là bảng trung tâm lưu mọi đơn giao dịch.
     *
     * Với API Partner:
     * - Partner gửi đơn vào hệ thống.
     * - Hệ thống kiểm tra quyền dịch vụ / loại sản phẩm / sản phẩm.
     * - Hệ thống tạo đơn hàng.
     * - Nếu đơn thành công thì sau này ghi công nợ đối tác.
     */
    public function up(): void
    {
        Schema::create('don_hang', function (Blueprint $table) {
            /**
             * id là khóa chính của đơn hàng.
             */
            $table->id();

            /**
             * ma_don_hang là mã đơn nội bộ của hệ thống mình.
             * Ví dụ: DH202606220001.
             */
            $table->string('ma_don_hang')->unique();

            /**
             * nguon_don cho biết đơn đến từ đâu.
             * Ví dụ: api_partner, dai_ly, customer, admin.
             */
            $table->string('nguon_don')->default('api_partner');

            /**
             * nguoi_dung_id dùng nếu đơn được tạo bởi user đăng nhập.
             * Nếu bảng user của bạn đang là users thì giữ như này.
             * Nếu sau này đổi sang nguoi_dung thì sửa constrained('users') thành constrained('nguoi_dung').
             */
            $table->foreignId('nguoi_dung_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            /**
             * dai_ly_id dành cho đại lý thường.
             * Hiện tại mình chưa triển khai bảng dai_ly nên để unsignedBigInteger trước.
             * Sau khi có bảng dai_ly, mình có thể bổ sung foreign key sau.
             */
            $table->unsignedBigInteger('dai_ly_id')->nullable()->index();

            /**
             * dai_ly_api_id cho biết đơn này thuộc API Partner nào.
             * Với nghiệp vụ hiện tại của bạn, đây là field rất quan trọng.
             */
            $table->foreignId('dai_ly_api_id')
                ->nullable()
                ->constrained('dai_ly_api')
                ->nullOnDelete();

            /**
             * ma_don_doi_tac là mã đơn do API Partner gửi lên.
             * Dùng để đối soát và chống tạo trùng đơn.
             */
            $table->string('ma_don_doi_tac')->nullable();

            /**
             * idempotency_key dùng để chống gửi trùng request.
             * Ví dụ partner gửi lại cùng một request do timeout, hệ thống không tạo 2 đơn.
             */
            $table->string('idempotency_key')->nullable()->index();

            /**
             * Dịch vụ, loại sản phẩm, sản phẩm của đơn hàng.
             */
            $table->foreignId('dich_vu_id')
                ->constrained('dich_vu')
                ->cascadeOnDelete();

            $table->foreignId('loai_san_pham_id')
                ->nullable()
                ->constrained('loai_san_pham')
                ->nullOnDelete();

            $table->foreignId('san_pham_id')
                ->nullable()
                ->constrained('san_pham')
                ->nullOnDelete();

            /**
             * cau_hinh_dich_vu_id là cấu hình NCC được chọn để xử lý đơn.
             * Ví dụ sản phẩm Viettel 20k chạy qua AppotaPay.
             */
            $table->foreignId('cau_hinh_dich_vu_id')
                ->nullable()
                ->constrained('cau_hinh_dich_vu')
                ->nullOnDelete();

            /**
             * nha_cung_cap_id là NCC thật xử lý đơn.
             */
            $table->foreignId('nha_cung_cap_id')
                ->nullable()
                ->constrained('nha_cung_cap')
                ->nullOnDelete();

            /**
             * tai_khoan_nhan là thuê bao / tài khoản game / mã khách hàng nhận nạp.
             */
            $table->string('tai_khoan_nhan')->nullable();

            /**
             * so_luong dùng cho mua mã thẻ hoặc mua nhiều item.
             */
            $table->integer('so_luong')->default(1);

            /**
             * Các field tiền dùng decimal(18,2) để tránh sai số.
             */
            $table->decimal('menh_gia', 18, 2)->default(0);
            $table->decimal('gia_ban', 18, 2)->default(0);
            $table->decimal('gia_von', 18, 2)->default(0);
            $table->decimal('chiet_khau', 18, 2)->default(0);
            $table->decimal('loi_nhuan', 18, 2)->default(0);

            /**
             * phuong_thuc_thanh_toan cho biết đơn xử lý tiền kiểu gì.
             *
             * Với API Partner trả sau:
             * - dùng gia_tri: cong_no
             *
             * Với đại lý thường sau này:
             * - có thể dùng: vi, ngan_hang
             */
            $table->string('phuong_thuc_thanh_toan')->default('cong_no');

            /**
             * trang_thai_thanh_toan:
             * - cho API Partner trả sau: chua_thu
             * - cho đại lý thường: da_thanh_toan hoặc chua_thanh_toan
             */
            $table->string('trang_thai_thanh_toan')->default('chua_thu');

            /**
             * trang_thai_don_hang là trạng thái nghiệp vụ của đơn.
             * Ví dụ: moi_tao, dang_xu_ly, thanh_cong, that_bai, cho_doi_soat.
             */
            $table->string('trang_thai_don_hang')->default('moi_tao');

            /**
             * trang_thai_doi_soat cho biết đơn đã đưa vào đối soát chưa.
             * Ví dụ: chua_doi_soat, da_ghi_cong_no, da_xuat_hoa_don.
             */
            $table->string('trang_thai_doi_soat')->default('chua_doi_soat');

            /**
             * Lưu lỗi chuẩn của hệ thống nếu đơn thất bại.
             */
            $table->string('ma_loi_he_thong')->nullable();
            $table->text('thong_bao_loi_he_thong')->nullable();

            /**
             * timestamps giúp biết đơn tạo/cập nhật lúc nào.
             */
            $table->timestamps();

            /**
             * Index để tìm đơn API Partner nhanh khi đối soát hoặc kiểm tra trùng.
             */
            $table->index(['dai_ly_api_id', 'ma_don_doi_tac'], 'idx_don_hang_partner_ma_don');
            $table->index(['trang_thai_don_hang', 'trang_thai_doi_soat'], 'idx_don_hang_trang_thai');
        });
    }

    /**
     * Rollback bảng đơn hàng.
     */
    public function down(): void
    {
        Schema::dropIfExists('don_hang');
    }
};