<x-app-layout>
    <div class="profile-container max-w-4xl mx-auto p-6 bg-white/10 backdrop-blur-md shadow-lg rounded-xl border border-white/20 mt-8 text-white">
        <!-- Profile Header -->
            <div class="text-center">
            @if(optional($user->profile)->profile_picture)
                <img src="{{ asset('storage/' . $user->profile->profile_picture) }}" 
                     alt="Foto Profil" 
                     class="w-40 h-40 rounded-full mx-auto object-cover shadow-md" />
            @else
                <div class="w-40 h-40 rounded-full mx-auto bg-gray-600 flex items-center justify-center shadow-md">
                    <svg class="w-20 h-20 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                </div>
            @endif
            <h1 class="text-3xl font-semibold mt-4">{{ $user->name }}</h1>
            <p class="text-sm text-gray-300 mt-2">{{ $user->email }}</p>
            @if(optional($user->profile)->tanggal_lahir)
                <p class="text-sm text-gray-300 mt-1">
                    {{ optional($user->profile)->tanggal_lahir->format('F Y') }} 
                    <!-- {{ optional($user->profile)->tanggal_lahir->age }} years old -->
                </p>
            @endif
            </div>


        {{-- Personal Information --}}
        <div class="mt-8 bg-white/5 rounded-lg p-6 border border-white/10">
            <h3 class="text-xl font-semibold text-white mb-4">Personal Information</h3>
            <p class="text-sm text-gray-300 mb-6">You can change your personal information settings here</p>
            @include('profile.partials.update-profile-information-form', ['user' => $user])
        </div>

        {{-- Profile Details --}}
        <div class="mt-8 bg-white/5 rounded-lg p-6 border border-white/10">
            <h3 class="text-xl font-semibold text-white mb-4">Profile Details</h3>
            @include('profile.partials.update-profile-detail-form', ['user' => $user])
        </div>

        {{-- Update Password --}}
        <div class="mt-8 bg-white/5 rounded-lg p-6 border border-white/10">
            <h3 class="text-xl font-semibold text-white mb-4">Update Password</h3>
            @include('profile.partials.update-password-form')
        </div>

        {{-- Delete Account --}}
        <div class="mt-8 bg-white/5 rounded-lg p-6 border border-red-500/30">
            <h3 class="text-xl font-semibold text-red-400 mb-4">Delete Account</h3>
            @include('profile.partials.delete-user-form')
        </div>

        <div>
        <!-- Authentication -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button :href="route('logout')"
                        onclick="event.preventDefault();
                                    this.closest('form').submit();">
                    {{ __('Log Out') }}
                </button>
            </form>
        </div>
    </div>

</x-app-layout>
