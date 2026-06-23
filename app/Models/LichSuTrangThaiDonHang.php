<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LichSuTrangThaiDonHang extends Model
{
    use HasFactory;

    protected $table = 'lich_su_trang_thai_don_hang';

    protected $fillable = [
        'don_hang_id',
        'trang_thai_cu',
        'trang_thai_moi',
        'ly_do',
        'du_lieu_json',
        'thay_doi_boi',
        'nguon_thay_doi',
    ];

    /**
     * Cast JSON để Laravel tự chuyển array ↔ JSON.
     */
    protected $casts = [
        'du_lieu_json' => 'array',
    ];

    /**
     * Lịch sử này thuộc về một đơn hàng.
     */
    public function donHang()
    {
        return $this->belongsTo(DonHang::class, 'don_hang_id');
    }
}