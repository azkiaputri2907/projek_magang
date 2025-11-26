<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Admin | Disdik Kab. Banjar</title>
  <style>
    /* ===== BACKGROUND (Sama dengan halaman lain) ===== */
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
      margin: 0;
      padding: 0;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .login-container {
      display: flex;
      width: 100%;
      height: 100vh;
      align-items: center;
      justify-content: center;
      padding: 20px;
      box-sizing: border-box;
    }

    /* ===== CARD LOGIN (EFEK 3D) ===== */
    .login-card {
      display: flex;
      background-color: #fff;
      border-radius: 25px;
      overflow: hidden;
      width: 90%;
      max-width: 950px;
      height: 550px; /* Sedikit lebih tinggi agar lega */
      
      /* EFEK TIMBUL: Shadow Berlapis & Border Tebal Bawah */
      box-shadow: 
          0 20px 50px rgba(0, 0, 0, 0.15),
          0 5px 15px rgba(0,0,0,0.05);
      border: 1px solid rgba(255,255,255,0.6);
      border-bottom: 6px solid #e1e8f0; /* Efek fisik tebal */

      animation: cardFadeUp 0.8s ease-out forwards;
      opacity: 0;
      transform: translateY(20px);
    }

    @keyframes cardFadeUp {
      to { opacity: 1; transform: translateY(0); }
    }

    /* ===== ILUSTRASI (KIRI) ===== */
    .illustration-side {
      flex: 1.1;
      display: flex;
      justify-content: center;
      align-items: center;
      overflow: hidden;
      position: relative;
      /* Bayangan pemisah agar terlihat 'masuk' */
      box-shadow: inset -5px 0 15px rgba(0,0,0,0.05);
    }

    .illustration-side img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    /* ===== FORM (KANAN) ===== */
    .form-side {
      flex: 1;
      display: flex;
      flex-direction: column;
      justify-content: center;
      padding: 40px 60px;
      position: relative;
      z-index: 2;
    }

