@extends('layouts.app')

@section('title', 'Laporan Bahaya Saya')
@section('page-title', 'Laporan Bahaya Saya')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('worker.dashboard') }}">Beranda</a></li>
  <li class="breadcrumb-item active">Laporan Bahaya</li>
@endsection

@section('page-actions')
  <a href="{{ route('worker.hazard.create') }}" class="btn btn-pandu-primary">
    <i class="fas fa-plus me-2"></i> Buat Laporan
  </a>
@endsection

@section('content')
<div class="pandu-table-wrapper">
  <div class="table-responsive">
    <table class="table pandu-table">
      <thead>
        <tr>
          <th>No. Laporan</th>
          <th>Judul</th>
          <th>Area Kerja</th>
          <th>Tingkat</th>
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
            <div class="td-sub">{{ ucfirst(str_replace('_', ' ', $report->hazard_type)) }}</div>
          </td>
          <td><span class="area-badge">{{ $report->workArea->name }}</span></td>
          <td><span class="risk-badge risk-{{ $report->severity }}">{{ ucfirst($report->severity) }}</span></td>
          <td><span class="status-badge status-{{ $report->status }}">{{ ucfirst(str_replace('_', ' ', $report->status)) }}</span></td>
          <td>
            <div class="td-main">{{ $report->reported_at->format('d M Y') }}</div>
            <div class="td-sub">{{ $report->reported_at->format('H:i') }} WIB</div>
          </td>
          <td>
            <div class="action-btns">
              <a href="{{ route('worker.hazard.show', $report->id) }}" class="btn-action btn-view" title="Lihat"><i class="fas fa-eye"></i></a>
            </div>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="7" class="text-center py-5">
            <div class="opacity-50 mb-3">
              <i class="fas fa-folder-open fa-3x"></i>
            </div>
            <p class="text-secondary">Anda belum memiliki laporan bahaya.</p>
            <a href="{{ route('worker.hazard.create') }}" class="btn btn-outline-primary btn-sm">Mulai Buat Laporan</a>
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div class="table-pagination">
    {{ $reports->links() }}
  </div>
</div>
@endsection
