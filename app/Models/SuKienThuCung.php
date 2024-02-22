<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuKienThuCung extends Model
{
    use HasFactory;

    protected $tabkle = "su_kien_thu_cungs";
    protected $fillable = [
        'ten_su_kien',
        'slug_su_kien',
        'mo_ta',
        'tinh_trang',
        'so_nguoi_tham_gia',
        'list_id_client',
        'dia_chi',
        'thoi_gian_bat_dau',//yyyy-mm-dd
        'thoi_gian_ket_thuc',
        'is_duyet',
        'is_ket_thuc'
    ];
}
