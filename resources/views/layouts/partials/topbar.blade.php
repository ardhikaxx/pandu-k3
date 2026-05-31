{{-- resources/views/layouts/partials/topbar.blade.php --}}

<!-- Left: Toggle + Breadcrumb -->
<div class="d-flex align-items-center gap-3">
  <button class="topbar-toggle" id="sidebarToggle">
    <i class="fas fa-bars"></i>
  </button>
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb mb-0 pandu-breadcrumb">
      @yield('breadcrumb')
    </ol>
  </nav>
</div>

<!-- Right: Actions -->
<div class="topbar-actions">
  <!-- Search -->
  <div class="topbar-search d-none d-md-flex">
    <i class="fas fa-search"></i>
    <input type="text" placeholder="Cari dokumen, laporan...">
  </div>

  <!-- Notifications -->
  <div class="dropdown">
    <button class="topbar-btn position-relative" data-bs-toggle="dropdown">
      <i class="fas fa-bell"></i>
      @if(auth()->user()->unreadNotifications->count() > 0)
        <span class="notif-dot">{{ auth()->user()->unreadNotifications->count() }}</span>
      @endif
    </button>
    <div class="dropdown-menu dropdown-menu-end shadow border-0 mt-2 p-0" style="width: 320px;">
       <div class="p-3 border-bottom d-flex justify-content-between align-items-center">
          <h6 class="mb-0 fw-bold">Notifikasi</h6>
          @if(auth()->user()->unreadNotifications->count() > 0)
            <form action="{{ route('notifications.read') }}" method="POST">
               @csrf
               <button type="submit" class="btn btn-link p-0 smaller text-decoration-none">Tandai Dibaca</button>
            </form>
          @endif
       </div>
       <div class="notif-list" style="max-height: 350px; overflow-y: auto;">
          @forelse(auth()->user()->unreadNotifications->take(5) as $notif)
             <a href="#" class="dropdown-item p-3 border-bottom text-wrap">
                <div class="d-flex gap-3">
                   <div class="icon-box-sm bg-primary-soft text-primary rounded-circle">
                      <i class="fas fa-info-circle"></i>
                   </div>
                   <div>
                      <p class="mb-0 small fw-bold">{{ $notif->data['title'] ?? 'Pembaruan Sistem' }}</p>
                      <p class="mb-0 smaller text-secondary">{{ $notif->data['message'] ?? 'Ada pembaruan pada data Anda.' }}</p>
                      <span class="smaller text-muted">{{ $notif->created_at->diffForHumans() }}</span>
                   </div>
                </div>
             </a>
          @empty
             <div class="p-4 text-center text-secondary small">Tidak ada notifikasi baru.</div>
          @endforelse
       </div>
       <div class="p-2 text-center bg-light rounded-bottom">
          <a href="{{ route('notifications.index') }}" class="smaller fw-bold text-decoration-none">Lihat Semua</a>
       </div>
    </div>
  </div>

  <!-- User Dropdown -->
  <div class="dropdown">
    <button class="topbar-user-btn" data-bs-toggle="dropdown">
      <img src="{{ auth()->user()->photo ? asset('storage/'.auth()->user()->photo) : 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&background=0D2137&color=fff' }}" class="topbar-avatar" alt="">
      <span class="topbar-username d-none d-md-inline">{{ auth()->user()->name }}</span>
      <i class="fas fa-chevron-down ms-1 small"></i>
    </button>
    <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2 p-2">
      <li><a class="dropdown-item rounded p-2" href="#"><i class="fas fa-user-circle me-2"></i> Profil Saya</a></li>
      <li><a class="dropdown-item rounded p-2" href="#"><i class="fas fa-gear me-2"></i> Pengaturan</a></li>
      <li><hr class="dropdown-divider"></li>
      <li>
        <form action="{{ route('logout') }}" method="POST">
          @csrf
          <button type="submit" class="dropdown-item rounded p-2 text-danger">
            <i class="fas fa-right-from-bracket me-2"></i> Logout
          </button>
        </form>
      </li>
    </ul>
  </div>
</div>
