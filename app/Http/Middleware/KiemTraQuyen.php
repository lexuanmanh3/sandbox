<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class KiemTraQuyen
{
    public function handle(Request $request, Closure $next, string $maQuyen): Response
    {
        // Nếu chưa đăng nhập thì chuyển về trang login
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Lấy user đang đăng nhập
        // Dòng @var giúp VS Code hiểu đây là App\Models\User
        /** @var \App\Models\User|null $user */
        $user = auth()->user();

        // Nếu user không tồn tại hoặc không có quyền yêu cầu thì chặn
        if (!$user || !$user->coQuyen($maQuyen)) {
            abort(403, 'Bạn không có quyền truy cập chức năng này.');
        }

        // Nếu hợp lệ thì cho request đi tiếp
        return $next($request);
    }
}