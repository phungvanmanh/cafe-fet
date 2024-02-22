<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class KhachHang extends Authenticatable
{
    use HasFactory;

    protected $table = 'khach_hangs';

    protected $fillable = [
        'first_name',//
        'last_name',
        'full_name',
        'so_dien_thoai',//
        'email',//
        'password',//
        'dia_chi',//
        'tong_diem',//
        'diem_da_tru',//
        'diem_chua_su_dung',//
        'trang_thai',//
        'avatar',
        'hash_reset',
        'hash_active'
    ];
}
