<?php

namespace App\Http\Controllers;

use App\Models\DonHang;
use App\Models\DonVi;
use Illuminate\Http\Request;

class DonHangController extends Controller
{
    public function indexAdmin()
    {
        return view('admin.page.donHang.index');
    }

    public function dataDonHang()
    {
        $data = DonHang::join('khach_hangs', 'khach_hangs.id', 'don_hangs.id_khach_hang')
                       ->select('don_hangs.*', 'khach_hangs.full_name as ten_nguoi_dat')
                       ->get();
        $tong_tien_don_hang = $data->sum('tong_tien');
        return response()->json([
            'data'      => $data,
            'tong_tien' => $tong_tien_don_hang
        ]);
    }

    public function changeStatus(Request $request)
    {
        $don_hang = DonHang::find($request->id);

        if($don_hang) {
            $don_hang->is_thanh_toan = 1;
            $don_hang->save();

            return response()->json([
                'status'    => true,
                'message'   => "Cập nhật thanh toán thành công!"
            ]);
        } else {
            return response()->json([
                'status'    => false,
                'message'   => "Đã có lỗi xảy ra!"
            ]);
        }
    }

    public function destroy(Request $request)
    {
        $don_hang = DonHang::find($request->id);

        if($don_hang) {
            $don_hang->delete();

            return response()->json([
                'status'    => true,
                'message'   => "Cập nhật thanh toán thành công!"
            ]);
        } else {
            return response()->json([
                'status'    => false,
                'message'   => "Đã có lỗi xảy ra!"
            ]);
        }
    }
}
