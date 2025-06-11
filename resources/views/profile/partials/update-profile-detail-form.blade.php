<section>
    <form method="post" action="{{ route('profile.add') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="grid md:grid-cols-2 gap-6">
            <!-- Gender -->
            <div>
                <x-input-label for="gender" value="Gender" class="text-white/90 font-medium" />
                <select name="gender" id="gender" class="mt-2 w-full bg-white/10 text-white border border-white/20 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                    <option value="" class="text-gray-800">Select Gender</option>
                    <option value="Laki-laki" @selected(optional($user->profile)->gender == 'Laki-laki') class="text-gray-800">Male</option>
                    <option value="Perempuan" @selected(optional($user->profile)->gender == 'Perempuan') class="text-gray-800">Female</option>
                </select>
                <x-input-error :messages="$errors->get('gender')" class="mt-2 text-red-300" />
            </div>

            <!-- Phone -->
            <div>
                <x-input-label for="phone" value="Phone Number" class="text-white/90 font-medium" />
                <x-text-input type="text" name="phone" id="phone" :value="old('phone', optional($user->profile)->phone)" 
                    class="mt-2 w-full bg-white/10 text-white placeholder-white/50 border border-white/20 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" 
                    placeholder="Enter your phone number" />
                <x-input-error :messages="$errors->get('phone')" class="mt-2 text-red-300" />
            </div>
        </div>

        <!-- Date of Birth -->
        <div>
            <x-input-label for="tanggal_lahir" value="Date of Birth" class="text-white/90 font-medium" />
            <x-text-input type="date" 
                         name="tanggal_lahir" 
                         id="tanggal_lahir" 
                         :value="old('tanggal_lahir', optional($user->profile)->tanggal_lahir?->format('Y-m-d'))" 
                         class="mt-2 w-full bg-white/10 text-white border border-white/20 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" />
            <x-input-error :messages="$errors->get('tanggal_lahir')" class="mt-2 text-red-300" />
        </div>

        <!-- Bio -->
        <div>
            <x-input-label for="bio" value="Bio" class="text-white/90 font-medium" />
            <textarea id="bio" name="bio" rows="4"
                class="mt-2 w-full bg-white/10 text-white placeholder-white/50 border border-white/20 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all resize-none" 
                placeholder="Tell us about yourself...">{{ old('bio', optional($user->profile)->bio) }}</textarea>
            <x-input-error :messages="$errors->get('bio')" class="mt-2 text-red-300" />
        </div>

        <div class="flex items-center justify-between pt-4">
            <div class="flex items-center">
                @if (session('status') === 'profile-detail-updated')
                    <div class="flex items-center text-green-400 animate-fade-in">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        {{ __('Saved successfully!') }}
                    </div>
                @endif
            </div>
            <button type="submit" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                {{ __('Save Changes') }}
            </button>
        </div>
    </form>
</section>
