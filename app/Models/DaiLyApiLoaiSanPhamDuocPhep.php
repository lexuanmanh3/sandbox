<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DaiLyApiLoaiSanPhamDuocPhep extends Model
{
    use HasFactory;

    protected $table = 'dai_ly_api_loai_san_pham_duoc_phep';

    protected $fillable = [
        'dai_ly_api_id',
        'loai_san_pham_id',
    ];

    /**
     * Dòng cấp quyền này thuộc về một API Partner.
     */
    public function daiLyApi()
    {
        return $this->belongsTo(DaiLyApi::class, 'dai_ly_api_id');
    }

    /**
     * Dòng cấp quyền này thuộc về một loại sản phẩm.
     */
    public function loaiSanPham()
    {
        return $this->belongsTo(LoaiSanPham::class, 'loai_san_pham_id');
    }
}