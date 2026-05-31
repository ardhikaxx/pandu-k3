@extends('layouts.app')

@section('title', 'Detail Investigasi')
@section('page-title', 'Investigasi Insiden')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('hse.dashboard') }}">Beranda</a></li>
  <li class="breadcrumb-item"><a href="{{ route('hse.incident.index') }}">Insiden</a></li>
  <li class="breadcrumb-item active">{{ $incidentReport->report_number }}</li>
@endsection

@section('content')
<div class="row g-4">
  <div class="col-lg-7">
    <div class="pandu-card">
      <div class="pandu-card-header bg-dark text-white">
        <div class="d-flex align-items-center gap-3">
           <span class="doc-number text-white" style="background:rgba(255,255,255,0.1)">{{ $incidentReport->report_number }}</span>
           <span class="status-badge status-{{ $incidentReport->status }} text-white">{{ ucfirst(str_replace('_', ' ', $incidentReport->status)) }}</span>
        </div>
      </div>
      <div class="pandu-card-body">
        <h4 class="fw-bold mb-3">{{ $incidentReport->title }}</h4>
        
        <div class="alert alert-secondary border-0 small mb-4">
           <div class="row">
              <div class="col-6">
                 <strong>Pelapor:</strong> {{ $incidentReport->reporter->name }}<br>
                 <strong>Area:</strong> {{ $incidentReport->workArea->name }}
              </div>
              <div class="col-6">
                 <strong>Waktu:</strong> {{ $incidentReport->incident_date->format('d M Y') }}, {{ $incidentReport->incident_time }}<br>
                 <strong>Tipe:</strong> {{ ucfirst(str_replace('_', ' ', $incidentReport->incident_type)) }}
              </div>
           </div>
        </div>

        <div class="mb-4">
          <p class="label-text text-secondary mb-1">KRONOLOGI AWAL (DARI PELAPOR)</p>
          <div class="p-3 bg-light rounded border">
            {{ $incidentReport->description }}
          </div>
        </div>

        @if($incidentReport->photos)
        <div class="mb-0">
          <p class="label-text text-secondary mb-2">FOTO BUKTI LAPANGAN</p>
          <div class="row g-2">
            @foreach($incidentReport->photos as $img)
              <div class="col-4">
                <img src="{{ asset('storage/'.$img) }}" class="img-fluid rounded border" onclick="window.open(this.src)" style="cursor:zoom-in">
              </div>
            @endforeach
          </div>
        </div>
        @endif
      </div>
    </div>
  </div>

  <div class="col-lg-5">
    <div class="pandu-card">
      <div class="pandu-card-header bg-primary text-white">
        <h6 class="mb-0 fw-bold"><i class="fas fa-microscope me-2"></i> Laporan Investigasi HSE</h6>
      </div>
      <div class="pandu-card-body">
        <form action="{{ route('hse.incident.investigate', $incidentReport->id) }}" method="POST">
          @csrf
          
          <div class="mb-3">
            <label class="form-label">Penyebab Langsung (Immediate Cause)</label>
            <textarea name="immediate_cause" rows="2" class="form-control" placeholder="Contoh: Kabel terbuka, lantai licin..." required>{{ old('immediate_cause', $incidentReport->immediate_cause) }}</textarea>
          </div>

          <div class="mb-3">
            <label class="form-label">Akar Masalah (Root Cause)</label>
            <textarea name="root_cause" rows="2" class="form-control" placeholder="Contoh: Kurangnya pemeliharaan rutin..." required>{{ old('root_cause', $incidentReport->root_cause) }}</textarea>
          </div>

          <div class="mb-3">
            <label class="form-label">Ringkasan Temuan Investigasi</label>
            <textarea name="investigation_report" rows="4" class="form-control" placeholder="Jelaskan hasil investigasi secara detail..." required>{{ old('investigation_report', $incidentReport->investigation_report) }}</textarea>
          </div>

          <div class="row mb-4">
             <div class="col-md-6">
                <label class="form-label">Klasifikasi Akhir</label>
                <select name="severity_classification" class="form-control" required>
                  <option value="minor" {{ $incidentReport->severity_classification == 'minor' ? 'selected' : '' }}>Minor</option>
                  <option value="moderate" {{ $incidentReport->severity_classification == 'moderate' ? 'selected' : '' }}>Moderate</option>
                  <option value="serious" {{ $incidentReport->severity_classification == 'serious' ? 'selected' : '' }}>Serious</option>
                  <option value="major" {{ $incidentReport->severity_classification == 'major' ? 'selected' : '' }}>Major</option>
                  <option value="catastrophic" {{ $incidentReport->severity_classification == 'catastrophic' ? 'selected' : '' }}>Catastrophic</option>
                </select>
             </div>
             <div class="col-md-6">
                <label class="form-label">Status Laporan</label>
                <select name="status" class="form-control" required>
                  <option value="under_investigation" {{ $incidentReport->status == 'under_investigation' ? 'selected' : '' }}>Masih Investigasi</option>
                  <option value="action_required" {{ $incidentReport->status == 'action_required' ? 'selected' : '' }}>Butuh Tindakan (CAPA)</option>
                  <option value="closed" {{ $incidentReport->status == 'closed' ? 'selected' : '' }}>Tutup Kasus</option>
                </select>
             </div>
          </div>

          <button type="submit" class="btn btn-pandu-primary w-100 py-2 fw-bold">
            SIMPAN HASIL INVESTIGASI <i class="fas fa-save ms-2"></i>
          </button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
