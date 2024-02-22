<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DonViSeeder extends Seeder
{
    public function run()
    {
        DB::table('don_vis')->delete();
        DB::table('don_vis')->truncate();
        DB::table('don_vis')->insert([
            [
                'ten_don_vi' => 'Thùng',
                'slug_don_vi' => Str::slug('Thùng'),
            ],
            [
                'ten_don_vi' => 'gam',
                'slug_don_vi' => Str::slug('gam'),
            ],
            [
                'ten_don_vi' => 'Hũ',
                'slug_don_vi' => Str::slug('Hũ'),
            ],
        ]);
    }
}
