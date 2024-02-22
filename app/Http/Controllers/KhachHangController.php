<?php

namespace App\Http\Controllers;

use App\Http\Requests\createRegisterRequest;
use App\Http\Requests\DatHangRequest;
use App\Http\Requests\KhachHang\CreateKhachHangRequest;
use App\Http\Requests\KhachHang\DeleteKhachHangRequest;
use App\Http\Requests\KhachHang\UpdateKhachHangRequest;
use App\Http\Requests\KhachHang\UpdatePasswordRequest;
use App\Mail\sendMail;
use App\Models\Blog;
use App\Models\DonHang;
use App\Models\GioHang;
use App\Models\KhachHang;
use App\Models\SanPham;
use App\Models\SuKienThuCung;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class KhachHangController extends Controller
{
    public function index()
    {
        $id_chuc_nang   =   7;

        $user_login     =   Auth::guard('admin')->user();

        $check = $this->checkQuyen($id_chuc_nang, $user_login->id_quyen);

        if (!$check) {
            if (!$check) {
                toastr()->error("Bạn không đủ quyền truy cập!");
                return redirect()->back();
            }
        }

        return view('admin.page.khachHang.index');
    }

    public function indexSuKien()
    {
        return view('client.page.su_kien');
    }

    public function indexClient()
    {
        $data = SanPham::where('trang_thai', 1)->get();
        return view('client.page.hompage', compact('data'));
    }

    public function indexLoginRegister()
    {
        return view('client.page.login_register');
    }

    public function indexContact()
    {
        return view('client.page.contact');
    }

    public function indexBlog()
    {
        return view('client.page.blog');
    }

    public function indexMyAccount()
    {
        return view('client.page.my_account');
    }

    public function indexShop()
    {
        return view('client.page.shop');
    }

    public function indexCart()
    {
        return view('client.page.cart');
    }

    public function indexCheckout()
    {
        return view('client.page.checkout');
    }

    public function indexSingleProduct($id)
    {
        return view('client.page.single_product');
    }

    public function createRegister(Request $request)
    {
        $data = $request->all();
        if (isset($data['first_name'])) {
            $data['full_name'] = $data['first_name'] . " " . $data['last_name'];
        } else {
            $data['full_name'] = $data['first_name'];
        }

        $data['password'] = bcrypt($data['password']);
        $data['hash_active'] = Str::uuid();
        //gửi email
        $xxx['ho_va_ten']       =   $request->ho_va_ten;
        $xxx['link']            =   'http://127.0.0.1:8000/kich-hoat-tai-khoan/' . $data['hash_active'];

        Mail::to($request->email)->send(new sendMail('Kích Hoạt Tài Khoản', 'mail.kich_hoat', $xxx));

        if ($data['avatar'] != null) {
            $file = $request->file('avatar');
            $avatar = $this->getLinkUpdateAVT('image-client', $file);
            $data['avatar'] = $avatar;
        }

        KhachHang::create($data);

        return response()->json([
            'status'    => true,
            'message'   => 'Đã tạo mới thành công!',
        ]);
    }

    public function actionLoginClient(Request $request)
    {
        $check  = Auth::guard('khach_hang')->attempt(['email' => $request->email, 'password' => $request->password]);
        if ($check) {
            $khachHang = KhachHang::where('email', $request->email)->first();
            if ($khachHang->trang_thai == 1) {
                return response()->json([
                    'status'    => 1,
                    'message'   => 'Đã đăng nhập thành công!',
                ]);
                return redirect('/admin/lich-lam-viec/dang-ky');
            } else if ($khachHang->trang_thai == 0) {
                Auth::guard('khach_hang')->logout();
                return response()->json([
                    'status'    => 2,
                    'message'   => 'Tài khoản chưa kích hoạt!',
                ]);
            } else {
                Auth::guard('khach_hang')->logout();
                return response()->json([
                    'status'    => 0,
                    'message'   => 'Tài khoản đã bị khóa!',
                ]);
            }
        } else {
            return response()->json([
                'status'    => 0,
                'message'   => 'Tài khoản hoặc mật khẩu không đúng!',
            ]);
        }
    }

    public function getDataShopAll(Request $request)
    {
        $data = SanPham::where('trang_thai', 1)->get();

        return response()->json([
            'data'   => $data,
        ]);
    }

    public function getDataSingleProduct(Request $request)
    {
        $data = SanPham::where('id', $request->id)->first();

        // Sản Phẩm Liên quan cùng danh mục
        $list =  SanPham::where('id_danh_muc', $data->id_danh_muc)->get();

        return response()->json([
            'data'      => $data,
            'list'      => $list
        ]);
    }

    public function getDataBlog(Request $request)
    {
        $data = Blog::get();
        return response()->json([
            'data'   => $data,
        ]);
    }

    public function actionLogout()
    {
        Auth::guard('khach_hang')->logout();
        toastr()->success("Tài khoản đã đăng xuất!");
        return redirect('/');
    }

    public function createKhachHang(CreateKhachHangRequest $request)
    {
        $data = $request->all();
        if (isset($data['first_name'])) {
            $data['full_name'] = $data['first_name'] . " " . $data['last_name'];
        } else {
            $data['full_name'] = $data['first_name'];
        }
        $data['password'] = bcrypt($data['password']);
        if ($data['avatar'] != null) {
            $file = $request->file('avatar');
            $avatar = $this->getLinkUpdateAVT('image-admin', $file);
            $data['avatar'] = $avatar;
        }
        KhachHang::create($data);

        return response()->json([
            'status'    => true,
            'message'   => 'Đã tạo mới thành công!',
        ]);
    }

    public function getDataKhachHang()
    {

        $id_chuc_nang   =   8;

        $user_login     =   Auth::guard('admin')->user();

        $check = $this->checkQuyen($id_chuc_nang, $user_login->id_quyen);

        if (!$check) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không có quyền cho chức năng này!',
            ]);
        }
        $khachHang = KhachHang::get();

        return response()->json([
            'status'   => 1,
            'data'    => $khachHang,
        ]);
    }

    public function updateKhachHang(UpdateKhachHangRequest $request)
    {
        $id_chuc_nang   =   10;

        $user_login     =   Auth::guard('admin')->user();

        $check = $this->checkQuyen($id_chuc_nang, $user_login->id_quyen);

        if (!$check) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không có quyền cho chức năng này!',
            ]);
        }
        $khachHang = KhachHang::find($request->id);
        if ($khachHang) {
            $data = $request->all();
            if (isset($data['first_name'])) {
                $data['full_name'] = $data['first_name'] . " " . $data['last_name'];
            } else {
                $data['full_name'] = $data['first_name'];
            }
            $khachHang->update($data);
            return response()->json([
                'status'        => 1,
                'message'       => 'Đã cập nhật khách hàng thành công',
            ]);
        }
    }

    public function updateClient(Request $request)
    {
        $khachHang = KhachHang::find($request->id);
        if ($khachHang) {
            $data = $request->all();
            if (isset($data['first_name'])) {
                $data['full_name'] = $data['first_name'] . " " . $data['last_name'];
            } else {
                $data['full_name'] = $data['first_name'];
            }
            if (isset($data['password_new'])) {
                $data['password'] =  $khachHang->password;
            } else {
                $data['password'] = bcrypt($data['password_new']);
                $khachHang->password  = $data['password'];
            }

            $khachHang->update($data);
            return response()->json([
                'status'        => 1,
                'message'       => 'Đã cập nhật khách hàng thành công',
            ]);
        }
    }

    public function updateAvatar(Request $request)
    {
        $id_chuc_nang   =   10;

        $user_login     =   Auth::guard('admin')->user();

        $check = $this->checkQuyen($id_chuc_nang, $user_login->id_quyen);

        if (!$check) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không có quyền cho chức năng này!',
            ]);
        }
        $admin = KhachHang::find($request->id);
        if ($admin) {
            $data = $request->all();
            if ($data['avatar'] != null) {
                $file = $request->file('avatar');
                $avatar = $this->getLinkUpdateAVT('image-khach-hang-update', $file);
                $data['avatar'] = $avatar;
            } else {
                return response()->json([
                    'status'    => 0,
                    'message'   => 'Đã gặp lỗi gì đó với hình ảnh!',
                ]);
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

    public function deleteKhachHang(DeleteKhachHangRequest $request)
    {
        $id_chuc_nang   =   11;

        $user_login     =   Auth::guard('admin')->user();

        $check = $this->checkQuyen($id_chuc_nang, $user_login->id_quyen);

        if (!$check) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không có quyền cho chức năng này!',
            ]);
        }
        $khachHang = KhachHang::find($request->id);
        $khachHang->delete();
        return response()->json([
            'status'        => 1,
            'message'       => 'Đã xóa khách hàng thành công',
        ]);
    }

    public function searchDataKhachHang(Request $request)
    {
        $id_chuc_nang   =   9;

        $user_login     =   Auth::guard('admin')->user();

        $check = $this->checkQuyen($id_chuc_nang, $user_login->id_quyen);

        if (!$check) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không có quyền cho chức năng này!',
            ]);
        }
        $list = KhachHang::where('khach_hangs.first_name', 'like', '%' . $request->key_search . '%')
            ->orWhere('khach_hangs.last_name', 'like', '%' . $request->key_search . '%')
            ->orWhere('khach_hangs.so_dien_thoai', 'like', '%' . $request->key_search . '%')
            ->orWhere('khach_hangs.email', 'like', '%' . $request->key_search . '%')
            ->get();

        return response()->json([
            'list'  => $list
        ]);
    }

    public function statusKhachHang(Request $request)
    {
        $id_chuc_nang   =   12;

        $user_login     =   Auth::guard('admin')->user();

        $check = $this->checkQuyen($id_chuc_nang, $user_login->id_quyen);

        if (!$check) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không có quyền cho chức năng này!',
            ]);
        }
        $khachHang = KhachHang::find($request->id);
        if ($khachHang) {
            if ($khachHang->trang_thai == 0) {
                $khachHang->trang_thai = 1;
            } else if ($khachHang->trang_thai == 1) {
                $khachHang->trang_thai = 2;
            } else {
                $khachHang->trang_thai = 0;
            }

            $khachHang->save();

            return response()->json([
                'status'    => 1,
                'message'      => 'Đã đổi trạng thái thành công!'
            ]);
        } else {
            return response()->json([
                'status'    => 0,
                'message'   => 'Khách hàng không tồn tại trong hệ thống!',
            ]);
        }
    }

    public function updatePasswordClient(UpdatePasswordRequest $request)
    {
        $id_chuc_nang   =   10;

        $user_login     =   Auth::guard('admin')->user();

        $check = $this->checkQuyen($id_chuc_nang, $user_login->id_quyen);

        if (!$check) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không có quyền cho chức năng này!',
            ]);
        }
        $khachHang = KhachHang::find($request->id);
        if ($khachHang) {
            $data = $request->all();
            $data['password'] = bcrypt($data['password_new']);
            $khachHang->password  = $data['password'];
            $khachHang->save();

            return response()->json([
                'status'    => 1,
                'message'   => 'Đã đổi mật khẩu thành công!',
            ]);
        } else {
            return response()->json([
                'status'    => 0,
                'message'   => 'Khách hàng không tồn tại trong hệ thống!',
            ]);
        }
    }

    public function indexSingleBlog()
    {
        return view('client.page.single_blog');
    }

    public function kichHoat($id)
    {
        $taiKhoan   = KhachHang::where('hash_active', $id)->first();
        if ($taiKhoan) {
            $taiKhoan->trang_thai   =   1;
            $taiKhoan->hash_active  =   null;
            $taiKhoan->save();

            toastr()->success('Đã kích hoạt tài khoản thành công!');
            return redirect('/login-register');
        } else {
            toastr()->error("Tài khoản không tồn tại!");
            return redirect('/');
        }
    }

    public function viewDoiMatKhau($id)
    {
        $taiKhoan   =   KhachHang::where('hash_reset', $id)->first();
        if ($taiKhoan) {
            return view('client.password.change_password', compact('id'));
        } else {
            toastr()->error('Liên kết không tồn tại!');
            return redirect('/');
        }
    }

    public function viewResetPassword()
    {
        return view('client.password.forgot_password');
    }

    public function resetPassword(Request $request)
    {
        $taiKhoan   = KhachHang::where('email', $request->email)->first();

        if ($taiKhoan) {
            $taiKhoan->hash_reset  =   Str::uuid();
            $taiKhoan->save();

            $data['ho_va_ten']          =   $taiKhoan->ho_va_ten;
            $data['link']               =   'http://127.0.0.1:8000/doi-mat-khau/' . $taiKhoan->hash_reset;

            Mail::to($taiKhoan->email)->send(new sendMail('Khôi Phục Mật Khẩu', 'mail.quen_mat_khau', $data));

            return response()->json([
                'status'    => 1,
                'message'   => 'Vui lòng kiểm tra email của bạn!',
            ]);
        } else {
            return response()->json([
                'status'    => 0,
                'message'   => 'Email không tồn tại!',
            ]);
        }
    }

    public function doiMatKhau(Request $request)
    {

        $taiKhoan   = KhachHang::where('hash_reset', $request->id)->first();
        if ($taiKhoan) {
            $taiKhoan->password         =   bcrypt($request->password);
            $taiKhoan->hash_reset       =   null;
            $taiKhoan->save();

            return response()->json([
                'status'    => 1,
                'message'   => 'Đã đổi mật khẩu thành công!',
            ]);
        } else {
            return response()->json([
                'status'    => 0,
                'message'   => 'Liên kết không tồn tại!',
            ]);
        }
    }

    public function datHang(DatHangRequest $request)
    {
        $nguoi_login    =   Auth::guard('khach_hang')->user();
        if ($nguoi_login) {
            $donHang = DonHang::create([
                'id_khach_hang'     =>  $nguoi_login->id,
                'dia_chi'           =>  $request->dia_chi,
                'ten_nguoi_nhan'    =>  $request->ten_nguoi_nhan,
                'email'             =>  $request->email,
                'so_dien_thoai'     =>  $request->so_dien_thoai
            ]);
            $donHang->ma_don_hang   =   "HD" . 140823 + $donHang->id;
            $donHang->tong_tien     =   $request->tong_tien;
            $donHang->save();
            foreach ($request->ds_sp as $key => $value) {
                $gio_hang = GioHang::find($value['id']);
                $gio_hang->id_don_hang  = $donHang->id;
                $gio_hang->tinh_trang   = \App\Models\GioHang::DANG_CHO_THANH_TOAN;
                $gio_hang->save();
            }

            $xxx['ho_va_ten']           =  $nguoi_login->ho_va_ten;
            $xxx['ds_ve']               =  $request->ds_sp;
            $xxx['tong_tien']           =  $request->tong_tien;
            $xxx['noi_dung_ck']         =  'CFTC' . $donHang->ma_don_hang;

            // Mail::to($nguoi_login->email)->send(new sendMail('Thông Tin Đơn Hàng Cafe Thú Cưng', 'mail.dat_ve', $xxx));

            return response()->json([
                'status'    => 1,
                'message'   => 'Đã đặt đơn hàng thành công!',
                'don_hang'  => $donHang
            ]);
        } else {
            return response()->json([
                'status'    => 0,
                'message'   => 'Chức năng này yêu cầu phải đăng nhập',
            ]);
        }
    }

    public function getDataSuKien()
    {
        $data = SuKienThuCung::where('tinh_trang', 1)->get();
        return response()->json([
            'data'   => $data,
        ]);
    }

    public function createSuKien(Request $request)
    {
        $user_login = Auth::guard('khach_hang')->user();

        $su_kien = SuKienThuCung::where('id', $request->id)->first();
        $doDaiChuoi = strlen($su_kien->list_id_client) - 1;

        if ($su_kien->list_id_client == null) {
            if ($doDaiChuoi == -1 || $doDaiChuoi <= $su_kien->so_nguoi_tham_gia) {
                $su_kien->list_id_client = $user_login->id . ",";
                $su_kien->save();
                return response()->json([
                    'status'    => 1,
                    'message'   => 'Đã tham gia sự kiện thành công',
                ]);
            } else {
                return response()->json([
                    'status'    => 0,
                    'message'   => 'Sự kiện đã đủ thành viên!',
                ]);
            }
        } else if (strpos($su_kien->list_id_client, $user_login->id) == 0) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn đã tham gia sự kiện rồi!',
            ]);
        }
    }
    public function dataHang()
    {
        $user_login = Auth::guard('khach_hang')->user();
        $donHang = DonHang::where('id_khach_hang', $user_login->id)
            ->get();
        return response()->json([
            'data'   => $donHang,
        ]);
    }
    public function chiTietDonHang(Request $request)
    {
        $gioHang = GioHang::where('id_don_hang', $request->id)
                    ->join('san_phams','gio_hangs.id_san_pham','san_phams.id')
                    ->select('gio_hangs.*','san_phams.ten_san_pham','san_phams.hinh_anh')
                    ->get();
        return response()->json([
            'status'    => 1,
            'data'      => $gioHang,
        ]);
    }
    public function searchDonHang(Request $request){
        $search = '%' . $request->key_search . '%';
        $user_login = Auth::guard('khach_hang')->user();
        $donHang = DonHang::where('id_khach_hang', $user_login->id)
            ->Where('don_hangs.ma_don_hang','like',$search)
            ->orWhere('don_hangs.tong_tien','like',$search)
            ->get();
        return response()->json([
            'data'   => $donHang,
        ]);
    }

    public function checkLogin() {
        $user = Auth::guard('khach_hang')->check();
        if ($user) {
            return response()->json([
                'user'    => $user,
                'status'    => 200,
            ]);
        }
    }

    public function searchProduct(Request $request)
    {
        $key = "%" . $request->key . "%";
        $data = SanPham::where('trang_thai', 1)
                        ->where('ten_san_pham', 'like', $key)
                        ->get();
        return view('client.page.hompage', compact('data'));
    }
}
