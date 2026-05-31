@extends('layouts.app')

@section('title', 'Manajemen CAPA')
@section('page-title', 'Pusat Tindakan CAPA')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('hse.dashboard') }}">Beranda</a></li>
  <li class="breadcrumb-item active">CAPA</li>
@endsection

@section('page-actions')
  <a href="{{ route('hse.capa.create') }}" class="btn btn-pandu-primary shadow-sm">
    <i class="fas fa-plus me-2"></i> Buat CAPA Baru
  </a>
@endsection

@section('content')
<!-- Filter & Summary Row -->
<div class="row g-3 mb-4">
  <div class="col-12">
     <div class="pandu-card shadow-sm border-0">
        <div class="pandu-card-body p-3">
           <form action="{{ route('hse.capa.index') }}" method="GET" class="row g-2 align-items-end">
              <div class="col-12 col-md-3">
                 <label class="label-text smaller text-muted mb-1">Cari Tindakan</label>
                 <div class="input-group input-group-sm">
                    <span class="input-group-text bg-light border-end-0 text-secondary"><i class="fas fa-search"></i></span>
                    <input type="text" name="search" class="form-control border-start-0" value="{{ request('search') }}" placeholder="Judul atau No. CAPA...">
                 </div>
              </div>
              <div class="col-6 col-md-2">
                 <label class="label-text smaller text-muted mb-1">Status</label>
                 <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>Open</option>
                    <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="pending_verification" {{ request('status') == 'pending_verification' ? 'selected' : '' }}>Verification</option>
                    <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                    <option value="overdue" {{ request('status') == 'overdue' ? 'selected' : '' }}>Overdue</option>
                 </select>
              </div>
              <div class="col-6 col-md-2">
                 <label class="label-text smaller text-muted mb-1">Prioritas</label>
                 <select name="priority" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="">Semua Prioritas</option>
                    <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Low</option>
                    <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                    <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>High</option>
                    <option value="critical" {{ request('priority') == 'critical' ? 'selected' : '' }}>Critical</option>
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
    <h6 class="card-title-custom mb-0 fw-bold"><i class="fas fa-check-to-slot me-2 text-primary"></i> Seluruh Tindakan Perbaikan (CAPA)</h6>
    <span class="badge bg-light text-dark fw-bold border shadow-sm">{{ $actions->total() }} Data</span>
  </div>
  <div class="pandu-card-body p-0">
    <div class="table-responsive">
      <table class="table pandu-table table-hover align-middle mb-0">
        <thead class="bg-light">
          <tr>
            <th class="ps-4">No. CAPA</th>
            <th>Judul / Tipe</th>
            <th>Personil PIC</th>
            <th>Batas Waktu</th>
            <th>Prioritas</th>
            <th>Status</th>
            <th class="pe-4 text-end">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($actions as $capa)
          <tr>
            <td class="ps-4"><span class="doc-number shadow-sm">{{ $capa->capa_number }}</span></td>
            <td>
              <div class="td-main text-dark">{{ Str::limit($capa->title, 40) }}</div>
              <div class="td-sub d-flex align-items-center gap-1 text-muted">
                 <i class="fas fa-tools smaller opacity-50"></i>
                 {{ ucfirst($capa->action_type) }}
              </div>
            </td>
            <td>
              <div class="d-flex align-items-center gap-2">
                 <img src="https://ui-avatars.com/api/?name={{ urlencode($capa->assignedTo->name) }}&background=E9ECEF&color=495057" class="rounded-circle" style="width:24px;">
                 <div>
                    <div class="td-main small">{{ $capa->assignedTo->name }}</div>
                    <div class="smaller text-muted">{{ $capa->division->name }}</div>
                 </div>
              </div>
            </td>
            <td>
              @php $isOverdue = $capa->due_date < now() && $capa->status !== 'closed'; @endphp
              <div class="td-main small {{ $isOverdue ? 'text-danger fw-bold' : 'text-dark' }}">
                 <i class="far fa-calendar-alt me-1 opacity-50"></i>
                 {{ $capa->due_date->format('d M Y') }}
              </div>
              <div class="smaller {{ $isOverdue ? 'text-danger' : 'text-muted' }}">
                 {{ $isOverdue ? 'TERLAMBAT' : $capa->due_date->diffForHumans() }}
              </div>
            </td>
            <td>
               <span class="risk-badge risk-{{ $capa->priority === 'critical' ? 'critical' : ($capa->priority === 'high' ? 'high' : 'medium') }} shadow-sm">
                  {{ ucfirst($capa->priority) }}
               </span>
            </td>
            <td>
               <span class="status-badge status-{{ $capa->status }} shadow-sm">
                  {{ ucfirst(str_replace('_', ' ', $capa->status)) }}
               </span>
            </td>
            <td class="pe-4 text-end">
              <a href="{{ route('hse.capa.show', $capa->id) }}" class="btn btn-sm btn-pandu-primary shadow-sm px-3" title="Detail & Verifikasi">
                 <i class="fas fa-clipboard-check me-1"></i> Detail
              </a>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="7" class="text-center py-5">
               <div class="opacity-25 mb-3"><i class="fas fa-tasks fa-4x"></i></div>
               <p class="text-secondary fw-medium">Belum ada data tindakan CAPA yang tercatat.</p>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
  <div class="table-pagination px-4 py-3 border-top bg-light-subtle">
    {{ $actions->appends(request()->query())->links() }}
  </div>
</div>
@endsection
