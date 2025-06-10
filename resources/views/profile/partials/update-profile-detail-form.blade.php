<section>
    <header>
        <p class="mt-1 text-sm text-gray-300">
            Lengkapi informasi tambahan akunmu.
        </p>
    </header>

    <form method="post" action="{{ route('profile.add') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf

        <!-- Gender -->
        <div>
            <x-input-label for="gender" value="Jenis Kelamin" class="text-white" />
            <select name="gender" id="gender" class="w-full bg-white/10 text-white placeholder-gray-300 border border-white/20 p-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="" class="text-black">Pilih Jenis Kelamin</option>
                <option value="Laki-laki" @selected(optional($user->profile)->gender == 'Laki-laki') class="text-black">Laki-laki</option>
                <option value="Perempuan" @selected(optional($user->profile)->gender == 'Perempuan') class="text-black">Perempuan</option>
            </select>
            <x-input-error :messages="$errors->get('gender')" class="mt-2 text-red-300" />
        </div>

        <!-- Tanggal Lahir
        <div>
            <x-input-label for="tanggal_lahir" value="Tanggal Lahir" class="text-white" />
            <x-text-input type="date" 
                         name="tanggal_lahir" 
                         id="tanggal_lahir" 
                         :value="old('tanggal_lahir', optional($user->profile)->tanggal_lahir?->format('Y-m-d'))" 
                         class="w-full bg-white/10 text-white placeholder-gray-300 border border-white/20 p-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" />
            <x-input-error :messages="$errors->get('tanggal_lahir')" class="mt-2 text-red-300" />
        </div> -->

        <!-- Phone -->
        <div>
            <x-input-label for="phone" value="Nomor Telepon" class="text-white" />
            <x-text-input type="text" name="phone" id="phone" :value="old('phone', optional($user->profile)->phone)" class="w-full bg-white/10 text-white placeholder-gray-300 border border-white/20 p-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2 text-red-300" />
        </div>

        <!-- Bio -->
        <div>
            <x-input-label for="bio" value="Bio" class="text-white" />
            <textarea id="bio" name="bio" class="w-full bg-white/10 text-white placeholder-gray-300 border border-white/20 p-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" rows="4">{{ old('bio', optional($user->profile)->bio) }}</textarea>
            <x-input-error :messages="$errors->get('bio')" class="mt-2 text-red-300" />
        </div>

        <!-- Current Profile Picture -->
        @if(optional($user->profile)->profile_picture)
        <div>
            <label class="block text-sm font-medium text-white mb-2">Foto Profil Saat Ini</label>
            <img src="{{ asset('storage/' . $user->profile->profile_picture) }}" 
                 alt="Current Profile Picture" 
                 class="w-20 h-20 rounded-full object-cover">
        </div>
        @endif

        <!-- Foto Profil -->
        <div>
            <x-input-label for="profile_picture" value="{{ optional($user->profile)->profile_picture ? 'Ganti Foto Profil' : 'Upload Foto Profil' }}" class="text-white" />
            <input type="file" 
                   name="profile_picture" 
                   id="profile_picture" 
                   accept="image/*"
                   class="mt-1 block w-full text-white file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
            <p class="mt-1 text-sm text-gray-400">Maksimal 2MB. Format: JPG, PNG, GIF</p>
            <x-input-error :messages="$errors->get('profile_picture')" class="mt-2 text-red-300" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>
            @if (session('status') === 'profile-detail-updated')
                <p class="text-sm text-green-300">{{ __('Tersimpan!') }}</p>
            @endif
        </div>
    </form>
</section>
