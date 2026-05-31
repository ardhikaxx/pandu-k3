<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Dashboard') — PANDU K3</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome 6 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="{{ asset('css/pandu.css') }}">

  @stack('styles')
</head>
<body>

<div class="pandu-wrapper">

  <!-- Sidebar Overlay (Mobile) -->
  <div class="sidebar-overlay" id="sidebarOverlay"></div>

  <!-- SIDEBAR -->
  <aside class="pandu-sidebar" id="panduSidebar">
    @include('layouts.partials.sidebar')
  </aside>

  <!-- MAIN -->
  <div class="pandu-main">

    <!-- TOP BAR -->
    <header class="pandu-topbar">
      @include('layouts.partials.topbar')
    </header>

    <!-- CONTENT -->
    <main class="pandu-content fade-in-up">
      <!-- Page Header -->
      <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
          <h1 class="page-title mb-1">@yield('page-title')</h1>
        </div>
        <div class="d-flex gap-2">
          @yield('page-actions')
        </div>
      </div>

      @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="pandu-footer">
      <span>© {{ date('Y') }} PANDU K3 — Sistem Manajemen K3 Industri</span>
      <span>v1.0.0</span>
    </footer>

  </div><!-- /pandu-main -->

</div><!-- /pandu-wrapper -->

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

<script>
// Sidebar Toggle
const sidebarEl = document.getElementById('panduSidebar');
const overlayEl = document.getElementById('sidebarOverlay');
const toggleBtn = document.getElementById('sidebarToggle');

toggleBtn?.addEventListener('click', () => {
  sidebarEl.classList.toggle('show');
  overlayEl.classList.toggle('show');
});
overlayEl?.addEventListener('click', () => {
  sidebarEl.classList.remove('show');
  overlayEl.classList.remove('show');
});

// SweetAlert Flash Messages
@if(session('success'))
  Swal.fire({ icon:'success', title:'Berhasil!', text:@json(session('success')), timer:2500, timerProgressBar:true, showConfirmButton:false, customClass:{popup:'pandu-swal-popup'} });
@endif
@if(session('error'))
  Swal.fire({ icon:'error', title:'Gagal!', text:@json(session('error')), confirmButtonColor:'#C0392B', customClass:{popup:'pandu-swal-popup'} });
@endif
@if(session('warning'))
  Swal.fire({ icon:'warning', title:'Perhatian!', text:@json(session('warning')), confirmButtonColor:'#E67E22', customClass:{popup:'pandu-swal-popup'} });
@endif
</script>

@stack('scripts')

</body>
</html>
