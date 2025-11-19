<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Survey | Disdik Kab. Banjar</title>

    <style>
        /* ==== LATAR BELAKANG (FULL CENTER) ==== */
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

        /* ==== KOTAK PUTIH (SAMA VIBES DENGAN ONBOARD) ==== */
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

        /* ==== HEADER LOGO ==== */
        .header-area {
            display: flex;
            justify-content: flex-end;
            align-items: flex-start;
            width: 100%;
            margin-bottom: 20px;
            padding: 0 5px;
        }

        .logo-container img {
            height: 45px;
            margin-left: 8px;
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
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s;
            box-shadow: 0 4px 6px rgba(48, 227, 188, 0.4);
        }

        .btn-start:hover {
            background-color: #27C4A1;
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
                <img src="{{ asset('images/setelah_pelayanan.jpg') }}" alt="Ilustrasi Setelah Pelayanan">
            </div>

            <h1 class="title">Gimana Pelayanannya?</h1>
            <p class="subtitle">Yuk isi <strong>Survei Kepuasan Masyarakat (SKM)</strong>.</p>

            <a href="{{ url('/survey/data-diri') }}" class="btn-start">Isi Survey</a>
        </div>

    </div>

    @include('components._footer')

</body>
</html>
