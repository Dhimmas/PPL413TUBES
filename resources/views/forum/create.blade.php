<x-app-layout>
    <div class="min-h-screen flex items-center justify-center py-8 bg-slate-900">
        <div class="max-w-5xl w-full mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="bg-slate-800 bg-opacity-75 backdrop-blur-md rounded-2xl p-6 md:p-8 shadow-2xl border border-slate-700/50">
                
                <div class="text-center mb-8">
                    <h1 class="text-3xl lg:text-4xl font-extrabold text-white tracking-tight">
                        <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-400 to-teal-400">
                            ✍️ Buat Diskusi Baru
                        </span>
                    </h1>
                    <p class="text-slate-400 mt-2">Bagikan ide, pertanyaan, atau pengetahuan Anda dengan komunitas.</p>
                </div>

                <form action="{{ route('forum.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-x-8 gap-y-5">
                        
                        {{-- KOLOM KIRI --}}
                        <div class="space-y-5">
                            {{-- Judul --}}
                            <div>
                                <label for="title" class="block text-sm font-medium text-slate-200 mb-2">Judul Diskusi</label>
                                <input type="text" name="title" id="title" value="{{ old('title') }}" class="form-input" placeholder="Masukkan judul yang jelas dan menarik" required>
                                @error('title') <p class="text-red-400 text-xs mt-2">{{ $message }}</p> @enderror
                            </div>

                            {{-- Kategori --}}
                            <div>
                                <label for="forum_category_id" class="block text-sm font-medium text-slate-200 mb-2">Kategori</label>
                                <div class="relative">
                                    <select name="forum_category_id" id="forum_category_id" class="form-input appearance-none">
                                        <option value="">Pilih Kategori (Opsional)</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('forum_category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-400">
                                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" /></svg>
                                    </div>
                                </div>
                                @error('forum_category_id') <p class="text-red-400 text-xs mt-2">{{ $message }}</p> @enderror
                            </div>

                            {{-- Konten --}}
                            <div>
                                <label for="content" class="block text-sm font-medium text-slate-200 mb-2">Konten Diskusi</label>
                                <textarea name="content" id="content" rows="6" class="form-input" placeholder="Tuliskan isi diskusi Anda secara detail..." required>{{ old('content') }}</textarea>
                                @error('content') <p class="text-red-400 text-xs mt-2">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        {{-- KOLOM KANAN --}}
                        <div class="space-y-5">
                             {{-- Unggah Gambar dengan Dropzone --}}
                            <div>
                                <label class="block text-sm font-medium text-slate-200 mb-2">Unggah Gambar (Opsional)</label>
                                <div id="image-upload-area" class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-slate-600 border-dashed rounded-lg hover:border-teal-500 transition duration-200">
                                    <div class="space-y-1 text-center">
                                        <svg class="mx-auto h-10 w-10 text-slate-500" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-slate-400 justify-center">
                                            <label for="image" class="relative cursor-pointer bg-slate-800/50 px-1 rounded-md font-medium text-teal-400 hover:text-teal-300 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-offset-slate-900 focus-within:ring-teal-500">
                                                <span>Unggah file Anda</span>
                                                <input id="image" name="image" type="file" class="sr-only">
                                            </label>
                                            <p class="pl-1">atau tarik dan lepas</p>
                                        </div>
                                        <p class="text-xs text-slate-500">PNG, JPG, GIF hingga 2MB</p>
                                    </div>
                                </div>
                                <div class="mt-2 hidden" id="image-preview-container">
                                    <img id="image-preview" src="#" alt="Pratinjau Gambar" class="max-h-32 rounded-lg mx-auto shadow-md object-contain"/>
                                    <button type="button" id="remove-image-button" class="block mx-auto mt-2 text-xs font-medium text-red-500 hover:text-red-400 transition">Hapus gambar</button>
                                </div>
                                @error('image') <p class="text-red-400 text-xs mt-2">{{ $message }}</p> @enderror
                            </div>
                             {{-- Bagian Polling --}}
                            <div class="pt-4 border-t border-slate-700 space-y-3">
                                <h3 class="text-base font-medium leading-6 text-slate-100">Buat Polling (Opsional)</h3>
                                <div>
                                    <label for="poll_question" class="block text-xs font-medium text-slate-200 mb-1">Pertanyaan Polling</label>
                                    <input type="text" name="poll_question" id="poll_question" value="{{ old('poll_question') }}" class="form-input text-sm" placeholder="Contoh: Framework favoritmu?">
                                    @error('poll_question') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div id="poll_options_container" class="space-y-2">
                                    <label class="block text-xs font-medium text-slate-200">Pilihan Jawaban</label>
                                    <div class="flex items-center gap-2 poll-option-entry"><input type="text" name="poll_options[]" value="{{ old('poll_options.0') }}" placeholder="Pilihan 1" class="form-input text-sm"></div>
                                    <div class="flex items-center gap-2 poll-option-entry"><input type="text" name="poll_options[]" value="{{ old('poll_options.1') }}" placeholder="Pilihan 2" class="form-input text-sm"></div>
                                    @if(is_array(old('poll_options')) && count(old('poll_options')) > 2)
                                        @for($i = 2; $i < count(old('poll_options')); $i++)
                                        <div class="flex items-center gap-2 poll-option-entry">
                                            <input type="text" name="poll_options[]" value="{{ old('poll_options.'.$i) }}" placeholder="Pilihan {{ $i + 1 }}" class="form-input text-sm">
                                            <button type="button" class="remove-poll-option-button text-red-500/80 hover:text-red-500 font-bold text-xl transition">&times;</button>
                                        </div>
                                        @endfor
                                    @endif
                                </div>
                                @error('poll_options') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                                @error('poll_options.*') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                                <button type="button" id="add_poll_option_button" class="text-xs font-medium text-teal-400 hover:text-teal-300 transition">+ Tambah Pilihan</button>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Tombol Aksi --}}
                    <div class="flex flex-col-reverse sm:flex-row sm:justify-between items-center pt-6 mt-6 border-t border-slate-700">
                        <a href="{{ route('forum.index') }}" class="inline-flex items-center gap-2 text-slate-300 hover:text-white transition duration-200 mt-4 sm:mt-0">
                             <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                            <span>Batal</span>
                        </a>
                        <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-gradient-to-r from-blue-500 to-teal-500 hover:from-blue-600 hover:to-teal-600 text-white px-8 py-3 rounded-lg text-base font-semibold shadow-lg shadow-teal-900/40 hover:shadow-lg hover:shadow-teal-700/40 transition-all duration-300 transform hover:-translate-y-0.5 focus:outline-none focus:ring-4 focus:ring-teal-400 focus:ring-opacity-75">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                            <span>Publikasikan</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('styles')
    <style>
        .form-input {
            @apply w-full bg-slate-800/60 text-slate-100 border border-slate-700 rounded-lg p-3;
            @apply focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500;
            @apply transition duration-200 placeholder-slate-500;
        }
        .form-checkbox {
             @apply h-4 w-4 rounded border-slate-600 bg-slate-700 text-teal-500;
             @apply focus:ring-teal-500 focus:ring-offset-slate-800;
        }
        .form-input option {
            background-color: #1E293B; /* bg-slate-800 */
            color: #F1F5F9; /* text-slate-100 */
        }
    </style>
    @endpush

    @push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        // --- Script untuk Polling ---
        const optionsContainer = document.getElementById('poll_options_container');
        function attachRemoveListener(button) {
            button.addEventListener('click', function() {
                this.closest('.poll-option-entry').remove();
                updatePlaceholders();
            });
        }
        function updatePlaceholders() {
            if (!optionsContainer) return;
            const allOptionInputs = optionsContainer.querySelectorAll('input[name="poll_options[]"]');
            allOptionInputs.forEach((input, index) => {
                input.setAttribute('placeholder', 'Pilihan ' + (index + 1));
            });
        }
        if (optionsContainer) {
            optionsContainer.querySelectorAll('.remove-poll-option-button').forEach(attachRemoveListener);
            document.getElementById('add_poll_option_button').addEventListener('click', function () {
                const newOptionEntry = document.createElement('div');
                newOptionEntry.className = 'flex items-center gap-2 poll-option-entry';
                const newOptionInput = document.createElement('input');
                newOptionInput.type = 'text';
                newOptionInput.name = 'poll_options[]';
                newOptionInput.className = 'form-input text-sm';
                const removeButton = document.createElement('button');
                removeButton.type = 'button';
                removeButton.className = 'remove-poll-option-button text-red-500/80 hover:text-red-500 font-bold text-xl transition';
                removeButton.innerHTML = '&times;';
                attachRemoveListener(removeButton);
                newOptionEntry.appendChild(newOptionInput);
                newOptionEntry.appendChild(removeButton);
                optionsContainer.appendChild(newOptionEntry);
                updatePlaceholders();
            });
        }

        // --- Script untuk Preview Gambar ---
        const imageInput = document.getElementById('image');
        const imagePreview = document.getElementById('image-preview');
        const imagePreviewContainer = document.getElementById('image-preview-container');
        const removeImageButton = document.getElementById('remove-image-button');
        const imageUploadArea = document.getElementById('image-upload-area');
        if (imageInput && imagePreview && imagePreviewContainer && removeImageButton && imageUploadArea) {
            imageInput.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        imagePreview.src = e.target.result;
                        imagePreviewContainer.classList.remove('hidden');
                        imageUploadArea.classList.add('hidden');
                    }
                    reader.readAsDataURL(file);
                }
            });
            removeImageButton.addEventListener('click', function() {
                imagePreview.src = '#';
                imagePreviewContainer.classList.add('hidden');
                imageInput.value = ''; 
                imageUploadArea.classList.remove('hidden');
            });
        }
    });
    </script>
    @endpush
</x-app-layout>