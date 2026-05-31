@extends('layouts.app')

@section('title', 'Investigasi Insiden')
@section('page-title', 'Seluruh Laporan Insiden')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('hse.dashboard') }}">Beranda</a></li>
  <li class="breadcrumb-item active">Insiden</li>
@endsection

@section('content')
<div class="pandu-card">
  <div class="pandu-card-header">
    <h6 class="card-title-custom mb-0">Daftar Insiden & Kecelakaan Kerja</h6>
  </div>
  <div class="pandu-card-body p-0">
    <div class="table-responsive">
      <table class="table pandu-table">
        <thead>
          <tr>
            <th>No. Laporan</th>
            <th>Judul / Tipe</th>
            <th>Area</th>
            <th>Keparahan</th>
            <th>Status</th>
            <th>Tanggal Kejadian</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($reports as $report)
          <tr>
            <td><span class="doc-number">{{ $report->report_number }}</span></td>
            <td>
              <div class="td-main">{{ $report->title }}</div>
              <div class="td-sub">{{ ucfirst(str_replace('_', ' ', $report->incident_type)) }}</div>
            </td>
            <td><span class="area-badge">{{ $report->workArea->name }}</span></td>
            <td><span class="status-badge status-{{ $report->severity_classification === 'minor' ? 'active' : 'emergency' }}">{{ ucfirst($report->severity_classification) }}</span></td>
            <td><span class="status-badge status-{{ $report->status }}">{{ ucfirst(str_replace('_', ' ', $report->status)) }}</span></td>
            <td>
              <div class="td-main">{{ $report->incident_date->format('d M Y') }}</div>
              <div class="td-sub">{{ $report->incident_time }}</div>
            </td>
            <td>
              <a href="{{ route('hse.incident.show', $report->id) }}" class="btn btn-sm btn-pandu-primary">
                Investigasi
              </a>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="7" class="text-center py-5">
              <p class="text-secondary">Belum ada laporan insiden yang masuk.</p>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
