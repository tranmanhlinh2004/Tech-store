<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdminRole
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->guest(route('frontend.signin'));
        }

        if (! $user->canAccessAdmin()) {
            return redirect()
                ->route('frontend.home')
                ->with('error', 'Tài khoản của bạn không có quyền truy cập trang quản trị.');
        }

        return $next($request);
    }
}
