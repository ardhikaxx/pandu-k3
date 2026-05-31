@extends('layouts.app')

@section('title', 'Laporan Bahaya Saya')
@section('page-title', 'Temuan Bahaya')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('worker.dashboard') }}">Beranda</a></li>
  <li class="breadcrumb-item active">Laporan Bahaya</li>
@endsection

@section('page-actions')
  <a href="{{ route('worker.hazard.create') }}" class="btn btn-pandu-primary shadow-sm">
    <i class="fas fa-camera me-1"></i> <span class="d-none d-sm-inline">Lapor Bahaya Baru</span><span class="d-sm-none">Lapor Baru</span>
  </a>
@endsection

@section('content')
<div class="row">
  <div class="col-12">
    <div class="pandu-card shadow-sm border-0">
      <div class="pandu-card-header bg-white border-bottom py-3">
        <h6 class="card-title-custom mb-0 fw-bold text-dark"><i class="fas fa-history me-2 text-primary"></i> Riwayat Laporan Anda</h6>
      </div>
      <div class="pandu-card-body p-0">
        <!-- Desktop Table View -->
        <div class="table-responsive d-none d-md-block">
          <table class="table pandu-table table-hover align-middle mb-0">
            <thead class="bg-light">
              <tr>
                <th class="ps-4">No. Laporan</th>
                <th>Judul Temuan</th>
                <th>Area Kerja</th>
                <th>Tingkat</th>
                <th>Status</th>
                <th>Waktu Lapor</th>
                <th class="pe-4 text-end">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse($reports as $report)
              <tr>
                <td class="ps-4"><span class="doc-number shadow-sm">{{ $report->report_number }}</span></td>
                <td>
                  <div class="td-main text-dark small fw-bold">{{ Str::limit($report->title, 40) }}</div>
                  <div class="td-sub smaller text-muted">{{ ucfirst(str_replace('_', ' ', $report->hazard_type)) }}</div>
                </td>
                <td>
                   <div class="area-badge shadow-sm">
                      <i class="fas fa-location-dot me-1 smaller"></i>
                      {{ $report->workArea->name }}
                   </div>
                </td>
                <td><span class="risk-badge risk-{{ $report->severity }}">{{ ucfirst($report->severity) }}</span></td>
                <td><span class="status-badge status-{{ $report->status }} shadow-sm">{{ ucfirst(str_replace('_', ' ', $report->status)) }}</span></td>
                <td>
                  <div class="td-main small fw-bold text-dark">{{ $report->reported_at->format('d M Y') }}</div>
                  <div class="td-sub smaller fw-semibold">{{ $report->reported_at->format('H:i') }} WIB</div>
                </td>
                <td class="pe-4 text-end">
                  <a href="{{ route('worker.hazard.show', $report->id) }}" class="btn-action btn-view shadow-sm ms-auto" title="Lihat Detail"><i class="fas fa-eye"></i></a>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="7" class="text-center py-5 text-secondary">
                   <div class="opacity-25 mb-3"><i class="fas fa-folder-open fa-4x"></i></div>
                   <p class="fw-medium">Anda belum pernah mengirimkan laporan bahaya.</p>
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
                 <a href="{{ route('worker.hazard.show', $report->id) }}" class="list-group-item p-4 text-decoration-none border-bottom">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                       <span class="doc-number" style="font-size: 10px;">{{ $report->report_number }}</span>
                       <span class="status-badge status-{{ $report->status }}" style="font-size: 9px; padding: 2px 8px;">{{ ucfirst($report->status) }}</span>
                    </div>
                    <h6 class="fw-extrabold text-dark mb-1">{{ $report->title }}</h6>
                    <div class="d-flex align-items-center gap-2 mb-3">
                       <span class="smaller text-muted"><i class="fas fa-location-dot me-1"></i> {{ $report->workArea->name }}</span>
                       <span class="smaller text-muted">|</span>
                       <span class="smaller fw-bold text-{{ $report->severity === 'critical' ? 'danger' : ($report->severity === 'high' ? 'warning' : 'success') }}">{{ strtoupper($report->severity) }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                       <span class="smaller text-secondary"><i class="far fa-clock me-1"></i> {{ $report->reported_at->diffForHumans() }}</span>
                       <span class="text-primary small fw-bold">Detail <i class="fas fa-chevron-right ms-1"></i></span>
                    </div>
                 </a>
              @empty
                 <div class="p-5 text-center text-secondary">
                    <i class="fas fa-camera-retro fa-3x mb-3 opacity-25"></i>
                    <p class="small fw-bold">Ketuk tombol di atas untuk lapor.</p>
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
