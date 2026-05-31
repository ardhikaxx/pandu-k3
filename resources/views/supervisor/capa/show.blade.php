@extends('layouts.app')

@section('title', 'Update CAPA')
@section('page-title', 'Pengerjaan CAPA')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('supervisor.dashboard') }}">Beranda</a></li>
  <li class="breadcrumb-item"><a href="{{ route('supervisor.capa.index') }}">CAPA Saya</a></li>
  <li class="breadcrumb-item active">{{ $capaAction->capa_number }}</li>
@endsection

@section('content')
<div class="row g-4">
  <div class="col-lg-7">
    <div class="pandu-card">
      <div class="pandu-card-header">
        <div class="d-flex align-items-center gap-3">
           <span class="doc-number">{{ $capaAction->capa_number }}</span>
           <span class="status-badge status-{{ $capaAction->status }}">{{ ucfirst(str_replace('_', ' ', $capaAction->status)) }}</span>
        </div>
      </div>
      <div class="pandu-card-body">
        <h4 class="fw-bold mb-3">{{ $capaAction->title }}</h4>
        
        <div class="p-3 bg-light rounded border mb-4">
          <p class="text-secondary label-text mb-1">INSTRUKSI TINDAKAN</p>
          <p class="mb-0">{{ $capaAction->description }}</p>
        </div>

        <div class="row mb-4">
           <div class="col-6">
              <p class="text-secondary label-text mb-1">PRIORITAS</p>
              <span class="risk-badge risk-{{ $capaAction->priority === 'critical' ? 'critical' : 'medium' }}">{{ ucfirst($capaAction->priority) }}</span>
           </div>
           <div class="col-6">
              <p class="text-secondary label-text mb-1">BATAS WAKTU</p>
              <p class="fw-bold text-{{ $capaAction->due_date < now() && $capaAction->status !== 'closed' ? 'danger' : 'dark' }} mb-0">
                {{ $capaAction->due_date->format('d M Y') }}
              </p>
           </div>
        </div>

        @if($capaAction->completion_evidence)
        <div>
          <p class="text-secondary label-text mb-2">FOTO BUKTI YANG SUDAH DIUPLOAD</p>
          <div class="row g-2">
            @foreach($capaAction->completion_evidence as $img)
              <div class="col-md-3">
                <img src="{{ asset('storage/'.$img) }}" class="img-fluid rounded border shadow-sm">
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
      <div class="pandu-card-header bg-light">
        <h6 class="card-title-custom mb-0"><i class="fas fa-edit me-2"></i> Update Progres & Penyelesaian</h6>
      </div>
      <div class="pandu-card-body">
        <form action="{{ route('supervisor.capa.update', $capaAction->id) }}" method="POST" enctype="multipart/form-data">
          @csrf
          
          <div class="mb-3">
            <label for="status" class="form-label">Status Saat Ini</label>
            <select name="status" id="status" class="form-control" required>
              <option value="in_progress" {{ $capaAction->status == 'in_progress' ? 'selected' : '' }}>Sedang Dikerjakan</option>
              <option value="pending_verification" {{ $capaAction->status == 'pending_verification' ? 'selected' : '' }}>Selesai - Minta Verifikasi</option>
            </select>
          </div>

          <div class="mb-3">
            <label for="progress_notes" class="form-label">Catatan Perbaikan / Kendala</label>
            <textarea name="progress_notes" id="progress_notes" rows="5" class="form-control" placeholder="Jelaskan tindakan yang telah dilakukan..." required>{{ old('progress_notes', $capaAction->progress_notes) }}</textarea>
          </div>

          <div class="mb-4">
            <label class="form-label">Upload Foto Bukti Perbaikan</label>
            <input type="file" name="evidence[]" class="form-control" multiple accept="image/*">
            <div class="form-text small">Dapat memilih lebih dari 1 foto.</div>
          </div>

          <button type="submit" class="btn btn-pandu-primary w-100 py-2 fw-bold">
            SIMPAN PERUBAHAN <i class="fas fa-save ms-2"></i>
          </button>
        </form>
      </div>
    </div>

    <div class="pandu-card">
      <div class="pandu-card-body">
        <p class="text-secondary label-text mb-1">DIBUAT OLEH</p>
        <div class="d-flex align-items-center gap-2">
           <img src="https://ui-avatars.com/api/?name={{ urlencode($capaAction->assignedBy->name) }}&background=E9ECEF&color=495057" class="rounded-circle" style="width: 32px; height: 32px;">
           <div>
             <p class="mb-0 fw-bold small">{{ $capaAction->assignedBy->name }}</p>
             <p class="mb-0 smaller text-secondary">{{ $capaAction->created_at->format('d M Y, H:i') }}</p>
           </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
