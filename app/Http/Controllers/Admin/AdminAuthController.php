<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    /**
     * Show the admin login form.
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.login');
    }

    /**
     * Handle the admin login request.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ], [
            'email.required' => 'Please enter your administrator email address.',
            'email.email' => 'Please provide a valid email format.',
            'password.required' => 'Please enter your password.',
        ]);

        $remember = $request->filled('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            flash()->success('Welcome back, ' . Auth::user()->name . '!', 'Authentication Successful');

            return redirect()->intended(route('admin.dashboard'))
                ->with('success', 'Welcome back, ' . Auth::user()->name . '!');
        }

        flash()->error('The provided credentials do not match our records.', 'Login Failed');

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Log the admin out of the application.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        flash()->info('You have been successfully logged out.', 'Session Ended');

        return redirect()->route('login')
            ->with('success', 'You have been successfully logged out.');
    }
}
