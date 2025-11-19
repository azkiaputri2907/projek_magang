@extends('layouts.app')

@section('title', 'Dashboard Admin | Disdik Kab.Banjar')

@section('content')
<style>
body {
    background-color: #DFEDFE;
    font-family: 'Poppins', sans-serif;
    margin: 0;
    min-height: 100vh;
    display: flex;
    justify-content: center;
    overflow-x: hidden;
}

/* LOGO HEADER */
.logo-header {
    position: absolute;
    top: 18px;
    right: 25px;
    display: flex;
    align-items: center;
    gap: 10px;
    z-index: 100;
}
.logo-header img { height: 50px; }

/* SIDEBAR */
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
    margin-bottom: 40px; /* ⭐ Tambahin jarak biar ga mentok bawah */
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


/* DASHBOARD CARD */
.container-dashboard {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 95%;
    max-width: 1300px;
    margin-top: 20px;
}
.dashboard-card {
    display: flex;
    background-color: #fff;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    height: 720px;
    width: 100%;
}

/* LEFT PANEL */
.dashboard-left {
    flex: 2.1;
    padding: 40px 50px;
    display: flex;
    flex-direction: column;
}

/* TITLE */
.title-card {
    display: flex;
    align-items: center;
    gap: 15px;
    font-size: 1.5rem;
    font-weight: 800;
    color: #007BFF;
    margin-bottom: 15px;
}
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

/* TODAY CARD */
.today-card {
    background-color: #ffadf1;
    color: #fff;
    border-radius: 12px;
    padding: 10px 20px;
    font-weight: 600;
    font-size: 0.9rem;
    box-shadow: 0 3px 6px rgba(0,0,0,0.1);
    margin-bottom: 15px;
    text-align: center;
}

/* ⭐ LAYANAN (FIXED — warna & ukuran sama versi awal) */
.layanan-card {
    background-color: #C9E1FF;
    padding: 15px 20px;
    border-radius: 15px;
    margin-bottom: 15px;
}
.layanan-card h3 {
    font-size: 1rem;
    font-weight: 600;
    color: #003366;
    margin-bottom: 14px;
}

.layanan-card ol {
    padding-left: 20px;
    margin: 0;
    font-size: 0.8rem;
}

.layanan-card ol li {
    margin-bottom: 6px;
}
.layanan-card ol li::marker {
    color: #007BFF;
    font-weight: 700;
}

