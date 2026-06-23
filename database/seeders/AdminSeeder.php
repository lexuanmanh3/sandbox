<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // NOTE: Tạo hoặc cập nhật tài khoản admin đầu tiên.
        // Dùng updateOrInsert để chạy seeder nhiều lần không bị trùng tài khoản.
        // Điều kiện tìm là ten_dang_nhap = admin.
        DB::table('users')->updateOrInsert(
            ['ten_dang_nhap' => 'admin'],

            // NOTE: Đây là dữ liệu sẽ được thêm mới hoặc cập nhật vào bảng users.
            // Các field bên dưới viết đúng theo cột đang có trong database của bạn.
            [
                'ten_dang_nhap' => 'admin',
                'email' => 'admin@example.com',
                'so_dien_thoai' => '0965657810',

                // NOTE: password là cột đăng nhập chuẩn của Laravel.
                // Hash::make giúp mã hóa mật khẩu trước khi lưu vào database.
                'password' => Hash::make('12345678'),

                // NOTE: ho, ten dùng để tách họ và tên riêng.
                // name dùng cho Laravel mặc định hoặc hiển thị nhanh full name.
                'ho' => 'System',
                'ten' => 'Admin',
                'name' => 'System Admin',

                // NOTE: loai_tai_khoan dùng để phân loại tài khoản.
                // Sau này có thể có admin, backend, ke_toan, agent, agent_api, customer.
                'loai_tai_khoan' => 'admin',

                // NOTE: email_verified_at là cột mặc định Laravel dùng để biết email đã xác minh chưa.
                // Gán now() nghĩa là tài khoản admin coi như đã xác minh email.
                'email_verified_at' => now(),

                // NOTE: Các cột boolean này dùng để kiểm soát trạng thái xác thực và bảo mật tài khoản.
                'email_da_xac_nhan' => true,
                'tai_khoan_da_xac_thuc' => true,
                'bat_buoc_doi_mat_khau' => false,
                'tu_dong_khoa_tai_khoan' => false,
                'bi_khoa' => false,

                // NOTE: trang_thai dùng để bật/tắt tài khoản.
                // hoat_dong nghĩa là tài khoản được phép sử dụng.
                'trang_thai' => 'hoat_dong',

                // NOTE: lan_dang_nhap_cuoi để lưu thời điểm đăng nhập gần nhất.
                // Lúc mới seed thì chưa đăng nhập nên để null.
                'lan_dang_nhap_cuoi' => null,

                // NOTE: remember_token là token "remember me" của Laravel.
                // Khi tạo admin ban đầu chưa cần token nên để null.
                'remember_token' => null,

                // NOTE: created_at và updated_at là timestamps mặc định của Laravel.
                // Dùng để biết dòng dữ liệu được tạo/cập nhật khi nào.
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        $adminUser = DB::table('users')
            ->where('ten_dang_nhap', 'admin')
            ->first();

        $adminRole = DB::table('vai_tro')
            ->where('ma_vai_tro', 'admin')
            ->first();

        if (!$adminUser || !$adminRole) {
            return;
        }

        DB::table('nguoi_dung_vai_tro')->updateOrInsert(
            [
                'nguoi_dung_id' => $adminUser->id,
                'vai_tro_id' => $adminRole->id,
            ],
            [
                'tao_luc' => now(),
            ]
        );
    }
}