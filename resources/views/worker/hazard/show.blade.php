@extends('layouts.app')

@section('title', 'Detail Laporan Bahaya')
@section('page-title', 'Detail Laporan')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('worker.dashboard') }}">Beranda</a></li>
  <li class="breadcrumb-item"><a href="{{ route('worker.hazard.index') }}">Laporan Bahaya</a></li>
  <li class="breadcrumb-item active">{{ $hazardReport->report_number }}</li>
@endsection

@section('content')
<div class="row g-4">
  <div class="col-lg-8">
    <!-- Main Info Card -->
    <div class="pandu-card">
      <div class="pandu-card-header">
        <div class="d-flex align-items-center gap-3">
           <span class="doc-number">{{ $hazardReport->report_number }}</span>
           <span class="status-badge status-{{ $hazardReport->status }}">{{ ucfirst(str_replace('_', ' ', $hazardReport->status)) }}</span>
        </div>
      </div>
      <div class="pandu-card-body">
        <h3 class="fw-bold mb-4">{{ $hazardReport->title }}</h3>

        <div class="row mb-4 small">
          <div class="col-md-4">
            <p class="text-secondary label-text mb-1">TIPE BAHAYA</p>
            <p class="fw-bold mb-0 text-dark">{{ ucfirst(str_replace('_', ' ', $hazardReport->hazard_type)) }}</p>
          </div>
          <div class="col-md-4">
            <p class="text-secondary label-text mb-1">KATEGORI</p>
            <p class="fw-bold mb-0 text-dark">{{ ucfirst($hazardReport->category) }}</p>
          </div>
          <div class="col-md-4">
            <p class="text-secondary label-text mb-1">RISIKO</p>
            <span class="risk-badge risk-{{ $hazardReport->severity }}">{{ ucfirst($hazardReport->severity) }}</span>
          </div>
        </div>

        <div class="mb-4">
          <p class="text-secondary label-text mb-1">DESKRIPSI TEMUAN</p>
          <div class="p-3 bg-light rounded border">
            {{ $hazardReport->description }}
          </div>
        </div>

        <div>
          <p class="text-secondary label-text mb-2">FOTO TEMUAN</p>
          <div class="photo-preview-grid">
            @foreach($hazardReport->photos as $photo)
              <div class="photo-preview-item">
                <img src="{{ asset('storage/'.$photo) }}" class="img-thumbnail" style="cursor: pointer;" onclick="window.open(this.src)">
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-4">
    <!-- Metadata Card -->
    <div class="pandu-card">
      <div class="pandu-card-header">
        <h6 class="card-title-custom mb-0">Informasi Lokasi & Waktu</h6>
      </div>
      <div class="pandu-card-body">
        <div class="mb-3">
          <p class="text-secondary label-text mb-1">AREA KERJA</p>
          <p class="fw-bold mb-0 text-dark"><i class="fas fa-location-dot me-2 text-primary"></i> {{ $hazardReport->workArea->name }}</p>
        </div>
        <div class="mb-3">
          <p class="text-secondary label-text mb-1">DETAIL LOKASI</p>
          <p class="fw-bold mb-0 text-dark">{{ $hazardReport->location_detail }}</p>
        </div>
        <div class="mb-3">
          <p class="text-secondary label-text mb-1">WAKTU LAPOR</p>
          <p class="fw-bold mb-0 text-dark"><i class="fas fa-calendar-alt me-2 text-secondary"></i> {{ $hazardReport->reported_at->format('d M Y, H:i') }} WIB</p>
        </div>
        <div class="mb-0">
          <p class="text-secondary label-text mb-1">DILAPORKAN OLEH</p>
          <div class="d-flex align-items-center gap-2">
            <img src="https://ui-avatars.com/api/?name={{ urlencode($hazardReport->reporter->name) }}&background=E9ECEF&color=495057" class="rounded-circle" style="width: 24px; height: 24px;">
            <p class="fw-bold mb-0 text-dark">{{ $hazardReport->reporter->name }}</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Timeline Card (Placeholder) -->
    <div class="pandu-card">
      <div class="pandu-card-header">
        <h6 class="card-title-custom mb-0">Riwayat Laporan</h6>
      </div>
      <div class="pandu-card-body p-0">
        <div class="p-3 border-bottom">
           <div class="d-flex gap-3">
              <div class="text-success small mt-1"><i class="fas fa-check-circle"></i></div>
              <div>
                <p class="mb-0 fw-bold small">Laporan Diterima</p>
                <p class="mb-0 text-secondary smaller">{{ $hazardReport->reported_at->format('d M Y, H:i') }} WIB</p>
              </div>
           </div>
        </div>
        <div class="p-3 opacity-50">
           <div class="d-flex gap-3">
              <div class="text-secondary small mt-1"><i class="far fa-circle"></i></div>
              <div>
                <p class="mb-0 fw-bold small">Verifikasi Supervisor</p>
                <p class="mb-0 text-secondary smaller">Menunggu tindakan...</p>
              </div>
           </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('styles')
<style>
.smaller { font-size: 0.75rem; }
.photo-preview-grid {
  display: grid; grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
  gap: 12px;
}
.photo-preview-item {
  border-radius: var(--radius-md); overflow: hidden;
  aspect-ratio: 1; border: 1px solid var(--gray-200);
}
.photo-preview-item img {
  width: 100%; height: 100%; object-fit: cover;
}
</style>
@endpush
