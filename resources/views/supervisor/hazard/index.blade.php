@extends('layouts.app')

@section('title', 'Verifikasi Laporan Bahaya')
@section('page-title', 'Pusat Verifikasi Bahaya')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('supervisor.dashboard') }}">Beranda</a></li>
  <li class="breadcrumb-item active">Verifikasi Bahaya</li>
@endsection

@section('content')
<!-- Filter Section -->
<div class="row mb-4">
  <div class="col-12">
    <div class="pandu-card shadow-sm border-0">
      <div class="pandu-card-body p-3">
        <form action="{{ route('supervisor.hazard.index') }}" method="GET" class="row g-3 align-items-end">
          <div class="col-12 col-md-3">
            <label class="label-text smaller text-muted mb-1">Prioritas</label>
            <select name="priority" class="form-select form-select-sm" onchange="this.form.submit()">
              <option value="">Semua Prioritas</option>
              <option value="emergency" {{ request('priority') == 'emergency' ? 'selected' : '' }}>Emergency</option>
              <option value="urgent" {{ request('priority') == 'urgent' ? 'selected' : '' }}>Urgent</option>
              <option value="normal" {{ request('priority') == 'normal' ? 'selected' : '' }}>Normal</option>
            </select>
          </div>
          <div class="col-6 col-md-2">
            <label class="label-text smaller text-muted mb-1">Status</label>
            <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
              <option value="">Semua Status</option>
              <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>Open</option>
              <option value="in_review" {{ request('status') == 'in_review' ? 'selected' : '' }}>In Review</option>
              <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Resolved</option>
            </select>
          </div>
          <div class="col-12 col-md-4 ms-auto">
            <label class="label-text smaller text-muted mb-1">Cari Laporan</label>
            <div class="input-group input-group-sm">
              <span class="input-group-text bg-light border-end-0 text-secondary"><i class="fas fa-search"></i></span>
              <input type="text" name="search" class="form-control border-start-0" value="{{ request('search') }}" placeholder="Judul atau No. Laporan...">
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="pandu-card shadow-sm border-0">
  <div class="pandu-card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
    <h6 class="card-title-custom mb-0 fw-bold"><i class="fas fa-triangle-exclamation me-2 text-warning"></i> Temuan Bahaya - Divisi {{ auth()->user()->division->name }}</h6>
    <span class="badge bg-light text-dark border shadow-sm fw-bold">{{ $reports->total() }} Laporan</span>
  </div>
  <div class="pandu-card-body p-0">
    <div class="table-responsive">
      <table class="table pandu-table table-hover align-middle mb-0">
        <thead class="bg-light">
          <tr>
            <th class="ps-4">No. Laporan</th>
            <th>Judul / Pelapor</th>
            <th>Area</th>
            <th>Prioritas</th>
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
              <div class="td-sub d-flex align-items-center gap-1 text-muted">
                 <i class="fas fa-user-pen smaller opacity-50"></i>
                 {{ $report->reporter->name }}
              </div>
            </td>
            <td>
               <div class="area-badge shadow-sm">
                  <i class="fas fa-location-dot me-1 small"></i>
                  {{ $report->workArea->name }}
               </div>
            </td>
            <td>
               <div class="d-flex align-items-center gap-2">
                  <span class="priority-dot priority-{{ $report->priority }} shadow-sm"></span>
                  @php
                    $prioClass = match($report->priority) {
                      'emergency' => 'danger',
                      'urgent' => 'warning',
                      default => 'success'
                    };
                  @endphp
                  <span class="small fw-bold text-{{ $prioClass }}">{{ strtoupper($report->priority) }}</span>
               </div>
            </td>
            <td>
               <span class="status-badge status-{{ $report->status }} shadow-sm">
                  {{ ucfirst(str_replace('_', ' ', $report->status)) }}
               </span>
            </td>
            <td>
              <div class="td-main small fw-bold text-dark"><i class="far fa-calendar-alt me-1 opacity-50"></i> {{ $report->reported_at->format('d M Y') }}</div>
              <div class="td-sub smaller fw-semibold"><i class="far fa-clock me-1 opacity-50"></i> {{ $report->reported_at->diffForHumans() }}</div>
            </td>
            <td class="pe-4 text-end">
              <a href="{{ route('supervisor.hazard.show', $report->id) }}" class="btn btn-sm btn-pandu-primary shadow-sm px-3">
                <i class="fas fa-user-check me-1"></i> Verifikasi
              </a>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="7" class="text-center py-5">
               <div class="opacity-25 mb-3"><i class="fas fa-check-circle fa-4x text-success"></i></div>
               <p class="text-secondary fw-medium">Luar biasa! Tidak ada laporan bahaya yang menunggu verifikasi di divisi Anda.</p>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
  <div class="table-pagination px-4 py-3 border-top bg-light-subtle">
    {{ $reports->appends(request()->query())->links() }}
  </div>
</div>
@endsection

@push('styles')
<style>
  .priority-dot { width: 10px; height: 10px; border-radius: 50%; }
  .priority-emergency { background-color: var(--color-danger); box-shadow: 0 0 8px rgba(192,57,43,0.5); }
  .priority-urgent { background-color: var(--color-warning); }
  .priority-normal { background-color: var(--color-success); }
</style>
@endpush
