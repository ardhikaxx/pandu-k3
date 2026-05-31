@extends('layouts.app')

@section('title', 'Detail CAPA')
@section('page-title', 'Tindakan Perbaikan (CAPA)')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('hse.dashboard') }}">Beranda</a></li>
  <li class="breadcrumb-item"><a href="{{ route('hse.capa.index') }}">CAPA</a></li>
  <li class="breadcrumb-item active">{{ $capaAction->capa_number }}</li>
@endsection

@section('content')
<div class="row g-4">
  <div class="col-lg-8">
    <!-- Main CAPA Info -->
    <div class="pandu-card shadow-sm border-0 mb-4">
      <div class="pandu-card-header bg-navy text-white py-3">
        <div class="d-flex justify-content-between align-items-center w-100 flex-wrap gap-2">
           <div class="d-flex align-items-center gap-3">
              <span class="doc-number text-white" style="background:rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2)">{{ $capaAction->capa_number }}</span>
              <span class="status-badge status-{{ $capaAction->status }} text-white border-0 shadow-sm">{{ ucfirst(str_replace('_', ' ', $capaAction->status)) }}</span>
           </div>
           <div class="small opacity-75">
              <i class="far fa-calendar-plus me-1"></i> Dibuat: {{ $capaAction->created_at->format('d/m/Y') }}
           </div>
        </div>
      </div>
      <div class="pandu-card-body p-4">
        <h2 class="fw-bold mb-4 text-dark">{{ $capaAction->title }}</h2>
        
        <div class="row g-4 mb-5">
          <div class="col-md-4">
            <p class="label-text text-secondary mb-1">TIPE TINDAKAN</p>
            <p class="fw-bold text-dark mb-0"><i class="fas fa-tools me-1 text-primary"></i> {{ strtoupper($capaAction->action_type) }}</p>
          </div>
          <div class="col-md-4">
            <p class="label-text text-secondary mb-1">PRIORITAS</p>
            <span class="risk-badge risk-{{ $capaAction->priority === 'critical' ? 'critical' : 'medium' }} shadow-sm">{{ ucfirst($capaAction->priority) }}</span>
          </div>
          <div class="col-md-4">
            <p class="label-text text-secondary mb-1">BATAS WAKTU</p>
            @php $isOverdue = $capaAction->due_date < now() && $capaAction->status !== 'closed'; @endphp
            <p class="fw-bold mb-0 {{ $isOverdue ? 'text-danger' : 'text-dark' }}">
               <i class="far fa-clock me-1"></i> {{ $capaAction->due_date->format('d M Y') }}
               @if($isOverdue) <span class="badge bg-danger ms-1 smaller">OVERDUE</span> @endif
            </p>
          </div>
        </div>

        <div class="mb-5">
          <div class="d-flex align-items-center gap-2 mb-2">
             <div class="bg-primary-soft text-primary rounded-circle d-flex align-items-center justify-content-center" style="width:24px;height:24px;font-size:10px;"><i class="fas fa-info-circle"></i></div>
             <h6 class="mb-0 fw-bold label-text">Instruksi & Deskripsi CAPA</h6>
          </div>
          <div class="p-4 bg-light rounded-3 border-start border-primary border-4 shadow-sm">
            {!! nl2br(e($capaAction->description)) !!}
          </div>
        </div>

        @if($capaAction->progress_notes)
        <div class="mb-5">
          <div class="d-flex align-items-center gap-2 mb-2 text-success">
             <div class="bg-success-soft text-success rounded-circle d-flex align-items-center justify-content-center" style="width:24px;height:24px;font-size:10px;"><i class="fas fa-check-circle"></i></div>
             <h6 class="mb-0 fw-bold label-text">Laporan Penyelesaian (Dari PIC)</h6>
          </div>
          <div class="p-4 bg-success-soft rounded-3 border-start border-success border-4 shadow-sm text-dark" style="line-height: 1.7;">
            {{ $capaAction->progress_notes }}
          </div>
          <p class="smaller text-muted mt-2 ps-2"><i class="fas fa-calendar-check me-1"></i> Selesai pada: {{ $capaAction->completed_at ? $capaAction->completed_at->format('d M Y, H:i') : '-' }} WIB</p>
        </div>
        @endif

        @if($capaAction->completion_evidence)
        <div class="mb-0">
          <div class="d-flex align-items-center gap-2 mb-3">
             <div class="bg-info-soft text-info rounded-circle d-flex align-items-center justify-content-center" style="width:24px;height:24px;font-size:10px;"><i class="fas fa-images"></i></div>
             <h6 class="mb-0 fw-bold label-text">Bukti Foto Dokumentasi</h6>
          </div>
          <div class="row g-3">
            @foreach($capaAction->completion_evidence as $img)
              <div class="col-6 col-md-3">
                <div class="ratio ratio-1x1 rounded-3 overflow-hidden shadow-sm border-2 border border-white hover-zoom" style="cursor: zoom-in;" onclick="window.open('{{ asset('storage/'.$img) }}')">
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
    <!-- Verification Action Card -->
    @if($capaAction->status === 'pending_verification')
    <div class="pandu-card border-0 shadow-lg mb-4 overflow-hidden">
      <div class="pandu-card-header bg-primary text-white py-3 border-0">
        <h6 class="mb-0 fw-bold"><i class="fas fa-check-double me-2"></i> Verifikasi Efektivitas</h6>
      </div>
      <div class="pandu-card-body p-4">
        <form action="{{ route('hse.capa.verify', $capaAction->id) }}" method="POST">
          @csrf
          <div class="mb-4">
            <label class="form-label label-text text-muted mb-3">Sejauh mana tindakan ini efektif?</label>
            <div class="d-flex justify-content-between px-1">
              @for($i=1; $i<=5; $i++)
                <div class="text-center">
                   <input type="radio" class="btn-check" name="effectiveness_rating" id="rate{{$i}}" value="{{$i}}" required>
                   <label class="btn btn-outline-primary rounded-circle d-flex align-items-center justify-content-center shadow-sm" for="rate{{$i}}" style="width:40px;height:40px; font-weight: 800;">{{$i}}</label>
                </div>
              @endfor
            </div>
            <div class="d-flex justify-content-between smaller text-secondary mt-2 px-1">
              <span>Tidak Efektif</span>
              <span>Sangat Efektif</span>
            </div>
          </div>

          <div class="mb-4">
            <label class="form-label label-text text-muted mb-2">Keputusan HSE</label>
            <select name="status" class="form-select fw-bold text-success" required>
              <option value="closed">Tutup CAPA (Selesai)</option>
              <option value="open">Tolak (Perlu Perbaikan)</option>
            </select>
          </div>

          <button type="submit" class="btn btn-pandu-primary w-100 py-3 fw-bold shadow">
             SIMPAN VERIFIKASI <i class="fas fa-paper-plane ms-2"></i>
          </button>
        </form>
      </div>
    </div>
    @endif

    <!-- Personnel Card -->
    <div class="pandu-card shadow-sm border-0 mb-4">
      <div class="pandu-card-header bg-light border-bottom py-3">
        <h6 class="card-title-custom mb-0 fw-bold"><i class="fas fa-users me-2 text-primary"></i> Personil Terkait</h6>
      </div>
      <div class="pandu-card-body p-4">
        <div class="mb-4">
          <p class="label-text text-secondary mb-2">DITUGASKAN OLEH</p>
          <div class="d-flex align-items-center gap-3">
             <img src="https://ui-avatars.com/api/?name={{ urlencode($capaAction->assignedBy->name) }}&background=0D2137&color=fff" class="rounded-circle shadow-sm" style="width:36px;">
             <div>
                <p class="fw-bold mb-0 text-dark small">{{ $capaAction->assignedBy->name }}</p>
                <p class="smaller text-muted mb-0">HSE Team</p>
             </div>
          </div>
        </div>
        
        <div class="mb-4">
          <p class="label-text text-secondary mb-2">PENANGGUNG JAWAB (PIC)</p>
          <div class="d-flex align-items-center gap-3">
             <img src="https://ui-avatars.com/api/?name={{ urlencode($capaAction->assignedTo->name) }}&background=E67E22&color=fff" class="rounded-circle shadow-sm" style="width:36px;">
             <div>
                <p class="fw-bold mb-0 text-primary small">{{ $capaAction->assignedTo->name }}</p>
                <p class="smaller text-muted mb-0">{{ $capaAction->division->name }}</p>
             </div>
          </div>
        </div>

        @if($capaAction->verifiedBy)
        <div class="mb-0 pt-3 border-top mt-3">
          <p class="label-text text-secondary mb-2">DIVERIFIKASI OLEH</p>
          <div class="d-flex align-items-center gap-3">
             <img src="https://ui-avatars.com/api/?name={{ urlencode($capaAction->verifiedBy->name) }}&background=1A7A4A&color=fff" class="rounded-circle shadow-sm" style="width:36px;">
             <div>
                <p class="fw-bold mb-0 text-success small">{{ $capaAction->verifiedBy->name }}</p>
                <div class="d-flex gap-1 align-items-center">
                   @for($r=1; $r<=5; $r++)
                      <i class="fas fa-star text-warning" style="font-size: 8px; {{ $r > $capaAction->effectiveness_rating ? 'opacity: 0.2' : '' }}"></i>
                   @endfor
                </div>
             </div>
          </div>
        </div>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection

@push('styles')
<style>
  .bg-navy { background-color: var(--pandu-navy) !important; }
  .bg-primary-soft { background-color: rgba(21, 101, 192, 0.1); }
  .bg-success-soft { background-color: rgba(26, 122, 74, 0.1); }
  .bg-info-soft { background-color: rgba(13, 202, 240, 0.1); }
  .hover-zoom { transition: transform 0.3s ease; }
  .hover-zoom:hover { transform: scale(1.05); }
</style>
@endpush
