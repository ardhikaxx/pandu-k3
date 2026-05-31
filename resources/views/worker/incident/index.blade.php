@extends('layouts.app')

@section('title', 'Laporan Insiden Saya')
@section('page-title', 'Kejadian & Insiden')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('worker.dashboard') }}">Beranda</a></li>
  <li class="breadcrumb-item active">Laporan Insiden</li>
@endsection

@section('page-actions')
  <a href="{{ route('worker.incident.create') }}" class="btn btn-pandu-danger shadow-sm">
    <i class="fas fa-plus me-1"></i> <span class="d-none d-sm-inline">Laporkan Insiden Baru</span><span class="d-sm-none">Lapor Baru</span>
  </a>
@endsection

@section('content')
<div class="row">
  <div class="col-12">
    <div class="pandu-card shadow-sm border-0">
      <div class="pandu-card-header bg-white border-bottom py-3">
        <h6 class="card-title-custom mb-0 fw-bold text-dark"><i class="fas fa-history me-2 text-danger"></i> Riwayat Insiden Anda</h6>
      </div>
      <div class="pandu-card-body p-0">
        <!-- Desktop Table View -->
        <div class="table-responsive d-none d-md-block">
          <table class="table pandu-table table-hover align-middle mb-0">
            <thead class="bg-light">
              <tr>
                <th class="ps-4">No. Laporan</th>
                <th>Judul Insiden</th>
                <th>Area Kerja</th>
                <th>Klasifikasi</th>
                <th>Status</th>
                <th>Tanggal</th>
                <th class="pe-4 text-end">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse($reports as $report)
              <tr>
                <td class="ps-4"><span class="doc-number shadow-sm">{{ $report->report_number }}</span></td>
                <td>
                  <div class="td-main text-dark small fw-bold">{{ Str::limit($report->title, 40) }}</div>
                  <div class="td-sub d-flex align-items-center gap-1">
                     <i class="fas fa-tag smaller opacity-50"></i>
                     {{ ucfirst(str_replace('_', ' ', $report->incident_type)) }}
                  </div>
                </td>
                <td>
                   <div class="area-badge shadow-sm">
                      <i class="fas fa-location-dot me-1 smaller text-danger"></i>
                      {{ $report->workArea->name }}
                   </div>
                </td>
                <td>
                   <span class="badge bg-light text-dark border rounded-pill px-3 fw-bold" style="font-size: 10px;">{{ strtoupper($report->severity_classification) }}</span>
                </td>
                <td><span class="status-badge status-{{ $report->status }} shadow-sm">{{ ucfirst(str_replace('_', ' ', $report->status)) }}</span></td>
                <td>
                  <div class="td-main small fw-bold text-dark">{{ $report->incident_date->format('d M Y') }}</div>
                  <div class="td-sub smaller fw-semibold text-muted">{{ $report->incident_time }} WIB</div>
                </td>
                <td class="pe-4 text-end">
                  <a href="{{ route('worker.incident.show', $report->id) }}" class="btn-action btn-view shadow-sm ms-auto" title="Lihat Detail"><i class="fas fa-eye text-danger"></i></a>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="7" class="text-center py-5 text-secondary">
                   <div class="opacity-25 mb-3"><i class="fas fa-folder-open fa-4x text-danger"></i></div>
                   <p class="fw-medium">Anda belum pernah melaporkan insiden keselamatan.</p>
                </td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        <!-- Mobile List View -->
        <div class="d-md-none">
           <div class="list-group list-group-flush">
              @forelse($reports as $report)
                 <a href="{{ route('worker.incident.show', $report->id) }}" class="list-group-item p-4 text-decoration-none border-bottom">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                       <span class="doc-number" style="font-size: 10px; border-color: #f8d7da; color: #dc3545;">{{ $report->report_number }}</span>
                       <span class="status-badge status-{{ $report->status }}" style="font-size: 9px; padding: 2px 8px;">{{ ucfirst($report->status) }}</span>
                    </div>
                    <h6 class="fw-extrabold text-dark mb-1">{{ $report->title }}</h6>
                    <div class="d-flex align-items-center gap-2 mb-3">
                       <span class="smaller text-muted"><i class="fas fa-location-dot me-1 text-danger"></i> {{ $report->workArea->name }}</span>
                       <span class="smaller text-muted">|</span>
                       <span class="smaller fw-bold text-dark">{{ strtoupper($report->severity_classification) }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                       <span class="smaller text-secondary"><i class="far fa-calendar-alt me-1"></i> {{ $report->incident_date->format('d/m/Y') }}</span>
                       <span class="text-danger small fw-bold">Lihat Detail <i class="fas fa-chevron-right ms-1"></i></span>
                    </div>
                 </a>
              @empty
                 <div class="p-5 text-center text-secondary">
                    <i class="fas fa-clipboard-check fa-3x mb-3 opacity-25"></i>
                    <p class="small fw-bold">Semua aman? Laporkan jika terjadi insiden.</p>
                 </div>
              @endforelse
           </div>
        </div>
      </div>
    </div>
    <div class="mt-4 px-2">
      {{ $reports->links() }}
    </div>
  </div>
</div>
@endsection
