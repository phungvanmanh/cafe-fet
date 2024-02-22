<?php

namespace App\Http\Controllers;

use App\Models\ChiTietNhapKho;
use App\Models\HoaDonNhapKho;
use App\Models\NguyenLieu;
use App\Models\NhaCungCap;
use App\Models\NhapKho;
use App\Models\SanPham;
use App\Models\TmpNhapKho;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class NhapKhoController extends Controller
{
    public function index()
    {
        return view('admin.page.donNhapKho.index');
    }

    public function dataNhapKho()
    {
        $data = TmpNhapKho::join('nguyen_lieus', 'nguyen_lieus.id', 'tmp_nhap_khos.id_nguyen_lieu')
            ->join('nha_cung_caps', 'nha_cung_caps.id', 'tmp_nhap_khos.id_nha_cung_cap')
            ->select('nguyen_lieus.ten_nguyen_lieu', 'nha_cung_caps.ten_doanh_nghiep', 'tmp_nhap_khos.*')
            ->get();
        return response()->json([
            'data'    => $data,
        ]);
    }

    public function createNhapKho(Request $request)
    {
        $tmpDaCo =  TmpNhapKho::where('id_nguyen_lieu', $request->id)->first();
        if ($tmpDaCo) {
            $tmpDaCo->so_luong++;
            $tmpDaCo->thanh_tien = $tmpDaCo->so_luong * $tmpDaCo->don_gia;
            $tmpDaCo->save();
        } else {
            TmpNhapKho::create(
                [
                    'id_nguyen_lieu' => $request->id,
                    'id_nha_cung_cap' => $request->id_nha_cung_cap,
                ]
            );
        }

        return response()->json([
            'status'    => 1,
            'message'   => 'Đã thêm thành công!',
        ]);
    }

    public function updateNhapKho(Request $request)
    {
        $data = $request->all();
        $data['thanh_tien'] = $data['so_luong'] * $data['don_gia'];
        TmpNhapKho::find($data['id'])->update($data);
        return response()->json([
            'status'    => 1,
            'message'   => 'Đã cập nhật thành công!',
        ]);
    }

    public function deleteNhapKho(Request $request)
    {
        TmpNhapKho::find($request->id)->delete();
        return response()->json([
            'status'    => 1,
            'message'   => 'Đã xóa thành công!',
        ]);
    }

    public function dataNguyenLieu($id_nha_cung_cap)
    {
        $check = NhaCungCap::find($id_nha_cung_cap);
        if ($check) {
            $list = explode('|', $check->list_id_nguyen_lieu);
            $list_nguyen_lieu = NguyenLieu::all();
            $data = [];
            foreach ($list_nguyen_lieu as $value) {
                if (in_array($value->id, $list)) {
                    array_push($data, $value);
                }
            }
            return response()->json([
                'status'    => 1,
                'data'   => $data,
            ]);
        }
    }

    public function taoHoaDonNhapKho(Request $request)
    {
        DB::beginTransaction();

        try {
            $dataHoaDon = $request->thong_tin;
            $dataHoaDon['ma_hoa_don'] = Str::uuid();
            $dataHoaDon['ngay_tao_hoa_don'] = Carbon::now()->toDateString();
            $dataHoaDon['tong_tien'] = 0;
            foreach ($request->list_tmp_nhap_kho as $value) {
                $dataHoaDon['tong_tien'] += $value['thanh_tien'];
            }
            $dataHoaDon['id_admin_nhap'] = Auth::guard('admin')->user()->id;
            $dataHoaDon['id_nha_cung_cap'] = $request->list_tmp_nhap_kho[0]['id_nha_cung_cap'];
            $hoaDon = HoaDonNhapKho::create($dataHoaDon);

            foreach ($request->list_tmp_nhap_kho as $value) {
                ChiTietNhapKho::create([
                    'id_nguyen_lieu'    => $value['id_nguyen_lieu'],
                    'so_luong'          => $value['so_luong'],
                    'don_gia'           => $value['don_gia'],
                    'thanh_tien'        => $value['thanh_tien'],
                    'ghi_chu'           => $value['ghi_chu'],
                    'id_nha_cung_cap'   => $value['id_nha_cung_cap'],
                    'id_hoa_don'        => $hoaDon->id,
                ]);

                TmpNhapKho::find($value['id'])->delete();
            }

            DB::commit();

            return response()->json([
                'status'    => 1,
                'message'   => 'Đã tạo hóa đơn thành công!',
            ]);
        } catch (Exception $e) {
            Log::error($e);
            DB::rollBack();
        }
    }
}
