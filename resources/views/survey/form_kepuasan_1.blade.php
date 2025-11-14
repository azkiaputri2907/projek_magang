@extends('layouts.app')

@section('title', 'Survey Kepuasan (1/3)')

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
    .survey-wrapper {
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
    .survey-left {
        flex: 2.1;
        padding: 60px 80px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        position: relative;
    }

    .survey-left h1 {
        font-size: 2.4rem;
        font-weight: 800;
        color: #003366;
        margin-bottom: 25px;
        line-height: 1.3;
    }

    .survey-left h1 span {
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

    .btn-next {
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

    .btn-next:hover {
        background-color: #27C4A1;
        transform: translateY(-2px);
    }

    /* ======================== RIGHT PANEL (PHOTO) ======================== */
    .survey-right {
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
    }

    .survey-right::after {
        content: "";
        position: absolute;
        inset: 0;
        background: linear-gradient(to bottom, rgba(0,0,0,0.3) 15%, transparent 60%);
        z-index: 1;
    }

    .survey-right h1 {
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

    .survey-right h1 span {
        color: #30E3BC;
        text-shadow: 0 3px 8px rgba(0, 0, 0, 0.55);
    }

    /* ======================== RESPONSIVE ======================== */
    @media (max-width: 992px) {
        .survey-wrapper {
            flex-direction: column;
            height: auto;
            width: 95%;
        }

        .survey-left {
            order: 2;
            padding: 30px 25px;
        }

        .survey-right {
            order: 1;
            height: 300px;
            background-position: center;
        }

        .survey-left h1 {
            font-size: 2rem;
        }
    }
</style>

<div class="logo-header">
    <img src="{{ asset('images/LOGO_KEMENTRIAN.png') }}" alt="Logo Kementrian">
    <img src="{{ asset('images/LOGO_PEMKAB_BANJAR.png') }}" alt="Logo Kab. Banjar">
</div>

<div class="survey-wrapper">
    {{-- ================= FORM DI KIRI ================= --}}
    <div class="survey-left">
        <h1>Survey Kepuasan <span>Masyarakat</span></h1>

        <form action="{{ route('survey.layanan') }}" method="GET">
            @if(session('current_pengunjung_id'))
                <input type="hidden" name="pengunjung_id" value="{{ session('current_pengunjung_id') }}">
            @endif

            <div class="form-group">
                <label for="usia">Usia (Tahun)</label>
                <input type="text" id="usia" name="usia" required>
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
                    <option value="S1_D4">S1 (Sarjana) / Diploma 4</option>
                    <option value="S2">S2 (Pascasarjana)</option>
                    <option value="S3">S3 (Doktoral)</option>
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
                    <option value="Rekomendasi Operasional Satuan Pendidikan">Rekomendasi Operasional Satuan Pendidikan</option>
                </select>
            </div>

            <button type="submit" class="btn-next">Berikutnya</button>
        </form>
    </div>

    {{-- ================= FOTO DI KANAN ================= --}}
    <div class="survey-right">
        <h1>1/3 <span>Survey</span></h1>
    </div>
</div>
@endsection
