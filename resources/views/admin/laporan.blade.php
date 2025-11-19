@extends('layouts.app')

@section('title', 'Laporan | Disdik Kab.Banjar')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@section('content')
<style>
/* ======================== GLOBAL ======================== */
body {
    background-color: #DFEDFE;
    font-family: 'Poppins', sans-serif;
    margin: 0;
    /* PENYESUAIAN: Menghapus padding-top 50px */
    padding-top: 0rem; 
    min-height: 100vh;
    overflow-x: hidden;
}

/* LOGO */
.logo-header {
    position: absolute;
    top: 18px; /* Lebih ke atas */
    right: 25px;
    display: flex;
    align-items: center;
    gap: 10px;
    z-index: 100;
}
.logo-header img { height: 50px; } /* Lebih kecil */

/* SIDEBAR - Pertahankan Gaya Asli */
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
    display: flex;
    flex-direction: column;
}

#sidebar.active { 
    left: 0; 
}

#sidebar-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.5);
    z-index: 999;
    display: none;
}

#sidebar.active + #sidebar-overlay { 
    display: block; 
}

/* PROFILE DI SIDEBAR */
.sidebar-profile {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 0 15px 20px 15px;
    border-bottom: 1px solid #eee;
    margin-bottom: 10px;
    text-align: center;
}

.sidebar-profile img {
    width: 60px; 
    height: 60px;
    border-radius: 50%;
    object-fit: cover;
    margin-bottom: 10px;
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


/* MENU LINK */
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

.sidebar-link i { 
    margin-right: 10px; 
}

.sidebar-link:hover { 
    background-color: rgba(220,53,69,0.05); 
}

.sidebar-link.active {
    background-color: rgba(195, 222, 255, 0.909);
    border-left: 4px solid #CFDDF7;
    font-weight: bold;
    border-radius: 0 8px 8px 0;
    margin-left: 0;
    margin-right: 20px;
    padding-left: 20px;
}


/* FOOTER / LOGOUT */
.sidebar-footer {
    padding: 15px;
    margin-top: auto;
    margin-bottom: 40px; 
}

.sidebar-footer form button {
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 10px;
    background-color: #EF4444;
    color: #fff;
    border: none;
    border-radius: 5px;
    font-weight: bold;
    cursor: pointer;
}

/* === DASHBOARD MAIN LAYOUT === */
.container-dashboard {
    display: flex;
    justify-content: center;
    align-items: flex-start;
    width: 95%;
    max-width: 1300px;
    margin: 0 auto;
    /* PENYESUAIAN: Konten ditarik ke atas */
    padding-top: 0; 
    margin-top: 5px; 
    padding-bottom: 20px;
}

.dashboard-card {
    display: flex;
    background-color: #fff;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    min-height: 580px;
    width: 100%;
}

/* ================= LEFT PANEL (KONTEN) ================= */
.dashboard-left {
    flex: 2.1; /* Mengadopsi rasio konten yang lebih besar */
    padding: 40px 50px;
    display: flex;
    flex-direction: column;
    position: relative;
    gap: 20px;
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
}
.title-card span {
    color: #30E3BC; 
}


/* MENU ICON */
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


/* REPORT CONTENT & CHARTS */
.report-content {
    display: flex;
    justify-content: center; /* Diubah dari space-around ke center */
    align-items: flex-start; /* Diubah dari center ke flex-start */
    gap: 40px;
    padding: 20px 0;
    flex-wrap: wrap;
    flex-grow: 1;
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
    border: 1px solid #eee; /* Tambah border tipis */
}

/* FIX DONUT BIAR NGGAK GEPENG */
.chart-wrapper {
    width: 220px;
    height: 220px;
    position: relative;
    margin-bottom: 10px;
}
.chart-wrapper canvas {
    position: absolute;
    inset: 0;
}
.report-chart p {
    font-weight: 600;
    color: #333;
    margin: 5px 0 0 0;
}


/* BUTTON UNDUH */
.btn-unduh {
    display: inline-block;
    background-color: #1BC5BD;
    color: white;
    padding: 10px 25px; /* Disesuaikan */
    margin-top: 15px; /* Disesuaikan */
    border-radius: 10px; /* Disesuaikan */
    font-weight: 600;
    text-decoration: none;
    box-shadow: 0 3px 8px rgba(27, 197, 189, 0.4);
    transition: 0.2s ease;
    text-transform: uppercase;
    font-size: 0.85rem;
}
.btn-unduh:hover {
    background-color: #15a098;
}


/* RIGHT PANEL (Image) - Mengadopsi dashboard-left-image Data Pengunjung */
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
    padding: 80px 40px 40px; /* Padding disesuaikan */
    position: relative;
    border-top-right-radius: 20px;
    border-bottom-right-radius: 20px;
    overflow: hidden;
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
    font-size: 2.2rem; /* Disesuaikan */
    font-weight: 800;
    margin-top: 40px;
    text-shadow: 0 3px 8px rgba(0,0,0,0.55);
}
.dashboard-right h1 span { color: #30E3BC; }


/* === RESPONSIVE MODE === */
@media (max-width: 992px) {

    .dashboard-card { flex-direction: column; min-height: auto; }

    /* Mengubah urutan untuk mobile: Gambar di atas */
    .dashboard-right { 
        order: 1;
        height: 260px; 
        padding-top: 40px; 
        border-radius: 20px 20px 0 0; 
        border-bottom-right-radius: 0;
    }

    .dashboard-right h1 { font-size: 1.8rem; margin-top: 10px; }
    
    .dashboard-left {
        order: 2;
        padding: 30px 20px;
    }

    .title-card {
        font-size: 1.8rem;
    }
    
    .container-dashboard {
        margin-top: 10px; 
    }

    .logo-header {
        top: 10px;
        right: 10px;
    }

    .logo-header img {
        height: 40px;
    }
    
    .report-chart {
        width: 100%;
        max-width: 320px; /* Batasi lebar chart di mobile */
    }
    
    .report-content {
        gap: 20px;
        justify-content: center;
    }
}

@media (max-width: 600px) {
    .dashboard-right h1 {
        font-size: 1.5rem;
    }
    
    .title-card {
        font-size: 1.5rem;
    }
    
    .report-chart {
        padding: 15px;
    }
    
    .btn-unduh {
        padding: 8px 15px;
        font-size: 0.75rem;
    }

    .dashboard-card {
        border-radius: 15px;
    }
    .dashboard-right {
        border-radius: 15px 15px 0 0;
    }
}
</style>

{{-- === LOGO === --}}
<div class="logo-header">
    <img src="{{ asset('images/LOGO_KEMENTRIAN.png') }}" alt="Logo Kementrian">
    <img src="{{ asset('images/LOGO_PEMKAB_BANJAR.png') }}" alt="Logo Kab. Banjar">
</div>

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
                Laporan <span>Data</span>
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
        cutout: '70%',
        elements: {
            arc: {
                borderWidth: 0
            }
        }
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
        cutout: '70%',
        elements: {
            arc: {
                borderWidth: 0
            }
        }
    }
});
</script>

@endsection