@extends('layouts.app')

@section('title', 'Inventaris APD')
@section('page-title', 'Manajemen Alat Pelindung Diri')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('supervisor.dashboard') }}">Beranda</a></li>
  <li class="breadcrumb-item active">Inventaris APD</li>
@endsection

@section('page-actions')
  <a href="{{ route('supervisor.apd.create') }}" class="btn btn-pandu-primary">
    <i class="fas fa-plus me-2"></i> Tambah Item APD
  </a>
@endsection

@section('content')
<div class="pandu-card">
  <div class="pandu-card-header">
    <h6 class="card-title-custom mb-0">Daftar Stok APD Divisi</h6>
  </div>
  <div class="pandu-card-body p-0">
    <div class="table-responsive">
      <table class="table pandu-table">
        <thead>
          <tr>
            <th>Kode Item</th>
            <th>Nama APD / Kategori</th>
            <th>Area Kerja</th>
            <th>Tersedia</th>
            <th>Rusak</th>
            <th>Total</th>
            <th>Kondisi</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($items as $item)
          <tr>
            <td><span class="doc-number">{{ $item->item_code }}</span></td>
            <td>
               <div class="td-main">{{ $item->name }}</div>
               <div class="td-sub">{{ ucfirst($item->category) }}</div>
            </td>
            <td><span class="area-badge">{{ $item->workArea->name }}</span></td>
            <td><div class="td-main fw-bold text-success">{{ $item->available_quantity }}</div></td>
            <td><div class="td-main fw-bold text-danger">{{ $item->damaged_quantity }}</div></td>
            <td><div class="td-main">{{ $item->total_quantity }}</div></td>
            <td>
               <span class="status-badge status-{{ $item->condition === 'good' ? 'active' : ($item->condition === 'damaged' ? 'overdue' : 'in_progress') }}">
                  {{ ucfirst($item->condition) }}
               </span>
            </td>
            <td>
               <button class="btn-action btn-view"><i class="fas fa-pen"></i></button>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="8" class="text-center py-5">
               <p class="text-secondary">Belum ada data inventaris APD.</p>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
