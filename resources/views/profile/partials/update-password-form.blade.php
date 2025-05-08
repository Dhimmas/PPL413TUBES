<section>
    <header>
        <p class="mt-1 text-sm text-gray-300">
            {{ __('Pastikan akunmu menggunakan kata sandi acak yang panjang untuk keamanan maksimal.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <!-- Current Password -->
        <div>
            <x-input-label for="update_password_current_password" :value="__('Kata Sandi Saat Ini') "  class="text-white"/>
            <x-text-input
                id="update_password_current_password"
                name="current_password"
                type="password"
                autocomplete="current-password"
                class="w-full bg-white/10 text-white placeholder-gray-300 border border-white/20 p-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <!-- New Password -->
        <div>
            <x-input-label for="update_password_password" :value="__('Kata Sandi Baru')" class="text-white" />
            <x-text-input
                id="update_password_password"
                name="password"
                type="password"
                autocomplete="new-password"
                class="w-full bg-white/10 text-white placeholder-gray-300 border border-white/20 p-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Konfirmasi Kata Sandi')" class="text-white"/>
            <x-text-input
                id="update_password_password_confirmation"
                name="password_confirmation"
                type="password"
                autocomplete="new-password"
                class="w-full bg-white/10 text-white placeholder-gray-300 border border-white/20 p-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Simpan') }}</x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Saved!') }}</p>
            @endif
        </div>
    </form>
</section>
