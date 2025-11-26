@extends('layouts.app')

@section('title', 'Dashboard Admin | Disdik Kab.Banjar')

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

/* ======================== DASHBOARD CONTENT ======================== */
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
    /* EFEK TIMBUL: Shadow berlapis & Border halus */
    box-shadow: 
        0 20px 50px rgba(0,0,0,0.2), 
        0 10px 15px rgba(0,0,0,0.1);
    border: 1px solid rgba(255, 255, 255, 0.6);
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
    /* EFEK TIMBUL: Gradient & Soft Shadow */
    background: linear-gradient(135deg, #ffadf1 0%, #ff85ea 100%);
    color: #fff;
    border-radius: 12px;
    padding: 10px 20px;
    font-weight: 600;
    font-size: 0.9rem;
    box-shadow: 0 8px 15px rgba(255, 133, 234, 0.3);
    margin-bottom: 15px;
    text-align: center;
    border-top: 1px solid rgba(255,255,255,0.4); /* Highlight atas */
}

/* LAYANAN */
.layanan-card {
    background-color: #C9E1FF;
    padding: 15px 20px;
    border-radius: 15px;
    margin-bottom: 15px;
    /* EFEK TIMBUL: Shadow bawah */
    box-shadow: 
        0 10px 20px rgba(0, 123, 255, 0.1),
        inset 0 2px 0 rgba(255, 255, 255, 0.4); /* Highlight dalam */
    border: 1px solid #bde0ff;
}

/* ANIMASI MASUK */
@keyframes slideFadeIn {
    0% { opacity: 0; transform: translateX(-25px) scale(.98); }
    100% { opacity: 1; transform: translateX(0) scale(1); }
}
.layanan-card h3 {
    font-size: 1rem;
    font-weight: 600;
    color: #003366;
    margin-bottom: 14px;
    opacity: 0;
    animation: slideFadeIn .6s ease-out forwards;
    animation-delay: .25s;    
}

.layanan-card ol {
    padding-left: 20px;
    margin: 0;
    font-size: 0.8rem;
}

.layanan-card ol li {
    margin-bottom: 6px;
    animation: slideFadeIn .45s ease-out forwards;    
}
.layanan-card ol li::marker {
    color: #007BFF;
    font-weight: 700;
}
/* Stagger */
.layanan-card ol li:nth-child(1) { animation-delay: .30s; }
.layanan-card ol li:nth-child(2) { animation-delay: .36s; }
.layanan-card ol li:nth-child(3) { animation-delay: .42s; }
.layanan-card ol li:nth-child(4) { animation-delay: .48s; }
.layanan-card ol li:nth-child(5) { animation-delay: .54s; }
.layanan-card ol li:nth-child(6) { animation-delay: .60s; }
.layanan-card ol li:nth-child(7) { animation-delay: .66s; }
.layanan-card ol li:nth-child(8) { animation-delay: .72s; }
.layanan-card ol li:nth-child(9) { animation-delay: .78s; }

/* DATA CARD */
.data-cards {
    display: flex;
    gap: 15px;
    margin-bottom: 15px;
}
.data-card {
    flex: 1;
    min-height: 120px;
    border-radius: 16px;
    padding: 20px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    color: #fff;
    cursor: pointer;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    
    /* EFEK 3D GLOSSY */
    position: relative;
    overflow: hidden;
    border-top: 1px solid rgba(255,255,255,0.3);
    border-bottom: 1px solid rgba(0,0,0,0.1);
}

.data-card.pengunjung { 
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    box-shadow: 0 10px 20px rgba(37, 99, 235, 0.3);
}

.data-card.skm { 
    background: linear-gradient(135deg, #2DD4BF 0%, #0d9488 100%);
    box-shadow: 0 10px 20px rgba(13, 148, 136, 0.3);
}

.data-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(0,0,0,0.2);
}

.data-card .icon-container {
    width: 35px; 
    height: 35px; 
    background-color: rgba(255,255,255,0.25); 
    border-radius: 50%; 
    display: flex; 
    align-items: center; 
    justify-content: center;
    backdrop-filter: blur(5px);
    box-shadow: inset 0 2px 5px rgba(255,255,255,0.2);
}
.data-card h4 { font-size: 0.9rem; font-weight: 600; margin: 0; }
.count { font-size: 2rem; font-weight: 700; margin: 0; }
.description { font-size: 11px; margin-top: 3px; }

/* BUTTONS DASHBOARD */
.button-wrapper { display: flex; gap: 15px; margin-top: 10px; }
.btn-item:hover { transform: translateY(-1px); }
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
    transition: all 0.2s;
    border-bottom: 4px solid rgba(0,0,0,0.1); 
}

.btn-item:active {
    transform: translateY(2px);
    border-bottom: 2px solid rgba(0,0,0,0.1);
}

.btn-laporan { 
    background-color: #dfefff; 
    color: #0056b3; 
    box-shadow: 0 4px 6px rgba(0,0,0,0.05);
}

.btn-keluar { 
    background: linear-gradient(135deg, #EF4444 0%, #dc2626 100%);
    color: #fff; 
    box-shadow: 0 4px 10px rgba(239, 68, 68, 0.3);
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

{{-- === PANGGIL SIDEBAR DARI COMPONENT === --}}
@include('components._sidebar')

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

                <form action="{{ route('admin.logout') }}" method="POST" style="flex:1;">
                    @csrf
                    <button type="submit" class="btn-item btn-keluar" style="width:100%;">
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

});
</script>
@endsection