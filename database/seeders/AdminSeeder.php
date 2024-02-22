<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    public function run()
    {
        DB::table('admins')->delete();

        DB::table('admins')->truncate();

        DB::table('admins')->insert([
            [
                'email'         => 'admin@master.com',
                'password'      => bcrypt('123456'),
                'first_name'    => '',
                'last_name'     => 'Admin',
                'full_name'     => 'Admin',
                'so_dien_thoai' => '0798752616',
                'trang_thai'    => '1',
                'avatar'        => 'avtadmin.png',
                'id_quyen'      => '1',
            ],

        ]);
    }
}
