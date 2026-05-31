@extends('layouts.app')

@section('title', 'Worker Dashboard')
@section('page-title', 'Halo, ' . auth()->user()->name)

@section('breadcrumb')
  <li class="breadcrumb-item active">Beranda</li>
@endsection

@section('content')
<div class="row g-4 justify-content-center">
  <div class="col-12 col-md-8 col-lg-6 col-xl-5">
    
    <!-- User Welcome Card -->
    <div class="pandu-card bg-navy text-white p-4 shadow-lg border-0 mb-4 overflow-hidden position-relative">
      <div class="z-1 position-relative">
         <div class="d-flex align-items-center gap-3">
           <img src="{{ auth()->user()->photo ? asset('storage/'.auth()->user()->photo) : 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&background=fff&color=0D2137' }}" class="rounded-circle border border-3 border-white-50 shadow-sm" style="width: 70px; height: 70px; object-fit: cover;">
           <div>
             <h4 class="fw-extrabold mb-0 text-white">{{ auth()->user()->name }}</h4>
             <p class="mb-0 opacity-75 small fw-medium"><i class="fas fa-location-dot me-1"></i> {{ auth()->user()->workArea->name ?? 'Area Kerja Belum Set' }}</p>
             <p class="smaller opacity-50 mb-0">ID: {{ auth()->user()->employee_id ?? 'N/A' }}</p>
           </div>
         </div>
      </div>
      <i class="fas fa-shield-halved position-absolute opacity-10" style="font-size: 150px; right: -20px; bottom: -30px;"></i>
    </div>

    <!-- Quick Actions -->
    <div class="mb-5">
      <h6 class="label-text text-muted mb-3 fw-bold"><i class="fas fa-bolt me-1 text-warning"></i> AKSES CEPAT PELAPORAN</h6>
      <div class="d-grid gap-3">
        <a href="{{ route('worker.hazard.create') }}" class="worker-action-btn bg-warning text-dark shadow-sm py-3 px-4 rounded-4 text-decoration-none">
          <div class="d-flex align-items-center justify-content-between w-100">
             <div class="d-flex align-items-center gap-3">
                <div class="icon-box bg-white bg-opacity-50 rounded-circle text-dark"><i class="fas fa-camera"></i></div>
                <div class="text-start">
                   <span class="fw-extrabold d-block">LAPOR BAHAYA</span>
                   <span class="smaller opacity-75">Kondisi/Tindakan Tidak Aman</span>
                </div>
             </div>
             <i class="fas fa-chevron-right opacity-50"></i>
          </div>
        </a>
        
        <a href="{{ route('worker.incident.create') }}" class="worker-action-btn bg-danger text-white shadow-sm py-3 px-4 rounded-4 text-decoration-none">
           <div class="d-flex align-items-center justify-content-between w-100">
              <div class="d-flex align-items-center gap-3">
                 <div class="icon-box bg-white bg-opacity-25 rounded-circle text-white"><i class="fas fa-circle-exclamation"></i></div>
                 <div class="text-start">
                    <span class="fw-extrabold d-block">LAPOR INSIDEN</span>
                    <span class="smaller opacity-75">Kecelakaan / Hampir Celaka</span>
                 </div>
              </div>
              <i class="fas fa-chevron-right opacity-50"></i>
           </div>
        </a>
      </div>
    </div>

    <!-- Panic Button Section -->
    <div class="mb-5 text-center px-3">
      <p class="smaller text-muted mb-2 fw-bold text-uppercase">Hanya untuk Keadaan Darurat Nyata</p>
      <button class="btn-panic shadow-lg w-100 py-3 rounded-4" id="panicButton">
        <i class="fas fa-exclamation-triangle me-2"></i> EMERGENCY PANIC
      </button>
    </div>

    <!-- Recent Activity Card -->
    <div class="pandu-card shadow-sm border-0 mb-4">
      <div class="pandu-card-header bg-white border-bottom py-3">
        <h6 class="card-title-custom mb-0 fw-bold text-dark"><i class="fas fa-clock-rotate-left me-2 text-primary"></i> Laporan Saya (3 Terbaru)</h6>
      </div>
      <div class="pandu-card-body p-0">
        <div class="list-group list-group-flush">
          @forelse($recent_hazards as $report)
          <div class="list-group-item p-3 border-0 border-bottom">
             <div class="d-flex justify-content-between align-items-start">
               <div>
                 <span class="doc-number smaller mb-1" style="font-size: 10px;">{{ $report->report_number }}</span>
                 <p class="mb-0 fw-bold text-dark small">{{ Str::limit($report->title, 40) }}</p>
               </div>
               <span class="status-badge status-{{ $report->status }}" style="font-size: 9px; padding: 2px 8px;">{{ ucfirst($report->status) }}</span>
             </div>
          </div>
          @empty
          <div class="p-4 text-center opacity-50 small fw-medium">
             <i class="fas fa-clipboard-check mb-2 d-block fs-4"></i>
             Belum ada laporan terbaru.
          </div>
          @endforelse
        </div>
        @if($recent_hazards->count() > 0)
        <div class="p-2 text-center bg-light-subtle rounded-bottom border-top">
           <a href="{{ route('worker.hazard.index') }}" class="smaller fw-bold text-decoration-none">LIHAT SEMUA LAPORAN</a>
        </div>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
  document.getElementById('panicButton')?.addEventListener('click', function() {
    Swal.fire({
      title: '🚨 AKTIFKAN DARURAT?',
      html: 'Peringatan darurat akan segera dikirim ke Tim HSE dan Keamanan. Gunakan hanya jika benar-benar terjadi keadaan darurat.',
      icon: 'error',
      showCancelButton: true,
      confirmButtonColor: '#C0392B',
      confirmButtonText: 'YA, AKTIFKAN!',
      cancelButtonText: 'Batal',
      customClass: { popup: 'pandu-swal-popup' }
    }).then((result) => {
      if (result.isConfirmed) {
        fetch('{{ route("worker.panic.trigger") }}', {
          method: 'POST',
          headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
          }
        })
        .then(response => response.json())
        .then(data => {
          if (data.status === 'success') {
            Swal.fire({
              title: 'TERKIRIM!',
              text: data.message,
              icon: 'success',
              confirmButtonColor: '#1A7A4A'
            });
          }
        })
        .catch(error => {
          Swal.fire('Gagal', 'Terjadi kesalahan sistem.', 'error');
        });
      }
    });
  });
});
</script>
@endpush

@push('styles')
<style>
.worker-action-btn { transition: all 0.3s ease; border: 1px solid rgba(0,0,0,0.05); }
.worker-action-btn:active { transform: scale(0.96); opacity: 0.9; }
.bg-navy { background-color: var(--pandu-navy) !important; }
.icon-box { width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; }
</style>
@endpush
