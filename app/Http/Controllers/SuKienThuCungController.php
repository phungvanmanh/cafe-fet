<?php

namespace App\Http\Controllers;

use App\Models\KhachHang;
use App\Models\SuKienThuCung;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use stdClass;
use Illuminate\Support\Str;

class SuKienThuCungController extends Controller
{
    public function index()
    {
        return view('admin.page.suKien.index');
    }

    public function indexDanhSach() {
        return view('admin.page.suKien.danhsach');
    }

    public function dataDanhSachSuKien()
    {
        $su_kien = SuKienThuCung::select('su_kien_thu_cungs.*', DB::raw ("DATE_FORMAT(thoi_gian_bat_dau,'%d/%m/%Y') as day_begin"), DB::raw ("DATE_FORMAT(thoi_gian_ket_thuc,'%d/%m/%Y') as day_end"))->get();
        foreach ($su_kien as $value) {
            $today = Carbon::today();
            $day_beign  = Carbon::parse($value->thoi_gian_bat_dau);
            $day_end    = Carbon::parse($value->thoi_gian_ket_thuc);

            if($today->greaterThan($day_end)) {
                $value->is_ket_thuc = 2;
            } else if($today->lessThan($day_beign))  {
                $value->is_ket_thuc = 0;
            } else {
                $value->is_ket_thuc = 1;
            }
            $value->save();

            $arrayList = [];
            $array = explode(',', $value->list_id_client);
            $array = array_filter($array, function($v) {
                return $v !== "";
            });
            $value->so_nguoi_da_tham_gia = count($array);
            foreach ($array as $v_1) {
                $khach_hang = KhachHang::where('id', $v_1)->first();
                if ($khach_hang) {
                    $object = new stdClass();
                    $object->full_name     = $khach_hang->full_name;
                    $object->so_dien_thoai = $khach_hang->so_dien_thoai;
                    $arrayList[] = $object;
                }
            }
            $value->list_id_client = $arrayList;

        }

        return response()->json([
            'data'   => $su_kien,
        ]);
    }

    public function createSuKien(Request $request)
    {
        $data = $request->all();
        SuKienThuCung::create($data);

        return response()->json([
            'status'    => 1,
            'message'   => 'Đã thêm mới thành công!',
        ]);
    }

    public function dataSuKien()
    {
        $data = SuKienThuCung::get();
        return response()->json([
            'data'   => $data,
        ]);
    }

    public function doiTrangThaiSuKien(Request $request)
    {
        $user = Auth::guard('admin')->user();

        $data = $request->all();
        $su_kien = SuKienThuCung::find($request->id);
        if ($su_kien->tinh_trang == 0) {
            $su_kien->tinh_trang = 1;
        } else {
            $su_kien->tinh_trang = 0;
        }
        $su_kien->save();

        return response()->json([
            'status'    => 1,
            'message'   => 'Đã đổi trạng thái thành công!',
        ]);

    }

    public function updateSuKien(Request $request)
    {
        $su_kien = SuKienThuCung::find($request->id);
        if ($su_kien) {
            $data = $request->all();

            $su_kien->update($data);

            return response()->json([
                'status'    => 1,
                'message'   => 'Đã cập nhật thành công!',
            ]);
        } else {
            return response()->json([
                'status'    => 0,
                'message'   => 'Sự kiện không tồn tại trong hệ thống!',
            ]);
        }
    }

    public function deleteSuKien(Request $request)
    {
        SuKienThuCung::find($request->id)->delete();
        return response()->json([
            'status'    => 1,
            'message'   => 'Đã xóa thành công!',
        ]);
    }
}
