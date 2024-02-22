<?php

namespace App\Http\Controllers;

use App\Http\Requests\Blog\DeleteBlogRequest;
use App\Http\Requests\Blog\DoiTrangThaiBlogRequest;
use App\Http\Requests\Blog\UpdateBlogRequest;
use App\Http\Requests\createBlogRequest;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    public function index()
    {
        $id_chuc_nang   =   13;

        $user_login     =   Auth::guard('admin')->user();

        $check = $this->checkQuyen($id_chuc_nang, $user_login->id_quyen);

        if (!$check) {
            if (!$check) {
                toastr()->error("Bạn không đủ quyền truy cập!");
                return redirect()->back();
            }
        }
        return view('admin.page.blog.index');
    }

    public function getDataBlog()
    {
        $id_chuc_nang   =   14;

        $user_login     =   Auth::guard('admin')->user();

        $check = $this->checkQuyen($id_chuc_nang, $user_login->id_quyen);

        if (!$check) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không có quyền cho chức năng này!',
            ]);
        }
        $data = Blog::get();

        return response()->json([
            'status'    => 1,
            'data'   => $data,
        ]);
    }

    public function createBlog(Request $request)
    {
        $id_chuc_nang   =   15;

        $user_login     =   Auth::guard('admin')->user();

        $check = $this->checkQuyen($id_chuc_nang, $user_login->id_quyen);

        if (!$check) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không có quyền cho chức năng này!',
            ]);
        }
        $data = $request->all();
        if ($data['avatar'] != null) {
            $file = $request->file('avatar');
            $avatar = $this->getLinkUpdateAVT('image-san-pham', $file);
            $data['hinh_anh'] = $avatar;
        }
        Blog::create($data);

        return response()->json([
            'status'    => 1,
            'message'   => 'Đã thêm mới thành công!',
        ]);
    }

    public function updateBlog(UpdateBlogRequest $request)
    {
        $id_chuc_nang   =   16;

        $user_login     =   Auth::guard('admin')->user();

        $check = $this->checkQuyen($id_chuc_nang, $user_login->id_quyen);

        if (!$check) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không có quyền cho chức năng này!',
            ]);
        }
        $blog = Blog::find($request->id);
        if ($blog) {
            $data = $request->all();
            // $data['hinh_anh'] = ''; //chưa viết
            $blog->update($data);

            return response()->json([
                'status'    => 1,
                'message'   => 'Đã cập nhật thành công!',
            ]);
        } else {
            return response()->json([
                'status'    => 0,
                'message'   => 'Blog không tồn tại trong hệ thống!',
            ]);
        }
    }

    public function deleteBlog(DeleteBlogRequest $request)
    {
        $id_chuc_nang   =   17;

        $user_login     =   Auth::guard('admin')->user();

        $check = $this->checkQuyen($id_chuc_nang, $user_login->id_quyen);

        if (!$check) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không có quyền cho chức năng này!',
            ]);
        }
        $blog = Blog::find($request->id);
        if ($blog) {
            $blog->delete();

            return response()->json([
                'status'    => 1,
                'message'   => 'Đã xóa thành công!',
            ]);
        } else {
            return response()->json([
                'status'    => 0,
                'message'   => 'Blog không tồn tại trong hệ thống!',
            ]);
        }
    }

    public function statusBlog(DoiTrangThaiBlogRequest $request)
    {
        $id_chuc_nang   =   18;

        $user_login     =   Auth::guard('admin')->user();

        $check = $this->checkQuyen($id_chuc_nang, $user_login->id_quyen);

        if (!$check) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không có quyền cho chức năng này!',
            ]);
        }
        $blog = Blog::find($request->id);
        if ($blog) {
            $blog->tinh_trang = !$blog->tinh_trang;
            $blog->save();

            return response()->json([
                'status'    => 1,
                'message'   => 'Đã thay đổi trạng thái thành công!',
            ]);
        } else {
            return response()->json([
                'status'    => 0,
                'message'   => 'Blog không tồn tại trong hệ thống!',
            ]);
        }
    }

    public function updateAvatar(Request $request)
    {
        $blog = Blog::find($request->id);
        if ($blog) {
            $data = $request->all();
            if ($data['avatar'] != null) {
                $file = $request->file('avatar');
                $avatar = $this->getLinkUpdateAVT('image-blog-update', $file);
                if ($avatar != false) {
                    $data['hinh_anh'] = $avatar;
                } else {
                    return response()->json([
                        'status'    => 0,
                        'message'   => 'Đã gặp lỗi gì đó với hình ảnh!',
                    ]);
                }
            }
            $blog->update($data);
            return response()->json([
                'status'    => 1,
                'message'   => 'Đã cập nhật ảnh thành công!',
            ]);
        }

        return response()->json([
            'status'    => 0,
            'message'   => 'Blog không tồn tại!',
        ]);
    }
}
