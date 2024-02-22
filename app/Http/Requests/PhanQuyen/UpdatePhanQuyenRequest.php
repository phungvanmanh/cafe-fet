<?php

namespace App\Http\Requests\PhanQuyen;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePhanQuyenRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id'            => 'required|exists:phan_quyens,id',
            'ten_quyen'     => 'required|unique:phan_quyens,ten_quyen,' . $this->id,
            'tinh_trang'    => 'required|numeric|between:0,1'
        ];
    }

    public function messages()
    {
        return [
            'id.*'                  => 'Phân quyền này không tồn tại!',
            'ten_quyen.required'    => 'Tên quyền không được bỏ trống!',
            'ten_quyen.unique'      => 'Tên quyền đã tồn tại!',
            'tinh_trang.*'          => 'Vui lòng chọn tình trạng đúng theo yêu cầu'
        ];
    }
}
