<x-app-layout>
    @push('styles')
    <style>
       .today-header {
    width: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    margin-top: 20px;
}

.today-header h2 {
    font-size: 25px;
    font-weight: bold;
    text-align: center;
    color: white;
    margin-bottom: 10px;
}

.goal-left {
    display: block; /* Menggunakan block supaya elemen berada dalam satu kolom */
    margin-bottom: 20px;
}

.goal-info {
    margin-bottom: 10px;
    text-align: left;
    padding-left: 10px; /* Memberi jarak kiri */
}

.goal-title {
    font-size: 14px;
    font-weight: bold;
    color: #fff;
    margin: 0;
    padding: 0;
    padding-left: 10px; /* Memberi jarak kiri */
}

.goal-description {
    font-size: 13px;
    color: #bbb;
    margin: 0;
    padding: 0;
    padding-left: 10px; /* Memberi jarak kiri */
}

.goal-progress {
    margin-top: 10px;
    text-align: left;
    display: flex;
    flex-direction: column;
    gap: 5px; /* Menambahkan jarak antara checkbox dan presentase */
    padding-left: 19px; /* Memberi jarak kiri */
     font-size: 13px;
}

.checkbox-container {
    display: flex;
    align-items: center; /* Menyelarankan checkbox dan label secara vertikal */
    gap: 5px; /* Menambahkan jarak antara checkbox dan label */
}

.goal-actions {
    text-align: right;
    margin-top: 10px;  /* Menurunkan posisi tombol edit dan hapus */
    margin-bottom: 10px; /* Jarak dari elemen lainnya */
}

.goal-actions a, .goal-actions button {
    color: #fff;
    margin-left: 10px;
}

/* Pop-up Modal Styles */
.popup-modal {
    display: none; /* Hidden by default */
    position: fixed;
    z-index: 1000; /* Make sure it's on top of everything */
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent background */
    display: flex;
    justify-content: center;
    align-items: center;
}

.popup-content {
    background-color: #fff;
    padding: 20px;
    border-radius: 10px;
    width: 300px;  /* Set the width of the pop-up */
    text-align: center;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); /* Adding shadow for better visual effect */
    position: relative;
}

.popup-close {
    color: #aaa;
    font-size: 24px;
    font-weight: bold;
    cursor: pointer;
    position: absolute;
    top: 4px;
    right: 8px;
}

.popup-close:hover,
.popup-close:focus {
    color: black;
    text-decoration: none;
}
/* Menambahkan styling untuk <h2> dalam pop-up */
.popup-content h2 {
    font-size: 13px; /* Atur ukuran font sesuai keinginan */
    color: #2c3e50;  /* Ganti warna teks dengan warna yang diinginkan */
    font-weight: bold;  /* Mengatur font agar tebal */
    margin: 0; /* Menghapus margin */
    padding: 10px 0; /* Menambahkan padding jika perlu */
}

    </style>
    @endpush

<div class="today-header">
    <h2><i class="fas fa-calendar-day"></i> Goals For Today</h2>
</div>

<!-- Menampilkan pesan sukses jika ada -->

@if(session('completed'))
    <!-- Pop-up untuk Goal yang selesai -->
    <div class="popup-modal" id="completedPopup">
        <div class="popup-content">
            <span class="popup-close" id="completedPopupClose">&times;</span>
            <!-- Menampilkan session 'completed' -->
            <h2>{{ session('completed') }}</h2>
        </div>
    </div>
@endif


@if(session('success'))
    <!-- Pop-up untuk update sukses -->
    <div class="popup-modal" id="successPopup">
        <div class="popup-content">
            <span class="popup-close" id="successPopupClose">&times;</span>
            <!-- Pesan sukses dari session -->
            <h2>{{ session('success') }}</h2>
        </div>
    </div>
@endif

<div class="today-goals-list">
    @foreach($goals as $goal)
        <div class="goal-row">
            <div class="goal-left">
                <div class="goal-info">
                    <p class="goal-title">{{ $goal->title }}</p>
                    <p class="goal-description">{{ $goal->description }}</p>
                </div>

                <div class="goal-progress">
                    @php
                        $startDate = \Carbon\Carbon::parse($goal->start_date);
                        $endDate = \Carbon\Carbon::parse($goal->end_date);
                        $totalDays = $startDate->diffInDays($endDate) + 1;
                        $checkedDays = $goal->progress()->whereBetween('date', [$startDate, $endDate])->count();
                        $percentage = ($checkedDays / $totalDays) * 100;
                    @endphp
                    <p>Presentase Selesai: {{ number_format($percentage, 2) }}%</p>

                    @for($i = 0; $i < $totalDays; $i++)
                        @php
                            $currentDay = $startDate->copy()->addDays($i);
                        @endphp
                        <form action="{{ route('study-goals.updateProgress', $goal->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div>
                                <input type="checkbox" 
                                       name="dates[]" 
                                       value="{{ $currentDay->format('Y-m-d') }}" 
                                       onchange="this.form.submit()" 
                                       {{ $goal->progress()->where('date', $currentDay->format('Y-m-d'))->exists() ? 'checked' : '' }} />
                                <label>{{ $currentDay->format('d M Y') }}</label>
                            </div>
                        </form>
                    @endfor
                </div>
            </div>

            <div class="goal-actions">
                <a href="{{ route('study-goals.edit', $goal->id) }}" class="icon-button"><i class="fas fa-pen"></i></a>
                <form action="{{ route('study-goals.destroy', $goal->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="icon-button delete"><i class="fas fa-trash"></i></button>
                </form>
            </div>
        </div>
    @endforeach
</div>

    @push('scripts')
    <script>
// Menutup pop-up 'completed' saat tombol close ditekan
document.addEventListener('DOMContentLoaded', function() {
    const completedPopupClose = document.getElementById('completedPopupClose');
    const successPopupClose = document.getElementById('successPopupClose');

    if (completedPopupClose) {
        completedPopupClose.onclick = function() {
            document.getElementById('completedPopup').style.display = 'none';
        };
    }

    if (successPopupClose) {
        successPopupClose.onclick = function() {
            document.getElementById('successPopup').style.display = 'none';
        };
    }

    // Menutup pop-up jika pengguna mengklik di luar pop-up
    window.onclick = function(event) {
        if (event.target == document.getElementById('completedPopup')) {
            document.getElementById('completedPopup').style.display = 'none';
        }
        if (event.target == document.getElementById('successPopup')) {
            document.getElementById('successPopup').style.display = 'none';
        }
    };
});

    </script>
    @endpush
</x-app-layout>