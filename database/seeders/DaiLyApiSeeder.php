<?php

namespace Database\Seeders;

use App\Models\CauHinhApiDaiLy;
use App\Models\DaiLyApi;
use App\Models\DaiLyApiDichVuDuocPhep;
use App\Models\DaiLyApiLoaiSanPhamDuocPhep;
use App\Models\DaiLyApiSanPhamDuocPhep;
use App\Models\DichVu;
use App\Models\LoaiSanPham;
use App\Models\SanPham;
use Illuminate\Database\Seeder;

class DaiLyApiSeeder extends Seeder
{
    /**
     * Seeder này tạo dữ liệu test cho Đại lý API.
     * Mục đích là sau này reset database vẫn có sẵn partner để test API, quyền dịch vụ,
     * quyền loại sản phẩm và quyền sản phẩm.
     */
    public function run(): void
    {
        /**
         * Tạo hoặc lấy Đại lý API test.
         * firstOrCreate giúp chạy Seeder nhiều lần không bị lỗi trùng ma_dai_ly_api.
         */
        $daiLyApi = DaiLyApi::firstOrCreate(
            ['ma_dai_ly_api' => 'PARTNER_TEST'],
            [
                'ten_dai_ly_api' => 'Đại lý API Test',
                'so_dien_thoai' => '0900000001',
                'ho' => 'API',
                'ten' => 'Partner',
                'email_ky_thuat' => 'tech@partner.test',
                'email_doi_soat' => 'reconcile@partner.test',
                'ky_doi_soat' => 30,
                'trang_thai' => 'hoat_dong',
            ]
        );

        /**
         * Tạo cấu hình API cho Đại lý API.
         * secret_key_ma_hoa sẽ được mã hóa nếu model CauHinhApiDaiLy đã dùng encrypted cast.
         */
        CauHinhApiDaiLy::firstOrCreate(
            ['dai_ly_api_id' => $daiLyApi->id],
            [
                'client_id' => 'partner_test_client',
                'secret_key_ma_hoa' => 'partner_test_secret',
                'allowed_grant_types' => 'client_credentials',
                'allowed_scopes' => 'order:create,order:query',
                'su_dung_chu_ky_dien_tu' => true,
                'danh_sach_ip_ket_noi' => '127.0.0.1',
                'so_luong_kenh_toi_da' => 5,
                'han_muc_mua_the' => 10000000,
                'ap_dung_nap_cham' => true,
                'check_phone_khi_nap_cham' => false,
            ]
        );

        /**
         * Lấy dữ liệu danh mục đầu tiên để cấp quyền test.
         * Nếu chưa có dịch vụ / loại sản phẩm / sản phẩm thì dừng lại.
         */
        $dichVu = DichVu::first();
        $loaiSanPham = LoaiSanPham::first();
        $sanPham = SanPham::first();

        /**
         * Nếu thiếu dữ liệu danh mục thì không cấp quyền.
         * Khi Seeder không ra quyền, kiểm tra lại bảng dich_vu, loai_san_pham, san_pham.
         */
        if (!$dichVu || !$loaiSanPham || !$sanPham) {
            return;
        }

        /**
         * Cấp quyền tầng 1: Đại lý API được phép dùng dịch vụ.
         */
        DaiLyApiDichVuDuocPhep::firstOrCreate([
            'dai_ly_api_id' => $daiLyApi->id,
            'dich_vu_id' => $dichVu->id,
        ]);

        /**
         * Cấp quyền tầng 2: Đại lý API được phép dùng loại sản phẩm.
         */
        DaiLyApiLoaiSanPhamDuocPhep::firstOrCreate([
            'dai_ly_api_id' => $daiLyApi->id,
            'loai_san_pham_id' => $loaiSanPham->id,
        ]);

        /**
         * Cấp quyền tầng 3: Đại lý API được phép dùng sản phẩm cụ thể.
         */
        DaiLyApiSanPhamDuocPhep::firstOrCreate([
            'dai_ly_api_id' => $daiLyApi->id,
            'san_pham_id' => $sanPham->id,
        ]);
    }
}