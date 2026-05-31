@extends('layouts.app')

@section('title', 'Jadwal Inspeksi')
@section('page-title', 'Pusat Inspeksi K3')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('hse.dashboard') }}">Beranda</a></li>
  <li class="breadcrumb-item active">Inspeksi</li>
@endsection

@section('page-actions')
  <a href="{{ route('hse.inspection.create') }}" class="btn btn-pandu-primary shadow-sm">
    <i class="fas fa-calendar-plus me-2"></i> Jadwalkan Inspeksi
  </a>
@endsection

@section('content')
<!-- Filter Section -->
<div class="row mb-4">
  <div class="col-12">
    <div class="pandu-card shadow-sm border-0">
      <div class="pandu-card-body p-3">
        <form action="{{ route('hse.inspection.index') }}" method="GET" class="row g-3 align-items-end">
          <div class="col-12 col-md-3">
            <label class="label-text smaller text-muted mb-1">Tipe Inspeksi</label>
            <select name="type" class="form-select form-select-sm" onchange="this.form.submit()">
              <option value="">Semua Tipe</option>
              <option value="daily" {{ request('type') == 'daily' ? 'selected' : '' }}>Harian</option>
              <option value="weekly" {{ request('type') == 'weekly' ? 'selected' : '' }}>Mingguan</option>
              <option value="monthly" {{ request('type') == 'monthly' ? 'selected' : '' }}>Bulanan</option>
            </select>
          </div>
          <div class="col-6 col-md-2">
            <label class="label-text smaller text-muted mb-1">Status</label>
            <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
              <option value="">Semua Status</option>
              <option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
              <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
              <option value="overdue" {{ request('status') == 'overdue' ? 'selected' : '' }}>Overdue</option>
            </select>
          </div>
          <div class="col-12 col-md-4 ms-auto">
            <label class="label-text smaller text-muted mb-1">Cari Inspeksi</label>
            <div class="input-group input-group-sm">
              <span class="input-group-text bg-light border-end-0 text-secondary"><i class="fas fa-search"></i></span>
              <input type="text" name="search" class="form-control border-start-0" value="{{ request('search') }}" placeholder="Judul atau No. Inspeksi...">
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="pandu-card shadow-sm border-0">
  <div class="pandu-card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
    <h6 class="card-title-custom mb-0 fw-bold"><i class="fas fa-clipboard-list me-2 text-primary"></i> Seluruh Jadwal & Riwayat Inspeksi</h6>
    <span class="badge bg-light text-dark border shadow-sm">{{ $inspections->total() }} Data</span>
  </div>
  <div class="pandu-card-body p-0">
    <div class="table-responsive">
      <table class="table pandu-table table-hover align-middle mb-0">
        <thead class="bg-light">
          <tr>
            <th class="ps-4">No. Inspeksi</th>
            <th>Judul / Tipe</th>
            <th>Area Kerja</th>
            <th>Inspektur</th>
            <th>Tanggal Jadwal</th>
            <th>Status</th>
            <th class="pe-4">Progres</th>
          </tr>
        </thead>
        <tbody>
          @forelse($inspections as $ins)
          <tr>
            <td class="ps-4"><span class="doc-number shadow-sm">{{ $ins->inspection_number }}</span></td>
            <td>
              <div class="td-main text-dark small fw-bold">{{ $ins->title }}</div>
              <div class="td-sub d-flex align-items-center gap-1">
                 <i class="fas fa-tag smaller opacity-50"></i>
                 {{ ucfirst($ins->inspection_type) }}
              </div>
            </td>
            <td>
              <div class="area-badge shadow-sm">
                 <i class="fas fa-location-dot me-1 small"></i>
                 {{ $ins->workArea->name }}
              </div>
            </td>
            <td>
               <div class="d-flex align-items-center gap-2">
                  <img src="https://ui-avatars.com/api/?name={{ urlencode($ins->inspector->name) }}&background=E9ECEF&color=495057" class="rounded-circle border" style="width:24px;">
                  <span class="small text-dark">{{ $ins->inspector->name }}</span>
               </div>
            </td>
            <td>
              <div class="td-main small fw-bold text-dark"><i class="far fa-calendar-alt me-1 opacity-50"></i> {{ $ins->scheduled_date->format('d M Y') }}</div>
            </td>
            <td>
               <span class="status-badge status-{{ $ins->status }} shadow-sm">
                  {{ ucfirst($ins->status) }}
               </span>
            </td>
            <td class="pe-4">
              <div class="d-flex align-items-center gap-3">
                <div class="progress flex-grow-1" style="height: 8px; min-width: 80px;">
                  <div class="progress-bar bg-primary rounded-pill shadow-sm" style="width: {{ $ins->completion_percentage }}%"></div>
                </div>
                <span class="smaller fw-bold text-dark">{{ round($ins->completion_percentage) }}%</span>
              </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="7" class="text-center py-5">
               <div class="opacity-25 mb-3"><i class="fas fa-calendar-check fa-4x"></i></div>
               <p class="text-secondary fw-medium">Belum ada jadwal inspeksi yang dibuat.</p>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
  <div class="table-pagination px-4 py-3 border-top bg-light-subtle">
    {{ $inspections->appends(request()->query())->links() }}
  </div>
</div>
@endsection

@push('styles')
<style>
  .smaller { font-size: 0.75rem; }
  .progress { background-color: #f0f0f0; }
</style>
@endpush
