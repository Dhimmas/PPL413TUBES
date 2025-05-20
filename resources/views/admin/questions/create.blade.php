<x-app-layout>
    <div class="max-w-4xl mx-auto p-6">
        <h1 class="text-3xl font-bold text-white mb-6">Tambah Soal</h1>

        <form method="POST" action="{{ route('admin.questions.store', $quiz) }}" enctype="multipart/form-data">
            @csrf

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
                <h2 class="text-xl font-semibold mb-4">Soal ${index + 1}</h2>

                {{-- Tipe Soal --}}
                <div class="mb-4">
                    <label class="block mb-1">Tipe Soal</label>
                    <select name="questions[${index}][question_type]" class="w-full p-2 rounded text-black question-type" data-index="${index}" required>
                        <option value="multiple_choice">Pilihan Ganda</option>
                        <option value="essay">Essay</option>
                        <option value="file_based">File-Based (PDF, ZIP, dll)</option>
                    </select>
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

                {{-- Jawaban Benar (Hanya untuk file_base dan essay) --}}
                <div class="mb-4 hidden" id="correct-answer-input-${index}">
                    <label class="block mb-1">Jawaban Benar</label>
                    <input type="text" name="questions[${index}][correct_answer]" class="w-full p-2 rounded text-black">
                </div>
            </div>
            `;

            container.insertAdjacentHTML('beforeend', html);
            attachTypeListener(index);
        }

        function attachTypeListener(index) {
            const select = document.querySelector(`[data-index="${index}"]`);
            const fileInput = document.getElementById(`file-input-${index}`);
            const optionsInput = document.getElementById(`options-input-${index}`);
            const correctAnswerInput = document.getElementById(`correct-answer-input-${index}`);

            function toggleFields() {
                const type = select.value;
                
                // Tampilkan/sembunyikan file input
                fileInput.classList.toggle("hidden", type !== "file_based");
                
                // Tampilkan/sembunyikan pilihan ganda
                optionsInput.classList.toggle("hidden", type !== "multiple_choice");
                
                // Tampilkan/sembunyikan jawaban benar (untuk short_answer dan essay)
                correctAnswerInput.classList.toggle("hidden", !(type === "file_based" || type === "essay"));
                
                // Set required attribute berdasarkan visibility
                const correctAnswerField = correctAnswerInput.querySelector('input');
                if (type === "file_based" || type === "essay") {
                    correctAnswerField.setAttribute('required', 'required');
                } else {
                    correctAnswerField.removeAttribute('required');
                }
            }

            select.addEventListener("change", toggleFields);
            toggleFields(); // Panggil sekali saat pertama kali load
        }

        document.addEventListener("DOMContentLoaded", function () {
            addQuestionForm();
        });
    </script>
</x-app-layout>