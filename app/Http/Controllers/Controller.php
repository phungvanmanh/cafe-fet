<?php

namespace App\Http\Controllers;

use App\Models\QuyenChucNang;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Str;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getLinkUpdateAVT($folder, $file)
    {
        $root_path = public_path();

        $file_extension = $file->getClientOriginalExtension();

        $file_name = Str::slug($file->getClientOriginalName()) . "." . $file_extension;

        $link = '/'.$folder.'/';

        $path = $root_path . '/' . $link;

        $file->move($path, $file_name);

        return $link . $file_name;
    }

    public function checkQuyen($id, $id_quyen) {
        $id_chuc_nang   =   $id;

        $check          =   QuyenChucNang::where('id_quyen', $id_quyen)
                                         ->where('id_chuc_nang', $id_chuc_nang)
                                         ->first();
        if ($check) {
            return true;
        } else {
            return false;
        }
    }
}
