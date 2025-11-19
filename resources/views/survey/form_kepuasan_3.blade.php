@extends('layouts.app')

@section('title', 'Survey Kepuasan (3/3)')

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

/* ======================== LEFT PANEL ======================== */
.bukutamu-left {
    flex: 2.1;
    padding: 60px 80px;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.bukutamu-left h1 {
    font-size: 2.4rem;
    font-weight: 800;
    color: #003366;
    margin-bottom: 30px;
    line-height: 1.3;
}

.bukutamu-left h1 span {
    color: #30E3BC;
}

.question-group {
    margin-bottom: 25px;
}

.question-group p {
    font-weight: 600;
    color: #333;
    margin-bottom: 10px;
    font-size: 1rem;
}

.question-group select,
.question-group textarea {
    width: 100%;
    padding: 13px 14px;
    border: 1px solid #ddd;
    border-radius: 10px;
    font-size: 1rem;
    transition: 0.2s;
}

.question-group select:focus,
.question-group textarea:focus {
    border-color: #30E3BC;
    box-shadow: 0 0 0 3px rgba(48, 227, 188, 0.2);
    outline: none;
}

textarea {
    min-height: 120px;
    resize: vertical;
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
    text-shadow: 0 3px 8px rgba(0, 0, 0, 0.55);
}

.bukutamu-right h1 span {
    color: #30E3BC;
}

/* ======================== RESPONSIVE ======================== */
@media (max-width: 992px) {
    .bukutamu-wrapper {
        flex-direction: column;
        width: 95%;
    }

    .bukutamu-left {
        order: 2;
        padding: 30px 25px;
    }

    .bukutamu-right {
        order: 1;
        height: 280px;
        background-position: center;
    }

    .logo-header {
        top: 10px;
        right: 15px;
    }

    .logo-header img {
        height: 40px;
    }
}

@media (max-width: 600px) {
    body {
        padding: 10px;
    }

    .bukutamu-wrapper {
        border-radius: 15px;
        width: 100%;
    }

    .bukutamu-left {
        padding: 28px 20px;
    }

    .bukutamu-left h1 {
        font-size: 1.7rem;
    }

    .question-group p {
        font-size: 0.9rem;
    }

    .question-group select
    {
        padding: 11px;
        font-size: 0.9rem;
        border-radius: 8px;
    }
    .question-group textarea {
        padding: 1px;
        font-size: 0.9rem;
        border-radius: 8px;
    }

    .btn-next {
        width: 100%;
        padding: 12px 0;
        font-size: 1rem;
        border-radius: 10px;
    }

    .bukutamu-right {
        height: 220px;
        padding: 40px 20px;
    }

    .bukutamu-right h1 {
        font-size: 1.5rem;
    }
}

@media (max-width: 390px) {
    .bukutamu-left {
        padding: 20px 15px;
    }

    .bukutamu-left h1 {
        font-size: 1.4rem;
    }

    .question-group select,
    .question-group textarea {
        padding: 10px;
        font-size: 0.85rem;
    }

    .bukutamu-right {
        height: 180px;
    }

    .bukutamu-right h1 {
        font-size: 1.3rem;
    }
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
