<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileAdminRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name'        =>  'required|min:2',
            'so_dien_thoai'     =>  'required|digits:10',
        ];
    }

    public function messages()
    {
        return [
            'first_name.*'          =>  'Họ lót phải từ 2 ký tự trở lên',
            'so_dien_thoai.*'       =>  'Số điện thoại phải 10 chữ số',
        ];
    }
}
