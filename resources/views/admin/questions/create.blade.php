<x-app-layout>
    <div class="max-w-4xl mx-auto p-6">
        <h1 class="text-3xl font-bold text-white mb-6">Tambah Soal untuk Quiz: {{ $quiz->title }}</h1>

        <form method="POST" action="{{ route('admin.questions.store', $quiz) }}" enctype="multipart/form-data">
            @csrf

            {{-- Menampilkan error validasi umum jika ada --}}
            @if ($errors->any())
                <div class="bg-red-500 text-white p-4 rounded mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div id="question-container">
                {{-- Soal pertama ditambahkan via JS --}}
            </div>

            <div class="flex gap-4 mt-6">
                <button type="button" onclick="addQuestionForm()" class="bg-green-600 hover:bg-green-700 px-4 py-2 rounded text-white">
                    + Tambah Soal
                </button>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 px-6 py-2 rounded text-white">
                    Simpan Semua Soal
                </button>
            </div>
        </form>
    </div>

    {{-- Script --}}
    <script>
        let questionCount = 0;

        function addQuestionForm() {
            const container = document.getElementById('question-container');
            const index = questionCount++;

            const html = `
            <div class="bg-gray-800 p-6 rounded text-white mb-6" id="question-box-${index}">
                <h2 class="text-xl font-semibold mb-4">Soal ${index + 1}
                    ${index > 0 ? `<button type="button" onclick="removeQuestionForm(${index})" class="ml-4 bg-red-600 hover:bg-red-700 text-white px-2 py-1 rounded text-sm">Hapus</button>` : ''}
                </h2>

                {{-- Tipe Soal --}}
                <div class="mb-4">
                    <label class="block mb-1">Tipe Soal</label>
                    <select name="questions[${index}][question_type]" class="w-full p-2 rounded text-black question-type" data-index="${index}" required>
                        <option value="multiple_choice">Pilihan Ganda</option>
                        <option value="essay">Essay</option>
                        <option value="file_based">File-Based (PDF, ZIP, dll)</option>
                    </select>
                </div>

                {{-- Batas Waktu Per Soal --}}
                <div class="mb-4">
                    <label class="block mb-1">Batas Waktu Soal Ini (Menit, Opsional)</label>
                    <input type="number" name="questions[${index}][time_limit_per_question]" class="w-full p-2 rounded text-black" placeholder="Cth: 5 (menit)">
                    <small class="text-gray-400">Kosongkan jika tidak ada batas waktu untuk soal ini.</small>
                </div>

                {{-- Pertanyaan Teks --}}
                <div class="mb-4">
                    <label class="block mb-1">Teks Soal</label>
                    <textarea name="questions[${index}][question_text]" class="w-full p-2 rounded text-black"></textarea>
                </div>

                {{-- Upload File --}}
                <div class="mb-4 hidden" id="file-input-${index}">
                    <label class="block mb-1">Upload File Soal</label>
                    <input type="file" name="questions[${index}][question_file]" class="w-full p-2 rounded text-black">
                </div>

                {{-- Gambar Soal --}}
                <div class="mb-4">
                    <label class="block mb-1">Gambar Soal (Opsional)</label>
                    <input type="file" name="questions[${index}][image]" class="w-full p-2 rounded text-black">
                </div>

                {{-- Opsi Pilihan Ganda (Hanya untuk multiple_choice) --}}
                <div class="mb-4" id="options-input-${index}">
                    <label class="block mb-1">Pilihan Jawaban</label>
                    ${['A', 'B', 'C', 'D'].map((option, i) => `
                        <div class="flex items-center gap-2 mb-2">
                            <input type="radio" name="questions[${index}][correct_option]" value="${i}" class="text-blue-500 focus:ring-blue-400" required>
                            <input type="text" name="questions[${index}][options][]" placeholder="Pilihan ${option}" class="w-full p-2 rounded text-black" required>
                        </div>
                    `).join('')}
                </div>

                {{-- Jawaban Benar (Untuk Essay dan File-Based) --}}
                <div class="mb-4 hidden" id="correct-answer-input-${index}">
                    <label class="block mb-1">Jawaban Benar (untuk penilaian otomatis jika berlaku)</label>
                    <input type="text" name="questions[${index}][correct_answer]" class="w-full p-2 rounded text-black">
                    <small class="text-gray-400">Untuk soal essay/file-based, ini bisa berupa kata kunci, atau hanya untuk referensi admin.</small>
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

        function attachTypeListener(index) {
            const select = document.querySelector(`[data-index="${index}"]`);
            const fileInput = document.getElementById(`file-input-${index}`);
            const optionsInput = document.getElementById(`options-input-${index}`);
            const correctAnswerInput = document.getElementById(`correct-answer-input-${index}`);
            
            // Dapatkan semua input yang mungkin ada di dalam optionsInput
            const mcOptionInputs = optionsInput.querySelectorAll('input[type="text"], input[type="radio"]');
            const correctAnswerField = correctAnswerInput.querySelector('input');


            function toggleFields() {
                const type = select.value;
                
                // Tampilkan/sembunyikan file input
                fileInput.classList.toggle("hidden", type !== "file_based");
                
                // Tampilkan/sembunyikan pilihan ganda
                optionsInput.classList.toggle("hidden", type !== "multiple_choice");
                
                // Tampilkan/sembunyikan jawaban benar (untuk essay dan file_based)
                correctAnswerInput.classList.toggle("hidden", !(type === "file_based" || type === "essay"));
                
                // Set required/disabled attribute berdasarkan visibility
                // Untuk Pilihan Ganda:
                if (type === "multiple_choice") {
                    mcOptionInputs.forEach(input => input.setAttribute('required', 'required'));
                } else {
                    mcOptionInputs.forEach(input => input.removeAttribute('required'));
                    // Kosongkan nilai saat disembunyikan agar tidak terkirim saat tidak relevan
                    mcOptionInputs.forEach(input => {
                        if (input.type === 'text') input.value = '';
                        if (input.type === 'radio') input.checked = false;
                    });
                }

                // Untuk Jawaban Benar (Essay/File-Based):
                if (type === "file_based" || type === "essay") {
                    correctAnswerField.setAttribute('required', 'required');
                } else {
                    correctAnswerField.removeAttribute('required');
                    correctAnswerField.value = ''; // Kosongkan nilai saat disembunyikan
                }

                // Untuk File Input (File-Based):
                const fileInputField = fileInput.querySelector('input[type="file"]');
                if (type === "file_based") {
                    fileInputField.setAttribute('required', 'required');
                } else {
                    fileInputField.removeAttribute('required');
                    fileInputField.value = ''; // Kosongkan nilai saat disembunyikan
                }
            }

            select.addEventListener("change", toggleFields);
            toggleFields(); // Panggil sekali saat pertama kali load
        }

        document.addEventListener("DOMContentLoaded", function () {
            addQuestionForm(); // Tambahkan form soal pertama saat halaman dimuat
        });
    </script>
</x-app-layout>