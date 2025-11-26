@extends('layouts.app')

@section('title', 'Survey Kepuasan (3/3)')

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

/* ======================== LEFT PANEL ======================== */
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
    margin-bottom: 30px;
    line-height: 1.3;
    text-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.bukutamu-left h1 span { color: #30E3BC; }

.question-group { margin-bottom: 25px; }

.question-group p {
    font-weight: 600;
    color: #333;
    margin-bottom: 10px;
    font-size: 1rem;
}

/* EFEK TIMBUL: SELECT & TEXTAREA (INSET) */
.question-group select,
.question-group textarea {
    width: 100%;
    padding: 14px 16px;
    border: 1px solid #e0e6ed;
    border-radius: 12px;
    font-size: 1rem;
    background-color: #f8fafc;
    transition: all 0.2s;
    /* Bayangan dalam (Inset) */
    box-shadow: inset 0 2px 5px rgba(0,0,0,0.03); 
}

.question-group select:focus,
.question-group textarea:focus {
    background-color: #fff;
    border-color: #30E3BC;
    /* Efek Glow */
    box-shadow: 
        0 0 0 4px rgba(48, 227, 188, 0.15),
        0 4px 10px rgba(0,0,0,0.05);
    outline: none;
    transform: translateY(-2px);
}

textarea {
    min-height: 120px;
    resize: vertical;
}

/* EFEK TIMBUL: TOMBOL KIRIM (PUSH BUTTON) */
.btn-next {
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

.btn-next:hover {
    transform: translateY(-2px);
    background: linear-gradient(135deg, #3dfcd1 0%, #21e0b3 100%);
    box-shadow: 0 8px 0 #16a080, 0 15px 25px rgba(48, 227, 188, 0.4);
}

.btn-next:active {
    transform: translateY(6px); /* Turun ke bawah */
    box-shadow: 0 0 0 #16a080, 0 2px 5px rgba(48, 227, 188, 0.4);
}

/* ======================== RIGHT PANEL ======================== */
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

    .logo-header { top: 10px; right: 15px; }
    .logo-header img { height: 40px; }
}

@media (max-width: 600px) {
    .bukutamu-left { padding: 30px 20px; }
    .bukutamu-left h1 { font-size: 1.7rem; }
    .question-group p { font-size: 0.9rem; }
    .question-group select, .question-group textarea { padding: 8px; font-size: 0.9rem; }
    
    .btn-next {
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
    .question-group select, .question-group textarea { padding: 10px; font-size: 0.85rem; }
    .bukutamu-right { height: 180px; }
    .bukutamu-right h1 { font-size: 1.3rem; }
}
</style>

<div class="logo-header">
    <img src="{{ asset('images/LOGO_KEMENTRIAN.png') }}" alt="Logo Kementrian">
    <img src="{{ asset('images/LOGO_PEMKAB_BANJAR.png') }}" alt="Logo Kab. Banjar">
</div>

<div class="bukutamu-wrapper">

    {{-- ================= FORM KIRI ================= --}}
    <div class="bukutamu-left">
        <h1>Aspek <span>Petugas & Sarana</span></h1>

        <form action="{{ route('survey.store') }}" method="POST">
            @csrf

            {{-- Simpan data dari halaman sebelumnya --}}
            @foreach (request()->query() as $key => $value)
                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            @endforeach

            <div class="question-group">
                <p>Bagaimana pendapat Saudara tentang kompetensi/kemampuan petugas dalam pelayanan?</p>
                <select name="q6_kompetensi_petugas" required>
                    <option value="" disabled selected>Pilih Jawaban</option>
                    <option value="4">Sangat Baik</option>
                    <option value="3">Baik</option>
                    <option value="2">Kurang Baik</option>
                    <option value="1">Tidak Baik</option>
                </select>
            </div>

            <div class="question-group">
                <p>Bagaimana pendapat Saudara tentang perilaku petugas dalam pelayanan terkait kesopanan dan keramahan?</p>
                <select name="q7_perilaku_petugas" required>
                    <option value="" disabled selected>Pilih Jawaban</option>
                    <option value="4">Sangat Baik</option>
                    <option value="3">Baik</option>
                    <option value="2">Kurang Baik</option>
                    <option value="1">Tidak Baik</option>
                </select>
            </div>

            <div class="question-group">
                <p>Bagaimana pendapat Saudara tentang penanganan pengaduan dan layanan konsultasi yang tersedia?</p>
                <select name="q8_penanganan_pengaduan" required>
                    <option value="" disabled selected>Pilih Jawaban</option>
                    <option value="4">Sangat Baik</option>
                    <option value="3">Baik</option>
                    <option value="2">Kurang Baik</option>
                    <option value="1">Tidak Ada</option>
                </select>
            </div>

            <div class="question-group">
                <p>Bagaimana pendapat Saudara tentang kualitas sarana dan prasarana pelayanan?</p>
                <select name="q9_sarana" required>
                    <option value="" disabled selected>Pilih Jawaban</option>
                    <option value="4">Sangat Baik</option>
                    <option value="3">Baik</option>
                    <option value="2">Kurang Baik</option>
                    <option value="1">Tidak Baik</option>
                </select>
            </div>

            <div class="question-group">
                <p>Saran / Masukan / Pendapat</p>
                <textarea name="saran_masukan"></textarea>
            </div>

            <button type="submit" class="btn-next">Kirim</button>
        </form>
    </div>

    {{-- ================= FOTO KANAN ================= --}}
    <div class="bukutamu-right">
        <h1>3/3 <span>Survey</span></h1>
    </div>

</div>
@endsection