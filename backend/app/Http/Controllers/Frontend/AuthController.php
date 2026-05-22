<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class AuthController extends Controller
{
    private const ADMIN_ROLES = [
        'admin',
        'staff',
        'manage',
        'manager',
    ];

    public function signin(): RedirectResponse|View
    {
        if (Auth::check()) {
            return redirect()->route($this->redirectRouteForAuthenticatedUser());
        }

        return view('frontend.signin');
    }

    public function signup(): RedirectResponse|View
    {
        if (Auth::check()) {
            return redirect()->route($this->redirectRouteForAuthenticatedUser());
        }

        return view('frontend.signup');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ], [
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không đúng định dạng.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $redirectRoute = $this->redirectRouteForAuthenticatedUser();

            return ($redirectRoute === 'admin.dashboard'
                ? redirect()->route($redirectRoute)
                : redirect()->intended(route($redirectRoute)))
                ->with('status', 'Đăng nhập thành công.');
        }

        return back()
            ->withErrors(['email' => 'Email hoặc mật khẩu không đúng.'])
            ->onlyInput('email');
    }

    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ], [
            'name.required' => 'Vui lòng nhập họ tên.',
            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không đúng định dạng.',
            'email.unique' => 'Email này đã được đăng ký.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.confirmed' => 'Mật khẩu nhập lại không khớp.',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
        ]);

        $customerRoleId = DB::table('roles')
            ->where('name', 'customer')
            ->value('id');

        if (! $customerRoleId) {
            return back()
                ->withErrors(['email' => 'Chưa cấu hình quyền khách hàng trong hệ thống.'])
                ->withInput($request->except('password', 'password_confirmation'));
        }

        $user = User::create([
            ...$validated,
            'role_id' => $customerRoleId,
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()
            ->route('frontend.dashboard')
            ->with('status', 'Tài khoản đã được tạo thành công.');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('frontend.home')
            ->with('status', 'Bạn đã đăng xuất.');
    }

    private function redirectRouteForAuthenticatedUser(): string
    {
        $user = Auth::user();

        if ($user instanceof User && $user->hasAnyRole(self::ADMIN_ROLES)) {
            return 'admin.dashboard';
        }

        return 'frontend.dashboard';
    }
}
