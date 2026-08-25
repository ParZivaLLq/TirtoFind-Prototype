<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityLog;

class LoginController extends Controller
{
    /**
     * Show admin login form.
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('pages.auth.login');
    }

    /**
     * Handle login request.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();
            
            if ($user->status !== 'aktif') {
                Auth::logout();
                return back()->with('error', 'Akun Anda dinonaktifkan oleh administrator.');
            }

            $request->session()->regenerate();

            // Log activity
            ActivityLog::create([
                'user_id' => $user->id,
                'activity' => 'Login',
                'details' => "Pengguna {$user->name} ({$user->role}) berhasil masuk ke dashboard admin.",
            ]);

            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->with('error', 'Kredensial yang diberikan tidak cocok dengan catatan kami.')->withInput($request->only('email'));
    }

    /**
     * Handle logout.
     */
    public function logout(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            ActivityLog::create([
                'user_id' => $user->id,
                'activity' => 'Logout',
                'details' => "Pengguna {$user->name} keluar dari sistem.",
            ]);
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
