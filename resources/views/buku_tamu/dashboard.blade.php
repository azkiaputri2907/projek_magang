@extends('layouts.app')

@section('title', 'Buku Tamu Disdik')

@section('content')
<style>
/* ===== GLOBAL BACKGROUND ===== */
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
    align-items: center;
    overflow-x: hidden;
}

/* ★ ANIMASI MASUK */
@keyframes slideFadeIn {
    0% { opacity: 0; transform: translateY(10px); }
    100% { opacity: 1; transform: translateY(0); }
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
}
.logo-header img { height: 50px; filter: drop-shadow(0 4px 4px rgba(0,0,0,0.1)); }

/* WRAPPER */
.container-bukutamu {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 95%;
    max-width: 1300px;
    position: relative;
    padding-top: 20px;
    padding-bottom: 20px;
}

/* EFEK TIMBUL: Main Card Container */
.bukutamu-card {
    display: flex;
    background-color: #fff;
    border-radius: 20px;
    overflow: hidden;
    /* Shadow berlapis untuk kedalaman */
    box-shadow: 
        0 20px 50px rgba(0,0,0,0.15), 
        0 5px 15px rgba(0,0,0,0.05);
    border: 1px solid rgba(255, 255, 255, 0.6);
    height: 720px;
    width: 100%;
}

/* ================= LEFT (GAMBAR) ================= */
.bukutamu-left {
    flex: 0.9;
    background-image: url('{{ asset("images/pengunjung.jpg") }}');
    background-size: cover;
    background-position: center;
    display: flex;
    justify-content: flex-start;
    align-items: center;
    flex-direction: column;
    position: relative;
    padding: 80px 40px 40px;
    
    /* Pemisah bayangan antara kiri dan kanan */
    box-shadow: 5px 0 15px rgba(0,0,0,0.15); 
    z-index: 2;
}

.bukutamu-left::after {
    content: "";
    position: absolute;
    inset: 0;
    background: linear-gradient(to bottom, rgba(0,0,0,0.4) 10%, transparent 60%);
    z-index: 1;
}

.bukutamu-left h1 {
    position: relative;
    font-size: 2.2rem;
    font-weight: 800;
    color: #fff;
    margin-top: 40px;
    margin-bottom: 30px;
    z-index: 2;
    text-shadow: 0 4px 10px rgba(0,0,0,0.6); /* Teks timbul */
}

