<?php

namespace App\Http\Requests\DonVi;

use Illuminate\Foundation\Http\FormRequest;

class DeleteDonViRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id' => 'required|exists:don_vis,id'
        ];
    }

    public function messages()
    {
        return [
            'id.*' => 'Đơn vị này chưa có'
        ];
    }
}
