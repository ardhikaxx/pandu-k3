{{-- resources/views/layouts/partials/sidebar.blade.php --}}

<!-- Logo Area -->
<div class="sidebar-logo">
  <div class="logo-icon">
    <i class="fas fa-shield-halved"></i>
  </div>
  <div class="logo-text">
    <span class="logo-brand">PANDU K3</span>
    <span class="logo-sub">HSE Management System</span>
  </div>
</div>

<!-- User Info -->
<div class="sidebar-user">
  <img src="{{ auth()->user()->photo ? asset('storage/'.auth()->user()->photo) : 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&background=0D2137&color=fff' }}" class="user-avatar" alt="">
  <div class="user-info">
    <span class="user-name">{{ auth()->user()->name }}</span>
    <span class="badge-role-{{ auth()->user()->role }}">
      {{ ucfirst(str_replace('_', ' ', auth()->user()->role)) }}
    </span>
  </div>
</div>

<!-- Navigation -->
<nav class="sidebar-nav">
  @php $role = auth()->user()->role; @endphp

  @if($role === 'super_admin')
    <div class="nav-group-label">UTAMA</div>
    <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
      <span class="nav-icon"><i class="fas fa-gauge-high"></i></span>
      <span class="nav-text">Dashboard</span>
    </a>
    <div class="nav-group-label">SISTEM</div>
    <a href="{{ route('admin.users.index') }}" class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
      <span class="nav-icon"><i class="fas fa-users"></i></span>
      <span class="nav-text">Pengguna</span>
    </a>
    <a href="{{ route('admin.activity.index') }}" class="nav-item {{ request()->routeIs('admin.activity.*') ? 'active' : '' }}">
      <span class="nav-icon"><i class="fas fa-clock-rotate-left"></i></span>
      <span class="nav-text">Audit Trail</span>
    </a>
    <a href="{{ route('analytics.index') }}" class="nav-item {{ request()->routeIs('analytics.*') ? 'active' : '' }}">
      <span class="nav-icon"><i class="fas fa-chart-pie"></i></span>
      <span class="nav-text">Analitik K3</span>
    </a>
  @elseif($role === 'hse_manager')
    <div class="nav-group-label">UTAMA</div>
    <a href="{{ route('hse.dashboard') }}" class="nav-item {{ request()->routeIs('hse.dashboard') ? 'active' : '' }}">
      <span class="nav-icon"><i class="fas fa-gauge-high"></i></span>
      <span class="nav-text">Dashboard</span>
    </a>
    <a href="{{ route('analytics.index') }}" class="nav-item {{ request()->routeIs('analytics.*') ? 'active' : '' }}">
      <span class="nav-icon"><i class="fas fa-chart-pie"></i></span>
      <span class="nav-text">Analitik K3</span>
    </a>
    <div class="nav-group-label">OPERASIONAL</div>
    <a href="{{ route('hse.incident.index') }}" class="nav-item {{ request()->routeIs('hse.incident.*') ? 'active' : '' }}">
      <span class="nav-icon"><i class="fas fa-circle-exclamation"></i></span>
      <span class="nav-text">Investigasi Insiden</span>
    </a>
    <a href="{{ route('hse.hiradc.index') }}" class="nav-item {{ request()->routeIs('hse.hiradc.*') ? 'active' : '' }}">
      <span class="nav-icon"><i class="fas fa-shield-virus"></i></span>
      <span class="nav-text">HIRADC</span>
    </a>
    <a href="{{ route('hse.capa.index') }}" class="nav-item {{ request()->routeIs('hse.capa.*') ? 'active' : '' }}">
      <span class="nav-icon"><i class="fas fa-check-to-slot"></i></span>
      <span class="nav-text">Tindakan CAPA</span>
    </a>
    <a href="{{ route('hse.inspection.index') }}" class="nav-item {{ request()->routeIs('hse.inspection.*') ? 'active' : '' }}">
      <span class="nav-icon"><i class="fas fa-clipboard-list"></i></span>
      <span class="nav-text">Inspeksi</span>
    </a>
    <a href="{{ route('hse.audit.index') }}" class="nav-item {{ request()->routeIs('hse.audit.*') ? 'active' : '' }}">
      <span class="nav-icon"><i class="fas fa-magnifying-glass-chart"></i></span>
      <span class="nav-text">Audit K3</span>
    </a>
    <a href="{{ route('hse.permit.index') }}" class="nav-item {{ request()->routeIs('hse.permit.*') ? 'active' : '' }}">
      <span class="nav-icon"><i class="fas fa-file-contract"></i></span>
      <span class="nav-text">Izin Kerja (PTW)</span>
    </a>
    <div class="nav-group-label">KEPATUHAN</div>
    <a href="{{ route('hse.sop.index') }}" class="nav-item {{ request()->routeIs('hse.sop.*') ? 'active' : '' }}">
      <span class="nav-icon"><i class="fas fa-book"></i></span>
      <span class="nav-text">SOP K3</span>
    </a>
    <a href="{{ route('hse.certificate.index') }}" class="nav-item {{ request()->routeIs('hse.certificate.*') ? 'active' : '' }}">
      <span class="nav-icon"><i class="fas fa-id-card"></i></span>
      <span class="nav-text">Sertifikat</span>
    </a>
    <a href="{{ route('hse.training.index') }}" class="nav-item {{ request()->routeIs('hse.training.*') ? 'active' : '' }}">
      <span class="nav-icon"><i class="fas fa-graduation-cap"></i></span>
      <span class="nav-text">Pelatihan</span>
    </a>
  @elseif($role === 'supervisor')
    <div class="nav-group-label">UTAMA</div>
    <a href="{{ route('supervisor.dashboard') }}" class="nav-item {{ request()->routeIs('supervisor.dashboard') ? 'active' : '' }}">
      <span class="nav-icon"><i class="fas fa-gauge-high"></i></span>
      <span class="nav-text">Dashboard</span>
    </a>
    <div class="nav-group-label">PENGAWASAN</div>
    <a href="{{ route('supervisor.hazard.index') }}" class="nav-item {{ request()->routeIs('supervisor.hazard.*') ? 'active' : '' }}">
      <span class="nav-icon"><i class="fas fa-triangle-exclamation"></i></span>
      <span class="nav-text">Verifikasi Bahaya</span>
    </a>
    <a href="{{ route('supervisor.inspection.index') }}" class="nav-item {{ request()->routeIs('supervisor.inspection.*') ? 'active' : '' }}">
      <span class="nav-icon"><i class="fas fa-clipboard-check"></i></span>
      <span class="nav-text">Inspeksi Harian</span>
    </a>
    <a href="{{ route('supervisor.capa.index') }}" class="nav-item {{ request()->routeIs('supervisor.capa.*') ? 'active' : '' }}">
      <span class="nav-icon"><i class="fas fa-tasks"></i></span>
      <span class="nav-text">Tugas CAPA</span>
    </a>
    <a href="{{ route('supervisor.toolbox.index') }}" class="nav-item {{ request()->routeIs('supervisor.toolbox.*') ? 'active' : '' }}">
      <span class="nav-icon"><i class="fas fa-people-group"></i></span>
      <span class="nav-text">Toolbox Meeting</span>
    </a>
    <a href="{{ route('supervisor.apd.index') }}" class="nav-item {{ request()->routeIs('supervisor.apd.*') ? 'active' : '' }}">
      <span class="nav-icon"><i class="fas fa-helmet-safety"></i></span>
      <span class="nav-text">Inventaris APD</span>
    </a>
  @elseif($role === 'worker')
    <div class="nav-group-label">UTAMA</div>
    <a href="{{ route('worker.dashboard') }}" class="nav-item {{ request()->routeIs('worker.dashboard') ? 'active' : '' }}">
      <span class="nav-icon"><i class="fas fa-gauge-high"></i></span>
      <span class="nav-text">Beranda</span>
    </a>
    <div class="nav-group-label">LAPORAN SAYA</div>
    <a href="{{ route('worker.hazard.index') }}" class="nav-item {{ request()->routeIs('worker.hazard.*') ? 'active' : '' }}">
      <span class="nav-icon"><i class="fas fa-camera"></i></span>
      <span class="nav-text">Temuan Bahaya</span>
    </a>
    <a href="{{ route('worker.incident.index') }}" class="nav-item {{ request()->routeIs('worker.incident.*') ? 'active' : '' }}">
      <span class="nav-icon"><i class="fas fa-circle-exclamation"></i></span>
      <span class="nav-text">Lapor Insiden</span>
    </a>
    <a href="{{ route('worker.permit.index') }}" class="nav-item {{ request()->routeIs('worker.permit.*') ? 'active' : '' }}">
      <span class="nav-icon"><i class="fas fa-file-signature"></i></span>
      <span class="nav-text">Izin Kerja (PTW)</span>
    </a>
  @endif

</nav>

<!-- Sidebar Footer -->
<div class="sidebar-footer">
  <form action="{{ route('logout') }}" method="POST">
    @csrf
    <button type="submit" class="sidebar-footer-btn text-danger border-0 bg-transparent w-100 text-start">
      <i class="fas fa-right-from-bracket"></i> Logout
    </button>
  </form>
</div>
