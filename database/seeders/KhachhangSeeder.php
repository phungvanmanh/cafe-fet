<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KhachhangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('khach_hangs')->delete();

        DB::table('khach_hangs')->truncate();

        DB::table('khach_hangs')->insert([
            [
                'first_name'    =>'Thach',
                'last_name' =>'Trương',
                'full_name'=>'abc',
                'so_dien_thoai' =>'1231231231',
                'email' =>'123@gmail.com',
                'password'  =>bcrypt(123123),
                'dia_chi'   =>'123123',
                'tong_diem' =>'0',
                'diem_da_tru'   =>'0',
                'diem_chua_su_dung' =>'0',
                'trang_thai'    =>'1',
            ]
        ]);
    }
}
