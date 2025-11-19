<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terima Kasih | Disdik Kab. Banjar</title>
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
            width: 210px; /* lebih kecil dari sebelumnya */
            max-width: 85%;
            height: auto;
            display: block;
            margin: 0 auto 20px;
        }

        .title {
            font-size: 24px; /* kecilin lagi */
            font-weight: 700;
            color: #003366;
            margin-bottom: 6px;
        }

        .subtitle {
            font-size: 14px;
            color: #555;
            margin-bottom: 22px;
        }

        .btn-survey {
            background-color: #30E3BC;
            color: #fff;
            font-weight: 600;
            padding: 8px 24px;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            font-size: 0.95rem;
            box-shadow: 0 3px 8px rgba(48, 227, 188, 0.4);
            transition: 0.2s ease-in-out;
            text-decoration: none;
        }

        .btn-survey:hover {
            background-color: #27C4A1;
            transform: translateY(-2px);
        }

            .logo-header {
        top: 10px;
        right: 10px;
    }

    .logo-header img {
        height: 40px;
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
            <img src="{{ asset('images/Ty.png') }}" alt="Terima Kasih">
        </div>
        <h1 class="title">Terima Kasih!</h1>
        <p class="subtitle">Selesai menerima layanan, jangan lupa isi surveynya ya.</p>
        <a href="{{ url('/survey/ajakan') }}" class="btn-survey">Survey</a>
    </div>

    @include('components._footer')
</body>
</html>
