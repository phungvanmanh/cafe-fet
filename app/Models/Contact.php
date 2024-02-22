<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $table = 'contacts';
    protected $fillable = [
        'noi_dung',
        'trang_thai',
        'email',
        'name',
        'so_dien_thoai',
    ];
}