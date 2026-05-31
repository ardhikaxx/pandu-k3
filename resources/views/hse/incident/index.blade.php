@extends('layouts.app')

@section('title', 'Investigasi Insiden')
@section('page-title', 'Pusat Investigasi Insiden')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('hse.dashboard') }}">Beranda</a></li>
  <li class="breadcrumb-item active">Insiden</li>
@endsection

@section('content')
<!-- Filter Section -->
<div class="row mb-4">
  <div class="col-12">
    <div class="pandu-card shadow-sm border-0">
      <div class="pandu-card-body">
        <form action="{{ route('hse.incident.index') }}" method="GET" class="row g-3">
          <div class="col-12 col-md-3">
            <label class="form-label label-text">Tipe Insiden</label>
            <select name="type" class="form-select form-select-sm" onchange="this.form.submit()">
              <option value="">Semua Tipe</option>
              <option value="accident" {{ request('type') == 'accident' ? 'selected' : '' }}>Accident</option>
              <option value="near_miss" {{ request('type') == 'near_miss' ? 'selected' : '' }}>Near Miss</option>
              <option value="first_aid" {{ request('type') == 'first_aid' ? 'selected' : '' }}>First Aid</option>
            </select>
          </div>
          <div class="col-12 col-md-3">
            <label class="form-label label-text">Status</label>
            <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
              <option value="">Semua Status</option>
              <option value="submitted" {{ request('status') == 'submitted' ? 'selected' : '' }}>Baru Masuk</option>
              <option value="under_investigation" {{ request('status') == 'under_investigation' ? 'selected' : '' }}>Investigasi</option>
              <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Selesai</option>
            </select>
          </div>
          <div class="col-12 col-md-4 ms-auto">
            <label class="form-label label-text">Cari Laporan</label>
            <div class="input-group input-group-sm">
              <span class="input-group-text bg-light border-end-0 text-secondary"><i class="fas fa-search"></i></span>
              <input type="text" name="search" class="form-control border-start-0" value="{{ request('search') }}" placeholder="No. Laporan atau Judul...">
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="pandu-card shadow-sm border-0">
  <div class="pandu-card-header bg-white border-bottom d-flex justify-content-between align-items-center py-3">
    <h6 class="card-title-custom mb-0 fw-bold"><i class="fas fa-list-check me-2 text-primary"></i> Daftar Insiden & Kecelakaan Kerja</h6>
    <span class="badge bg-light text-dark fw-bold shadow-sm border">{{ $reports->total() }} Laporan</span>
  </div>
  <div class="pandu-card-body p-0">
    <div class="table-responsive">
      <table class="table pandu-table table-hover align-middle mb-0">
        <thead class="bg-light">
          <tr>
            <th class="ps-4">No. Laporan</th>
            <th>Kejadian / Tipe</th>
            <th>Area Kerja</th>
            <th>Klasifikasi</th>
            <th>Status</th>
            <th>Waktu Kejadian</th>
            <th class="pe-4 text-end">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($reports as $report)
          <tr>
            <td class="ps-4"><span class="doc-number shadow-sm">{{ $report->report_number }}</span></td>
            <td>
              <div class="td-main text-dark">{{ Str::limit($report->title, 40) }}</div>
              <div class="td-sub d-flex align-items-center gap-1">
                 <i class="fas fa-tag smaller opacity-50"></i>
                 {{ ucfirst(str_replace('_', ' ', $report->incident_type)) }}
              </div>
            </td>
            <td>
               <div class="area-badge shadow-sm">
                  <i class="fas fa-location-dot me-1 small"></i>
                  {{ $report->workArea->name }}
               </div>
            </td>
            <td>
              @php
                $sevClass = match($report->severity_classification) {
                  'minor' => 'success',
                  'moderate' => 'info',
                  'serious' => 'warning',
                  default => 'danger'
                };
              @endphp
              <span class="badge bg-{{ $sevClass }}-soft text-{{ $sevClass }} px-3 rounded-pill" style="font-size: 11px; font-weight: 800;">
                 {{ strtoupper($report->severity_classification) }}
              </span>
            </td>
            <td>
               <span class="status-badge status-{{ $report->status }} shadow-sm">
                  {{ ucfirst(str_replace('_', ' ', $report->status)) }}
               </span>
            </td>
            <td>
              <div class="td-main small fw-bold text-dark"><i class="far fa-calendar-alt me-1 opacity-50"></i> {{ $report->incident_date->format('d M Y') }}</div>
              <div class="td-sub smaller fw-semibold"><i class="far fa-clock me-1 opacity-50"></i> {{ $report->incident_time }} WIB</div>
            </td>
            <td class="pe-4 text-end">
              <a href="{{ route('hse.incident.show', $report->id) }}" class="btn btn-sm btn-pandu-primary shadow-sm px-3">
                <i class="fas fa-microscope me-1"></i> Investigasi
              </a>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="7" class="text-center py-5">
               <div class="opacity-25 mb-3"><i class="fas fa-clipboard-question fa-4x"></i></div>
               <p class="text-secondary fw-medium">Belum ada laporan insiden yang masuk untuk diproses.</p>
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
  .bg-success-soft { background-color: rgba(25, 135, 84, 0.1); }
  .bg-info-soft { background-color: rgba(13, 202, 240, 0.1); }
  .bg-warning-soft { background-color: rgba(255, 193, 7, 0.1); }
  .bg-danger-soft { background-color: rgba(220, 53, 69, 0.1); }
</style>
@endpush
