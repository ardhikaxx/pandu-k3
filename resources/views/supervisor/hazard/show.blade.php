@extends('layouts.app')

@section('title', 'Verifikasi Laporan')
@section('page-title', 'Verifikasi Laporan')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('supervisor.dashboard') }}">Beranda</a></li>
  <li class="breadcrumb-item"><a href="{{ route('supervisor.hazard.index') }}">Verifikasi Bahaya</a></li>
  <li class="breadcrumb-item active">{{ $hazardReport->report_number }}</li>
@endsection

@section('content')
<div class="row g-4">
  <div class="col-lg-7">
    <!-- Report Details -->
    <div class="pandu-card">
      <div class="pandu-card-header">
        <div class="d-flex align-items-center gap-3">
           <span class="doc-number">{{ $hazardReport->report_number }}</span>
           <span class="status-badge status-{{ $hazardReport->status }}">{{ ucfirst(str_replace('_', ' ', $hazardReport->status)) }}</span>
        </div>
      </div>
      <div class="pandu-card-body">
        <h4 class="fw-bold mb-3">{{ $hazardReport->title }}</h4>
        
        <div class="p-3 bg-light rounded border mb-4">
          <p class="text-secondary label-text mb-1">DESKRIPSI TEMUAN</p>
          <p class="mb-0">{{ $hazardReport->description }}</p>
        </div>

        <div class="row mb-4">
           <div class="col-6">
              <p class="text-secondary label-text mb-1">LOKASI</p>
              <p class="fw-bold small mb-0">{{ $hazardReport->workArea->name }}</p>
              <p class="text-secondary small">{{ $hazardReport->location_detail }}</p>
           </div>
           <div class="col-6">
              <p class="text-secondary label-text mb-1">DILAPORKAN PADA</p>
              <p class="fw-bold small mb-0">{{ $hazardReport->reported_at->format('d M Y') }}</p>
              <p class="text-secondary small">{{ $hazardReport->reported_at->format('H:i') }} WIB</p>
           </div>
        </div>

        <div>
          <p class="text-secondary label-text mb-2">FOTO TEMUAN</p>
          <div class="row g-2">
            @foreach($hazardReport->photos as $photo)
              <div class="col-4">
                <img src="{{ asset('storage/'.$photo) }}" class="img-fluid rounded border shadow-sm" style="cursor: zoom-in;" onclick="window.open(this.src)">
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-5">
    <!-- Verification Form -->
    <div class="pandu-card">
      <div class="pandu-card-header bg-light">
        <h6 class="card-title-custom mb-0"><i class="fas fa-user-check me-2"></i> Tindakan Verifikasi</h6>
      </div>
      <div class="pandu-card-body">
        <form action="{{ route('supervisor.hazard.verify', $hazardReport->id) }}" method="POST">
          @csrf
          
          <div class="mb-3">
            <label for="status" class="form-label">Update Status Laporan</label>
            <select name="status" id="status" class="form-control" required>
              <option value="in_review" {{ $hazardReport->status == 'in_review' ? 'selected' : '' }}>Dalam Tinjauan (In Review)</option>
              <option value="in_progress" {{ $hazardReport->status == 'in_progress' ? 'selected' : '' }}>Sedang Dikerjakan (In Progress)</option>
              <option value="resolved" {{ $hazardReport->status == 'resolved' ? 'selected' : '' }}>Terselesaikan (Resolved)</option>
              <option value="closed" {{ $hazardReport->status == 'closed' ? 'selected' : '' }}>Ditutup (Closed)</option>
            </select>
          </div>

          <div class="mb-4">
            <label for="supervisor_notes" class="form-label">Catatan Supervisor / Instruksi</label>
            <textarea name="supervisor_notes" id="supervisor_notes" rows="5" class="form-control" placeholder="Tuliskan catatan teknis, instruksi perbaikan, atau alasan penutupan..." required>{{ old('supervisor_notes', $hazardReport->supervisor_notes) }}</textarea>
          </div>

          <div class="alert alert-info border-0 small mb-4">
            <i class="fas fa-info-circle me-2"></i> Memberikan status <strong>Resolved</strong> atau <strong>Closed</strong> akan mengirimkan notifikasi ke pelapor.
          </div>

          <button type="submit" class="btn btn-pandu-primary w-100 py-2">
            SIMPAN VERIFIKASI <i class="fas fa-save ms-2"></i>
          </button>
        </form>
      </div>
    </div>

    <!-- Reporter Info -->
    <div class="pandu-card">
      <div class="pandu-card-body">
        <div class="d-flex align-items-center gap-3">
          <img src="https://ui-avatars.com/api/?name={{ urlencode($hazardReport->reporter->name) }}&background=0D2137&color=fff" class="rounded-circle" style="width: 45px; height: 45px;">
          <div>
            <p class="mb-0 fw-bold">{{ $hazardReport->reporter->name }}</p>
            <p class="mb-0 text-secondary small">Pelapor · {{ $hazardReport->reporter->employee_id ?? 'N/A' }}</p>
          </div>
          <div class="ms-auto">
            <a href="tel:{{ $hazardReport->reporter->phone }}" class="btn btn-outline-secondary btn-sm rounded-pill">
              <i class="fas fa-phone"></i>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
