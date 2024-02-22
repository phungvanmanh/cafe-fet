<?php

namespace App\Http\Requests\DanMuc;

use Illuminate\Foundation\Http\FormRequest;

class DeleteDanhMucRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id' => 'required|exists:danh_mucs,id'
        ];
    }

    public function messages()
    {
        return [
            'id.*'  => 'Danh Mục này không tồn tại'
        ];
    }
}
