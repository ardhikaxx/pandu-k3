@extends('layouts.app')

@section('title', 'Supervisor Dashboard')
@section('page-title', 'Pusat Pengawasan Divisi')

@section('breadcrumb')
  <li class="breadcrumb-item active">Dashboard Supervisor</li>
@endsection

@section('content')
<div class="row g-3 g-md-4 mb-4">
  <div class="col-12 col-md-4">
    <div class="stat-card stat-card--warning shadow-sm border-0 h-100">
      <div class="stat-card-header">
        <span class="stat-card-label">Perlu Verifikasi</span>
        <div class="stat-card-icon shadow-sm"><i class="fas fa-user-check"></i></div>
      </div>
      <div class="stat-card-body">
        <h2 class="stat-card-number mb-0">{{ $stats['my_verifications'] }}</h2>
        <p class="smaller text-muted mt-2 mb-0">Laporan bahaya dari pekerja</p>
      </div>
    </div>
  </div>
  <div class="col-12 col-md-4">
    <div class="stat-card stat-card--danger shadow-sm border-0 h-100">
      <div class="stat-card-header">
        <span class="stat-card-label">Tugas CAPA</span>
        <div class="stat-card-icon shadow-sm"><i class="fas fa-tasks"></i></div>
      </div>
      <div class="stat-card-body">
        <h2 class="stat-card-number mb-0">{{ $stats['my_capa'] }}</h2>
        <p class="smaller text-muted mt-2 mb-0">Tindakan perbaikan aktif</p>
      </div>
    </div>
  </div>
  <div class="col-12 col-md-4">
    <div class="stat-card stat-card--success shadow-sm border-0 h-100">
      <div class="stat-card-header">
        <span class="stat-card-label">Jadwal Inspeksi</span>
        <div class="stat-card-icon shadow-sm"><i class="fas fa-clipboard-check"></i></div>
      </div>
      <div class="stat-card-body">
        <h2 class="stat-card-number mb-0">{{ $stats['my_inspections'] }}</h2>
        <p class="smaller text-muted mt-2 mb-0">Sesi inspeksi Anda</p>
      </div>
    </div>
  </div>
</div>

<div class="row g-4">
  <div class="col-lg-8">
     <div class="pandu-card shadow-sm border-0 h-100">
        <div class="pandu-card-header bg-white border-bottom py-3">
           <h6 class="card-title-custom mb-0 fw-bold text-dark"><i class="fas fa-bullhorn me-2 text-primary"></i> Pengingat Keselamatan Hari Ini</h6>
        </div>
        <div class="pandu-card-body p-4">
           <div class="alert alert-info border-0 shadow-sm d-flex gap-3 align-items-center mb-4 p-3">
              <i class="fas fa-lightbulb fs-4 opacity-50"></i>
              <div>
                 <p class="mb-0 fw-bold small">Jangan lupa lakukan Toolbox Meeting!</p>
                 <p class="mb-0 smaller opacity-75">Sesuai SOP, briefing harian wajib dilakukan sebelum memulai shift.</p>
              </div>
           </div>
           
           <div class="list-group list-group-flush small">
              <div class="list-group-item px-0 py-3 border-0 border-bottom">
                 <div class="d-flex justify-content-between">
                    <p class="mb-0 fw-bold text-dark">Lengkapi Inspeksi Mingguan</p>
                    <span class="text-danger fw-bold">Due Today</span>
                 </div>
              </div>
              <div class="list-group-item px-0 py-3 border-0">
                 <div class="d-flex justify-content-between">
                    <p class="mb-0 fw-bold text-dark">Review Sertifikat Tim</p>
                    <span class="text-muted">Next 3 days</span>
                 </div>
              </div>
           </div>
        </div>
     </div>
  </div>
  
  <div class="col-lg-4">
     <div class="pandu-card shadow-sm border-0 h-100 bg-navy text-white">
        <div class="pandu-card-body p-4 d-flex flex-column justify-content-center text-center">
           <div class="mb-3">
              <i class="fas fa-shield-halved fa-4x opacity-25"></i>
           </div>
           <h4 class="fw-extrabold mb-1">Safety First</h4>
           <p class="small opacity-75 mb-4 px-3">Kepemimpinan Anda menentukan keselamatan seluruh anggota tim lapangan.</p>
           <div class="d-grid gap-2">
              <a href="{{ route('supervisor.toolbox.create') }}" class="btn btn-warning fw-bold py-2 shadow">
                 <i class="fas fa-plus me-1"></i> CATAT TBM SEKARANG
              </a>
           </div>
        </div>
     </div>
  </div>
</div>
@endsection

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
  .stat-card-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; }
  .bg-navy { background-color: var(--pandu-navy) !important; }
</style>
@endpush
