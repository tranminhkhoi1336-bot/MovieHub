<?php

namespace App\Http\Middleware;

use Closure;

class CheckAdmin
{
    
public function handle($request, Closure $next)
{
    // Chưa đăng nhập thì chuyển đến trang đăng nhập
    if (!auth()->check()) {
        return redirect()->route('login');
    }

    // Đã đăng nhập nhưng không phải Admin
    if (!auth()->user()->isAdmin()) {
        abort(403, 'Bạn không có quyền truy cập trang quản trị.');
    }

    // Là Admin thì được phép truy cập
    return $next($request);
}

}
