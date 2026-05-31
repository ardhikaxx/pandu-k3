@extends('layouts.app')

@section('title', 'Otorisasi Izin Kerja')
@section('page-title', 'Pusat Izin Kerja (PTW)')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('hse.dashboard') }}">Beranda</a></li>
  <li class="breadcrumb-item active">Izin Kerja</li>
@endsection

@section('content')
<!-- Filter Section -->
<div class="row mb-4">
  <div class="col-12">
    <div class="pandu-card shadow-sm border-0">
      <div class="pandu-card-body p-3">
        <form action="{{ route('hse.permit.index') }}" method="GET" class="row g-3 align-items-end">
          <div class="col-12 col-md-3">
            <label class="label-text smaller text-muted mb-1">Tipe Pekerjaan</label>
            <select name="type" class="form-select form-select-sm" onchange="this.form.submit()">
              <option value="">Semua Tipe</option>
              <option value="hot_work" {{ request('type') == 'hot_work' ? 'selected' : '' }}>Hot Work</option>
              <option value="confined_space" {{ request('type') == 'confined_space' ? 'selected' : '' }}>Confined Space</option>
              <option value="working_at_height" {{ request('type') == 'working_at_height' ? 'selected' : '' }}>Working at Height</option>
            </select>
          </div>
          <div class="col-6 col-md-2">
            <label class="label-text smaller text-muted mb-1">Status</label>
            <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
              <option value="">Semua Status</option>
              <option value="submitted" {{ request('status') == 'submitted' ? 'selected' : '' }}>Submitted</option>
              <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
              <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
            </select>
          </div>
          <div class="col-12 col-md-4 ms-auto">
            <label class="label-text smaller text-muted mb-1">Cari Pengajuan</label>
            <div class="input-group input-group-sm">
              <span class="input-group-text bg-light border-end-0 text-secondary"><i class="fas fa-search"></i></span>
              <input type="text" name="search" class="form-control border-start-0" value="{{ request('search') }}" placeholder="Judul atau No. Izin...">
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="pandu-card shadow-sm border-0">
  <div class="pandu-card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
    <h6 class="card-title-custom mb-0 fw-bold"><i class="fas fa-file-contract me-2 text-primary"></i> Seluruh Pengajuan Izin Kerja Berisiko</h6>
    <span class="badge bg-light text-dark border shadow-sm">{{ $permits->total() }} Izin</span>
  </div>
  <div class="pandu-card-body p-0">
    <div class="table-responsive">
      <table class="table pandu-table table-hover align-middle mb-0">
        <thead class="bg-light">
          <tr>
            <th class="ps-4">No. Izin</th>
            <th>Pekerjaan / Tipe</th>
            <th>Pemohon & Pengawas</th>
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
               <div class="d-flex flex-column gap-1">
                  <div class="d-flex align-items-center gap-1">
                     <img src="https://ui-avatars.com/api/?name={{ urlencode($ptw->applicant->name) }}&background=EBF5FB&color=1565C0" class="rounded-circle border" style="width:20px;">
                     <span class="smaller text-dark fw-semibold">{{ $ptw->applicant->name }}</span>
                  </div>
                  <div class="d-flex align-items-center gap-1 opacity-75">
                     <i class="fas fa-user-check smaller ms-1"></i>
                     <span class="smaller">{{ $ptw->supervisor->name }}</span>
                  </div>
               </div>
            </td>
            <td>
               <div class="area-badge shadow-sm">
                  <i class="fas fa-location-dot me-1 small"></i>
                  {{ $ptw->workArea->name }}
               </div>
            </td>
            <td>
              <div class="td-main small fw-bold text-dark"><i class="far fa-calendar-alt me-1 opacity-50"></i> {{ $ptw->start_datetime->format('d M Y') }}</div>
              <div class="td-sub smaller fw-semibold"><i class="far fa-clock me-1 opacity-50"></i> {{ $ptw->start_datetime->format('H:i') }} - {{ $ptw->end_datetime->format('H:i') }} WIB</div>
            </td>
            <td>
               <span class="status-badge status-{{ $ptw->status }} shadow-sm">
                  {{ ucfirst($ptw->status) }}
               </span>
            </td>
            <td class="pe-4 text-end">
              <a href="{{ route('hse.permit.show', $ptw->id) }}" class="btn btn-sm btn-pandu-primary shadow-sm px-3">
                 <i class="fas fa-file-signature me-1"></i> Review
              </a>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="7" class="text-center py-5">
               <div class="opacity-25 mb-3"><i class="fas fa-file-signature fa-4x"></i></div>
               <p class="text-secondary fw-medium">Belum ada pengajuan izin kerja yang perlu diproses.</p>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
  <div class="table-pagination px-4 py-3 border-top bg-light-subtle">
    {{ $permits->appends(request()->query())->links() }}
  </div>
</div>
@endsection
