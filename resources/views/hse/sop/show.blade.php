@extends('layouts.app')

@section('title', 'Detail SOP')
@section('page-title', 'Detail Prosedur')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('hse.dashboard') }}">Beranda</a></li>
  <li class="breadcrumb-item"><a href="{{ route('hse.sop.index') }}">SOP</a></li>
  <li class="breadcrumb-item active">{{ $sop->document_number }}</li>
@endsection

@section('page-actions')
  @if($sop->status === 'draft')
    <form action="{{ route('hse.sop.approve', $sop->id) }}" method="POST">
      @csrf
      <button type="submit" class="btn btn-pandu-success">
        <i class="fas fa-check-circle me-2"></i> Aktifkan SOP
      </button>
    </form>
  @endif
  @if($sop->document_path)
    <a href="{{ asset('storage/'.$sop->document_path) }}" class="btn btn-outline-danger" target="_blank">
      <i class="fas fa-file-pdf me-2"></i> Download PDF
    </a>
  @endif
@endsection

@section('content')
<div class="row g-4">
  <div class="col-lg-8">
    <div class="pandu-card">
      <div class="pandu-card-header bg-dark text-white d-flex justify-content-between align-items-center">
        <div>
           <h5 class="mb-0 fw-bold">{{ $sop->title }}</h5>
           <p class="mb-0 small opacity-75">{{ $sop->document_number }} · v{{ $sop->version }}</p>
        </div>
        <span class="status-badge status-{{ $sop->status }} text-white">{{ ucfirst($sop->status) }}</span>
      </div>
      <div class="pandu-card-body">
        <div class="sop-content p-4 bg-white border rounded">
          {!! nl2br(e($sop->content)) !!}
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-4">
    <div class="pandu-card">
      <div class="pandu-card-header">
        <h6 class="card-title-custom mb-0">Metadata SOP</h6>
      </div>
      <div class="pandu-card-body">
        <div class="mb-3">
          <p class="label-text text-secondary mb-1">KATEGORI</p>
          <p class="fw-bold mb-0 text-dark">{{ ucfirst(str_replace('_', ' ', $sop->category)) }}</p>
        </div>
        <div class="mb-3">
          <p class="label-text text-secondary mb-1">AREA / DIVISI</p>
          <p class="fw-bold mb-0 text-dark">{{ $sop->workArea->name ?? 'Seluruh Area' }}</p>
          <p class="small text-secondary">{{ $sop->division->name ?? 'Seluruh Divisi' }}</p>
        </div>
        <div class="mb-3">
          <p class="label-text text-secondary mb-1">TANGGAL BERLAKU</p>
          <p class="fw-bold mb-0 text-dark">{{ $sop->effective_date->format('d M Y') }}</p>
        </div>
        <div class="mb-0">
          <p class="label-text text-secondary mb-1">DIBUAT OLEH</p>
          <p class="fw-bold mb-0 text-dark">{{ $sop->createdBy->name }}</p>
          <p class="small text-secondary">{{ $sop->created_at->format('d M Y') }}</p>
        </div>
      </div>
    </div>

    <div class="pandu-card">
      <div class="pandu-card-body text-center py-4">
         <div class="metric-number mb-1 text-primary">{{ $sop->view_count }}</div>
         <p class="text-secondary mb-0 label-text">TOTAL KUNJUNGAN</p>
      </div>
    </div>
  </div>
</div>
@endsection

@push('styles')
<style>
.sop-content { font-size: 0.95rem; line-height: 1.8; color: #333; }
</style>
@endpush
