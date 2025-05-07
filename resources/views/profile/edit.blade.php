@extends('layouts.app_2')

@section('content')
<div class="profile-container max-w-4xl mx-auto p-6 bg-white shadow-md rounded-lg">
    <!-- Profile Header -->
    <div class="text-center">
        <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="Profile Picture" class="w-40 h-40 rounded-full mx-auto object-cover">
        <h1 class="text-3xl font-semibold mt-4">{{ $user->user_id }}</h1>
        <p class="text-sm text-gray-500 mt-2">
            {{ \Carbon\Carbon::parse($user->tanggal_lahir)->format('F Y') }} | 
            {{ \Carbon\Carbon::parse($user->tanggal_lahir)->age }} years old
        </p>
    </div>

    <!-- Personal Info Section -->
    <div class="mt-8">
        <h3 class="text-xl font-semibold mb-4">Personal Information</h3>
        <p class="text-sm text-gray-500 mb-6">You can change your personal information settings here</p>
        
        <!-- Update Profile Information Form -->
        @include('profile.partials.update-profile-information-form', ['user' => $user])
    </div>

    <!-- Update Profile Detail Form -->
    <div class="mt-8">
        <h3 class="text-xl font-semibold mb-4">Profile Details</h3>
        <p class="text-sm text-gray-500 mb-6">Complete your additional account information here.</p>
        
        @include('profile.partials.update-profile-detail-form', ['user' => $user])
    </div>

    <!-- Password Update Form (Optional) -->
    <div class="mt-8">
        <h3 class="text-xl font-semibold mb-4">Update Password</h3>
        @include('profile.partials.update-password-form')
    </div>

    <!-- Delete User Form (Optional) -->
    <div class="mt-8">
        <h3 class="text-xl font-semibold mb-4 text-red-600">Delete Account</h3>
        @include('profile.partials.delete-user-form')
    </div>
</div>
@endsection