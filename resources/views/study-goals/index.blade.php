@extends('layouts.app')


@section('styles')
    <style>
      /* Menjaga halaman terpusat secara vertikal dan horizontal */
html, body {
    height: 100%;
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column; /* Mengatur elemen-elemen di dalamnya secara kolom */
    justify-content: flex-start; /* Menjaga elemen di bagian atas */
    align-items: center; /* Menjaga elemen di tengah secara horizontal */
    background-color: #021C2D; /* Warna biru */
    font-family: 'Arial', sans-serif;
}

/* Styling untuk header Overview */
.overview-header {
    width: 100%; /* Membuat lebar penuh */
    display: flex;
    justify-content: center; /* Menjaga judul di tengah secara horizontal */
    align-items: center;
    margin-top: 20px; /* Memberikan jarak di bagian atas */
}

/* Styling untuk judul */
.overview-header h2 {
    font-size: 27px;
    font-weight: bold;
    text-align: center;
    color: white;
    margin-bottom: 20px;
}

    </style>
@endsection
@section('content')
    <div class="overview-header">
        <h2><i class="fas fa-chart-pie"></i> Goal Overview</h2>
    </div>

    <!-- Tambahkan Legend di bawah Judul -->
    <div class="legend-container">
        <div class="legend-item">
            <span class="legend-color" style="background-color:rgb(153, 245, 255);"></span>
            <span class="legend-text">Goals Created</span>
        </div>
        <div class="legend-item">
            <span class="legend-color" style="background-color:rgb(152, 255, 138);"></span>
            <span class="legend-text">Goals Completed</span>
        </div>
        <div class="legend-item">
            <span class="legend-color" style="background-color:rgb(252, 203, 112);"></span>
            <span class="legend-text">Goals Progress</span>
        </div>
    </div>

    <!-- Chart Pie -->
    <div class="chart-container">
        <canvas id="goalPieChart"></canvas>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    const ctx = document.getElementById('goalPieChart').getContext('2d');
const chart = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: ['Goals Created', 'Goals Completed', 'Goals Progress'],
        datasets: [{
            label: 'Goal Distribution',
            data: [
                {{ $goalsCreated }},
                {{ $goalsCompleted }},
                {{ $goalsInProgress }}
            ],
            backgroundColor: [
                'rgb(153, 245, 255)',  // Goals Created
                'rgb(152, 255, 138)',  // Goals Completed
                'rgb(252, 203, 112)'   // Goals Progress
            ],
            borderColor: '#ffffff',
            borderWidth: 2
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false, // Responsif
        plugins: {
            legend: {
                display: false,  // Menonaktifkan legend (kotak warna)
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        let label = context.label || '';
                        let value = context.raw;
                        let total = context.chart._metasets[0].total;
                        let percentage = ((value / total) * 100).toFixed(1); // Persentase
                        return `${label}: ${percentage}% (${value})`; // Menampilkan nilai dan persentase
                    }
                }
            },
            datalabels: {
                display: true,
                color: '#fff', // Warna teks
                font: {
                    weight: 'bold',
                    size: 16
                },
                formatter: function(value, ctx) {
                    return value; // Menampilkan jumlah nilai (bukan persentase)
                }
            }
        },
        animation: {
            animateScale: true, // Efek animasi saat chart pertama kali ditampilkan
            animateRotate: true
        }
    }
});

    </script>
@endsection
