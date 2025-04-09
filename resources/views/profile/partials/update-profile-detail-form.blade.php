<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Detail Profil</h2>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            Lengkapi informasi tambahan akunmu.
        </p>
    </header>

    <form method="post" action="{{ route('profile.add') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf

        <!-- Gender -->
        <div>
            <x-input-label for="gender" value="Jenis Kelamin" />
            <select name="gender" id="gender" class="mt-1 block w-full">
                <option value="Laki-laki" @selected(($user->profile->gender ?? '') == 'Laki-laki')>Laki-laki</option>
                <option value="Perempuan" @selected(($user->profile->gender ?? '') == 'Perempuan')>Perempuan</option>
            </select>
            <x-input-error :messages="$errors->get('gender')" class="mt-2" />
        </div>

        <!-- Tanggal Lahir -->
        <div>
            <x-input-label for="tanggal_lahir" value="Tanggal Lahir" />
            <x-text-input type="date" name="tanggal_lahir" id="tanggal_lahir" :value="old('tanggal_lahir', $user->profile->tanggal_lahir ?? '')" class="mt-1 block w-full" />
            <x-input-error :messages="$errors->get('tanggal_lahir')" class="mt-2" />
        </div>

        <!-- Phone -->
        <div>
            <x-input-label for="phone" value="Nomor Telepon" />
            <x-text-input type="text" name="phone" id="phone" :value="old('phone', $user->profile->phone ?? '')" class="mt-1 block w-full" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <!-- Bio -->
        <div>
            <x-input-label for="bio" value="Bio" />
            <textarea id="bio" name="bio" class="mt-1 block w-full">{{ old('bio', $user->profile->bio ?? '') }}</textarea>
            <x-input-error :messages="$errors->get('bio')" class="mt-2" />
        </div>

        <!-- Foto Profil -->
        <div>
            <x-input-label for="profile_picture" value="Foto Profil" />
            <input type="file" name="profile_picture" id="profile_picture" class="mt-1 block w-full" />
            <x-input-error :messages="$errors->get('profile_picture')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>save</x-primary-button>
            @if (session('status') === 'profile-detail-updated')
                <p class="text-sm text-gray-600 dark:text-gray-400">Tersimpan!</p>
            @endif
        </div>
    </form>
</section>
