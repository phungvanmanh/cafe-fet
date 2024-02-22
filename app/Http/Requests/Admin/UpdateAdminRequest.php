<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id'                => 'required|exists:admins,id',
            'first_name'        => 'min:2',
            'last_name'         => 'required|min:2',
            'trang_thai'        => 'required|numeric|between:0,1',
            'so_dien_thoai'     => 'required|between:10,15',
            'email'             => 'required|email|unique:admins,email,' . $this->id,
            'id_quyen'          => 'required|numeric|exists:phan_quyens,id',
        ];
    }

    public function messages()
    {
        return [
            'id.*'              => 'Tài khoản Admin không tồn tại!',
            'first_name.*'      => 'Họ tên lót ít nhất 2 ký tự!',
            'last_name.*'      => 'Tên ít nhất 2 ký tự!',
            'trang_thai.*'        => 'Vui lòng chọn trạng thái theo đúng yêu cầu!',
            'so_dien_thoai.*'     => 'Số điện thoại không hợp lệ!',
            'email.*'             => 'Địa chỉ Email không hợp lệ!',
            'id_quyen.*'          => 'Vui lòng chọn phân quyền theo đúng yêu cầu!',
        ];
    }
}
