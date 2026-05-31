@extends('layouts.app')

@section('title', 'Manajemen HIRADC')
@section('page-title', 'Pusat HIRADC')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('hse.dashboard') }}">Beranda</a></li>
  <li class="breadcrumb-item active">HIRADC</li>
@endsection

@section('page-actions')
  <a href="{{ route('hse.hiradc.create') }}" class="btn btn-pandu-primary shadow-sm">
    <i class="fas fa-plus me-2"></i> Buat HIRADC Baru
  </a>
@endsection

@section('content')
<!-- Filter & Stats Summary -->
<div class="row g-4 mb-4">
   <div class="col-md-9">
      <div class="pandu-card shadow-sm border-0 h-100">
         <div class="pandu-card-body p-3">
            <form action="{{ route('hse.hiradc.index') }}" method="GET" class="row g-2 align-items-end">
               <div class="col-md-4">
                  <label class="label-text smaller text-muted mb-1">Cari Dokumen</label>
                  <div class="input-group input-group-sm">
                     <span class="input-group-text bg-light border-end-0"><i class="fas fa-search"></i></span>
                     <input type="text" name="search" class="form-control border-start-0" value="{{ request('search') }}" placeholder="Judul atau No. Dokumen...">
                  </div>
               </div>
               <div class="col-md-3">
                  <label class="label-text smaller text-muted mb-1">Status</label>
                  <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                     <option value="">Semua Status</option>
                     <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                     <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                     <option value="review" {{ request('status') == 'review' ? 'selected' : '' }}>In Review</option>
                  </select>
               </div>
               <div class="col-md-3">
                  <label class="label-text smaller text-muted mb-1">Area Kerja</label>
                  <select name="area" class="form-select form-select-sm" onchange="this.form.submit()">
                     <option value="">Semua Area</option>
                     @foreach(\App\Models\WorkArea::all() as $wa)
                        <option value="{{ $wa->id }}" {{ request('area') == $wa->id ? 'selected' : '' }}>{{ $wa->name }}</option>
                     @endforeach
                  </select>
               </div>
            </form>
         </div>
      </div>
   </div>
   <div class="col-md-3">
      <div class="pandu-card bg-primary text-white shadow-sm border-0 h-100">
         <div class="pandu-card-body d-flex flex-column justify-content-center text-center">
            <h6 class="label-text text-white-50 mb-1">TOTAL DOKUMEN</h6>
            <h2 class="fw-extrabold mb-0">{{ $documents->total() }}</h2>
         </div>
      </div>
   </div>
</div>

<div class="pandu-card shadow-sm border-0">
  <div class="pandu-card-header bg-white border-bottom py-3">
    <h6 class="card-title-custom mb-0 fw-bold"><i class="fas fa-shield-virus me-2 text-primary"></i> Daftar Dokumen HIRADC</h6>
  </div>
  <div class="pandu-card-body p-0">
    <div class="table-responsive">
      <table class="table pandu-table table-hover align-middle mb-0">
        <thead class="bg-light">
          <tr>
            <th class="ps-4">No. Dokumen</th>
            <th>Judul HIRADC</th>
            <th>Area / Divisi</th>
            <th>Status</th>
            <th>Masa Berlaku</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($documents as $doc)
          <tr>
            <td class="ps-4"><span class="doc-number shadow-sm">{{ $doc->document_number }}</span></td>
            <td>
              <div class="td-main text-dark">{{ $doc->title }}</div>
              <div class="td-sub d-flex align-items-center gap-1">
                 <i class="fas fa-user-edit smaller opacity-50"></i>
                 {{ $doc->preparedBy->name }}
              </div>
            </td>
            <td>
              <div class="td-main fw-bold small">{{ $doc->workArea->name }}</div>
              <div class="td-sub smaller">{{ $doc->division->name }}</div>
            </td>
            <td>
               <span class="status-badge status-{{ $doc->status }} shadow-sm">
                  {{ ucfirst($doc->status) }}
               </span>
            </td>
            <td>
              <div class="td-main small fw-bold text-dark"><i class="far fa-calendar-alt me-1 opacity-50"></i> {{ $doc->valid_from->format('d/m/Y') }}</div>
              <div class="td-sub smaller text-muted">s/d {{ $doc->valid_until->format('d/m/Y') }}</div>
            </td>
            <td class="pe-4">
               <div class="action-btns">
                  <a href="{{ route('hse.hiradc.show', $doc->id) }}" class="btn-action btn-view shadow-sm" title="Lihat Detail"><i class="fas fa-eye"></i></a>
                  @if($doc->status === 'draft')
                     <a href="#" class="btn-action btn-edit shadow-sm" title="Edit Dokumen"><i class="fas fa-edit"></i></a>
                  @endif
               </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="6" class="text-center py-5">
               <div class="opacity-25 mb-3"><i class="fas fa-folder-open fa-4x"></i></div>
               <p class="text-secondary fw-medium">Belum ada dokumen HIRADC yang tersedia.</p>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
  <div class="table-pagination px-4 py-3 border-top bg-light-subtle">
    {{ $documents->appends(request()->query())->links() }}
  </div>
</div>
@endsection
