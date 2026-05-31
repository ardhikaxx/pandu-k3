@extends('layouts.app')

@section('title', 'HSE Manager Dashboard')
@section('page-title', 'Pusat Kendali HSE')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="#">Home</a></li>
  <li class="breadcrumb-item active">HSE Dashboard</li>
@endsection

@section('content')
<div class="row g-4 mb-4">
  <div class="col-md-3">
    <div class="pandu-card p-4">
      <div class="d-flex justify-content-between">
        <div>
          <p class="text-secondary small fw-bold text-uppercase mb-1">Bahaya (Open)</p>
          <h2 class="fw-bold mb-0">{{ $stats['open_hazards'] }}</h2>
        </div>
        <div class="icon-box bg-warning-soft text-warning">
          <i class="fas fa-triangle-exclamation"></i>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="pandu-card p-4">
      <div class="d-flex justify-content-between">
        <div>
          <p class="text-secondary small fw-bold text-uppercase mb-1">CAPA Pending</p>
          <h2 class="fw-bold mb-0">{{ $stats['pending_capa'] }}</h2>
        </div>
        <div class="icon-box bg-danger-soft text-danger">
          <i class="fas fa-list-check"></i>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="pandu-card p-4">
      <div class="d-flex justify-content-between">
        <div>
          <p class="text-secondary small fw-bold text-uppercase mb-1">Jadwal Inspeksi</p>
          <h2 class="fw-bold mb-0">{{ $stats['upcoming_inspections'] }}</h2>
        </div>
        <div class="icon-box bg-success-soft text-success">
          <i class="fas fa-clipboard-check"></i>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="pandu-card p-4">
      <div class="d-flex justify-content-between">
        <div>
          <p class="text-secondary small fw-bold text-uppercase mb-1">Sertifikat Expired</p>
          <h2 class="fw-bold mb-0">{{ $stats['expired_certificates'] }}</h2>
        </div>
        <div class="icon-box bg-dark text-white">
          <i class="fas fa-id-card-clip"></i>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row g-4">
  <div class="col-md-8">
    <div class="pandu-card">
      <div class="pandu-card-header">
        <h5 class="card-title-custom mb-0">Tren Insiden & Bahaya</h5>
      </div>
      <div class="pandu-card-body">
        <canvas id="mainChart" height="300"></canvas>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="pandu-card">
      <div class="pandu-card-header">
        <h5 class="card-title-custom mb-0">Distribusi Bahaya</h5>
      </div>
      <div class="pandu-card-body">
        <canvas id="distChart" height="300"></canvas>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
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
      tension: 0.4
    }, {
      label: 'Laporan Bahaya',
      data: [10, 15, 8, 20, 25, 18],
      borderColor: '#E67E22',
      backgroundColor: 'rgba(230,126,34,0.1)',
      fill: true,
      tension: 0.4
    }]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    plugins: { legend: { position: 'top' } }
  }
});

const ctx2 = document.getElementById('distChart').getContext('2d');
new Chart(ctx2, {
  type: 'doughnut',
  data: {
    labels: ['Listrik', 'Mekanikal', 'Kimia', 'Lainnya'],
    datasets: [{
      data: [30, 40, 15, 15],
      backgroundColor: ['#F39C12', '#2C3E50', '#8E44AD', '#95A5A6']
    }]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    cutout: '70%'
  }
});
</script>
@endpush

@push('styles')
<style>
  .bg-primary-soft { background: rgba(21, 101, 192, 0.1); }
</style>
@endpush
