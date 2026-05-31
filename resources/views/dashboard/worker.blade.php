@extends('layouts.app')

@section('title', 'Worker Dashboard')
@section('page-title', 'Halo, ' . auth()->user()->name)

@section('breadcrumb')
  <li class="breadcrumb-item active">Beranda</li>
@endsection

@section('content')
<div class="row g-4 justify-content-center">
  <div class="col-md-6 col-lg-4">
    <div class="pandu-card bg-primary text-white p-4">
      <div class="d-flex align-items-center gap-3">
        <img src="{{ auth()->user()->photo ? asset('storage/'.auth()->user()->photo) : 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&background=fff&color=0D2137' }}" class="user-avatar" style="width: 60px; height: 60px;">
        <div>
          <h4 class="fw-bold mb-0 text-white">{{ auth()->user()->name }}</h4>
          <p class="mb-0 opacity-75 small">Shift Pagi · {{ auth()->user()->workArea->name ?? 'Area Kerja Belum Set' }}</p>
        </div>
      </div>
    </div>

    <div class="mb-4">
      <h5 class="section-title mb-3">Lapor Cepat</h5>
      <div class="d-grid gap-3">
        <a href="#" class="worker-action-btn bg-warning text-dark shadow-sm">
          <i class="fas fa-camera"></i>
          <span>LAPORKAN BAHAYA</span>
        </a>
        <a href="#" class="worker-action-btn bg-danger text-white shadow-sm">
          <i class="fas fa-circle-exclamation"></i>
          <span>LAPORKAN INSIDEN</span>
        </a>
      </div>
    </div>

    <div class="mb-4">
      <button class="btn-panic shadow-lg" id="panicButton">
        <i class="fas fa-exclamation-triangle me-2"></i> PANIC BUTTON
      </button>
    </div>

    <div class="pandu-card">
      <div class="pandu-card-header">
        <h6 class="card-title-custom mb-0">Laporan Saya (3 Terbaru)</h6>
      </div>
      <div class="pandu-card-body p-0">
        <div class="list-group list-group-flush small">
          <div class="list-group-item p-3">
             <div class="d-flex justify-content-between align-items-start">
               <div>
                 <span class="badge bg-light text-dark mb-1">HAZ-2025-001</span>
                 <p class="mb-0 fw-bold">Lantai Licin Area A</p>
               </div>
               <span class="status-badge status-open">Open</span>
             </div>
          </div>
          <div class="list-group-item p-3 text-center opacity-50">
            Belum ada laporan lainnya
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('panicButton').addEventListener('click', function() {
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
</script>
@endpush

@push('styles')
<style>
.worker-action-btn {
  display: flex; align-items: center; justify-content: center;
  gap: 12px; width: 100%;
  padding: 20px 24px; border-radius: var(--radius-lg);
  font-size: 1rem; font-weight: 700; letter-spacing: 0.3px;
  border: none; cursor: pointer; text-decoration: none;
  transition: var(--transition-base);
}
.worker-action-btn i { font-size: 1.5rem; }
.worker-action-btn:active { transform: scale(0.97); }

.bg-primary { background: var(--pandu-navy) !important; }
</style>
@endpush
