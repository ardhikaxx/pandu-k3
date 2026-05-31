@extends('layouts.app')

@section('title', 'Audit Trail')
@section('page-title', 'Log Aktivitas Sistem')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Beranda</a></li>
  <li class="breadcrumb-item active">Audit Trail</li>
@endsection

@section('content')
<div class="pandu-card">
  <div class="pandu-card-header d-flex justify-content-between align-items-center">
    <h6 class="card-title-custom mb-0">Riwayat Aksi Pengguna</h6>
    <div class="d-flex gap-2">
       <select class="form-select form-select-sm" style="width: 150px;">
         <option value="">Semua Modul</option>
         <option value="auth">Autentikasi</option>
         <option value="hazard_report">Bahaya</option>
         <option value="incident_report">Insiden</option>
       </select>
    </div>
  </div>
  <div class="pandu-card-body p-0">
    <div class="table-responsive">
      <table class="table pandu-table table-hover">
        <thead>
          <tr>
            <th>Waktu</th>
            <th>Pengguna</th>
            <th>Aksi</th>
            <th>Modul</th>
            <th>Deskripsi</th>
            <th>IP Address</th>
          </tr>
        </thead>
        <tbody>
          @forelse($logs as $log)
          <tr class="small">
            <td>
              <div class="td-main">{{ $log->created_at->format('d/m/Y') }}</div>
              <div class="td-sub">{{ $log->created_at->format('H:i:s') }} WIB</div>
            </td>
            <td>
              <div class="td-main">{{ $log->user->name }}</div>
              <div class="td-sub">{{ ucfirst($log->user->role) }}</div>
            </td>
            <td><span class="badge bg-{{ $log->action === 'delete' ? 'danger' : ($log->action === 'create' ? 'success' : 'info') }}">{{ strtoupper($log->action) }}</span></td>
            <td><div class="td-main fw-bold">{{ strtoupper($log->module) }}</div></td>
            <td>{{ $log->description }}</td>
            <td><code>{{ $log->ip_address }}</code></td>
          </tr>
          @empty
          <tr>
            <td colspan="6" class="text-center py-5">Belum ada catatan aktivitas.</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
  <div class="table-pagination p-3">
    {{ $logs->links() }}
  </div>
</div>
@endsection
