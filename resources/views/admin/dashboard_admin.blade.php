@extends('layouts.app')

@section('title', 'Dashboard Admin | Disdik Kab.Banjar')

@section('content')
<style>
body {
    background-color: #DFEDFE;
    font-family: 'Poppins', sans-serif;
    margin: 0;
    padding-top: 50px; 
    min-height: 100vh;
    display: flex;
    flex-direction: column; 
    align-items: center;
    overflow-x: hidden;
}

/* === LOGO HEADER === */
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

/* === DASHBOARD === */
.container-dashboard {
    display: flex;
    justify-content: center;
    align-items: flex-start;
    width: 95%;
    max-width: 1300px;
    position: relative;
    margin-top: 20px; 
}
.dashboard-card {
    display: flex;
    background-color: #fff;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    width: 100%;
    min-height: 700px;
}
.dashboard-left {
    flex: 2.1;
    padding: 15px 30px; 
    display: flex;
    flex-direction: column; 
    gap: 15px;
    justify-content: flex-start;
}

/* === TITLE CARD === */
.title-card {
    background-color: #fff;
    border-radius: 12px;
    padding: 10px 20px;
    font-size: 1.5rem;
    font-weight: 800;
    color: #007BFF;
    text-align: left;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    display: flex;
    align-items: center;
    gap: 15px;
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

/* === TODAY CARD === */
.today-card {
    background-color: #ffadf1;
    color: #fff;
    border-radius: 12px;
    padding: 10px 20px;
    font-weight: 600;
    font-size: 0.9rem;
    box-shadow: 0 3px 6px rgba(0,0,0,0.1);
}

/* === DATA CARD === */
.data-cards {
    display: flex;
    gap: 15px;
    width: 100%;
}
.left-cards-wrapper {
    display: flex;
    flex-direction: column;
    gap: 15px;
    flex: 1;
}
.top-data-cards {
    display: flex;
    gap: 15px;
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
}
.data-card.pengunjung { background-color: #007bff; }
.data-card.skm { background-color: #2DD4BF; }

.data-card .card-header {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 5px;
}
.data-card h4 {
    font-size: 0.9rem;
    font-weight: 600;
    margin: 0;
}
.icon-container {
    width: 25px; height: 25px;
    background-color: rgba(255,255,255,0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}
.count { font-size: 2rem; font-weight: 700; margin: 0; }
.description { font-size: 11px; margin-top: 3px; }

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

/* === LAYANAN CARD === */
.layanan-card {
    flex: 1.8;
    background-color: #E7F1FF;
    border-radius: 14px;
    padding: 15px 20px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    overflow-y: auto;
    max-height: 450px;
}
.layanan-card h3 {
    font-size: 0.9rem;
    font-weight: 700;
    color: #003366;
    margin-bottom: 8px;
}
.layanan-card ol {
    list-style: none;
    padding: 0;
    margin: 0;
    counter-reset: listnum;
    font-size: 0.7rem;
}
.layanan-card li {
    counter-increment: listnum;
    margin-bottom: 3px;
    padding-left: 18px;
    position: relative;
}
.layanan-card li::before {
    content: counter(listnum) ".";
    position: absolute;
    left: 0;
    color: #007BFF;
    font-weight: 600;
}

/* === RIGHT PANEL === */
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

/* === RESPONSIVE === */
@media (max-width: 992px) {
    .data-cards { flex-direction: column; }
    .dashboard-card { flex-direction: column; }
}
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

{{-- === DASHBOARD === --}}
<div class="container-dashboard">
    <div class="dashboard-card">
        <div class="dashboard-left">
            <div class="title-card">
                <div class="menu-icon" id="menuToggle"><span></span><span></span><span></span></div>
                Dashboard <span style="color:#30E3BC;">Admin!</span>
            </div>

            <div class="today-card" id="today-card"></div>

            <div class="data-cards">
                <div class="left-cards-wrapper">
                    <div class="top-data-cards">
                        <div class="data-card pengunjung">
                            <div class="card-header">
                                <div class="icon-container"><i class="fas fa-users"></i></div>
                                <h4>Data Pengunjung</h4>
                            </div>
                            <div class="card-body">
                                <p class="count">{{ $total_pengunjung ?? 0 }}</p>
                                <span class="description">Pengunjung</span>
                            </div>
                        </div>

                        <div class="data-card skm">
                            <div class="card-header">
                                <div class="icon-container"><i class="fas fa-user-check"></i></div>
                                <h4>Data SKM</h4>
                            </div>
                            <div class="card-body">
                                <p class="count">{{ $total_skm ?? 0 }}</p>
                                <span class="description">Survey Kepuasan Masyarakat</span>
                            </div>
                        </div>
                    </div>

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
            </div>
        </div>

        <div class="dashboard-right">
            <h1>Selamat Datang, <span>Admin!</span></h1>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const today = new Date();
    const options = { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' };
    document.getElementById('today-card').innerText = today.toLocaleDateString('id-ID', options);

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
