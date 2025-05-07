<x-guest-layout>

<!-- Logo ditambahkan di atas teks "Welcome Back" -->
    <div class="logo-container">
        <!-- Path gambar logo -->
        <img src="{{ asset('images/logo11.png') }}" alt="Logo" class="logo">
    </div>

      {{-- Heading --}}
      <h1 class="text-3xl font-bold text-center mb-6">Create Account</h1>

      {{-- Form --}}
      <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Name -->
        <div class = "input-group">
            <x-input-label for="name" :value="__('Full Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class = "input-group">
            <x-input-label for="email" :value="__('Email address')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="login-actions">
            <a class="underline text-sm text-purple-600 dark:text-#6366f1-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already have an account?') }}
            </a>

            <x-primary-button class="login-button">
                {{ __('Sign Up') }}
            </x-primary-button>
        </div>
      </form>

    </div>
  </div>

</x-guest-layout>
