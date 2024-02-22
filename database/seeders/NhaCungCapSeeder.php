<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NhaCungCapSeeder extends Seeder
{
    public function run()
    {
        DB::table('nha_cung_caps')->delete();

        DB::table('nha_cung_caps')->truncate();

        DB::table('nha_cung_caps')->insert([
            [
                'ten_nguoi_dai_dien' => 'Nguyễn Thị Lan Anh',
                'so_dien_thoai' => '0546384152',
                'ma_so_thue' => '2718281828',
                'ten_doanh_nghiep' => 'Yi He Tang',
                'email' => 'yihetangvietnamofficial@gmail.com',
                'trang_thai' => '1',
                'dia_chi' => '529 Nguyễn Trãi, Phường 7, Quận 5, Hồ Chí Minh',
                'list_id_nguyen_lieu' => '1|2|'
            ],
            [
                'ten_nguoi_dai_dien' => 'Đặng Văn Tuấn',
                'so_dien_thoai' => '0395147839',
                'ma_so_thue' => '3141592653',
                'ten_doanh_nghiep' => 'BaYa',
                'email' => 'payadnvn@gmail.comm',
                'trang_thai' => '1',
                'dia_chi' => '135 Điện Biên Phủ, phường Chính Gián, quận Thanh Khê,  Đà Nẵng',
                'list_id_nguyen_lieu' => '1|2|'
            ],
            [
                'ten_nguoi_dai_dien' => 'Hoàng Thị Thùy Linh',
                'so_dien_thoai' => '0867913564',
                'ma_so_thue' => '6574839201',
                'ten_doanh_nghiep' => 'Pet Zone',
                'email' => 'zonepetvn@gmail.com',
                'trang_thai' => '1',
                'dia_chi' => '45/6 Nguyễn Văn Linh, Phường Tân Thuận Tây, Quận 7, Hồ Chí Minh',
                'list_id_nguyen_lieu' => '1|2|'
            ],
            [
                'ten_nguoi_dai_dien' => 'Vũ Thị Hồng Nhung',
                'so_dien_thoai' => '0934815927',
                'ma_so_thue' => '1029384756',
                'ten_doanh_nghiep' => 'Pet House',
                'email' => 'pethouse@gmail.com',
                'trang_thai' => '1',
                'dia_chi' => '  23/4B Lê Duẩn, Phường Thanh Bình,  Đà Nẵng',
                'list_id_nguyen_lieu' => '1|'
            ],
            [
                'ten_nguoi_dai_dien' => '  Đỗ Thị Ngọc Mai',
                'so_dien_thoai' => '0521592684',
                'ma_so_thue' => '1357913579',
                'ten_doanh_nghiep' => 'Upet',
                'email' => 'upetaccso@gmail.com',
                'trang_thai' => '1',
                'dia_chi' => 'Số 12, Ngõ 34, Đường Láng, Phường Thịnh Quang, Quận Đống Đa, Hà Nội',
                'list_id_nguyen_lieu' => '1|'
            ],
        ]);
    }
}
