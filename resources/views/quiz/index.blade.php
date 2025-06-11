<x-app-layout>
    <div class="max-w-7xl mx-auto mb-12 px-4 sm:px-6 lg:px-8">
        {{-- Header dengan Judul dan Tombol Tambah Quiz --}}
        <div class="flex flex-col sm:flex-row justify-between items-center mb-12 gap-8">
            @auth
                @if(auth()->user()->is_admin)
                    <a href="{{ route('admin.quiz.create') }}"
                       class="inline-flex items-center gap-3 bg-gradient-to-r from-blue-600 to-purple-700 hover:from-blue-700 hover:to-purple-800 text-white px-8 py-4 rounded-xl text-lg font-semibold shadow-xl hover:shadow-2xl transition duration-300 transform hover:-translate-y-1 hover:scale-105 focus:outline-none focus:ring-4 focus:ring-blue-300 focus:ring-opacity-75">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                        ✨ Buat Quiz Baru
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
            <div class="text-center mb-6">
                <h2 class="text-2xl font-bold text-white mb-2">🔍 Temukan Quiz Favoritmu</h2>
                <p class="text-white/70">Filter berdasarkan kategori atau cari dengan kata kunci</p>
            </div>
            <form action="{{ route('quiz.index') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-center">
                {{-- Filter Kategori (Dropdown) --}}
                <div class="flex-1 w-full md:w-auto">
                    <label for="category_filter" class="block text-sm font-medium text-white mb-2 flex items-center gap-2">
                        🏷️ Filter Kategori:
                    </label>
                    <select name="category" id="category_filter" onchange="this.form.submit()"
                            class="block w-full rounded-md shadow-sm bg-gray-800 border-gray-600 text-white
                                   focus:border-blue-500 focus:ring-blue-500 transition duration-200
                                   appearance-none px-3 py-2">
                        <option value="" class="bg-gray-800 text-white">🌟 Semua Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->slug }}" {{ request('category') == $category->slug ? 'selected' : '' }}
                                    class="bg-gray-800 text-white">
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Search Bar --}}
                <div class="flex-1 w-full md:w-auto">
                    <label for="search_quiz" class="block text-sm font-medium text-white mb-2 flex items-center gap-2">
                        🔎 Cari Quiz:
                    </label>
                    <div class="relative">
                        <input type="text" name="search" id="search_quiz" placeholder="Ketik kata kunci quiz yang dicari..."
                               value="{{ request('search') }}"
                               class="block w-full pl-10 pr-3 py-2 rounded-md shadow-sm bg-gray-800 border-gray-600 text-white placeholder-gray-400
                                      focus:border-blue-500 focus:ring-blue-500 focus:ring-2 focus:ring-opacity-50 transition duration-200">
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
                       class="mt-auto px-5 py-2 md:py-3 rounded-md bg-red-600 hover:bg-red-700 text-white font-semibold shadow-md transition duration-200 flex items-center gap-2">
                        🔄 Reset Filter
                    </a>
                @endif

                {{-- Tombol Submit --}}
                <button type="submit" class="mt-auto px-5 py-2 md:py-3 rounded-md bg-blue-600 hover:bg-blue-700 text-white font-semibold shadow-md transition duration-200 flex items-center gap-2">
                    🎯 Cari Quiz
                </button>
            </form>
        </div>

        {{-- Quiz Stats Banner --}}
        <div class="mb-8 bg-gradient-to-r from-purple-600/20 to-blue-600/20 backdrop-blur-lg rounded-2xl p-6 border border-white/20">
            <div class="text-center">
                <h3 class="text-xl font-bold text-white mb-2">📊 Statistik Quiz Platform</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                    <div class="bg-white/10 rounded-xl p-4">
                        <div class="text-2xl font-bold text-teal-400">{{ $quizzes->total() }}</div>
                        <div class="text-white/70 text-sm">Total Quiz Tersedia</div>
                    </div>
                    <div class="bg-white/10 rounded-xl p-4">
                        <div class="text-2xl font-bold text-blue-400">{{ $categories->count() }}</div>
                        <div class="text-white/70 text-sm">Kategori Beragam</div>
                    </div>
                    <div class="bg-white/10 rounded-xl p-4">
                        <div class="text-2xl font-bold text-purple-400">∞</div>
                        <div class="text-white/70 text-sm">Kesempatan Belajar</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Quiz List --}}
        @if($quizzes->count() > 0)
            <div class="mb-8">
                <h2 class="text-3xl font-bold text-white text-center mb-8">
                    🎮 Pilih Quiz & Mulai Petualangan Belajar!
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($quizzes as $quiz)
                        <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-6 transition-all duration-300 hover:bg-white/20 shadow-xl hover:shadow-3xl border border-transparent hover:border-white/30 transform hover:-translate-y-1 relative group overflow-hidden">
                            {{-- Decorative Elements --}}
                            <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-teal-400/20 to-blue-600/20 rounded-full blur-xl"></div>
                            <div class="absolute bottom-0 left-0 w-16 h-16 bg-gradient-to-tr from-purple-400/20 to-pink-600/20 rounded-full blur-lg"></div>
                            
                            {{-- Quiz Image (jika ada, dengan overlay) --}}
                            @if($quiz->image)
                                <div class="relative mb-4 rounded-xl overflow-hidden shadow-lg group-hover:shadow-xl transition-shadow duration-300">
                                    <img src="{{ asset('storage/'.$quiz->image) }}" alt="{{ $quiz->title }}" class="w-full h-48 object-cover object-center transform group-hover:scale-105 transition-transform duration-500 ease-in-out">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-4">
                                        <span class="text-white text-lg font-bold">{{ $quiz->title }}</span>
                                    </div>
                                    {{-- Quiz Type Badge --}}
                                    <div class="absolute top-3 left-3 bg-gradient-to-r from-blue-500 to-purple-600 text-white px-3 py-1 rounded-full text-xs font-bold">
                                        🎯 QUIZ
                                    </div>
                                </div>
                            @else
                                {{-- Enhanced Placeholder --}}
                                <div class="bg-gradient-to-br from-gray-700 to-gray-800 rounded-xl h-48 flex flex-col items-center justify-center mb-4 shadow-lg relative overflow-hidden">
                                    <div class="absolute inset-0 bg-gradient-to-r from-teal-500/20 to-blue-500/20"></div>
                                    <div class="relative z-10 text-center">
                                        <div class="text-5xl mb-2">🎓</div>
                                        <div class="text-white font-semibold">{{ $quiz->title }}</div>
                                        <div class="text-white/60 text-sm mt-1">Quiz Edukatif</div>
                                    </div>
                                </div>
                            @endif

                            <h2 class="text-2xl font-bold text-white mb-2 group-hover:text-teal-300 transition-colors duration-200">
                                {{ $quiz->title }}
                            </h2>
                            <p class="text-white/70 mb-4 line-clamp-3 leading-relaxed">
                                {{ $quiz->description ?: 'Tantang diri Anda dengan quiz menarik ini! Uji pengetahuan dan tingkatkan kemampuan Anda.' }}
                            </p>

                            {{-- Enhanced Quiz Info --}}
                            <div class="flex justify-between items-center text-sm text-white/60 mb-4">
                                <div class="flex items-center gap-4">
                                    <span class="inline-flex items-center gap-1 bg-blue-500/20 px-2 py-1 rounded-full">
                                        📝 {{ $quiz->questions_count }} Soal
                                    </span>
                                    @if($quiz->time_limit_per_quiz)
                                        <span class="inline-flex items-center gap-1 bg-orange-500/20 px-2 py-1 rounded-full">
                                            ⏱️ {{ $quiz->time_limit_per_quiz }} menit
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 bg-green-500/20 px-2 py-1 rounded-full">
                                            ♾️ Unlimited
                                        </span>
                                    @endif
                                </div>
                            </div>

                            {{-- Enhanced Quiz Status Badge --}}
                            @auth
                                @if(isset($quiz->user_status))
                                    <div class="mb-4">
                                        @if($quiz->user_status === 'completed')
                                            <span class="inline-flex items-center gap-2 bg-green-500/20 text-green-300 px-3 py-2 rounded-full text-sm font-medium border border-green-500/30">
                                                ✅ Quiz Selesai
                                            </span>
                                        @elseif($quiz->user_status === 'in_progress')
                                            <span class="inline-flex items-center gap-2 bg-yellow-500/20 text-yellow-300 px-3 py-2 rounded-full text-sm font-medium border border-yellow-500/30">
                                                ⚡ Sedang Dikerjakan
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-2 bg-blue-500/20 text-blue-300 px-3 py-2 rounded-full text-sm font-medium border border-blue-500/30">
                                                🚀 Siap Dimulai
                                            </span>
                                        @endif
                                    </div>
                                @endif
                            @endauth

                            {{-- Enhanced Kategori --}}
                            <div class="mb-4">
                                <span class="inline-flex items-center gap-1 text-sm text-white/60 bg-white/5 px-3 py-1 rounded-full">
                                    🏷️ {{ $quiz->category?->name ?? 'Umum' }}
                                </span>
                            </div>

                            {{-- Enhanced Action Buttons --}}
                            <div class="space-y-2">
                                {{-- Tombol Utama (Dynamic berdasarkan status) --}}
                                @auth
                                    @if(isset($quiz->user_status))
                                        @if($quiz->user_status === 'completed')
                                            {{-- Quiz sudah selesai - tombol lihat hasil --}}
                                            <a href="{{ route('quiz.result', $quiz->id) }}" 
                                            class="w-full inline-flex items-center justify-center gap-2 bg-gradient-to-r from-green-500 to-emerald-500 hover:from-green-600 hover:to-emerald-600 text-white py-3 rounded-xl transition duration-300 font-semibold shadow-md hover:shadow-lg transform hover:scale-105">
                                                📊 Lihat Hasil Saya
                                            </a>
                                        @elseif($quiz->user_status === 'in_progress')
                                            {{-- Quiz sedang dikerjakan - tombol lanjutkan --}}
                                            <a href="{{ route('quiz.attempt', $quiz->id) }}" 
                                                class="w-full inline-flex items-center justify-center gap-2 bg-gradient-to-r from-yellow-500 to-orange-500 hover:from-yellow-600 hover:to-orange-600 text-white py-3 rounded-xl transition duration-300 font-semibold shadow-md hover:shadow-lg transform hover:scale-105">
                                                ⚡ Lanjutkan Quiz
                                            </a>
                                        @else
                                            {{-- Quiz belum dikerjakan - tombol mulai --}}
                                            <a href="{{ route('quiz.attempt', $quiz->id) }}" 
                                            class="w-full inline-flex items-center justify-center gap-2 bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white py-3 rounded-xl transition duration-300 font-semibold shadow-md hover:shadow-lg transform hover:scale-105">
                                                🚀 Mulai Quiz Sekarang
                                            </a>
                                        @endif
                                    @endif
                                @else
                                    {{-- User belum login --}}
                                    <a href="{{ route('login') }}" 
                                       class="w-full inline-flex items-center justify-center gap-2 bg-gradient-to-r from-gray-600 to-gray-700 hover:from-gray-700 hover:to-gray-800 text-white py-3 rounded-xl transition duration-300 font-semibold shadow-md hover:shadow-lg">
                                        🔐 Login untuk Mulai
                                    </a>
                                @endauth

                                {{-- Secondary Actions Row --}}
                                <div class="flex gap-2">
                                    {{-- View Ranking Button --}}
                                    <a href="{{ route('quiz.ranking', $quiz) }}" 
                                       class="flex-1 bg-purple-600/80 hover:bg-purple-700 text-white text-center py-2 px-3 rounded-lg text-sm transition duration-200 flex items-center justify-center gap-1">
                                        🏆 Ranking
                                    </a>
                                    
                                    {{-- Admin Actions --}}
                                    @auth
                                        @if(auth()->user()->is_admin)
                                            <a href="{{ route('admin.quiz.show', $quiz->id) }}" 
                                               class="flex-1 bg-gray-600 hover:bg-gray-700 text-white text-center py-2 px-3 rounded-lg text-sm transition duration-200 flex items-center justify-center gap-1">
                                                ⚙️ Manage
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
                                                ✏️ Edit
                                            </a>
                                            <form action="{{ route('admin.quiz.destroy', $quiz->id) }}" method="POST" class="flex-1">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        onclick="return confirm('Yakin ingin menghapus quiz ini?')" 
                                                        class="w-full bg-red-600 hover:bg-red-700 text-white py-2 px-3 rounded-lg text-sm transition duration-200">
                                                    🗑️ Hapus
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                @endauth
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            
            {{-- Pagination --}}
            <div class="mt-16 flex justify-center">
                {{ $quizzes->links() }}
            </div>
        @else
            {{-- Enhanced Empty State --}}
            <div class="text-center py-20 bg-white/5 backdrop-blur-sm rounded-2xl shadow-lg border border-white/10">
                <div class="relative inline-block mb-8">
                    <div class="text-8xl mb-4">🎯</div>
                    <div class="absolute inset-0 bg-gradient-to-t from-teal-500/10 to-transparent rounded-full blur-2xl"></div>
                </div>
                
                @if(request('category') && $currentCategory)
                    <p class="text-white/90 text-3xl font-bold mb-4">
                        🔍 Belum ada quiz untuk kategori "{{ $currentCategory->name }}"
                    </p>
                    <p class="text-white/70 text-xl mb-8">Jangan khawatir! Quiz baru akan segera hadir. Stay tuned! ⏳</p>
                @elseif(request('search'))
                    <p class="text-white/90 text-3xl font-bold mb-4">
                        🤔 Quiz "{{ request('search') }}" tidak ditemukan
                    </p>
                    <p class="text-white/70 text-xl mb-8">Coba kata kunci lain atau jelajahi kategori yang tersedia! 🔄</p>
                @else
                    <p class="text-white/90 text-3xl font-bold mb-4">🌟 Belum ada quiz yang tersedia</p>
                    <p class="text-white/70 text-xl mb-8">Jadilah yang pertama membuat quiz yang menginspirasi! 💡</p>
                @endif
                
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                    @auth
                        @if(auth()->user()->is_admin)
                            <a href="{{ route('admin.quiz.create') }}"
                               class="inline-flex items-center gap-3 bg-gradient-to-r from-blue-600 to-purple-700 hover:from-blue-700 hover:to-purple-800 text-white px-8 py-4 rounded-xl text-lg font-semibold shadow-xl hover:shadow-2xl transition duration-300 transform hover:-translate-y-1 hover:scale-105">
                                ✨ Buat Quiz Pertama
                            </a>
                        @endif
                    @endauth
                    
                    @if(request('category') || request('search'))
                        <a href="{{ route('quiz.index') }}"
                           class="inline-flex items-center gap-2 bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-xl font-semibold transition duration-200">
                            🏠 Kembali ke Semua Quiz
                        </a>
                    @endif
                </div>
            </div>
        @endif
    </div>
</x-app-layout>