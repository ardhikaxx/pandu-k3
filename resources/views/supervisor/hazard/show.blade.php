@extends('layouts.app')

@section('title', 'Verifikasi Laporan')
@section('page-title', 'Verifikasi Temuan Bahaya')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('supervisor.dashboard') }}">Beranda</a></li>
  <li class="breadcrumb-item"><a href="{{ route('supervisor.hazard.index') }}">Verifikasi Bahaya</a></li>
  <li class="breadcrumb-item active">{{ $hazardReport->report_number }}</li>
@endsection

@section('content')
<div class="row g-4">
  <div class="col-lg-8">
    <!-- Report Content -->
    <div class="pandu-card shadow-sm border-0 mb-4">
      <div class="pandu-card-header bg-navy text-white py-3">
        <div class="d-flex justify-content-between align-items-center w-100 flex-wrap gap-2">
           <div class="d-flex align-items-center gap-3">
              <span class="doc-number text-white" style="background:rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2)">{{ $hazardReport->report_number }}</span>
              <span class="status-badge status-{{ $hazardReport->status }} text-white border-0 shadow-sm">{{ ucfirst(str_replace('_', ' ', $hazardReport->status)) }}</span>
           </div>
           <div class="small opacity-75">
              <i class="far fa-calendar-alt me-1"></i> {{ $hazardReport->reported_at->format('d M Y, H:i') }} WIB
           </div>
        </div>
      </div>
      <div class="pandu-card-body p-4">
        <h2 class="fw-bold mb-4 text-dark">{{ $hazardReport->title }}</h2>

        <div class="row g-4 mb-5 small">
          <div class="col-md-4">
            <p class="label-text text-secondary mb-1">KATEGORI BAHAYA</p>
            <p class="fw-bold text-dark mb-0"><i class="fas fa-tags me-1 text-primary"></i> {{ ucfirst($hazardReport->category) }}</p>
          </div>
          <div class="col-md-4">
            <p class="label-text text-secondary mb-1">TIPE TEMUAN</p>
            <p class="fw-bold text-dark mb-0">{{ ucfirst(str_replace('_', ' ', $hazardReport->hazard_type)) }}</p>
          </div>
          <div class="col-md-4">
            <p class="label-text text-secondary mb-1">TINGKAT RISIKO</p>
            <span class="risk-badge risk-{{ $hazardReport->severity }} shadow-sm">{{ ucfirst($hazardReport->severity) }}</span>
          </div>
        </div>

        <div class="mb-5">
          <div class="d-flex align-items-center gap-2 mb-2">
             <div class="bg-primary-soft text-primary rounded-circle d-flex align-items-center justify-content-center" style="width:24px;height:24px;font-size:10px;"><i class="fas fa-align-left"></i></div>
             <h6 class="mb-0 fw-bold label-text">Deskripsi Detail Temuan</h6>
          </div>
          <div class="p-4 bg-light rounded-3 border-start border-primary border-4 shadow-sm" style="line-height: 1.8;">
            {{ $hazardReport->description }}
          </div>
        </div>

        @if($hazardReport->photos)
        <div class="mb-0">
          <div class="d-flex align-items-center gap-2 mb-3">
             <div class="bg-warning-soft text-warning rounded-circle d-flex align-items-center justify-content-center" style="width:24px;height:24px;font-size:10px;"><i class="fas fa-camera"></i></div>
             <h6 class="mb-0 fw-bold label-text">Foto Dokumentasi Lapangan</h6>
          </div>
          <div class="row g-3">
            @foreach($hazardReport->photos as $photo)
              <div class="col-6 col-md-4">
                <div class="ratio ratio-4x3 rounded-3 overflow-hidden shadow-sm border border-2 border-white hover-zoom" style="cursor:zoom-in" onclick="window.open('{{ asset('storage/'.$photo) }}')">
                   <img src="{{ asset('storage/'.$photo) }}" class="object-fit-cover">
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
    <!-- Verification Form -->
    <div class="pandu-card shadow border-0 overflow-hidden mb-4">
      <div class="pandu-card-header bg-primary text-white py-3 border-0">
        <h6 class="mb-0 fw-bold"><i class="fas fa-user-check me-2"></i> Tindakan Verifikasi Supervisor</h6>
      </div>
      <div class="pandu-card-body p-4">
        <form action="{{ route('supervisor.hazard.verify', $hazardReport->id) }}" method="POST">
          @csrf
          
          <div class="mb-4">
            <label for="status" class="form-label label-text text-muted mb-2">Update Status Laporan</label>
            <select name="status" id="status" class="form-select fw-bold" required>
              <option value="in_review" {{ $hazardReport->status == 'in_review' ? 'selected' : '' }}>Dalam Tinjauan (In Review)</option>
              <option value="in_progress" {{ $hazardReport->status == 'in_progress' ? 'selected' : '' }}>Sedang Dikerjakan (In Progress)</option>
              <option value="resolved" {{ $hazardReport->status == 'resolved' ? 'selected' : '' }}>Terselesaikan (Resolved)</option>
              <option value="closed" {{ $hazardReport->status == 'closed' ? 'selected' : '' }}>Ditutup (Closed)</option>
            </select>
          </div>

          <div class="mb-4">
            <label for="supervisor_notes" class="form-label label-text text-muted mb-2">Instruksi & Catatan Teknis</label>
            <textarea name="supervisor_notes" id="supervisor_notes" rows="6" class="form-control bg-light" placeholder="Tuliskan instruksi perbaikan atau alasan verifikasi..." required>{{ old('supervisor_notes', $hazardReport->supervisor_notes) }}</textarea>
          </div>

          <div class="alert alert-info border-0 shadow-sm smaller mb-4">
            <i class="fas fa-info-circle me-1"></i> Perubahan status akan memberitahu pelapor dan memperbarui statistik keselamatan area.
          </div>

          <button type="submit" class="btn btn-pandu-primary w-100 py-3 fw-bold shadow">
            SIMPAN VERIFIKASI <i class="fas fa-save ms-2"></i>
          </button>
        </form>
      </div>
    </div>

    <!-- Reporter Profile -->
    <div class="pandu-card shadow-sm border-0 mb-4">
       <div class="pandu-card-body p-3">
          <p class="label-text text-muted mb-2">PERSONIL PELAPOR</p>
          <div class="d-flex align-items-center gap-3">
             <img src="https://ui-avatars.com/api/?name={{ urlencode($hazardReport->reporter->name) }}&background=0D2137&color=fff" class="rounded-circle shadow-sm" style="width:45px;">
             <div>
                <p class="mb-0 fw-bold text-dark small">{{ $hazardReport->reporter->name }}</p>
                <p class="mb-0 smaller text-muted">ID: {{ $hazardReport->reporter->employee_id ?? 'N/A' }}</p>
             </div>
             <div class="ms-auto">
                <a href="tel:{{ $hazardReport->reporter->phone }}" class="icon-box-sm bg-light text-primary rounded-circle shadow-sm border"><i class="fas fa-phone"></i></a>
             </div>
          </div>
       </div>
    </div>

    <!-- Location Summary -->
    <div class="pandu-card shadow-sm border-0">
       <div class="pandu-card-body p-3">
          <p class="label-text text-muted mb-2">LOKASI KEJADIAN</p>
          <div class="d-flex align-items-start gap-3">
             <div class="icon-box-sm bg-danger-soft text-danger rounded-circle"><i class="fas fa-location-dot"></i></div>
             <div>
                <p class="mb-0 fw-bold text-dark small">{{ $hazardReport->workArea->name }}</p>
                <p class="mb-0 smaller text-muted">{{ $hazardReport->location_detail }}</p>
             </div>
          </div>
       </div>
    </div>
  </div>
</div>
@endsection

@push('styles')
<style>
  .bg-navy { background-color: var(--pandu-navy) !important; }
  .bg-primary-soft { background-color: rgba(21, 101, 192, 0.1); }
  .bg-warning-soft { background-color: rgba(230, 126, 34, 0.1); }
  .bg-danger-soft { background-color: rgba(192, 57, 43, 0.1); }
  .hover-zoom { transition: transform 0.3s ease; }
  .hover-zoom:hover { transform: scale(1.05); }
</style>
@endpush
