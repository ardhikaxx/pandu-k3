@extends('layouts.app')

@section('title', 'Manajemen Pengguna')
@section('page-title', 'Daftar Pengguna Sistem')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Beranda</a></li>
  <li class="breadcrumb-item active">Pengguna</li>
@endsection

@section('page-actions')
  <a href="{{ route('admin.users.create') }}" class="btn btn-pandu-primary shadow-sm">
    <i class="fas fa-user-plus me-2"></i> Tambah Pengguna
  </a>
@endsection

@section('content')
<!-- Filter Section -->
<div class="row mb-4">
  <div class="col-12">
    <div class="pandu-card">
      <div class="pandu-card-body">
        <form action="{{ route('admin.users.index') }}" method="GET" class="row g-3">
          <div class="col-12 col-md-3">
            <label class="form-label label-text">Role</label>
            <select name="role" class="form-select form-select-sm" onchange="this.form.submit()">
              <option value="">Semua Peran</option>
              <option value="super_admin" {{ request('role') == 'super_admin' ? 'selected' : '' }}>Super Admin</option>
              <option value="hse_manager" {{ request('role') == 'hse_manager' ? 'selected' : '' }}>HSE Manager</option>
              <option value="supervisor" {{ request('role') == 'supervisor' ? 'selected' : '' }}>Supervisor</option>
              <option value="worker" {{ request('role') == 'worker' ? 'selected' : '' }}>Worker</option>
            </select>
          </div>
          <div class="col-12 col-md-5 ms-auto">
            <label class="form-label label-text">Cari Pengguna</label>
            <div class="input-group input-group-sm">
              <span class="input-group-text bg-light border-end-0 text-secondary"><i class="fas fa-search"></i></span>
              <input type="text" name="search" class="form-control border-start-0" value="{{ request('search') }}" placeholder="Cari nama, email, atau NIK...">
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="pandu-card">
  <div class="pandu-card-header d-flex justify-content-between align-items-center">
    <h6 class="card-title-custom mb-0"><i class="fas fa-users me-2 text-primary"></i> Seluruh Akun Terdaftar</h6>
    <span class="badge bg-light text-dark fw-bold">{{ $users->total() }} Akun</span>
  </div>
  <div class="pandu-card-body p-0">
    <div class="table-responsive">
      <table class="table pandu-table table-hover align-middle mb-0">
        <thead>
          <tr>
            <th class="ps-4">Pengguna</th>
            <th>Email</th>
            <th>Peran</th>
            <th>Unit Kerja</th>
            <th>Status</th>
            <th>Login Terakhir</th>
            <th class="pe-4 text-end">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($users as $u)
          <tr>
            <td class="ps-4">
              <div class="d-flex align-items-center gap-3">
                <img src="{{ $u->photo ? asset('storage/'.$u->photo) : 'https://ui-avatars.com/api/?name='.urlencode($u->name).'&background=E9ECEF&color=495057' }}" class="rounded-circle border" style="width: 40px; height: 40px; object-fit: cover;">
                <div>
                  <div class="td-main">{{ $u->name }}</div>
                  <div class="td-sub">NIK: {{ $u->employee_id ?? 'N/A' }}</div>
                </div>
              </div>
            </td>
            <td>
               <div class="small fw-semibold text-dark">{{ $u->email }}</div>
            </td>
            <td>
               <span class="badge-role-{{ $u->role }} d-inline-block px-2 py-1 rounded text-white" style="font-size: 11px;">
                  {{ strtoupper(str_replace('_', ' ', $u->role)) }}
               </span>
            </td>
            <td>
              <div class="td-main">{{ $u->division->name ?? 'Global' }}</div>
              <div class="td-sub">{{ $u->company->name ?? '-' }}</div>
            </td>
            <td>
               <span class="status-badge status-{{ $u->is_active ? 'active' : 'overdue' }}">
                  {{ $u->is_active ? 'Aktif' : 'Nonaktif' }}
               </span>
            </td>
            <td>
               <div class="td-sub fw-semibold">
                  <i class="fas fa-clock me-1 opacity-50"></i>
                  {{ $u->last_login_at ? $u->last_login_at->diffForHumans() : 'Belum pernah' }}
               </div>
            </td>
            <td class="pe-4 text-end">
               <div class="action-btns justify-content-end">
                  <a href="#" class="btn-action btn-view" title="Edit Profil"><i class="fas fa-user-edit"></i></a>
                  <button class="btn-action btn-delete" title="Nonaktifkan"><i class="fas fa-ban"></i></button>
               </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="7" class="text-center py-5">
               <div class="opacity-25 mb-3"><i class="fas fa-users-slash fa-3x"></i></div>
               <p class="text-secondary">Tidak ada pengguna yang ditemukan.</p>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
  <div class="table-pagination px-4 py-3 border-top">
    {{ $users->appends(request()->query())->links() }}
  </div>
</div>
@endsection
