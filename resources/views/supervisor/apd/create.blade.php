@extends('layouts.app')

@section('title', 'Tambah APD')
@section('page-title', 'Input Stok APD')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('supervisor.dashboard') }}">Beranda</a></li>
  <li class="breadcrumb-item"><a href="{{ route('supervisor.apd.index') }}">Inventaris APD</a></li>
  <li class="breadcrumb-item active">Tambah Baru</li>
@endsection

@section('content')
<div class="row justify-content-center">
  <div class="col-lg-8">
    <div class="pandu-card">
      <div class="pandu-card-header bg-light">
        <h6 class="card-title-custom mb-0">Formulir Data Alat Pelindung Diri</h6>
      </div>
      <div class="pandu-card-body">
        <form action="{{ route('supervisor.apd.store') }}" method="POST">
          @csrf
          
          <div class="row mb-3">
            <div class="col-md-4">
              <label for="item_code" class="form-label">Kode Item / Barcode</label>
              <input type="text" name="item_code" class="form-control" placeholder="Contoh: APD-PROD-001" required>
            </div>
            <div class="col-md-8">
              <label for="name" class="form-label">Nama Alat / Spesifikasi</label>
              <input type="text" name="name" class="form-control" placeholder="Contoh: Helm Safety 3M Orange" required>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-md-6">
              <label for="category" class="form-label">Kategori</label>
              <select name="category" class="form-control" required>
                <option value="helmet">Helm (Helmet)</option>
                <option value="vest">Rompi (Vest)</option>
                <option value="gloves">Sarung Tangan (Gloves)</option>
                <option value="boots">Sepatu (Boots)</option>
                <option value="goggles">Kacamata (Goggles)</option>
                <option value="mask">Masker (Mask)</option>
                <option value="harness">Harness</option>
                <option value="other">Lainnya</option>
              </select>
            </div>
            <div class="col-md-6">
              <label for="work_area_id" class="form-label">Area Kerja Penempatan</label>
              <select name="work_area_id" class="form-control" required>
                @foreach($workAreas as $area)
                  <option value="{{ $area->id }}">{{ $area->name }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-md-4">
              <label for="total_quantity" class="form-label">Total Stok</label>
              <input type="number" name="total_quantity" class="form-control" min="1" required>
            </div>
            <div class="col-md-4">
              <label for="available_quantity" class="form-label">Stok Layak Pakai</label>
              <input type="number" name="available_quantity" class="form-control" min="0" required>
            </div>
            <div class="col-md-4">
              <label for="condition" class="form-label">Kondisi Dominan</label>
              <select name="condition" class="form-control" required>
                <option value="good">Sangat Baik (Good)</option>
                <option value="fair">Cukup (Fair)</option>
                <option value="poor">Buruk (Poor)</option>
                <option value="damaged">Rusak (Damaged)</option>
              </select>
            </div>
          </div>

          <div class="row mb-3">
             <div class="col-md-6">
               <label for="brand" class="form-label">Merk (Brand)</label>
               <input type="text" name="brand" class="form-control" placeholder="Contoh: 3M, Krisbow">
             </div>
             <div class="col-md-6">
               <label for="size" class="form-label">Ukuran (Size)</label>
               <input type="text" name="size" class="form-control" placeholder="Contoh: L, XL, 42">
             </div>
          </div>

          <div class="mb-4">
            <label for="notes" class="form-label">Catatan / Keterangan</label>
            <textarea name="notes" rows="3" class="form-control" placeholder="Informasi tambahan terkait batch atau kondisi..."></textarea>
          </div>

          <div class="d-flex gap-2 justify-content-end">
            <a href="{{ route('supervisor.apd.index') }}" class="btn btn-light">Batal</a>
            <button type="submit" class="btn btn-pandu-primary px-4">Simpan Data <i class="fas fa-save ms-2"></i></button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
