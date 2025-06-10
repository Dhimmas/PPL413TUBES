@extends('layouts.app')

@section('content')
<div class="goal-form-container">
    <h2><i class="fas fa-plus-circle"></i> Add Goals</h2>

    <form id="goalForm" method="POST" class="goal-form" action="{{ route('study-goals.store') }}">
        @csrf  <!-- CSRF token untuk keamanan -->
    
      <div class="form-group">
    <label for="goal_title">Goal Title:</label>
    <input type="text" id="goal_title" name="goal_title" required />
</div>

<div class="form-group">
    <label for="goal_description">Description:</label>
    <input type="text" id="goal_description" name="goal_description" required />
</div>

<!-- Tanggal (hidden) -->
<input type="hidden" id="startDateInput" name="start_date">
<input type="hidden" id="endDateInput" name="end_date">

<!-- Tombol Pilih Tanggal -->
<div class="form-group">
    <label for="startDateTrigger">Start Date:</label> <!-- Perbaiki ID yang sesuai -->
    <div class="date-input-container">
        <button type="button" id="startDateTrigger" class="date-btn">
            <i class="fas fa-calendar-alt"></i> <span id="startDateLabel">Select Start Date</span>
        </button>
    </div>
</div>

<div class="form-group">
    <label for="endDateTrigger">End Date:</label> <!-- Perbaiki ID yang sesuai -->
    <div class="date-input-container">
        <button type="button" id="endDateTrigger" class="date-btn">
            <i class="fas fa-calendar-alt"></i> <span id="endDateLabel">Select End Date</span>
        </button>
    </div>
</div>
        <!-- Tombol Submit -->
        <div class="form-group form-submit-wrapper">
            <button type="submit" class="submit-btn">Add Goal</button>
        </div>
    </form>

    <!-- Tempat menampilkan pesan sukses atau error -->
    <div id="message"></div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const initDatePicker = (triggerId, labelId, hiddenId) => {
        const trigger = document.getElementById(triggerId);
        const label = document.getElementById(labelId);
        const hiddenInput = document.getElementById(hiddenId);

        // Inisialisasi flatpickr pada tombol
        const fp = flatpickr(trigger, {
            dateFormat: 'm/d/Y', // Format tanggal
            onChange: function (selectedDates, dateStr) {
                // Menampilkan tanggal yang dipilih pada label
                label.textContent = dateStr;
                hiddenInput.value = dateStr; // Menyimpan tanggal yang dipilih di input tersembunyi
            },
            appendTo: document.body,  // Kalender ditempatkan pada body agar lebih fleksibel
            disableMobile: true, // Menonaktifkan tampilan mobile calendar, menjaga konsistensi tampilan pop-up
        });

        // Menangani klik pada tombol tanggal untuk membuka kalender
        trigger.addEventListener('click', function () {
            const rect = trigger.getBoundingClientRect(); // Mengambil posisi tombol
            const calendar = document.querySelector('.flatpickr-calendar'); // Mendapatkan kalender yang sesuai

            // Menempatkan kalender di bawah tombol dengan perhitungan posisi yang benar
            calendar.style.left = `${rect.left}px`;  // Kalender akan sejajar dengan tombol
            calendar.style.top = `${rect.top + rect.height + 10}px`;  // Kalender muncul di bawah tombol

            fp.open(); // Membuka kalender ketika tombol diklik
        });
    };

    // Menginisialisasi tombol tanggal
    initDatePicker('startDateTrigger', 'startDateLabel', 'startDateInput');
    initDatePicker('endDateTrigger', 'endDateLabel', 'endDateInput');
});


$('#goalForm').on('submit', function (e) {
    e.preventDefault(); // Mencegah form untuk submit secara default

    // Ambil nilai tanggal yang sudah dipilih
    const startDate = document.getElementById('startDateInput').value;
    const endDate = document.getElementById('endDateInput').value;

    // Periksa apakah tanggal tidak kosong
    if (!startDate || !endDate) {
        $('#error-message').text("Both start date and end date are required.");
        $('#error-message').show(); // Menampilkan elemen pesan kesalahan
        return;
    }

    // Konversi format tanggal dari 'm/d/Y' ke 'Y-m-d' (contoh: '05/23/2025' -> '2025-05-23')
    const formatDate = (dateStr) => {
        const dateParts = dateStr.split('/');
        if (dateParts.length === 3) {
            const [month, day, year] = dateParts;
            return `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`;
        } else {
            return ''; // Jika format tidak valid, kembalikan string kosong
        }
    };

    const formattedStartDate = formatDate(startDate);
    const formattedEndDate = formatDate(endDate);

    // Update input hidden dengan tanggal yang sudah diformat
    document.getElementById('startDateInput').value = formattedStartDate;
    document.getElementById('endDateInput').value = formattedEndDate;

    let formData = new FormData(this); // Ambil data form

    $.ajax({
        url: "{{ route('study-goals.store') }}", // URL untuk menyimpan data
        method: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
            if (response.redirect) {
                window.location.href = response.redirect;  // Redirect ke halaman yang diberikan (today atau upcoming)
            }
        },
        error: function (xhr) {
            let errors = xhr.responseJSON.errors;
            let errorMessages = '';
            for (const key in errors) {
                errorMessages += `<p style="color: red;">${errors[key]}</p>`; // Menampilkan error
            }
            $('#message').html(errorMessages); // Menampilkan error
        }
    });
});




</script>
@endsection
