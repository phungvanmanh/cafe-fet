<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TmpNhapKho extends Model
{
    use HasFactory;

    protected $table = 'tmp_nhap_khos';
    protected $fillable = [
        'id_nguyen_lieu',
        'so_luong',
        'don_gia',
        'thanh_tien',
        'ghi_chu',
        'id_nha_cung_cap',
    ];
}