/* DATA CARD */
.data-cards {
    display: flex;
    gap: 15px;
    margin-bottom: 15px;
}
.data-card {
    flex: 1;
    min-height: 120px;
    border-radius: 12px;
    padding: 15px;
    box-shadow: 0 3px 6px rgba(0,0,0,0.1);
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    color: #fff;
    cursor: pointer;
}
.data-card.pengunjung { background-color: #007bff; }
.data-card.skm { background-color: #2DD4BF; }
.data-card .card-header { display: flex; align-items: center; gap: 10px; }
.data-card h4 { font-size: 0.9rem; font-weight: 600; margin: 0; }
.icon-container { width: 25px; height: 25px; background-color: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; }
.count { font-size: 2rem; font-weight: 700; margin: 0; }
.description { font-size: 11px; margin-top: 3px; }

/* BUTTONS */
.button-wrapper { display: flex; gap: 15px; margin-top: 10px; }
.btn-item { flex: 1; font-weight: 600; padding: 12px 20px; border: none; border-radius: 12px; cursor: pointer; font-size: 0.9rem; display: flex; align-items: center; justify-content: center; gap: 8px; box-shadow: 0 3px 6px rgba(0,0,0,0.1); }
.btn-item:hover { transform: translateY(-1px); }
.btn-laporan { background-color: #dfefff; color: #444; }
.btn-keluar { background-color: #EF4444; color: #fff; }

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
}
.dashboard-right::after {
    content: "";
    position: absolute;
    inset: 0;
    background: linear-gradient(to bottom, rgba(0,0,0,0.3) 15%, transparent 60%);
}
.dashboard-right h1 {
    position: relative;
    font-size: 2rem;
    font-weight: 800;
    color: #fff;
    text-align: center;
    z-index: 2;
    margin-top: 40px;
    text-shadow: 0 2px 6px rgba(0,0,0,0.5);
}
.dashboard-right h1 span { color: #30E3BC; }

/* RESPONSIVE */
@media (max-width: 992px) {
    .dashboard-card { flex-direction: column; height: auto; }
    .dashboard-left { padding: 20px 25px; }
    .dashboard-right { height: 260px; padding-top: 40px; border-radius: 0 0 15px 15px; }
    .dashboard-right h1 { font-size: 1.4rem; margin-top: 10px; }

    .logo-header {
        top: 10px;
        right: 10px;
    }

    .logo-header img {
        height: 40px;
    }
}
</style>

{{-- LOGO HEADER --}}
<div class="logo-header">
    <img src="{{ asset('images/LOGO_KEMENTRIAN.png') }}" alt="Logo Kementrian">
    <img src="{{ asset('images/LOGO_PEMKAB_BANJAR.png') }}" alt="Logo Kab. Banjar">
</div>

{{-- SIDEBAR --}}
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
            <button type="submit"><i class="fas fa-sign-out-alt"></i> Keluar</button>
        </form>
    </div>
</div>
<div id="sidebar-overlay"></div>

{{-- DASHBOARD --}}
<div class="container-dashboard">
    <div class="dashboard-card">

        {{-- RIGHT PANEL --}}
        <div class="dashboard-right" style="order:1;">
            <h1>Selamat Datang, <span>Admin!</span></h1>
        </div>

        {{-- LEFT PANEL --}}
        <div class="dashboard-left" style="order:2;">

            <div class="title-card">
                <div class="menu-icon" id="menuToggle"><span></span><span></span><span></span></div>
                Dashboard <span style="color:#30E3BC;">Admin!</span>
            </div>

            {{-- TODAY --}}
            <div class="today-card" id="today-card"></div>

            {{-- LAYANAN --}}
            <div class="layanan-card">
                <h3>Layanan di Satu Pintu Disdik</h3>
                <ol>
                    <li>Rekomendasi Mutasi</li>
                    <li>Rekomendasi Mutasi Siswa</li>
                    <li>Surat Keterangan Pengganti Ijazah</li>
                    <li>Legalisir Ijazah</li>
                    <li>Magang / Penelitian</li>
                    <li>NPSN</li>
                    <li>Rekomendasi Izin Pendirian Satuan Pendidikan</li>
                    <li>Rekomendasi Pendirian Satuan Pendidikan</li>
                    <li>Rekomendasi Operasional Satuan Pendidikan</li>
                </ol>
            </div>

            {{-- DATA CARDS --}}
            <div class="data-cards">

                <a href="{{ url('/admin/pengunjung') }}" class="data-card pengunjung" style="text-decoration:none;">
                    <div class="card-header">
                        <div class="icon-container"><i class="fas fa-users"></i></div>
                        <h4>Data Pengunjung</h4>
                    </div>
                    <p class="count">{{ $total_pengunjung ?? 0 }}</p>
                    <span class="description">Pengunjung</span>
                </a>

                <a href="{{ url('/admin/skm') }}" class="data-card skm" style="text-decoration:none;">
                    <div class="card-header">
                        <div class="icon-container"><i class="fas fa-user-check"></i></div>
                        <h4>Data SKM</h4>
                    </div>
                    <p class="count">{{ $total_skm ?? 0 }}</p>
                    <span class="description">Survey Kepuasan Masyarakat</span>
                </a>

            </div>


            {{-- BUTTONS --}}
            <div class="button-wrapper">
                <a href="{{ route('admin.laporan') }}" class="btn-item btn-laporan">
                    <i class="fas fa-chart-line"></i> Laporan
                </a>

                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-item btn-keluar">
                        <i class="fas fa-sign-out-alt"></i> Keluar
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {

    // Tanggal hari ini
    const today = new Date();
    const options = { weekday:'long', day:'numeric', month:'long', year:'numeric' };
    document.getElementById('today-card').innerText =
        today.toLocaleDateString('id-ID', options);

    // Sidebar toggle
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
@endsection
