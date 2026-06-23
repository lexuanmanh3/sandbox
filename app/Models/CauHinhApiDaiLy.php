<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CauHinhApiDaiLy extends Model
{
    use HasFactory;

    /**
     * Model này đại diện cho bảng cau_hinh_api_dai_ly.
     * Dùng để lưu client_id, secret, whitelist IP và giới hạn API của partner.
     */
    protected $table = 'cau_hinh_api_dai_ly';

    /**
     * Các field được phép lưu qua Eloquent.
     */
    protected $fillable = [
        'dai_ly_api_id',
        'client_id',
        'secret_key_ma_hoa',
        'partner_public_key_file',
        'private_key_file_ma_hoa',
        'allowed_grant_types',
        'allowed_scopes',
        'allow_offline_access',
        'require_consent',
        'su_dung_chu_ky_dien_tu',
        'danh_sach_ip_ket_noi',
        'so_luong_kenh_toi_da',
        'han_muc_mua_the',
        'ap_dung_nap_cham',
        'check_phone_khi_nap_cham',
    ];

    /**
     * Cast giúp Laravel tự mã hóa field nhạy cảm và tự chuyển boolean/decimal đúng kiểu.
     * Khi bảo trì, các field secret/private key nên thêm vào encrypted cast tại đây.
     */
    protected $casts = [
        'secret_key_ma_hoa' => 'encrypted',
        'private_key_file_ma_hoa' => 'encrypted',
        'allow_offline_access' => 'boolean',
        'require_consent' => 'boolean',
        'su_dung_chu_ky_dien_tu' => 'boolean',
        'ap_dung_nap_cham' => 'boolean',
        'check_phone_khi_nap_cham' => 'boolean',
        'han_muc_mua_the' => 'decimal:2',
    ];

    /**
     * Mỗi cấu hình API thuộc về một API Partner.
     */
    public function daiLyApi()
    {
        return $this->belongsTo(DaiLyApi::class, 'dai_ly_api_id');
    }
}