@extends('layouts.app')

@section('title', 'Manajemen SOP')
@section('page-title', 'Standard Operating Procedures')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('hse.dashboard') }}">Beranda</a></li>
  <li class="breadcrumb-item active">SOP</li>
@endsection

@section('page-actions')
  <a href="{{ route('hse.sop.create') }}" class="btn btn-pandu-primary">
    <i class="fas fa-plus me-2"></i> Buat SOP Baru
  </a>
@endsection

@section('content')
<div class="pandu-card">
  <div class="pandu-card-header">
    <h6 class="card-title-custom mb-0">Seluruh Dokumen Prosedur Kerja (SOP)</h6>
  </div>
  <div class="pandu-card-body p-0">
    <div class="table-responsive">
      <table class="table pandu-table">
        <thead>
          <tr>
            <th>No. Dokumen</th>
            <th>Judul / Kategori</th>
            <th>Area / Divisi</th>
            <th>Status</th>
            <th>Versi</th>
            <th>Dilihat</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($sops as $sop)
          <tr>
            <td><span class="doc-number">{{ $sop->document_number }}</span></td>
            <td>
              <div class="td-main">{{ $sop->title }}</div>
              <div class="td-sub">{{ ucfirst(str_replace('_', ' ', $sop->category)) }}</div>
            </td>
            <td>
              <div class="td-main">{{ $sop->workArea->name ?? 'Semua Area' }}</div>
              <div class="td-sub">{{ $sop->division->name ?? 'Semua Divisi' }}</div>
            </td>
            <td><span class="status-badge status-{{ $sop->status }}">{{ ucfirst($sop->status) }}</span></td>
            <td><div class="td-main">v{{ $sop->version }}</div></td>
            <td><div class="td-main text-secondary"><i class="fas fa-eye me-1"></i> {{ $sop->view_count }}</div></td>
            <td>
              <a href="{{ route('hse.sop.show', $sop->id) }}" class="btn-action btn-view"><i class="fas fa-eye"></i></a>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="7" class="text-center py-5">
              <p class="text-secondary">Belum ada dokumen SOP.</p>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
