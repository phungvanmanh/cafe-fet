<?php

namespace App\Http\Controllers;

use App\Http\Requests\NhaCungCap\CreateNhaCungCapRequest;
use App\Http\Requests\NhaCungCap\DeleteNhaCungCapRequest;
use App\Http\Requests\NhaCungCap\UpdateNhaCungCapRequest;
use App\Models\NguyenLieu;
use App\Models\NhaCungCap;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NhaCungCapController extends Controller
{

    public function index()
    {
        $id_chuc_nang   =   25;

        $user_login     =   Auth::guard('admin')->user();

        $check = $this->checkQuyen($id_chuc_nang, $user_login->id_quyen);

        if(!$check) {
            if(!$check) {
                toastr()->error("Bạn không đủ quyền truy cập!");
                return redirect()->back();
            }
        }
        return view('admin.page.nhaCungCap.index');
    }

    public function createNhaCungCap(CreateNhaCungCapRequest $request)
    {
        $id_chuc_nang   =   27;

        $user_login     =   Auth::guard('admin')->user();

        $check = $this->checkQuyen($id_chuc_nang, $user_login->id_quyen);

        if(!$check) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không có quyền cho chức năng này!',
            ]);
        }
        $data = $request->all();
        $data['nhaCungCap']['list_id_nguyen_lieu'] = '';
        foreach ($data['listNguyenLieu'] as $value) {
            if (isset($value['choose']) && $value['choose']) {
                $data['nhaCungCap']['list_id_nguyen_lieu'] .= $value['id'] . '|';
            }
        }
        NhaCungCap::create($data['nhaCungCap']);

        return response()->json([
            'status'    => true,
            'message'   => 'Đã tạo mới nhà cung cấp thành công!',
        ]);
    }

    public function getDataNhaCungCap()
    {
        $id_chuc_nang   =   26;

        $user_login     =   Auth::guard('admin')->user();

        $check = $this->checkQuyen($id_chuc_nang, $user_login->id_quyen);

        if(!$check) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không có quyền cho chức năng này!',
            ]);
        }
        $data = NhaCungCap::all();

        return response()->json([
            'data'  => $data,
        ]);
    }

    public function updateNhaCungCap(UpdateNhaCungCapRequest $request)
    {
        $id_chuc_nang   =   28;

        $user_login     =   Auth::guard('admin')->user();

        $check = $this->checkQuyen($id_chuc_nang, $user_login->id_quyen);

        if(!$check) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không có quyền cho chức năng này!',
            ]);
        }
        $data = $request->all();
        $data['nhaCungCap']['list_id_nguyen_lieu'] = '';
        foreach ($data['listNguyenLieu'] as $value) {
            if (isset($value['choose']) && $value['choose']) {
                $data['nhaCungCap']['list_id_nguyen_lieu'] .= $value['id'] . '|';
            }
        }
        $nhaCungCap = NhaCungCap::find($data['nhaCungCap']['id']);
        $nhaCungCap->update($data['nhaCungCap']);

        return response()->json([
            'status'    => true,
            'message'   => 'Đã cập nhật thành công nhà cung cấp!',
        ]);
    }

    public function deleteNhaCungCap(DeleteNhaCungCapRequest $request)
    {
        $id_chuc_nang   =   30;

        $user_login     =   Auth::guard('admin')->user();

        $check = $this->checkQuyen($id_chuc_nang, $user_login->id_quyen);

        if(!$check) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không có quyền cho chức năng này!',
            ]);
        }
        $nhaCungCap = NhaCungCap::where('id', $request->id)->first();
        $nhaCungCap->delete();

        return response()->json([
            'status'    => true,
            'message'   => 'Đã xóa thành công nhà cung cấp!',
        ]);
    }

    public function statusNhaCungCap(Request $request)
    {
        $id_chuc_nang   =   29;

        $user_login     =   Auth::guard('admin')->user();

        $check = $this->checkQuyen($id_chuc_nang, $user_login->id_quyen);

        if(!$check) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không có quyền cho chức năng này!',
            ]);
        }
        $nhaCungCap = NhaCungCap::find($request->id);

        if ($nhaCungCap) {
            $nhaCungCap->trang_thai = !$nhaCungCap->trang_thai;
            $nhaCungCap->save();
            return response()->json([
                'status'    => true,
                'message'   => 'Đã đổi trạng thái thành công!'
            ]);
        } else {
            return response()->json([
                'status'    => false,
                'message'   => 'Nhà cung cấp không tồn tại!'
            ]);
        }
    }

    public function getDataNguyenLieu($id)
    {
        $check = NhaCungCap::find($id);
        if ($check) {
            $list = explode('|', $check->list_id_nguyen_lieu);
            $data = NguyenLieu::all();
            foreach ($data as $value) {
                if (in_array($value->id, $list)) {
                    $value->choose = true;
                } else {
                    $value->choose = false;
                }
            }
            return response()->json([
                'status'    => 1,
                'data'   => $data,
            ]);
        }
        return response()->json([
            'status'    => 0,
            'message'   => "Nhà cung cấp không tồn tại",
        ]);
    }
}
