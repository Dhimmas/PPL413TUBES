<x-app-layout>
    <div class="max-w-7xl mx-auto mb-12 px-4 sm:px-6 lg:px-8">
        {{-- Header dengan Judul dan Tombol Tambah Quiz --}}
        <div class="flex flex-col sm:flex-row justify-between items-center mb-12 gap-8">
            <h1 class="text-5xl font-extrabold text-white tracking-tight leading-tight text-center sm:text-left">
                <span class="bg-clip-text text-transparent bg-gradient-to-r from-teal-400 to-cyan-600 animate-gradient-pulse">
                    📚 Jelajahi Quiz Seru!
                </span>
            </h1>
            @auth
                @if(auth()->user()->is_admin)
                    <a href="{{ route('admin.quiz.create') }}"
                       class="inline-flex items-center gap-3 bg-gradient-to-r from-blue-600 to-purple-700 hover:from-blue-700 hover:to-purple-800 text-white px-8 py-4 rounded-xl text-lg font-semibold shadow-xl hover:shadow-2xl transition duration-300 transform hover:-translate-y-1 hover:scale-105 focus:outline-none focus:ring-4 focus:ring-blue-300 focus:ring-opacity-75">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Buat Quiz Baru
                    </a>
                @endif
            @endauth
        </div>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 shadow-md">
                {{ session('success') }}
            </div>
        @endif

        {{-- Filter dan Search Section --}}
        <div class="mb-8 p-6 bg-white/10 backdrop-blur-lg rounded-2xl shadow-xl border border-white/20">
            <form action="{{ route('quiz.index') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-center">
                {{-- Filter Kategori (Dropdown) --}}
                <div class="flex-1 w-full md:w-auto">
                    <label for="category_filter" class="block text-sm font-medium text-white mb-2">Filter Kategori:</label>
                    <select name="category" id="category_filter" onchange="this.form.submit()"
                            class="block w-full rounded-md shadow-sm bg-white/15 border-white/20 text-white
                                   focus:border-blue-500 focus:ring-blue-500 transition duration-200">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->slug }}" {{ request('category') == $category->slug ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Search Bar --}}
                <div class="flex-1 w-full md:w-auto">
                    <label for="search_quiz" class="block text-sm font-medium text-white mb-2">Cari Quiz:</label>
                    <div class="relative">
                        <input type="text" name="search" id="search_quiz" placeholder="Cari berdasarkan judul..."
                               value="{{ request('search') }}"
                               class="block w-full pl-10 pr-3 py-2 rounded-md shadow-sm bg-white/15 border-white/20 text-white placeholder-white/50
                                      focus:border-blue-500 focus:ring-blue-500 transition duration-200">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Tombol Reset Filter --}}
                @if(request('category') || request('search'))
                    <a href="{{ route('quiz.index') }}"
                       class="mt-auto px-5 py-2 md:py-3 rounded-md bg-red-600 hover:bg-red-700 text-white font-semibold shadow-md transition duration-200">
                        Reset Filter
                    </a>
                @endif

                {{-- Tombol Submit --}}
                <button type="submit" class="mt-auto px-5 py-2 md:py-3 rounded-md bg-blue-600 hover:bg-blue-700 text-white font-semibold shadow-md transition duration-200">
                    Filter
                </button>
            </form>
        </div>

        {{-- Quiz List --}}
        @if($quizzes->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($quizzes as $quiz)
                    <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-6 transition-all duration-300 hover:bg-white/20 shadow-xl hover:shadow-3xl border border-transparent hover:border-white/30 transform hover:-translate-y-1 relative group overflow-hidden">
                        {{-- Quiz Image (jika ada, dengan overlay) --}}
                        @if($quiz->image)
                            <div class="relative mb-4 rounded-xl overflow-hidden shadow-lg group-hover:shadow-xl transition-shadow duration-300">
                                <img src="{{ asset('storage/'.$quiz->image) }}" alt="{{ $quiz->title }}" class="w-full h-48 object-cover object-center transform group-hover:scale-105 transition-transform duration-500 ease-in-out">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-4">
                                    <span class="text-white text-lg font-bold">{{ $quiz->title }}</span>
                                </div>
                            </div>
                        @else
                            {{-- Placeholder jika tidak ada gambar --}}
                            <div class="bg-gray-700 rounded-xl h-48 flex items-center justify-center mb-4 shadow-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        @endif

                        <h2 class="text-2xl font-bold text-white mb-2 group-hover:text-teal-300 transition-colors duration-200">{{ $quiz->title }}</h2>
                        <p class="text-white/70 mb-4 line-clamp-3 leading-relaxed">{{ $quiz->description }}</p>

                        {{-- Quiz Info dengan Status Badge --}}
                        <div class="flex justify-between items-center text-sm text-white/60 mb-4">
                            <div class="flex items-center gap-4">
                                <span class="inline-flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    {{ $quiz->questions_count }} Soal
                                </span>
                                @if($quiz->time_limit_per_quiz)
                                    <span class="inline-flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        {{ $quiz->time_limit_per_quiz }} menit
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{-- Quiz Status Badge --}}
                        @auth
                            @if(isset($quiz->user_status))
                                <div class="mb-4">
                                    @if($quiz->user_status === 'completed')
                                        <span class="inline-flex items-center gap-2 bg-green-500/20 text-green-300 px-3 py-1 rounded-full text-sm font-medium">
                                            <i class="fas fa-check-circle"></i>
                                            Quiz Selesai
                                        </span>
                                    @elseif($quiz->user_status === 'in_progress')
                                        <span class="inline-flex items-center gap-2 bg-yellow-500/20 text-yellow-300 px-3 py-1 rounded-full text-sm font-medium">
                                            <i class="fas fa-play-circle"></i>
                                            Sedang Dikerjakan
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-2 bg-blue-500/20 text-blue-300 px-3 py-1 rounded-full text-sm font-medium">
                                            <i class="fas fa-plus-circle"></i>
                                            Belum Dikerjakan
                                        </span>
                                    @endif
                                </div>
                            @endif
                        @endauth

                        {{-- Kategori --}}
                        <div class="mb-4">
                            <span class="inline-flex items-center gap-1 text-sm text-white/60">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                </svg>
                                {{ $quiz->category?->name ?? 'Tidak Berkategori' }}
                            </span>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="space-y-2">
                            {{-- Tombol Utama (Dynamic berdasarkan status) --}}
                            @auth
                                @if(isset($quiz->user_status))
                                    @if($quiz->user_status === 'completed')
                                        {{-- Quiz sudah selesai - tombol lihat hasil --}}
                                        <a href="{{ route('quiz.result', $quiz->id) }}" 
                                        class="w-full inline-flex items-center justify-center gap-2 bg-gradient-to-r from-green-500 to-emerald-500 hover:from-green-600 hover:to-emerald-600 text-white py-3 rounded-xl transition duration-300 font-semibold shadow-md hover:shadow-lg transform hover:scale-105">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                            </svg>
                                            Lihat Hasil
                                        </a>
                                    @elseif($quiz->user_status === 'in_progress')
                                        {{-- Quiz sedang dikerjakan - tombol lanjutkan --}}
                                        <a href="{{ route('quiz.attempt', $quiz->id) }}" 
                                            class="w-full inline-flex items-center justify-center gap-2 bg-gradient-to-r from-yellow-500 to-orange-500 hover:from-yellow-600 hover:to-orange-600 text-white py-3 rounded-xl transition duration-300 font-semibold shadow-md hover:shadow-lg transform hover:scale-105">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1.586a1 1 0 01.707.293l2.414 2.414a1 1 0 00.707.293H15M9 10v4a6 6 0 006 6v-3" />
                                            </svg>
                                            Lanjutkan Quiz
                                        </a>
                                    @else
                                        {{-- Quiz belum dikerjakan - tombol mulai --}}
                                        <a href="{{ route('quiz.attempt', $quiz->id) }}" 
                                        class="w-full inline-flex items-center justify-center gap-2 bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white py-3 rounded-xl transition duration-300 font-semibold shadow-md hover:shadow-lg transform hover:scale-105">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1.586a1 1 0 01.707.293l2.414 2.414a1 1 0 00.707.293H15M9 10v4a6 6 0 006 6v-3" />
                                            </svg>
                                            Mulai Quiz
                                        </a>
                                    @endif
                                @endif
                            @else
                                {{-- User belum login --}}
                                <a href="{{ route('login') }}" 
                                   class="w-full inline-flex items-center justify-center gap-2 bg-gradient-to-r from-gray-600 to-gray-700 hover:from-gray-700 hover:to-gray-800 text-white py-3 rounded-xl transition duration-300 font-semibold shadow-md hover:shadow-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                    </svg>
                                    Login untuk Mulai
                                </a>
                            @endauth

                            {{-- Secondary Actions Row --}}
                            <div class="flex gap-2">
                                {{-- Admin Actions (dalam dropdown kecil) --}}
                                @auth
                                    @if(auth()->user()->is_admin)
                                        <a href="{{ route('admin.quiz.show', $quiz->id) }}" 
                                           class="flex-1 bg-gray-600 hover:bg-gray-700 text-white text-center py-2 px-3 rounded-lg text-sm transition duration-200">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            Manage
                                        </a>
                                    @endif
                                @endauth
                            </div>

                            {{-- Admin Action Buttons (Full Row) --}}
                            @auth
                                @if(auth()->user()->is_admin)
                                    <div class="flex gap-2">
                                        <a href="{{ route('admin.quiz.edit', $quiz->id) }}" 
                                           class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-center py-2 px-3 rounded-lg text-sm transition duration-200">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.quiz.destroy', $quiz->id) }}" method="POST" class="flex-1">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    onclick="return confirm('Yakin ingin menghapus quiz ini?')" 
                                                    class="w-full bg-red-600 hover:bg-red-700 text-white py-2 px-3 rounded-lg text-sm transition duration-200">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            @endauth
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-16 flex justify-center">
                {{ $quizzes->links() }}
            </div>
        @else
            {{-- Pesan Khusus Jika Tidak Ada Quiz yang Ditemukan --}}
            <div class="text-center py-20 bg-white/5 backdrop-blur-sm rounded-2xl shadow-lg border border-white/10">
                <svg class="mx-auto h-20 w-20 text-teal-400/70 mb-6 animate-bounce-slow" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z" />
                </svg>
                @if(request('category') && $currentCategory)
                    <p class="text-white/90 text-2xl font-bold mb-3">
                        Oops! Belum ada quiz untuk kategori "{{ $currentCategory->name }}" saat ini.
                    </p>
                @elseif(request('search'))
                    <p class="text-white/90 text-2xl font-bold mb-3">
                        Maaf, tidak ditemukan quiz dengan judul "{{ request('search') }}".
                    </p>
                @else
                    <p class="text-white/90 text-2xl font-bold mb-3">Belum ada quiz yang tersedia nih...</p>
                @endif
                <p class="text-white/70 text-lg mb-8">Jadilah yang pertama membuat quiz yang menarik!</p>
                @auth
                    @if(auth()->user()->is_admin)
                        <a href="{{ route('admin.quiz.create') }}"
                           class="inline-flex items-center gap-3 bg-gradient-to-r from-blue-600 to-purple-700 hover:from-blue-700 hover:to-purple-800 text-white px-8 py-4 rounded-xl text-lg font-semibold shadow-xl hover:shadow-2xl transition duration-300 transform hover:-translate-y-1 hover:scale-105 focus:outline-none focus:ring-4 focus:ring-blue-300 focus:ring-opacity-75">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Buat Quiz Baru
                        </a>
                    @endif
                @endauth
            </div>
        @endif
    </div>
</x-app-layout>