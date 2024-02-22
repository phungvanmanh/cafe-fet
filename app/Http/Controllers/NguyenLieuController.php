<?php

namespace App\Http\Controllers;

use App\Http\Requests\NguyenLieu\CreateNguyenLieuRequest;
use App\Http\Requests\NguyenLieu\UpdateNguyenLieuRequest;
use App\Models\NguyenLieu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NguyenLieuController extends Controller
{
    public function index()
    {
        $id_chuc_nang   =   36;

        $user_login     =   Auth::guard('admin')->user();

        $check = $this->checkQuyen($id_chuc_nang, $user_login->id_quyen);

        if(!$check) {
            if(!$check) {
                toastr()->error("Bạn không đủ quyền truy cập!");
                return redirect()->back();
            }
        }
        return view('admin.page.nguyenLieu.index');
    }

    public function createNguyenLieu(CreateNguyenLieuRequest $request)
    {
        $id_chuc_nang   =   37;

        $user_login     =   Auth::guard('admin')->user();

        $check = $this->checkQuyen($id_chuc_nang, $user_login->id_quyen);

        if(!$check) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không có quyền cho chức năng này!',
            ]);
        }
        $data = $request->all();

        NguyenLieu::create($data);

        return response()->json([
            'status'    => 1,
        ]);
    }

    public function dataNguyenLieu()
    {
        $id_chuc_nang   =   38;

        $user_login     =   Auth::guard('admin')->user();

        $check = $this->checkQuyen($id_chuc_nang, $user_login->id_quyen);

        if(!$check) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không có quyền cho chức năng này!',
            ]);
        }
        $data = NguyenLieu::leftjoin('don_vis', 'nguyen_lieus.don_vi_tinh', 'don_vis.id')
            ->select('don_vis.ten_don_vi', 'nguyen_lieus.*')
            ->get();

        return response()->json([
            'data'    => $data,
        ]);
    }

    public function doiTrangThaiNguyenLieu(Request $request)
    {
        $id_chuc_nang   =   40;

        $user_login     =   Auth::guard('admin')->user();

        $check = $this->checkQuyen($id_chuc_nang, $user_login->id_quyen);

        if(!$check) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không có quyền cho chức năng này!',
            ]);
        }
        $nguyenLieu = NguyenLieu::find($request->id);
        if ($nguyenLieu) {
            $nguyenLieu->trang_thai = !$nguyenLieu->trang_thai;
            $nguyenLieu->save();

            return response()->json([
                'status'    => 1,
            ]);
        } else {
            return response()->json([
                'status'    => 0,
                'message'   => 'Nguyên liệu này chưa có'
            ]);
        }
    }

    public function updateNguyenLieu(UpdateNguyenLieuRequest $request)
    {
        $id_chuc_nang   =   39;

        $user_login     =   Auth::guard('admin')->user();

        $check = $this->checkQuyen($id_chuc_nang, $user_login->id_quyen);

        if(!$check) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không có quyền cho chức năng này!',
            ]);
        }
        $data = $request->all();

        NguyenLieu::find($request->id)->update($data);

        return response()->json([
            'status'    => 1,
        ]);
    }
}
