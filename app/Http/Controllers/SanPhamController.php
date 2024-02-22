<?php

namespace App\Http\Controllers;

use App\Http\Requests\DanMuc\DoiTrangThaiSanPhamRequest;
use App\Http\Requests\SanPham\CreateSanPhamRequest;
use App\Http\Requests\SanPham\DeleteSanPhamRequest;
use App\Http\Requests\SanPham\UpdateSanPhamRequest;
use App\Models\DanhMuc;
use App\Models\SanPham;
use Illuminate\Http\Request;

class SanPhamController extends Controller
{
    public function index()
    {
        $danhMuc = DanhMuc::get();
        return view('admin.page.sanPham.index', compact('danhMuc'));
    }
    public function getDataSanPham()
    {
        $data = SanPham::join('danh_mucs', 'danh_mucs.id', 'san_phams.id_danh_muc')
            ->select('san_phams.*', 'danh_mucs.ten_danh_muc')
            ->get();

        return response()->json([
            'status'    => 1,
            'data'   => $data,
        ]);
    }
    public function createSanPham(Request $request)
    {
        $danh_muc = DanhMuc::find($request->id_danh_muc);
        if ($danh_muc) {
            $data = $request->all();
            if ($data['avatar'] != null) {
                $file = $request->file('avatar');
                $avatar = $this->getLinkUpdateAVT('image-san-pham', $file);
                $data['hinh_anh'] = $avatar;
            }
            SanPham::create($data);

            return response()->json([
                'status'    => 1,
                'message'   => 'Đã thêm mới thành công!',
            ]);
        } else {
            return response()->json([
                'status'    => 0,
                'message'   => 'Danh mục không tồn tại trong hệ thống!',
            ]);
        }
    }
    public function updateSanPham(UpdateSanPhamRequest $request)
    {
        $san_pham = SanPham::find($request->id);
        $danh_muc = DanhMuc::find($request->id_danh_muc);
        if ($san_pham && $danh_muc) {
            $data = $request->all();

            $san_pham->update($data);

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

    public function deleteSanPham(DeleteSanPhamRequest $request)
    {
        $san_pham = SanPham::find($request->id);
        if ($san_pham) {
            $san_pham->delete();

            return response()->json([
                'status'    => 1,
                'message'   => 'Đã xóa thành công!',
            ]);
        } else {
            return response()->json([
                'status'    => 0,
                'message'   => 'Sản phẩm không tồn tại trong hệ thống!',
            ]);
        }
    }

    public function statusSanPham(DoiTrangThaiSanPhamRequest $request)
    {
        $san_pham = SanPham::where('id', $request->id)->first();

        if ($san_pham) {
            $san_pham->trang_thai = !$san_pham->trang_thai;

            $san_pham->save();

            return response()->json([
                'status'    => 1,
                'message'      => 'Đã đổi trạng thái thành công!'
            ]);
        } else {
            return response()->json([
                'status'    => 0,
                'message'   => 'Sản phẩm không tồn tại trong hệ thống!',
            ]);
        }
    }

    public function updateAvatar(Request $request)
    {
        $san_pham = SanPham::find($request->id);
        if ($san_pham) {
            $data = $request->all();
            if ($data['avatar'] != null) {
                $file = $request->file('avatar');
                $avatar = $this->getLinkUpdateAVT('image-san-pham-update', $file);
                if ($avatar != false) {
                    $data['hinh_anh'] = $avatar;
                } else {
                    return response()->json([
                        'status'    => 0,
                        'message'   => 'Đã gặp lỗi gì đó với hình ảnh!',
                    ]);
                }
            }
            $san_pham->update($data);
            return response()->json([
                'status'    => 1,
                'message'   => 'Đã cập nhật ảnh thành công!',
            ]);
        }

        return response()->json([
            'status'    => 0,
            'message'   => 'Sản phẩm không tồn tại!',
        ]);
    }
}
