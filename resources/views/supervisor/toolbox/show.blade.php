@extends('layouts.app')

@section('title', 'Detail TBM')
@section('page-title', 'Detail Toolbox Meeting')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('supervisor.dashboard') }}">Beranda</a></li>
  <li class="breadcrumb-item"><a href="{{ route('supervisor.toolbox.index') }}">Toolbox Meeting</a></li>
  <li class="breadcrumb-item active">{{ $toolboxMeeting->meeting_number }}</li>
@endsection

@section('content')
<div class="row g-4">
  <div class="col-lg-8">
    <div class="pandu-card">
      <div class="pandu-card-header bg-dark text-white">
        <div class="d-flex align-items-center gap-3">
           <span class="doc-number text-white" style="background:rgba(255,255,255,0.1)">{{ $toolboxMeeting->meeting_number }}</span>
           <span class="status-badge status-{{ $toolboxMeeting->status }} text-white">{{ ucfirst($toolboxMeeting->status) }}</span>
        </div>
      </div>
      <div class="pandu-card-body">
        <h3 class="fw-bold mb-4">{{ $toolboxMeeting->title }}</h3>

        <div class="mb-4">
           <p class="label-text text-secondary mb-1">TOPIK UTAMA</p>
           <p class="fw-bold text-dark fs-5">{{ $toolboxMeeting->topic }}</p>
        </div>

        <div class="mb-4">
           <p class="label-text text-secondary mb-1">AGENDA & MATERI</p>
           <div class="p-3 bg-light rounded border">
              {!! nl2br(e($toolboxMeeting->agenda)) !!}
           </div>
        </div>

        <div class="row g-3">
           <div class="col-md-6">
              <p class="label-text text-secondary mb-1">LOKASI</p>
              <p class="fw-bold"><i class="fas fa-location-dot me-1 text-primary"></i> {{ $toolboxMeeting->location }}</p>
           </div>
           <div class="col-md-6">
              <p class="label-text text-secondary mb-1">WAKTU</p>
              <p class="fw-bold"><i class="fas fa-clock me-1 text-secondary"></i> {{ $toolboxMeeting->meeting_date->format('d M Y') }}, {{ $toolboxMeeting->start_time }} - {{ $toolboxMeeting->end_time }}</p>
           </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-4">
    <div class="pandu-card">
       <div class="pandu-card-header">
          <h6 class="card-title-custom mb-0">Daftar Kehadiran</h6>
       </div>
       <div class="pandu-card-body p-0">
          <div class="list-group list-group-flush">
             @forelse($toolboxMeeting->attendances as $att)
                <div class="list-group-item d-flex justify-content-between align-items-center">
                   <div class="small">
                      <p class="mb-0 fw-bold">{{ $att->user->name }}</p>
                      <p class="mb-0 text-secondary smaller">{{ $att->user->employee_id }}</p>
                   </div>
                   <span class="badge bg-success-soft text-success">{{ ucfirst($att->attendance_status) }}</span>
                </div>
             @empty
                <div class="p-4 text-center opacity-50 small">Belum ada data kehadiran.</div>
             @endforelse
          </div>
       </div>
    </div>
  </div>
</div>
@endsection
