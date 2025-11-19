<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terima Kasih Survey | Disdik Kab. Banjar</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #ffffff;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* ==== LOGO HEADER ==== */
        .logo-header {
            position: absolute;
            top: 10px;          /* disamain */
            right: 10px;        /* disamain */
            display: flex;
            align-items: center;
            gap: 10px;
            z-index: 100;
        }

        .logo-header img {
            height: 40px;       /* kecilin sesuai kode kedua */
        }

        /* ==== KONTEN UTAMA ==== */
        .container {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 80px 20px 60px;
        }

        .illustration-box img {
            width: 210px;
            max-width: 85%;
            height: auto;
            display: block;
            margin: 0 auto 20px;
        }

        .title {
            font-size: 24px;
            font-weight: 700;
            color: #003366;
            margin-bottom: 6px;
        }

        .subtitle {
            font-size: 14px;
            color: #555;
            margin-bottom: 22px;
        }

        .btn-back {
            background-color: #30E3BC;
            color: #fff;
            font-weight: 600;
            padding: 8px 24px;
            border: none;
            border-radius: 20px;   /* disamain kayak btn-survey */
            cursor: pointer;
            font-size: 0.95rem;
            box-shadow: 0 3px 8px rgba(48, 227, 188, 0.4);
            transition: 0.2s ease-in-out;
            text-decoration: none;
        }

        .btn-back:hover {
            background-color: #27C4A1;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>

    <div class="logo-header">
        <img src="{{ asset('images/LOGO_KEMENTRIAN.png') }}" alt="Logo Kementrian">
        <img src="{{ asset('images/LOGO_PEMKAB_BANJAR.png') }}" alt="Logo Kab. Banjar">
    </div>

    <div class="container">
        <div class="illustration-box">
            <img src="{{ asset('images/telah_isi_survey_(1).png') }}" alt="Ilustrasi Terima Kasih Survey">
        </div>

        <h1 class="title">Terima Kasih!</h1>
        <p class="subtitle">Kami menghargai waktu Anda dalam mengisi survei ini.</p>

        <a href="{{ url('/') }}" class="btn-back">Kembali</a>
    </div>

    @include('components._footer')
</body>
</html>
