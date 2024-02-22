<?php

namespace App\Http\Requests\PhanQuyen;

use Illuminate\Foundation\Http\FormRequest;

class DeletePhanQuyenRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id' => 'required|exists:phan_quyens,id'
        ];
    }

    public function messages()
    {
        return [
            'id.*'  => 'Quyền này không tồn tại'
        ];
    }
}
