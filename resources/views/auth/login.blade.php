<<<<<<< HEAD
<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
=======
@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-200">
  <div class="bg-white w-80 h-[90vh] rounded-3xl shadow-lg overflow-auto">
    <div class="px-6 py-4">
      {{-- Back button --}}
      <a href="{{ url()->previous() }}" class="inline-block mb-4 text-gray-500 hover:text-gray-700">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
             viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M15 19l-7-7 7-7" />
        </svg>
      </a>

      {{-- Heading --}}
      <h1 class="text-3xl font-bold text-center mb-6">Create Account</h1>

      {{-- Form --}}
      <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <input
          type="text"
          name="name"
          placeholder="Full Name"
          value="{{ old('name') }}"
          required
          class="input-style"
        />

        <input
          type="email"
          name="email"
          placeholder="Email address"
          value="{{ old('email') }}"
          required
          class="input-style"
        />

        <input
          type="password"
          name="password"
          placeholder="Password"
          required
          class="input-style"
        />

        <input
          type="password"
          name="password_confirmation"
          placeholder="Confirm Password"
          required
          class="input-style"
        />

        <button
          type="submit"
          class="w-full py-3 bg-purple-600 hover:bg-purple-700 text-white font-semibold rounded-full transition"
        >
          Sign Up
        </button>
      </form>

      {{-- Already have account --}}
      <div class="text-center mt-6">
        <span class="text-gray-500 text-sm">Already have an account?</span>
        <a href="{{ route('login') }}"
           class="text-purple-600 text-sm font-semibold hover:underline">
          Log In
        </a>
      </div>

      <div class="pb-6"></div>
    </div>
  </div>
</div>
@endsection
>>>>>>> 33a5f72 (test-regist)
