@extends('layouts.app')

@section('title', 'Detail HIRADC')
@section('page-title', 'Detail HIRADC')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('hse.dashboard') }}">Beranda</a></li>
  <li class="breadcrumb-item"><a href="{{ route('hse.hiradc.index') }}">HIRADC</a></li>
  <li class="breadcrumb-item active">{{ $hiradc->document_number }}</li>
@endsection

@section('page-actions')
  @if($hiradc->status === 'draft')
    <form action="{{ route('hse.hiradc.approve', $hiradc->id) }}" method="POST">
      @csrf
      <button type="submit" class="btn btn-pandu-success">
        <i class="fas fa-check-double me-2"></i> Setujui Dokumen
      </button>
    </form>
  @endif
  <button class="btn btn-outline-secondary" onclick="window.print()">
    <i class="fas fa-print me-2"></i> Cetak PDF
  </button>
@endsection

@section('content')
<div class="row g-4">
  <div class="col-lg-12">
    <div class="pandu-card">
      <div class="pandu-card-header bg-dark text-white">
        <div class="d-flex justify-content-between align-items-center w-100">
          <div>
            <h5 class="mb-0 fw-bold">{{ $hiradc->title }}</h5>
            <p class="mb-0 small opacity-75">{{ $hiradc->document_number }} · Status: {{ ucfirst($hiradc->status) }}</p>
          </div>
          <div class="text-end">
            <p class="mb-0 small fw-bold">Masa Berlaku:</p>
            <p class="mb-0 small text-warning">{{ $hiradc->valid_from->format('d M Y') }} - {{ $hiradc->valid_until->format('d M Y') }}</p>
          </div>
        </div>
      </div>
      <div class="pandu-card-body p-0">
        <div class="table-responsive">
          <table class="table table-bordered mb-0 small">
            <thead class="bg-light text-center align-middle fw-bold">
              <tr>
                <th rowspan="2">No</th>
                <th rowspan="2">Kegiatan</th>
                <th rowspan="2">Bahaya & Risiko</th>
                <th colspan="3">Risiko Awal</th>
                <th rowspan="2">Langkah Kontrol</th>
                <th colspan="3">Risiko Sisa</th>
                <th rowspan="2">PIC / Target</th>
              </tr>
              <tr>
                <th>S</th><th>P</th><th>Skor</th>
                <th>S</th><th>P</th><th>Skor</th>
              </tr>
            </thead>
            <tbody>
              @foreach($hiradc->items as $index => $item)
              <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $item->activity }}</td>
                <td>
                  <strong>{{ ucfirst($item->hazard_type) }}</strong><br>
                  <span class="text-secondary">{{ $item->hazard_description }}</span><br>
                  <em class="text-danger">P: {{ $item->potential_incident }}</em>
                </td>
                <td class="text-center">{{ $item->severity_before }}</td>
                <td class="text-center">{{ $item->probability_before }}</td>
                <td class="text-center fw-bold bg-light">{{ $item->risk_score_before }}</td>
                <td>
                  <span class="badge bg-info mb-1">{{ ucfirst($item->control_hierarchy) }}</span><br>
                  {{ $item->control_measures }}
                </td>
                <td class="text-center">{{ $item->severity_after }}</td>
                <td class="text-center">{{ $item->probability_after }}</td>
                <td class="text-center fw-bold bg-light">{{ $item->risk_score_after }}</td>
                <td>
                  <strong>{{ $item->pic_control }}</strong><br>
                  <span class="smaller">{{ $item->target_date->format('d/m/Y') }}</span>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-6">
    <div class="pandu-card">
      <div class="pandu-card-header">
        <h6 class="card-title-custom mb-0">Informasi Penyusunan</h6>
      </div>
      <div class="pandu-card-body">
        <div class="row">
          <div class="col-6">
            <p class="label-text text-secondary mb-1">DISUSUN OLEH</p>
            <p class="fw-bold mb-0">{{ $hiradc->preparedBy->name }}</p>
            <p class="small text-secondary">{{ $hiradc->created_at->format('d M Y, H:i') }}</p>
          </div>
          <div class="col-6">
            <p class="label-text text-secondary mb-1">DISETUJUI OLEH</p>
            <p class="fw-bold mb-0">{{ $hiradc->approvedBy->name ?? 'Belum disetujui' }}</p>
            <p class="small text-secondary">{{ $hiradc->approved_at ? $hiradc->approved_at->format('d M Y, H:i') : '-' }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('styles')
<style>
  @media print {
    .pandu-sidebar, .pandu-topbar, .page-actions, .breadcrumb { display: none !important; }
    .pandu-main { margin-left: 0 !important; }
    .pandu-card { border: none !important; box-shadow: none !important; }
    .pandu-card-header { background: #333 !important; color: white !important; -webkit-print-color-adjust: exact; }
  }
</style>
@endpush
