<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\User;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        // 🔎 Ambil user dulu
        $user = User::where('email', $request->email)->first();

        // ❌ Email tidak terdaftar
        if (!$user) {
            return back()->withErrors([
                'email' => 'Email atau password salah.',
            ]);
        }

        // 🔒 Kasir nonaktif tidak boleh login
        if ($user->role === 'kasir' && $user->active == 0) {
            return back()->withErrors([
                'email' => 'Akun ini telah dinonaktifkan oleh pemilik.',
            ]);
        }

        // ✅ LOGIN DENGAN SYARAT ACTIVE = 1
        if (!Auth::attempt([
            'email'    => $request->email,
            'password' => $request->password,
            'active'   => 1,
        ], $request->boolean('remember'))) {

            return back()->withErrors([
                'email' => 'Email atau password salah.',
            ]);
        }

        // 🔄 Regenerate session (AMAN)
        $request->session()->regenerate();

        return redirect('/dashboard');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
