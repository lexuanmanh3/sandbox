<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuyenSeeder extends Seeder
{
    public function run(): void
    {
        $quyens = [
            [
                'ma_quyen' => 'dashboard.view',
                'ten_quyen' => 'Xem dashboard',
                'nhom_quyen' => 'dashboard',
                'thu_tu' => 1,
            ],

            [
                'ma_quyen' => 'user.view',
                'ten_quyen' => 'Xem người dùng',
                'nhom_quyen' => 'nguoi_dung',
                'thu_tu' => 10,
            ],
            [
                'ma_quyen' => 'user.create',
                'ten_quyen' => 'Thêm người dùng',
                'nhom_quyen' => 'nguoi_dung',
                'thu_tu' => 11,
            ],
            [
                'ma_quyen' => 'user.update',
                'ten_quyen' => 'Sửa người dùng',
                'nhom_quyen' => 'nguoi_dung',
                'thu_tu' => 12,
            ],
            [
                'ma_quyen' => 'user.delete',
                'ten_quyen' => 'Xóa người dùng',
                'nhom_quyen' => 'nguoi_dung',
                'thu_tu' => 13,
            ],

            [
                'ma_quyen' => 'role.view',
                'ten_quyen' => 'Xem vai trò',
                'nhom_quyen' => 'vai_tro',
                'thu_tu' => 20,
            ],
            [
                'ma_quyen' => 'role.create',
                'ten_quyen' => 'Thêm vai trò',
                'nhom_quyen' => 'vai_tro',
                'thu_tu' => 21,
            ],
            [
                'ma_quyen' => 'role.update',
                'ten_quyen' => 'Sửa vai trò',
                'nhom_quyen' => 'vai_tro',
                'thu_tu' => 22,
            ],
            [
                'ma_quyen' => 'role.delete',
                'ten_quyen' => 'Xóa vai trò',
                'nhom_quyen' => 'vai_tro',
                'thu_tu' => 23,
            ],

            [
                'ma_quyen' => 'permission.view',
                'ten_quyen' => 'Xem quyền',
                'nhom_quyen' => 'phan_quyen',
                'thu_tu' => 30,
            ],
            [
                'ma_quyen' => 'permission.assign',
                'ten_quyen' => 'Gán quyền',
                'nhom_quyen' => 'phan_quyen',
                'thu_tu' => 31,
            ],
        ];

        foreach ($quyens as $quyen) {
            DB::table('quyen')->updateOrInsert(
                ['ma_quyen' => $quyen['ma_quyen']],
                array_merge($quyen, [
                    'quyen_cha_id' => null,
                    'trang_thai' => 'hoat_dong',
                ])
            );
        }

        $adminRole = DB::table('vai_tro')
            ->where('ma_vai_tro', 'admin')
            ->first();

        if (!$adminRole) {
            return;
        }

        $tatCaQuyen = DB::table('quyen')->get();

        foreach ($tatCaQuyen as $quyen) {
            DB::table('vai_tro_quyen')->updateOrInsert(
                [
                    'vai_tro_id' => $adminRole->id,
                    'quyen_id' => $quyen->id,
                ],
                [
                    'tao_luc' => now(),
                ]
            );
        }
    }
}