<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VaiTroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
       public function run(): void
    {
        $vaiTro = [
            [
                'ma_vai_tro' => 'admin',
                'ten_vai_tro' => 'Quản trị viên',
                'mac_dinh' => true,
                'trang_thai' => 'hoat_dong',
            ],
            [
                'ma_vai_tro' => 'backend',
                'ten_vai_tro' => 'Nhân viên BackEnd',
                'mac_dinh' => false,
                'trang_thai' => 'hoat_dong',
            ],
            [
                'ma_vai_tro' => 'ke_toan',
                'ten_vai_tro' => 'Kế toán',
                'mac_dinh' => false,
                'trang_thai' => 'hoat_dong',
            ],
            [
                'ma_vai_tro' => 'doi_soat',
                'ten_vai_tro' => 'Đối soát',
                'mac_dinh' => false,
                'trang_thai' => 'hoat_dong',
            ],
            [
                'ma_vai_tro' => 'agent',
                'ten_vai_tro' => 'Đại lý',
                'mac_dinh' => false,
                'trang_thai' => 'hoat_dong',
            ],
            [
                'ma_vai_tro' => 'agent_api',
                'ten_vai_tro' => 'Đại lý API',
                'mac_dinh' => false,
                'trang_thai' => 'hoat_dong',
            ],
        ];

        foreach ($vaiTro as $vaiTro) {
            DB::table('vai_tro')->updateOrInsert(
                ['ma_vai_tro' => $vaiTro['ma_vai_tro']],
                array_merge($vaiTro, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }
    }
}
