<?php

namespace App\Http\Requests\DonVi;

use Illuminate\Foundation\Http\FormRequest;

class CreateDonViRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'ten_don_vi'  => 'required',
            'slug_don_vi' => 'required|unique:don_vis,slug_don_vi'
        ];
    }

    public function messages()
    {
        return [
            'ten_don_vi.required'  => 'Tên đơn vị không được bỏ trống',
            'slug_don_vi.required'  => 'Slug đơn vị không được bỏ trống',
            'slug_don_vi.unique'    => 'Đơn vị này đã có'
        ];
    }
}