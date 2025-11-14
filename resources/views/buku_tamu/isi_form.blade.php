@extends('layouts.app')

@section('title', 'Isi Buku Tamu')

@section('content')
<style>
    /* ======================== GLOBAL ======================== */
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

    /* ======================== LOGO HEADER ======================== */
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

    /* ======================== WRAPPER ======================== */
    .bukutamu-wrapper {
        display: flex;
        justify-content: center;
        align-items: stretch;
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        width: 95%;
        max-width: 1300px;
        min-height: 720px;
        overflow: hidden;
        position: relative;
    }

    /* ======================== LEFT PANEL (FORM) ======================== */
    .bukutamu-left {
        flex: 2.1;
        padding: 60px 80px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        position: relative;
    }

    .bukutamu-left h1 {
        font-size: 2.4rem;
        font-weight: 800;
        color: #003366;
        margin-bottom: 25px;
        line-height: 1.3;
    }

    .bukutamu-left h1 span {
        color: #30E3BC;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        font-weight: 600;
        margin-bottom: 6px;
        color: #333;
        font-size: 1rem;
    }

    .form-group input,
    .form-group select {
        width: 100%;
        padding: 13px 14px;
        border: 1px solid #ddd;
        border-radius: 10px;
        font-size: 1rem;
        transition: 0.2s;
    }

    .form-group input:focus,
    .form-group select:focus {
        border-color: #30E3BC;
        box-shadow: 0 0 0 3px rgba(48, 227, 188, 0.2);
        outline: none;
    }

    .btn-submit {
        background-color: #30E3BC;
        color: white;
        font-weight: 700;
        font-size: 1.1rem;
        padding: 13px 40px;
        border: none;
        border-radius: 12px;
        cursor: pointer;
        margin-top: 25px;
        box-shadow: 0 5px 15px rgba(48, 227, 188, 0.3);
        transition: 0.25s ease;
        align-self: flex-start;
    }

    .btn-submit:hover {
        background-color: #27C4A1;
        transform: translateY(-2px);
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
        font-size: 2.4rem;
        font-weight: 800;
        color: #fff;
        text-align: center;
        z-index: 2;
        margin-top: 60px;
        line-height: 1.3;
        text-shadow: 0 3px 8px rgba(0, 0, 0, 0.55), 0 0 15px rgba(0, 0, 0, 0.3);
    }

    .bukutamu-right h1 span {
        color: #30E3BC;
        text-shadow: 0 3px 8px rgba(0, 0, 0, 0.55);
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
            padding: 30px 25px;
        }

        .bukutamu-right {
            order: 1;
            height: 300px;
            background-position: center;
        }

        .bukutamu-left h1 {
            font-size: 2rem;
        }
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
