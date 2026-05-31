@extends('layouts.app')

@section('title', 'Tugas CAPA Saya')
@section('page-title', 'Tugas Perbaikan (CAPA)')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('supervisor.dashboard') }}">Beranda</a></li>
  <li class="breadcrumb-item active">CAPA Saya</li>
@endsection

@section('content')
<div class="pandu-card">
  <div class="pandu-card-header">
    <h6 class="card-title-custom mb-0">Tindakan Perbaikan yang Ditugaskan Ke Saya</h6>
  </div>
  <div class="pandu-card-body p-0">
    <div class="table-responsive">
      <table class="table pandu-table">
        <thead>
          <tr>
            <th>No. CAPA</th>
            <th>Judul</th>
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
              <div class="td-main {{ $capa->due_date < now() && $capa->status !== 'closed' ? 'text-danger' : '' }}">
                {{ $capa->due_date->format('d M Y') }}
              </div>
              <div class="td-sub text-danger fw-bold small">
                @if($capa->due_date < now() && $capa->status !== 'closed') OVERDUE @endif
              </div>
            </td>
            <td><span class="risk-badge risk-{{ $capa->priority === 'critical' ? 'critical' : 'medium' }}">{{ ucfirst($capa->priority) }}</span></td>
            <td><span class="status-badge status-{{ $capa->status }}">{{ ucfirst(str_replace('_', ' ', $capa->status)) }}</span></td>
            <td>
              <a href="{{ route('supervisor.capa.show', $capa->id) }}" class="btn btn-sm btn-pandu-primary">
                Update Progres
              </a>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="6" class="text-center py-5">
              <p class="text-secondary">Anda belum memiliki tugas CAPA.</p>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
