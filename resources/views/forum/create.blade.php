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

            {{-- TAMBAHKAN INPUT KATEGORI --}}
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
                        <p class="text-xs text-gray-500">PNG, JPG, GIF hingga 2MB</p> {{-- Sesuaikan dengan validasi controller --}}
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

            <div class="pt-5">
                <button type="submit"
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                    Publikasikan Postingan
                </button>
            </div>
        </form>
    </div>

    {{-- Script untuk preview gambar --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
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
</x-app-layout>