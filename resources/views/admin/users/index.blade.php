@extends('layouts.app')

@section('title', 'Manajemen Pengguna')
@section('page-title', 'Daftar Pengguna Sistem')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Beranda</a></li>
  <li class="breadcrumb-item active">Pengguna</li>
@endsection

@section('page-actions')
  <a href="{{ route('admin.users.create') }}" class="btn btn-pandu-primary">
    <i class="fas fa-user-plus me-2"></i> Tambah Pengguna
  </a>
@endsection

@section('content')
<div class="pandu-card">
  <div class="pandu-card-header">
    <h6 class="card-title-custom mb-0">Seluruh Akun Terdaftar</h6>
  </div>
  <div class="pandu-card-body p-0">
    <div class="table-responsive">
      <table class="table pandu-table">
        <thead>
          <tr>
            <th>Nama / NIK</th>
            <th>Email</th>
            <th>Peran</th>
            <th>Divisi / Area</th>
            <th>Status</th>
            <th>Login Terakhir</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($users as $u)
          <tr>
            <td>
              <div class="td-main">{{ $u->name }}</div>
              <div class="td-sub">{{ $u->employee_id ?? 'N/A' }}</div>
            </td>
            <td>{{ $u->email }}</td>
            <td><span class="badge-role-{{ $u->role }} text-white px-2 py-1 rounded small">{{ ucfirst(str_replace('_', ' ', $u->role)) }}</span></td>
            <td>
              <div class="td-main">{{ $u->division->name ?? 'Global' }}</div>
              <div class="td-sub">{{ $u->company->name ?? '-' }}</div>
            </td>
            <td><span class="status-badge status-{{ $u->is_active ? 'active' : 'overdue' }}">{{ $u->is_active ? 'Aktif' : 'Nonaktif' }}</span></td>
            <td><div class="td-sub">{{ $u->last_login_at ? $u->last_login_at->diffForHumans() : 'Belum pernah' }}</div></td>
            <td>
               <button class="btn-action btn-view"><i class="fas fa-edit"></i></button>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="7" class="text-center py-5">Tidak ada pengguna.</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
