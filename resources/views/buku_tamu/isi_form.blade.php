@extends('layouts.app')

@section('title', 'Isi Buku Tamu')

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

    /* LOGO (Efek Bayangan Halus) */
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

    /* ======================== WRAPPER (MAIN CARD TIMBUL) ======================== */
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
        z-index: 2; /* Agar di atas bayangan panel kanan */
    }

    .bukutamu-left h1 {
        font-size: 2.2rem;
        font-weight: 800;
        color: #003366;
        margin-bottom: 25px;
        line-height: 1.3;
        text-shadow: 0 2px 4px rgba(0,0,0,0.1); /* Teks sedikit timbul */
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

    .form-group input:focus,
    .form-group select:focus {
        background-color: #fff;
        border-color: #30E3BC;
        /* Efek Glow saat diklik */
        box-shadow: 
            0 0 0 4px rgba(48, 227, 188, 0.15),
            0 4px 10px rgba(0,0,0,0.05);
        outline: none;
        transform: translateY(-2px); /* Naik sedikit saat fokus */
    }

    /* EFEK TIMBUL: TOMBOL SUBMIT (PUSH BUTTON) */
    .btn-submit {
        background: linear-gradient(135deg, #30E3BC 0%, #1bcfa5 100%);
        color: white;
        font-weight: 800;
        font-size: 1.1rem;
        padding: 14px 45px;
        border: none;
        border-radius: 50px; /* Lebih bulat */
        cursor: pointer;
        margin-top: 25px;
        align-self: flex-start;
        letter-spacing: 0.5px;
        width: auto;

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
        background-image: url('{{ asset('images/Pengunjung.jpg') }}');
        background-repeat: no-repeat;
        background-position: center;
        background-size: cover;
        position: relative;
        display: flex;
        justify-content: center;
        align-items: flex-start;
        padding: 80px 40px 40px;

        /* Bayangan dalam di sisi kiri agar terlihat ada kedalaman dengan panel kiri */
        box-shadow: inset 15px 0 20px -10px rgba(0,0,0,0.15);
    }

    .bukutamu-right::after {
        content: "";
        position: absolute;
        inset: 0;
        background: linear-gradient(to bottom, rgba(0,0,0,0.4) 15%, transparent 60%);
        z-index: 1;
    }

    .bukutamu-right h1 {
        position: relative;
        font-size: 2.2rem;
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
            box-shadow: inset 0 -15px 20px -10px rgba(0,0,0,0.15); /* Bayangan pindah ke bawah */
        }

        .logo-header { top: 10px; right: 10px; }
        .logo-header img { height: 40px; }
    }

    @media (max-width: 600px) {
        .bukutamu-left { padding: 30px 20px; }
        .bukutamu-left h1 { font-size: 1.6rem; margin-bottom: 20px; }
        .form-group label { font-size: 0.9rem; }
        .form-group input, .form-group select { padding: 6px; font-size: 0.9rem; }
        
        .btn-submit { 
            width: 100%; 
            text-align: center; 
        }
        
        .bukutamu-right { height: 200px; padding: 40px 20px; }
        .bukutamu-right h1 { font-size: 1.5rem; margin-top: 20px; }
    }
</style>

<div class="logo-header">
    <img src="{{ asset('images/LOGO_KEMENTRIAN.png') }}" alt="Logo Kementrian">
    <img src="{{ asset('images/LOGO_PEMKAB_BANJAR.png') }}" alt="Logo Kab. Banjar">
</div>

<div class="bukutamu-wrapper">
    {{-- ================= FORM DI KIRI ================= --}}
    <div class="bukutamu-left">

        <form action="{{ route('buku-tamu.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="tanggal">Tanggal</label>
                <input type="date" id="tanggal" name="tanggal" required value="{{ now()->toDateString() }}">
            </div>

            <div class="form-group">
                <label for="nama_nip">Nama / NIP</label>
                <input type="text" id="nama_nip" name="nama_nip" required placeholder="Masukkan Nama atau NIP">
            </div>

            <div class="form-group">
                <label for="instansi">Instansi</label>
                <input type="text" id="instansi" name="instansi" required placeholder="Contoh: SMPN 1 Banjar">
            </div>

            <div class="form-group">
                <label for="layanan">Layanan</label>
                <select id="layanan" name="layanan" required>
                    <option value="" disabled selected>Pilih Layanan</option>
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

            <div class="form-group">
                <label for="keperluan">Keperluan</label>
                <input type="text" id="keperluan" name="keperluan" required placeholder="Jelaskan secara singkat keperluan Anda">
            </div>

            <div class="form-group">
                <label for="no_hp">No. HP</label>
                <input type="tel" id="no_hp" name="no_hp" required placeholder="Contoh: 0812XXXXXXXX">
            </div>

            <button type="submit" class="btn-submit">Simpan</button>
        </form>
    </div>

    {{-- ================= FOTO DI KANAN ================= --}}
    <div class="bukutamu-right">
        <h1>Buku Tamu <span>Layanan</span></h1>
    </div>
</div>
@endsection
