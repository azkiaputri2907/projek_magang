@extends('layouts.app')

@section('title', 'Laporan | Disdik Kab.Banjar')

{{-- Load Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@section('content')
<style>
/* ======================== GLOBAL ======================== */
body {
    background-color: #DFEDFE;
    background-image: 
        linear-gradient(135deg, rgba(255,255,255,0.18) 25%, transparent 25%),
        linear-gradient(225deg, rgba(255,255,255,0.18) 25%, transparent 25%),
        linear-gradient(45deg, rgba(255,255,255,0.18) 25%, transparent 25%),
        linear-gradient(315deg, rgba(255,255,255,0.18) 25%, #DFEDFE 25%);
    background-position: 20px 0, 20px 0, 0 0, 0 0;
    background-size: 20px 20px;
    background-repeat: repeat;
    font-family: 'Poppins', sans-serif;
    margin: 0;
    padding-top: 0rem; 
    min-height: 100vh;
    overflow-x: hidden;
}

/* LOGO */
.logo-header {
    position: absolute;
    top: 18px;
    right: 25px;
    display: flex;
    align-items: center;
    gap: 10px;
    z-index: 100;
    filter: drop-shadow(0 4px 6px rgba(0,0,0,0.1));
}
.logo-header img { height: 50px; }

/* ================= DASHBOARD MAIN (3D CARD) ================= */
.container-dashboard {
    display: flex;
    justify-content: center;
    align-items: flex-start;
    width: 95%;
    max-width: 1300px;
    margin: 0 auto;
    padding-top: 0; 
    margin-top: 5px; 
    padding-bottom: 20px;
}

.dashboard-card {
    display: flex;
    background-color: #fff;
    border-radius: 20px;
    overflow: hidden;
    
    /* EFEK TIMBUL 3D */
    box-shadow: 
        0 20px 50px rgba(0, 0, 0, 0.15),
        0 5px 15px rgba(0,0,0,0.05);
    border: 1px solid rgba(255,255,255,0.6);
    border-bottom: 6px solid #e1e8f0;
    
    min-height: 620px;
    width: 100%;
}

/* ================= LEFT PANEL (KONTEN) ================= */
.dashboard-left {
    flex: 2.1; 
    padding: 40px 50px;
    display: flex;
    flex-direction: column;
    position: relative;
    gap: 20px;
    background-color: #F8FBFF;
    z-index: 1;
    min-width: 0;
}

/* Title Card */
.title-card {
    background: transparent; 
    border-radius: 0; 
    padding: 0; 
    font-size: 2rem; 
    font-weight: 800;
    color: #003366; 
    margin-bottom: 15px; 
    display: flex;
    align-items: center;
    gap: 15px;
    text-shadow: 0 2px 3px rgba(0,0,0,0.05);
}
.title-card span { color: #30E3BC; }

.menu-icon {
    cursor: pointer;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    width: 22px;
    height: 18px;
    min-width: 22px;
}
.menu-icon span {
    height: 3px;
    background: #003366;
    border-radius: 2px;
}

/* === REPORT CONTENT & CHARTS === */
.report-content {
    display: flex;
    justify-content: center;
    align-items: flex-start;
    gap: 40px;
    padding: 20px 0;
    flex-wrap: wrap;
    flex-grow: 1;
}

/* 3D CARD UNTUK CHART */
.report-chart {
    text-align: center;
    background: #fff;
    border-radius: 20px;
    padding: 25px;
    width: 280px;
    height: 360px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    
    /* EFEK TIMBUL CARD KECIL */
    border: 1px solid #e0e6ed;
    border-bottom: 5px solid #d1d9e6;
    box-shadow: 0 10px 20px rgba(0,0,0,0.05);
    transition: transform 0.3s ease;
}

.report-chart:hover {
    transform: translateY(-5px);
}

.chart-wrapper {
    width: 220px;
    height: 220px;
    position: relative;
    margin-bottom: 15px;
}
.chart-wrapper canvas {
    position: absolute;
    inset: 0;
}

.report-chart p {
    font-weight: 700;
    color: #003366;
    margin: 0 0 15px 0;
    font-size: 1.1rem;
}

/* TOMBOL UNDUH (3D PUSH BUTTON) */
.btn-unduh {
    display: inline-block;
    background: linear-gradient(135deg, #1BC5BD 0%, #0f968e 100%);
    color: white;
    padding: 10px 30px;
    border-radius: 50px;
    font-weight: 700;
    text-decoration: none;
    text-transform: uppercase;
    font-size: 0.85rem;
    letter-spacing: 0.5px;
    position: relative;
    top: 0;
    
    /* KUNCI EFEK 3D */
    box-shadow: 
        0 4px 0 #0f7a74, 
        0 5px 10px rgba(27, 197, 189, 0.3);
    transition: all 0.15s cubic-bezier(0.4, 0, 0.2, 1);
}

.btn-unduh:hover {
    background: linear-gradient(135deg, #25dcd3 0%, #13b0a7 100%);
    transform: translateY(-2px);
    box-shadow: 
        0 6px 0 #0f7a74, 
        0 8px 15px rgba(27, 197, 189, 0.4);
}

.btn-unduh:active {
    top: 4px;
    box-shadow: 
        0 0 0 #0f7a74, 
        0 2px 5px rgba(27, 197, 189, 0.3);
}

/* ================= RIGHT PANEL (IMAGE) ================= */
.dashboard-right {
    flex: 0.9;
    background-color: #C9E1FF;
    background-image: url('{{ asset('images/admin1.jpg') }}');
    background-repeat: no-repeat;
    background-position: center;
    background-size: cover;
    display: flex;
    justify-content: center;
    align-items: flex-start;
    padding: 80px 40px 40px; 
    position: relative;
    
    /* Bayangan pemisah */
    box-shadow: inset 15px 0 20px -10px rgba(0,0,0,0.15);
    z-index: 2;
    
    flex-shrink: 0;
    min-width: 300px;
}

.dashboard-right::after {
    content: "";
    position: absolute;
    inset: 0;
    background: linear-gradient(to bottom, rgba(0,0,0,0.35) 10%, transparent 60%);
    z-index: 1;
}
.dashboard-right h1 {
    z-index: 2;
    color: white;
    text-align: center;
    font-size: 2.2rem;
    font-weight: 800;
    margin-top: 40px;
    text-shadow: 0 4px 8px rgba(0,0,0,0.6);
}
.dashboard-right h1 span { color: #30E3BC; }

/* TAMBAHAN: TEKS DI TENGAH CHART */
.chart-center-text {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    text-align: center;
    pointer-events: none; /* Agar grafik tetap bisa diklik/hover */
    z-index: 0;
}

.chart-center-text h2 {
    margin: 0;
    font-size: 2.5rem; /* Ukuran angka besar */
    font-weight: 800;
    color: #003366;
    line-height: 1;
}

.chart-center-text span {
    font-size: 0.85rem;
    color: #888;
    font-weight: 500;
    text-transform: uppercase;
    display: block;
    margin-top: 5px;
}
/* === RESPONSIVE MODE === */
@media (max-width: 992px) {
    .dashboard-card { flex-direction: column; min-height: auto; }

    /* Mobile: Image on Top */
    .dashboard-right { 
        order: 1;
        height: 260px; 
        padding-top: 40px; 
        border-radius: 20px 20px 0 0; 
        border-bottom-right-radius: 0;
        width: 100%;
        min-width: unset;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        text-align: center;
    }

    .dashboard-right h1 { font-size: 1.8rem; margin-top: 10px; text-align: center; }
    
    .dashboard-left { order: 2; padding: 30px 20px; }
    .title-card { font-size: 1.8rem; }
    .container-dashboard { margin-top: 10px; }
    .logo-header { top: 10px; right: 10px; }
    .logo-header img { height: 40px; }
    
    .report-chart {
        width: 100%;
        max-width: 320px;
    }
    
    .report-content {
        gap: 20px;
        justify-content: center;
    }
}

@media (max-width: 600px) {
    .dashboard-right h1 { font-size: 1.5rem; text-align: center;}
    .title-card { font-size: 1.5rem; }
    .report-chart { padding: 20px; height: auto; }
    .btn-unduh { width: 100%; text-align: center; box-sizing: border-box; }
}
</style>

{{-- === LOGO === --}}
<div class="logo-header">
    <img src="{{ asset('images/LOGO_KEMENTRIAN.png') }}" alt="Logo Kementrian">
    <img src="{{ asset('images/LOGO_PEMKAB_BANJAR.png') }}" alt="Logo Kab. Banjar">
</div>

{{-- === PANGGIL SIDEBAR DARI COMPONENT === --}}
@include('components._sidebar')

<div class="container-dashboard">
    <div class="dashboard-card">

        {{-- KIRI (KONTEN) --}}
        <div class="dashboard-left">
            <div class="title-card">
                <div class="menu-icon" id="menuToggle">
                    <span></span><span></span><span></span>
                </div>
                Laporan <span>Data</span>
            </div>

            <div class="report-content">

                {{-- CARD 1: PENGUNJUNG --}}
                <div class="report-chart">
                    <p>Data Pengunjung</p>
                    <div class="chart-wrapper">
                        <canvas id="chartPengunjung" style="position: relative; z-index: 2;"></canvas>
                        
                        {{-- TEKS ANGKA DI TENGAH --}}
                        <div class="chart-center-text">
                            <h2>{{ $totalPengunjung ?? 0 }}</h2>
                            <span>Orang</span>
                        </div>
                    </div>
                    
                    {{-- Link Unduh Excel Langsung dari Google Sheets --}}
                    <a href="https://docs.google.com/spreadsheets/d/1XKirvKDNNnwcauLTxHebHCcHbAdEHLZdL5caoB3HiVE/export?format=xlsx" 
                    class="btn-unduh" target="_blank">
                    <i class="fas fa-download" style="margin-right:5px;"></i> Unduh Excel
                    </a>
                </div>

                {{-- CARD 2: SKM --}}
                <div class="report-chart">
                    <p>Data SKM</p>
                    <div class="chart-wrapper">
                        <canvas id="chartSkm" style="position: relative; z-index: 2;"></canvas>
                        
                        {{-- TEKS ANGKA DI TENGAH --}}
                        <div class="chart-center-text">
                            <h2>{{ $totalSkm ?? 0 }}</h2>
                            <span>Responden</span>
                        </div>
                    </div>
                    
                    {{-- Link Unduh Excel Langsung dari Google Sheets --}}
                    <a href="https://docs.google.com/spreadsheets/d/1iTmYnrKDmx3lmoIjoEqeAkSlHE0aePXF56SGFqfl6J0/export?format=xlsx" 
                    class="btn-unduh" target="_blank">
                    <i class="fas fa-download" style="margin-right:5px;"></i> Unduh Excel
                    </a>
                </div>

            </div>
        </div>

        {{-- KANAN (GAMBAR) --}}
        <div class="dashboard-right">
            <h1>Data Laporan <span>Buku Tamu</span></h1>
        </div>

    </div>
</div>

@include('components._footer')

<script>
// KONFIGURASI CHART.JS
const donutColors = ['#30AADD', '#00917C', '#F9D923', '#F05454'];

// Mengambil data dari controller yang sudah dihitung dari Sheets
// FIX: Gunakan tanda kutip dan Number() untuk menghindari Syntax Error jika Blade tidak dirender
const totalPengunjung = Number("{{ $totalPengunjung ?? 0 }}");
const totalSkm = Number("{{ $totalSkm ?? 0 }}");

// Chart Pengunjung
new Chart(document.getElementById('chartPengunjung'), {
    type: 'doughnut',
    data: {
        labels: ['Total Pengunjung'],
        datasets: [{
            data: [totalPengunjung],
            backgroundColor: donutColors[0],
            borderWidth: 0,
            hoverOffset: 4
        }]
    },
    options: { 
        responsive: true,
        maintainAspectRatio: false,
        plugins: { 
            legend: { display: false },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return context.raw + ' Orang';
                    }
                }
            }
        },
        cutout: '75%',
    }
});

// Chart SKM
new Chart(document.getElementById('chartSkm'), {
    type: 'doughnut',
    data: {
        labels: ['Total SKM'],
        datasets: [{
            data: [totalSkm],
            backgroundColor: donutColors[1],
            borderWidth: 0,
            hoverOffset: 4
        }]
    },
    options: { 
        responsive: true,
        maintainAspectRatio: false,
        plugins: { 
            legend: { display: false },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return context.raw + ' Responden';
                    }
                }
            }
        },
        cutout: '75%',
    }
});
</script>

@endsection