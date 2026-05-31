<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            // Log activity
            \App\Models\ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => 'login',
                'module' => 'auth',
                'description' => 'User logged in',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            // Update last login
            Auth::user()->update(['last_login_at' => now()]);

            return redirect()->intended($this->redirectPath());
        }

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    protected function redirectPath()
    {
        $role = Auth::user()->role;
        return match ($role) {
            'super_admin' => route('admin.dashboard'),
            'hse_manager' => route('hse.dashboard'),
            'supervisor' => route('supervisor.dashboard'),
            'worker' => route('worker.dashboard'),
            default => '/',
        };
    }

    public function logout(Request $request)
    {
        // Log activity before logout
        if (Auth::check()) {
            \App\Models\ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => 'logout',
                'module' => 'auth',
                'description' => 'User logged out',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
