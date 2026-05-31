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
</head>
<body>

<div class="auth-page">
  <!-- Left Panel — Branding -->
  <div class="auth-left text-white">
    <div class="text-center z-1 position-relative">
      <div class="logo-icon mx-auto mb-4" style="width: 80px; height: 80px; font-size: 36px;">
        <i class="fas fa-shield-halved"></i>
      </div>
      <h1 class="display-4 fw-bold mb-2">PANDU K3</h1>
      <p class="fs-5 opacity-75">Pusat Analisis & Navigasi Data Unggul K3</p>
      <div class="mt-5 text-start opacity-50 small">
        <p><i class="fas fa-check-circle me-2"></i> Sistem Manajemen K3 Industri Modern</p>
        <p><i class="fas fa-check-circle me-2"></i> Pelaporan Real-time & Analitik Data</p>
        <p><i class="fas fa-check-circle me-2"></i> Kepatuhan Standar SMK3 & ISO 45001</p>
      </div>
    </div>
  </div>

  <!-- Right Panel — Form -->
  <div class="auth-right">
    <div class="auth-card">
      <div class="mb-4">
        <h2 class="fw-bold text-dark">Selamat Datang</h2>
        <p class="text-secondary">Silakan masuk ke akun Anda</p>
      </div>

      @if($errors->any())
        <div class="alert alert-danger border-0 small">
          <ul class="mb-0">
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form action="{{ route('login') }}" method="POST">
        @csrf
        <div class="mb-3">
          <label for="email" class="form-label">Alamat Email</label>
          <div class="input-group">
            <span class="input-group-text bg-light border-end-0 text-secondary"><i class="fas fa-envelope"></i></span>
            <input type="email" class="form-control border-start-0" id="email" name="email" value="{{ old('email') }}" placeholder="name@company.com" required autofocus>
          </div>
        </div>

        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <div class="input-group">
            <span class="input-group-text bg-light border-end-0 text-secondary"><i class="fas fa-lock"></i></span>
            <input type="password" class="form-control border-start-0" id="password" name="password" placeholder="••••••••" required>
          </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="remember" id="remember">
            <label class="form-check-label text-secondary small" for="remember">
              Ingat Saya
            </label>
          </div>
          <a href="#" class="text-pandu-primary text-decoration-none small fw-semibold">Lupa Password?</a>
        </div>

        <button type="submit" class="btn btn-pandu-primary w-100 py-2">
          MASUK KE SISTEM <i class="fas fa-arrow-right ms-2"></i>
        </button>
      </form>

      <div class="mt-5 text-center small text-secondary">
        &copy; {{ date('Y') }} PANDU K3 System. v1.0.0
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
