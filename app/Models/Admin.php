<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory;
    protected $table = "admins";

    protected $fillable = [
        'email',
        'password',
        'first_name',
        'last_name',
        'full_name',
        'so_dien_thoai',
        'trang_thai',
        'avatar',
        'id_quyen',
    ];
}
