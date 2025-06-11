<x-app-layout>
    <div class="max-w-4xl mx-auto p-6 mt-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-6 shadow-xl border border-white/20">
                <h1 class="text-3xl md:text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-400 mb-2">
                    ⚙️ Edit Profile
                </h1>
                <p class="text-white/70 text-lg">Update your personal information and preferences</p>
            </div>
        </div>

        <!-- Combined Profile Form -->
        <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-8 shadow-xl border border-white/20 mb-8">
            <form method="post" action="{{ route('profile.add') }}" enctype="multipart/form-data" class="space-y-8">
                @csrf

                <!-- Profile Picture Section -->
                <div class="text-center">
                    <h3 class="text-xl font-bold text-white mb-6 flex items-center justify-center">
                        <i class="fas fa-camera text-purple-400 mr-2"></i>
                        Profile Picture
                    </h3>
                    
                    <div class="relative inline-block">
                        <!-- Current Profile Picture Preview -->
                        <div class="w-32 h-32 mx-auto rounded-full overflow-hidden border-4 border-white/30 shadow-lg mb-4" id="current-profile-preview">
                            @if(auth()->user()->profile && auth()->user()->profile->profile_picture)
                                <img src="{{ asset('storage/' . auth()->user()->profile->profile_picture) }}" 
                                     alt="Profile Picture" 
                                     class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-purple-500 to-blue-500 flex items-center justify-center">
                                    <svg class="w-16 h-16 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <!-- Modern Drag & Drop Upload Area -->
                        <div class="relative max-w-md mx-auto">
                            <input type="file" name="profile_picture" id="profile_picture" accept="image/*"
                                   class="hidden" onchange="previewProfileImage(this)">
                            
                            <div id="profile-upload-area" 
                                 class="mt-4 flex justify-center px-6 pt-8 pb-8 border-2 border-purple-400 border-dashed rounded-xl hover:border-purple-300 transition duration-300 cursor-pointer bg-white/5 hover:bg-white/10"
                                 onclick="document.getElementById('profile_picture').click()"
                                 ondrop="dropHandler(event)" 
                                 ondragover="dragOverHandler(event)"
                                 ondragenter="dragEnterHandler(event)"
                                 ondragleave="dragLeaveHandler(event)">
                                
                                <div class="space-y-3 text-center" id="upload-content">
                                    <div class="mx-auto h-16 w-16 text-purple-400">
                                        <svg stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true" class="w-full h-full">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </div>
                                    <div class="text-white">
                                        <p class="font-semibold text-lg">Choose your profile photo</p>
                                        <p class="text-white/70 text-sm mt-1">or drag and drop it here</p>
                                    </div>
                                    <p class="text-xs text-white/50">PNG, JPG, GIF up to 2MB</p>
                                </div>

                                <!-- Preview Area (Hidden by default) -->
                                <div class="hidden" id="image-preview-area">
                                    <div class="flex flex-col items-center space-y-3">
                                        <img id="profile-preview-image" src="" alt="Preview" 
                                             class="w-24 h-24 rounded-full object-cover border-4 border-purple-400 shadow-lg">
                                        <div class="text-center">
                                            <p class="text-green-400 font-semibold text-sm">
                                                <i class="fas fa-check-circle mr-1"></i>
                                                Photo selected successfully!
                                            </p>
                                            <button type="button" onclick="removeProfileImage()" 
                                                    class="mt-2 text-red-400 hover:text-red-300 text-xs font-medium transition">
                                                <i class="fas fa-times mr-1"></i>Remove photo
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @error('profile_picture')
                            <p class="text-red-300 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Basic Information -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Left Column -->
                    <div class="space-y-6">
                        <h3 class="text-lg font-bold text-white border-b border-white/20 pb-2 flex items-center">
                            <i class="fas fa-user text-blue-400 mr-2"></i>
                            Basic Information
                        </h3>

                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-white/90 font-medium mb-2">
                                <i class="fas fa-signature mr-2 text-green-400"></i>Full Name
                            </label>
                            <input type="text" name="name" id="name" :value="old('name', $user->name)" required
                                   class="w-full p-4 rounded-xl bg-white/10 text-white placeholder-white/50 border border-white/20 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" 
                                   placeholder="Enter your full name">
                            @error('name')
                                <p class="text-red-300 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-white/90 font-medium mb-2">
                                <i class="fas fa-envelope mr-2 text-purple-400"></i>Email Address
                            </label>
                            <input type="email" name="email" id="email" :value="old('email', $user->email)" required
                                   class="w-full p-4 rounded-xl bg-white/10 text-white placeholder-white/50 border border-white/20 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all" 
                                   placeholder="Enter your email">
                            @error('email')
                                <p class="text-red-300 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Gender -->
                        <div>
                            <label for="gender" class="block text-white/90 font-medium mb-2">
                                <i class="fas fa-venus-mars mr-2 text-pink-400"></i>Gender
                            </label>
                            <select name="gender" id="gender" 
                                    class="w-full p-4 rounded-xl bg-white/10 text-white border border-white/20 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-all">
                                <option value="" class="bg-gray-800">Select Gender</option>
                                <option value="Laki-laki" @selected(optional($user->profile)->gender == 'Laki-laki') class="bg-gray-800">Male</option>
                                <option value="Perempuan" @selected(optional($user->profile)->gender == 'Perempuan') class="bg-gray-800">Female</option>
                            </select>
                            @error('gender')
                                <p class="text-red-300 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-6">
                        <h3 class="text-lg font-bold text-white border-b border-white/20 pb-2 flex items-center">
                            <i class="fas fa-id-card text-yellow-400 mr-2"></i>
                            Personal Details
                        </h3>

                        <!-- Phone -->
                        <div>
                            <label for="phone" class="block text-white/90 font-medium mb-2">
                                <i class="fas fa-phone mr-2 text-green-400"></i>Phone Number
                            </label>
                            <input type="text" name="phone" id="phone" :value="old('phone', optional($user->profile)->phone)" 
                                   class="w-full p-4 rounded-xl bg-white/10 text-white placeholder-white/50 border border-white/20 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all" 
                                   placeholder="Enter your phone number">
                            @error('phone')
                                <p class="text-red-300 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Date of Birth -->
                        <div>
                            <label for="tanggal_lahir" class="block text-white/90 font-medium mb-2">
                                <i class="fas fa-birthday-cake mr-2 text-orange-400"></i>Date of Birth
                            </label>
                            <input type="date" name="tanggal_lahir" id="tanggal_lahir" 
                                   :value="old('tanggal_lahir', optional($user->profile)->tanggal_lahir?->format('Y-m-d'))" 
                                   class="w-full p-4 rounded-xl bg-white/10 text-white border border-white/20 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all">
                            @error('tanggal_lahir')
                                <p class="text-red-300 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Bio -->
                        <div>
                            <label for="bio" class="block text-white/90 font-medium mb-2">
                                <i class="fas fa-comment mr-2 text-blue-400"></i>Bio
                            </label>
                            <textarea id="bio" name="bio" rows="4"
                                      class="w-full p-4 rounded-xl bg-white/10 text-white placeholder-white/50 border border-white/20 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all resize-none" 
                                      placeholder="Tell us about yourself...">{{ old('bio', optional($user->profile)->bio) }}</textarea>
                            @error('bio')
                                <p class="text-red-300 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Password Section -->
                <div class="border-t border-white/20 pt-8">
                    <h3 class="text-lg font-bold text-white mb-6 flex items-center">
                        <i class="fas fa-lock text-red-400 mr-2"></i>
                        Change Password (Optional)
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Current Password -->
                        <div>
                            <label for="current_password" class="block text-white/90 font-medium mb-2">Current Password</label>
                            <input type="password" name="current_password" id="current_password"
                                   class="w-full p-4 rounded-xl bg-white/10 text-white placeholder-white/50 border border-white/20 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all" 
                                   placeholder="Enter current password">
                            @error('current_password')
                                <p class="text-red-300 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- New Password -->
                        <div>
                            <label for="password" class="block text-white/90 font-medium mb-2">New Password</label>
                            <input type="password" name="password" id="password"
                                   class="w-full p-4 rounded-xl bg-white/10 text-white placeholder-white/50 border border-white/20 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all" 
                                   placeholder="Enter new password">
                            @error('password')
                                <p class="text-red-300 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation" class="block text-white/90 font-medium mb-2">Confirm Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                   class="w-full p-4 rounded-xl bg-white/10 text-white placeholder-white/50 border border-white/20 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all" 
                                   placeholder="Confirm new password">
                            @error('password_confirmation')
                                <p class="text-red-300 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex items-center justify-between pt-6 border-t border-white/20">
                    <div class="flex items-center">
                        @if (session('status') === 'profile-detail-updated')
                            <div class="flex items-center text-green-400 animate-fade-in">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Profile updated successfully!
                            </div>
                        @endif
                    </div>
                    <div class="flex gap-4">
                        <a href="{{ route('profile.show') }}" 
                           class="inline-flex items-center px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Back to Profile
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105">
                            <i class="fas fa-save mr-2"></i>
                            Save All Changes
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Delete Account Section -->
        <div class="bg-red-500/10 backdrop-blur-lg rounded-2xl p-6 shadow-xl border border-red-500/20">
            <h2 class="text-xl font-bold text-red-300 mb-6 flex items-center">
                <i class="fas fa-exclamation-triangle text-red-400 mr-2"></i>
                Danger Zone
            </h2>
            <div class="max-w-xl">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>

    <script>
        let selectedFile = null;

        // Drag and Drop Handlers
        function dragOverHandler(ev) {
            ev.preventDefault();
            ev.dataTransfer.dropEffect = "copy";
        }

        function dragEnterHandler(ev) {
            ev.preventDefault();
            const uploadArea = document.getElementById('profile-upload-area');
            uploadArea.classList.add('border-purple-300', 'bg-purple-500/10');
            uploadArea.classList.remove('border-purple-400');
        }

        function dragLeaveHandler(ev) {
            ev.preventDefault();
            const uploadArea = document.getElementById('profile-upload-area');
            uploadArea.classList.remove('border-purple-300', 'bg-purple-500/10');
            uploadArea.classList.add('border-purple-400');
        }

        function dropHandler(ev) {
            ev.preventDefault();
            
            const uploadArea = document.getElementById('profile-upload-area');
            uploadArea.classList.remove('border-purple-300', 'bg-purple-500/10');
            uploadArea.classList.add('border-purple-400');

            const files = ev.dataTransfer.files;
            if (files.length > 0) {
                const file = files[0];
                if (validateFile(file)) {
                    selectedFile = file;
                    
                    // Update the file input
                    const fileInput = document.getElementById('profile_picture');
                    const dt = new DataTransfer();
                    dt.items.add(file);
                    fileInput.files = dt.files;
                    
                    showPreview(file);
                }
            }
        }

        function previewProfileImage(input) {
            if (input.files && input.files[0]) {
                const file = input.files[0];
                if (validateFile(file)) {
                    selectedFile = file;
                    showPreview(file);
                }
            }
        }

        function validateFile(file) {
            // Check file type
            const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
            if (!allowedTypes.includes(file.type)) {
                alert('Please select a valid image file (JPG, PNG, GIF)');
                return false;
            }

            // Check file size (2MB = 2 * 1024 * 1024 bytes)
            if (file.size > 2 * 1024 * 1024) {
                alert('File size must be less than 2MB');
                return false;
            }

            return true;
        }

        function showPreview(file) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                const uploadContent = document.getElementById('upload-content');
                const previewArea = document.getElementById('image-preview-area');
                const previewImage = document.getElementById('profile-preview-image');
                const currentPreview = document.getElementById('current-profile-preview');
                
                // Update preview image
                previewImage.src = e.target.result;
                
                // Update current profile preview
                currentPreview.innerHTML = `<img src="${e.target.result}" alt="Profile Preview" class="w-full h-full object-cover">`;
                
                // Show preview area, hide upload content
                uploadContent.classList.add('hidden');
                previewArea.classList.remove('hidden');
            };
            
            reader.readAsDataURL(file);
        }

        function removeProfileImage() {
            const uploadContent = document.getElementById('upload-content');
            const previewArea = document.getElementById('image-preview-area');
            const fileInput = document.getElementById('profile_picture');
            const currentPreview = document.getElementById('current-profile-preview');
            
            // Reset file input
            fileInput.value = '';
            selectedFile = null;
            
            // Reset preview areas
            uploadContent.classList.remove('hidden');
            previewArea.classList.add('hidden');
            
            // Reset current profile preview to original
            @if(auth()->user()->profile && auth()->user()->profile->profile_picture)
                currentPreview.innerHTML = `<img src="{{ asset('storage/' . auth()->user()->profile->profile_picture) }}" alt="Profile Picture" class="w-full h-full object-cover">`;
            @else
                currentPreview.innerHTML = `
                    <div class="w-full h-full bg-gradient-to-br from-purple-500 to-blue-500 flex items-center justify-center">
                        <svg class="w-16 h-16 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                        </svg>
                    </div>
                `;
            @endif
        }

        // Add smooth hover effects
        document.addEventListener('DOMContentLoaded', function() {
            const uploadArea = document.getElementById('profile-upload-area');
            
            uploadArea.addEventListener('mouseenter', function() {
                this.style.transform = 'scale(1.02)';
            });
            
            uploadArea.addEventListener('mouseleave', function() {
                this.style.transform = 'scale(1)';
            });
        });
    </script>

    <style>
        #profile-upload-area {
            transition: all 0.3s ease;
        }
        
        #profile-upload-area:hover svg {
            transform: scale(1.1);
            transition: transform 0.3s ease;
        }
        
        .animate-fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1, transform: translateY(0); }
        }
    </style>
</x-app-layout>
