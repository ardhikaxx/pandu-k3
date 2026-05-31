@extends('layouts.app')

@section('title', 'Izin Kerja Saya')
@section('page-title', 'Permit to Work (PTW)')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('worker.dashboard') }}">Beranda</a></li>
  <li class="breadcrumb-item active">Izin Kerja</li>
@endsection

@section('page-actions')
  <a href="{{ route('worker.permit.create') }}" class="btn btn-pandu-primary">
    <i class="fas fa-file-signature me-2"></i> Ajukan Izin Baru
  </a>
@endsection

@section('content')
<div class="pandu-card">
  <div class="pandu-card-header">
    <h6 class="card-title-custom mb-0">Riwayat Pengajuan Izin Kerja</h6>
  </div>
  <div class="pandu-card-body p-0">
    <div class="table-responsive">
      <table class="table pandu-table">
        <thead>
          <tr>
            <th>No. Izin</th>
            <th>Pekerjaan / Tipe</th>
            <th>Area Kerja</th>
            <th>Waktu Pelaksanaan</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($permits as $ptw)
          <tr>
            <td><span class="doc-number">{{ $ptw->permit_number }}</span></td>
            <td>
              <div class="td-main">{{ $ptw->title }}</div>
              <div class="td-sub">{{ ucfirst(str_replace('_', ' ', $ptw->work_type)) }}</div>
            </td>
            <td><span class="area-badge">{{ $ptw->workArea->name }}</span></td>
            <td>
              <div class="td-main">{{ $ptw->start_datetime->format('d/m/Y H:i') }}</div>
              <div class="td-sub">s/d {{ $ptw->end_datetime->format('d/m/Y H:i') }}</div>
            </td>
            <td><span class="status-badge status-{{ $ptw->status }}">{{ ucfirst($ptw->status) }}</span></td>
            <td>
              <a href="#" class="btn-action btn-view"><i class="fas fa-eye"></i></a>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="6" class="text-center py-5">
              <p class="text-secondary">Anda belum mengajukan izin kerja.</p>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
