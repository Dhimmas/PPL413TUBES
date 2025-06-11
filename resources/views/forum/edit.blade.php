<x-app-layout>
{{--
Container Halaman Standar
- 'min-h-screen' dan 'flex' digunakan untuk menengahkan konten secara vertikal.
- Padding vertikal disesuaikan agar pas di layar.
--}}
<div class="min-h-screen flex items-center justify-center py-8 bg-slate-900">
<div class="max-w-5xl w-full mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Card Form Utama --}}
        <div class="bg-slate-800 bg-opacity-75 backdrop-blur-md rounded-2xl p-6 md:p-8 shadow-2xl border border-slate-700/50">

            <div class="text-center mb-8">
                <h1 class="text-3xl lg:text-4xl font-extrabold text-white tracking-tight">
                    <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-400 to-teal-400">
                        📝 Edit Postingan
                    </span>
                </h1>
                <p class="text-slate-400 mt-2">Perbarui detail diskusi Anda agar tetap relevan.</p>
            </div>

            <form action="{{ route('forum.update', $post->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-x-8 gap-y-5">
                    {{-- KOLOM KIRI --}}
                    <div class="space-y-5">
                        {{-- Judul --}}
                        <div>
                            <label for="title" class="block text-sm font-medium text-slate-200 mb-2">Judul Diskusi</label>
                            <input type="text" name="title" id="title" value="{{ old('title', $post->title) }}"
    class="w-full bg-slate-800/60 text-white border border-slate-700 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition duration-200 placeholder-slate-400"
    placeholder="Masukkan judul..." required>
                            @error('title') <p class="text-red-400 text-xs mt-2">{{ $message }}</p> @enderror
                        </div>

                        {{-- Kategori --}}
                        <div>
                            <label for="forum_category_id" class="block text-sm font-medium text-slate-200 mb-2">Kategori</label>
                            <div class="relative">
                                <select name="forum_category_id" id="forum_category_id"
    class="w-full bg-slate-800/60 text-white border border-slate-700 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition duration-200 appearance-none">
    <option value="">Pilih Kategori</option>
    @foreach($categories as $category)
        <option value="{{ $category->id }}" {{ old('forum_category_id', $post->forum_category_id) == $category->id ? 'selected' : '' }}>
            {{ $category->name }}
        </option>
    @endforeach
