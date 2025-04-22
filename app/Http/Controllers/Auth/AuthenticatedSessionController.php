<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
<<<<<<< HEAD
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
=======
>>>>>>> 33a5f72 (test-regist)
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
<<<<<<< HEAD
    /**
     * Display the login view.
     */
=======
>>>>>>> 33a5f72 (test-regist)
    public function create(): View
    {
        return view('auth.login');
    }

<<<<<<< HEAD
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
=======
    public function store(Request $request)
    {
        // Proses login
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials are incorrect.',
        ]);
    }

    public function destroy(Request $request)
    {
        Auth::logout();
        return redirect('/');
    }
}

>>>>>>> 33a5f72 (test-regist)
