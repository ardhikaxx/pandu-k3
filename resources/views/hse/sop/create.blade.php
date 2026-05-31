@extends('layouts.app')

@section('title', 'Buat SOP')
@section('page-title', 'Penyusunan Prosedur (SOP)')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('hse.dashboard') }}">Beranda</a></li>
  <li class="breadcrumb-item"><a href="{{ route('hse.sop.index') }}">SOP</a></li>
  <li class="breadcrumb-item active">Buat Baru</li>
@endsection

@section('content')
<div class="row justify-content-center">
  <div class="col-lg-10">
    <div class="pandu-card">
      <div class="pandu-card-header bg-light">
        <h6 class="card-title-custom mb-0">Formulir Penyusunan Prosedur Kerja Standar</h6>
      </div>
      <div class="pandu-card-body">
        <form action="{{ route('hse.sop.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
          
          <div class="row mb-3">
            <div class="col-md-8">
              <label for="title" class="form-label">Judul SOP</label>
              <input type="text" name="title" class="form-control" placeholder="Contoh: Prosedur Penggunaan Alat Pelindung Diri" required>
            </div>
            <div class="col-md-4">
              <label for="category" class="form-label">Kategori</label>
              <select name="category" class="form-control" required>
                <option value="work_procedure">Prosedur Kerja</option>
                <option value="emergency_response">Tanggap Darurat</option>
                <option value="chemical_handling">Penanganan Kimia</option>
                <option value="fire_safety">Kebakaran</option>
                <option value="first_aid">P3K</option>
                <option value="other">Lainnya</option>
              </select>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-md-6">
              <label for="division_id" class="form-label">Divisi (Opsional)</label>
              <select name="division_id" class="form-control">
                <option value="">Berlaku untuk Semua Divisi</option>
                @foreach($divisions as $div)
                  <option value="{{ $div->id }}">{{ $div->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-6">
              <label for="work_area_id" class="form-label">Area Kerja (Opsional)</label>
              <select name="work_area_id" class="form-control">
                <option value="">Berlaku untuk Semua Area</option>
                @foreach($workAreas as $area)
                  <option value="{{ $area->id }}">{{ $area->name }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="mb-3">
            <label for="content" class="form-label">Isi Prosedur (Markdown / HTML)</label>
            <textarea name="content" rows="12" class="form-control font-monospace" placeholder="Tuliskan langkah-langkah prosedur secara detail di sini..." required></textarea>
            <div class="form-text small text-secondary">Anda dapat menggunakan format teks standar untuk memperjelas instruksi.</div>
          </div>

          <div class="mb-4">
            <label for="document" class="form-label">Lampiran Dokumen PDF (Opsional)</label>
            <input type="file" name="document" class="form-control" accept=".pdf">
            <div class="form-text small text-secondary">Ukuran maksimal 10MB.</div>
          </div>

          <div class="d-flex gap-2 justify-content-end">
            <a href="{{ route('hse.sop.index') }}" class="btn btn-light">Batal</a>
            <button type="submit" class="btn btn-pandu-primary px-5">SIMPAN SEBAGAI DRAFT <i class="fas fa-save ms-2"></i></button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
