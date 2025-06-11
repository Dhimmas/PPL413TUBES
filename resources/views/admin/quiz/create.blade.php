<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-gray-900 via-purple-900 to-gray-900 py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-6 shadow-xl border border-white/20">
                    <h1 class="text-3xl md:text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-400 mb-2">
                        ✨ Buat Quiz Baru
                    </h1>
                    <p class="text-white/70 text-lg">Buat quiz yang menarik untuk para pembelajar</p>
                </div>
            </div>

            <!-- Form Container -->
            <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-8 shadow-xl border border-white/20 text-white">
                <form method="POST" action="{{ route('admin.quiz.store') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <!-- Grid Layout for Form Fields -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Left Column -->
                        <div class="space-y-6">
                            <!-- Judul Quiz -->
                            <div>
                                <label class="block mb-2 text-white font-semibold">
                                    <i class="fas fa-heading mr-2 text-blue-400"></i>Judul Quiz
                                </label>
                                <input type="text" name="title" 
                                       class="w-full p-4 rounded-xl bg-white/10 text-white placeholder-white/50 border border-white/20 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" 
                                       placeholder="Masukkan judul quiz yang menarik..." 
                                       required>
                                @error('title')
                                    <p class="text-red-300 text-sm mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Deskripsi -->
                            <div>
                                <label class="block mb-2 text-white font-semibold">
                                    <i class="fas fa-align-left mr-2 text-green-400"></i>Deskripsi
                                </label>
                                <textarea name="description" rows="4"
                                          class="w-full p-4 rounded-xl bg-white/10 text-white placeholder-white/50 border border-white/20 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all resize-none" 
                                          placeholder="Jelaskan tentang quiz ini..."></textarea>
                                @error('description')
                                    <p class="text-red-300 text-sm mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Gambar Quiz -->
                            <div>
                                <label class="block mb-2 text-white font-semibold">
                                    <i class="fas fa-image mr-2 text-purple-400"></i>Gambar Quiz
                                </label>
                                <input type="file" name="image" 
                                       class="w-full p-4 rounded-xl bg-white/10 text-white border border-white/20 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-blue-500 file:text-white file:cursor-pointer hover:file:bg-blue-600">
                                @error('image')
                                    <p class="text-red-300 text-sm mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-6">
                            <!-- Kategori -->
                            <div>
                                <label class="block mb-2 text-white font-semibold">
                                    <i class="fas fa-tag mr-2 text-yellow-400"></i>Kategori
                                </label>
                                <div class="space-y-3">
                                    <!-- Input Kategori Baru -->
                                    <input type="text" name="new_category" 
                                           placeholder="Buat kategori baru..." 
                                           class="w-full p-4 rounded-xl bg-white/10 text-white placeholder-white/50 border border-white/20 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-all">
                                    
                                    <!-- Atau Pilih yang Ada -->
                                    <div class="relative">
                                        <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-white/50 text-sm">atau pilih yang sudah ada:</span>
                                        <select name="category_id" 
                                                class="w-full p-4 pt-8 rounded-xl bg-white/10 text-white border border-white/20 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-all">
                                            <option value="" class="bg-gray-800">Pilih Kategori</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" class="bg-gray-800">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                @error('category_id')
                                    <p class="text-red-300 text-sm mt-2">{{ $message }}</p>
                                @enderror
                                @error('new_category')
                                    <p class="text-red-300 text-sm mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Batas Waktu -->
                            <div>
                                <label class="block mb-2 text-white font-semibold">
                                    <i class="fas fa-clock mr-2 text-red-400"></i>Batas Waktu Quiz (Menit)
                                </label>
                                <input type="number" name="time_limit_per_quiz" min="0"
                                       class="w-full p-4 rounded-xl bg-white/10 text-white placeholder-white/50 border border-white/20 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all" 
                                       placeholder="Contoh: 60 (kosongkan jika tidak ada batas)">
                                <p class="text-white/50 text-sm mt-2">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Kosongkan jika ingin menghitung dari waktu per soal
                                </p>
                                @error('time_limit_per_quiz')
                                    <p class="text-red-300 text-sm mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Info Box -->
                            <div class="bg-blue-500/20 border border-blue-500/50 rounded-xl p-4">
                                <div class="flex items-start">
                                    <i class="fas fa-lightbulb text-blue-400 mt-1 mr-3"></i>
                                    <div>
                                        <h4 class="text-blue-300 font-semibold mb-1">Tips:</h4>
                                        <p class="text-blue-200 text-sm">Setelah membuat quiz, Anda dapat langsung menambahkan soal-soal yang menarik!</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row justify-between items-center gap-4 pt-6 border-t border-white/20">
                        <a href="{{ route('admin.quiz.index') }}" 
                           class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Kembali
                        </a>
                        <button type="submit" 
                                class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-3 bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105">
                            <i class="fas fa-plus mr-2"></i>
                            Buat Quiz & Tambah Soal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>