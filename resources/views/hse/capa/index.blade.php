@extends('layouts.app')

@section('title', 'Manajemen CAPA')
@section('page-title', 'Corrective & Preventive Action')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('hse.dashboard') }}">Beranda</a></li>
  <li class="breadcrumb-item active">CAPA</li>
@endsection

@section('page-actions')
  <a href="{{ route('hse.capa.create') }}" class="btn btn-pandu-primary">
    <i class="fas fa-plus me-2"></i> Buat CAPA Baru
  </a>
@endsection

@section('content')
<div class="pandu-card">
  <div class="pandu-card-header">
    <h6 class="card-title-custom mb-0">Seluruh Tindakan Perbaikan (CAPA)</h6>
  </div>
  <div class="pandu-card-body p-0">
    <div class="table-responsive">
      <table class="table pandu-table">
        <thead>
          <tr>
            <th>No. CAPA</th>
            <th>Judul / Tipe</th>
            <th>Ditugaskan Ke</th>
            <th>Batas Waktu</th>
            <th>Prioritas</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($actions as $capa)
          <tr>
            <td><span class="doc-number">{{ $capa->capa_number }}</span></td>
            <td>
              <div class="td-main">{{ $capa->title }}</div>
              <div class="td-sub">{{ ucfirst($capa->action_type) }}</div>
            </td>
            <td>
              <div class="td-main">{{ $capa->assignedTo->name }}</div>
              <div class="td-sub">{{ $capa->division->name }}</div>
            </td>
            <td>
              <div class="td-main {{ $capa->due_date < now() && $capa->status !== 'closed' ? 'text-danger' : '' }}">
                {{ $capa->due_date->format('d M Y') }}
              </div>
              <div class="td-sub">{{ $capa->due_date->diffForHumans() }}</div>
            </td>
            <td><span class="risk-badge risk-{{ $capa->priority === 'critical' ? 'critical' : ($capa->priority === 'high' ? 'high' : 'medium') }}">{{ ucfirst($capa->priority) }}</span></td>
            <td><span class="status-badge status-{{ $capa->status }}">{{ ucfirst(str_replace('_', ' ', $capa->status)) }}</span></td>
            <td>
              <a href="{{ route('hse.capa.show', $capa->id) }}" class="btn-action btn-view"><i class="fas fa-eye"></i></a>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="7" class="text-center py-5">
              <p class="text-secondary">Belum ada data CAPA.</p>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
  <div class="table-pagination p-3">
    {{ $actions->links() }}
  </div>
</div>
@endsection
