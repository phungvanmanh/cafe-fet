<?php

namespace App\Http\Requests\Blog;

use Illuminate\Foundation\Http\FormRequest;

class DeleteBlogRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id' => 'required|exists:blogs,id'
        ];
    }

    public function messages()
    {
        return [
            'id.*'      => 'Blog không tồn tại!'
        ];
    }
}
