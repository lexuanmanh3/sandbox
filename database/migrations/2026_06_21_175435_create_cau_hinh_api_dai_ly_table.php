<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Bảng cau_hinh_api_dai_ly dùng để lưu cấu hình API của partner.
     * Bao gồm client_id, secret, IP whitelist, scope và hạn mức.
     * Các secret/private key phải mã hóa, không lưu plain text.
     */
    public function up(): void
    {
        Schema::create('cau_hinh_api_dai_ly', function (Blueprint $table) {
            /**
             * id là khóa chính của cấu hình API.
             */
            $table->id();

            /**
             * dai_ly_api_id liên kết cấu hình này với một API Partner.
             * Nếu xóa partner thì cấu hình API cũng bị xóa theo.
             */
            $table->foreignId('dai_ly_api_id')
                ->constrained('dai_ly_api')
                ->cascadeOnDelete();

            /**
             * client_id là mã định danh public cho partner khi gọi API.
             * Field này unique để không có 2 partner dùng chung client_id.
             */
            $table->string('client_id')->unique();

            /**
             * secret_key_ma_hoa là secret dùng để ký request hoặc lấy token.
             * Field này phải được mã hóa trong Model bằng encrypted cast.
             */
            $table->text('secret_key_ma_hoa');

            /**
             * partner_public_key_file dùng khi partner gửi chữ ký RSA.
             * Hệ thống dùng public key này để verify chữ ký.
             */
            $table->string('partner_public_key_file')->nullable();

            /**
             * private_key_file_ma_hoa dùng nếu hệ thống cần ký response/callback.
             * Private key phải mã hóa hoặc lưu an toàn, không đưa vào code.
             */
            $table->text('private_key_file_ma_hoa')->nullable();

            /**
             * allowed_grant_types dùng cho kiểu cấp token.
             * Ví dụ: client_credentials, refresh_token.
             */
            $table->string('allowed_grant_types')->default('client_credentials');

            /**
             * allowed_scopes là danh sách quyền API partner được dùng.
             * Ví dụ: order:create, order:query.
             */
            $table->string('allowed_scopes')->nullable();

            /**
             * allow_offline_access cho phép refresh token hay không.
             * Hiện tại để false cho an toàn.
             */
            $table->boolean('allow_offline_access')->default(false);

            /**
             * require_consent dùng nếu cần màn hình xác nhận quyền.
             * Với hệ thống server-to-server thường để false.
             */
            $table->boolean('require_consent')->default(false);

            /**
             * su_dung_chu_ky_dien_tu bật/tắt kiểm tra signature.
             * Sau này khi làm API thật nên bật để chống giả mạo request.
             */
            $table->boolean('su_dung_chu_ky_dien_tu')->default(true);

            /**
             * danh_sach_ip_ket_noi là whitelist IP.
             * Chỉ các IP này mới được gọi API.
             * Có thể lưu nhiều IP, mỗi IP một dòng hoặc JSON tùy cách bạn làm sau này.
             */
            $table->text('danh_sach_ip_ket_noi')->nullable();

            /**
             * so_luong_kenh_toi_da giới hạn số kênh/request song song của partner.
             */
            $table->integer('so_luong_kenh_toi_da')->default(1);

            /**
             * han_muc_mua_the giới hạn tiền mua thẻ.
             * Dùng decimal(18,2) cho dữ liệu tiền.
             */
            $table->decimal('han_muc_mua_the', 18, 2)->default(0);

            /**
             * ap_dung_nap_cham cho phép partner gửi đơn trước, cuối kỳ thanh toán sau.
             * Đây là nghiệp vụ trả sau của API Partner.
             */
            $table->boolean('ap_dung_nap_cham')->default(false);

            /**
             * check_phone_khi_nap_cham dùng để kiểm tra thuê bao trước khi xử lý đơn nạp chậm.
             */
            $table->boolean('check_phone_khi_nap_cham')->default(false);

            /**
             * timestamps giúp biết cấu hình API được tạo/cập nhật khi nào.
             */
            $table->timestamps();
        });
    }

    /**
     * Rollback bảng cau_hinh_api_dai_ly.
     */
    public function down(): void
    {
        Schema::dropIfExists('cau_hinh_api_dai_ly');
    }
};