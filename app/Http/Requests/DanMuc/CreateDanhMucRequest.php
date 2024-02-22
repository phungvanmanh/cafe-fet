<?php

namespace App\Http\Requests\DanMuc;

use Illuminate\Foundation\Http\FormRequest;

class CreateDanhMucRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'ten_danh_muc'      => 'required',
            'slug_danh_muc'     => 'required|unique:danh_mucs,slug_danh_muc',
            // 'id_danh_muc_cha'   => 'required|exists:danh_mucs,id',
            'trang_thai'        => 'required|numeric|between:0,1'
        ];
    }

    public function messages()
    {
        return [
            'ten_danh_muc.*'            => 'Tên danh mục không được bỏ trống!',
            'slug_danh_muc.unique'      => 'Tên danh mục đã tồn tại!',
            // 'id_danh_muc_cha.*'         => 'Danh mục này không tồn tại!',
            'trang_thai.*'              => 'Vui lòng chọn tình trạng đúng theo yêu cầu'
        ];
    }
}