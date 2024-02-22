<?php

namespace App\Http\Controllers;

use App\Models\DonHang;
use App\Models\ThanhToan;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class ThanhToanController extends Controller
{
    public function index()
    {
        $client = new Client();
        $payload = [
            "USERNAME"  =>  "THANHTRUONG2311",
            "PASSWORD"  =>  "Lethanhtruong2311@@",
            "DAY_BEGIN" =>  Carbon::now()->format('d/m/Y'),
            "DAY_END"   =>  Carbon::now()->format('d/m/Y'),
            "NUMBER_MB" =>  "1910061030119",
        ];
        try {
            $response = $client->post('http://103.137.185.71:2603/mb', [
                'json' => $payload
            ]);
            $data = json_decode($response->getBody(), true);
            if(isset($data['transactionHistoryList'])) {
                foreach($data['transactionHistoryList'] as $k => $v) {
                    $check  =   ThanhToan::where('code', $v['refNo'])->first();
                    if(!$check) {
                        ThanhToan::create([
                            'so_tien'       =>  $v['creditAmount'],
                            'noi_dung'      =>  $v['description'],
                            'code'          =>  $v['refNo'],
                        ]);

                        $pattern = '/CFTC(\d+)/';
                        $text    = $v['description'];
                        if (preg_match($pattern, $text, $matches)) {
                            $result     = $matches[1];
                            $so_tien    = $v['creditAmount'];
                            $kiem_tra   = DonHang::where('ma_don_hang', $result)
                                                 ->where('tong_tien', '<=', $so_tien)
                                                 ->first();
                            if($kiem_tra) {
                                $kiem_tra->is_thanh_toan = 1;
                                $kiem_tra->save();

                                // VeXemPhim::where('id_don_hang', $result)
                                //          ->update([
                                //             'tinh_trang'    => 2
                                //          ]);
                                // Gửi mail
                            }
                        }
                    }
                }
            }

        } catch (\Exception $e) {
            echo $e;
            // Xử lý khi có lỗi xảy ra
        }
    }
}
