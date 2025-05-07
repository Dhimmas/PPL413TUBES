<x-guest-layout>

    <!-- Logo ditambahkan di atas teks "Welcome Back" -->
    <div class="logo-container">
        <!-- Path gambar logo -->
        <img src="{{ asset('images/logo11.png') }}" alt="Logo" class="logo">
    </div>

    <h2>Welcome Back!</h2>
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="input-group">
            <x-input-label for="email" :value="__('Email')" style="font-size: 14px; color:rgb(84, 84, 84); font-weight: 600; margin-bottom: 5px;" />
            <x-text-input id="email" class="input-field" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="error-message" />
        </div>

        <!-- Password -->
        <div class="input-group">
            <x-input-label for="password" :value="__('Password')" style="font-size: 14px; color:rgb(84, 84, 84); font-weight: 600; margin-bottom: 5px;" />
            <x-text-input id="password" class="input-field" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="error-message" />
        </div>

        <!-- Remember Me -->
        <div class="remember-me">
            <label for="remember_me" class="remember-label">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="login-actions">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="forgot-password">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="login-button">
                {{ __('Login') }}
            </x-primary-button>
        </div>
    </form>

    <div class="signup-link">
        <a href="{{ route('register') }}" class="signup-button">{{ __('Don\'t have an account? Sign Up') }}</a>
    </div>

</x-guest-layout>
