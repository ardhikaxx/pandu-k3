@extends('layouts.app')

@section('title', 'Pelatihan K3')
@section('page-title', 'Pusat Pelatihan K3')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('hse.dashboard') }}">Beranda</a></li>
  <li class="breadcrumb-item active">Pelatihan</li>
@endsection

@section('page-actions')
  <a href="{{ route('hse.training.create') }}" class="btn btn-pandu-primary shadow-sm">
    <i class="fas fa-plus me-2"></i> Tambah Jadwal Pelatihan
  </a>
@endsection

@section('content')
<!-- Filter Section -->
<div class="row mb-4">
  <div class="col-12">
    <div class="pandu-card shadow-sm border-0">
      <div class="pandu-card-body p-3">
        <form action="{{ route('hse.training.index') }}" method="GET" class="row g-3 align-items-end">
          <div class="col-12 col-md-3">
            <label class="label-text smaller text-muted mb-1">Tipe Pelatihan</label>
            <select name="type" class="form-select form-select-sm" onchange="this.form.submit()">
              <option value="">Semua Tipe</option>
              <option value="induction" {{ request('type') == 'induction' ? 'selected' : '' }}>Induction</option>
              <option value="refresher" {{ request('type') == 'refresher' ? 'selected' : '' }}>Refresher</option>
              <option value="specialist" {{ request('type') == 'specialist' ? 'selected' : '' }}>Specialist</option>
            </select>
          </div>
          <div class="col-6 col-md-2">
            <label class="label-text smaller text-muted mb-1">Status</label>
            <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
              <option value="">Semua Status</option>
              <option value="planned" {{ request('status') == 'planned' ? 'selected' : '' }}>Planned</option>
              <option value="ongoing" {{ request('status') == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
              <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
            </select>
          </div>
          <div class="col-12 col-md-4 ms-auto">
            <label class="label-text smaller text-muted mb-1">Cari Pelatihan</label>
            <div class="input-group input-group-sm">
              <span class="input-group-text bg-light border-end-0 text-secondary"><i class="fas fa-search"></i></span>
              <input type="text" name="search" class="form-control border-start-0" value="{{ request('search') }}" placeholder="Judul atau No. Pelatihan...">
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="pandu-card shadow-sm border-0">
  <div class="pandu-card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
    <h6 class="card-title-custom mb-0 fw-bold"><i class="fas fa-graduation-cap me-2 text-primary"></i> Daftar Pelatihan & Sosialisasi K3</h6>
    <span class="badge bg-light text-dark border shadow-sm">{{ $trainings->total() }} Sesi</span>
  </div>
  <div class="pandu-card-body p-0">
    <div class="table-responsive">
      <table class="table pandu-table table-hover align-middle mb-0">
        <thead class="bg-light">
          <tr>
            <th class="ps-4">No. Pelatihan</th>
            <th>Judul / Tipe</th>
            <th>Penyelenggara / Trainer</th>
            <th>Jadwal Pelaksanaan</th>
            <th>Okupansi</th>
            <th>Status</th>
            <th class="pe-4 text-end">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($trainings as $trn)
          <tr>
            <td class="ps-4"><span class="doc-number shadow-sm">{{ $trn->training_number }}</span></td>
            <td>
              <div class="td-main text-dark small fw-bold">{{ $trn->title }}</div>
              <div class="td-sub d-flex align-items-center gap-1">
                 <i class="fas fa-bookmark smaller opacity-50"></i>
                 {{ ucfirst(str_replace('_', ' ', $trn->type)) }}
              </div>
            </td>
            <td>
              <div class="td-main small">{{ $trn->provider }}</div>
              <div class="td-sub smaller d-flex align-items-center gap-1">
                 <i class="fas fa-user-tie smaller opacity-50"></i>
                 {{ $trn->trainer_name }}
              </div>
            </td>
            <td>
              <div class="td-main small fw-bold text-dark"><i class="far fa-calendar-alt me-1 opacity-50"></i> {{ $trn->scheduled_date->format('d M Y') }}</div>
              <div class="td-sub smaller fw-semibold"><i class="far fa-clock me-1 opacity-50"></i> {{ $trn->duration_hours }} Jam</div>
            </td>
            <td>
              @php 
                $count = $trn->participants_count ?? 0;
                $pct = ($count / $trn->max_participants) * 100;
              @endphp
              <div class="d-flex align-items-center gap-2">
                 <div class="progress flex-grow-1" style="height: 6px; width: 60px;">
                    <div class="progress-bar bg-info" style="width: {{ $pct }}%"></div>
                 </div>
                 <span class="smaller fw-bold text-dark">{{ $count }}/{{ $trn->max_participants }}</span>
              </div>
            </td>
            <td>
               <span class="status-badge status-{{ $trn->status }} shadow-sm">
                  {{ ucfirst($trn->status) }}
               </span>
            </td>
            <td class="pe-4 text-end">
               <a href="{{ route('hse.training.show', $trn->id) }}" class="btn btn-sm btn-pandu-primary shadow-sm px-3">
                  <i class="fas fa-eye me-1"></i> Detail
               </a>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="7" class="text-center py-5">
               <div class="opacity-25 mb-3"><i class="fas fa-users-viewfinder fa-4x"></i></div>
               <p class="text-secondary fw-medium">Belum ada jadwal pelatihan yang direncanakan.</p>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
  <div class="table-pagination px-4 py-3 border-top bg-light-subtle">
    {{ $trainings->appends(request()->query())->links() }}
  </div>
</div>
@endsection
