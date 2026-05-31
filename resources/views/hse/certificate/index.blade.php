@extends('layouts.app')

@section('title', 'Kepatuhan Kompetensi')
@section('page-title', 'Sertifikat Kompetensi')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('hse.dashboard') }}">Beranda</a></li>
  <li class="breadcrumb-item active">Sertifikat</li>
@endsection

@section('page-actions')
  <a href="{{ route('hse.certificate.create') }}" class="btn btn-pandu-primary shadow-sm">
    <i class="fas fa-plus me-2"></i> Tambah Sertifikat
  </a>
@endsection

@section('content')
<!-- Filter Section -->
<div class="row mb-4">
  <div class="col-12">
    <div class="pandu-card shadow-sm border-0">
      <div class="pandu-card-body p-3">
        <form action="{{ route('hse.certificate.index') }}" method="GET" class="row g-3 align-items-end">
          <div class="col-12 col-md-3">
            <label class="label-text smaller text-muted mb-1">Tipe Sertifikat</label>
            <select name="type" class="form-select form-select-sm" onchange="this.form.submit()">
              <option value="">Semua Tipe</option>
              <option value="k3_umum" {{ request('type') == 'k3_umum' ? 'selected' : '' }}>Ahli K3 Umum</option>
              <option value="first_aid" {{ request('type') == 'first_aid' ? 'selected' : '' }}>Petugas P3K</option>
              <option value="fire_fighting" {{ request('type') == 'fire_fighting' ? 'selected' : '' }}>Damkar</option>
              <option value="operator_forklift" {{ request('type') == 'operator_forklift' ? 'selected' : '' }}>Operator Forklift</option>
            </select>
          </div>
          <div class="col-12 col-md-2">
            <label class="label-text smaller text-muted mb-1">Status</label>
            <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
              <option value="">Semua Status</option>
              <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
              <option value="expiring_soon" {{ request('status') == 'expiring_soon' ? 'selected' : '' }}>Hampir Habis</option>
              <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Kadaluarsa</option>
            </select>
          </div>
          <div class="col-12 col-md-4 ms-auto">
            <label class="label-text smaller text-muted mb-1">Cari Karyawan</label>
            <div class="input-group input-group-sm">
              <span class="input-group-text bg-light border-end-0 text-secondary"><i class="fas fa-search"></i></span>
              <input type="text" name="search" class="form-control border-start-0" value="{{ request('search') }}" placeholder="Nama, NIK, atau No. Sertifikat...">
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="pandu-card shadow-sm border-0">
  <div class="pandu-card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
    <h6 class="card-title-custom mb-0 fw-bold"><i class="fas fa-id-card me-2 text-primary"></i> Daftar Sertifikat & Masa Berlaku</h6>
    <span class="badge bg-light text-dark border shadow-sm">{{ $certificates->total() }} Data</span>
  </div>
  <div class="pandu-card-body p-0">
    <div class="table-responsive">
      <table class="table pandu-table table-hover align-middle mb-0">
        <thead class="bg-light">
          <tr>
            <th class="ps-4">Karyawan</th>
            <th>Tipe Sertifikat</th>
            <th>No. Sertifikat / Penerbit</th>
            <th>Masa Berlaku</th>
            <th>Status</th>
            <th class="pe-4 text-end">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($certificates as $cert)
          <tr>
            <td class="ps-4">
               <div class="d-flex align-items-center gap-3">
                  <img src="https://ui-avatars.com/api/?name={{ urlencode($cert->user->name) }}&background=E9ECEF&color=495057" class="rounded-circle border" style="width: 36px;">
                  <div>
                     <div class="td-main small">{{ $cert->user->name }}</div>
                     <div class="td-sub smaller">NIK: {{ $cert->user->employee_id ?? 'N/A' }}</div>
                  </div>
               </div>
            </td>
            <td>
               <div class="td-main text-dark small fw-bold">{{ strtoupper(str_replace('_', ' ', $cert->certificate_type)) }}</div>
            </td>
            <td>
              <div class="td-main small">{{ $cert->certificate_number }}</div>
              <div class="td-sub smaller d-flex align-items-center gap-1">
                 <i class="fas fa-building smaller opacity-50"></i>
                 {{ $cert->issuing_body }}
              </div>
            </td>
            <td>
              <div class="td-main small fw-bold {{ $cert->status === 'expired' ? 'text-danger' : ($cert->status === 'expiring_soon' ? 'text-warning' : 'text-dark') }}">
                 <i class="far fa-calendar-alt me-1 opacity-50"></i>
                 {{ $cert->expiry_date->format('d M Y') }}
              </div>
              <div class="smaller text-muted">{{ $cert->expiry_date->diffForHumans() }}</div>
            </td>
            <td>
               <span class="status-badge status-{{ $cert->status }} shadow-sm">
                  {{ ucfirst(str_replace('_', ' ', $cert->status)) }}
               </span>
            </td>
            <td class="pe-4 text-end">
              @if($cert->document_path)
                <a href="{{ asset('storage/'.$cert->document_path) }}" class="btn btn-sm btn-outline-danger shadow-sm px-3" target="_blank">
                  <i class="fas fa-file-pdf me-1"></i> Lihat
                </a>
              @else
                <button class="btn btn-sm btn-light disabled px-3"><i class="fas fa-file-slash me-1"></i> No File</button>
              @endif
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="6" class="text-center py-5 text-secondary">
               <div class="opacity-25 mb-3"><i class="fas fa-id-card-clip fa-4x"></i></div>
               <p class="fw-medium">Belum ada data sertifikat kompetensi yang terdaftar.</p>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
  <div class="table-pagination px-4 py-3 border-top bg-light-subtle">
    {{ $certificates->appends(request()->query())->links() }}
  </div>
</div>
@endsection
