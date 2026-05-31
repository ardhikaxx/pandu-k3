@extends('layouts.app')

@section('title', 'Manajemen HIRADC')
@section('page-title', 'Dokumen HIRADC')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('hse.dashboard') }}">Beranda</a></li>
  <li class="breadcrumb-item active">HIRADC</li>
@endsection

@section('page-actions')
  <a href="{{ route('hse.hiradc.create') }}" class="btn btn-pandu-primary">
    <i class="fas fa-plus me-2"></i> Buat HIRADC Baru
  </a>
@endsection

@section('content')
<div class="pandu-card">
  <div class="pandu-card-header">
    <h6 class="card-title-custom mb-0">Daftar Dokumen HIRADC</h6>
  </div>
  <div class="pandu-card-body p-0">
    <div class="table-responsive">
      <table class="table pandu-table">
        <thead>
          <tr>
            <th>No. Dokumen</th>
            <th>Judul</th>
            <th>Area / Divisi</th>
            <th>Status</th>
            <th>Masa Berlaku</th>
            <th>Penyusun</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($documents as $doc)
          <tr>
            <td><span class="doc-number">{{ $doc->document_number }}</span></td>
            <td><div class="td-main">{{ $doc->title }}</div></td>
            <td>
              <div class="td-main">{{ $doc->workArea->name }}</div>
              <div class="td-sub">{{ $doc->division->name }}</div>
            </td>
            <td><span class="status-badge status-{{ $doc->status }}">{{ ucfirst($doc->status) }}</span></td>
            <td>
              <div class="td-main">{{ $doc->valid_from->format('d/m/Y') }}</div>
              <div class="td-sub">s/d {{ $doc->valid_until->format('d/m/Y') }}</div>
            </td>
            <td><div class="td-main">{{ $doc->preparedBy->name }}</div></td>
            <td>
               <a href="{{ route('hse.hiradc.show', $doc->id) }}" class="btn-action btn-view"><i class="fas fa-eye"></i></a>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="7" class="text-center py-5">
               <p class="text-secondary">Belum ada dokumen HIRADC yang dibuat.</p>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
  <div class="table-pagination p-3">
    {{ $documents->links() }}
  </div>
</div>
@endsection