.bukutamu-left h1 span { color: #30E3BC; }

/* ================= RIGHT (KONTEN) ================= */
.bukutamu-right {
    flex: 2.1;
    padding: 40px 50px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    position: relative;
    background-color: #F8FBFF; /* Warna dasar sedikit abu biru */
    z-index: 1;
}

.right-content-wrapper {
    display: flex;
    gap: 40px;
    flex-grow: 1;
}

/* === LAYANAN CARD (EFEK KERTAS TIMBUL) === */
.layanan-section {
    width: 120%;
    transform: translateX(-5%);
    z-index: 10; /* Agar melayang di atas */
}

.layanan-card {
    background: linear-gradient(145deg, #DFEDFE, #E7F1FF);
    border-radius: 16px;
    padding: 28px 50px 28px 35px;
    max-height: 620px;
    overflow-y: auto;
    
    /* EFEK TIMBUL KUAT */
    box-shadow: 
        10px 10px 20px rgba(0, 51, 102, 0.1),
        -5px -5px 15px rgba(255, 255, 255, 0.8);
    border: 1px solid rgba(255,255,255,0.6);
}

.layanan-card h3 {
    font-size: 1rem;
    font-weight: 700;
    color: #003366;
    margin-bottom: 14px;
    opacity: 0;
    animation: slideFadeIn .6s ease-out forwards;
    animation-delay: .25s;
    text-shadow: 0 1px 1px rgba(255,255,255,0.8);
}

.layanan-card ol {
    padding-left: 20px;
    margin: 0;
    font-size: 0.8rem;
    color: #444;
}

.layanan-card ol li {
    margin-bottom: 8px;
    opacity: 0;
    animation: slideFadeIn .45s ease-out forwards;
}

/* Stagger Animation */
.layanan-card ol li:nth-child(1) { animation-delay: .30s; }
.layanan-card ol li:nth-child(2) { animation-delay: .36s; }
.layanan-card ol li:nth-child(3) { animation-delay: .42s; }
.layanan-card ol li:nth-child(4) { animation-delay: .48s; }
.layanan-card ol li:nth-child(5) { animation-delay: .54s; }
.layanan-card ol li:nth-child(6) { animation-delay: .60s; }
.layanan-card ol li:nth-child(7) { animation-delay: .66s; }
.layanan-card ol li:nth-child(8) { animation-delay: .72s; }
.layanan-card ol li:nth-child(9) { animation-delay: .78s; }

/* === TABLE SECTION === */
.tabel-section {
    flex: 1;
    display: flex;
    flex-direction: column;
}

/* DATE BOX (EFEK CAPSULE TIMBUL) */
.date-box {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-radius: 50px;
    width: 240px;
    margin-left: auto;
    margin-bottom: 15px;
    padding: 8px 6px;
    background: #fff;
    
    /* Shadow halus inset & outset */
    box-shadow: 
        0 4px 6px rgba(0,0,0,0.05),
        inset 0 -2px 0 rgba(0,0,0,0.02);
    border: 1px solid #e1e5eb;
}

.date-box .nav-btn {
    border: none;
    background: #E7F1FF;
    width: 30px; 
    height: 30px;
    border-radius: 50%;
    color: #007BFF;
    cursor: pointer;
    font-weight: bold;
    display: flex; 
    align-items: center; 
    justify-content: center;
    transition: all 0.2s;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.date-box .nav-btn:hover { background: #007BFF; color: #fff; }
.date-box .nav-btn:active { transform: scale(0.9); }

/* TABEL HEADER (EFEK BAR) */
.guest-header {
    display: flex;
    font-weight: 700;
    background: linear-gradient(to right, #007BFF, #0056b3);
    color: #fff;
    padding: 12px 15px;
    border-radius: 10px;
    font-size: .9rem;
    box-shadow: 0 4px 8px rgba(0, 123, 255, 0.25); /* Shadow biru */
    margin-bottom: 10px;
    border-bottom: 2px solid #004494; /* Efek tebal bawah */
}

.guest-row {
    display: flex;
    padding: 10px 15px;
    font-size: .85rem;
    border-bottom: 1px solid #eee;
    transition: background 0.2s;
    background: #fff;
    margin-bottom: 5px;
    border-radius: 8px;
}
.guest-row:hover {
    background-color: #f0f7ff;
    transform: translateY(-1px);
    box-shadow: 0 2px 5px rgba(0,0,0,0.05);
}

.col-tanggal { flex: 1; }
.col-nama { flex: 1.8; font-weight: 600; color: #333; }
.col-instansi { flex: 1.3; }
.col-layanan { flex: 1.5; }
.col-keperluan { flex: 2.2; }

.tabel-container {
    flex-grow: 1;
    overflow-y: auto;
    margin-top: 5px;
    padding-right: 6px;
    max-height: 480px;
}

/* === TOMBOL TAMBAH (EFEK 3D PUSH) === */
.btn-tambah {
    position: absolute;
    bottom: 30px;
    right: 50px;
    background: linear-gradient(135deg, #30E3BC 0%, #1bcfa5 100%);
    color: #fff;
    padding: 12px 35px;
    border-radius: 50px;
    font-weight: 700;
    text-decoration: none;
    letter-spacing: 0.5px;
    
    /* KUNCI EFEK 3D */
    box-shadow: 
        0 6px 0 #16a080, /* Ketebalan tombol */
        0 12px 20px rgba(48, 227, 188, 0.4); /* Bayangan lantai */
    transition: all 0.15s cubic-bezier(0.4, 0, 0.2, 1);
    transform: translateY(0);
}

.btn-tambah:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 0 #16a080, 0 15px 25px rgba(48, 227, 188, 0.5);
}

.btn-tambah:active {
    transform: translateY(6px); /* Turun ke bawah */
    box-shadow: 0 0 0 #16a080, 0 2px 5px rgba(48, 227, 188, 0.4);
}


/* RESPONSIVE */
@media (max-width: 992px) {
    .bukutamu-card { flex-direction: column; height: auto; }
    .bukutamu-left { height: 260px; padding: 40px 20px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
    .right-content-wrapper { flex-direction: column; gap: 25px; }
    .layanan-section { width: 100%; transform: none; }
    .layanan-card { max-height: none; padding: 25px; }
    .tabel-section { width: 100%; }
    
    .btn-tambah {
        position: relative;
        bottom: unset; right: unset;
        margin-top: 30px;
        align-self: center;
        display: inline-block;
        text-align: center;
        width: 200px;
    }
    
    .logo-header { top: 10px; right: 10px; }
    .logo-header img { height: 40px; }
}

@media (min-width: 993px) {
    .layanan-section { flex: 0.7; max-width: 30%; }
    .tabel-section { flex: 2.3; max-width: 70%; }
}

@media (max-width: 600px) {
    .bukutamu-left h1 { font-size: 1.5rem; }
    .date-box { width: 100%; justify-content: space-between; gap: 10px; }
    .guest-header, .guest-row { flex-wrap: wrap; }
    .guest-header span, .guest-row span { font-size: .75rem; width: 100%; display: block; margin-bottom: 2px; }
}
</style>

<div class="logo-header">
    <img src="{{ asset('images/LOGO_KEMENTRIAN.png') }}" alt="Logo Kementrian">
    <img src="{{ asset('images/LOGO_PEMKAB_BANJAR.png') }}" alt="Logo Kab. Banjar">
</div>

<div class="container-bukutamu">
    <div class="bukutamu-card">
        <!-- ================= KIRI ================= -->
        <div class="bukutamu-left">
            <h1>Isi <span>Buku Tamu,</span> Yuk!</h1>
        </div>

        <!-- ================= KANAN ================= -->
        <div class="bukutamu-right">
            <div class="right-content-wrapper">
                <!-- === LAYANAN === -->
                <div class="layanan-section">
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

                <!-- === TABEL === -->
                <div class="tabel-section">
                    <div class="date-box">
                        <button class="nav-btn" id="prevMonth">&lt;</button>
                        <span id="monthDisplay">{{ now()->translatedFormat('F Y') }}</span>
                        <button class="nav-btn" id="nextMonth">&gt;</button>
                    </div>

                    <div class="guest-header">
                        <span class="col-tanggal">Tanggal</span>
                        <span class="col-nama">Nama / NIP</span>
                        <span class="col-instansi">Instansi</span>
                        <span class="col-layanan">Layanan</span>
                        <span class="col-keperluan">Keperluan</span>
                    </div>

                    <div class="tabel-container">
                        @if(!empty($pengunjung) && count($pengunjung) > 0)
                            @foreach($pengunjung as $tamu)
                                <div class="guest-row">
                                    <span class="col-tanggal">{{ \Carbon\Carbon::parse($tamu->tanggal)->translatedFormat('d M Y') }}</span>
                                    <span class="col-nama">{{ $tamu->nama_nip }}</span>
                                    <span class="col-instansi">{{ $tamu->instansi }}</span>
                                    <span class="col-layanan">{{ $tamu->layanan }}</span>
                                    <span class="col-keperluan">{{ $tamu->keperluan }}</span>
                                </div>
                            @endforeach
                        @else
                            @for($i=0;$i<3;$i++)
                            <div class="guest-row">
                                <span class="col-tanggal"></span>
                                <span class="col-nama"></span>
                                <span class="col-instansi"></span>
                                <span class="col-layanan"></span>
                                <span class="col-keperluan"></span>
                            </div>
                            @endfor
                        @endif
                    </div>
                </div>
            </div>

            <a href="{{ url('/buku-tamu/isi') }}" class="btn-tambah">Tambah</a>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function(){
    const display = document.getElementById('monthDisplay');
    const prev = document.getElementById('prevMonth');
    const next = document.getElementById('nextMonth');
    let current = new Date();

    const monthNames = [
        "Januari","Februari","Maret","April","Mei","Juni",
        "Juli","Agustus","September","Oktober","November","Desember"
    ];

    function updateDisplay() {
        const day = current.getDate();
        const month = current.getMonth();
        const year = current.getFullYear();

        display.textContent = `${day} ${monthNames[month]} ${year}`;
    }

    prev.addEventListener('click', () => {
        current.setMonth(current.getMonth() - 1);
        updateDisplay();
    });

    next.addEventListener('click', () => {
        current.setMonth(current.getMonth() + 1);
        updateDisplay();
    });

    updateDisplay();
});
</script>
@endsection
