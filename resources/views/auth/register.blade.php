<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
=======
@extends('layouts.app')

@section('title', 'Create Account')

@section('content')
  <div class="min-h-screen flex items-center justify-center bg-gray-50 px-4">
    {{-- Card --}}
    <div class="bg-white w-full sm:w-96 md:w-[400px] h-[85vh] rounded-3xl shadow-xl overflow-auto p-6">
      
      {{-- Back Button --}}
      <a href="{{ url()->previous() }}" class="inline-block mb-2 text-gray-400 hover:text-gray-600">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
      </a>

      {{-- Title --}}
      <h2 class="text-2xl font-semibold text-gray-800 text-center mb-6">Create your account</h2>

      {{-- Form --}}
      <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        {{-- Name --}}
        <div class="relative">
          <input type="text" name="name" placeholder="Full Name" value="{{ old('name') }}" required
            class="w-full px-4 py-3 bg-gray-100 rounded-full focus:outline-none focus:ring-2 focus:ring-purple-400">
          @error('name')
            <span class="text-sm text-red-600 absolute right-4 bottom-2">{{ $message }}</span>
          @enderror
        </div>

        {{-- Email --}}
        <div class="relative">
          <input type="email" name="email" placeholder="Email Address" value="{{ old('email') }}" required
            class="w-full px-4 py-3 bg-gray-100 rounded-full focus:outline-none focus:ring-2 focus:ring-purple-400">
          @error('email')
            <span class="text-sm text-red-600 absolute right-4 bottom-2">{{ $message }}</span>
          @enderror
        </div>

        {{-- Password --}}
        <div class="relative">
          <input type="password" name="password" placeholder="Password" required
            class="w-full px-4 py-3 bg-gray-100 rounded-full focus:outline-none focus:ring-2 focus:ring-purple-400">
          <button type="button" class="absolute right-4 top-3 text-gray-400 hover:text-gray-600 focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>
          </button>
        </div>

        {{-- Confirm Password --}}
        <div class="relative">
          <input type="password" name="password_confirmation" placeholder="Confirm Password" required
            class="w-full px-4 py-3 bg-gray-100 rounded-full focus:outline-none focus:ring-2 focus:ring-purple-400">
          <button type="button" class="absolute right-4 top-3 text-gray-400 hover:text-gray-600 focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>
          </button>
        </div>

        {{-- Privacy & Policy --}}
        <div class="flex items-center">
          <input type="checkbox" name="agree" required
            class="h-4 w-4 text-purple-600 focus:ring-purple-400 border-gray-300 rounded" />
          <label class="ml-2 text-sm text-gray-600">
            I have read the
            <a href="#" class="text-purple-500 underline">Privacy & Policy</a>
          </label>
        </div>

        {{-- Submit --}}
        <button type="submit"
          class="w-full py-3 bg-purple-500 hover:bg-purple-600 text-white font-semibold rounded-full transition">
          GET STARTED
        </button>
      </form>

      {{-- Separator --}}
      <div class="flex items-center my-6">
        <hr class="flex-grow border-gray-300">
        <span class="mx-2 text-gray-400 text-xs uppercase">Or sign up with</span>
        <hr class="flex-grow border-gray-300">
      </div>

      {{-- Social --}}
      <div class="flex justify-center space-x-4 mb-4">
        <button type="button" class="bg-white border p-2 rounded-full shadow-md">
          <img src="https://upload.wikimedia.org/wikipedia/commons/5/53/Google_%22G%22_Logo.svg"
            class="w-6 h-6" alt="Google">
        </button>
        <button type="button" class="bg-white border p-2 rounded-full shadow-md">
          <img src="https://upload.wikimedia.org/wikipedia/commons/1/1b/Facebook_icon.svg"
            class="w-6 h-6" alt="Facebook">
        </button>
      </div>

      {{-- Login link --}}
      <p class="text-center text-sm text-gray-600 mb-4">
        ALREADY HAVE AN ACCOUNT?
        <a href="{{ route('login') }}" class="text-purple-500 font-semibold hover:underline">
          LOG IN
        </a>
      </p>

      {{-- Bottom padding --}}
      <div class="pb-6"></div>
    </div>
  </div>
@endsection
