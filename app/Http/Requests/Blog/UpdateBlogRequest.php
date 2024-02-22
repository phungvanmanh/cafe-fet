<?php

namespace App\Http\Requests\Blog;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBlogRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'tieu_de'           => 'required|min:10',
            'slug'              => 'unique:blogs,slug,' . $this->id,
            'mo_ta_ngan'        => 'required|min:20',
            'mo_ta_chi_tiet'    => 'required|min:50',
            'tinh_trang'        => 'required|numeric|between:0,1',
        ];
    }

    public function messages()
    {
        return [
            'tieu_de.*'           => 'Tiêu đề phải dài hơn 10 ký tự!',
            'slug.*'              => 'Tiêu đề này đã tồn tại!',
            'mo_ta_ngan.*'        => 'Mô tả ngắn phải dài hơn 20 ký tự!',
            'mo_ta_chi_tiet.*'    => 'Mô tả ngắn phải dài hơn 50 ký tự!',
            'tinh_trang'          => 'Vui lòng nhập theo đúng yêu cầu!',
        ];
    }
}
