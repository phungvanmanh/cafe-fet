<?php

namespace App\Http\Requests\NguyenLieu;

use Illuminate\Foundation\Http\FormRequest;

class CreateNguyenLieuRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'ten_nguyen_lieu'   => 'required',
            'slug_nguyen_lieu'  => 'required|unique:nguyen_lieus,slug_nguyen_lieu',
            'don_vi_tinh'       => 'required|exists:don_vis,id',
            'trang_thai'        => 'required|between:0,1',
        ];
    }

    public function messages()
    {
        return [
            'ten_nguyen_lieu.*'         => 'Tên nguyên liệu không được bỏ trống!',
            'slug_nguyen_lieu.required' => 'Slug nguyên liệu không được bỏ trống!',
            'slug_nguyen_lieu.unique'   => 'Nguyên liệu này đã có!',
            'don_vi_tinh.*'             => 'Vui lòng nhập đơn vị đúng yêu cầu!',
            'trang_thai.*'              => 'Vui lòng nhập trạng thái đúng yêu cầu!',
        ];
    }
}
