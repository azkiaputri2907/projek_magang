@extends('layouts.app')

@section('title', 'Buku Tamu Disdik')

@section('content')
<style>
    body {
        background-color: #DFEDFE;
        font-family: 'Poppins', sans-serif;
        margin: 0;
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        overflow-x: hidden;
    }

    .logo-header {
        position: absolute;
        top: 25px;
        right: 45px;
        display: flex;
        align-items: center;
        gap: 10px;
        z-index: 100;
    }

    .logo-header img {
        height: 55px;
    }

    .container-bukutamu {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 95%;
        max-width: 1300px;
        position: relative;
    }

    .bukutamu-card {
        display: flex;
        background-color: #fff;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        height: 720px;
        width: 100%;
    }

    /* ======================== KIRI ======================== */
    .bukutamu-left {
        flex: 0.9;
        background-color: #C9E1FF;
        background-image: url('{{ asset('images/Pengunjung.jpg') }}');
        background-repeat: no-repeat;
        background-position: center;
        background-size: cover;
        display: flex;
        flex-direction: column;
        justify-content: flex-start; /* teks di atas */
        align-items: center;
        position: relative;
        padding: 80px 40px 40px; /* agak turun dikit biar seimbang */
    }

    /* Tambah gradasi gelap dari atas */
    .bukutamu-left::after {
        content: "";
        position: absolute;
        inset: 0;
        background: linear-gradient(to bottom, rgba(0,0,0,0.35) 10%, transparent 60%);
        z-index: 1;
    }

    /* Teks judul di atas gambar */
    .bukutamu-left h1 {
        position: relative;
        font-size: 2.4rem;
        font-weight: 800;
        color: #fff;
        text-align: center;
        z-index: 2;
        margin-top: 40px;
        margin-bottom: 30px;
        line-height: 1.3;
        /* Bayangan lebih halus & tebal dikit biar teks tetap kebaca di area terang */
        text-shadow: 0 3px 8px rgba(0, 0, 0, 0.55), 0 0 15px rgba(0, 0, 0, 0.3);
    }

    .bukutamu-left h1 span {
        color: #30E3BC;
        text-shadow: 0 3px 8px rgba(0, 0, 0, 0.55);
    }

    /* ======================== KANAN ======================== */
    .bukutamu-right {
        flex: 2.1;
        padding: 40px 50px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .right-content-wrapper {
        display: flex;
        gap: 40px;
        flex-grow: 1;
    }
    /* --- Layanan Section --- */
    .layanan-section {
        width: 120%; /* sebelumnya 100%, sekarang lebih lebar */
        transform: translateX(-5%); /* biar agak geser ke kiri dikit, nggak mentok ke kanan */
    }

    .layanan-card {
        background-color: #E7F1FF;
        border-radius: 16px;
        padding: 28px 50px 28px 35px; /* tambah ruang biar isi lebih lapang */
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        max-height: 620px;
        overflow-y: auto;
    }

    .layanan-card h3 {
        font-size: 1rem;
        font-weight: 600;
        color: #003366;
        margin-bottom: 14px;
    }

    .layanan-card ol {
        list-style: none;
        padding: 0;
        margin: 0;
        counter-reset: listnum;
        color: #222;
        font-size: 0.8rem;
        line-height: 1.45;
    }

    .layanan-card ol li {
        counter-increment: listnum;
        margin-bottom: 6px;
        position: relative;
        padding-left: 20px;
    }

    .layanan-card ol li::before {
        content: counter(listnum) ".";
        position: absolute;
        left: 0;
        color: #007BFF;
        font-weight: 600;
    }



    /* --- Tabel Section --- */
    .tabel-section {
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .date-box {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        border: 1px solid #ccc;
        border-radius: 8px;
        width: 220px;
        margin-left: auto;
        margin-bottom: 10px;
        padding: 4px 6px;
        background: #fafafa;
    }

    .date-box .nav-btn {
        border: none;
        background: none;
        font-size: 1.1rem;
        color: #007BFF;
        cursor: pointer;
        font-weight: bold;
        padding: 4px 8px;
    }

    .date-box span {
        font-weight: 600;
        color: #333;
        flex-grow: 1;
        text-align: center;
    }

    .guest-header {
        display: flex;
        font-weight: 700;
        color: #000;
        border-bottom: 2px solid #007BFF;
        padding-bottom: 8px;
        font-size: 0.9rem;
    }

    .guest-row {
        display: flex;
        border-bottom: 1px solid #bbb;
        padding: 8px 0;
        font-size: 0.85rem;
        color: #333;
        line-height: 1.3;
    }

    .guest-header span, .guest-row span {
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
        padding-right: 8px;
    }

    .col-tanggal { flex: 1; }
    .col-nama { flex: 1.8; }
    .col-instansi { flex: 1.3; }
    .col-layanan { flex: 1.5; }
    .col-keperluan { flex: 2.2; }

    .tabel-container {
        flex-grow: 1;
        overflow-y: auto;
        margin-top: 8px;
        padding-right: 6px;
    }

    /* --- Tombol Tambah --- */
    /* --- Tombol Tambah --- */
    .btn-tambah {
        position: absolute;
        bottom: 25px; /* jarak dari bawah card */
        right: 60px;  /* jarak dari kanan card */
        background-color: #30E3BC;
        color: #fff;
        font-weight: 600;
        padding: 10px 30px;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        font-size: 1rem;
        box-shadow: 0 4px 10px rgba(48, 227, 188, 0.4);
        transition: 0.2s ease-in-out;
        text-decoration: none;
        z-index: 5; /* biar gak ketimpa elemen lain */
    }

    .btn-tambah:hover {
        background-color: #30E3BC;
        transform: translateY(-2px);
    }

    /* Pastikan parent-nya punya posisi relatif */
    .bukutamu-right {
        position: relative;
    }

    @media (max-width: 992px) {
        .bukutamu-card {
            flex-direction: column;
            height: auto;
        }

        .bukutamu-left {
            height: 300px;
            background-position: center;
        }

        .right-content-wrapper {
            display: flex;
            gap: 0;
            flex-grow: 1;
        }

        .layanan-section {
            width: 90%;
        }

        .btn-tambah {
            align-self: center;
            margin-top: 10px;
        }
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
        const month = current.getMonth();
        const year = current.getFullYear();
        display.textContent = `${monthNames[month]} ${year}`;
    }

    prev.addEventListener('click', () => {
        current.setMonth(current.getMonth() - 1);
        updateDisplay();
    });
    next.addEventListener('click', () => {
        current.setMonth(current.getMonth() + 1);
        updateDisplay();
    });
});
</script>
@endsection
