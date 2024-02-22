<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChiTietNhapKho extends Model
{
    use HasFactory;

    protected $table = 'chi_tiet_nhap_khos';
    protected $fillable = [
        'id_nguyen_lieu',
        'so_luong',
        'don_gia',
        'thanh_tien',
        'ghi_chu',
        'id_nha_cung_cap',
        'id_hoa_don',
    ];
}
