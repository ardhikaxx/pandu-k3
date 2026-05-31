@extends('layouts.app')

@section('title', 'Detail Insiden')
@section('page-title', 'Detail Laporan Insiden')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('worker.dashboard') }}">Beranda</a></li>
  <li class="breadcrumb-item"><a href="{{ route('worker.incident.index') }}">Laporan Insiden</a></li>
  <li class="breadcrumb-item active">{{ $incidentReport->report_number }}</li>
@endsection

@section('content')
<div class="row g-4">
  <div class="col-lg-8">
    <div class="pandu-card">
      <div class="pandu-card-header">
        <div class="d-flex align-items-center gap-3">
           <span class="doc-number">{{ $incidentReport->report_number }}</span>
           <span class="status-badge status-{{ $incidentReport->status }}">{{ ucfirst(str_replace('_', ' ', $incidentReport->status)) }}</span>
        </div>
      </div>
      <div class="pandu-card-body">
        <h3 class="fw-bold mb-4">{{ $incidentReport->title }}</h3>

        <div class="row mb-4 small">
          <div class="col-md-4">
            <p class="text-secondary label-text mb-1">TIPE INSIDEN</p>
            <p class="fw-bold mb-0 text-dark">{{ ucfirst(str_replace('_', ' ', $incidentReport->incident_type)) }}</p>
          </div>
          <div class="col-md-4">
            <p class="text-secondary label-text mb-1">KEPARAHAN</p>
            <p class="fw-bold mb-0 text-dark">{{ ucfirst($incidentReport->severity_classification) }}</p>
          </div>
          <div class="col-md-4">
            <p class="text-secondary label-text mb-1">KORBAN</p>
            <p class="fw-bold mb-0 text-dark">{{ $incidentReport->victim_name ?? 'Tidak ada korban jiwa/luka' }}</p>
          </div>
        </div>

        <div class="mb-4">
          <p class="text-secondary label-text mb-1">KRONOLOGI KEJADIAN</p>
          <div class="p-3 bg-light rounded border">
            {{ $incidentReport->description }}
          </div>
        </div>

        <div>
          <p class="text-secondary label-text mb-2">FOTO BUKTI</p>
          <div class="row g-2">
            @foreach($incidentReport->photos as $photo)
              <div class="col-md-4">
                <img src="{{ asset('storage/'.$photo) }}" class="img-fluid rounded border shadow-sm" style="cursor: pointer;" onclick="window.open(this.src)">
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-4">
    <div class="pandu-card mb-4">
      <div class="pandu-card-header">
        <h6 class="card-title-custom mb-0">Lokasi & Waktu</h6>
      </div>
      <div class="pandu-card-body">
        <div class="mb-3">
          <p class="text-secondary label-text mb-1">AREA KERJA</p>
          <p class="fw-bold mb-0 text-dark"><i class="fas fa-location-dot me-2 text-danger"></i> {{ $incidentReport->workArea->name }}</p>
        </div>
        <div class="mb-3">
          <p class="text-secondary label-text mb-1">WAKTU KEJADIAN</p>
          <p class="fw-bold mb-0 text-dark"><i class="fas fa-clock me-2 text-secondary"></i> {{ $incidentReport->incident_date->format('d M Y') }}, {{ $incidentReport->incident_time }}</p>
        </div>
      </div>
    </div>

    <div class="alert alert-info border-0 shadow-sm">
      <h6 class="fw-bold mb-2 small text-uppercase">Status Investigasi</h6>
      <p class="mb-0 small">Laporan ini sedang dalam tahap <strong>Investigasi</strong> oleh Tim HSE. Anda akan menerima notifikasi jika ada perkembangan atau tindakan yang diperlukan.</p>
    </div>
  </div>
</div>
@endsection
