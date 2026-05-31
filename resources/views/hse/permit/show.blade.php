@extends('layouts.app')

@section('title', 'Review Izin Kerja')
@section('page-title', 'Otorisasi Izin Kerja')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('hse.dashboard') }}">Beranda</a></li>
  <li class="breadcrumb-item"><a href="{{ route('hse.permit.index') }}">Izin Kerja</a></li>
  <li class="breadcrumb-item active">{{ $permitToWork->permit_number }}</li>
@endsection

@section('content')
<div class="row g-4">
  <div class="col-lg-8">
    <div class="pandu-card">
      <div class="pandu-card-header bg-dark text-white">
        <div class="d-flex align-items-center gap-3">
           <span class="doc-number text-white" style="background:rgba(255,255,255,0.1)">{{ $permitToWork->permit_number }}</span>
           <span class="status-badge status-{{ $permitToWork->status }} text-white">{{ ucfirst($permitToWork->status) }}</span>
        </div>
      </div>
      <div class="pandu-card-body">
        <h3 class="fw-bold mb-4">{{ $permitToWork->title }}</h3>

        <div class="row mb-4 small">
           <div class="col-md-4">
              <p class="label-text text-secondary mb-1">TIPE PEKERJAAN</p>
              <p class="fw-bold text-danger"><i class="fas fa-triangle-exclamation me-1"></i> {{ strtoupper(str_replace('_', ' ', $permitToWork->work_type)) }}</p>
           </div>
           <div class="col-md-4">
              <p class="label-text text-secondary mb-1">WAKTU PELAKSANAAN</p>
              <p class="fw-bold mb-0">{{ $permitToWork->start_datetime->format('d M Y, H:i') }}</p>
              <p class="small text-secondary">s/d {{ $permitToWork->end_datetime->format('d M Y, H:i') }}</p>
           </div>
           <div class="col-md-4">
              <p class="label-text text-secondary mb-1">LOKASI KERJA</p>
              <p class="fw-bold"><i class="fas fa-location-dot me-1 text-primary"></i> {{ $permitToWork->workArea->name }}</p>
           </div>
        </div>

        <div class="mb-4">
           <p class="label-text text-secondary mb-1">DESKRIPSI PEKERJAAN</p>
           <p>{{ $permitToWork->description ?? 'Tidak ada deskripsi tambahan.' }}</p>
        </div>

        <div class="mb-4">
           <p class="label-text text-secondary mb-2">ALAT PELINDUNG DIRI (APD) WAJIB</p>
           <div class="d-flex flex-wrap gap-2">
              @foreach($permitToWork->required_ppe as $ppe)
                 <span class="badge bg-light text-dark border p-2"><i class="fas fa-shield-halved me-1 text-primary"></i> {{ ucfirst($ppe) }}</span>
              @endforeach
           </div>
        </div>

        <div class="mb-0">
           <p class="label-text text-secondary mb-1">LANGKAH PENCEGAHAN (PRECAUTIONS)</p>
           <div class="p-3 bg-light rounded border border-warning">
              {!! nl2br(e($permitToWork->precautions)) !!}
           </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-4">
    <div class="pandu-card mb-4">
       <div class="pandu-card-header bg-light">
          <h6 class="card-title-custom mb-0">Personil Terkait</h6>
       </div>
       <div class="pandu-card-body">
          <div class="mb-3">
             <p class="label-text text-secondary mb-1">PEMOHON (WORKER)</p>
             <div class="d-flex align-items-center gap-2">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($permitToWork->applicant->name) }}&background=E9ECEF&color=495057" class="rounded-circle" style="width: 32px; height: 32px;">
                <p class="fw-bold mb-0 small">{{ $permitToWork->applicant->name }}</p>
             </div>
          </div>
          <div class="mb-0">
             <p class="label-text text-secondary mb-1">SUPERVISOR PENGAWAS</p>
             <div class="d-flex align-items-center gap-2">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($permitToWork->supervisor->name) }}&background=E9ECEF&color=495057" class="rounded-circle" style="width: 32px; height: 32px;">
                <p class="fw-bold mb-0 small">{{ $permitToWork->supervisor->name }}</p>
             </div>
          </div>
       </div>
    </div>

    @if($permitToWork->status === 'submitted')
    <div class="pandu-card border-primary">
       <div class="pandu-card-header bg-primary text-white">
          <h6 class="mb-0 fw-bold"><i class="fas fa-file-signature me-2"></i> Keputusan HSE Manager</h6>
       </div>
       <div class="pandu-card-body">
          <form action="{{ route('hse.permit.approve', $permitToWork->id) }}" method="POST">
             @csrf
             <div class="mb-4">
                <label class="form-label">Tentukan Status Izin</label>
                <select name="status" class="form-control" required>
                   <option value="approved">Setujui (Approved)</option>
                   <option value="cancelled">Tolak (Rejected)</option>
                </select>
             </div>
             <button type="submit" class="btn btn-pandu-primary w-100 fw-bold py-2">
                PROSES IZIN KERJA <i class="fas fa-paper-plane ms-2"></i>
             </button>
          </form>
       </div>
    </div>
    @endif
  </div>
</div>
@endsection
