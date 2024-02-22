<?php

namespace App\Http\Requests\KhachHang;

use Illuminate\Foundation\Http\FormRequest;

class UpdateKhachHangRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id'                    => 'required|exists:khach_hangs,id',
            'last_name'             => 'required',
            'first_name'            => 'nullable',
            'so_dien_thoai'         => 'required|numeric',
            'email'                 => 'required|email',
            'dia_chi'               => 'required',
        ];
    }

    public function messages()
    {
        return [
            'id'                            => 'Tài khoản không tồn tại!',
            'last_name.*'                   => 'Tên khách không được để trống!',
            'so_dien_thoai.required'        => 'Số điện thoại không được để trống!',
            'so_dien_thoai.between'         => 'Số điện thoại phải đủ 10 số!',
            'so_dien_thoai.numeric'         => 'Số điện thoại phải là số!',
            'so_dien_thoai.unique'          => 'Số điện thoại đã tồn tại!',
            'email.*'                       => 'Email không được để trống!',
            'email.email'                   => 'Email phải đúng định dạng!',
            'email.unique'                  => 'Email đã tồn tại!',
            'dia_chi.required'              => 'Địa chỉ không được để trống!',
            'dia_chi.min'                   => 'Địa chỉ phải từ 5 ký tự trở lên!',
        ];
    }
}
