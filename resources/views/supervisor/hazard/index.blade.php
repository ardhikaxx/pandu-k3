@extends('layouts.app')

@section('title', 'Verifikasi Laporan Bahaya')
@section('page-title', 'Verifikasi Laporan Bahaya')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('supervisor.dashboard') }}">Beranda</a></li>
  <li class="breadcrumb-item active">Verifikasi Bahaya</li>
@endsection

@section('content')
<div class="pandu-card mb-4">
  <div class="pandu-card-header">
    <h6 class="card-title-custom mb-0">Daftar Temuan Bahaya - Divisi {{ auth()->user()->division->name }}</h6>
  </div>
  <div class="pandu-card-body p-0">
    <div class="table-responsive">
      <table class="table pandu-table">
        <thead>
          <tr>
            <th>No. Laporan</th>
            <th>Judul / Pelapor</th>
            <th>Area</th>
            <th>Tingkat</th>
            <th>Prioritas</th>
            <th>Status</th>
            <th>Tanggal</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($reports as $report)
          <tr>
            <td><span class="doc-number">{{ $report->report_number }}</span></td>
            <td>
              <div class="td-main">{{ $report->title }}</div>
              <div class="td-sub">Oleh: {{ $report->reporter->name }}</div>
            </td>
            <td><span class="area-badge">{{ $report->workArea->name }}</span></td>
            <td><span class="risk-badge risk-{{ $report->severity }}">{{ ucfirst($report->severity) }}</span></td>
            <td>
               <span class="priority-dot priority-{{ $report->priority }} me-1"></span>
               <span class="small fw-bold text-{{ $report->priority === 'emergency' ? 'danger' : ($report->priority === 'urgent' ? 'warning' : 'success') }}">
                 {{ ucfirst($report->priority) }}
               </span>
            </td>
            <td><span class="status-badge status-{{ $report->status }}">{{ ucfirst(str_replace('_', ' ', $report->status)) }}</span></td>
            <td>
              <div class="td-main">{{ $report->reported_at->format('d M Y') }}</div>
              <div class="td-sub">{{ $report->reported_at->diffForHumans() }}</div>
            </td>
            <td>
              <a href="{{ route('supervisor.hazard.show', $report->id) }}" class="btn btn-sm btn-pandu-primary">
                Verifikasi
              </a>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="8" class="text-center py-5">
              <p class="text-secondary">Tidak ada laporan yang perlu diverifikasi.</p>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
  <div class="table-pagination p-3">
    {{ $reports->links() }}
  </div>
</div>
@endsection

@push('styles')
<style>
.priority-emergency { background: var(--color-danger); }
.priority-urgent { background: var(--color-warning); }
.priority-normal { background: var(--color-success); }
</style>
@endpush
