<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Buku Tamu Disdik Kab.Banjar')</title>
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">


    {{-- Memanggil CSS yang bisa di-overwrite/ditambahkan oleh child views --}}
    @stack('styles')
    
    <style>
        /* Gaya Dasar Global */
        body { 
            font-family: sans-serif; 
            background-color: #f0f8ff; 
            margin: 0; 
            padding: 0; 
            display: flex; 
            flex-direction: column; 
            min-height: 100vh; 
        }
        .logo-group { 
            position: absolute; 
            top: 20px; 
            right: 20px; 
            display: flex; 
        }
        .logo-group img { 
            height: 70px; 
            margin-left: 10px; 
        }
        .content-container {
            flex-grow: 1; 
            padding-top: 50px; /* Jarak dari atas untuk logo */
            padding-bottom: 80px; /* Jarak dari footer */
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>
<body>

    {{-- Logo Grup di pojok kanan atas --}}
    <div class="logo-group">
        
        
    </div>

    {{-- KONTEN UTAMA APLIKASI --}}
    <div class="content-container">
        @yield('content')
    </div>

    {{-- FOOTER --}}
    @include('components._footer')
    
    {{-- Memanggil JavaScript yang bisa di-overwrite/ditambahkan oleh child views --}}
    @stack('scripts')
</body>
</html>