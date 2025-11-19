@extends('layouts.app')

@section('title','Edit Banyak Pengunjung')

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

    /* WRAPPER BESAR (2 KOLOM) */
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

    /* LEFT FORM */
    .bukutamu-left {
        flex: 2;
        padding: 50px 60px;
        overflow-y: auto;
    }

    .bukutamu-left h1 {
        font-size: 2.2rem;
        font-weight: 800;
        color: #003366;
        margin-bottom: 25px;
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
        margin-bottom: 5px;
        display: block;
    }

    .edit-card input {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #bcd4fe;
        border-radius: 10px;
        margin-bottom: 12px;
        outline: none;
        transition: .2s;
    }

    .edit-card input:focus {
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

    /* RIGHT PHOTO PANEL */
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

    /* RESPONSIVE */
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
    
    {{-- RIGHT SIDE IMAGE --}}
    <div class="bukutamu-right">
        <h1><span>Edit</span> Pengunjung</h1>
    </div>

    {{-- LEFT SIDE CONTENT --}}
    <div class="bukutamu-left">
        <form action="{{ route('pengunjung.updateMultiple') }}" method="POST">
            @csrf

            @foreach($items as $item)
            <div class="edit-card">
                <input type="hidden" name="pengunjung[{{ $item->id }}][id]" value="{{ $item->id }}">

                <label>Tanggal</label>
                <input type="date" name="pengunjung[{{ $item->id }}][tanggal]" value="{{ $item->tanggal }}">

                <label>Nama / NIP</label>
                <input type="text" name="pengunjung[{{ $item->id }}][nama_nip]" value="{{ $item->nama_nip }}">

                <label>Instansi</label>
                <input type="text" name="pengunjung[{{ $item->id }}][instansi]" value="{{ $item->instansi }}">

                <label>Layanan</label>
                <input type="text" name="pengunjung[{{ $item->id }}][layanan]" value="{{ $item->layanan }}">

                <label>Keperluan</label>
                <input type="text" name="pengunjung[{{ $item->id }}][keperluan]" value="{{ $item->keperluan }}">

                <label>No. HP</label>
                <input type="text" name="pengunjung[{{ $item->id }}][no_hp]" value="{{ $item->no_hp }}">
            </div>
            @endforeach

            <button type="submit" class="btn-simpan-semua">Simpan Semua</button>
        </form>
    </div>

</div>

@endsection
@include('components._footer')
