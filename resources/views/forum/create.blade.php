<x-app-layout>
    <div class="max-w-3xl mx-auto mt-10 bg-white rounded-xl shadow-xl p-8">
        <h1 class="text-3xl font-semibold text-gray-800 mb-8 text-center">Buat Postingan Baru</h1>

        <form action="{{ route('forum.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Judul</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}"
                       class="block w-full border-gray-300 rounded-lg shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out sm:text-sm"
                       placeholder="Masukkan judul postingan..."
                       required>
                @error('title')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="forum_category_id" class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                <select name="forum_category_id" id="forum_category_id"
                        class="block w-full border-gray-300 rounded-lg shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out sm:text-sm">
                    <option value="">Pilih Kategori (Opsional)</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('forum_category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('forum_category_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Konten</label>
                <textarea name="content" id="content" rows="8"
                          class="block w-full border-gray-300 rounded-lg shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out sm:text-sm"
                          placeholder="Tulis isi postingan Anda di sini..."
                          required>{{ old('content') }}</textarea>
                @error('content')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Upload Gambar (opsional)</label>
                <div id="image-upload-area" class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-indigo-500 transition duration-150 ease-in-out">
                    <div class="space-y-1 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="flex text-sm text-gray-600 justify-center">
                            <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                <span>Upload file Anda</span>
                                <input id="image" name="image" type="file" class="sr-only">
                            </label>
                            <p class="pl-1">atau tarik dan lepas</p>
                        </div>
                        <p class="text-xs text-gray-500">PNG, JPG, GIF hingga 2MB</p>
                    </div>
                </div>
                <div class="mt-4 hidden" id="image-preview-container">
                    <img id="image-preview" src="#" alt="Image Preview" class="max-h-60 rounded-lg mx-auto shadow-md object-contain"/>
                    <button type="button" id="remove-image-button" class="block mx-auto mt-2 text-sm font-medium text-red-600 hover:text-red-700 transition duration-150 ease-in-out">
                        Hapus gambar
                    </button>
                </div>
                 @error('image')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Bagian untuk Polling DIPINDAHKAN KE SINI (DI DALAM FORM) --}}
            <div class="pt-6 border-t border-gray-200"> {{-- Memberi sedikit pemisah visual --}}
                <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Buat Polling (Opsional)</h3>
                
                <div class="mb-4">
                    <label for="poll_question" class="block text-sm font-medium text-gray-700 mb-1">Pertanyaan Polling</label>
                    <input type="text" name="poll_question" id="poll_question" value="{{ old('poll_question') }}"
                           class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-lg p-3 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out"
                           placeholder="Contoh: Apa framework PHP favoritmu?">
                    @error('poll_question') {{-- Menambahkan error display untuk poll_question --}}
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            
                <div id="poll_options_container">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pilihan Jawaban Polling</label>
                    {{-- Opsi awal (minimal 2) --}}
                    <div class="flex items-center gap-2 mb-2 poll-option-entry">
                        <input type="text" name="poll_options[]" value="{{ old('poll_options.0') }}" placeholder="Pilihan 1"
                               class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-lg p-3 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out">
                    </div>
                    <div class="flex items-center gap-2 mb-2 poll-option-entry">
                        <input type="text" name="poll_options[]" value="{{ old('poll_options.1') }}" placeholder="Pilihan 2"
                               class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-lg p-3 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out">
                    </div>
                    {{-- Jika ada old_input untuk opsi tambahan, render di sini --}}
                    @if(is_array(old('poll_options')) && count(old('poll_options')) > 2)
                        @for($i = 2; $i < count(old('poll_options')); $i++)
                            <div class="flex items-center gap-2 mb-2 poll-option-entry">
                                <input type="text" name="poll_options[]" value="{{ old('poll_options.'.$i) }}" placeholder="Pilihan {{ $i + 1 }}"
                                       class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-lg p-3 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out">
                                <button type="button" class="remove-poll-option-button text-sm text-red-500 hover:text-red-700">&times; Hapus</button>
                            </div>
                        @endfor
                    @endif
                </div>
                 @error('poll_options') {{-- Menambahkan error display umum untuk poll_options --}}
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
                @error('poll_options.*') {{-- Menambahkan error display spesifik untuk setiap item poll_options --}}
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror

                <button type="button" id="add_poll_option_button"
                        class="mt-2 text-sm text-indigo-600 hover:text-indigo-900 font-medium">
                    + Tambah Pilihan Jawaban
                </button>
            </div>

            <div class="pt-8"> {{-- Menambah padding atas untuk tombol submit --}}
                <button type="submit"
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                    Publikasikan Postingan
                </button>
            </div>
        </form> {{-- Akhir dari tag form --}}
    </div>

    {{-- Bagian script untuk polling dan preview gambar digabung ke satu @push --}}
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Script untuk Polling
            const addOptionButton = document.getElementById('add_poll_option_button');
            const optionsContainer = document.getElementById('poll_options_container');
            // Hitung jumlah opsi yang sudah ada dari input 'poll_options[]' yang ada di DOM
            let optionCount = optionsContainer ? optionsContainer.querySelectorAll('input[name="poll_options[]"]').length : 0;

            if (addOptionButton && optionsContainer) {
                addOptionButton.addEventListener('click', function () {
                    optionCount++;
                    const newOptionEntry = document.createElement('div');
                    newOptionEntry.classList.add('flex', 'items-center', 'gap-2', 'mb-2', 'poll-option-entry');

                    const newOptionInput = document.createElement('input');
                    newOptionInput.setAttribute('type', 'text');
                    newOptionInput.setAttribute('name', 'poll_options[]');
                    newOptionInput.setAttribute('placeholder', 'Pilihan ' + optionCount);
                    newOptionInput.classList.add('mt-1', 'block', 'w-full', 'shadow-sm', 'sm:text-sm', 'border-gray-300', 'rounded-lg', 'p-3', 'focus:ring-indigo-500', 'focus:border-indigo-500', 'transition', 'duration-150', 'ease-in-out');

                    const removeButton = document.createElement('button');
                    removeButton.setAttribute('type', 'button');
                    removeButton.classList.add('remove-poll-option-button', 'text-sm', 'text-red-500', 'hover:text-red-700');
                    removeButton.innerHTML = '&times; Hapus';
                    removeButton.addEventListener('click', function () {
                        newOptionEntry.remove();
                        // Update optionCount jika perlu, atau biarkan agar placeholder tetap unik jika ada penambahan lagi
                        // Untuk menjaga konsistensi placeholder, lebih baik re-index placeholder jika ada penghapusan di tengah.
                        // Namun untuk kesederhanaan, kita bisa biarkan dulu.
                        // Atau, hitung ulang optionCount dari jumlah input yang ada setelah remove
                        optionCount = optionsContainer.querySelectorAll('input[name="poll_options[]"]').length;
                        // Update placeholder untuk input yang tersisa (jika diperlukan)
                        const allOptionInputs = optionsContainer.querySelectorAll('input[name="poll_options[]"]');
                        allOptionInputs.forEach((input, index) => {
                            input.setAttribute('placeholder', 'Pilihan ' + (index + 1));
                        });

                    });

                    newOptionEntry.appendChild(newOptionInput);
                    newOptionEntry.appendChild(removeButton);
                    optionsContainer.appendChild(newOptionEntry);
                });
            }
            
            // Menambahkan event listener ke tombol hapus yang sudah ada (misal dari old input)
            optionsContainer.querySelectorAll('.remove-poll-option-button').forEach(button => {
                button.addEventListener('click', function() {
                    this.closest('.poll-option-entry').remove();
                    optionCount = optionsContainer.querySelectorAll('input[name="poll_options[]"]').length;
                     const allOptionInputs = optionsContainer.querySelectorAll('input[name="poll_options[]"]');
                        allOptionInputs.forEach((input, index) => {
                            input.setAttribute('placeholder', 'Pilihan ' + (index + 1));
                        });
                });
            });

            // Script untuk Preview Gambar
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
                            imagePreview.setAttribute('src', e.target.result);
                            imagePreviewContainer.classList.remove('hidden');
                            imageUploadArea.classList.add('hidden');
                        }
                        reader.readAsDataURL(file);
                    }
                });

                removeImageButton.addEventListener('click', function() {
                    imagePreview.setAttribute('src', '#');
                    imagePreviewContainer.classList.add('hidden');
                    imageInput.value = ''; 
                    imageUploadArea.classList.remove('hidden');
                });
            }
        });
    </script>
    @endpush
</x-app-layout>