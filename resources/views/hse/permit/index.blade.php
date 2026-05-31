@extends('layouts.app')

@section('title', 'Otorisasi Izin Kerja')
@section('page-title', 'Permit to Work (PTW)')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('hse.dashboard') }}">Beranda</a></li>
  <li class="breadcrumb-item active">Izin Kerja</li>
@endsection

@section('content')
<div class="pandu-card">
  <div class="pandu-card-header">
    <h6 class="card-title-custom mb-0">Seluruh Pengajuan Izin Kerja Berisiko</h6>
  </div>
  <div class="pandu-card-body p-0">
    <div class="table-responsive">
      <table class="table pandu-table">
        <thead>
          <tr>
            <th>No. Izin</th>
            <th>Pekerjaan / Tipe</th>
            <th>Pemohon</th>
            <th>Area</th>
            <th>Mulai</th>
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
            <td>
               <div class="td-main">{{ $ptw->applicant->name }}</div>
               <div class="td-sub">Spv: {{ $ptw->supervisor->name }}</div>
            </td>
            <td><span class="area-badge">{{ $ptw->workArea->name }}</span></td>
            <td>
              <div class="td-main">{{ $ptw->start_datetime->format('d M Y') }}</div>
              <div class="td-sub">{{ $ptw->start_datetime->format('H:i') }} WIB</div>
            </td>
            <td><span class="status-badge status-{{ $ptw->status }}">{{ ucfirst($ptw->status) }}</span></td>
            <td>
              <a href="{{ route('hse.permit.show', $ptw->id) }}" class="btn btn-sm btn-pandu-primary">
                Review
              </a>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="7" class="text-center py-5">
              <p class="text-secondary">Belum ada pengajuan izin kerja.</p>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
