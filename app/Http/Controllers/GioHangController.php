<?php

namespace App\Http\Controllers;

use App\Models\DonHang;
use App\Models\GioHang;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GioHangController extends Controller
{
    public function addToCart(Request $request)
    {
        $data = $request->all();
        $user_check = Auth::guard('khach_hang')->check();
        if ($user_check) {
            $khach_hang = Auth::guard('khach_hang')->user();
            $check      = GioHang::where('id_san_pham', $data['id'])
                                  ->where('tinh_trang', 0)
                                  ->where('id_khach_hang', $khach_hang->id)
                                  ->first();
            if ($check) {
                $check->so_luong = $check->so_luong + $data['so_luong_mua'];
                $check->thanh_tien = $check->so_luong * $check->don_gia;
                $check->save();
            } else {
                GioHang::create([
                    'id_san_pham'       => $data['id'],
                    'id_khach_hang'     => $khach_hang->id,
                    'don_gia'           => $data['gia_ban'],
                    'so_luong'          => 1,
                    'thanh_tien'        => $data['gia_ban'] * 1,
                    'tinh_trang'        => 0,
                ]);
            }

            return response()->json([
                'status'    => 1,
                'message'   => 'Đã thêm vào giỏ hàng',
            ]);
        }

    }

    public function dataCart()
    {

        $user = Auth::guard('khach_hang')->user();

        $data = GioHang::where('id_khach_hang', $user->id)
                        ->where('tinh_trang',0)
                        ->select(DB::raw('SUM(so_luong) as so_luong'), DB::raw('SUM(thanh_tien) as tong_tien'))
                        ->get();

        return response()->json([
            'data'    => $data,
        ]);

    }

    public function dataListCart()
    {
        $user = Auth::guard('khach_hang')->user();
        $data = GioHang::where('id_khach_hang', $user->id)
                        ->where('tinh_trang',0)
                        ->join('san_phams', 'san_phams.id', 'gio_hangs.id_san_pham')
                        ->select('gio_hangs.id', 'gio_hangs.don_gia', 'gio_hangs.so_luong', 'gio_hangs.thanh_tien', 'san_phams.ten_san_pham', 'san_phams.hinh_anh')
                        ->groupBy('gio_hangs.id', 'gio_hangs.don_gia', 'gio_hangs.so_luong', 'gio_hangs.thanh_tien', 'san_phams.ten_san_pham', 'san_phams.hinh_anh')
                        ->get();
        $total = 0;
        foreach ($data as $value) {
            $total += $value->thanh_tien;
        }
        return response()->json([
            'data'   => $data,
            'total'   => $total,
        ]);
    }

    public function updateCart(Request $request)
    {
        $chiTiet = GioHang::find($request->id);

        if ($chiTiet) {
            $chiTiet->update([
                'so_luong'      => $request->so_luong,
                'thanh_tien'    => $request->so_luong * $chiTiet->don_gia,
            ]);

            return response()->json([
                'status'    => 1,
                'message'   => 'Cập nhật thành công!',
            ]);
        } else {
            return response()->json([
                'status'    => 0,
                'message'   => 'Không tìm thấy chi tiết giỏ hàng này!',
            ]);
        }
    }

    public function deleteCart(Request $request)
    {
        $user = Auth::guard('khach_hang')->user();
        $chiTiet = GioHang::where('id', $request->id)
            ->where('id_khach_hang', $user->id)
            ->first();
        if ($chiTiet) {
            $chiTiet->delete();

            return response()->json([
                'status'    => 1,
                'message'   => 'Đã xóa thành công',
            ]);
        } else {
            return response()->json([
                'status'    => 0,
                'message'   => 'Không tìm thấy hoặc không phải giỏ hàng của bạn!',
            ]);
        }
    }

    public function indexDonHang()
    {
        return view('client.page.list_don_hang');
    }

    public function dataDonHang()
    {
        $user = Auth::guard('khach_hang')->user();

        $data = DonHang::where('id_khach_hang', $user->id)->orderByDESC('id')->get();

        return response()->json([
            'data'  => $data
        ]);
    }

    public function updateThanhToan(Request $request)
    {

        $hoa_don = DonHang::find($request->id);
        if($hoa_don) {
            $hoa_don->loai_thanh_toan = $request->loai_thanh_toan;
            $hoa_don->save();

            return response()->json([
                'status'   => true,
                'message'  => "Cập Nhật hình thức thanh toán thành công!"
            ]);
        } else {
            return response()->json([
                'status'   => false,
                'message'  => "Đã có lỗi hệ thống!"
            ]);
        }


    }
}
