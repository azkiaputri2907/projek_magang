<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Admin | Disdik Kab. Banjar</title>
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #E8F2FF;
      margin: 0;
      padding: 0;
    }

    .login-container {
      display: flex;
      min-height: 100vh;
      background-color: #E8F2FF;
      align-items: center;
      justify-content: center;
      padding: 20px;
    }

    .login-card {
      display: flex;
      background-color: #fff;
      border-radius: 25px;
      box-shadow: 0 8px 18px rgba(0, 0, 0, 0.08);
      overflow: hidden;
      width: 90%;
      max-width: 950px;
      height: 500px;
    }

    .illustration-side {
      flex: 1.1;
      display: flex;
      justify-content: center;
      align-items: center;
      overflow: hidden;
    }

    .illustration-side img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    /* FORM */
    .form-side {
      flex: 1;
      display: flex;
      flex-direction: column;
      justify-content: center;
      padding: 40px 60px;
      position: relative;
    }

    /* Logo di pojok kanan */
    .logo-header {
      position: absolute;
      top: 15px;
      right: 25px;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .logo-header img {
      height: 45px;
    }

    .login-box {
      max-width: 350px;
      width: 100%;
      margin: 0 auto;
    }

    .login-box h1 {
      font-size: 24px;
      font-weight: 700;
      color: #222;
      margin-bottom: 6px;
    }

    .login-box p {
      color: #666;
      font-size: 13px;
      margin-bottom: 25px;
    }

    label {
      font-weight: 600;
      font-size: 13px;
      color: #333;
      display: block;
      margin-bottom: 5px;
    }

    input[type="email"],
    input[type="password"] {
      width: 100%;
      padding: 12px 14px;
      border: none;
      border-radius: 8px;
      background-color: #f1f5f9;
      font-size: 14px;
      color: #333;
      box-sizing: border-box;
    }

    .password-group {
      position: relative;
    }

    .eye-icon {
      position: absolute;
      right: 12px;
      top: 10px;
      cursor: pointer;
      font-size: 18px;
      transition: .2s;
    }

    /* Mata kebuka */
    .eye-open {
      content: "🙈";
    }

    /* Mata ketutup */
    .eye-close {
      content: "🙉";
    }


    .btn-login {
      background-color: #30E3BC;
      color: #fff;
      border: none;
      padding: 12px 0;
      border-radius: 10px;
      cursor: pointer;
      font-weight: 600;
      font-size: 14px;
      box-shadow: 0 3px 8px rgba(48, 227, 188, 0.4);
      transition: .2s;
      margin-top: 10px;
      width: 100%;
    }

    .btn-login:hover {
      background-color: #27C4A1;
      transform: translateY(-2px);
    }

    .alert-error {
      margin-bottom: 10px;
      padding: 8px;
      background: #f8d7da;
      border: 1px solid #f5c6cb;
      color: #721c24;
      border-radius: 5px;
      font-size: 13px;
    }

    /* === MOBILE RESPONSIVE === */
/* === RESPONSIVE HP === */
@media (max-width: 900px) {

  .login-card {
    flex-direction: column;
    height: auto;
    width: 100%;
    max-width: 480px;
    border-radius: 18px;
  }

  /* Ilustrasi tetap muncul di atas */
  .illustration-side {
    display: block;
    width: 100%;
    height: 140px;
  }

  .illustration-side img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  /* Logo tetap di kanan atas */
    .logo-header {
        top: 10px;
        right: 10px;
    }

    .logo-header img {
        height: 40px;
    }

  .form-side {
    padding: 20px 25px 30px;
  }

  .login-box {
    margin-top: 10px; /* jarak mendekat ke ilustrasi */
  }

  .login-box h1 {
    font-size: 21px;
  }
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
            <input type="email" id="email" name="email" required>

            <label for="password" style="margin-top: 12px;">Password</label>
            <div class="password-group">
              <input type="password" id="password" name="password" required>
              <span class="eye-icon eye-close" id="eyeIcon" onclick="togglePassword()">🙉</span>
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
      eye.classList.remove("eye-close");
      eye.classList.add("eye-open");
    } else {
      password.type = "password";
      eye.textContent = "🙉";      // mata tutup
      eye.classList.remove("eye-open");
      eye.classList.add("eye-close");
    }
  }
</script>


  @include('components._footer')
</body>
</html>
