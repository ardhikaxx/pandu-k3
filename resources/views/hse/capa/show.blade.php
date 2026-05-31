@extends('layouts.app')

@section('title', 'Detail CAPA')
@section('page-title', 'Detail Tindakan Perbaikan')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('hse.dashboard') }}">Beranda</a></li>
  <li class="breadcrumb-item"><a href="{{ route('hse.capa.index') }}">CAPA</a></li>
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
        
        <div class="row mb-4 small">
          <div class="col-md-4">
            <p class="text-secondary label-text mb-1">TIPE TINDAKAN</p>
            <p class="fw-bold mb-0 text-dark">{{ ucfirst($capaAction->action_type) }}</p>
          </div>
          <div class="col-md-4">
            <p class="text-secondary label-text mb-1">PRIORITAS</p>
            <span class="risk-badge risk-{{ $capaAction->priority === 'critical' ? 'critical' : 'medium' }}">{{ ucfirst($capaAction->priority) }}</span>
          </div>
          <div class="col-md-4">
            <p class="text-secondary label-text mb-1">DEADLINE</p>
            <p class="fw-bold mb-0 {{ $capaAction->due_date < now() && $capaAction->status !== 'closed' ? 'text-danger' : '' }}">{{ $capaAction->due_date->format('d M Y') }}</p>
          </div>
        </div>

        <div class="mb-4">
          <p class="text-secondary label-text mb-1">DESKRIPSI TINDAKAN</p>
          <div class="p-3 bg-light rounded border">
            {{ $capaAction->description }}
          </div>
        </div>

        @if($capaAction->progress_notes)
        <div class="mb-4">
          <p class="text-secondary label-text mb-1">CATATAN PENYELESAIAN (DARI PIC)</p>
          <div class="p-3 bg-success-soft rounded border border-success">
            {{ $capaAction->progress_notes }}
          </div>
        </div>
        @endif

        @if($capaAction->completion_evidence)
        <div>
          <p class="text-secondary label-text mb-2">BUKTI PENYELESAIAN</p>
          <div class="row g-2">
            @foreach($capaAction->completion_evidence as $img)
              <div class="col-md-4">
                <img src="{{ asset('storage/'.$img) }}" class="img-fluid rounded border" style="cursor: zoom-in;" onclick="window.open(this.src)">
              </div>
            @endforeach
          </div>
        </div>
        @endif
      </div>
    </div>
  </div>

  <div class="col-lg-5">
    @if($capaAction->status === 'pending_verification')
    <!-- Verification Form for HSE Manager -->
    <div class="pandu-card border-primary">
      <div class="pandu-card-header bg-primary text-white">
        <h6 class="mb-0 fw-bold"><i class="fas fa-check-double me-2"></i> Verifikasi Efektivitas</h6>
      </div>
      <div class="pandu-card-body">
        <form action="{{ route('hse.capa.verify', $capaAction->id) }}" method="POST">
          @csrf
          <div class="mb-3">
            <label class="form-label">Rating Efektivitas (1-5)</label>
            <div class="d-flex justify-content-between">
              @for($i=1; $i<=5; $i++)
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="effectiveness_rating" id="rate{{$i}}" value="{{$i}}" required>
                  <label class="form-check-label" for="rate{{$i}}">{{$i}}</label>
                </div>
              @endfor
            </div>
            <div class="d-flex justify-content-between smaller text-secondary mt-1">
              <span>Sangat Tidak Efektif</span>
              <span>Sangat Efektif</span>
            </div>
          </div>

          <div class="mb-4">
            <label class="form-label">Tentukan Status Akhir</label>
            <select name="status" class="form-control" required>
              <option value="closed">Tutup CAPA (Selesai)</option>
              <option value="open">Tolak (Perlu Perbaikan Lagi)</option>
            </select>
          </div>

          <button type="submit" class="btn btn-pandu-primary w-100">SIMPAN VERIFIKASI</button>
        </form>
      </div>
    </div>
    @endif

    <div class="pandu-card">
      <div class="pandu-card-header bg-light">
        <h6 class="card-title-custom mb-0">Personil Terkait</h6>
      </div>
      <div class="pandu-card-body">
        <div class="mb-3">
          <p class="text-secondary label-text mb-1">DITUGASKAN OLEH (HSE)</p>
          <p class="fw-bold mb-0">{{ $capaAction->assignedBy->name }}</p>
        </div>
        <div class="mb-3">
          <p class="text-secondary label-text mb-1">PENANGGUNG JAWAB (PIC)</p>
          <p class="fw-bold mb-0 text-primary">{{ $capaAction->assignedTo->name }}</p>
          <p class="small text-secondary">{{ $capaAction->division->name }}</p>
        </div>
        @if($capaAction->verifiedBy)
        <div class="mb-0">
          <p class="text-secondary label-text mb-1">DIVERIFIKASI OLEH</p>
          <p class="fw-bold mb-0 text-success">{{ $capaAction->verifiedBy->name }}</p>
          <p class="small text-secondary">Pada: {{ $capaAction->verified_at->format('d M Y, H:i') }}</p>
        </div>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection

@push('styles')
<style>
.smaller { font-size: 0.7rem; }
.bg-success-soft { background: rgba(26, 122, 74, 0.08); }
</style>
@endpush
