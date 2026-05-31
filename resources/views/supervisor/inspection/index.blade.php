@extends('layouts.app')

@section('title', 'Tugas Inspeksi')
@section('page-title', 'Tugas Inspeksi Rutin')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('supervisor.dashboard') }}">Beranda</a></li>
  <li class="breadcrumb-item active">Inspeksi</li>
@endsection

@section('content')
<!-- Task Summary Row -->
<div class="row g-3 mb-4">
  <div class="col-6 col-md-3">
    <div class="pandu-card shadow-sm border-0 p-3 bg-primary text-white">
      <p class="smaller fw-bold text-uppercase opacity-75 mb-1">Belum Selesai</p>
      <h3 class="fw-extrabold mb-0">{{ $inspections->where('status', 'scheduled')->count() }}</h3>
    </div>
  </div>
  <div class="col-6 col-md-3">
    <div class="pandu-card shadow-sm border-0 p-3 bg-danger text-white">
      <p class="smaller fw-bold text-uppercase opacity-75 mb-1">Terlambat</p>
      <h3 class="fw-extrabold mb-0">{{ $inspections->where('status', 'overdue')->count() }}</h3>
    </div>
  </div>
</div>

<div class="pandu-card shadow-sm border-0">
  <div class="pandu-card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
    <h6 class="card-title-custom mb-0 fw-bold"><i class="fas fa-clipboard-check me-2 text-primary"></i> Daftar Tugas Inspeksi Anda</h6>
    <span class="badge bg-light text-dark border shadow-sm fw-bold">{{ $inspections->total() }} Tugas</span>
  </div>
  <div class="pandu-card-body p-0">
    <div class="table-responsive">
      <table class="table pandu-table table-hover align-middle mb-0">
        <thead class="bg-light">
          <tr>
            <th class="ps-4">No. Inspeksi</th>
            <th>Judul / Area</th>
            <th>Tipe</th>
            <th>Batas Waktu</th>
            <th>Status</th>
            <th class="pe-4 text-end">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($inspections as $ins)
          <tr>
            <td class="ps-4"><span class="doc-number shadow-sm">{{ $ins->inspection_number }}</span></td>
            <td>
              <div class="td-main text-dark small fw-bold">{{ Str::limit($ins->title, 40) }}</div>
              <div class="td-sub d-flex align-items-center gap-1">
                 <i class="fas fa-location-dot smaller opacity-50"></i>
                 {{ $ins->workArea->name }}
              </div>
            </td>
            <td>
               <span class="badge bg-light text-dark border px-2 py-1" style="font-size: 10px;">{{ strtoupper($ins->inspection_type) }}</span>
            </td>
            <td>
              @php $isOverdue = $ins->scheduled_date < now() && $ins->status === 'scheduled'; @endphp
              <div class="td-main small fw-bold {{ $isOverdue ? 'text-danger' : 'text-dark' }}">
                 <i class="far fa-calendar-alt me-1 opacity-50"></i>
                 {{ $ins->scheduled_date->format('d M Y') }}
              </div>
              @if($isOverdue) <span class="smaller text-danger fw-extrabold">TERLAMBAT</span> @endif
            </td>
            <td>
               <span class="status-badge status-{{ $ins->status }} shadow-sm">
                  {{ ucfirst($ins->status) }}
               </span>
            </td>
            <td class="pe-4 text-end">
              @if($ins->status !== 'completed')
                <a href="{{ route('supervisor.inspection.show', $ins->id) }}" class="btn btn-sm btn-pandu-primary shadow-sm px-3">
                   <i class="fas fa-play me-1"></i> Mulai
                </a>
              @else
                <a href="{{ route('supervisor.inspection.show', $ins->id) }}" class="btn btn-sm btn-outline-secondary shadow-sm px-3">
                   <i class="fas fa-eye me-1"></i> Hasil
                </a>
              @endif
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="6" class="text-center py-5">
               <div class="opacity-25 mb-3"><i class="fas fa-clipboard-list fa-4x"></i></div>
               <p class="text-secondary fw-medium">Anda tidak memiliki tugas inspeksi saat ini.</p>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
