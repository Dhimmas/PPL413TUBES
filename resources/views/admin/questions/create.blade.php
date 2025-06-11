<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-gray-900 via-purple-900 to-gray-900 py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-6 shadow-xl border border-white/20">
                    <h1 class="text-3xl md:text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-green-400 to-blue-400 mb-2">
                        ✨ Tambah Soal Quiz
                    </h1>
                    <h2 class="text-xl md:text-2xl font-bold text-white mb-2">{{ $quiz->title }}</h2>
                    <p class="text-white/70 text-lg">Buat soal-soal yang menantang dan edukatif</p>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.questions.store', $quiz) }}" enctype="multipart/form-data" class="space-y-8">
                @csrf

                @if ($errors->any())
                    <div class="bg-red-500/20 border border-red-500/50 rounded-2xl p-6 shadow-xl">
                        <div class="flex items-center mb-3">
                            <i class="fas fa-exclamation-triangle text-red-400 mr-3 text-xl"></i>
                            <h3 class="text-red-300 font-semibold text-lg">Terdapat Kesalahan</h3>
                        </div>
                        <ul class="space-y-2">
                            @foreach ($errors->all() as $error)
                                <li class="text-red-200 text-sm">• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div id="question-container" class="space-y-8"></div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row justify-between items-center gap-4 pt-6">
                    <div class="flex gap-3">
                        <a href="{{ route('admin.quiz.show', $quiz) }}" 
                           class="inline-flex items-center px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Kembali
                        </a>
                        <button type="button" onclick="addQuestionForm()" 
                                class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105">
                            <i class="fas fa-plus mr-2"></i>
                            Tambah Soal Baru
                        </button>
                    </div>
                    <button type="submit" 
                            class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105">
                        <i class="fas fa-save mr-2"></i>
                        Simpan Semua Soal
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let questionCount = 0;

        function addQuestionForm() {
            const container = document.getElementById('question-container');
            const index = questionCount++;

            const html = `
            <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-8 shadow-xl border border-white/20 text-white relative" id="question-box-${index}">
                <!-- Header Soal -->
                <div class="flex justify-between items-center mb-6">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center mr-4">
                            <span class="text-white font-bold">${index + 1}</span>
                        </div>
                        <h2 class="text-2xl font-bold text-white">Soal ${index + 1}</h2>
                    </div>
                    ${index > 0 ? `
                    <button type="button" onclick="removeQuestionForm(${index})" 
                            class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition duration-200 transform hover:scale-105">
                        <i class="fas fa-trash mr-2"></i>
                        Hapus
                    </button>
                    ` : ''}
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Left Column -->
                    <div class="space-y-6">
                        <!-- Tipe Soal -->
                        <div>
                            <label class="block mb-2 text-white font-semibold">
                                <i class="fas fa-list mr-2 text-blue-400"></i>Tipe Soal
                            </label>
                            <select name="questions[${index}][question_type]" 
                                    class="w-full p-4 rounded-xl bg-white/10 text-white border border-white/20 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all question-type" 
                                    data-index="${index}" required>
                                <option value="multiple_choice" class="bg-gray-800">Pilihan Ganda</option>
                                <option value="essay" class="bg-gray-800">Essay</option>
                                <option value="file_based" class="bg-gray-800">File-Based (PDF, ZIP, dll)</option>
                            </select>
                        </div>

                        <!-- Batas Waktu -->
                        <div>
                            <label class="block mb-2 text-white font-semibold">
                                <i class="fas fa-clock mr-2 text-yellow-400"></i>Batas Waktu (Menit)
                            </label>
                            <input type="number" name="questions[${index}][time_limit_per_question]" 
                                   class="w-full p-4 rounded-xl bg-white/10 text-white placeholder-white/50 border border-white/20 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-all" 
                                   placeholder="Contoh: 5 (kosongkan jika tidak ada batas)">
                            <p class="text-white/50 text-sm mt-2">
                                <i class="fas fa-info-circle mr-1"></i>
                                Kosongkan jika tidak ada batas waktu untuk soal ini
                            </p>
                        </div>

                        <!-- Gambar Soal -->
                        <div>
                            <label class="block mb-2 text-white font-semibold">
                                <i class="fas fa-image mr-2 text-purple-400"></i>Gambar Soal (Opsional)
                            </label>
                            <div class="relative">
                                <input type="file" name="questions[${index}][image]" id="image-${index}" accept="image/*"
                                       class="hidden" onchange="previewImage(${index}, this)">
                                <div class="image-upload-area cursor-pointer border-2 border-dashed border-white/30 rounded-xl p-6 text-center hover:border-purple-400 hover:bg-white/5 transition-all duration-300" 
                                     onclick="document.getElementById('image-${index}').click()">
                                    <div class="upload-content">
                                        <i class="fas fa-cloud-upload-alt text-4xl text-white/60 mb-3"></i>
                                        <p class="text-white/80 font-medium">Klik untuk upload gambar</p>
                                        <p class="text-white/60 text-sm mt-1">PNG, JPG, GIF hingga 5MB</p>
                                    </div>
                                    <div class="image-preview hidden">
                                        <img src="" alt="Preview" class="max-h-32 mx-auto rounded-lg shadow-lg">
                                        <p class="text-green-400 text-sm mt-2">
                                            <i class="fas fa-check-circle mr-1"></i>
                                            Gambar berhasil dipilih
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-6">
                        <!-- Pertanyaan Teks -->
                        <div>
                            <label class="block mb-2 text-white font-semibold">
                                <i class="fas fa-question-circle mr-2 text-green-400"></i>Teks Soal
                            </label>
                            <textarea name="questions[${index}][question_text]" rows="4"
                                      class="w-full p-4 rounded-xl bg-white/10 text-white placeholder-white/50 border border-white/20 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all resize-none" 
                                      placeholder="Tuliskan soal di sini..." required></textarea>
                        </div>

                        <!-- Upload File Soal -->
                        <div class="hidden" id="file-input-${index}">
                            <label class="block mb-2 text-white font-semibold">
                                <i class="fas fa-file-upload mr-2 text-orange-400"></i>Upload File Soal
                            </label>
                            <div class="relative">
                                <input type="file" name="questions[${index}][question_file]" id="file-${index}"
                                       class="hidden" onchange="previewFile(${index}, this)">
                                <div class="file-upload-area cursor-pointer border-2 border-dashed border-white/30 rounded-xl p-6 text-center hover:border-orange-400 hover:bg-white/5 transition-all duration-300" 
                                     onclick="document.getElementById('file-${index}').click()">
                                    <div class="upload-content">
                                        <i class="fas fa-file-alt text-4xl text-white/60 mb-3"></i>
                                        <p class="text-white/80 font-medium">Klik untuk upload file soal</p>
                                        <p class="text-white/60 text-sm mt-1">PDF, DOC, ZIP, dll.</p>
                                    </div>
                                    <div class="file-preview hidden">
                                        <i class="fas fa-file text-2xl text-orange-400 mb-2"></i>
                                        <p class="file-name text-white text-sm"></p>
                                        <p class="text-green-400 text-sm mt-1">
                                            <i class="fas fa-check-circle mr-1"></i>
                                            File berhasil dipilih
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pilihan Ganda -->
                        <div id="options-input-${index}">
                            <label class="block mb-2 text-white font-semibold">
                                <i class="fas fa-list-ol mr-2 text-indigo-400"></i>Pilihan Jawaban
                            </label>
                            <div class="space-y-3">
                                ${['A', 'B', 'C', 'D'].map((option, i) => `
                                    <div class="flex items-center gap-3 p-3 bg-white/5 rounded-lg hover:bg-white/10 transition-all duration-200">
                                        <input type="radio" name="questions[${index}][correct_option]" value="${i}" 
                                               class="w-5 h-5 text-blue-500 focus:ring-blue-400 focus:ring-2" required>
                                        <div class="w-8 h-8 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-full flex items-center justify-center">
                                            <span class="text-white font-bold text-sm">${option}</span>
                                        </div>
                                        <input type="text" name="questions[${index}][options][]" 
                                               placeholder="Masukkan pilihan ${option}" 
                                               class="flex-1 p-3 rounded-lg bg-white/10 text-white placeholder-white/50 border border-white/20 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all" 
                                               required>
                                    </div>
                                `).join('')}
                            </div>
                        </div>

                        <!-- Jawaban Benar untuk Essay/File -->
                        <div class="hidden" id="correct-answer-input-${index}">
                            <label class="block mb-2 text-white font-semibold">
                                <i class="fas fa-check-circle mr-2 text-green-400"></i>Kunci Jawaban / Panduan
                            </label>
                            <textarea name="questions[${index}][correct_answer]" rows="3"
                                      class="w-full p-4 rounded-xl bg-white/10 text-white placeholder-white/50 border border-white/20 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all resize-none" 
                                      placeholder="Masukkan kunci jawaban atau panduan penilaian..."></textarea>
                            <p class="text-white/50 text-sm mt-2">
                                <i class="fas fa-info-circle mr-1"></i>
                                Untuk soal essay/file, ini bisa berupa kata kunci atau panduan penilaian
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            `;

            container.insertAdjacentHTML('beforeend', html);
            attachTypeListener(index);
        }

        function removeQuestionForm(index) {
            const questionBox = document.getElementById(`question-box-${index}`);
            if (questionBox) {
                questionBox.remove();
            }
        }

        function previewImage(index, input) {
            const file = input.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const uploadArea = input.parentElement.querySelector('.image-upload-area');
                    const uploadContent = uploadArea.querySelector('.upload-content');
                    const imagePreview = uploadArea.querySelector('.image-preview');
                    const img = imagePreview.querySelector('img');
                    
                    img.src = e.target.result;
                    uploadContent.classList.add('hidden');
                    imagePreview.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        }

        function previewFile(index, input) {
            const file = input.files[0];
            if (file) {
                const uploadArea = input.parentElement.querySelector('.file-upload-area');
                const uploadContent = uploadArea.querySelector('.upload-content');
                const filePreview = uploadArea.querySelector('.file-preview');
                const fileName = filePreview.querySelector('.file-name');
                
                fileName.textContent = file.name;
                uploadContent.classList.add('hidden');
                filePreview.classList.remove('hidden');
            }
        }

        function attachTypeListener(index) {
            const select = document.querySelector(`[data-index="${index}"]`);
            const fileInput = document.getElementById(`file-input-${index}`);
            const optionsInput = document.getElementById(`options-input-${index}`);
            const correctAnswerInput = document.getElementById(`correct-answer-input-${index}`);
            
            const mcOptionInputs = optionsInput.querySelectorAll('input[type="text"], input[type="radio"]');
            const correctAnswerField = correctAnswerInput.querySelector('textarea');

            function toggleFields() {
                const type = select.value;
                
                fileInput.classList.toggle("hidden", type !== "file_based");
                optionsInput.classList.toggle("hidden", type !== "multiple_choice");
                correctAnswerInput.classList.toggle("hidden", !(type === "file_based" || type === "essay"));
                
                if (type === "multiple_choice") {
                    mcOptionInputs.forEach(input => input.setAttribute('required', 'required'));
                } else {
                    mcOptionInputs.forEach(input => {
                        input.removeAttribute('required');
                        if (input.type === 'text') input.value = '';
                        if (input.type === 'radio') input.checked = false;
                    });
                }

                if (type === "file_based" || type === "essay") {
                    correctAnswerField.setAttribute('required', 'required');
                } else {
                    correctAnswerField.removeAttribute('required');
                    correctAnswerField.value = '';
                }

                const fileInputField = fileInput.querySelector('input[type="file"]');
                if (type === "file_based") {
                    fileInputField.setAttribute('required', 'required');
                } else {
                    fileInputField.removeAttribute('required');
                    fileInputField.value = '';
                }
            }

            select.addEventListener("change", toggleFields);
            toggleFields();
        }

        document.addEventListener("DOMContentLoaded", function () {
            addQuestionForm();
        });
    </script>

    <style>
        .question-number {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .image-upload-area:hover .upload-content i,
        .file-upload-area:hover .upload-content i {
            transform: scale(1.1);
            transition: transform 0.3s ease;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        #question-container > div {
            animation: fadeInUp 0.5s ease forwards;
        }
    </style>
</x-app-layout>