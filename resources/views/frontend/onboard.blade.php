@extends('layouts.app')

@section('title', 'Selamat Datang')

@section('content')
<style>
    /* ===== LATAR BELAKANG ===== */
    body {
        background-color: #DFEDFE;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        margin: 0;
        padding: 20px;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
    }

    /* ===== KOTAK PUTIH ===== */
    .white-card {
        background-color: white;
        border-radius: 15px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 720px;
        min-height: 250px;
        position: relative;
        padding: 25px;
        display: flex;
        flex-direction: column;
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

    .admin-login-btn {
        display: inline-flex;
        align-items: center;
        background-color: #DFEDFE;
        color: #2c3e50;
        text-decoration: none;
        padding: 5px 15px;
        border-radius: 20px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        font-size: 13px;
        font-weight: 500;
        transition: background-color 0.3s;
    }

    .admin-login-btn i {
        margin-right: 6px;
        font-size: 13px;
    }

    .admin-login-btn:hover {
        background-color: #c9e0fc;
    }

    .logo-container img {
        height: 45px;
        margin-left: 8px;
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

    .illustration-box img {
        max-width: 80%;
        height: auto;
        display: block;
        margin: 0 auto 20px;
        max-height: 200px;
    }

    .title {
        font-size: 24px;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 8px;
    }

    .subtitle {
        font-size: 13px;
        color: #6c757d;
        margin-bottom: 30px;
        max-width: 80%;
    }

    .subtitle strong {
        color: #2c3e50;
    }

    .btn-start {
        background-color: #30E3BC;
        color: white;
        border: none;
        padding: 12px 32px;
        font-size: 16px;
        border-radius: 40px;
        cursor: pointer;
        transition: background-color 0.3s;
        text-decoration: none;
        font-weight: bold;
        box-shadow: 0 4px 6px rgba(48, 227, 188, 0.4);
    }

    .btn-start:hover {
        background-color: #27C4A1;
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
            <img src="{{ asset('images/Tessa.jpg') }}" alt="Ilustrasi Selamat Datang">
        </div>

        <h1 class="title">Selamat Datang di Dinas Pendidikan Kab. Banjar</h1>
        <p class="subtitle">Mohon lengkapi data kunjungan Anda di <strong>Buku Tamu Digital</strong> sebelum melanjutkan layanan.</p>

        <a href="{{ route('buku-tamu.dashboard') }}" class="btn-start">Mulai</a>
    </div>
</div>
@endsection
