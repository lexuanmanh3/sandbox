<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class KiemTraVaiTro
{
    public function handle(Request $request, Closure $next, string $maVaiTro): Response
    {
        // Nếu chưa đăng nhập thì chuyển về trang login
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Lấy user đang đăng nhập
        /** @var \App\Models\User|null $user */
        $user = auth()->user();

        // Nếu user không tồn tại hoặc không có vai trò yêu cầu thì chặn
        if (!$user || !$user->coVaiTro($maVaiTro)) {
            abort(403, 'Bạn không có quyền truy cập chức năng này.');
        }

        // Nếu hợp lệ thì cho request đi tiếp
        return $next($request);
    }
}