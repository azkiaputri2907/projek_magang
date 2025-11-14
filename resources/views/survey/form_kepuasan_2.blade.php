@extends('layouts.app')

@section('title', 'Survey Kepuasan (2/3)')

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

    .survey-left {
        flex: 2.1;
        padding: 60px 80px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .survey-left h1 {
        font-size: 2.4rem;
        font-weight: 800;
        color: #003366;
        margin-bottom: 30px;
        line-height: 1.3;
    }

    .survey-left h1 span {
        color: #30E3BC;
    }

    .question-group {
        margin-bottom: 30px;
    }

    .question-group p {
        font-weight: 600;
        color: #333;
        margin-bottom: 10px;
        font-size: 1rem;
    }

    .question-group select {
        width: 100%;
        padding: 13px 14px;
        border: 1px solid #ddd;
        border-radius: 10px;
        font-size: 1rem;
        transition: 0.2s;
        max-width: 500px;
    }

    .question-group select:focus {
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
        text-shadow: 0 3px 8px rgba(0, 0, 0, 0.55);
    }

    .survey-right h1 span {
        color: #30E3BC;
    }

    @media (max-width: 992px) {
        .survey-wrapper {
            flex-direction: column;
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
    }
</style>

<div class="logo-header">
    <img src="{{ asset('images/LOGO_KEMENTRIAN.png') }}" alt="Logo Kementrian">
    <img src="{{ asset('images/LOGO_PEMKAB_BANJAR.png') }}" alt="Logo Kab. Banjar">
</div>

<div class="survey-wrapper">
    {{-- ================= FORM DI KIRI ================= --}}
    <div class="survey-left">
        <h1>Aspek <span>Pelayanan</span></h1>

        <form action="{{ route('survey.petugas') }}" method="GET">
            @foreach (request()->query() as $key => $value)
                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            @endforeach

            <div class="question-group">
                <p>Kesesuaian persyaratan pelayanan dengan yang diinformasikan?</p>
                <select name="q1_persyaratan" required>
                    <option value="" disabled selected>Pilih Jawaban</option>
                    <option value="4">Sangat Sesuai</option>
                    <option value="3">Sesuai</option>
                    <option value="2">Kurang Sesuai</option>
                    <option value="1">Tidak Sesuai</option>
                </select>
            </div>

            <div class="question-group">
                <p>Kemudahan prosedur untuk mendapatkan layanan?</p>
                <select name="q2_prosedur" required>
                    <option value="" disabled selected>Pilih Jawaban</option>
                    <option value="4">Sangat Mudah</option>
                    <option value="3">Mudah</option>
                    <option value="2">Cukup Sulit</option>
                    <option value="1">Sangat Sulit</option>
                </select>
            </div>

            <div class="question-group">
                <p>Kesesuaian jangka waktu penyelesaian dengan informasi?</p>
                <select name="q3_waktu" required>
                    <option value="" disabled selected>Pilih Jawaban</option>
                    <option value="4">Sangat Sesuai</option>
                    <option value="3">Sesuai</option>
                    <option value="2">Kurang Sesuai</option>
                    <option value="1">Tidak Sesuai</option>
                </select>
            </div>

            <div class="question-group">
                <p>Kesesuaian biaya/tarif dengan yang diinformasikan?</p>
                <select name="q4_biaya" required>
                    <option value="" disabled selected>Pilih Jawaban</option>
                    <option value="4">Sangat Sesuai</option>
                    <option value="3">Sesuai</option>
                    <option value="2">Kurang Sesuai</option>
                    <option value="1">Tidak Sesuai</option>
                </select>
            </div>

            <div class="question-group">
                <p>Kesesuaian produk pelayanan dengan publikasi?</p>
                <select name="q5_produk" required>
                    <option value="" disabled selected>Pilih Jawaban</option>
                    <option value="4">Sangat Sesuai</option>
                    <option value="3">Sesuai</option>
                    <option value="2">Kurang Sesuai</option>
                    <option value="1">Tidak Sesuai</option>
                </select>
            </div>

            <button type="submit" class="btn-next">Berikutnya</button>
        </form>
    </div>

    {{-- ================= FOTO DI KANAN ================= --}}
    <div class="survey-right">
        <h1>2/3 <span>Survey</span></h1>
    </div>
</div>
@endsection
