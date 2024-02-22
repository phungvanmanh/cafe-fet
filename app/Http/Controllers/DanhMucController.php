<?php

namespace App\Http\Controllers;

use App\Http\Requests\DanMuc\CreateDanhMucRequest;
use App\Http\Requests\DanMuc\DeleteDanhMucRequest;
use App\Http\Requests\DanMuc\DoiTrangThaiDanhMucRequest;
use App\Http\Requests\DanMuc\UpdateDanhMucRequest;
use App\Models\DanhMuc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DanhMucController extends Controller
{
    public function index()
    {
        $id_chuc_nang   =   19;

        $user_login     =   Auth::guard('admin')->user();

        $check = $this->checkQuyen($id_chuc_nang, $user_login->id_quyen);

        if (!$check) {
            toastr()->error("Bạn không đủ quyền truy cập!");
            return redirect()->back();
        }
        $danhMucCha = DanhMuc::where('id_danh_muc_cha', 0)->get();
        return view('admin.page.danhMuc.index', compact('danhMucCha'));
    }

    public function getDataDanhMuc()
    {
        $id_chuc_nang   =   20;

        $user_login     =   Auth::guard('admin')->user();

        $check = $this->checkQuyen($id_chuc_nang, $user_login->id_quyen);

        if (!$check) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không có quyền cho chức năng này!',
            ]);
        }
        $data = DanhMuc::from('danh_mucs as a')
            ->rightJoin('danh_mucs as b', 'a.id', 'b.id_danh_muc_cha')
            ->select('a.ten_danh_muc as ten_danh_muc_cha', 'b.*')
            ->get();

        return response()->json([
            'status'    => 1,
            'data'   => $data,
        ]);
    }

    public function createDanhMuc(CreateDanhMucRequest $request)
    {
        $id_chuc_nang   =   21;

        $user_login     =   Auth::guard('admin')->user();

        $check = $this->checkQuyen($id_chuc_nang, $user_login->id_quyen);

        if (!$check) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không có quyền cho chức năng này!',
            ]);
        }
        $data = $request->all();

        DanhMuc::create($data);

        return response()->json([
            'status'    => 1,
            'message'   => 'Đã thêm mới thành công!',
        ]);
    }

    public function updateDanhMuc(UpdateDanhMucRequest $request)
    {
        $id_chuc_nang   =   22;

        $user_login     =   Auth::guard('admin')->user();

        $check = $this->checkQuyen($id_chuc_nang, $user_login->id_quyen);

        if (!$check) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không có quyền cho chức năng này!',
            ]);
        }
        $danh_muc = DanhMuc::find($request->id);
        if ($danh_muc) {
            $data = $request->all();

            $danh_muc->update($data);

            return response()->json([
                'status'    => 1,
                'message'   => 'Đã cập nhật thành công!',
            ]);
        } else {
            return response()->json([
                'status'    => 0,
                'message'   => 'Danh mục không tồn tại trong hệ thống!',
            ]);
        }
    }

    public function deleteDanhMuc(DeleteDanhMucRequest $request)
    {
        $id_chuc_nang   =   24;

        $user_login     =   Auth::guard('admin')->user();

        $check = $this->checkQuyen($id_chuc_nang, $user_login->id_quyen);

        if (!$check) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không có quyền cho chức năng này!',
            ]);
        }
        $danh_muc = DanhMuc::find($request->id);
        if ($danh_muc) {
            $danh_muc->delete();

            return response()->json([
                'status'    => 1,
                'message'   => 'Đã xóa thành công!',
            ]);
        } else {
            return response()->json([
                'status'    => 0,
                'message'   => 'Danh mục không tồn tại trong hệ thống!',
            ]);
        }
    }

    public function statusDanhMuc(DoiTrangThaiDanhMucRequest $request)
    {
        $id_chuc_nang   =   23;

        $user_login     =   Auth::guard('admin')->user();

        $check = $this->checkQuyen($id_chuc_nang, $user_login->id_quyen);

        if (!$check) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không có quyền cho chức năng này!',
            ]);
        }
        $danh_muc = DanhMuc::where('id', $request->id)->first();

        if ($danh_muc) {
            $danh_muc->trang_thai = !$danh_muc->trang_thai;

            $danh_muc->save();

            return response()->json([
                'status'    => 1,
                'message'      => 'Đã đổi trạng thái thành công!'
            ]);
        } else {
            return response()->json([
                'status'    => 0,
                'message'   => 'Danh mục không tồn tại trong hệ thống!',
            ]);
        }
    }
}
