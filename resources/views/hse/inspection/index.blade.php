@extends('layouts.app')

@section('title', 'Jadwal Inspeksi')
@section('page-title', 'Manajemen Inspeksi K3')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('hse.dashboard') }}">Beranda</a></li>
  <li class="breadcrumb-item active">Inspeksi</li>
@endsection

@section('page-actions')
  <a href="{{ route('hse.inspection.create') }}" class="btn btn-pandu-primary">
    <i class="fas fa-calendar-plus me-2"></i> Jadwalkan Inspeksi
  </a>
@endsection

@section('content')
<div class="pandu-card">
  <div class="pandu-card-header">
    <h6 class="card-title-custom mb-0">Seluruh Jadwal & Riwayat Inspeksi</h6>
  </div>
  <div class="pandu-card-body p-0">
    <div class="table-responsive">
      <table class="table pandu-table">
        <thead>
          <tr>
            <th>No. Inspeksi</th>
            <th>Judul / Tipe</th>
            <th>Area Kerja</th>
            <th>Inspektur</th>
            <th>Tanggal Jadwal</th>
            <th>Status</th>
            <th>Progres</th>
          </tr>
        </thead>
        <tbody>
          @forelse($inspections as $ins)
          <tr>
            <td><span class="doc-number">{{ $ins->inspection_number }}</span></td>
            <td>
              <div class="td-main">{{ $ins->title }}</div>
              <div class="td-sub">{{ ucfirst($ins->inspection_type) }}</div>
            </td>
            <td>
              <div class="td-main">{{ $ins->workArea->name }}</div>
              <div class="td-sub">{{ $ins->division->name }}</div>
            </td>
            <td><div class="td-main">{{ $ins->inspector->name }}</div></td>
            <td><div class="td-main">{{ $ins->scheduled_date->format('d M Y') }}</div></td>
            <td><span class="status-badge status-{{ $ins->status }}">{{ ucfirst($ins->status) }}</span></td>
            <td>
              <div class="d-flex align-items-center gap-2">
                <div class="progress flex-grow-1" style="height: 6px; width: 60px;">
                  <div class="progress-bar bg-primary" style="width: {{ $ins->completion_percentage }}%"></div>
                </div>
                <span class="smaller fw-bold">{{ round($ins->completion_percentage) }}%</span>
              </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="7" class="text-center py-5">
              <p class="text-secondary">Belum ada jadwal inspeksi.</p>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection

@push('styles')
<style>
.smaller { font-size: 0.7rem; }
</style>
@endpush
