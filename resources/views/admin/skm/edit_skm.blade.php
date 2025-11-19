@extends('layouts.app')

@section('title','Edit Data SKM')

@section('content')
<style>
    body {
        background-color: #DFEDFE;
        font-family: 'Poppins', sans-serif;
        margin: 0;
        padding-top: 40px;
    }

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

    /* MAIN WRAPPER */
    .edit-wrapper {
        width: 95%;
        max-width: 1300px;
        margin: 0 auto;
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        display: flex;
        overflow: hidden;
        min-height: 720px;
    }

    /* LEFT SIDE FORM */
    .bukutamu-left {
        flex: 2;
        padding: 50px 60px;
        overflow-y: auto;
    }

    .edit-card {
        background: #ffffff;
        border-radius: 15px;
        padding: 20px 25px;
        margin-bottom: 18px;
        border: 1px solid #d5e6ff;
        box-shadow: 0px 6px 14px rgba(0,0,0,0.06);
    }

    .edit-card label {
        font-weight: 600;
        margin-bottom: 6px;
        display: block;
    }

    .edit-card input,
    .edit-card select,
    .edit-card textarea {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #bcd4fe;
        border-radius: 10px;
        margin-bottom: 14px;
        outline: none;
        transition: .2s;
    }

    .edit-card input:focus,
    .edit-card select:focus,
    .edit-card textarea:focus {
        border-color: #007BFF;
        box-shadow: 0 0 6px rgba(0,123,255,0.3);
    }

    .btn-simpan-semua {
        background: #2bd9a6;
        border: none;
        padding: 14px 28px;
        color: #fff;
        font-size: 1.1rem;
        font-weight: 700;
        border-radius: 12px;
        cursor: pointer;
        display: block;
        margin: 20px auto 0 auto;
        transition: .2s;
    }

    .btn-simpan-semua:hover {
        background: #1fc190;
        transform: translateY(-2px);
    }

    /* RIGHT IMAGE PANEL */
    .bukutamu-right {
        flex: 1;
        background-color: #C9E1FF;
        background-image: url('{{ asset('images/survey.png') }}');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        position: relative;
        display: flex;
        justify-content: center;
        align-items: flex-start;
        padding-top: 100px;
    }

    .bukutamu-right::after {
        content: "";
        position: absolute;
        inset: 0;
        background: linear-gradient(to bottom, rgba(0,0,0,0.35), transparent 60%);
        z-index: 1;
    }

    .bukutamu-right h1 {
        z-index: 2;
        color: #fff;
        font-size: 2rem;
        font-weight: 800;
        text-align: center;
        text-shadow: 0 3px 8px rgba(0, 0, 0, 0.55);
    }

    .bukutamu-right h1 span {
        color: #30E3BC;
    }

    @media (max-width: 992px) {
        .edit-wrapper {
            flex-direction: column;
        }
        .bukutamu-right {
            height: 260px;
        }

        .logo-header {
            top: 10px;
            right: 10px;
        }

        .logo-header img {
            height: 40px;
        }
    }
</style>

<div class="logo-header">
    <img src="{{ asset('images/LOGO_KEMENTRIAN.png') }}" alt="Logo Kementrian">
    <img src="{{ asset('images/LOGO_PEMKAB_BANJAR.png') }}" alt="Logo Kab. Banjar">
</div>

<div class="edit-wrapper">

    {{-- RIGHT IMAGE --}}
    <div class="bukutamu-right">
        <h1><span>Edit</span> SKM</h1>
    </div>

    {{-- LEFT FORM --}}
    <div class="bukutamu-left">

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

            {{-- Q1 - Q9 --}}
            @for ($i = 1; $i <= 9; $i++)
            <div class="edit-card">
                <label>Q{{ $i }}</label>
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
                    required>
            </div>
            @endfor

            <div class="edit-card">
                <label>Saran Masukan</label>
                <textarea name="saran_masukan" rows="3">{{ $skm->saran_masukan }}</textarea>
            </div>

            <button type="submit" class="btn-simpan-semua">Simpan Perubahan</button>
        </form>

    </div>
</div>

@endsection

@include('components._footer')