/* LOGO */
.logo-header {
    position: absolute;
    top: 18px;
    right: 25px;
    display: flex;
    align-items: center;
    gap: 10px;
    z-index: 100;
}
.logo-header img { height: 50px; filter: drop-shadow(0 4px 4px rgba(0,0,0,0.1)); }

    .login-box {
      max-width: 350px;
      width: 100%;
      margin: 0 auto;
    }

    .login-box h1 {
      font-size: 26px;
      font-weight: 800;
      color: #003366;
      margin-bottom: 6px;
      text-shadow: 0 2px 3px rgba(0,0,0,0.1);
    }

    .login-box p {
      color: #666;
      font-size: 13px;
      margin-bottom: 30px;
    }

    label {
      font-weight: 600;
      font-size: 13px;
      color: #444;
      display: block;
      margin-bottom: 8px;
    }

    /* ===== INPUT FIELD (EFEK INSET/CEKUNG) ===== */
    input[type="email"],
    input[type="password"] {
      width: 100%;
      padding: 14px 16px;
      border: 1px solid #e0e6ed;
      border-radius: 12px;
      background-color: #f8fafc;
      font-size: 14px;
      color: #333;
      box-sizing: border-box;
      transition: all 0.2s;
      
      /* Bayangan dalam agar terlihat cekung */
      box-shadow: inset 0 2px 5px rgba(0,0,0,0.03);
    }

    input:focus {
      background-color: #fff;
      border-color: #30E3BC;
      outline: none;
      /* Efek Glow & Pop-up */
      box-shadow: 
        0 0 0 4px rgba(48, 227, 188, 0.15),
        0 4px 10px rgba(0,0,0,0.05);
      transform: translateY(-2px);
    }

    .password-group { position: relative; }

    .eye-icon {
      position: absolute;
      right: 15px;
      top: 14px;
      cursor: pointer;
      font-size: 18px;
      transition: .2s;
      opacity: 0.6;
    }
    .eye-icon:hover { opacity: 1; }

    /* ===== TOMBOL LOGIN (EFEK PUSH BUTTON) ===== */
    .btn-login {
      background: linear-gradient(135deg, #30E3BC 0%, #1bcfa5 100%);
      color: #fff;
      border: none;
      padding: 14px 0;
      border-radius: 50px; /* Lebih bulat */
      cursor: pointer;
      font-weight: 700;
      font-size: 15px;
      margin-top: 25px;
      width: 100%;
      letter-spacing: 0.5px;
      position: relative;
      top: 0;

      /* KUNCI EFEK 3D */
      box-shadow: 
          0 6px 0 #16a080, /* Sisi tebal tombol */
          0 12px 20px rgba(48, 227, 188, 0.3); /* Bayangan lantai */
      
      transition: all 0.15s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .btn-login:hover {
      transform: translateY(-2px);
      background: linear-gradient(135deg, #3dfcd1 0%, #21e0b3 100%);
      box-shadow: 
          0 9px 0 #16a080, 
          0 15px 25px rgba(48, 227, 188, 0.5);
    }

    .btn-login:active {
      top: 6px; /* Turun ke bawah */
      box-shadow: 
          0 0 0 #16a080, 
          0 2px 5px rgba(48, 227, 188, 0.4);
    }

    .alert-error {
      margin-bottom: 20px;
      padding: 12px;
      background: #fff5f5;
      border: 1px solid #feb2b2;
      border-left: 4px solid #e53e3e;
      color: #c53030;
      border-radius: 8px;
      font-size: 13px;
      font-weight: 500;
      box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }

    /* === RESPONSIVE HP === */
    @media (max-width: 900px) {
      .login-container {
        height: auto;
        min-height: 100vh;
      }

      .login-card {
        flex-direction: column;
        height: auto;
        width: 100%;
        max-width: 480px;
      }

      /* Ilustrasi tetap muncul di atas */
      .illustration-side {
        display: block;
        width: 100%;
        height: 160px;
        box-shadow: inset 0 -10px 15px rgba(0,0,0,0.05);
      }

      /* Logo tetap di kanan atas */
      .logo-header { top: 10px; right: 10px; }
      .logo-header img { height: 40px; }

      .form-side { padding: 30px 25px 40px; }

      .login-box { margin-top: 5px; }
      .login-box h1 { font-size: 22px; }
      
      .btn-login { width: 100%; }
    }
  </style>
</head>

<body>
  <div class="login-container">
    <div class="login-card">

      <div class="logo-header">
        <img src="{{ asset('images/LOGO_KEMENTRIAN.png') }}" alt="">
        <img src="{{ asset('images/LOGO_PEMKAB_BANJAR.png') }}" alt="">
      </div>

      <div class="illustration-side">
        <img src="{{ asset('images/admin.jpg') }}" alt="Ilustrasi Login Admin">
      </div>

      <div class="form-side">

        <div class="login-box">
          <h1>Login Admin</h1>
          <p>Selamat datang di Sistem Buku Tamu Layanan Disdik Kab. Banjar</p>

          @if ($errors->any())
          <div class="alert-error">
            Kredensial tidak valid. Silakan coba lagi.
          </div>
          @endif

          <form action="{{ route('admin.login') }}" method="POST">
            @csrf

            <label for="email">Email</label>
            <input type="email" id="email" name="email" required placeholder="Masukkan email admin">

            <label for="password" style="margin-top: 15px;">Password</label>
            <div class="password-group">
              <input type="password" id="password" name="password" required placeholder="Masukkan password">
              <span class="eye-icon" id="eyeIcon" onclick="togglePassword()">🙉</span>
            </div>

            <button type="submit" class="btn-login">Masuk</button>
          </form>
        </div>

      </div>

    </div>
  </div>

<script>
  function togglePassword() {
    const password = document.getElementById("password");
    const eye = document.getElementById("eyeIcon");

    if (password.type === "password") {
      password.type = "text";
      eye.textContent = "🙈";     // mata buka
    } else {
      password.type = "password";
      eye.textContent = "🙉";      // mata tutup
    }
  }
</script>

  @include('components._footer')
</body>
</html>