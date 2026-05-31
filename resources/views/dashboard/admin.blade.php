@extends('layouts.app')

@section('title', 'Admin Dashboard')
@section('page-title', 'Pusat Komando PANDU K3')

@section('breadcrumb')
  <li class="breadcrumb-item active">Dashboard Eksekutif</li>
@endsection

@section('content')
<div class="row g-3 g-md-4 mb-4">
  <div class="col-12 col-sm-6 col-xl-3">
    <div class="stat-card stat-card--danger shadow-sm border-0 h-100">
      <div class="stat-card-header">
        <span class="stat-card-label">Total Insiden</span>
        <div class="stat-card-icon shadow-sm"><i class="fas fa-circle-exclamation"></i></div>
      </div>
      <div class="stat-card-body">
        <h2 class="stat-card-number mb-0">{{ $stats['total_incidents'] }}</h2>
        <p class="smaller text-muted mt-2 mb-0">Kumulatif seluruh site</p>
      </div>
    </div>
  </div>
  <div class="col-12 col-sm-6 col-xl-3">
    <div class="stat-card stat-card--warning shadow-sm border-0 h-100">
      <div class="stat-card-header">
        <span class="stat-card-label">Temuan Bahaya</span>
        <div class="stat-card-icon shadow-sm"><i class="fas fa-triangle-exclamation"></i></div>
      </div>
      <div class="stat-card-body">
        <h2 class="stat-card-number mb-0">{{ $stats['total_hazards'] }}</h2>
        <p class="smaller text-muted mt-2 mb-0">Total laporan masuk</p>
      </div>
    </div>
  </div>
  <div class="col-12 col-sm-6 col-xl-3">
    <div class="stat-card stat-card--success shadow-sm border-0 h-100">
      <div class="stat-card-header">
        <span class="stat-card-label">Pengguna Sistem</span>
        <div class="stat-card-icon shadow-sm"><i class="fas fa-user-shield"></i></div>
      </div>
      <div class="stat-card-body">
        <h2 class="stat-card-number mb-0">{{ $stats['total_users'] }}</h2>
        <p class="smaller text-muted mt-2 mb-0">Akun aktif terdaftar</p>
      </div>
    </div>
  </div>
  <div class="col-12 col-sm-6 col-xl-3">
    <div class="stat-card stat-card--navy shadow-sm border-0 h-100">
      <div class="stat-card-header">
        <span class="stat-card-label">Entitas Bisnis</span>
        <div class="stat-card-icon shadow-sm"><i class="fas fa-building"></i></div>
      </div>
      <div class="stat-card-body">
        <h2 class="stat-card-number mb-0">{{ $stats['total_companies'] }}</h2>
        <p class="smaller text-muted mt-2 mb-0">Perusahaan dalam grup</p>
      </div>
    </div>
  </div>
</div>

<div class="row g-4">
  <div class="col-lg-8">
    <div class="pandu-card shadow-sm border-0 h-100">
      <div class="pandu-card-header bg-white border-bottom py-3">
        <h6 class="card-title-custom mb-0 fw-bold text-dark"><i class="fas fa-chart-line me-2 text-primary"></i> Performa Keselamatan Tahunan</h6>
      </div>
      <div class="pandu-card-body p-4">
        <div style="height: 300px;">
           <canvas id="mainChart"></canvas>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-4">
    <div class="pandu-card shadow-sm border-0 h-100">
      <div class="pandu-card-header bg-white border-bottom py-3">
        <h6 class="card-title-custom mb-0 fw-bold text-dark"><i class="fas fa-chart-pie me-2 text-primary"></i> Distribusi Kategori Bahaya</h6>
      </div>
      <div class="pandu-card-body p-4">
        <div style="height: 250px;">
           <canvas id="distChart"></canvas>
        </div>
        <div class="mt-4 border-top pt-3">
           <div class="d-grid gap-2">
              <a href="{{ route('analytics.index') }}" class="btn btn-sm btn-light border fw-bold text-primary py-2 shadow-sm">
                 LIHAT ANALITIK DETAIL <i class="fas fa-arrow-right ms-1"></i>
              </a>
           </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('mainChart').getContext('2d');
    new Chart(ctx, {
      type: 'line',
      data: {
        labels: ['Jan','Feb','Mar','Apr','Mei','Jun'],
        datasets: [{
          label: 'Insiden',
          data: [2, 1, 0, 3, 2, 1],
          borderColor: '#C0392B',
          backgroundColor: 'rgba(192,57,43,0.1)',
          fill: true,
          tension: 0.4,
          borderWidth: 3
        }, {
          label: 'Bahaya',
          data: [10, 15, 8, 20, 25, 18],
          borderColor: '#E67E22',
          backgroundColor: 'rgba(230,126,34,0.05)',
          fill: true,
          tension: 0.4,
          borderWidth: 3
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { position: 'top', align: 'end', labels: { usePointStyle: true, font: { weight: '600' } } } },
        scales: { y: { beginAtZero: true, grid: { borderDash: [5, 5] } }, x: { grid: { display: false } } }
      }
    });

    const ctx2 = document.getElementById('distChart').getContext('2d');
    new Chart(ctx2, {
      type: 'doughnut',
      data: {
        labels: ['Listrik', 'Mekanikal', 'Kimia', 'Lainnya'],
        datasets: [{
          data: [30, 40, 15, 15],
          backgroundColor: ['#F39C12', '#2C3E50', '#8E44AD', '#95A5A6'],
          borderWidth: 0
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '80%',
        plugins: { legend: { position: 'bottom', labels: { usePointStyle: true, font: { size: 10, weight: '600' } } } }
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
  .stat-card-icon { width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1rem; }
  .stat-card--danger .stat-card-icon { background: var(--color-danger-light); color: var(--color-danger); }
  .stat-card--warning .stat-card-icon { background: var(--color-warning-light); color: var(--color-warning); }
  .stat-card--success .stat-card-icon { background: var(--color-success-light); color: var(--color-success); }
  .stat-card--navy .stat-card-icon { background: #EBF5FB; color: var(--pandu-navy); }
  .stat-card-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; }
</style>
@endpush
