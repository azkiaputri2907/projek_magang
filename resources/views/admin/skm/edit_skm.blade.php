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
                        <input type="number" name="usia" value="{{ $skm->usia }}" required>

                        <label>Jenis Kelamin</label>
                        <select name="jenis_kelamin" required>
                            <option value="Laki-laki" {{ $skm->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ $skm->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>

                        <label>Pendidikan Terakhir</label>
                        <input type="text" name="pendidikan_terakhir" value="{{ $skm->pendidikan_terakhir }}">

                        <label>Pekerjaan</label>
                        <input type="text" name="pekerjaan" value="{{ $skm->pekerjaan }}" required>

                        <label>Jenis Layanan Diterima</label>
                        <input type="text" name="jenis_layanan_diterima" value="{{ $skm->jenis_layanan_diterima }}" required>
                    </div>

                    {{-- Q1 - Q9 (Input Nilai) --}}
                    @for ($i = 1; $i <= 9; $i++)
                    <div class="edit-card">
                        <label>Q{{ $i }} (Nilai 1-4)</label>
                        <input type="number"
                            name="q{{ $i }}_{{ [
                                1=>'persyaratan',
                                2=>'prosedur',
                                3=>'waktu',
                                4=>'biaya',
                                5=>'produk',
                                6=>'kompetensi_petugas',
                                7=>'perilaku_petugas',
                                8=>'penanganan_pengaduan',
                                9=>'sarana'
                            ][$i] }}"
                            value="{{ $skm->{'q'.$i.'_'.[
                                1=>'persyaratan',
                                2=>'prosedur',
                                3=>'waktu',
                                4=>'biaya',
                                5=>'produk',
                                6=>'kompetensi_petugas',
                                7=>'perilaku_petugas',
                                8=>'penanganan_pengaduan',
                                9=>'sarana'
                            ][$i]} }}"
                            min="1" max="4"
                            required>
                    </div>
                    @endfor

                    <div class="edit-card">
                        <label>Saran Masukan</label>
                        <textarea name="saran_masukan" rows="4">{{ $skm->saran_masukan }}</textarea>
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