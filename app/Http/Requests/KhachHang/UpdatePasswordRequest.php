<?php

namespace App\Http\Requests\KhachHang;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id'                => 'required|exists:khach_hangs,id',
            'password_new'      => 'required|min:6',
            're_password'       => 'same:password_new',
        ];
    }

    public function messages()
    {
        return [
            'id.*'                    =>  'Tài khoản không tồn tại!',
            'password_new.required'   =>  'Mật khẩu không được để trống!',
            'password_new.min'        =>  'Mật khẩu phải từ 6 ký tự!',
            're_password.same'        =>  'Mật khẩu không trùng khớp!',
        ];
    }
}
