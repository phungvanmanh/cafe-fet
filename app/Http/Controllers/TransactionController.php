<?php

namespace App\Http\Controllers;

use App\Models\DonHang;
use App\Models\Transaction;
use Carbon\Carbon;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TransactionController extends Controller
{
    public function transaction()
    {
        $client = new Client();
        $payload = [
            "USERNAME"      => "NGUYENHOAN168", // Tên đăng nhập
            "PASSWORD"      => "Hoan1608!", // Mật khẩu
            "DAY_BEGIN"     => Carbon::today()->format('d/m/Y'),
            "DAY_END"       => Carbon::today()->format('d/m/Y'),
            "NUMBER_MB"     => "0186915616801" // Số Tài Khoản
        ];

        try {
            $response = $client->post('http://103.137.185.71:2603/mb', [
                'json' => $payload
            ]);

            $data = json_decode($response->getBody(), true);
            if($data['status'] == true) {
                foreach ($data['data'] as $key => $value) {
                    if($value['creditAmount'] > 0) {
                        $check      = Transaction::where('refNo', $value['refNo'])
                                                 ->first();
                        if(!$check) {
                            $date = Carbon::createFromFormat('d/m/Y H:i:s', $value['transactionDate']);
                            Transaction::create([
                                'accountNo'         => $value['accountNo'],
                                'transactionDate'   => $date,
                                'creditAmount'      => $value['creditAmount'],
                                'description'       => $value['description'],
                                'refNo'             => $value['refNo'],
                                // 'code',
                            ]);
                            $pattern = '/HD\d{6}/';
                            $text    = $value['description'];
                            if (preg_match($pattern, $text, $matches)) {
                                $result = $matches[0];
                                DonHang::where('ma_don_hang', $result)
                                    ->where('tong_tien', '<=', $value['creditAmount'])
                                    ->update([
                                        'is_thanh_toan'    => 1
                                    ]);
                            }
                        }
                    }
                }

                return response()->json([
                    'status' => true
                ]);
            } else {
                return response()->json([
                    'status' => false
                ]);
            }
        } catch (Exception $e) {
            echo $e;
        }
    }

    public function extractNumber($string) {
        $numberString = preg_replace('/[^0-9]/', '', $string);
        return (int)$numberString;
    }
}
