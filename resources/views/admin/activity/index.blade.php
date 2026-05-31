@extends('layouts.app')

@section('title', 'Audit Trail')
@section('page-title', 'Log Aktivitas Sistem')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Beranda</a></li>
  <li class="breadcrumb-item active">Audit Trail</li>
@endsection

@section('content')
<!-- Filter & Search Section -->
<div class="row mb-4">
  <div class="col-12">
    <div class="pandu-card">
      <div class="pandu-card-body">
        <form action="{{ route('admin.activity.index') }}" method="GET" class="row g-3">
          <div class="col-12 col-md-4 col-lg-3">
            <label class="form-label label-text">Filter Modul</label>
            <select name="module" class="form-select form-select-sm" onchange="this.form.submit()">
              <option value="">Semua Modul</option>
              <option value="auth" {{ request('module') == 'auth' ? 'selected' : '' }}>Autentikasi</option>
              <option value="hazard_report" {{ request('module') == 'hazard_report' ? 'selected' : '' }}>Bahaya</option>
              <option value="incident_report" {{ request('module') == 'incident_report' ? 'selected' : '' }}>Insiden</option>
              <option value="capa" {{ request('module') == 'capa' ? 'selected' : '' }}>CAPA</option>
            </select>
          </div>
          <div class="col-12 col-md-5 col-lg-4 ms-auto">
             <label class="form-label label-text">Cari Log</label>
             <div class="input-group input-group-sm">
                <span class="input-group-text bg-light border-end-0 text-secondary"><i class="fas fa-search"></i></span>
                <input type="text" name="search" class="form-control border-start-0" value="{{ request('search') }}" placeholder="Cari deskripsi atau IP...">
             </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="pandu-card">
  <div class="pandu-card-header d-flex justify-content-between align-items-center">
    <h6 class="card-title-custom mb-0"><i class="fas fa-history me-2 text-primary"></i> Riwayat Aksi Pengguna</h6>
    <span class="badge bg-light text-dark fw-bold">{{ $logs->total() }} Data</span>
  </div>
  <div class="pandu-card-body p-0">
    <div class="table-responsive">
      <table class="table pandu-table table-hover align-middle mb-0">
        <thead>
          <tr>
            <th class="ps-4">Waktu</th>
            <th>Pengguna</th>
            <th>Aksi</th>
            <th>Modul</th>
            <th>Deskripsi</th>
            <th class="pe-4 text-end">IP Address</th>
          </tr>
        </thead>
        <tbody>
          @forelse($logs as $log)
          <tr>
            <td class="ps-4">
              <div class="td-main">{{ $log->created_at->format('d/m/Y') }}</div>
              <div class="td-sub">{{ $log->created_at->format('H:i:s') }} WIB</div>
            </td>
            <td>
              <div class="d-flex align-items-center gap-2">
                <div class="icon-box-sm rounded-circle bg-light text-primary">
                  <i class="fas fa-user-circle"></i>
                </div>
                <div>
                  <div class="td-main">{{ $log->user->name }}</div>
                  <div class="badge-role-{{ $log->user->role }} d-inline-block px-2 py-0 rounded text-white" style="font-size: 10px;">{{ strtoupper(str_replace('_', ' ', $log->user->role)) }}</div>
                </div>
              </div>
            </td>
            <td>
              @php
                $actionColor = match($log->action) {
                  'create', 'post' => 'success',
                  'update', 'put', 'patch' => 'info',
                  'delete' => 'danger',
                  'login' => 'primary',
                  'logout' => 'secondary',
                  default => 'secondary'
                };
              @endphp
              <span class="badge bg-{{ $actionColor }} rounded-pill" style="font-size: 10px; min-width: 60px;">{{ strtoupper($log->action) }}</span>
            </td>
            <td>
              <div class="td-main fw-bold text-dark"><i class="fas fa-cube me-1 small opacity-50"></i> {{ strtoupper($log->module) }}</div>
            </td>
            <td style="max-width: 300px;">
              <p class="mb-0 small text-wrap">{{ $log->description }}</p>
            </td>
            <td class="pe-4 text-end">
              <code class="bg-light px-2 py-1 rounded small border">{{ $log->ip_address }}</code>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="6" class="text-center py-5">
               <div class="opacity-25 mb-3"><i class="fas fa-database fa-3x"></i></div>
               <p class="text-secondary">Belum ada catatan aktivitas sistem.</p>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
  <div class="table-pagination px-4 py-3 border-top">
    {{ $logs->appends(request()->query())->links() }}
  </div>
</div>
@endsection
