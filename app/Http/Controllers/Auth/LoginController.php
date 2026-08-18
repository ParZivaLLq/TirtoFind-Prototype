<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * Show admin login form.
     */
    public function showLoginForm()
    {
        return view('pages.auth.login');
    }

    /**
     * Handle login request (Frontend demo route).
     */
    public function login(Request $request)
    {
        return redirect()->route('admin.dashboard');
    }

    /**
     * Handle logout.
     */
    public function logout(Request $request)
    {
        return redirect()->route('home');
    }
}
