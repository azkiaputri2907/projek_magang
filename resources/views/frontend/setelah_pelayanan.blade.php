<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Survey | Disdik Kab. Banjar</title>

    <style>
        /* ==== LATAR BELAKANG (Sama dengan halaman lain) ==== */
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

        /* ==== KOTAK PUTIH (EFEK 3D CARD) ==== */
        .white-card {
            background-color: white;
            border-radius: 25px; /* Lebih bulat dikit */
            width: 100%;
            max-width: 680px;
            min-height: 250px;
            position: relative;
            padding: 40px 30px;
            display: flex;
            flex-direction: column;

            /* EFEK TIMBUL: Shadow & Border Tebal Bawah */
            box-shadow: 
                0 20px 40px rgba(0, 0, 0, 0.1),
                0 5px 10px rgba(0,0,0,0.05);
            border: 1px solid rgba(255,255,255,0.8);
            border-bottom: 6px solid #e1e8f0; /* Efek fisik tebal */

            animation: cardFadeUp 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
            opacity: 0;
            transform: scale(0.95);
        }

        @keyframes cardFadeUp {
            0% { transform: translateY(30px) scale(0.95); opacity: 0; }
            100% { transform: translateY(0) scale(1); opacity: 1; }
        }

        /* ==== HEADER LOGO ==== */
        .header-area {
            display: flex;
            justify-content: flex-end;
            align-items: flex-start;
            width: 100%;
            margin-bottom: 10px;
            padding: 0 5px;
        }

        .logo-container img {
            height: 45px;
            margin-left: 8px;
            filter: drop-shadow(0 3px 3px rgba(0,0,0,0.1)); /* Logo timbul */
        }

        /* ==== KONTEN UTAMA ==== */
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
            margin: 0 auto 25px;
            max-height: 220px;

            /* Bayangan Karakter Pop-out */
            filter: drop-shadow(0 15px 15px rgba(255, 255, 255, 0.25));
            animation: floatImage 3s ease-in-out infinite;
        }    
        
        @keyframes floatImage {
            0% { transform: translateY(0); }
            50% { transform: translateY(-12px); }
            100% { transform: translateY(0); }
        }

        .title {
            font-size: 26px;
            font-weight: 800;
            color: #2c3e50;
            margin-bottom: 10px;
            text-shadow: 0 2px 3px rgba(0,0,0,0.1); /* Teks timbul */

            opacity: 0;
            animation: fadeInText 1s ease forwards;
            animation-delay: 0.3s;
        }

        .subtitle {
            font-size: 14px;
            color: #6c757d;
            margin-bottom: 35px;
            line-height: 1.6;

            opacity: 0;
            animation: fadeInText 1s ease forwards;
            animation-delay: 0.5s;
        }

        @keyframes fadeInText {
            0% { opacity: 0; transform: translateY(15px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        .subtitle strong { color: #2c3e50; }

        /* ==== TOMBOL START (EFEK 3D PUSH) ==== */
        .btn-start {
            background: linear-gradient(135deg, #30E3BC 0%, #1bcfa5 100%);
            color: white;
            border: none;
            padding: 14px 45px;
            font-size: 16px;
            border-radius: 50px;
            cursor: pointer;
            text-decoration: none;
            font-weight: 800;
            letter-spacing: 0.5px;
            position: relative;
            top: 0;

            /* KUNCI EFEK 3D */
            box-shadow: 
                0 6px 0 #16a080, /* Sisi tebal tombol */
                0 12px 20px rgba(48, 227, 188, 0.4); /* Bayangan lantai */

            transition: all 0.15s cubic-bezier(0.4, 0, 0.2, 1);

            opacity: 0;
            animation: fadeInBtn 1.2s ease forwards;
            animation-delay: 0.7s;            
        }

        .btn-start:hover {
            transform: translateY(-3px);
            background: linear-gradient(135deg, #3dfcd1 0%, #21e0b3 100%);
            box-shadow: 
                0 9px 0 #16a080, 
                0 15px 25px rgba(48, 227, 188, 0.5);
        }

        .btn-start:active {
            top: 6px; /* Turun ke bawah */
            box-shadow: 
                0 0 0 #16a080, 
                0 2px 5px rgba(48, 227, 188, 0.4);
        }

        @keyframes fadeInBtn {
            0% { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0); }
        }        

        /* Responsive */
        @media (max-width: 480px) {
            .white-card { padding: 30px 20px; }
            .title { font-size: 22px; }
            .btn-start { width: 100%; text-align: center; box-sizing: border-box;}
        }
    </style>
</head>

<body>

    <div class="white-card">
        
        {{-- HEADER --}}
        <div class="header-area">
            <div class="logo-container">
                <img src="{{ asset('images/LOGO_KEMENTRIAN.png') }}" alt="Logo Kementrian">
                <img src="{{ asset('images/LOGO_PEMKAB_BANJAR.png') }}" alt="Logo Kab. Banjar">
            </div>
        </div>

        {{-- KONTEN UTAMA --}}
        <div class="main-content">
            <div class="illustration-box">
                {{-- Pastikan nama file gambar benar, misal: set_survey.png --}}
                <img src="{{ asset('images/setelah_pelayanan.png') }}" alt="Ilustrasi Survey">
            </div>

            <h1 class="title">Gimana Pelayanannya?</h1>
            <p class="subtitle">Yuk bantu kami jadi lebih baik dengan mengisi <strong>Survei Kepuasan Masyarakat (SKM)</strong>.</p>

            <a href="{{ url('/survey/data-diri') }}" class="btn-start">Isi Survey</a>
        </div>

    </div>

    {{-- @include('components._footer') --}}

</body>
</html>