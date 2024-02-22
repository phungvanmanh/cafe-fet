<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\DeleteAdminRequest;
use App\Http\Requests\Admin\DoiTrangThaiAdminRequest;
use App\Http\Requests\Admin\UpdateAdminRequest as AdminUpdateAdminRequest;
use App\Http\Requests\Admin\UpdatePasswordRequest;
use App\Http\Requests\Admin\UpdateProfileAdminRequest;
use App\Http\Requests\CreateAdminRequest;
use App\Http\Requests\updateAdminRequest;
use App\Models\Admin;
use App\Models\PhanQuyen;
use App\Models\Quyen;
use App\Models\QuyenChucNang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mockery\Undefined;

class AdminController extends Controller
{
    public function index()
    {
        $id_chuc_nang   =   6;

        $user_login     =   Auth::guard('admin')->user();

        $check = $this->checkQuyen($id_chuc_nang, $user_login->id_quyen);

        if (!$check) {
            if (!$check) {
                toastr()->error("Bạn không đủ quyền truy cập!");
                return redirect()->back();
            }
        }

        return view('admin.page.admin.index');
    }

    public function index_profile()
    {
        return view('admin.page.profile.index');
    }

    public function getProfile()
    {
        $admin = Auth::guard('admin')->user();

        return response()->json([
            'status'    => 1,
            'data'      => $admin,    //res.data.data
        ]);
    }

    public function updateProfile(UpdateProfileAdminRequest $request)
    {
        $admin_login = Auth::guard('admin')->user();

        Admin::where('id', $admin_login->id)
            ->update([
                'first_name'        =>  $request->first_name,
                'last_name'         =>  $request->last_name,
                'so_dien_thoai'     =>  $request->so_dien_thoai,
                'dia_chi'           =>  $request->dia_chi,
            ]);

        return response()->json([
            'status'    => 1,
            'message'   => 'Đã cập nhật thông tin thành công',
        ]);
    }

    public function viewLogin()
    {
        return view('admin.page.login');
    }

    public function actionLogin(Request $request)
    {
        $check =  Auth::guard('admin')->attempt([
            'email'     => $request->email,
            'password'  => $request->password
        ]);

        if ($check) {
            toastr()->success("Đã đăng nhập thành công!");
            return redirect('/admin');
        } else {
            toastr()->error("Tài khoản hoặc mật khẩu không đúng!");
            return redirect('/admin/login');
        }
    }

    public function actionLogout()
    {
        Auth::guard('admin')->logout();
        toastr()->success("Tài khoản đã đăng xuất!");
        return redirect('/admin/login');
    }

    public function viewLostPass()
    {
        return view('admin.page.lost_password');
    }

    public function getDataAdmin()
    {
        $id_chuc_nang   =   2;
        $user_login     =   Auth::guard('admin')->user();
        $check = $this->checkQuyen($id_chuc_nang, $user_login->id_quyen);
        if (!$check) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không có quyền cho chức năng này!',
            ]);
        }
        $data = Admin::leftjoin('phan_quyens', 'admins.id_quyen', 'phan_quyens.id')
            ->select('admins.*', 'phan_quyens.ten_quyen')
            ->get();
        return response()->json([
            'status'    => 1,
            'data'      => $data,
        ]);
    }

    public function getDataQuyen()
    {

        $data = PhanQuyen::where('tinh_trang', 1)->get();

        return response()->json([
            'status'    => 1,
            'data'      => $data,
        ]);
    }

    public function createAdmin(Request $request)
    {
        $id_chuc_nang   =   1;

        $user_login     =   Auth::guard('admin')->user();

        $check = $this->checkQuyen($id_chuc_nang, $user_login->id_quyen);

        if (!$check) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không có quyền cho chức năng này!',
            ]);
        }

        $data = $request->all();
        $data['password'] =  bcrypt($request->password);
        $data['full_name'] = rtrim($data['first_name'], " ") . ' ' . ltrim($data['last_name'], " ");

        if (isset($data['avatar'])) {
            $file = $request->file('avatar');
            $avatar = $this->getLinkUpdateAVT('image-admin', $file);
            $data['avatar'] = $avatar;
        }

        Admin::create($data);

        return response()->json([
            'status'    => 1,
            'message'   => 'Đã thêm mới thành công!',
        ]);
    }

    public function updateAdmin(AdminUpdateAdminRequest $request)
    {
        $id_chuc_nang   =   3;

        $user_login     =   Auth::guard('admin')->user();

        $check = $this->checkQuyen($id_chuc_nang, $user_login->id_quyen);

        if (!$check) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không có quyền cho chức năng này!',
            ]);
        }

        $admin = Admin::find($request->id);
        if ($admin) {
            $data = $request->all();
            if ($data['last_name'] != null) {
                $data['full_name']  = rtrim($data['first_name'], " ") . ' ' . ltrim($data['last_name'], " ");
            } else {
                $data['full_name']  = rtrim($data['first_name'], " ");
            }

            $admin->update($data);

            return response()->json([
                'status'    => 1,
                'message'   => 'Đã cập nhật thành công!',
            ]);
        } else {
            return response()->json([
                'status'    => 0,
                'message'   => 'Admin không tồn tại trong hệ thống!',
            ]);
        }
    }

    public function updateAvatar(Request $request)
    {
        $admin = Admin::find($request->id);
        if ($admin) {
            $data = $request->all();
            if ($data['avatar'] != null) {
                $file = $request->file('avatar');
                $avatar = $this->getLinkUpdateAVT('image-admin-update', $file);
                $data['avatar'] = $avatar;
            } else {
                $data['avatar'] = $admin->avatar;
            }

            if ($data['last_name'] == null) {
                $data['last_name'] = "";
            }

            $admin->update($data);
            return response()->json([
                'status'    => 1,
                'message'   => 'Đã cập nhật ảnh thành công!',
            ]);
        }

        return response()->json([
            'status'    => 0,
            'message'   => 'Tài khoản không tồn tại!',
        ]);
    }

    public function deleteAdmin(DeleteAdminRequest $request)
    {
        $id_chuc_nang   =   3;

        $user_login     =   Auth::guard('admin')->user();

        $check = $this->checkQuyen($id_chuc_nang, $user_login->id_quyen);

        if (!$check) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không có quyền cho chức năng này!',
            ]);
        }

        $admin = Admin::find($request->id);
        if ($admin) {
            $admin->delete();

            return response()->json([
                'status'    => 1,
                'message'   => 'Đã xóa thành công!',
            ]);
        } else {
            return response()->json([
                'status'    => 0,
                'message'   => 'Admin không tồn tại trong hệ thống!',
            ]);
        }
    }

    public function statusAdmin(DoiTrangThaiAdminRequest $request)
    {
        $admin = Admin::find($request->id);
        if ($admin) {
            $admin->trang_thai = !$admin->trang_thai;
            $admin->save();

            return response()->json([
                'status'    => 1,
                'message'   => 'Đã thay đổi trạng thái thành công!',
            ]);
        } else {
            return response()->json([
                'status'    => 0,
                'message'   => 'Admin không tồn tại trong hệ thống!',
            ]);
        }
    }

    public function updatePasswordAdmin(UpdatePasswordRequest $request)
    {
        $admin = Admin::find($request->id);
        if ($admin) {
            $data = $request->all();
            $data['password'] = bcrypt($data['password_new']);
            $admin->password  = $data['password'];
            $admin->save();
            return response()->json([
                'status'    => 1,
                'message'   => 'Đã đổi mật khẩu thành công!',
            ]);
        }
    }
}
