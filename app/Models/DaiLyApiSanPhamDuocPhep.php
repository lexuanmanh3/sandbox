<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DaiLyApiSanPhamDuocPhep extends Model
{
    use HasFactory;

    /**
     * Model này đại diện cho bảng dai_ly_api_san_pham_duoc_phep.
     */
    protected $table = 'dai_ly_api_san_pham_duoc_phep';

    /**
     * Các field được phép lưu bằng Eloquent.
     */
    protected $fillable = [
        'dai_ly_api_id',
        'san_pham_id',
    ];

    /**
     * Một dòng cấp quyền sản phẩm thuộc về một API Partner.
     */
    public function daiLyApi()
    {
        return $this->belongsTo(DaiLyApi::class, 'dai_ly_api_id');
    }

    /**
     * Một dòng cấp quyền thuộc về một sản phẩm cụ thể.
     */
    public function sanPham()
    {
        return $this->belongsTo(SanPham::class, 'san_pham_id');
    }
}