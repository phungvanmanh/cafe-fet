<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Mockery\Expectation;
use Yoeunes\Toastr\Facades\Toastr;

class ClientMiddleware
{

    public function handle(Request $request, Closure $next)
    {
        $check = Auth::guard('khach_hang')->check();
        if($check) {
            return $next($request);
        }

        Toastr::error('Bạn cần đăng nhập hệ thống trước!');
        return redirect('/login-register');
    }
}
