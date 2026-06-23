<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Bảng quyen
        |--------------------------------------------------------------------------
        | Mục đích:
        | - Lưu danh sách quyền trong hệ thống.
        | - Quyền có thể chia dạng cha/con để dễ hiển thị theo cây.
        |
        | Ví dụ:
        | - nguoi_dung.view
        | - nguoi_dung.create
        | - vai_tro.update
        | - don_hang.approve
        */
        Schema::create('quyen', function (Blueprint $table) {
            // Khóa chính tự tăng
            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Quyền cha
            |--------------------------------------------------------------------------
            | Dùng để tạo cấu trúc quyền dạng cây.
            |
            | Ví dụ:
            | - "Quản lý người dùng" là quyền cha
            | - "nguoi_dung.view", "nguoi_dung.create" là quyền con
            |
            | nullable:
            | - Cho phép quyền cấp cao nhất không có cha.
            |
            | constrained('quyen'):
            | - Khóa ngoại trỏ về chính bảng quyen.
            |
            | nullOnDelete:
            | - Nếu quyền cha bị xóa, quyền con không bị xóa theo.
            | - Cột quyen_cha_id của quyền con sẽ thành null.
            */
            $table->foreignId('quyen_cha_id')
                ->nullable()
                ->constrained('quyen')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Mã quyền
            |--------------------------------------------------------------------------
            | Mã kỹ thuật dùng trong code để kiểm tra quyền.
            |
            | Ví dụ:
            | - nguoi_dung.view
            | - nguoi_dung.create
            | - vai_tro.delete
            |
            | unique:
            | - Không cho phép trùng mã quyền.
            */
            $table->string('ma_quyen')->unique();

            /*
            |--------------------------------------------------------------------------
            | Tên quyền
            |--------------------------------------------------------------------------
            | Tên hiển thị cho admin dễ đọc.
            |
            | Ví dụ:
            | - Xem người dùng
            | - Thêm người dùng
            | - Xóa vai trò
            */
            $table->string('ten_quyen');

            /*
            |--------------------------------------------------------------------------
            | Nhóm quyền
            |--------------------------------------------------------------------------
            | Dùng để gom quyền theo module/chức năng.
            |
            | Ví dụ:
            | - nguoi_dung
            | - vai_tro
            | - don_hang
            | - vi_tien
            */
            $table->string('nhom_quyen')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Thứ tự hiển thị
            |--------------------------------------------------------------------------
            | Dùng để sắp xếp quyền trên giao diện admin.
            | Số nhỏ sẽ hiển thị trước.
            */
            $table->integer('thu_tu')->default(0);

            /*
            |--------------------------------------------------------------------------
            | Trạng thái quyền
            |--------------------------------------------------------------------------
            | Dùng để bật/tắt quyền.
            |
            | Gợi ý giá trị:
            | - hoat_dong
            | - tam_dung
            */
            $table->string('trang_thai')->default('hoat_dong');

            /*
            |--------------------------------------------------------------------------
            | Thời gian tạo/cập nhật
            |--------------------------------------------------------------------------
            | Laravel tự tạo 2 cột:
            | - created_at
            | - updated_at
            */
            $table->timestamps();
        });
    }

    public function down(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Rollback bảng quyen
        |--------------------------------------------------------------------------
        | Khi chạy php artisan migrate:rollback,
        | Laravel sẽ xóa bảng quyen.
        */
        Schema::dropIfExists('quyen');
    }
};