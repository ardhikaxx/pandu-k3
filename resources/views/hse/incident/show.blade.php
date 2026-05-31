@extends('layouts.app')

@section('title', 'Detail Investigasi')
@section('page-title', 'Investigasi Laporan Insiden')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('hse.dashboard') }}">Beranda</a></li>
  <li class="breadcrumb-item"><a href="{{ route('hse.incident.index') }}">Insiden</a></li>
  <li class="breadcrumb-item active">{{ $incidentReport->report_number }}</li>
@endsection

@section('content')
<div class="row g-4">
  <div class="col-lg-8">
    <!-- Main Report Details -->
    <div class="pandu-card shadow-sm border-0 mb-4">
      <div class="pandu-card-header bg-dark text-white py-3">
        <div class="d-flex justify-content-between align-items-center w-100">
           <div class="d-flex align-items-center gap-3">
              <span class="doc-number text-white" style="background:rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2)">{{ $incidentReport->report_number }}</span>
              <span class="status-badge status-{{ $incidentReport->status }} text-white border-0 shadow-sm">{{ ucfirst(str_replace('_', ' ', $incidentReport->status)) }}</span>
           </div>
           <div class="small opacity-75 d-none d-md-block">
              <i class="fas fa-clock me-1"></i> Dilaporkan: {{ $incidentReport->submitted_at ? $incidentReport->submitted_at->format('d M Y, H:i') : $incidentReport->created_at->format('d M Y, H:i') }} WIB
           </div>
        </div>
      </div>
      <div class="pandu-card-body p-4">
        <h2 class="fw-bold mb-4 text-dark">{{ $incidentReport->title }}</h2>
        
        <div class="row g-4 mb-5">
           <div class="col-md-6 col-lg-3">
              <p class="label-text text-secondary mb-1">TIPE INSIDEN</p>
              <p class="fw-bold text-dark mb-0"><i class="fas fa-circle-exclamation me-1 text-danger"></i> {{ strtoupper(str_replace('_', ' ', $incidentReport->incident_type)) }}</p>
           </div>
           <div class="col-md-6 col-lg-3">
              <p class="label-text text-secondary mb-1">AREA KERJA</p>
              <p class="fw-bold text-dark mb-0"><i class="fas fa-location-dot me-1 text-primary"></i> {{ $incidentReport->workArea->name }}</p>
           </div>
           <div class="col-md-6 col-lg-3">
              <p class="label-text text-secondary mb-1">KEPARAHAN</p>
              @php
                $sevClass = match($incidentReport->severity_classification) {
                  'minor' => 'success',
                  'moderate' => 'info',
                  'serious' => 'warning',
                  default => 'danger'
                };
              @endphp
              <span class="badge bg-{{ $sevClass }}-soft text-{{ $sevClass }} px-3 rounded-pill" style="font-weight: 800;">
                 {{ strtoupper($incidentReport->severity_classification) }}
              </span>
           </div>
           <div class="col-md-6 col-lg-3">
              <p class="label-text text-secondary mb-1">WAKTU KEJADIAN</p>
              <p class="fw-bold text-dark mb-0"><i class="far fa-calendar-check me-1 text-secondary"></i> {{ $incidentReport->incident_date->format('d M Y') }}</p>
              <p class="smaller text-muted">{{ $incidentReport->incident_time }} WIB</p>
           </div>
        </div>

        <div class="mb-5">
          <div class="d-flex align-items-center gap-2 mb-2">
             <div class="bg-primary-soft text-primary rounded-circle d-flex align-items-center justify-content-center" style="width:24px;height:24px;font-size:10px;"><i class="fas fa-align-left"></i></div>
             <h6 class="mb-0 fw-bold label-text">Kronologi Awal Kejadian</h6>
          </div>
          <div class="p-4 bg-light rounded-3 border-start border-primary border-4 shadow-sm" style="line-height: 1.8;">
            {{ $incidentReport->description }}
          </div>
        </div>

        @if($incidentReport->victim_name)
        <div class="mb-5">
           <div class="d-flex align-items-center gap-2 mb-2">
              <div class="bg-danger-soft text-danger rounded-circle d-flex align-items-center justify-content-center" style="width:24px;height:24px;font-size:10px;"><i class="fas fa-user-injured"></i></div>
              <h6 class="mb-0 fw-bold label-text">Data Personil Terlibat / Korban</h6>
           </div>
           <div class="pandu-card bg-light border-0 p-3">
              <div class="row align-items-center">
                 <div class="col-auto">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($incidentReport->victim_name) }}&background=E74C3C&color=fff" class="rounded-circle shadow-sm" style="width:50px;">
                 </div>
                 <div class="col">
                    <p class="mb-0 fw-bold text-dark">{{ $incidentReport->victim_name }}</p>
                    <p class="mb-0 small text-secondary">NIK: {{ $incidentReport->victim_employee_id ?? 'N/A' }}</p>
                 </div>
              </div>
           </div>
        </div>
        @endif

        @if($incidentReport->photos)
        <div class="mb-0">
          <div class="d-flex align-items-center gap-2 mb-3">
             <div class="bg-warning-soft text-warning rounded-circle d-flex align-items-center justify-content-center" style="width:24px;height:24px;font-size:10px;"><i class="fas fa-camera"></i></div>
             <h6 class="mb-0 fw-bold label-text">Foto Bukti Lapangan</h6>
          </div>
          <div class="row g-3">
            @foreach($incidentReport->photos as $img)
              <div class="col-6 col-md-3">
                <div class="ratio ratio-1x1 rounded-3 overflow-hidden shadow-sm border border-2 border-white hover-zoom" style="cursor:zoom-in" onclick="window.open('{{ asset('storage/'.$img) }}')">
                   <img src="{{ asset('storage/'.$img) }}" class="object-fit-cover">
                </div>
              </div>
            @endforeach
          </div>
        </div>
        @endif
      </div>
    </div>
  </div>

  <div class="col-lg-4">
    <!-- Investigation Panel -->
    <div class="pandu-card shadow border-0 overflow-hidden sticky-top" style="top: 85px; z-index: 10;">
      <div class="pandu-card-header bg-primary text-white py-3 border-0">
        <h6 class="mb-0 fw-bold"><i class="fas fa-magnifying-glass me-2"></i> Investigasi & Analisis HSE</h6>
      </div>
      <div class="pandu-card-body p-4">
        <form action="{{ route('hse.incident.investigate', $incidentReport->id) }}" method="POST">
          @csrf
          
          <div class="mb-4">
            <label class="form-label label-text text-muted mb-2">Penyebab Langsung</label>
            <textarea name="immediate_cause" rows="2" class="form-control bg-light" placeholder="Kondisi atau tindakan tidak aman..." required>{{ old('immediate_cause', $incidentReport->immediate_cause) }}</textarea>
            <div class="form-text smaller">Contoh: Ceceran oli, kabel terkelupas.</div>
          </div>

          <div class="mb-4">
            <label class="form-label label-text text-muted mb-2">Akar Masalah (Root Cause)</label>
            <textarea name="root_cause" rows="2" class="form-control bg-light" placeholder="Penyebab dasar sistemik..." required>{{ old('root_cause', $incidentReport->root_cause) }}</textarea>
            <div class="form-text smaller">Contoh: Kurangnya jadwal maintenance.</div>
          </div>

          <div class="mb-4">
            <label class="form-label label-text text-muted mb-2">Laporan Temuan Detail</label>
            <textarea name="investigation_report" rows="5" class="form-control bg-light" placeholder="Hasil investigasi mendalam..." required>{{ old('investigation_report', $incidentReport->investigation_report) }}</textarea>
          </div>

          <div class="mb-4">
             <label class="form-label label-text text-muted mb-2">Keputusan Status & Klasifikasi</label>
             <div class="row g-2">
                <div class="col-6">
                   <select name="severity_classification" class="form-select form-select-sm" required>
                     <option value="minor" {{ $incidentReport->severity_classification == 'minor' ? 'selected' : '' }}>Minor</option>
                     <option value="moderate" {{ $incidentReport->severity_classification == 'moderate' ? 'selected' : '' }}>Moderate</option>
                     <option value="serious" {{ $incidentReport->severity_classification == 'serious' ? 'selected' : '' }}>Serious</option>
                     <option value="major" {{ $incidentReport->severity_classification == 'major' ? 'selected' : '' }}>Major</option>
                     <option value="catastrophic" {{ $incidentReport->severity_classification == 'catastrophic' ? 'selected' : '' }}>Catastrophic</option>
                   </select>
                </div>
                <div class="col-6">
                   <select name="status" class="form-select form-select-sm fw-bold {{ $incidentReport->status === 'closed' ? 'text-success' : 'text-primary' }}" required>
                     <option value="under_investigation" {{ $incidentReport->status == 'under_investigation' ? 'selected' : '' }}>Investigasi</option>
                     <option value="action_required" {{ $incidentReport->status == 'action_required' ? 'selected' : '' }}>Butuh CAPA</option>
                     <option value="closed" {{ $incidentReport->status == 'closed' ? 'selected' : '' }}>Tutup Kasus</option>
                   </select>
                </div>
             </div>
          </div>

          <div class="alert alert-info border-0 shadow-sm smaller mb-4">
             <i class="fas fa-info-circle me-1"></i> Menyimpan hasil investigasi akan memperbarui data statistik dan notifikasi pelapor.
          </div>

          <button type="submit" class="btn btn-pandu-primary w-100 py-3 fw-bold shadow">
            SIMPAN HASIL INVESTIGASI <i class="fas fa-save ms-2"></i>
          </button>
        </form>
      </div>
    </div>

    <!-- Reporter Profile -->
    <div class="pandu-card mt-4 border-0 shadow-sm">
       <div class="pandu-card-body p-3">
          <p class="label-text text-muted mb-2">PERSONIL PELAPOR</p>
          <div class="d-flex align-items-center gap-3">
             <img src="https://ui-avatars.com/api/?name={{ urlencode($incidentReport->reporter->name) }}&background=0D2137&color=fff" class="rounded-circle shadow-sm" style="width:40px;">
             <div>
                <p class="mb-0 fw-bold text-dark small">{{ $incidentReport->reporter->name }}</p>
                <div class="badge-role-{{ $incidentReport->reporter->role }} px-2 py-0 rounded text-white" style="font-size: 9px;">{{ strtoupper($incidentReport->reporter->role) }}</div>
             </div>
             <div class="ms-auto">
                <a href="mailto:{{ $incidentReport->reporter->email }}" class="icon-box-sm bg-light text-secondary rounded-circle"><i class="fas fa-envelope"></i></a>
             </div>
          </div>
       </div>
    </div>
  </div>
</div>
@endsection

@push('styles')
<style>
  .hover-zoom { transition: transform 0.3s ease; }
  .hover-zoom:hover { transform: scale(1.05); }
  .bg-primary-soft { background-color: rgba(21, 101, 192, 0.1); }
  .bg-danger-soft { background-color: rgba(192, 57, 43, 0.1); }
  .bg-warning-soft { background-color: rgba(230, 126, 34, 0.1); }
  .bg-success-soft { background-color: rgba(26, 122, 74, 0.1); }
  .bg-info-soft { background-color: rgba(13, 202, 240, 0.1); }
</style>
@endpush
