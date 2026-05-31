@extends('layouts.app')

@section('title', 'Toolbox Meeting')
@section('page-title', 'Safety Briefing & Toolbox Meeting')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('supervisor.dashboard') }}">Beranda</a></li>
  <li class="breadcrumb-item active">Toolbox Meeting</li>
@endsection

@section('page-actions')
  <a href="{{ route('supervisor.toolbox.create') }}" class="btn btn-pandu-primary">
    <i class="fas fa-plus me-2"></i> Buat Jadwal TBM
  </a>
@endsection

@section('content')
<div class="pandu-card">
  <div class="pandu-card-header">
    <h6 class="card-title-custom mb-0">Riwayat Toolbox Meeting Divisi</h6>
  </div>
  <div class="pandu-card-body p-0">
    <div class="table-responsive">
      <table class="table pandu-table">
        <thead>
          <tr>
            <th>No. Meeting</th>
            <th>Judul / Topik</th>
            <th>Area</th>
            <th>Waktu</th>
            <th>Facilitator</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($meetings as $tbm)
          <tr>
            <td><span class="doc-number">{{ $tbm->meeting_number }}</span></td>
            <td>
               <div class="td-main">{{ $tbm->title }}</div>
               <div class="td-sub">{{ Str::limit($tbm->topic, 50) }}</div>
            </td>
            <td><span class="area-badge">{{ $tbm->workArea->name }}</span></td>
            <td>
               <div class="td-main">{{ $tbm->meeting_date->format('d M Y') }}</div>
               <div class="td-sub">{{ $tbm->start_time }} - {{ $tbm->end_time }}</div>
            </td>
            <td><div class="td-main">{{ $tbm->facilitator->name }}</div></td>
            <td><span class="status-badge status-{{ $tbm->status }}">{{ ucfirst($tbm->status) }}</span></td>
            <td>
               <a href="{{ route('supervisor.toolbox.show', $tbm->id) }}" class="btn-action btn-view"><i class="fas fa-eye"></i></a>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="7" class="text-center py-5">
               <p class="text-secondary">Belum ada catatan toolbox meeting.</p>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
