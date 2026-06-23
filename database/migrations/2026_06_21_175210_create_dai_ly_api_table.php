<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Bảng dai_ly_api dùng để lưu thông tin API Partner.
     * API Partner là bên thứ ba gửi đơn hàng qua API vào hệ thống của mình.
     * Ví dụ: đối tác A gửi đơn nạp điện thoại, cuối kỳ mình đối soát và thu tiền.
     */
    public function up(): void
    {
        Schema::create('dai_ly_api', function (Blueprint $table) {
            /**
             * id là khóa chính của API Partner.
             */
            $table->id();

            /**
             * nguoi_dung_id liên kết API Partner với một tài khoản đăng nhập trong hệ thống.
             * Nếu bảng user của bạn đang là users thì mình dùng constrained('users').
             * Nếu project bạn dùng bảng nguoi_dung thì đổi lại thành constrained('nguoi_dung').
             */
            $table->foreignId('nguoi_dung_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            /**
             * ma_dai_ly_api là mã duy nhất của partner.
             * Mã này dùng để tìm partner nhanh trong hệ thống.
             * Ví dụ: API001, NT966215, PARTNER_TEST.
             */
            $table->string('ma_dai_ly_api')->unique();

            /**
             * ten_dai_ly_api là tên hiển thị của partner trên admin.
             */
            $table->string('ten_dai_ly_api');

            /**
             * Thông tin liên hệ cơ bản của partner.
             * Các field ho/ten dùng khi partner gắn với người đại diện cụ thể.
             */
            $table->string('so_dien_thoai')->nullable();
            $table->string('ho')->nullable();
            $table->string('ten')->nullable();

            /**
             * Thông tin hợp đồng.
             * Sau này dùng khi đối soát, xuất hóa đơn, kiểm tra pháp lý.
             */
            $table->date('ngay_ky_hop_dong')->nullable();
            $table->string('so_hop_dong')->nullable();

            /**
             * email_ky_thuat dùng để gửi thông báo lỗi API/webhook.
             * email_doi_soat dùng để gửi bảng kê công nợ cuối kỳ.
             */
            $table->string('email_ky_thuat')->nullable();
            $table->string('email_doi_soat')->nullable();

            /**
             * ky_doi_soat là số ngày hoặc chu kỳ đối soát.
             * Ví dụ: 7 là đối soát mỗi 7 ngày, 30 là mỗi tháng.
             */
            $table->integer('ky_doi_soat')->default(30);

            /**
             * folder_ftp dùng nếu sau này gửi file đối soát qua FTP/SFTP.
             * Hiện tại có thể để null.
             */
            $table->string('folder_ftp')->nullable();

            /**
             * telegram_group_id dùng để gửi cảnh báo giao dịch/lỗi cho partner.
             */
            $table->string('telegram_group_id')->nullable();

            /**
             * trang_thai dùng để bật/tắt partner.
             * Ví dụ: hoat_dong, tam_dung, khoa.
             */
            $table->string('trang_thai')->default('hoat_dong');

            /**
             * timestamps giúp biết partner được tạo/cập nhật khi nào.
             */
            $table->timestamps();
        });
    }

    /**
     * Rollback bảng dai_ly_api.
     */
    public function down(): void
    {
        Schema::dropIfExists('dai_ly_api');
    }
};