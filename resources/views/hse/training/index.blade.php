@extends('layouts.app')

@section('title', 'Pelatihan K3')
@section('page-title', 'Manajemen Pelatihan Keselamatan')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('hse.dashboard') }}">Beranda</a></li>
  <li class="breadcrumb-item active">Pelatihan</li>
@endsection

@section('page-actions')
  <a href="{{ route('hse.training.create') }}" class="btn btn-pandu-primary">
    <i class="fas fa-plus me-2"></i> Tambah Jadwal Pelatihan
  </a>
@endsection

@section('content')
<div class="pandu-card">
  <div class="pandu-card-header">
    <h6 class="card-title-custom mb-0">Daftar Pelatihan & Sosialisasi K3</h6>
  </div>
  <div class="pandu-card-body p-0">
    <div class="table-responsive">
      <table class="table pandu-table">
        <thead>
          <tr>
            <th>No. Pelatihan</th>
            <th>Judul / Tipe</th>
            <th>Penyelenggara / Trainer</th>
            <th>Jadwal</th>
            <th>Kuota</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($trainings as $trn)
          <tr>
            <td><span class="doc-number">{{ $trn->training_number }}</span></td>
            <td>
              <div class="td-main">{{ $trn->title }}</div>
              <div class="td-sub">{{ ucfirst(str_replace('_', ' ', $trn->type)) }}</div>
            </td>
            <td>
              <div class="td-main">{{ $trn->provider }}</div>
              <div class="td-sub">Oleh: {{ $trn->trainer_name }}</div>
            </td>
            <td>
              <div class="td-main">{{ $trn->scheduled_date->format('d M Y') }}</div>
              <div class="td-sub">{{ $trn->duration_hours }} Jam</div>
            </td>
            <td>
              <div class="td-main">{{ $trn->participants_count ?? 0 }} / {{ $trn->max_participants }}</div>
            </td>
            <td><span class="status-badge status-{{ $trn->status }}">{{ ucfirst($trn->status) }}</span></td>
            <td>
              <a href="{{ route('hse.training.show', $trn->id) }}" class="btn-action btn-view"><i class="fas fa-eye"></i></a>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="7" class="text-center py-5">
              <p class="text-secondary">Belum ada jadwal pelatihan.</p>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
