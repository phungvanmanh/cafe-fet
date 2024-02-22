<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    protected $table = 'blogs';

    protected $fillable = [
        'tieu_de',
        'slug',
        'mo_ta_ngan',
        'mo_ta_chi_tiet',
        'hinh_anh',
        'tinh_trang',
    ];
}
