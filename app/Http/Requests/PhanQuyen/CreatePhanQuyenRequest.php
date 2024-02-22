<?php

namespace App\Http\Requests\PhanQuyen;

use Illuminate\Foundation\Http\FormRequest;

class CreatePhanQuyenRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'ten_quyen'     => 'required',
            'tinh_trang'    => 'required|numeric|between:0,1'
        ];
    }

    public function messages()
    {
        return [
            'ten_quyen.*'   => 'Tên quyền không được bỏ trống!',
            'tinh_trang.*'  => 'Vui lòng chọn tình trạng đúng theo yêu cầu'
        ];
    }
}
