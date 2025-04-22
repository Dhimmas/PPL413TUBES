<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
<<<<<<< HEAD
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
=======
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
<<<<<<< HEAD
use Illuminate\Support\Facades\Auth;
>>>>>>> 33a5f72 (test-regist)
=======
>>>>>>> 2b19e7a (implementasi fitur registrasi studify)

class RegisteredUserController extends Controller
{
    /**
<<<<<<< HEAD
     * Display the registration view.
     */
    public function create(): View
=======
     * Tampilkan form registrasi.
     */
    public function create()
>>>>>>> 33a5f72 (test-regist)
    {
        return view('auth.register');
    }

    /**
<<<<<<< HEAD
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

=======
     * Tangani permintaan registrasi.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
        ]);

        // Simpan user baru
<<<<<<< HEAD
>>>>>>> 33a5f72 (test-regist)
        $user = User::create([
=======
        User::create([
>>>>>>> 2b19e7a (implementasi fitur registrasi studify)
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

<<<<<<< HEAD
<<<<<<< HEAD
        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
=======
        // Login user setelah registrasi
        Auth::login($user);

        // Redirect ke halaman dashboard
        return redirect()->route('dashboard');
>>>>>>> 33a5f72 (test-regist)
=======
        // Redirect ke halaman login (tanpa login otomatis)
        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
>>>>>>> 2b19e7a (implementasi fitur registrasi studify)
    }
}
