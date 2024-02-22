<?php

namespace App\Http\Requests\NhaCungCap;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNhaCungCapRequest extends FormRequest
{
    public function rules()
    {
        return [
            'nhaCungCap.id'                    =>  'required|exists:nha_cung_caps,id',
            'nhaCungCap.ma_so_thue'            =>  'nullable|unique:nha_cung_caps,ma_so_thue,' . $this->id,
            'nhaCungCap.ten_doanh_nghiep'      =>  'required',
            'nhaCungCap.ten_nguoi_dai_dien'    =>  'required',
            'nhaCungCap.so_dien_thoai'         =>  'required|digits:10',
            'nhaCungCap.email'                 =>  'required|email',
            'nhaCungCap.dia_chi'               =>  'nullable',
            'nhaCungCap.trang_thai'            =>  'boolean',

        ];
    }

    public function messages()
    {
        return [
            'nhaCungCap.id.*'                          => 'Nhà cung cấp không tồn tại!',
            'nhaCungCap.ma_so_thue.*'                  => 'Mã số thuế đã tồn tại trong hệ thống!',
            'nhaCungCap.ten_doanh_nghiep.required'     => 'Tên doanh nghiệp không được để trống!',
            'nhaCungCap.ten_nguoi_dai_dien.required'   => 'Tên người đại điện không được để trống!',
            'nhaCungCap.so_dien_thoai.required'        => 'Số điện thoại không được để trống!',
            'nhaCungCap.so_dien_thoai.digits'          => 'Số điện thoại phải là 10 số!',
            'nhaCungCap.email.required'                => 'Email không được để trống!',
            'nhaCungCap.email.email'                   => 'Email phải đúng định dạng!',
        ];
    }
}
