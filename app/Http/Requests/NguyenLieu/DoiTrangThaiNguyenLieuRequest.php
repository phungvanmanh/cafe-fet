<?php

namespace App\Http\Requests\NguyenLieu;

use Illuminate\Foundation\Http\FormRequest;

class DoiTrangThaiNguyenLieuRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id' => 'required|exists:nguyen_lieus,id'
        ];
    }

    public function messages()
    {
        return [
            'id.*' => 'Nguyên liệu này chưa có'
        ];
    }
}
