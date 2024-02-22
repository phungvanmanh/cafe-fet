<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class NguyenLieuSeeder extends Seeder
{
    public function run()
    {
        DB::table('nguyen_lieus')->delete();
        DB::table('nguyen_lieus')->truncate();
        DB::table('nguyen_lieus')->insert([
            [
                'ten_nguyen_lieu'   => 'Hạt cà phê chồn',
                'slug_nguyen_lieu'  => Str::slug('Hạt cà phê chồn'),
                'so_luong'          => 10,
                'don_gia'           => 120000,
                'don_vi_tinh'       => 1,
                'trang_thai'        => 1,
            ],
            [
                'ten_nguyen_lieu'   => 'Cà phê sài gòn',
                'slug_nguyen_lieu'  => Str::slug('Cà phê sài gòn'),
                'so_luong'          => 10,
                'don_gia'           => 200000,
                'don_vi_tinh'       => 1,
                'trang_thai'        => 1,
            ],
        ]);
    }
}
