@extends('layouts.app')

@section('title', 'Selamat Datang')

@section('content')
<style>
    /* ===== LATAR BELAKANG ===== */
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
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        margin: 0;
        padding: 20px;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
    }

    /* ===== KOTAK PUTIH (EFEK TIMBUL UTAMA) ===== */
    .white-card {
        background-color: #fff;
        border-radius: 20px;
        width: 100%;
        max-width: 720px;
        min-height: 250px;
        position: relative;
        padding: 30px;
        display: flex;
        flex-direction: column;

        /* EFEK 3D Card */
        box-shadow: 
            0 20px 40px rgba(0,0,0,0.1), /* Bayangan jauh */
            0 5px 10px rgba(0,0,0,0.05), /* Bayangan dekat */
            inset 0 -4px 0 rgba(0,0,0,0.02); /* Ketebalan bawah halus */
        border: 1px solid rgba(255,255,255,0.8);
        border-bottom: 4px solid #e1e8f0; /* Efek tebal fisik bawah */

        /* ANIMASI MASUK */
        animation: cardFadeUp 0.8s ease-out forwards;
        opacity: 0;
    }

    @keyframes cardFadeUp {
        0% { transform: translateY(30px); opacity: 0; }
        100% { transform: translateY(0); opacity: 1; }
    }

    /* ===== HEADER (LOGIN + LOGO) ===== */
    .header-area {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        width: 100%;
        margin-bottom: 20px;
        padding: 0 5px;
    }

    /* EFEK TIMBUL: Login Button */
    .admin-login-btn {
        display: inline-flex;
        align-items: center;
        background: linear-gradient(145deg, #DFEDFE, #e6f0fa); /* Gradient halus */
        color: #5a6b7c;
        text-decoration: none;
        padding: 8px 18px;
        border-radius: 50px;
        font-size: 13px;
        font-weight: 600;
        transition: all 0.2s ease;
        
        /* 3D Button Effect */
        box-shadow: 
            3px 3px 8px rgba(0,0,0,0.05), 
            -2px -2px 6px rgba(255,255,255,0.8),
            0 2px 0 rgba(0,0,0,0.05); /* Tebal bawah */
        border: 1px solid #fff;
    }

    .admin-login-btn i { margin-right: 6px; }

    .admin-login-btn:hover {
        transform: translateY(-2px);
        box-shadow: 
            4px 4px 10px rgba(0,0,0,0.08), 
            -2px -2px 6px rgba(255,255,255,1);
        color: #2c3e50;
    }
    
    .admin-login-btn:active {
        transform: translateY(1px);
        box-shadow: inset 2px 2px 5px rgba(0,0,0,0.05);
    }

    .logo-container img {
        height: 45px;
        margin-left: 8px;
        /* Efek pop sedikit untuk logo */
        filter: drop-shadow(0 2px 3px rgba(0,0,0,0.1)); 
    }

    /* ===== KONTEN UTAMA ===== */
    .main-content {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        padding: 10px 0;
    }

    /* EFEK TIMBUL: Ilustrasi */
    .illustration-box img {
        max-width: 80%;
        height: auto;
        display: block;
        margin: 0 auto 20px;
        max-height: 220px;

        /* Bayangan pada gambar PNG agar karakter terasa 'berdiri' */
        filter: drop-shadow(0 15px 15px rgba(255, 255, 255, 0.2)); 
        animation: floatImage 3s ease-in-out infinite;
    }

    @keyframes floatImage {
        0% { transform: translateY(0); }
        50% { transform: translateY(-12px); }
        100% { transform: translateY(0); }
    }

    .title {
        font-size: 26px; /* Sedikit lebih besar */
        font-weight: 800;
        color: #2c3e50;
        margin-bottom: 8px;
        text-shadow: 0 2px 4px rgba(0,0,0,0.05); /* Teks sedikit timbul */
        
        opacity: 0;
        animation: fadeInText 1s ease forwards;
        animation-delay: 0.3s;
    }

    .subtitle {
        font-size: 13px;
        color: #6c757d;
        margin-bottom: 35px;
        max-width: 80%;
        line-height: 1.6;

        opacity: 0;
        animation: fadeInText 1s ease forwards;
        animation-delay: 0.5s;
    }

    @keyframes fadeInText {
        0% { opacity: 0; transform: translateY(10px); }
        100% { opacity: 1; transform: translateY(0); }
    }

    /* ===== TOMBOL START (EFEK 3D TEKAN) ===== */
    .btn-start {
        background: linear-gradient(to bottom right, #30E3BC, #1bcfa5);
        color: white;
        border: none;
        padding: 14px 45px;
        font-size: 16px;
        border-radius: 50px;
        cursor: pointer;
        text-decoration: none;
        font-weight: 800;
        letter-spacing: 0.5px;
        
        /* EFEK 3D BUTTON (KUNCI AGAR TERLIHAT TIMBUL) */
        box-shadow: 
            0 6px 0 #16a080, /* Bagian samping tebal tombol */
            0 12px 20px rgba(48, 227, 188, 0.4); /* Bayangan lantai */
            
        transition: all 0.15s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        top: 0;

        opacity: 0;
        animation: fadeInBtn 1.2s ease forwards;
        animation-delay: 0.7s;
    }

    /* Efek saat tombol ditekan (Pencet) */
    .btn-start:active {
        top: 6px; /* Tombol turun ke bawah */
        box-shadow: 
            0 0 0 #16a080, /* Samping hilang */
            0 0 5px rgba(48, 227, 188, 0.4); /* Bayangan menipis */
        background: #1bcfa5;
    }

    .btn-start:hover {
        background: linear-gradient(to bottom right, #3dfcd1, #21e0b3);
        transform: translateY(-2px); /* Naik dikit pas di hover sebelum klik */
        box-shadow: 
            0 8px 0 #16a080, 
            0 15px 25px rgba(48, 227, 188, 0.5);
    }

    @keyframes fadeInBtn {
        0% { opacity: 0; transform: translateY(15px); }
        100% { opacity: 1; transform: translateY(0); }
    }

    /* Efek Hover Text */
    .title:hover, .subtitle strong:hover {
        color: #1abc9c;
        transition: 0.3s;
    }
</style>

<div class="white-card">
    {{-- HEADER --}}
    <div class="header-area">
        <a href="{{ route('admin.login') }}" class="admin-login-btn">
            <i class="fas fa-lock"></i> Login Admin
        </a>
        
        <div class="logo-container">
            <img src="{{ asset('images/LOGO_KEMENTRIAN.png') }}" alt="Logo Kementrian">
            <img src="{{ asset('images/LOGO_PEMKAB_BANJAR.png') }}" alt="Logo Kab. Banjar">
        </div>
    </div>

    {{-- KONTEN UTAMA --}}
    <div class="main-content">
        <div class="illustration-box">
            <img src="{{ asset('images/Tessa.png') }}" alt="Ilustrasi Selamat Datang">
        </div>

        <h1 class="title">Selamat Datang di Dinas Pendidikan Kab. Banjar</h1>
        <p class="subtitle">
            Mohon lengkapi data kunjungan Anda di <strong>Buku Tamu Digital</strong> sebelum melanjutkan layanan.
        </p>

        <a href="{{ route('buku-tamu.dashboard') }}" class="btn-start">Mulai</a>
    </div>
</div>
@endsection
