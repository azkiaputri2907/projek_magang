@extends('layouts.app')

@section('title', 'Laporan | Disdik Kab.Banjar')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@section('content')
<style>
body {
    background-color: #DFEDFE;
    font-family: 'Poppins', sans-serif;
    margin: 0;
    padding-top: 50px;
    min-height: 100vh;
}

/* LOGO */
.logo-header {
    position: absolute;
    top: 25px;
    right: 45px;
    display: flex;
    gap: 10px;
    z-index: 100;
}
.logo-header img { height: 55px; }

/* === SIDEBAR === */
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
    border-radius: 0 20px 20px 0;

    display: flex;          /* biar bisa dorong footer ke bawah */
    flex-direction: column; /* vertikal */
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
    flex-direction: column;     /* susun vertikal */
    justify-content: center;
    align-items: center;        /* center horizontal */
    padding: 0 15px 20px 15px;
    border-bottom: 1px solid #eee;
    margin-bottom: 10px;
    text-align: center;         /* biar teksnya center */
}

.sidebar-profile img {
    width: 60px; 
    height: 60px;
    border-radius: 50%; 
    object-fit: cover;
    margin: 0 0 10px 0;         /* jarak ke nama */
}

.sidebar-profile div {
    font-size: 14px;
    color: #333;
}

.sidebar-profile div span {
    display: block;
    font-size: 12px;
    color: #666;
}

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
    background-color: rgba(195, 222, 255, 0.909);
    border-left: 4px solid #CFDDF7;
    font-weight: bold;
    border-radius: 0 8px 8px 0;   /* sudut kiri lurus, kanan rounded */
    margin-left: 0;              /* tempelin ke kiri */
    margin-right: 20px;          /* kasih spasi kanan */
    padding-left: 20px;          /* sedikit masuk ke dalam */
}
.sidebar-footer {
    padding: 15px;
    margin-top: auto; 
}
.sidebar-footer a {
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 10px;
    text-decoration: none;
    color: #fff;
    background-color: #a5ceff;
    font-weight: bold;
    border-radius: 5px;
    font-size: 14px;
}


/* CONTAINER */
.container-dashboard {
    display: flex;
    justify-content: center;
    width: 95%;
    max-width: 1300px;
    margin: 20px auto;
}

.dashboard-card {
    display: flex;
    background: #fff;
    border-radius: 20px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    width: 100%;
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


/* MENU ICON */
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

.report-content {
    display: flex;
    justify-content: space-around;
    align-items: center;
    gap: 40px;
    padding: 20px 0;
    flex-wrap: wrap;
}

.report-chart {
    text-align: center;
    background: #fff;
    border-radius: 15px;
    padding: 20px;
    box-shadow: 0 6px 15px rgba(0,0,0,0.1);
    width: 260px;
    height: 320px;
    display: flex;
    flex-direction: column;
    align-items: center;
}

/* FIX DONUT BIAR NGGAK GEPENG */
.chart-wrapper {
    width: 220px;
    height: 220px;
    position: relative;
}
.chart-wrapper canvas {
    position: absolute;
    inset: 0;
}


/* BUTTON */
/* === BUTTONS === */
.button-wrapper {
    display: flex;
    gap: 15px;
}
.btn-item {
    flex: 1;
    font-weight: 600;
    padding: 12px 20px;
    border: none;
    border-radius: 12px;
    cursor: pointer;
    font-size: 0.9rem;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    box-shadow: 0 3px 6px rgba(0,0,0,0.1);
    transition: transform 0.2s;
}
.btn-item:hover { transform: translateY(-1px); }
.btn-laporan { background-color: #dfefff; color: #444; }
.btn-keluar { background-color: #EF4444; color: #fff; }

.btn-unduh {
    display: inline-block;
    background-color: #1BC5BD;
    color: white;
    padding: 10px 30px;
    margin-top: 12px;
    border-radius: 8px;
    font-weight: 600;
    text-decoration: none;
}
.btn-unduh:hover {
    background-color: #15a098;
}

/* RIGHT PANEL */
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
    text-align: center;
    font-size: 2rem;
    font-weight: 800;
    margin-top: 40px;
}
.dashboard-right h1 span { color: #30E3BC; }

</style>

{{-- === LOGO === --}}
<div class="logo-header">
    <img src="{{ asset('images/LOGO_KEMENTRIAN.png') }}" alt="Logo Kementrian">
    <img src="{{ asset('images/LOGO_PEMKAB_BANJAR.png') }}" alt="Logo Kab. Banjar">
</div>

<!-- === SIDEBAR === -->
<div id="sidebar">
    <div class="sidebar-profile">
        <img src="{{ asset('images/avatar_admin.jpg') }}" alt="Avatar">
        <div>
            {{ Auth::user()->name ?? 'Admin' }}
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
                    <div class="chart-wrapper">
                        <canvas id="chartPengunjung"></canvas>
                    </div>
                    <p>Data Pengunjung</p>
                        <a href="https://docs.google.com/spreadsheets/d/1XKirvKDNNnwcauLTxHebHCcHbAdEHLZdL5caoB3HiVE/export?format=xlsx" 
                        class="btn-unduh" target="_blank">
                        Unduh
                        </a>
                </div>

                <div class="report-chart">
                    <div class="chart-wrapper">
                        <canvas id="chartSkm"></canvas>
                    </div>
                    <p>Data SKM</p>
                        <a href="https://docs.google.com/spreadsheets/d/1iTmYnrKDmx3lmoIjoEqeAkSlHE0aePXF56SGFqfl6J0/export?format=xlsx" 
                        class="btn-unduh" target="_blank">
                        Unduh
                        </a>
                </div>

            </div>
        </div>

        <div class="dashboard-right">
            <h1>Data Laporan <span>Buku Tamu</span></h1>
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
const donutColors = ['#30AADD', '#00917C', '#F9D923', '#F05454'];

const totalPengunjung = {{ $totalPengunjung ?? 0 }};
const totalSkm = {{ $totalSkm ?? 0 }};

new Chart(document.getElementById('chartPengunjung'), {
    type: 'doughnut',
    data: {
        labels: ['Total Pengunjung'],
        datasets: [{
            data: [totalPengunjung],
            backgroundColor: donutColors[0],
            borderWidth: 0
        }]
    },
    options: { 
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        cutout: '70%' 
    }
});

new Chart(document.getElementById('chartSkm'), {
    type: 'doughnut',
    data: {
        labels: ['Total SKM'],
        datasets: [{
            data: [totalSkm],
            backgroundColor: donutColors[1],
            borderWidth: 0
        }]
    },
    options: { 
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        cutout: '70%' 
    }
});
</script>

@endsection
