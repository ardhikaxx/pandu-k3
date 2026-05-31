@extends('layouts.app')

@section('title', 'Kepatuhan Kompetensi')
@section('page-title', 'Sertifikat Kompetensi Karyawan')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('hse.dashboard') }}">Beranda</a></li>
  <li class="breadcrumb-item active">Sertifikat</li>
@endsection

@section('page-actions')
  <a href="{{ route('hse.certificate.create') }}" class="btn btn-pandu-primary">
    <i class="fas fa-plus me-2"></i> Tambah Sertifikat
  </a>
@endsection

@section('content')
<div class="pandu-card">
  <div class="pandu-card-header">
    <h6 class="card-title-custom mb-0">Daftar Sertifikat & Masa Berlaku</h6>
  </div>
  <div class="pandu-card-body p-0">
    <div class="table-responsive">
      <table class="table pandu-table">
        <thead>
          <tr>
            <th>Karyawan</th>
            <th>Tipe Sertifikat</th>
            <th>No. Sertifikat / Penerbit</th>
            <th>Masa Berlaku</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($certificates as $cert)
          <tr>
            <td>
              <div class="td-main">{{ $cert->user->name }}</div>
              <div class="td-sub">{{ $cert->user->employee_id }}</div>
            </td>
            <td><div class="td-main fw-bold">{{ ucfirst(str_replace('_', ' ', $cert->certificate_type)) }}</div></td>
            <td>
              <div class="td-main">{{ $cert->certificate_number }}</div>
              <div class="td-sub">{{ $cert->issuing_body }}</div>
            </td>
            <td>
              <div class="td-main">{{ $cert->expiry_date->format('d M Y') }}</div>
              <div class="td-sub">{{ $cert->expiry_date->diffForHumans() }}</div>
            </td>
            <td><span class="status-badge status-{{ $cert->status }}">{{ ucfirst(str_replace('_', ' ', $cert->status)) }}</span></td>
            <td>
              @if($cert->document_path)
                <a href="{{ asset('storage/'.$cert->document_path) }}" class="btn-action btn-view" target="_blank"><i class="fas fa-file-pdf"></i></a>
              @endif
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="6" class="text-center py-5">
              <p class="text-secondary">Belum ada data sertifikat.</p>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
