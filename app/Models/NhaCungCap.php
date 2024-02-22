<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NhaCungCap extends Model
{
    use HasFactory;

    protected $table = 'nha_cung_caps';

    protected $fillable = [
        'ma_so_thue',
        'ten_doanh_nghiep',
        'ten_nguoi_dai_dien',
        'so_dien_thoai',
        'email',
        'dia_chi',
        'trang_thai',
        'list_id_nguyen_lieu'
    ];
}
