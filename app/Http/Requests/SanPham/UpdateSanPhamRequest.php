<?php

namespace App\Http\Requests\SanPham;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSanPhamRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'ten_san_pham'      => 'required',
            'slug_san_pham'     => 'unique:san_phams,slug_san_pham',
            'trang_thai'        => 'required|numeric|between:0,1',
            'so_luong'          => 'required|min:1',
            'id_danh_muc'       => 'required|exists:danh_mucs,id'
        ];
    }

    public function messages()
    {
        return [
            'ten_san_pham.*'            => 'Tên sản phẩm không được bỏ trống!',
            'slug_san_pham.unique'      => 'Tên sản phẩm đã tồn tại!',
            'trang_thai.*'              => 'Vui lòng chọn tình trạng đúng theo yêu cầu',
            'so_luong.*'                => 'Số lượng ít nhất phải là 1',
            'id_danh_muc'               => 'Danh mục không tồn tại!'
        ];
    }
}
