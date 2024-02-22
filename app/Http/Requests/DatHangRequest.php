<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DatHangRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'dia_chi'           => 'required|min:6',
            'ten_nguoi_nhan'    => 'required|min:6',
            'email'             => 'required|email',
            'so_dien_thoai'     => 'required|digits:10|numeric'
        ];
    }

    public function messages()
    {
        return [
            'dia_chi.required'              => 'Địa chỉ không được bỏ trống!',
            'dia_chi.min'                   => 'Địa chỉ phải từ 6 ký tự trở lên!',
            'ten_nguoi_nhan.required'       => 'Tên người nhận không được bỏ trống!',
            'ten_nguoi_nhan.min'            => 'Tên người nhận phải từ 6 ký tự trở lên!',
            'email.required'                => 'Email không được bỏ trống!',
            'email.email'                   => 'Email phải đúng định dạng!',
            'so_dien_thoai.required'        => 'Số điện thoại không được bỏ trống!',
            'so_dien_thoai.digits'          => 'Số điện thoại phải là 10 số!',
            'so_dien_thoai.numeric'         => 'Số điện thoại phải là số!'
        ];
    }
}
