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

.logo-header img {
    height: 50px;
}

/* WRAPPER */
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
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    height: 720px;
    width: 100%;
}

/* ================= LEFT ================= */
.bukutamu-left {
    flex: 0.9;
    background-image: url('{{ asset("images/Pengunjung.jpg") }}');
    background-size: cover;
    background-position: center;
    display: flex;
    justify-content: flex-start;
    align-items: center;
    flex-direction: column;
    position: relative;
    padding: 80px 40px 40px;
}

.bukutamu-left::after {
    content: "";
    position: absolute;
    inset: 0;
    background: linear-gradient(to bottom, rgba(0,0,0,0.35) 10%, transparent 60%);
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
    text-shadow: 0 3px 8px rgba(0,0,0,0.55);
}

.bukutamu-left h1 span {
    color: #30E3BC;
}

/* ================= RIGHT ================= */
.bukutamu-right {
    flex: 2.1;
    padding: 40px 50px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    position: relative;
}

.right-content-wrapper {
    display: flex;
    gap: 40px;
    flex-grow: 1;
}

/* Layanan */
.layanan-section {
    width: 120%;
    transform: translateX(-5%);
}

.layanan-card {
    background-color: #E7F1FF;
    border-radius: 16px;
    padding: 28px 50px 28px 35px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
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
    padding-left: 20px;
    margin: 0;
    font-size: 0.8rem;
}

.layanan-card ol li {
    margin-bottom: 6px;
}


/* TABLE */
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
}

.guest-header,
.guest-row {
    display: flex;
}

.guest-header {
    font-weight: 700;
    border-bottom: 2px solid #007BFF;
    font-size: .9rem;
    padding-bottom: 8px;
}

.guest-row {
    border-bottom: 1px solid #bbb;
    padding: 8px 0;
    font-size: .85rem;
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

/* BUTTON */
.btn-tambah {
    position: absolute;
    bottom: 20px;
    right: 40px;
    background-color: #30E3BC;
    color: #fff;
    padding: 10px 30px;
    border-radius: 10px;
    font-weight: 600;
    text-decoration: none;
    box-shadow: 0 4px 10px rgba(48,227,188,.4);
    transition: .2s;
}
.btn-tambah:hover {
    transform: translateY(-2px);
}

/* ===================================================== */
/* ================= RESPONSIVE MODE ==================== */
/* ===================================================== */

@media (max-width: 992px) {
    .bukutamu-card {
        flex-direction: column;
        height: auto;
    }

    .bukutamu-left {
        height: 260px;
        padding: 40px 20px;
    }

    .bukutamu-left h1 {
        font-size: 1.8rem;
    }

    .right-content-wrapper {
        flex-direction: column;
        gap: 25px;
    }

    .layanan-section {
        width: 100%;
        transform: none;
    }

    .layanan-card {
        max-height: none;
        padding: 20px;
    }

    .tabel-section {
        width: 100%;
    }

    .btn-tambah {
        position: relative;
        bottom: unset;
        right: unset;
        margin-top: 20px;
        align-self: center;
    }

    .logo-header {
        top: 10px;
        right: 10px;
    }

    .logo-header img {
        height: 40px;
    }
}

@media (max-width: 600px) {
    .bukutamu-left h1 {
        font-size: 1.5rem;
    }

    .date-box {
        width: 100%;
        justify-content: center;
        gap: 10px;
    }

    .guest-header span,
    .guest-row span {
        font-size: .75rem;
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
