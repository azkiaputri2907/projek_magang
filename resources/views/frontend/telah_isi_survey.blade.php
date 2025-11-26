<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terima Kasih Survey | Disdik Kab. Banjar</title>
    <style>
    /* ===== LATAR BELAKANG (Sama dengan halaman lain) ===== */
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #DFEDFE;
        background-image: 
            linear-gradient(135deg, rgba(255,255,255,0.18) 25%, transparent 25%),
            linear-gradient(225deg, rgba(255,255,255,0.18) 25%, transparent 25%),
            linear-gradient(45deg, rgba(255,255,255,0.18) 25%, transparent 25%),
            linear-gradient(315deg, rgba(255,255,255,0.18) 25%, #DFEDFE 25%);
        background-position: 20px 0, 20px 0, 0 0, 0 0;
        background-size: 20px 20px;
        background-repeat: repeat;

        display: flex;
        flex-direction: column;
        min-height: 100vh;
        margin: 0;
        padding: 20px;
        align-items: center;
        justify-content: center;
        box-sizing: border-box;
    }

    /* ===== LOGO HEADER ===== */
    .logo-header {
        position: absolute;
        top: 20px;
        right: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
        z-index: 100;
        animation: fadeInTop 0.8s ease forwards;
        opacity: 0;
        filter: drop-shadow(0 4px 4px rgba(0,0,0,0.1));
    }

    .logo-header img { height: 45px; }

    @keyframes fadeInTop {
        0% { opacity: 0; transform: translateY(-15px); }
        100% { opacity: 1; transform: translateY(0); }
    }

    /* ===== KARTU UTAMA (Gaya 3D Timbul) ===== */
    .thankyou-card {
        background-color: #fff;
        width: 100%;
        max-width: 550px;
        padding: 50px 30px;
        border-radius: 25px;
        text-align: center;
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: center;

        /* EFEK 3D: Ketebalan Bawah & Bayangan */
        box-shadow: 
            0 20px 40px rgba(0,0,0,0.1), 
            0 5px 10px rgba(0,0,0,0.05);
        border: 1px solid rgba(255,255,255,0.8);
        border-bottom: 6px solid #e1e8f0; /* Efek tebal fisik */

        animation: cardFadeUp 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
        opacity: 0;
        transform: scale(0.95);
    }

    @keyframes cardFadeUp {
        0% { opacity: 0; transform: translateY(40px) scale(0.95); }
        100% { opacity: 1; transform: translateY(0) scale(1); }
    }

    /* ===== ILUSTRASI ===== */
    .illustration-box img {
        width: 240px;
        max-width: 80%;
        height: auto;
        margin-bottom: 25px;

        /* Bayangan karakter agar 'pop out' */
        filter: drop-shadow(0 15px 15px rgba(255, 255, 255, 0.25));
        animation: floatImage 3s ease-in-out infinite;
    }

    @keyframes floatImage {
        0% { transform: translateY(0); }
        50% { transform: translateY(-12px); }
        100% { transform: translateY(0); }
    }

    /* ===== TEKS ===== */
    .title {
        font-size: 28px;
        font-weight: 800;
        color: #2c3e50;
        margin: 0 0 10px 0;
        text-shadow: 0 2px 3px rgba(0,0,0,0.1);

        opacity: 0;
        animation: fadeInText 0.8s ease forwards;
        animation-delay: .3s;
    }

    .subtitle {
        font-size: 15px;
        color: #6c757d;
        margin: 0 auto 35px auto;
        max-width: 85%;
        line-height: 1.6;

        opacity: 0;
        animation: fadeInText 0.8s ease forwards;
        animation-delay: .5s;
    }

    @keyframes fadeInText {
        0% { opacity: 0; transform: translateY(15px); }
        100% { opacity: 1; transform: translateY(0); }
    }

    /* ===== TOMBOL KEMBALI (Gaya 3D Push Button) ===== */
    .btn-back {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #30E3BC 0%, #1bcfa5 100%);
        color: #fff;
        font-weight: 700;
        padding: 14px 50px;
        border-radius: 50px;
        text-decoration: none;
        font-size: 16px;
        letter-spacing: 0.5px;
        position: relative;
        top: 0;
        border: none;
        cursor: pointer;
        
        /* KUNCI EFEK TIMBUL TOMBOL */
        box-shadow: 
            0 6px 0 #16a080, /* Sisi tebal tombol */
            0 12px 20px rgba(48, 227, 188, 0.4); /* Bayangan lantai */
            
        transition: all 0.15s cubic-bezier(0.4, 0, 0.2, 1);
        
        opacity: 0;
        animation: fadeInBtn 0.8s ease forwards;
        animation-delay: .7s;
    }

    /* Efek Hover */
    .btn-back:hover {
        transform: translateY(-3px);
        background: linear-gradient(135deg, #3dfcd1 0%, #21e0b3 100%);
        box-shadow: 
            0 9px 0 #16a080, 
            0 15px 25px rgba(48, 227, 188, 0.5);
    }

    /* Efek Klik (Pencet) */
    .btn-back:active {
        top: 6px; /* Turun ke bawah */
        box-shadow: 
            0 0 0 #16a080, 
            0 2px 5px rgba(48, 227, 188, 0.4);
    }

    @keyframes fadeInBtn {
        0% { opacity: 0; transform: translateY(20px); }
        100% { opacity: 1; transform: translateY(0); }
    }

    /* RESPONSIVE HP */
    @media (max-width: 480px) {
        .thankyou-card {
            padding: 40px 20px;
        }
        .title { font-size: 24px; }
        .subtitle { font-size: 14px; }
        .illustration-box img { width: 180px; }
        .btn-back { width: 100%; box-sizing: border-box; }
    }
    </style>
</head>
<body>

    <div class="logo-header">
        <img src="{{ asset('images/LOGO_KEMENTRIAN.png') }}" alt="Logo Kementrian">
        <img src="{{ asset('images/LOGO_PEMKAB_BANJAR.png') }}" alt="Logo Kab. Banjar">
    </div>

    {{-- KARTU UTAMA --}}
    <div class="thankyou-card">
        <div class="illustration-box">
            <img src="{{ asset('images/telah_isi_survey_(1).png') }}" alt="Ilustrasi Terima Kasih Survey">
        </div>
        
        <h1 class="title">Terima Kasih!</h1>
        <p class="subtitle">Kami sangat menghargai waktu Anda dalam mengisi survei ini.</p>
        
        <a href="{{ url('/') }}" class="btn-back">
            Kembali
        </a>
    </div>

    {{-- @include('components._footer') --}}
</body>
</html>