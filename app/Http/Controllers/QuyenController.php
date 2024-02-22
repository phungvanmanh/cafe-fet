<?php

namespace App\Http\Controllers;

use App\Http\Requests\PhanQuyen\CreatePhanQuyenRequest;
use App\Http\Requests\PhanQuyen\DeletePhanQuyenRequest;
use App\Http\Requests\PhanQuyen\UpdatePhanQuyenRequest;
use App\Models\ChucNang;
use App\Models\DanhSachChucNang;
use App\Models\PhanQuyen;
use App\Models\Quyen;
use App\Models\QuyenChucNang;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class QuyenController extends Controller
{
    public function index()
    {
        return view('admin.page.quyen.index');
    }

    public function dataQuyen(Request $request)
    {
        $data = PhanQuyen::get();
        return response()->json([
            'status'    => 1,
            'data'      => $data,
        ]);
    }

    public function dataChucNang(Request $request)
    {
        $data       = ChucNang::get();
        $chucNang   = QuyenChucNang::where('id_quyen', $request->id)->get();
        foreach ($data as $k_1 => $v_1) {
            foreach ($chucNang as $k_2 => $v_2) {
                if ($v_1->id == $v_2->id_chuc_nang) {
                    $v_1->check = true;
                    break;
                }
            }
        }
        return response()->json([
            'status'    => 1,
            'data'      => $data,
        ]);
    }

    public function store(CreatePhanQuyenRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->all();
            PhanQuyen::create($data);

            DB::commit();
            return response()->json([
                'status'    => 1,
                'message'   => 'Đã thêm mới quyền thành công!',
            ]);
        } catch (Exception $e) {
            Log::error("Đã có lỗi: " . $e);
            DB::rollBack();
        }
    }

    public function destroy(DeletePhanQuyenRequest $request)
    {
        DB::beginTransaction();
        try {

            $phanQuyen     =   PhanQuyen::find($request->id);

            if ($phanQuyen) {
                $phanQuyen->delete();
                DB::commit();

                return response()->json([
                    'status'    => 1,
                    'message'   => 'Đã xóa quyền thành công!',
                ]);
            } else {
                return response()->json([
                    'status'    => 0,
                    'message'   => 'Quyền không tồn tại!',
                ]);
            }
        } catch (Exception $e) {
            Log::error($e);
            DB::rollBack();
        }
    }

    public function update(UpdatePhanQuyenRequest $request)
    {
        DB::beginTransaction();
        try {

            $phanQuyen     =   PhanQuyen::find($request->id);
            if ($phanQuyen) {
                $data   = $request->all();
                $phanQuyen->update($data);
                DB::commit();

                return response()->json([
                    'status'    => 1,
                    'message'   => 'Đã cập nhật quyền thành công!',
                ]);
            } else {
                return response()->json([
                    'status'    => 0,
                    'message'   => 'Quyền không tồn tại!',
                ]);
            }
        } catch (Exception $e) {
            Log::error($e);
            DB::rollBack();
        }
    }

    public function status(Request $request)
    {
        DB::beginTransaction();
        try {
            $phanQuyen     =   PhanQuyen::find($request->id);
            if ($phanQuyen) {
                $phanQuyen->tinh_trang     =   $phanQuyen->tinh_trang == 1 ? 0 : 1;
                $phanQuyen->save();
                DB::commit();

                return response()->json([
                    'status'    => 1,
                    'message'   => 'Đã cập nhật quyền thành công!',
                ]);
            } else {
                return response()->json([
                    'status'    => 0,
                    'message'   => 'Quyền không tồn tại!',
                ]);
            }
        } catch (Exception $e) {
            Log::error($e);
            DB::rollBack();
        }
    }

    public function phanQuyen(Request $request)
    {
        if ($request->quyen == [] || $request->chuc_nang == []) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Cần chọn quyền để cấp quyền!',
            ]);
        }
        DB::beginTransaction();
        try {
            QuyenChucNang::where('id_quyen', $request->quyen['id'])->delete();
            foreach ($request->chuc_nang as $key => $value) {
                if (isset($value['check']) && $value['check'] == true) {
                    QuyenChucNang::create([
                        'id_quyen'          =>  $request->quyen['id'],
                        'id_chuc_nang'      =>  $value['id'],
                    ]);
                }
            }
            DB::commit();
            return response()->json([
                'status'    => 1,
                'message'   => 'Đã cập nhật quyền thành công!',
            ]);
        } catch (Exception $e) {
            Log::error($e);
            DB::rollBack();
        }
    }
}
