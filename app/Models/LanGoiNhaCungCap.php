<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LanGoiNhaCungCap extends Model
{
    use HasFactory;

    protected $table = 'lan_goi_nha_cung_cap';

    protected $fillable = [
        'don_hang_id',
        'nha_cung_cap_id',
        'cau_hinh_dich_vu_id',
        'lan_thu',
        'ma_giao_dich_ncc',
        'request_json',
        'response_json',
        'ma_loi_ncc',
        'ma_loi_he_thong',
        'trang_thai',
        'thoi_gian_xu_ly_ms',
    ];

    /**
     * Cast JSON và số lần gọi.
     */
    protected $casts = [
        'lan_thu' => 'integer',
        'request_json' => 'array',
        'response_json' => 'array',
    ];

    /**
     * Lần gọi NCC này thuộc về một đơn hàng.
     */
    public function donHang()
    {
        return $this->belongsTo(DonHang::class, 'don_hang_id');
    }

    /**
     * Lần gọi này gửi tới một NCC.
     */
    public function nhaCungCap()
    {
        return $this->belongsTo(NhaCungCap::class, 'nha_cung_cap_id');
    }

    /**
     * Lần gọi này dùng một cấu hình dịch vụ.
     */
    public function cauHinhDichVu()
    {
        return $this->belongsTo(CauHinhDichVu::class, 'cau_hinh_dich_vu_id');
    }
}