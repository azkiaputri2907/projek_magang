@extends('layouts.app')

@section('title', 'Edit Data SKM | Disdik Kab.Banjar')

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
    padding-top: 0rem; 
    min-height: 100vh;
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
    filter: drop-shadow(0 4px 6px rgba(0,0,0,0.1));
}
.logo-header img { height: 50px; }

.btn-keluar {
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 10px;
    background: linear-gradient(135deg, #EF4444 0%, #b91c1c 100%);
    color: #fff;
    border: none;
    border-radius: 8px;
    font-weight: bold;
    cursor: pointer;
    box-shadow: 0 4px 0 #991b1b;
    transition: all 0.1s;
}
.btn-keluar:active { transform: translateY(4px); box-shadow: none; }

/* ================= DASHBOARD MAIN ================= */
.container-dashboard {
    display: flex;
    justify-content: center;
    align-items: flex-start;
    width: 95%;
    max-width: 1300px;
    margin: 0 auto;
    padding-top: 0; 
    margin-top: 5px; 
    padding-bottom: 20px;
}

.dashboard-card {
    display: flex;
    background-color: #fff;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 
        0 20px 50px rgba(0, 0, 0, 0.15),
        0 5px 15px rgba(0,0,0,0.05);
    border: 1px solid rgba(255,255,255,0.6);
    border-bottom: 6px solid #e1e8f0; /* Efek tebal 3D */
    min-height: 620px;
    width: 100%;
}

/* ================= LEFT PANEL (FORM AREA) ================= */
.dashboard-left {
    flex: 2.1; 
    padding: 40px 50px;
    display: flex;
    flex-direction: column;
    position: relative;
    background-color: #F8FBFF;
    z-index: 1;
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
    text-shadow: 0 2px 3px rgba(0,0,0,0.05);
}
.title-card span { color: #30E3BC; }

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

/* === FORM CONTAINER (Scrollable) === */
.form-container {
    flex-grow: 1;
    overflow-y: auto;
    padding-right: 10px;
}

/* EDIT CARD (INSET PANEL) */
.edit-card {
    background: #ffffff;
    border-radius: 15px;
    padding: 20px 25px;
    margin-bottom: 20px;
    border: 1px solid #e0e6ed;
    /* Efek Timbul Halus */
    box-shadow: 0 4px 6px rgba(0,0,0,0.02);
}

.edit-card label {
    font-weight: 700;
    margin-bottom: 8px;
    display: block;
    color: #003366;
    font-size: 0.9rem;
}

/* INPUT FIELDS (INSET EFFECT) */
.edit-card input,
.edit-card select,
.edit-card textarea {
    width: 100%;
    padding: 12px 16px;
    border: 1px solid #e0e6ed;
    border-radius: 10px;
    margin-bottom: 15px;
    outline: none;
    transition: all 0.2s;
    background-color: #f8fafc;
    font-size: 0.95rem;
    /* Bayangan dalam agar terlihat cekung */
    box-shadow: inset 0 2px 5px rgba(0,0,0,0.03); 
}

.edit-card input:focus,
.edit-card select:focus,
.edit-card textarea:focus {
    background-color: #fff;
    border-color: #30E3BC;
    box-shadow: 
        0 0 0 4px rgba(48, 227, 188, 0.15),
        0 4px 10px rgba(0,0,0,0.05);
    transform: translateY(-2px);
}

/* TOMBOL SIMPAN (3D PUSH) */
.btn-simpan-semua {
    background: linear-gradient(135deg, #2bd9a6 0%, #17a078 100%);
    border: none;
    padding: 14px 40px;
    color: #fff;
    font-size: 1rem;
    font-weight: 800;
    border-radius: 50px;
    cursor: pointer;
    display: block;
    width: 100%;
    margin: 10px 0 20px 0;
    transition: all 0.15s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    top: 0;
    /* KUNCI EFEK 3D */
    box-shadow: 
        0 6px 0 #138563, /* Sisi tebal tombol */
        0 12px 20px rgba(43, 217, 166, 0.3); /* Bayangan lantai */
}

.btn-simpan-semua:hover {
    transform: translateY(-2px);
    background: linear-gradient(135deg, #3dfcd1 0%, #21e0b3 100%);
    box-shadow: 
        0 8px 0 #138563, 
        0 15px 25px rgba(43, 217, 166, 0.4);
}

.btn-simpan-semua:active {
    top: 6px; 
    box-shadow: 
        0 0 0 #138563, 
        0 2px 5px rgba(43, 217, 166, 0.3);
}

/* ================= RIGHT PANEL (IMAGE) ================= */
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
    padding: 80px 40px 40px; 
    position: relative;
    
    /* Bayangan pemisah */
    box-shadow: inset 15px 0 20px -10px rgba(0,0,0,0.15);
    z-index: 2;
    
    /* Agar gambar tidak hilang saat panel kiri melebar */
    flex-shrink: 0;
    min-width: 300px;
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
    font-size: 2.2rem;
    font-weight: 800;
    margin-top: 40px;
    text-shadow: 0 4px 8px rgba(0,0,0,0.6);
    text-align: center;
}
.dashboard-right h1 span { color: #30E3BC; }


/* ================= RESPONSIVE MODE ==================== */
@media (max-width: 992px) {
    .dashboard-card { flex-direction: column; min-height: auto; }

    /* Mobile: Image on Top */
    .dashboard-right { 
        order: 1;
        height: 260px; 
        padding-top: 40px; 
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        border-bottom-right-radius: 0;
        border-radius: 20px 20px 0 0;
        width: 100%;
        min-width: unset;
    }
    .dashboard-right h1 { font-size: 1.8rem; margin-top: 10px; }
    
    .dashboard-left { order: 2; padding: 30px 20px; }
    .title-card { font-size: 1.8rem; }
    .container-dashboard { margin-top: 10px; }
    
    .logo-header { top: 10px; right: 10px; }
    .logo-header img { height: 40px; }
}
</style>

{{-- LOGO --}}
<div class="logo-header">
    <img src="{{ asset('images/LOGO_KEMENTRIAN.png') }}" alt="Logo Kementrian">
    <img src="{{ asset('images/LOGO_PEMKAB_BANJAR.png') }}" alt="Logo Kab. Banjar">
</div>

{{-- === PANGGIL SIDEBAR DARI COMPONENT === --}}
@include('components._sidebar')

{{-- LAYOUT UTAMA --}}
<div class="container-dashboard">
    <div class="dashboard-card">

        {{-- KIRI (FORM EDIT) --}}
        <div class="dashboard-left">
            <div class="title-card">
                <div class="menu-icon" id="menuToggle">
                    <span></span><span></span><span></span>
                </div>
                Edit Data <span>SKM</span>
            </div>

<div class="form-container">
                <form action="{{ route('admin.skm.update', $skm->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="edit-card">
                        <label>Usia</label>
                        <input type="number" name="usia" value="{{ old('usia', $skm->usia) }}" required>
                        @error('usia') <span class="text-danger">{{ $message }}</span> @enderror

                        <label>Jenis Kelamin</label>
                        <select name="jenis_kelamin" required>
                            <option value="Laki-laki" {{ old('jenis_kelamin', $skm->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('jenis_kelamin', $skm->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('jenis_kelamin') <span class="text-danger">{{ $message }}</span> @enderror

                        <label>Pendidikan Terakhir</label>
                        <select name="pendidikan_terakhir" required>
                            <option value="SD" {{ old('pendidikan_terakhir', $skm->pendidikan_terakhir) == 'SD' ? 'selected' : '' }}>SD</option>
                            <option value="SLTP" {{ old('pendidikan_terakhir', $skm->pendidikan_terakhir) == 'SLTP' ? 'selected' : '' }}>SLTP (SMP/MTs/Sederajat)</option>
                            <option value="SLTA" {{ old('pendidikan_terakhir', $skm->pendidikan_terakhir) == 'SLTA' ? 'selected' : '' }}>SLTA (SMA/SMK/MA/Sederajat)</option>
                            <option value="D1_D3" {{ old('pendidikan_terakhir', $skm->pendidikan_terakhir) == 'D1_D3' ? 'selected' : '' }}>Diploma 1-3</option>
                            <option value="S1_D4" {{ old('pendidikan_terakhir', $skm->pendidikan_terakhir) == 'S1_D4' ? 'selected' : '' }}>S1 / D4</option>
                            <option value="S2" {{ old('pendidikan_terakhir', $skm->pendidikan_terakhir) == 'S2' ? 'selected' : '' }}>S2</option>
                            <option value="S3" {{ old('pendidikan_terakhir', $skm->pendidikan_terakhir) == 'S3' ? 'selected' : '' }}>S3</option>
                        </select>
                        @error('pendidikan_terakhir') <span class="text-danger">{{ $message }}</span> @enderror

                        <label>Pekerjaan</label>
                        <select name="pekerjaan" required>
                            <option value="PNS/TNI/Polri" {{ old('pekerjaan', $skm->pekerjaan) == 'PNS/TNI/Polri' ? 'selected' : '' }}>PNS/TNI/Polri</option>
                            <option value="Swasta" {{ old('pekerjaan', $skm->pekerjaan) == 'Swasta' ? 'selected' : '' }}>Pegawai Swasta</option>
                            <option value="Wiraswasta" {{ old('pekerjaan', $skm->pekerjaan) == 'Wiraswasta' ? 'selected' : '' }}>Wiraswasta</option>
                            <option value="Pelajar/Mahasiswa" {{ old('pekerjaan', $skm->pekerjaan) == 'Pelajar/Mahasiswa' ? 'selected' : '' }}>Pelajar/Mahasiswa</option>
                            <option value="Lainnya" {{ old('pekerjaan', $skm->pekerjaan) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        @error('pekerjaan') <span class="text-danger">{{ $message }}</span> @enderror

                        <label>Jenis Layanan Diterima</label>
                        <select name="jenis_layanan_diterima" required>
                            <option value="Rekomendasi Mutasi" {{ old('jenis_layanan_diterima', $skm->jenis_layanan_diterima) == 'Rekomendasi Mutasi' ? 'selected' : '' }}>Rekomendasi Mutasi</option>
                            <option value="Rekomendasi Mutasi Siswa" {{ old('jenis_layanan_diterima', $skm->jenis_layanan_diterima) == 'Rekomendasi Mutasi Siswa' ? 'selected' : '' }}>Rekomendasi Mutasi Siswa</option>
                            <option value="Surat Keterangan Pengganti Ijazah" {{ old('jenis_layanan_diterima', $skm->jenis_layanan_diterima) == 'Surat Keterangan Pengganti Ijazah' ? 'selected' : '' }}>Surat Keterangan Pengganti Ijazah</option>
                            <option value="Legalisir Ijazah" {{ old('jenis_layanan_diterima', $skm->jenis_layanan_diterima) == 'Legalisir Ijazah' ? 'selected' : '' }}>Legalisir Ijazah</option>
                            <option value="Magang / Penelitian" {{ old('jenis_layanan_diterima', $skm->jenis_layanan_diterima) == 'Magang / Penelitian' ? 'selected' : '' }}>Magang / Penelitian</option>
                            <option value="NPSN" {{ old('jenis_layanan_diterima', $skm->jenis_layanan_diterima) == 'NPSN' ? 'selected' : '' }}>NPSN</option>
                            <option value="Rekomendasi Izin Pendirian Satuan Pendidikan" {{ old('jenis_layanan_diterima', $skm->jenis_layanan_diterima) == 'Rekomendasi Izin Pendirian Satuan Pendidikan' ? 'selected' : '' }}>Rekomendasi Izin Pendirian Satuan Pendidikan</option>
                            <option value="Rekomendasi Pendirian Satuan Pendidikan" {{ old('jenis_layanan_diterima', $skm->jenis_layanan_diterima) == 'Rekomendasi Pendirian Satuan Pendidikan' ? 'selected' : '' }}>Rekomendasi Pendirian Satuan Pendidikan</option>
                            <option value="Rekomendasi Operasional Satuan Pendidikan" {{ old('jenis_layanan_diterima', $skm->jenis_layanan_diterima) == 'Rekomendasi Operasional Satuan Pendidikan' ? 'selected' : '' }}>Rekomendasi Operasional Satuan Pendidikan</option>
                            <option value="Konsultasi Lainnya" {{ old('jenis_layanan_diterima', $skm->jenis_layanan_diterima) == 'Konsultasi Lainnya' ? 'selected' : '' }}>Konsultasi Lainnya</option>
                        </select>
                        @error('jenis_layanan_diterima') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    {{-- SURVEY SKM (Q1 - Q9) : NAMA DISESUAIKAN DENGAN FORMAT PANJANG --}}
                    
                    <div class="edit-card">
                        <label>Q1 - Persyaratan Pelayanan</label>
                        {{-- Menggunakan name q1_persyaratan --}}
                        <select name="q1_persyaratan" required>
                            <option value="4" {{ old('q1_persyaratan', $skm->q1_persyaratan ?? $skm->q1 ?? 0) == 4 ? 'selected' : '' }}>Sangat Sesuai</option>
                            <option value="3" {{ old('q1_persyaratan', $skm->q1_persyaratan ?? $skm->q1 ?? 0) == 3 ? 'selected' : '' }}>Sesuai</option>
                            <option value="2" {{ old('q1_persyaratan', $skm->q1_persyaratan ?? $skm->q1 ?? 0) == 2 ? 'selected' : '' }}>Kurang Sesuai</option>
                            <option value="1" {{ old('q1_persyaratan', $skm->q1_persyaratan ?? $skm->q1 ?? 0) == 1 ? 'selected' : '' }}>Tidak Sesuai</option>
                        </select>
                        @error('q1_persyaratan') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="edit-card">
                        <label>Q2 - Kemudahan Prosedur</label>
                        {{-- Menggunakan name q2_prosedur --}}
                        <select name="q2_prosedur" required>
                            <option value="4" {{ old('q2_prosedur', $skm->q2_prosedur ?? $skm->q2 ?? 0) == 4 ? 'selected' : '' }}>Sangat Mudah</option>
                            <option value="3" {{ old('q2_prosedur', $skm->q2_prosedur ?? $skm->q2 ?? 0) == 3 ? 'selected' : '' }}>Mudah</option>
                            <option value="2" {{ old('q2_prosedur', $skm->q2_prosedur ?? $skm->q2 ?? 0) == 2 ? 'selected' : '' }}>Cukup Sulit</option>
                            <option value="1" {{ old('q2_prosedur', $skm->q2_prosedur ?? $skm->q2 ?? 0) == 1 ? 'selected' : '' }}>Sangat Sulit</option>
                        </select>
                        @error('q2_prosedur') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="edit-card">
                        <label>Q3 - Kecepatan Waktu</label>
                        {{-- Menggunakan name q3_waktu --}}
                        <select name="q3_waktu" required>
                            <option value="4" {{ old('q3_waktu', $skm->q3_waktu ?? $skm->q3 ?? 0) == 4 ? 'selected' : '' }}>Sangat Sesuai</option>
                            <option value="3" {{ old('q3_waktu', $skm->q3_waktu ?? $skm->q3 ?? 0) == 3 ? 'selected' : '' }}>Sesuai</option>
                            <option value="2" {{ old('q3_waktu', $skm->q3_waktu ?? $skm->q3 ?? 0) == 2 ? 'selected' : '' }}>Kurang Sesuai</option>
                            <option value="1" {{ old('q3_waktu', $skm->q3_waktu ?? $skm->q3 ?? 0) == 1 ? 'selected' : '' }}>Tidak Sesuai</option>
                        </select>
                        @error('q3_waktu') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="edit-card">
                        <label>Q4 - Kewajaran Biaya</label>
                        {{-- Menggunakan name q4_biaya --}}
                        <select name="q4_biaya" required>
                            <option value="4" {{ old('q4_biaya', $skm->q4_biaya ?? $skm->q4 ?? 0) == 4 ? 'selected' : '' }}>Sangat Sesuai</option>
                            <option value="3" {{ old('q4_biaya', $skm->q4_biaya ?? $skm->q4 ?? 0) == 3 ? 'selected' : '' }}>Sesuai</option>
                            <option value="2" {{ old('q4_biaya', $skm->q4_biaya ?? $skm->q4 ?? 0) == 2 ? 'selected' : '' }}>Kurang Sesuai</option>
                            <option value="1" {{ old('q4_biaya', $skm->q4_biaya ?? $skm->q4 ?? 0) == 1 ? 'selected' : '' }}>Tidak Sesuai</option>
                        </select>
                        @error('q4_biaya') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="edit-card">
                        <label>Q5 - Kesesuaian Produk</label>
                        {{-- Menggunakan name q5_produk --}}
                        <select name="q5_produk" required>
                            <option value="4" {{ old('q5_produk', $skm->q5_produk ?? $skm->q5 ?? 0) == 4 ? 'selected' : '' }}>Sangat Sesuai</option>
                            <option value="3" {{ old('q5_produk', $skm->q5_produk ?? $skm->q5 ?? 0) == 3 ? 'selected' : '' }}>Sesuai</option>
                            <option value="2" {{ old('q5_produk', $skm->q5_produk ?? $skm->q5 ?? 0) == 2 ? 'selected' : '' }}>Kurang Sesuai</option>
                            <option value="1" {{ old('q5_produk', $skm->q5_produk ?? $skm->q5 ?? 0) == 1 ? 'selected' : '' }}>Tidak Sesuai</option>
                        </select>
                        @error('q5_produk') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="edit-card">
                        <label>Q6 - Kompetensi Petugas</label>
                        {{-- Menggunakan name q6_kompetensi_petugas --}}
                        <select name="q6_kompetensi_petugas" required>
                            <option value="4" {{ old('q6_kompetensi_petugas', $skm->q6_kompetensi_petugas ?? $skm->q6 ?? 0) == 4 ? 'selected' : '' }}>Sangat Baik</option>
                            <option value="3" {{ old('q6_kompetensi_petugas', $skm->q6_kompetensi_petugas ?? $skm->q6 ?? 0) == 3 ? 'selected' : '' }}>Baik</option>
                            <option value="2" {{ old('q6_kompetensi_petugas', $skm->q6_kompetensi_petugas ?? $skm->q6 ?? 0) == 2 ? 'selected' : '' }}>Kurang Baik</option>
                            <option value="1" {{ old('q6_kompetensi_petugas', $skm->q6_kompetensi_petugas ?? $skm->q6 ?? 0) == 1 ? 'selected' : '' }}>Tidak Baik</option>
                        </select>
                        @error('q6_kompetensi_petugas') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="edit-card">
                        <label>Q7 - Perilaku Petugas</label>
                        {{-- Menggunakan name q7_perilaku_petugas --}}
                        <select name="q7_perilaku_petugas" required>
                            <option value="4" {{ old('q7_perilaku_petugas', $skm->q7_perilaku_petugas ?? $skm->q7 ?? 0) == 4 ? 'selected' : '' }}>Sangat Baik</option>
                            <option value="3" {{ old('q7_perilaku_petugas', $skm->q7_perilaku_petugas ?? $skm->q7 ?? 0) == 3 ? 'selected' : '' }}>Baik</option>
                            <option value="2" {{ old('q7_perilaku_petugas', $skm->q7_perilaku_petugas ?? $skm->q7 ?? 0) == 2 ? 'selected' : '' }}>Kurang Baik</option>
                            <option value="1" {{ old('q7_perilaku_petugas', $skm->q7_perilaku_petugas ?? $skm->q7 ?? 0) == 1 ? 'selected' : '' }}>Tidak Baik</option>
                        </select>
                        @error('q7_perilaku_petugas') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="edit-card">
                        <label>Q8 - Penanganan Pengaduan</label>
                        {{-- Menggunakan name q8_penanganan_pengaduan --}}
                        <select name="q8_penanganan_pengaduan" required>
                            <option value="4" {{ old('q8_penanganan_pengaduan', $skm->q8_penanganan_pengaduan ?? $skm->q8 ?? 0) == 4 ? 'selected' : '' }}>Sangat Baik</option>
                            <option value="3" {{ old('q8_penanganan_pengaduan', $skm->q8_penanganan_pengaduan ?? $skm->q8 ?? 0) == 3 ? 'selected' : '' }}>Baik</option>
                            <option value="2" {{ old('q8_penanganan_pengaduan', $skm->q8_penanganan_pengaduan ?? $skm->q8 ?? 0) == 2 ? 'selected' : '' }}>Kurang Baik</option>
                            <option value="1" {{ old('q8_penanganan_pengaduan', $skm->q8_penanganan_pengaduan ?? $skm->q8 ?? 0) == 1 ? 'selected' : '' }}>Tidak Ada</option>
                        </select>
                        @error('q8_penanganan_pengaduan') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="edit-card">
                        <label>Q9 - Kualitas Sarana</label>
                        {{-- Menggunakan name q9_sarana --}}
                        <select name="q9_sarana" required>
                            <option value="4" {{ old('q9_sarana', $skm->q9_sarana ?? $skm->q9 ?? 0) == 4 ? 'selected' : '' }}>Sangat Baik</option>
                            <option value="3" {{ old('q9_sarana', $skm->q9_sarana ?? $skm->q9 ?? 0) == 3 ? 'selected' : '' }}>Baik</option>
                            <option value="2" {{ old('q9_sarana', $skm->q9_sarana ?? $skm->q9 ?? 0) == 2 ? 'selected' : '' }}>Kurang Baik</option>
                            <option value="1" {{ old('q9_sarana', $skm->q9_sarana ?? $skm->q9 ?? 0) == 1 ? 'selected' : '' }}>Tidak Baik</option>
                        </select>
                        @error('q9_sarana') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="edit-card">
                        <label>Saran Masukan</label>
                        <textarea name="saran_masukan" rows="4">{{ old('saran_masukan', $skm->saran_masukan ?? '') }}</textarea>
                        @error('saran_masukan') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" class="btn-simpan-semua">Simpan Perubahan</button>
                </form>
            </div>
        </div>

        {{-- KANAN (GAMBAR) --}}
        <div class="dashboard-right">
            <h1>Data <span>SKM</span></h1>
        </div>
    </div>
</div>

@include('components._footer')

@endsection