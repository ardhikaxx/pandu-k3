@extends('layouts.app')

@section('title', 'Tugas Inspeksi')
@section('page-title', 'Tugas Inspeksi Saya')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('supervisor.dashboard') }}">Beranda</a></li>
  <li class="breadcrumb-item active">Inspeksi</li>
@endsection

@section('content')
<div class="pandu-card">
  <div class="pandu-card-header">
    <h6 class="card-title-custom mb-0">Daftar Inspeksi yang Harus Dilakukan</h6>
  </div>
  <div class="pandu-card-body p-0">
    <div class="table-responsive">
      <table class="table pandu-table">
        <thead>
          <tr>
            <th>No. Inspeksi</th>
            <th>Judul</th>
            <th>Area</th>
            <th>Tanggal Jadwal</th>
            <th>Status</th>
            <th>Aksi</th>
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
            <td><span class="area-badge">{{ $ins->workArea->name }}</span></td>
            <td>
              <div class="td-main {{ $ins->scheduled_date < now() && $ins->status === 'scheduled' ? 'text-danger' : '' }}">
                {{ $ins->scheduled_date->format('d M Y') }}
              </div>
            </td>
            <td><span class="status-badge status-{{ $ins->status }}">{{ ucfirst($ins->status) }}</span></td>
            <td>
              @if($ins->status !== 'completed')
                <a href="{{ route('supervisor.inspection.show', $ins->id) }}" class="btn btn-sm btn-pandu-primary">
                  Mulai Inspeksi
                </a>
              @else
                <a href="{{ route('supervisor.inspection.show', $ins->id) }}" class="btn btn-sm btn-outline-secondary">
                  Lihat Hasil
                </a>
              @endif
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="6" class="text-center py-5">
              <p class="text-secondary">Anda tidak memiliki tugas inspeksi.</p>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
