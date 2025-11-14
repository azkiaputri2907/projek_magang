<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan | Disdik Kab.Banjar</title>
    <style>
        body { font-family: sans-serif; background-color: #f0f8ff; margin: 0; padding: 0; display: flex; flex-direction: column; min-height: 100vh; }
        .logo-group { position: absolute; top: 20px; right: 20px; display: flex; }
        .logo-group img { height: 70px; margin-left: 10px; }
        .menu-icon { position: absolute; top: 30px; left: 30px; font-size: 30px; color: #333; cursor: pointer; z-index: 1001; }
        .main-container { padding: 80px 50px 80px 100px; display: flex; gap: 30px; flex-grow: 1; }
        .content-area { flex: 2; display: flex; gap: 50px; justify-content: flex-start; align-items: center; }
        .right-illustration { flex: 1.5; position: relative; }
        .right-illustration img { max-width: 100%; height: auto; position: absolute; bottom: 0; right: 0; }
        .header-title { font-size: 36px; font-weight: bold; margin-bottom: 50px; position: absolute; top: 80px; left: 100px; }
        .report-chart { text-align: center; }
        .chart-placeholder { width: 200px; height: 200px; border-radius: 50%; border: 30px solid; margin-bottom: 20px; }
        /* Warna untuk meniru chart di desain */
        .chart-pengunjung { border-color: #dc3545 #ffc107 #20c997 #007bff; }
        .chart-skm { border-color: #ffc107 #007bff #20c997 #dc3545; }
        .report-chart p { font-weight: bold; margin-bottom: 15px; }
        .btn-unduh { background-color: #20c997; color: white; padding: 10px 30px; border-radius: 5px; text-decoration: none; font-weight: bold; }
    </style>
</head>
<body>

    @include('components._sidebar_admin')

    <div class="menu-icon">&#9776;</div>

    <div class="logo-group">
                    </div>

    <div class="main-container">
        <h1 class="header-title">Laporan</h1>
        <div class="content-area">
            <div class="report-chart">
                <div class="chart-placeholder chart-pengunjung">
                    {{-- Di sini biasanya akan ada chart JS seperti Chart.js atau sejenisnya --}}
                </div>
                <p>Data Pengunjung</p>
                <a href="#" class="btn-unduh">Unduh</a>
            </div>

            <div class="report-chart">
                <div class="chart-placeholder chart-skm">
                     {{-- Di sini biasanya akan ada chart JS seperti Chart.js atau sejenisnya --}}
                </div>
                <p>Data SKM</p>
                <a href="#" class="btn-unduh">Unduh</a>
            </div>
        </div>
        <div class="right-illustration">
             {{-- Ilustrasi dari laporan.png --}}
                    </div>
    </div>

    @include('components._footer')
</body>
</html>