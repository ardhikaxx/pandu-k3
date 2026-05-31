@extends('layouts.app')

@section('title', 'Manajemen SOP')
@section('page-title', 'Pusat Prosedur K3 (SOP)')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('hse.dashboard') }}">Beranda</a></li>
  <li class="breadcrumb-item active">SOP</li>
@endsection

@section('page-actions')
  <a href="{{ route('hse.sop.create') }}" class="btn btn-pandu-primary shadow-sm">
    <i class="fas fa-plus me-2"></i> Buat SOP Baru
  </a>
@endsection

@section('content')
<!-- Filter Section -->
<div class="row mb-4">
  <div class="col-12">
    <div class="pandu-card shadow-sm border-0">
      <div class="pandu-card-body p-3">
        <form action="{{ route('hse.sop.index') }}" method="GET" class="row g-3 align-items-end">
          <div class="col-12 col-md-3">
            <label class="label-text smaller text-muted mb-1">Kategori</label>
            <select name="category" class="form-select form-select-sm" onchange="this.form.submit()">
              <option value="">Semua Kategori</option>
              <option value="work_procedure" {{ request('category') == 'work_procedure' ? 'selected' : '' }}>Prosedur Kerja</option>
              <option value="emergency_response" {{ request('category') == 'emergency_response' ? 'selected' : '' }}>Tanggap Darurat</option>
              <option value="chemical_handling" {{ request('category') == 'chemical_handling' ? 'selected' : '' }}>Penanganan Kimia</option>
              <option value="fire_safety" {{ request('category') == 'fire_safety' ? 'selected' : '' }}>Kebakaran</option>
              <option value="first_aid" {{ request('category') == 'first_aid' ? 'selected' : '' }}>P3K</option>
            </select>
          </div>
          <div class="col-12 col-md-4 ms-auto">
            <label class="label-text smaller text-muted mb-1">Cari Prosedur</label>
            <div class="input-group input-group-sm">
              <span class="input-group-text bg-light border-end-0 text-secondary"><i class="fas fa-search"></i></span>
              <input type="text" name="search" class="form-control border-start-0" value="{{ request('search') }}" placeholder="Judul atau No. Dokumen...">
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="pandu-card shadow-sm border-0">
  <div class="pandu-card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
    <h6 class="card-title-custom mb-0 fw-bold"><i class="fas fa-book me-2 text-primary"></i> Seluruh Dokumen Prosedur Kerja (SOP)</h6>
    <span class="badge bg-light text-dark border shadow-sm">{{ $sops->total() }} Dokumen</span>
  </div>
  <div class="pandu-card-body p-0">
    <div class="table-responsive">
      <table class="table pandu-table table-hover align-middle mb-0">
        <thead class="bg-light">
          <tr>
            <th class="ps-4">No. Dokumen</th>
            <th>Judul / Kategori</th>
            <th>Area / Divisi</th>
            <th>Status</th>
            <th>Versi</th>
            <th>Dilihat</th>
            <th class="pe-4 text-end">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($sops as $sop)
          <tr>
            <td class="ps-4"><span class="doc-number shadow-sm">{{ $sop->document_number }}</span></td>
            <td>
              <div class="td-main text-dark small fw-bold">{{ $sop->title }}</div>
              <div class="td-sub d-flex align-items-center gap-1">
                 <i class="fas fa-folder smaller opacity-50"></i>
                 {{ ucfirst(str_replace('_', ' ', $sop->category)) }}
              </div>
            </td>
            <td>
              <div class="td-main small fw-bold text-dark">{{ $sop->workArea->name ?? 'Semua Area' }}</div>
              <div class="td-sub smaller">{{ $sop->division->name ?? 'Semua Divisi' }}</div>
            </td>
            <td>
               <span class="status-badge status-{{ $sop->status }} shadow-sm">
                  {{ ucfirst($sop->status) }}
               </span>
            </td>
            <td><div class="badge bg-light text-dark border rounded-pill px-3 fw-bold" style="font-size: 10px;">v{{ $sop->version }}</div></td>
            <td>
               <div class="td-main small text-secondary">
                  <i class="far fa-eye me-1 opacity-75"></i> {{ $sop->view_count }}
               </div>
            </td>
            <td class="pe-4 text-end">
               <a href="{{ route('hse.sop.show', $sop->id) }}" class="btn btn-sm btn-pandu-primary shadow-sm px-3">
                  <i class="fas fa-file-lines me-1"></i> Buka
               </a>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="7" class="text-center py-5">
               <div class="opacity-25 mb-3"><i class="fas fa-book-open fa-4x"></i></div>
               <p class="text-secondary fw-medium">Belum ada dokumen SOP yang terdaftar di perpustakaan.</p>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
  <div class="table-pagination px-4 py-3 border-top bg-light-subtle">
    {{ $sops->appends(request()->query())->links() }}
  </div>
</div>
@endsection
