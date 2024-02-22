<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DanhMucSeeder extends Seeder
{
    public function run()
    {
        DB::table('danh_mucs')->delete();
        DB::table('danh_mucs')->truncate();
        DB::table('danh_mucs')->insert([
            [
                'ten_danh_muc' => 'Đồ uống',
                'slug_danh_muc' => 'do-uong',
                'id_danh_muc_cha' => '0',
                'trang_thai' => '1',
            ],
            [
                'ten_danh_muc' => 'Phụ kiện thú cưng',
                'slug_danh_muc' => 'phu-kien-thu-cung',
                'id_danh_muc_cha' => '0',
                'trang_thai' => '1',
            ],
            [
                'ten_danh_muc' => 'Thức ăn thú cưng',
                'slug_danh_muc' => 'thuc-an-thu-cưng',
                'id_danh_muc_cha' => '0',
                'trang_thai' => '1',
            ],
            [
                'ten_danh_muc' => 'Đồ chơi thú cưng',
                'slug_danh_muc' => 'do-choi-thu-cung',
                'id_danh_muc_cha' => '0',
                'trang_thai' => '1',
            ],
        ]);
    }
}
