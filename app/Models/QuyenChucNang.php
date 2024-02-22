<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuyenChucNang extends Model
{
    use HasFactory;

    protected $table = 'quyen_chuc_nangs';

    protected $fillable = [
        'id_quyen',
        'id_chuc_nang',
    ];
}
