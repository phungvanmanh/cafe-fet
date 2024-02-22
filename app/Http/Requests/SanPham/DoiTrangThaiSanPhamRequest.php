<?php

namespace App\Http\Requests\DanMuc;

use Illuminate\Foundation\Http\FormRequest;

class DoiTrangThaiSanPhamRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id' => 'required|exists:san_phams,id'
        ];
    }

    public function messages()
    {
        return [
            'id.*'  => 'Sản phẩm này không tồn tại!'
        ];
    }
}
