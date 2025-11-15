@extends('layouts.app')

@section('title', 'Laporan | Disdik Kab.Banjar')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@section('content')
<style>
/* Catatan: Karena menggunakan @extends('layouts.app'), diasumsikan sebagian besar gaya
   terutama untuk sidebar, overlay, menu-icon, dan logo-header sudah ada di layouts.app,
   atau terdefinisikan secara global. Gaya di bawah ini mencakup yang spesifik untuk halaman laporan
   dan memastikannya konsisten dengan struktur dashboard-card. */

body {
    background-color: #DFEDFE;
    font-family: 'Poppins', sans-serif;
    margin: 0;
    padding-top: 50px;
    min-height: 100vh;
}

/* LOGO (Diambil dari kode kedua) */
.logo-header {
    position: absolute;
    top: 25px;
    right: 45px;
    display: flex;
    gap: 10px;
    z-index: 100;
}
.logo-header img { height: 55px; }

/* === SIDEBAR (Diambil dari kode kedua) === */
#sidebar {
    position: fixed;
    top: 0;
    left: -250px;
    height: 100%;
    width: 250px;
    background-color: #fff;
    box-shadow: 2px 0 15px rgba(0,0,0,0.3);
    z-index: 1000;
    transition: left 0.3s ease;
    padding: 20px 0;
}
#sidebar.active { left: 0; }
#sidebar-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.5);
    z-index: 999;
    display: none;
}
#sidebar.active + #sidebar-overlay { display: block; }

