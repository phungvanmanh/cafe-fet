<?php

namespace App\Http\Controllers;

use App\Models\HoaDonNhapKho;
use Illuminate\Http\Request;

class HoaDonNhapKhoController extends Controller
{
    public function index()
    {
        return view('admin.page.hoadonNhapKho.index');
    }
    public function gethoadonNhapKho()
    {
        $data = HoaDonNhapKho::join('admins', 'admins.id', 'hoa_don_nhap_khos.id_admin_nhap')
                            ->join('nha_cung_caps', 'nha_cung_caps.id', 'hoa_don_nhap_khos.id_nha_cung_cap')
                            ->select('hoa_don_nhap_khos.*', 'admins.full_name', 'nha_cung_caps.ten_doanh_nghiep')
                            ->get();
         return response()->json([
        'data' => $data,

       ]);
    }
}
