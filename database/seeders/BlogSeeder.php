<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    public function run()
    {
        DB::table('blogs')->delete();

        DB::table('blogs')->truncate();

        DB::table('blogs')->insert([
            [
                'tieu_de' => 'bệnh thường gặp ở thú cưng',
                'slug' => Str::slug('bệnh thường gặp ở thú cưng'),
                'mo_ta_ngan' => 'bệnh của thú cưng dễ gặp trong cuộc sống',
                'mo_ta_chi_tiet' => 'Yi He Tang',
                'hinh_anh' => 'https://i.ex-cdn.com/nongnghiep.vn/files/content/2023/08/30/tiem-phong-vac-xin-la-cach-tot-nhat-phong-benh-cho-thu-cung-174536_166.jpg',
                'tinh_trang' => '1',
            ],
            [
                'tieu_de' => 'hướng dẫn đăng ký tài khoản cho người mới',
                'slug' => Str::slug('hướng dẫn đăng ký tài khoản cho người mới'),
                'mo_ta_ngan' => 'cách dăng ký tài khoản',
                'mo_ta_chi_tiet' => 'hiện các tin tức trên mạng giúp người dùng cập nhật các thông tin trên mạng',
                'hinh_anh' => 'https://pos.nvncdn.net/367fec-95771/art/20221105_ilX8O9t3M3o7RcN2q6JIbGZ4.jpg',
                'tinh_trang' => '1',
            ],
            [
                'tieu_de' => 'vui đùa cùng thú cưng',
                'slug' => Str::slug('vui đùa cùng thú cưng'),
                'mo_ta_ngan' => 'một ngày duy nhất để giao lưu kết bạn cũng như chơi cùng thú cưng của mình',
                'mo_ta_chi_tiet' => 'sự kiện thú cưng được thông báo đến người dùng diễn ra ngay tại quán vào ngày 1/1/2024',
                'hinh_anh' => 'https://vcdn-giadinh.vnecdn.net/2022/08/10/294717369-1075174046440773-667-2302-1585-1660065780.jpg',
                'tinh_trang' => '1',
            ],
            [
                'tieu_de' => 'trái tim nhỏ tình yêu to',
                'slug' => Str::slug('trái tim nhỏ tình yêu to'),
                'mo_ta_ngan' => 'sự kiện thú cưng được thông báo đến người dùng diễn ra từ ngày 12/5/2024-12/6/2024',
                'mo_ta_chi_tiet' => 'Yi He Tang',
                'hinh_anh' => 'https://duyendangvietnam.net.vn/public/uploads/files/cho%20meo.jpg',
                'tinh_trang' => '1',
            ],
            [
                'tieu_de' => 'bí quyết để trở nên thành công',
                'slug' => Str::slug('bí quyết để trở nên thành công'),
                'mo_ta_ngan' => 'bệnh của thú cưng dễ gặp trong cuộc sống',
                'mo_ta_chi_tiet' => 'để thành công cần nên thất bại, trong cuộc sống chúng ta cần nổ lực hơn hơn nữa. Chưa bao giờ là đủ',
                'hinh_anh' => 'https://www.ieltsvietop.vn/wp-content/uploads/2023/07/Money-nghia-la-gi.jpg',
                'tinh_trang' => '1',
            ],

        ]);
    }
}
