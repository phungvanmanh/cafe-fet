<?php

namespace App\Http\Requests\KhachHang;

use Illuminate\Foundation\Http\FormRequest;

class CreateKhachHangRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'last_name'             => 'required',
            'first_name'            => 'nullable',
            'so_dien_thoai'         => 'required|digits_between:10,10|numeric|unique:khach_hangs',
            'email'                 => 'required|email|unique:khach_hangs',
            'dia_chi'               => 'required|min:5',
        ];
    }

    public function messages()
    {
        return [
            'last_name.*'                   => 'Tên khách không được để trống!',
            'so_dien_thoai.required'        => 'Số điện thoại không được để trống!',
            'so_dien_thoai.digits_between'  => 'Số điện thoại phải là 10 số!',
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
