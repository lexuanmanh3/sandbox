<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KetNoiNhaCungCap extends Model
{
    use HasFactory;

    /**
     * Model này đại diện cho bảng ket_noi_nha_cung_cap.
     */
    protected $table = 'ket_noi_nha_cung_cap';

    /**
     * Các field được phép lưu bằng Eloquent.
     */
    protected $fillable = [
        'nha_cung_cap_id',
        'username',
        'password_ma_hoa',
        'api_user',
        'api_password_ma_hoa',
        'api_url',
        'public_key_file',
        'private_key_file_ma_hoa',
        'timeout_he_thong',
        'timeout_ncc',
        'trang_thai',
    ];

    /**
     * Các field nhạy cảm sẽ được Laravel tự mã hóa khi lưu
     * và tự giải mã khi đọc ra.
     *
     * Lưu ý: Không echo các field này ra giao diện admin nếu không cần thiết.
     */
    protected $casts = [
        'password_ma_hoa' => 'encrypted',
        'api_password_ma_hoa' => 'encrypted',
        'private_key_file_ma_hoa' => 'encrypted',
    ];

    /**
     * Mỗi kết nối API thuộc về một NCC.
     * Dùng để lấy thông tin NCC từ cấu hình kết nối.
     */
    public function nhaCungCap()
    {
        return $this->belongsTo(NhaCungCap::class, 'nha_cung_cap_id');
    }
}