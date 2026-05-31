<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login — PANDU K3</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome 6 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="{{ asset('css/pandu.css') }}">
  <style>
    .login-footer { border-top: 1px solid #eee; margin-top: 3rem; padding-top: 1.5rem; }
    .auth-left-content { max-width: 500px; }
    .feature-item { 
      background: rgba(255,255,255,0.05); 
      border: 1px solid rgba(255,255,255,0.1); 
      border-radius: 12px; 
      padding: 1rem; 
      margin-bottom: 1rem;
      backdrop-filter: blur(5px);
    }
  </style>
</head>
<body>

<div class="auth-page">
  <!-- Left Panel — Branding (Visible on Desktop) -->
  <div class="auth-left text-white d-none d-lg-flex">
    <div class="auth-left-content z-1 position-relative">
      <div class="logo-icon mb-4 shadow-lg" style="width: 70px; height: 70px; font-size: 32px;">
        <i class="fas fa-shield-halved"></i>
      </div>
      <h1 class="display-5 fw-extrabold mb-2 tracking-tight">PANDU K3</h1>
      <p class="fs-5 opacity-75 fw-medium mb-5">Pusat Analisis & Navigasi Data Unggul K3</p>
      
      <div class="mt-5">
        <div class="feature-item d-flex align-items-center gap-3">
           <div class="icon-box-sm bg-orange text-white rounded-circle"><i class="fas fa-bolt"></i></div>
           <div>
              <p class="mb-0 fw-bold">Respons Cepat Darurat</p>
              <p class="mb-0 smaller opacity-75">Integrasi Panic Button dan alur eskalasi otomatis.</p>
           </div>
        </div>
        <div class="feature-item d-flex align-items-center gap-3">
           <div class="icon-box-sm bg-primary text-white rounded-circle"><i class="fas fa-chart-pie"></i></div>
           <div>
              <p class="mb-0 fw-bold">Analitik Data Presisi</p>
              <p class="mb-0 smaller opacity-75">Visualisasi KPI K3 (LTIFR/TRIFR) secara real-time.</p>
           </div>
        </div>
        <div class="feature-item d-flex align-items-center gap-3">
           <div class="icon-box-sm bg-success text-white rounded-circle"><i class="fas fa-clipboard-check"></i></div>
           <div>
              <p class="mb-0 fw-bold">Kepatuhan Terjamin</p>
              <p class="mb-0 smaller opacity-75">Manajemen HIRADC, Izin Kerja, dan Sertifikasi digital.</p>
           </div>
        </div>
      </div>
      
      <div class="mt-5 pt-4 opacity-50 small">
        <p class="mb-0 fw-semibold">Dipercaya oleh Industri Utama Indonesia</p>
      </div>
    </div>
  </div>

  <!-- Right Panel — Form -->
  <div class="auth-right py-5">
    <div class="auth-card shadow-lg border-0 px-4 px-md-5">
      <!-- Mobile Logo (Visible only on mobile) -->
      <div class="d-lg-none text-center mb-4">
         <div class="logo-icon mx-auto mb-2" style="width: 50px; height: 50px; font-size: 24px;">
            <i class="fas fa-shield-halved"></i>
         </div>
         <h3 class="fw-bold text-dark">PANDU K3</h3>
      </div>

      <div class="mb-4 text-center text-lg-start">
        <h2 class="fw-bold text-dark mb-1">Masuk Akun</h2>
        <p class="text-secondary small">Gunakan email perusahaan untuk mengakses dashboard</p>
      </div>

      @if($errors->any())
        <div class="alert alert-danger border-0 small py-2">
          <ul class="mb-0 ps-3">
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form action="{{ route('login') }}" method="POST" class="mt-4">
        @csrf
        <div class="mb-3">
          <label for="email" class="form-label text-uppercase smaller tracking-wider text-muted">ID Pengguna / Email</label>
          <div class="input-group">
            <span class="input-group-text bg-light border-end-0 text-secondary"><i class="fas fa-envelope"></i></span>
            <input type="email" class="form-control border-start-0 py-2" id="email" name="email" value="{{ old('email') }}" placeholder="admin@pandu.com" required autofocus>
          </div>
        </div>

        <div class="mb-3">
          <label for="password" class="form-label text-uppercase smaller tracking-wider text-muted">Kata Sandi</label>
          <div class="input-group">
            <span class="input-group-text bg-light border-end-0 text-secondary"><i class="fas fa-lock"></i></span>
            <input type="password" class="form-control border-start-0 py-2" id="password" name="password" placeholder="••••••••" required>
          </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="remember" id="remember">
            <label class="form-check-label text-secondary small" for="remember">
              Tetap Masuk
            </label>
          </div>
          <a href="#" class="text-pandu-primary text-decoration-none small fw-bold">Lupa Sandi?</a>
        </div>

        <button type="submit" class="btn btn-pandu-primary w-100 py-3 mt-2 shadow">
          AUTENTIKASI SEKARANG <i class="fas fa-sign-in-alt ms-2"></i>
        </button>
      </form>

      <div class="login-footer text-center">
         <p class="small text-muted mb-0">&copy; {{ date('Y') }} <strong>PANDU K3</strong> System</p>
         <p class="smaller text-secondary opacity-50">Versi Terakhir: 1.0.0 (WIB)</p>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
