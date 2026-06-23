<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Quyen;

class VaiTro extends Model
{
    use HasFactory;

    protected $table = 'vai_tro';

    protected $fillable = [
        'ma_vai_tro',
        'ten_vai_tro',
        'mo_ta',
        'mac_dinh',
        'trang_thai',
    ];

    protected $casts = [
        'mac_dinh' => 'boolean',
    ];

    // Các người dùng đang có vai trò này
public function nguoiDung()
{
    return $this->belongsToMany(
        User::class,
        'nguoi_dung_vai_tro',
        'vai_tro_id',
        'nguoi_dung_id'
    );
}

// Các quyền thuộc vai trò này
public function quyen()
{
    return $this->belongsToMany(
        Quyen::class,
        'vai_tro_quyen',
        'vai_tro_id',
        'quyen_id'
    );
}
}
