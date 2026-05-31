@extends('layouts.app')

@section('title', 'Izin Kerja Saya')
@section('page-title', 'Izin Kerja (PTW)')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('worker.dashboard') }}">Beranda</a></li>
  <li class="breadcrumb-item active">Izin Kerja</li>
@endsection

@section('page-actions')
  <a href="{{ route('worker.permit.create') }}" class="btn btn-pandu-primary shadow-sm">
    <i class="fas fa-file-signature me-1"></i> <span class="d-none d-sm-inline">Ajukan Izin Baru</span><span class="d-sm-none">Ajukan Baru</span>
  </a>
@endsection

@section('content')
<div class="row">
  <div class="col-12">
    <div class="pandu-card shadow-sm border-0">
      <div class="pandu-card-header bg-white border-bottom py-3">
        <h6 class="card-title-custom mb-0 fw-bold text-dark"><i class="fas fa-history me-2 text-primary"></i> Riwayat Pengajuan Izin Kerja</h6>
      </div>
      <div class="pandu-card-body p-0">
        <!-- Desktop Table View -->
        <div class="table-responsive d-none d-md-block">
          <table class="table pandu-table table-hover align-middle mb-0">
            <thead class="bg-light">
              <tr>
                <th class="ps-4">No. Izin</th>
                <th>Pekerjaan / Tipe</th>
                <th>Area Kerja</th>
                <th>Waktu Pelaksanaan</th>
                <th>Status</th>
                <th class="pe-4 text-end">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse($permits as $ptw)
              <tr>
                <td class="ps-4"><span class="doc-number shadow-sm">{{ $ptw->permit_number }}</span></td>
                <td>
                  <div class="td-main text-dark small fw-bold">{{ Str::limit($ptw->title, 35) }}</div>
                  <div class="td-sub d-flex align-items-center gap-1">
                     <i class="fas fa-triangle-exclamation smaller text-danger opacity-75"></i>
                     {{ strtoupper(str_replace('_', ' ', $ptw->work_type)) }}
                  </div>
                </td>
                <td>
                   <div class="area-badge shadow-sm">
                      <i class="fas fa-location-dot me-1 smaller text-primary"></i>
                      {{ $ptw->workArea->name }}
                   </div>
                </td>
                <td>
                  <div class="td-main small fw-bold text-dark"><i class="far fa-calendar-alt me-1 opacity-50"></i> {{ $ptw->start_datetime->format('d M Y') }}</div>
                  <div class="td-sub smaller fw-semibold text-muted">{{ $ptw->start_datetime->format('H:i') }} - {{ $ptw->end_datetime->format('H:i') }} WIB</div>
                </td>
                <td><span class="status-badge status-{{ $ptw->status }} shadow-sm">{{ ucfirst($ptw->status) }}</span></td>
                <td class="pe-4 text-end">
                  <a href="#" class="btn-action btn-view shadow-sm ms-auto" title="Lihat Detail"><i class="fas fa-eye"></i></a>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="6" class="text-center py-5 text-secondary">
                   <div class="opacity-25 mb-3"><i class="fas fa-file-contract fa-4x"></i></div>
                   <p class="fw-medium">Anda belum pernah mengajukan izin kerja berisiko.</p>
                </td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        <!-- Mobile List View -->
        <div class="d-md-none">
           <div class="list-group list-group-flush">
              @forelse($permits as $ptw)
                 <a href="#" class="list-group-item p-4 text-decoration-none border-bottom">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                       <span class="doc-number" style="font-size: 10px;">{{ $ptw->permit_number }}</span>
                       <span class="status-badge status-{{ $ptw->status }}" style="font-size: 9px; padding: 2px 8px;">{{ ucfirst($ptw->status) }}</span>
                    </div>
                    <h6 class="fw-extrabold text-dark mb-1">{{ $ptw->title }}</h6>
                    <div class="d-flex align-items-center gap-2 mb-3">
                       <span class="smaller text-muted"><i class="fas fa-location-dot me-1 text-primary"></i> {{ $ptw->workArea->name }}</span>
                       <span class="smaller text-muted">|</span>
                       <span class="smaller fw-bold text-danger">{{ strtoupper(str_replace('_', ' ', $ptw->work_type)) }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                       <span class="smaller text-secondary"><i class="far fa-clock me-1"></i> {{ $ptw->start_datetime->format('d/m H:i') }}</span>
                       <span class="text-primary small fw-bold">Detail <i class="fas fa-chevron-right ms-1"></i></span>
                    </div>
                 </a>
              @empty
                 <div class="p-5 text-center text-secondary">
                    <i class="fas fa-file-signature fa-3x mb-3 opacity-25"></i>
                    <p class="small fw-bold">Ketuk tombol di atas untuk pengajuan.</p>
                 </div>
              @endforelse
           </div>
        </div>
      </div>
    </div>
    <div class="mt-4 px-2">
      {{ $permits->links() }}
    </div>
  </div>
</div>
@endsection