.sidebar-profile {
    display: flex;
    align-items: center;
    padding: 0 15px 20px 15px;
    border-bottom: 1px solid #eee;
    margin-bottom: 10px;
}
.sidebar-profile img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
    margin-right: 10px;
}
.sidebar-profile div { font-size: 14px; color: #333; }
.sidebar-profile div span { display: block; font-size: 12px; color: #666; }

.sidebar-link {
    display: flex;
    align-items: center;
    padding: 12px 15px;
    text-decoration: none;
    color: #333;
    font-size: 14px;
    margin: 5px 0;
    transition: background 0.2s ease;
}
.sidebar-link:hover {
    background-color: rgba(220,53,69,0.05);
}
.sidebar-link i { margin-right: 10px; }

.sidebar-link.active {
    background-color: rgba(220,53,69,0.1);
    border-left: 4px solid #dc3545;
    font-weight: bold;
    border-radius: 0 5px 5px 0;
}

.sidebar-footer {
    padding: 15px;
}
.sidebar-footer a {
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 10px;
    text-decoration: none;
    color: #fff;
    background-color: #dc3545;
    font-weight: bold;
    border-radius: 5px;
    font-size: 14px;
}
/* MENU ICON (Diambil dari kode kedua) */
.menu-icon {
    cursor: pointer;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    width: 22px;
    height: 18px;
}
.menu-icon span {
    height: 3px;
    background: #333;
    border-radius: 2px;
}


/* CONTENT AREA (Menyesuaikan dengan container-dashboard dari kode kedua) */
.container-dashboard {
    display: flex;
    justify-content: center;
    width: 95%;
    max-width: 1300px;
    margin: 20px auto; /* Mengubah margin-top 90px menjadi auto dan menambahkan margin-top 20px agar responsif */
}

.dashboard-card {
    display: flex;
    background: #fff;
    border-radius: 20px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    width: 100%;
    /* min-height: 700px; */ /* Dihapus atau disesuaikan */
}

.dashboard-left {
    flex: 2.2;
    padding: 20px 30px;
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.title-card {
    background: #fff;
    border-radius: 12px;
    padding: 10px 20px;
    font-size: 1.5rem;
    font-weight: 800;
    color: #007BFF;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    display: flex;
    align-items: center;
    gap: 15px;
}

.report-content {
    display: flex;
    justify-content: space-around;
    align-items: center;
    gap: 40px;
    padding: 20px 0;
    flex-wrap: wrap; /* Untuk responsivitas jika perlu */
}

.report-chart {
    text-align: center;
    background: #fff;
    border-radius: 15px;
    padding: 20px;
    box-shadow: 0 6px 15px rgba(0,0,0,0.1);
}

.report-chart p {
    font-size: 18px;
    font-weight: 600;
    margin-top: 15px;
    color: #003366;
}

canvas {
    width: 200px !important;
    height: 200px !important;
}

.btn-unduh {
    display: inline-block;
    background-color: #1BC5BD;
    color: white;
    padding: 10px 30px;
    margin-top: 12px;
    border-radius: 8px;
    font-weight: 600;
    text-decoration: none;
    transition: background-color 0.2s;
}
.btn-unduh:hover {
    background-color: #15a098;
}

/* RIGHT PANEL (Diambil dari kode kedua) */
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
    padding: 60px 20px 20px;
    position: relative;
    border-top-right-radius: 20px;
    border-bottom-right-radius: 20px;
    overflow: hidden;
}

.dashboard-right::after {
    content: "";
    position: absolute;
    inset: 0;
    background: linear-gradient(to bottom, rgba(0,0,0,0.25) 20%, transparent 60%);
    z-index: 1;
}
.dashboard-right h1 {
    z-index: 2;
    color: white;
    font-size: 2rem;
    font-weight: 800;
    margin-top: 40px;
    text-align: center;
}
.dashboard-right h1 span { color: #30E3BC; }

</style>

<div class="logo-header">
    <img src="{{ asset('images/LOGO_KEMENTRIAN.png') }}" alt="Logo Kementrian">
    <img src="{{ asset('images/LOGO_PEMKAB_BANJAR.png') }}" alt="Logo Pemkab Banjar">
</div>

<div id="sidebar">
    <div class="sidebar-profile">
        <img src="{{ asset('images/avatar_admin.png') }}" alt="Avatar">
        <div>
            Jamilatul Azkia Putri
            <span>Admin</span>
        </div>
    </div>

    <a href="{{ url('/admin/dashboard') }}" class="sidebar-link {{ Request::is('admin/dashboard') ? 'active' : '' }}">
        <i class="fas fa-home"></i> Beranda
    </a>
    <a href="{{ url('/admin/pengunjung') }}" class="sidebar-link {{ Request::is('admin/pengunjung') ? 'active' : '' }}">
        <i class="fas fa-users"></i> Data Pengunjung
    </a>
    <a href="{{ url('/admin/skm') }}" class="sidebar-link {{ Request::is('admin/skm') ? 'active' : '' }}">
        <i class="fas fa-file-alt"></i> Data SKM
    </a>
    <a href="{{ url('/admin/skm/pertanyaan') }}" class="sidebar-link {{ Request::is('admin/skm/pertanyaan') ? 'active' : '' }}">
        <i class="fas fa-file-alt"></i> Data SKM Pertanyaan
    </a>
    <a href="{{ url('/admin/laporan') }}" class="sidebar-link {{ Request::is('admin/laporan') ? 'active' : '' }}">
        <i class="fas fa-chart-line"></i> Laporan
    </a>

    <div class="sidebar-footer">
        <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn-item btn-keluar">
                <i class="fas fa-sign-out-alt"></i> Keluar
            </button>
        </form>    
    </div>
</div>
<div id="sidebar-overlay"></div>

<div class="container-dashboard">
    <div class="dashboard-card">

        <div class="dashboard-left">
            <div class="title-card">
                <div class="menu-icon" id="menuToggle">
                    <span></span><span></span><span></span>
                </div>
                Laporan
            </div>

            <div class="report-content">
                <div class="report-chart">
                    <canvas id="chartPengunjung"></canvas>
                    <p>Data Pengunjung</p>
                    <a href="{{ route('laporan.download_pengunjung') }}" class="btn-unduh">Unduh</a>
                </div>

                <div class="report-chart">
                    <canvas id="chartSkm"></canvas>
                    <p>Data SKM</p>
                    <a href="{{ route('laporan.download_skm') }}" class="btn-unduh">Unduh</a>
                </div>
            </div>
            </div>

        <div class="dashboard-right">
            <h1>Laporan <span>Disdik</span></h1>
        </div>

    </div>
</div>

@include('components._footer')

<script>
document.addEventListener("DOMContentLoaded", function() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebar-overlay');
    const toggle = document.getElementById('menuToggle');

    toggle.addEventListener('click', () => {
        sidebar.classList.toggle('active');
        overlay.style.display = sidebar.classList.contains('active') ? 'block' : 'none';
    });

    overlay.addEventListener('click', () => {
        sidebar.classList.remove('active');
        overlay.style.display = 'none';
    });
});
</script>

<script>
    // Pastikan variabel $totalPengunjung dan $totalSkm dilewatkan dari controller
    const donutColors = ['#30AADD', '#00917C', '#F9D923', '#F05454'];

    const totalPengunjung = {{ $totalPengunjung ?? 0 }}; // Tambahkan default value jika belum didefinisikan
    const totalSkm = {{ $totalSkm ?? 0 }}; // Tambahkan default value jika belum didefinisikan

    // Chart Pengunjung
    new Chart(document.getElementById('chartPengunjung'), {
        type: 'doughnut',
        data: {
            labels: ['Total Pengunjung'],
            datasets: [{
                data: [totalPengunjung],
                backgroundColor: donutColors[0], // Gunakan satu warna saja karena hanya ada satu data
                borderWidth: 0
            }]
        },
        options: { 
            responsive: true,
            maintainAspectRatio: false,
            plugins: { 
                legend: { display: false },
                tooltip: { callbacks: { label: (context) => `Total: ${context.parsed}` } }
            }, 
            cutout: '70%' 
        }
    });
    
    // Chart SKM
    new Chart(document.getElementById('chartSkm'), {
        type: 'doughnut',
        data: {
            labels: ['Total SKM'],
            datasets: [{
                data: [totalSkm],
                backgroundColor: donutColors[1], // Gunakan warna lain
                borderWidth: 0
            }]
        },
        options: { 
            responsive: true,
            maintainAspectRatio: false,
            plugins: { 
                legend: { display: false },
                tooltip: { callbacks: { label: (context) => `Total: ${context.parsed}` } }
            }, 
            cutout: '70%' 
        }
    });
</script>
