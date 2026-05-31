@extends('layouts.app')

@section('title', 'HSE Dashboard')
@section('page-title', 'Pusat Operasional HSE')

@section('breadcrumb')
  <li class="breadcrumb-item active">Dashboard HSE</li>
@endsection

@section('content')
<div class="row g-3 g-md-4 mb-4">
  <div class="col-12 col-sm-6 col-xl-3">
    <div class="stat-card stat-card--warning shadow-sm border-0 h-100">
      <div class="stat-card-header">
        <span class="stat-card-label">Bahaya Aktif</span>
        <div class="stat-card-icon shadow-sm"><i class="fas fa-triangle-exclamation"></i></div>
      </div>
      <div class="stat-card-body">
        <h2 class="stat-card-number mb-0">{{ $stats['open_hazards'] }}</h2>
        <p class="smaller text-muted mt-2 mb-0">Laporan belum diverifikasi</p>
      </div>
    </div>
  </div>
  <div class="col-12 col-sm-6 col-xl-3">
    <div class="stat-card stat-card--danger shadow-sm border-0 h-100">
      <div class="stat-card-header">
        <span class="stat-card-label">CAPA Menunggu</span>
        <div class="stat-card-icon shadow-sm"><i class="fas fa-list-check"></i></div>
      </div>
      <div class="stat-card-body">
        <h2 class="stat-card-number mb-0">{{ $stats['pending_capa'] }}</h2>
        <p class="smaller text-muted mt-2 mb-0">Butuh verifikasi penyelesaian</p>
      </div>
    </div>
  </div>
  <div class="col-12 col-sm-6 col-xl-3">
    <div class="stat-card stat-card--success shadow-sm border-0 h-100">
      <div class="stat-card-header">
        <span class="stat-card-label">Jadwal Inspeksi</span>
        <div class="stat-card-icon shadow-sm"><i class="fas fa-clipboard-list"></i></div>
      </div>
      <div class="stat-card-body">
        <h2 class="stat-card-number mb-0">{{ $stats['upcoming_inspections'] }}</h2>
        <p class="smaller text-muted mt-2 mb-0">Sesi inspeksi mendatang</p>
      </div>
    </div>
  </div>
  <div class="col-12 col-sm-6 col-xl-3">
    <div class="stat-card stat-card--navy shadow-sm border-0 h-100">
      <div class="stat-card-header">
        <span class="stat-card-label">Sertifikat Expired</span>
        <div class="stat-card-icon shadow-sm text-danger"><i class="fas fa-id-card-clip"></i></div>
      </div>
      <div class="stat-card-body">
        <h2 class="stat-card-number mb-0 text-danger">{{ $stats['expired_certificates'] }}</h2>
        <p class="smaller text-muted mt-2 mb-0">Segera lakukan pembaruan</p>
      </div>
    </div>
  </div>
</div>

<div class="row g-4">
  <div class="col-lg-12">
    <div class="pandu-card shadow-sm border-0">
      <div class="pandu-card-header bg-white border-bottom py-3">
         <h6 class="card-title-custom mb-0 fw-bold text-dark"><i class="fas fa-chart-column me-2 text-primary"></i> Pantauan Aktivitas K3 Perusahaan</h6>
      </div>
      <div class="pandu-card-body p-4">
         <div style="height: 350px;">
            <canvas id="hseMainChart"></canvas>
         </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('hseMainChart').getContext('2d');
    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4'],
        datasets: [{
          label: 'Laporan Bahaya',
          data: [15, 22, 10, 25],
          backgroundColor: '#F39C12',
          borderRadius: 6
        }, {
          label: 'Tindakan Selesai',
          data: [10, 18, 12, 20],
          backgroundColor: '#1A7A4A',
          borderRadius: 6
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { position: 'top', align: 'end', labels: { usePointStyle: true, font: { weight: '600' } } } },
        scales: { y: { beginAtZero: true, grid: { borderDash: [5, 5] } }, x: { grid: { display: false } } }
      }
    });
});
</script>
@endpush

@push('styles')
<style>
  .stat-card { background: #fff; border-radius: 16px; padding: 20px; position: relative; overflow: hidden; transition: all 0.3s; }
  .stat-card:hover { transform: translateY(-5px); }
  .stat-card::before { content: ''; position: absolute; top: 0; left: 0; width: 4px; height: 100%; }
  .stat-card--danger::before { background: var(--color-danger); }
  .stat-card--warning::before { background: var(--color-warning); }
  .stat-card--success::before { background: var(--color-success); }
  .stat-card--navy::before { background: var(--pandu-navy); }
  .stat-card-label { font-size: 0.7rem; font-weight: 800; text-transform: uppercase; color: var(--gray-500); letter-spacing: 0.5px; }
  .stat-card-number { font-size: 2rem; font-weight: 800; color: var(--gray-900); }
  .stat-card-icon { width: 42px; height: 42px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; }
  .stat-card--danger .stat-card-icon { background: var(--color-danger-light); color: var(--color-danger); }
  .stat-card--warning .stat-card-icon { background: var(--color-warning-light); color: var(--color-warning); }
  .stat-card--success .stat-card-icon { background: var(--color-success-light); color: var(--color-success); }
  .stat-card--navy .stat-card-icon { background: #EBF5FB; color: var(--pandu-navy); }
  .stat-card-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; }
</style>
@endpush
