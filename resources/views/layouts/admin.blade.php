<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | @yield('title', 'Disdik Kab.Banjar')</title>
    <style>
        /* Menggunakan warna latar belakang biru muda yang cerah sesuai desain */
        body { 
            font-family: sans-serif; 
            background-color: #e6f0ff; /* Warna latar yang lebih dekat ke desain */
            margin: 0; 
            padding: 0; 
            display: flex; 
            flex-direction: column; 
            min-height: 100vh; 
        }

        /* --- STYLES UNTUK HEADER & LOGO --- */
        /* Pastikan logo dan badge ada di halaman login (seperti di gambar) */
        .header-content { 
            position: absolute; 
            top: 20px; 
            right: 20px; 
            display: flex;
            align-items: center;
            z-index: 10;
        }
        .header-content img { 
            height: 70px; /* Ukuran logo disesuaikan */
            margin-left: 10px; 
        }

        /* --- MENU ICON HANYA TAMPIL JIKA BUKAN HALAMAN LOGIN --- */
        .menu-icon { 
            position: absolute; 
            top: 30px; 
            left: 30px; 
            font-size: 30px; 
            color: #333; 
            cursor: pointer; 
            z-index: 1001; 
            /* Disembunyikan secara default, akan diatur tampil di bagian PHP jika perlu */
        }

        /* --- WRAPPER UTAMA KONTEN (Dashboard/Login) --- */
        .main-wrapper {
            /* Padding disesuaikan untuk halaman non-login */
            padding: 80px 50px 80px 100px; 
            flex-grow: 1;
            display: flex;
            width: 100%;
            box-sizing: border-box;
        }

        /* --- NOTIFIKASI --- */
        .alert-success {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid #c3e6cb;
            border-radius: 4px;
            color: #155724;
            background-color: #d4edda;
        }

        /* --- STYLES KHUSUS UNTUK ILUSTRASI LOGIN (Halaman Login) --- */
        .login-illustration {
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            width: 700px; /* Lebar area ilustrasi */
            height: 500px; /* Tinggi area ilustrasi */
            /* Menggantikan ilustrasi dengan background image/div yang sesuai desain */
            background-image: url('{{ asset('images/login-illustration.png') }}'); /* Ganti dengan path ilustrasi Anda */
            background-size: contain;
            background-repeat: no-repeat;
            background-position: left center;
        }

        /* --- STYLES KHUSUS UNTUK FOOTER SOSIAL MEDIA (Halaman Login/Semua Halaman) --- */
        .footer-sosmed {
            width: 100%;
            padding: 20px 0;
            background-color: #fff; /* Atau warna biru muda yang sangat terang */
            border-top: 1px solid #eee;
            text-align: center;
            position: sticky; /* Agar footer tetap di bawah */
            bottom: 0;
            box-sizing: border-box;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 40px;
            margin-top: auto; /* Mendorong footer ke bawah */
        }
        .footer-sosmed a {
            color: #4a4a4a;
            text-decoration: none;
            font-size: 16px;
            display: flex;
            align-items: center;
            font-weight: 500;
        }
        .footer-sosmed a::before {
            content: '';
            display: inline-block;
            width: 20px;
            height: 20px;
            margin-right: 8px;
            background-size: contain;
            background-repeat: no-repeat;
        }
        /* Ikon placeholder untuk sosmed */
        .footer-sosmed .yt::before { content: '▶'; color: #ff0000; font-size: 24px; }
        .footer-sosmed .web::before { content: '🌐'; font-size: 20px; }
        .footer-sosmed .ig::before { content: '📷'; color: #e1306c; font-size: 20px; }

    </style>
</head>
<body>

    {{-- Ikon Hamburger Menu - HANYA TAMPIL JIKA BUKAN LOGIN --}}
    @if (!View::hasSection('is_login'))
        <div class="menu-icon">&#9776;</div>
    @endif


    {{-- Logo Grup --}}
    <div class="header-content">
        {{-- Ganti dengan path logo Anda --}}
        <img src="{{ asset('images/LOGO_KEMENTERIAN.png') }}" alt="Logo Tut Wuri Handayani">
        <img src="{{ asset('images/LOGO_KAB_BANJAR.png') }}" alt="Logo Kab. Banjar">
    </div>

    {{-- --- LOGIKA KONTEN UTAMA --- --}}
    @hasSection('is_login')
        {{-- JIKA INI ADALAH HALAMAN LOGIN --}}
        <div class="main-wrapper" style="
            padding: 0; 
            justify-content: center; 
            align-items: center; 
            flex-grow: 1;
            /* Flex-direction diubah menjadi row default untuk menampung Ilustrasi Kiri dan Form Kanan */
            position: relative;
        ">
            {{-- Bagian Ilustrasi Kiri (sekitar 50%) --}}
            <div style="flex: 1.2; display: flex; justify-content: flex-end; align-items: center; height: 100%;">
                {{-- Ini adalah tempat ilustrasi login Anda akan muncul --}}
                <div class="login-illustration" style="
                    /* Ini adalah kontainer untuk ilustrasi vector (login admin (1).png) */
                    position: static; 
                    transform: none;
                    width: 600px; 
                    height: 600px;
                    background-image: url('{{ asset('images/login_admin_illustration.png') }}'); /* Ganti dengan path ilustrasi Anda */
                    background-size: contain;
                    background-repeat: no-repeat;
                    background-position: right center;
                ">
                </div>
            </div>

            {{-- Tempat Konten Login (Formulir Login) (sekitar 50%) --}}
            <div style="flex: 1; max-width: 450px; padding: 40px 0 40px 50px;">
                @yield('content')
            </div>

        </div>
    @else
        {{-- JIKA INI BUKAN HALAMAN LOGIN (DASHBOARD/DATA) --}}
        {{-- SIDEBAR ADMIN --}}
        @include('components._sidebar_admin')

        <div class="main-wrapper">
            <div style="flex: 1; margin-right: 30px;">
                {{-- Menampilkan Notifikasi Sukses --}}
                @if(session('success'))
                    <div class="alert-success">
                        {!! session('success') !!}
                    </div>
                @endif
                @yield('content')
            </div>
            
            {{-- ILUSTRASI UMUM DI SISI KANAN (Dihilangkan di halaman Login) --}}
            <div style="flex: 1.5; position: relative;">
                {{-- Asumsi ilustrasi ini ada di semua halaman Admin --}}
                <img src="{{ asset('images/admin-general-illustration.png') }}" alt="Admin Illustration" style="width: 100%; height: auto;">
            </div>
        </div>
    @endif

@include('components._footer') 

</body>
</html>