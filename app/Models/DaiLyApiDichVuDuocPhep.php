<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DaiLyApiDichVuDuocPhep extends Model
{
    use HasFactory;

    /**
     * Model này đại diện cho bảng dai_ly_api_dich_vu_duoc_phep.
     * Bảng này lưu partner nào được phép dùng dịch vụ nào.
     */
    protected $table = 'dai_ly_api_dich_vu_duoc_phep';

    /**
     * Các field được phép create/update.
     */
    protected $fillable = [
        'dai_ly_api_id',
        'dich_vu_id',
    ];

    /**
     * Dòng cấp quyền này thuộc về một API Partner.
     */
    public function daiLyApi()
    {
        return $this->belongsTo(DaiLyApi::class, 'dai_ly_api_id');
    }

    /**
     * Dòng cấp quyền này thuộc về một dịch vụ.
     */
    public function dichVu()
    {
        return $this->belongsTo(DichVu::class, 'dich_vu_id');
    }
}