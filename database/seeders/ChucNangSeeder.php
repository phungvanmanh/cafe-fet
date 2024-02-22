<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChucNangSeeder extends Seeder
{
    public function run()
    {

        DB::table('chuc_nangs')->delete();

        DB::table('chuc_nangs')->truncate();

        DB::table('chuc_nangs')->insert([
            ['id' => 1, 'ten_chuc_nang' => 'Thêm mới admin'],
            ['id' => 2, 'ten_chuc_nang' => 'Danh sách admin'],
            ['id' => 3, 'ten_chuc_nang' => 'Cập nhật admin'],
            ['id' => 4, 'ten_chuc_nang' => 'Xóa admin'],
            ['id' => 5, 'ten_chuc_nang' => 'Đổi trạng thái admin'],
            ['id' => 6, 'ten_chuc_nang' => 'Xem view admin'],
            ['id' => 7, 'ten_chuc_nang' => 'Xem view khách hàng'],
            ['id' => 8, 'ten_chuc_nang' => 'Lấy dữ liệu khách hàng'],
            ['id' => 9, 'ten_chuc_nang' => 'Tìm kiếm khách hàng'],
            ['id' => 10, 'ten_chuc_nang' => 'Cập nhật khách hàng'],
            ['id' => 11, 'ten_chuc_nang' => 'Xóa khách hàng'],
            ['id' => 12, 'ten_chuc_nang' => 'Đổi trạng thái khách hàng'],
            ['id' => 13, 'ten_chuc_nang' => 'Xem view blog'],
            ['id' => 14, 'ten_chuc_nang' => 'Lấy dữ liệu blog'],
            ['id' => 15, 'ten_chuc_nang' => 'Thêm mới blog'],
            ['id' => 16, 'ten_chuc_nang' => 'Cập nhật blog'],
            ['id' => 17, 'ten_chuc_nang' => 'Đổi trạng thái blog'],
            ['id' => 18, 'ten_chuc_nang' => 'Xóa blog'],
            ['id' => 19, 'ten_chuc_nang' => 'Xem view danh mục'],
            ['id' => 20, 'ten_chuc_nang' => 'Lấy dữ liệu danh mục'],
            ['id' => 21, 'ten_chuc_nang' => 'Thêm mới danh mục'],
            ['id' => 22, 'ten_chuc_nang' => 'Cập nhật danh mục'],
            ['id' => 23, 'ten_chuc_nang' => 'Đổi trạng danh mục'],
            ['id' => 24, 'ten_chuc_nang' => 'Xóa danh mục'],
            ['id' => 25, 'ten_chuc_nang' => 'Xem view nhà cung cấp'],
            ['id' => 26, 'ten_chuc_nang' => 'Lấy dữ liệu nhà cung cấp'],
            ['id' => 27, 'ten_chuc_nang' => 'Thêm mới nhà cung cấp'],
            ['id' => 28, 'ten_chuc_nang' => 'Cập nhật nhà cung cấp'],
            ['id' => 29, 'ten_chuc_nang' => 'Đổi trạng nhà cung cấp'],
            ['id' => 30, 'ten_chuc_nang' => 'Xóa nhà cung cấp'],
            ['id' => 31, 'ten_chuc_nang' => 'Xem view đơn vị'],
            ['id' => 32, 'ten_chuc_nang' => 'Lấy dữ liệu đơn vị'],
            ['id' => 33, 'ten_chuc_nang' => 'Thêm mới đơn vị'],
            ['id' => 34, 'ten_chuc_nang' => 'Cập nhật đơn vị'],
            ['id' => 35, 'ten_chuc_nang' => 'Xóa đơn vị'],
            ['id' => 36, 'ten_chuc_nang' => 'Xem view nguyên liệu'],
            ['id' => 37, 'ten_chuc_nang' => 'Thêm mới nguyên liệu'],
            ['id' => 38, 'ten_chuc_nang' => 'Lấy dữ liệu nguyên liệu'],
            ['id' => 39, 'ten_chuc_nang' => 'Cập nhật nhà nguyên liệu'],
            ['id' => 40, 'ten_chuc_nang' => 'Đổi trạng nguyên liệu'],
        ]);
    }
}
