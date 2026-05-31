@extends('layouts.app')

@section('title', 'Toolbox Meeting')
@section('page-title', 'Safety Talk & Toolbox Meeting')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('supervisor.dashboard') }}">Beranda</a></li>
  <li class="breadcrumb-item active">Toolbox Meeting</li>
@endsection

@section('page-actions')
  <a href="{{ route('supervisor.toolbox.create') }}" class="btn btn-pandu-primary shadow-sm">
    <i class="fas fa-plus me-2"></i> Buat Jadwal TBM
  </a>
@endsection

@section('content')
<!-- Filter Section -->
<div class="row mb-4">
  <div class="col-12">
    <div class="pandu-card shadow-sm border-0">
      <div class="pandu-card-body p-3">
        <form action="{{ route('supervisor.toolbox.index') }}" method="GET" class="row g-3 align-items-end">
          <div class="col-12 col-md-4">
            <label class="label-text smaller text-muted mb-1">Cari Meeting</label>
            <div class="input-group input-group-sm">
              <span class="input-group-text bg-light border-end-0 text-secondary"><i class="fas fa-search"></i></span>
              <input type="text" name="search" class="form-control border-start-0" value="{{ request('search') }}" placeholder="Judul atau No. Meeting...">
            </div>
          </div>
          <div class="col-6 col-md-2">
             <label class="label-text smaller text-muted mb-1">Status</label>
             <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                <option value="">Semua Status</option>
                <option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
             </select>
          </div>
          <div class="col-12 col-md-2 ms-auto">
             <button type="submit" class="btn btn-sm btn-outline-secondary w-100"><i class="fas fa-filter me-1"></i> Terapkan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="pandu-card shadow-sm border-0">
  <div class="pandu-card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
    <h6 class="card-title-custom mb-0 fw-bold"><i class="fas fa-people-group me-2 text-primary"></i> Riwayat Safety Talk Divisi</h6>
    <span class="badge bg-light text-dark border shadow-sm fw-bold">{{ $meetings->total() }} Record</span>
  </div>
  <div class="pandu-card-body p-0">
    <div class="table-responsive">
      <table class="table pandu-table table-hover align-middle mb-0">
        <thead class="bg-light">
          <tr>
            <th class="ps-4">No. Meeting</th>
            <th>Judul / Topik</th>
            <th>Area Kerja</th>
            <th>Waktu & Durasi</th>
            <th>Facilitator</th>
            <th>Status</th>
            <th class="pe-4 text-end">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($meetings as $tbm)
          <tr>
            <td class="ps-4"><span class="doc-number shadow-sm">{{ $tbm->meeting_number }}</span></td>
            <td>
               <div class="td-main text-dark small fw-bold">{{ Str::limit($tbm->title, 35) }}</div>
               <div class="td-sub d-flex align-items-center gap-1">
                  <i class="fas fa-comment-dots smaller opacity-50"></i>
                  {{ Str::limit($tbm->topic, 30) }}
               </div>
            </td>
            <td>
               <div class="area-badge shadow-sm">
                  <i class="fas fa-location-dot me-1 small"></i>
                  {{ $tbm->workArea->name }}
               </div>
            </td>
            <td>
               <div class="td-main small fw-bold text-dark"><i class="far fa-calendar-alt me-1 opacity-50"></i> {{ $tbm->meeting_date->format('d M Y') }}</div>
               <div class="td-sub smaller fw-semibold"><i class="far fa-clock me-1 opacity-50"></i> {{ $tbm->start_time }} - {{ $tbm->end_time }}</div>
            </td>
            <td>
               <div class="d-flex align-items-center gap-2">
                  <img src="https://ui-avatars.com/api/?name={{ urlencode($tbm->facilitator->name) }}&background=E9ECEF&color=495057" class="rounded-circle border" style="width:24px;">
                  <span class="smaller text-dark fw-semibold">{{ $tbm->facilitator->name }}</span>
               </div>
            </td>
            <td>
               <span class="status-badge status-{{ $tbm->status }} shadow-sm">
                  {{ ucfirst($tbm->status) }}
               </span>
            </td>
            <td class="pe-4 text-end">
               <a href="{{ route('supervisor.toolbox.show', $tbm->id) }}" class="btn btn-sm btn-pandu-primary shadow-sm px-3">
                  <i class="fas fa-eye me-1"></i> Detail
               </a>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="7" class="text-center py-5">
               <div class="opacity-25 mb-3"><i class="fas fa-microphone-lines-slash fa-4x"></i></div>
               <p class="text-secondary fw-medium">Belum ada catatan toolbox meeting di divisi Anda.</p>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
  <div class="table-pagination px-4 py-3 border-top bg-light-subtle">
    {{ $meetings->appends(request()->query())->links() }}
  </div>
</div>
@endsection
