<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\NguyenLieu;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(DanhMucSeeder::class);
        $this->call(SanPhamSeeder::class);
        $this->call(BlogSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(PhanQuyenSeeder::class);
        $this->call(NhaCungCapSeeder::class);
        $this->call(DonViSeeder::class);
        $this->call(NguyenLieuSeeder::class);
        $this->call(ChucNangSeeder::class);
        $this->call(QuyenChucNangSeeder::class);
        $this->call(KhachhangSeeder::class);

    }
}
