<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogApi extends Model
{
    use HasFactory;

    protected $table = 'log_api';

    protected $fillable = [
        'huong',
        'doi_tuong',
        'doi_tuong_id',
        'don_hang_id',
        'endpoint',
        'method',
        'request_body_json',
        'response_status',
        'response_body_json',
        'dia_chi_ip',
        'thoi_gian_xu_ly_ms',
    ];

    /**
     * Cast JSON để lưu request/response dạng array.
     */
    protected $casts = [
        'request_body_json' => 'array',
        'response_body_json' => 'array',
    ];

    /**
     * Log này có thể thuộc một đơn hàng.
     */
    public function donHang()
    {
        return $this->belongsTo(DonHang::class, 'don_hang_id');
    }
}