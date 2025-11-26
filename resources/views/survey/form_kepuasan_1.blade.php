@extends('layouts.app')

@section('title', 'Survey Kepuasan (1/3)')

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
    align-items: center;
    overflow-x: hidden;
    padding: 20px 0;
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

/* ======================== WRAPPER (EFEK 3D CARD) ======================== */
.bukutamu-wrapper {
    display: flex;
    justify-content: center;
    align-items: stretch;
    background: #fff;
    border-radius: 20px;
    
    /* EFEK TIMBUL: Shadow Berlapis & Border Halus */
    box-shadow: 
        0 20px 50px rgba(0, 0, 0, 0.15),
        0 5px 15px rgba(0,0,0,0.05);
    border: 1px solid rgba(255,255,255,0.6);

    width: 95%;
    max-width: 1300px;
    min-height: 720px;
    overflow: hidden;
    position: relative;
}

/* ======================== LEFT PANEL (FORM) ======================== */
.bukutamu-left {
    flex: 2.1;
    padding: 50px 80px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    position: relative;
    z-index: 2;
}

.bukutamu-left h1 {
    font-size: 2.4rem;
    font-weight: 800;
    color: #003366;
    margin-bottom: 25px;
    line-height: 1.3;
    text-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.bukutamu-left h1 span { color: #30E3BC; }

.form-group { margin-bottom: 18px; }

.form-group label {
    display: block;
    font-weight: 600;
    margin-bottom: 8px;
    color: #444;
    font-size: 0.95rem;
}

/* EFEK TIMBUL: INPUT FIELD (INSET/CEKUNG) */
.form-group input,
.form-group select {
    width: 100%;
    padding: 14px 16px;
    border: 1px solid #e0e6ed;
    border-radius: 12px;
    font-size: 1rem;
    background-color: #f8fafc;
    transition: all 0.2s;
    /* Bayangan dalam (Inset) agar terlihat masuk ke dalam kertas */
    box-shadow: inset 0 2px 5px rgba(0,0,0,0.03); 
}

/* Hilangkan panah spinner number */
.form-group input[type=number]::-webkit-outer-spin-button,
.form-group input[type=number]::-webkit-inner-spin-button {
  -webkit-appearance: none; margin: 0;
}
.form-group input[type=number] { -moz-appearance: textfield; }

.form-group input:focus,
.form-group select:focus {
    background-color: #fff;
    border-color: #30E3BC;
    /* Efek Glow saat diklik */
    box-shadow: 
        0 0 0 4px rgba(48, 227, 188, 0.15),
        0 4px 10px rgba(0,0,0,0.05);
    outline: none;
    transform: translateY(-2px);
}

/* EFEK TIMBUL: TOMBOL SUBMIT (PUSH BUTTON) */
.btn-submit {
    background: linear-gradient(135deg, #30E3BC 0%, #1bcfa5 100%);
    color: white;
    font-weight: 800;
    font-size: 1.1rem;
    padding: 14px 45px;
    border: none;
    border-radius: 50px;
    cursor: pointer;
    margin-top: 25px;
    align-self: flex-start;
    letter-spacing: 0.5px;

    /* KUNCI EFEK 3D */
    box-shadow: 
        0 6px 0 #16a080, /* Sisi tebal tombol */
        0 12px 20px rgba(48, 227, 188, 0.3); /* Bayangan lantai */
    
    transition: all 0.15s cubic-bezier(0.4, 0, 0.2, 1);
    transform: translateY(0);
}

.btn-submit:hover {
    transform: translateY(-2px);
    background: linear-gradient(135deg, #3dfcd1 0%, #21e0b3 100%);
    box-shadow: 0 8px 0 #16a080, 0 15px 25px rgba(48, 227, 188, 0.4);
}

.btn-submit:active {
    transform: translateY(6px); /* Turun ke bawah */
    box-shadow: 0 0 0 #16a080, 0 2px 5px rgba(48, 227, 188, 0.4);
}

/* ======================== RIGHT PANEL (PHOTO) ======================== */
.bukutamu-right {
    flex: 0.9;
    background-color: #C9E1FF;
    background-image: url('{{ asset('images/survey.png') }}');
    background-repeat: no-repeat;
    background-position: center;
    background-size: cover;
    position: relative;
    display: flex;
    justify-content: center;
    align-items: flex-start;
    padding: 80px 40px 40px;

    /* Bayangan dalam di sisi kiri */
    box-shadow: inset 15px 0 20px -10px rgba(0,0,0,0.15);
}

.bukutamu-right::after {
    content: "";
    position: absolute;
    inset: 0;
    background: linear-gradient(to bottom, rgba(0,0,0,0.3) 15%, transparent 60%);
    z-index: 1;
}

.bukutamu-right h1 {
    position: relative;
    font-size: 2rem;
    font-weight: 800;
    color: #fff;
    text-align: center;
    z-index: 2;
    margin-top: 60px;
    line-height: 1.3;
    text-shadow: 0 4px 10px rgba(0,0,0,0.6);
}

.bukutamu-right h1 span {
    color: #30E3BC;
    text-shadow: 0 4px 10px rgba(0,0,0,0.6);
}

/* ======================== RESPONSIVE ======================== */
@media (max-width: 992px) {
    .bukutamu-wrapper {
        flex-direction: column;
        height: auto;
        width: 95%;
    }

    .bukutamu-left {
        order: 2;
        padding: 40px 30px;
    }

    .bukutamu-right {
        order: 1;
        height: 280px;
        /* Bayangan pindah ke bawah */
        box-shadow: inset 0 -15px 20px -10px rgba(0,0,0,0.15); 
    }

    .bukutamu-left h1 { font-size: 1.9rem; }
    .logo-header { top: 10px; right: 10px; }
    .logo-header img { height: 40px; }
}

@media (max-width: 600px) {
    .bukutamu-left { padding: 30px 20px; }
    .bukutamu-left h1 { font-size: 1.6rem; margin-bottom: 20px; }
    .form-group label { font-size: 0.9rem; }
    .form-group input, .form-group select { padding: 8px; font-size: 0.9rem; }
    
    .btn-submit { 
        width: 100%; 
        padding: 14px 0;
        text-align: center; 
    }
    
    .bukutamu-right { height: 220px; padding: 40px 20px; }
    .bukutamu-right h1 { font-size: 1.5rem; }
}

@media (max-width: 390px) {
    .bukutamu-left { padding: 20px 15px; }
    .bukutamu-left h1 { font-size: 1.4rem; }
    .form-group input, .form-group select { padding: 10px; font-size: 0.85rem; }
    .bukutamu-right { height: 180px; }
    .bukutamu-right h1 { font-size: 1.3rem; }
}
</style>

<div class="logo-header">
    <img src="{{ asset('images/LOGO_KEMENTRIAN.png') }}" alt="Logo Kementrian">
    <img src="{{ asset('images/LOGO_PEMKAB_BANJAR.png') }}" alt="Logo Kab. Banjar">
</div>

<div class="bukutamu-wrapper">
    <div class="bukutamu-left">

        <h1>Survey Kepuasan <span>Masyarakat</span></h1>

        <form action="{{ route('survey.layanan') }}" method="GET">

            @if(session('current_pengunjung_id'))
                <input type="hidden" name="pengunjung_id" value="{{ session('current_pengunjung_id') }}">
            @endif

            <div class="form-group">
                <label for="usia">Usia (Tahun)</label>
                <input 
                    type="number" 
                    id="usia" 
                    name="usia" 
                    required 
                    min="1" 
                    max="150"
                    inputmode="numeric"
                    placeholder="Contoh: 25"
                    oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                >
            </div>

            <div class="form-group">
                <label for="jenis_kelamin">Jenis Kelamin</label>
                <select id="jenis_kelamin" name="jenis_kelamin" required>
                    <option value="" disabled selected>Pilih...</option>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            </div>

            <div class="form-group">
                <label for="pendidikan">Pendidikan Terakhir</label>
                <select id="pendidikan" name="pendidikan_terakhir" required>
                    <option value="" disabled selected>Pilih...</option>
                    <option value="SD">SD</option>
                    <option value="SLTP">SLTP (SMP/MTs/Sederajat)</option>
                    <option value="SLTA">SLTA (SMA/SMK/MA/Sederajat)</option>
                    <option value="D1_D3">Diploma 1-3</option>
                    <option value="S1_D4">S1 / D4</option>
                    <option value="S2">S2</option>
                    <option value="S3">S3</option>
                </select>
            </div>

            <div class="form-group">
                <label for="pekerjaan">Pekerjaan</label>
                <select id="pekerjaan" name="pekerjaan" required>
                    <option value="" disabled selected>Pilih...</option>
                    <option value="PNS/TNI/Polri">PNS/TNI/Polri</option>
                    <option value="Swasta">Pegawai Swasta</option>
                    <option value="Wiraswasta">Wiraswasta</option>
                    <option value="Pelajar/Mahasiswa">Pelajar/Mahasiswa</option>
                    <option value="Lainnya">Lainnya</option>
                </select>
            </div>

            <div class="form-group">
                <label for="jenis_layanan">Jenis Layanan yang Diterima</label>
                <select id="jenis_layanan" name="jenis_layanan_diterima" required>
                    <option value="" disabled selected>Pilih...</option>
                    <option value="Rekomendasi Mutasi">Rekomendasi Mutasi</option>
                    <option value="Rekomendasi Mutasi Siswa">Rekomendasi Mutasi Siswa</option>
                    <option value="Surat Keterangan Pengganti Ijazah">Surat Keterangan Pengganti Ijazah</option>
                    <option value="Legalisir Ijazah">Legalisir Ijazah</option>
                    <option value="Magang / Penelitian">Magang / Penelitian</option>
                    <option value="NPSN">NPSN</option>
                    <option value="Rekomendasi Izin Pendirian Satuan Pendidikan">Rekomendasi Izin Pendirian Satuan Pendidikan</option>
                    <option value="Rekomendasi Pendirian Satuan Pendidikan">Rekomendasi Pendirian Satuan Pendidikan</option>
                    <option value="Rekomendasi Operasional Satuan Pendidikan">Rekomendasi Operasional Satuan Pendidikan</option>
                    <option value="Konsultasi Lainnya">Konsultasi Lainnya</option>
                </select>
            </div>

            <button type="submit" class="btn-submit">Berikutnya</button>
        </form>

    </div>

    <div class="bukutamu-right">
        <h1>1/3 <span>Survey</span></h1>
    </div>
</div>
@endsection