<x-app-layout>
    <div class="profile-container max-w-4xl mx-auto p-6 bg-white/10 backdrop-blur-md shadow-lg rounded-xl border border-white/20 mt-8 text-white">
        <!-- Profile Header -->
        <div class="text-center">
            <img src="{{ asset('storage/' . ($profile->profile_picture ?? 'images/default-avatar.png')) }}" 
                 alt="Foto Profil" 
                 class="w-40 h-40 rounded-full mx-auto object-cover shadow-md" />
            <h1 class="text-3xl font-semibold mt-4">{{ $user->name }}</h1>
            <p class="text-sm text-gray-300 mt-2">{{ $user->email }}</p>
            @if($user->tanggal_lahir)
                <p class="text-sm text-gray-300 mt-1">
                    {{ \Carbon\Carbon::parse($user->tanggal_lahir)->format('F Y') }} | 
                    {{ \Carbon\Carbon::parse($user->tanggal_lahir)->age }} years old
                </p>
            @endif
        </div>

        <!-- Profile Information -->
        <div class="mt-8 bg-white/5 rounded-lg p-6 border border-white/10">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold text-white">Profile Information</h3>
                <a href="{{ route('profile.edit') }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-200">
                    Edit Profile
                </a>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-300">Name</label>
                    <p class="mt-1 text-white">{{ $user->name }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300">Email</label>
                    <p class="mt-1 text-white">{{ $user->email }}</p>
                </div>
                @if($user->tanggal_lahir)
                <div>
                    <label class="block text-sm font-medium text-gray-300">Date of Birth</label>
                    <p class="mt-1 text-white">{{ \Carbon\Carbon::parse($user->tanggal_lahir)->format('d F Y') }}</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="mt-8 flex gap-4">
            <a href="{{ route('profile.edit') }}" 
               class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-center py-3 rounded-lg transition duration-200">
                Edit Profile
            </a>
            <a href="{{ route('dashboard') }}" 
               class="flex-1 bg-gray-600 hover:bg-gray-700 text-white text-center py-3 rounded-lg transition duration-200">
                Back to Dashboard
            </a>
        </div>
    </div>
</x-app-layout>
