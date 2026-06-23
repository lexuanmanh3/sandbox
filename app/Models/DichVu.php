<?php

namespace App\Models;

// NOTE: HasFactory dùng để hỗ trợ tạo dữ liệu test/factory sau này.
// Model giúp class DichVu đại diện cho bảng dich_vu trong database.
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// NOTE: HasMany dùng cho quan hệ 1-nhiều.
// Ví dụ 1 dịch vụ có nhiều loại sản phẩm và nhiều sản phẩm.
use Illuminate\Database\Eloquent\Relations\HasMany;

class DichVu extends Model
{
    use HasFactory;

    // NOTE: Khai báo tên bảng thật trong database.
    // Nếu không khai báo, Laravel có thể đoán thành dich_vus và bị sai.
    protected $table = 'dich_vu';

    // NOTE: Các cột được phép thêm/sửa bằng create() hoặc update().
    // Sau này làm màn quản lý dịch vụ thì Laravel chỉ cho ghi các field này.
    protected $fillable = [
        'ma_dich_vu',
        'ten_dich_vu',
        'trang_thai',
        'thu_tu',
        'mo_ta',
    ];

    // NOTE: Lấy danh sách loại sản phẩm thuộc dịch vụ này.
    // Ví dụ dịch vụ PIN_CODE có các loại sản phẩm Viettel, Mobifone, Vinaphone.
    public function loaiSanPham(): HasMany
    {
        return $this->hasMany(
            LoaiSanPham::class,
            'dich_vu_id'
        );
    }

    // NOTE: Lấy danh sách sản phẩm thuộc dịch vụ này.
    // Ví dụ dịch vụ PIN_CODE có sản phẩm Viettel 10k, Viettel 20k.
    public function sanPham(): HasMany
    {
        return $this->hasMany(
            SanPham::class,
            'dich_vu_id'
        );
    }
        /**
     * Một dịch vụ có thể có nhiều cấu hình chạy qua NCC.
     * Ví dụ dịch vụ PIN_CODE có thể chạy qua AppotaPay hoặc NCC khác.
     */
    public function cauHinhDichVu()
    {
        return $this->hasMany(CauHinhDichVu::class, 'dich_vu_id');
    }
    /**
 * Một dịch vụ có thể được cấp cho nhiều API Partner.
 * Ví dụ dịch vụ PIN_CODE có thể được cấp cho nhiều đối tác API.
 */
public function daiLyApiDuocPhep()
{
    return $this->hasMany(DaiLyApiDichVuDuocPhep::class, 'dich_vu_id');
}

/**
 * Quan hệ many-to-many giúp lấy danh sách API Partner được phép dùng dịch vụ này.
 */
public function daiLyApi()
{
    return $this->belongsToMany(
        DaiLyApi::class,
        'dai_ly_api_dich_vu_duoc_phep',
        'dich_vu_id',
        'dai_ly_api_id'
    )->withTimestamps();
}
}