</select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" /></svg>
                                </div>
                            </div>
                            @error('forum_category_id') <p class="text-red-400 text-xs mt-2">{{ $message }}</p> @enderror
                        </div>

                        {{-- Konten --}}
                        <div>
                            <label for="content" class="block text-sm font-medium text-slate-200 mb-2">Konten Diskusi</label>
                            {{-- Rows dikurangi agar lebih pendek --}}
                            <textarea name="content" id="content" rows="6"
    class="w-full bg-slate-800/60 text-white border border-slate-700 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition duration-200 placeholder-slate-400"
    placeholder="Tuliskan isi diskusi..." required>{{ old('content', $post->content) }}</textarea>
                            @error('content') <p class="text-red-400 text-xs mt-2">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- KOLOM KANAN --}}
                    <div class="space-y-5">
                        {{-- Unggah Gambar & Opsi Hapus --}}
                        <div class="space-y-3">
                            <div>
                                <label for="image" class="block text-sm font-medium text-slate-200 mb-2">Unggah Gambar (Opsional)</label>
                                <input type="file" name="image" id="image" class="w-full text-sm text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-gray-200 file:text-gray-800 hover:file:bg-gray-300 file:transition-all file:duration-200 file:cursor-pointer">
                                @error('image') <p class="text-red-400 text-xs mt-2">{{ $message }}</p> @enderror
                            </div>

                            @if ($post->image)
                                <div class="p-3 bg-slate-800/50 rounded-lg">
                                    <p class="text-xs text-slate-300 mb-2">Gambar saat ini:</p>
                                    <img src="{{ asset('storage/' . $post->image) }}" alt="Current image" class="max-h-28 w-auto rounded-md border-2 border-slate-700 shadow-md">
                                    <div class="mt-2">
                                        <label for="remove_image" class="flex items-center text-xs text-slate-300 cursor-pointer">
                                            <input type="checkbox" name="remove_image" id="remove_image" value="1" class="form-checkbox-light">
                                            <span class="ml-2">Hapus Gambar Ini</span>
                                        </label>
                                    </div>
                                </div>
                            @endif
                        </div>

                        {{-- Bagian Edit Polling --}}
                        @if ($post->poll)
                        <div class="pt-4 border-t border-slate-700 space-y-3">
                            <h3 class="text-base font-medium leading-6 text-slate-100">Edit Polling</h3>
                            <div>
                                <label for="poll_question" class="block text-xs font-medium text-slate-200 mb-1">Pertanyaan Polling</label>
                                <input type="text" name="poll_question" id="poll_question" value="{{ old('poll_question', $post->poll->question ?? '') }}"
    class="w-full bg-slate-800/60 text-white border border-slate-700 rounded-lg p-3 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition duration-200 placeholder-slate-400"
    placeholder="Pertanyaan polling...">
                            </div>
                            <div id="poll_options_container" class="space-y-2">
                                <label class="block text-xs font-medium text-slate-200">Pilihan Jawaban</label>
                                @foreach ($post->poll->options as $option)
                                    <div class="flex items-center gap-2 poll-option-entry">
                                        <input type="hidden" name="poll_option_ids[]" value="{{ $option->id }}">
                                        <input type="text" name="poll_options[]" value="{{ old('poll_options.'.$loop->index, $option->text) }}"
    class="w-full bg-slate-800/60 text-white border border-slate-700 rounded-lg p-3 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition duration-200 placeholder-slate-400"
    placeholder="Pilihan {{ $loop->iteration }}">
                                        <button type="button" class="remove-poll-option-button text-red-500/80 hover:text-red-500 font-bold text-xl transition">&times;</button>
                                    </div>
                                @endforeach
                            </div>
                            @error('poll_options') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                            @error('poll_options.*') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                            <button type="button" id="add_poll_option_button" class="text-xs font-medium text-teal-400 hover:text-teal-300 transition">+ Tambah Pilihan</button>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Tombol Aksi --}}
                <div class="flex flex-col-reverse sm:flex-row sm:justify-between items-center pt-6 mt-8 border-t border-slate-700">
                    <a href="{{ route('forum.index') }}" class="inline-flex items-center gap-2 text-slate-300 hover:text-white transition duration-200 mt-4 sm:mt-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                        <span>Kembali</span>
                    </a>
                    <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-gradient-to-r from-blue-500 to-teal-500 hover:from-blue-600 hover:to-teal-600 text-white px-8 py-3 rounded-lg text-base font-semibold shadow-lg shadow-teal-900/40 hover:shadow-lg hover:shadow-teal-700/40 transition-all duration-300 transform hover:-translate-y-0.5 focus:outline-none focus:ring-4 focus:ring-teal-400 focus:ring-opacity-75">
                        <svg xmlns="[http://www.w3.org/2000/svg](http://www.w3.org/2000/svg)" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                        <span>Simpan Perubahan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Gaya BARU untuk form input terang (teks hitam) di atas latar gelap */
    .form-input-light {
        @apply w-full bg-white text-gray-900 border border-gray-300 rounded-lg p-2 sm:p-3;
        @apply focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500;
        @apply transition duration-200 placeholder-gray-500;
    }
    .form-checkbox-light {
        @apply h-4 w-4 rounded border-gray-400 text-teal-600 bg-gray-100;
        @apply focus:ring-teal-500 focus:ring-offset-slate-900;
    }
</style>
@endpush

@push('scripts')
<script>
    // Script polling tetap sama, hanya akan men-clone elemen dengan class baru
    document.addEventListener('DOMContentLoaded', function () {
        const optionsContainer = document.getElementById('poll_options_container');

        function attachRemoveListener(button) {
            button.addEventListener('click', function() {
                this.closest('.poll-option-entry').remove();
                updatePlaceholders();
            });
        }

        function updatePlaceholders() {
            if (!optionsContainer) return;
            const allOptionInputs = optionsContainer.querySelectorAll('input.form-input-light');
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
                newOptionInput.className = 'form-input-light text-sm'; // Menggunakan class baru

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
    });
</script>
@endpush
</x-app-layout>