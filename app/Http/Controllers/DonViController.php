<?php

namespace App\Http\Controllers;

use App\Http\Requests\DonVi\CreateDonViRequest;
use App\Http\Requests\DonVi\DeleteDonViRequest;
use App\Http\Requests\DonVi\UpdateDonViRequest;
use App\Models\DonVi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DonViController extends Controller
{
    public function index()
    {
        $id_chuc_nang   =   31;

        $user_login     =   Auth::guard('admin')->user();

        $check = $this->checkQuyen($id_chuc_nang, $user_login->id_quyen);

        if(!$check) {
            if(!$check) {
                toastr()->error("Bạn không đủ quyền truy cập!");
                return redirect()->back();
            }
        }
        return view('admin.page.donVi.index');
    }

    public function createDonVi(CreateDonViRequest $request)
    {
        $id_chuc_nang   =   33;

        $user_login     =   Auth::guard('admin')->user();

        $check = $this->checkQuyen($id_chuc_nang, $user_login->id_quyen);

        if(!$check) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không có quyền cho chức năng này!',
            ]);
        }
        $data = $request->all();
        DonVi::create($data);

        return response()->json([
            'status'    => 1,
        ]);
    }

    public function dataDonVi()
    {
        $id_chuc_nang   =   32;

        $user_login     =   Auth::guard('admin')->user();

        $check = $this->checkQuyen($id_chuc_nang, $user_login->id_quyen);

        if(!$check) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không có quyền cho chức năng này!',
            ]);
        }
        $data = DonVi::get();

        return response()->json([
            'data'    => $data,
        ]);
    }

    public function updateDonVi(UpdateDonViRequest $request)
    {
        $id_chuc_nang   =   34;

        $user_login     =   Auth::guard('admin')->user();

        $check = $this->checkQuyen($id_chuc_nang, $user_login->id_quyen);

        if(!$check) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không có quyền cho chức năng này!',
            ]);
        }
        $data = $request->all();

        DonVi::find($request->id)->update($data);

        return response()->json([
            'status'    => 1,
        ]);
    }

    public function deleteDonVi(DeleteDonViRequest $request)
    {
        $id_chuc_nang   =   35;

        $user_login     =   Auth::guard('admin')->user();

        $check = $this->checkQuyen($id_chuc_nang, $user_login->id_quyen);

        if(!$check) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không có quyền cho chức năng này!',
            ]);
        }
        DonVi::find($request->id)->delete();

        return response()->json([
            'status' => 1
        ]);
    }
}
