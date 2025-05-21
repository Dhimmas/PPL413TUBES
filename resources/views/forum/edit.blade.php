<x-app-layout>
    {{-- Slot untuk Header atau Navigasi --}}
    <x-slot name="header">
        @include('layouts.navigation') {{-- Navigation bar Anda masuk di sini --}}
    </x-slot>

    {{-- Main Content --}}
    <div class="fixed inset-0 flex items-center justify-center bg-gray-900 z-40">
        <div class="max-w-xl w-full bg-white/10 backdrop-blur-lg rounded-2xl p-8 md:p-10 shadow-2xl border border-white/20 transition-all duration-300 transform hover:scale-[1.01] relative z-50">
            <div class="text-center mb-8">
                <h1 class="text-4xl font-extrabold text-white tracking-tight">
                    <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-400 to-purple-600 animate-gradient-pulse">
                        📝 Edit Postingan
                    </span>
                </h1>
                <p class="text-white/70 mt-2">Perbarui diskusi Anda dengan informasi terbaru.</p>
            </div>

            <form action="{{ route('forum.update', $post->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Judul --}}
                <div class="mb-6">
                    <label for="title" class="block text-sm font-semibold text-white mb-2">Judul Diskusi</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $post->title) }}"
                        class="w-full bg-white/5 text-white border border-white/20 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition duration-200 placeholder-white/50"
                        placeholder="Masukkan judul postingan Anda" required>
                    @error('title')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Konten --}}
                <div class="mb-6">
                    <label for="content" class="block text-sm font-semibold text-white mb-2">Konten Diskusi</label>
                    <textarea name="content" id="content" rows="7"
                        class="w-full bg-white/5 text-white border border-white/20 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition duration-200 placeholder-white/50"
                        placeholder="Tuliskan isi diskusi Anda di sini..." required>{{ old('content', $post->content) }}</textarea>
                    @error('content')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Gambar --}}
                <div class="mb-6">
                    <label for="image" class="block text-sm font-semibold text-white mb-2">Unggah Gambar (Opsional)</label>
                    <input type="file" name="image" id="image"
                        class="w-full text-white/80 file:mr-4 file:py-2 file:px-4
                        file:rounded-lg file:border-0 file:text-sm file:font-semibold
                        file:bg-blue-500 file:text-white hover:file:bg-blue-600
                        file:transition-all file:duration-200 cursor-pointer
                        focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 focus:ring-offset-gray-900">
                    @error('image')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tampilkan Gambar Lama --}}
                @if ($post->image)
                    <div class="mb-8">
                        <p class="text-sm text-white/70 mb-2">Gambar saat ini:</p>
                        <img src="{{ asset('storage/' . $post->image) }}" alt="Current image"
                            class="max-w-xs h-auto rounded-lg border border-white/20 shadow-md">
                        <div class="mt-3">
                            <input type="checkbox" name="remove_image" id="remove_image"
                                class="rounded border-gray-300 text-red-500 shadow-sm focus:border-red-300 focus:ring focus:ring-red-200 focus:ring-opacity-50">
                            <label for="remove_image" class="text-sm text-white/70 ml-2">Hapus Gambar Ini</label>
                        </div>
                    </div>
                @endif

                {{-- Tombol --}}
                <div class="flex justify-between items-center mt-8">
                    <a href="{{ route('forum.show', $post->id) }}"
                        class="inline-flex items-center gap-2 text-white/70 hover:text-white transition duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Batal
                    </a>
                    <button type="submit"
                        class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-purple-700 hover:from-blue-700 hover:to-purple-800 text-white px-6 py-3 rounded-lg text-lg font-semibold shadow-xl hover:shadow-2xl transition duration-300 transform hover:-translate-y-0.5 hover:scale-105 focus:outline-none focus:ring-4 focus:ring-blue-300 focus:ring-opacity-75">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('styles')
        <style>
            @keyframes gradient-pulse {
                0%, 100% { background-position: 0% 50%; }
                50% { background-position: 100% 50%; }
            }

            .animate-gradient-pulse {
                background-size: 200% auto;
                animation: gradient-pulse 4s ease infinite;
            }
        </style>
    @endpush

    @push('scripts')
        {{-- Tambahkan script editor jika ingin --}}
    @endpush
</x-app-layout>
