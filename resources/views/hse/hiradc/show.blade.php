@extends('layouts.app')

@section('title', 'Detail HIRADC')
@section('page-title', 'Detail Identifikasi Bahaya (HIRADC)')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('hse.dashboard') }}">Beranda</a></li>
  <li class="breadcrumb-item"><a href="{{ route('hse.hiradc.index') }}">HIRADC</a></li>
  <li class="breadcrumb-item active">{{ $hiradc->document_number }}</li>
@endsection

@section('page-actions')
  <div class="d-flex gap-2">
     @if($hiradc->status === 'draft')
       <form action="{{ route('hse.hiradc.approve', $hiradc->id) }}" method="POST">
         @csrf
         <button type="submit" class="btn btn-pandu-success shadow-sm">
           <i class="fas fa-check-double me-2"></i> Setujui Dokumen
         </button>
       </form>
     @endif
     <button class="btn btn-outline-secondary shadow-sm" onclick="window.print()">
       <i class="fas fa-print me-2"></i> Cetak PDF
     </button>
  </div>
@endsection

@section('content')
<div class="row g-4">
  <div class="col-lg-12">
    <div class="pandu-card shadow-sm border-0">
      <div class="pandu-card-header bg-navy text-white py-3">
        <div class="d-flex justify-content-between align-items-center w-100 flex-wrap gap-3">
          <div>
            <h4 class="mb-1 fw-extrabold">{{ $hiradc->title }}</h4>
            <p class="mb-0 small opacity-75 d-flex align-items-center gap-2">
               <span class="badge bg-white text-dark">{{ $hiradc->document_number }}</span>
               <i class="fas fa-circle smaller"></i>
               <span>Status: <strong>{{ strtoupper($hiradc->status) }}</strong></span>
            </p>
          </div>
          <div class="text-md-end">
            <p class="mb-0 small fw-bold text-white-50">MASA BERLAKU</p>
            <p class="mb-0 fw-bold text-warning fs-5">{{ $hiradc->valid_from->format('d M Y') }} - {{ $hiradc->valid_until->format('d M Y') }}</p>
          </div>
        </div>
      </div>
      <div class="pandu-card-body p-0">
        <div class="table-responsive">
          <table class="table table-bordered align-middle mb-0 small">
            <thead class="bg-light text-center fw-bold text-uppercase" style="font-size: 10px; letter-spacing: 0.5px;">
              <tr>
                <th rowspan="2" class="py-3">No</th>
                <th rowspan="2" class="py-3">Kegiatan / Tahapan</th>
                <th rowspan="2" class="py-3" style="min-width: 250px;">Bahaya, Tipe & Potensi Risiko</th>
                <th colspan="3" class="bg-warning-soft text-warning-dark border-bottom-0">Penilaian Risiko Awal</th>
                <th rowspan="2" class="py-3" style="min-width: 250px;">Langkah Kontrol (Mitigasi)</th>
                <th colspan="3" class="bg-success-soft text-success-dark border-bottom-0">Penilaian Risiko Sisa</th>
                <th rowspan="2" class="py-3">PIC & Target</th>
              </tr>
              <tr>
                <th class="bg-warning-soft" style="width: 50px;">S</th>
                <th class="bg-warning-soft" style="width: 50px;">P</th>
                <th class="bg-warning-soft" style="width: 60px;">Skor</th>
                <th class="bg-success-soft" style="width: 50px;">S</th>
                <th class="bg-success-soft" style="width: 50px;">P</th>
                <th class="bg-success-soft" style="width: 60px;">Skor</th>
              </tr>
            </thead>
            <tbody>
              @foreach($hiradc->items as $index => $item)
              <tr>
                <td class="text-center fw-bold text-muted">{{ $index + 1 }}</td>
                <td class="fw-bold text-dark">{{ $item->activity }}</td>
                <td>
                  <span class="badge bg-dark-soft text-dark mb-1" style="font-size: 9px;">{{ strtoupper($item->hazard_type) }}</span>
                  <div class="mb-1 fw-medium">{{ $item->hazard_description }}</div>
                  <div class="smaller text-danger fw-bold"><i class="fas fa-triangle-exclamation me-1"></i> {{ $item->potential_incident }}</div>
                </td>
                <td class="text-center">{{ $item->severity_before }}</td>
                <td class="text-center">{{ $item->probability_before }}</td>
                @php
                    $scoreBefore = $item->risk_score_before;
                    $classBefore = match(true) {
                        $scoreBefore <= 4 => 'bg-success',
                        $scoreBefore <= 9 => 'bg-info text-white',
                        $scoreBefore <= 14 => 'bg-warning text-dark',
                        $scoreBefore <= 19 => 'bg-danger text-white',
                        default => 'bg-danger text-white pulse-bg',
                    };
                @endphp
                <td class="text-center fw-extrabold {{ $classBefore }}">{{ $scoreBefore }}</td>
                <td>
                  <div class="d-flex align-items-center gap-1 mb-1">
                     <span class="badge bg-primary px-2 py-1" style="font-size: 9px;">{{ strtoupper($item->control_hierarchy) }}</span>
                  </div>
                  <div class="text-dark" style="font-size: 11.5px;">{{ $item->control_measures }}</div>
                </td>
                <td class="text-center">{{ $item->severity_after }}</td>
                <td class="text-center">{{ $item->probability_after }}</td>
                @php
                    $scoreAfter = $item->risk_score_after;
                    $classAfter = match(true) {
                        $scoreAfter <= 4 => 'bg-success text-white',
                        $scoreAfter <= 9 => 'bg-info text-white',
                        $scoreAfter <= 14 => 'bg-warning text-dark',
                        default => 'bg-danger text-white',
                    };
                @endphp
                <td class="text-center fw-extrabold {{ $classAfter }}">{{ $scoreAfter }}</td>
                <td>
                  <div class="fw-bold small text-dark">{{ $item->pic_control }}</div>
                  <div class="smaller text-muted"><i class="far fa-clock me-1"></i>{{ $item->target_date->format('d/m/Y') }}</div>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-12">
    <div class="row g-4">
      <div class="col-md-6">
        <div class="pandu-card shadow-sm border-0 h-100">
          <div class="pandu-card-header bg-light border-bottom py-3">
            <h6 class="card-title-custom mb-0 fw-bold"><i class="fas fa-info-circle me-2 text-primary"></i> Informasi Penyusunan</h6>
          </div>
          <div class="pandu-card-body p-4">
            <div class="row g-4">
              <div class="col-6">
                <p class="label-text text-secondary mb-1">DISUSUN OLEH</p>
                <div class="d-flex align-items-center gap-2">
                   <img src="https://ui-avatars.com/api/?name={{ urlencode($hiradc->preparedBy->name) }}&background=0D2137&color=fff" class="rounded-circle" style="width:30px;">
                   <div>
                      <p class="fw-bold mb-0 text-dark small">{{ $hiradc->preparedBy->name }}</p>
                      <p class="smaller text-muted mb-0">{{ $hiradc->created_at->format('d M Y, H:i') }}</p>
                   </div>
                </div>
              </div>
              <div class="col-6 border-start ps-4">
                <p class="label-text text-secondary mb-1">DISETUJUI OLEH</p>
                @if($hiradc->approvedBy)
                   <div class="d-flex align-items-center gap-2">
                      <img src="https://ui-avatars.com/api/?name={{ urlencode($hiradc->approvedBy->name) }}&background=1A7A4A&color=fff" class="rounded-circle" style="width:30px;">
                      <div>
                         <p class="fw-bold mb-0 text-success small">{{ $hiradc->approvedBy->name }}</p>
                         <p class="smaller text-muted mb-0">{{ $hiradc->approved_at->format('d M Y, H:i') }}</p>
                      </div>
                   </div>
                @else
                   <div class="d-flex align-items-center gap-2 opacity-50">
                      <div class="icon-box-sm bg-light rounded-circle"><i class="fas fa-user-clock"></i></div>
                      <p class="mb-0 small italic">Menunggu persetujuan...</p>
                   </div>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <div class="col-md-6">
         <div class="pandu-card shadow-sm border-0 h-100 bg-light-subtle">
            <div class="pandu-card-body p-4 text-center d-flex flex-column justify-content-center">
               <div class="mb-3">
                  <i class="fas fa-file-shield fa-3x text-primary opacity-25"></i>
               </div>
               <h6 class="fw-bold text-dark">Kepatuhan Standar SMK3</h6>
               <p class="small text-muted px-4">Dokumen ini disusun untuk memenuhi standar ISO 45001:2018 dan PP No. 50 Tahun 2012 tentang Sistem Manajemen K3.</p>
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
  .bg-dark-soft { background-color: rgba(0,0,0,0.05); }
  .bg-warning-soft { background-color: rgba(255, 193, 7, 0.08); }
  .text-warning-dark { color: #856404; }
  .bg-success-soft { background-color: rgba(40, 167, 69, 0.08); }
  .text-success-dark { color: #155724; }
  
  @keyframes pulse-bg {
    0% { background-color: rgba(220, 53, 69, 1); }
    50% { background-color: rgba(220, 53, 69, 0.7); }
    100% { background-color: rgba(220, 53, 69, 1); }
  }
  .pulse-bg { animation: pulse-bg 1.5s infinite; }

  @media print {
    .pandu-sidebar, .pandu-topbar, .page-actions, .breadcrumb, .pandu-footer { display: none !important; }
    .pandu-main { margin-left: 0 !important; padding: 0 !important; }
    .pandu-content { padding: 0 !important; }
    .pandu-card { border: 1px solid #ddd !important; box-shadow: none !important; }
    .pandu-card-header { background: #0D2137 !important; color: white !important; -webkit-print-color-adjust: exact; }
    .bg-success { background-color: #28a745 !important; color: white !important; -webkit-print-color-adjust: exact; }
    .bg-warning { background-color: #ffc107 !important; color: black !important; -webkit-print-color-adjust: exact; }
    .bg-danger { background-color: #dc3545 !important; color: white !important; -webkit-print-color-adjust: exact; }
    .bg-info { background-color: #17a2b8 !important; color: white !important; -webkit-print-color-adjust: exact; }
  }
</style>
@endpush
