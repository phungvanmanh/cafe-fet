<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonHang extends Model
{
    use HasFactory;
    protected $table = 'don_hangs';

    protected $fillable = [
        'id_khach_hang',
        'ma_don_hang',
        'is_thanh_toan',
        'tong_tien',
        'dia_chi',
        'ten_nguoi_nhan',
        'email',
        'so_dien_thoai',
        'loai_thanh_toan'
    ];
}
