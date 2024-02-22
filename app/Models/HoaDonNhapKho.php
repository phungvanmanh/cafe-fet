<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HoaDonNhapKho extends Model
{
    use HasFactory;

    protected $table = 'hoa_don_nhap_khos';
    protected $fillable = [
        'ma_hoa_don',
        'ngay_tao_hoa_don',
        'ghi_chu',
        'tong_tien',
        'id_admin_nhap',
        'id_nha_cung_cap',
        'trang_thai'
    ];
}
