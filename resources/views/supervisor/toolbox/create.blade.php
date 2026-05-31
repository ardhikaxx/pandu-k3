@extends('layouts.app')

@section('title', 'Jadwalkan TBM')
@section('page-title', 'Buat Toolbox Meeting')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('supervisor.dashboard') }}">Beranda</a></li>
  <li class="breadcrumb-item"><a href="{{ route('supervisor.toolbox.index') }}">Toolbox Meeting</a></li>
  <li class="breadcrumb-item active">Buat Baru</li>
@endsection

@section('content')
<div class="row justify-content-center">
  <div class="col-lg-8">
    <div class="pandu-card">
      <div class="pandu-card-header bg-light">
        <h6 class="card-title-custom mb-0">Formulir Toolbox Meeting K3</h6>
      </div>
      <div class="pandu-card-body">
        <form action="{{ route('supervisor.toolbox.store') }}" method="POST">
          @csrf
          
          <div class="mb-3">
            <label for="title" class="form-label">Judul Meeting</label>
            <input type="text" name="title" class="form-control" placeholder="Contoh: Safety Talk Sebelum Shift Pagi" required>
          </div>

          <div class="mb-3">
            <label for="topic" class="form-label">Topik Utama Pembahasan</label>
            <input type="text" name="topic" class="form-control" placeholder="Contoh: Bahaya Listrik di Area Basah" required>
          </div>

          <div class="row mb-3">
            <div class="col-md-6">
              <label for="work_area_id" class="form-label">Area Pelaksanaan</label>
              <select name="work_area_id" class="form-control" required>
                @foreach($workAreas as $area)
                  <option value="{{ $area->id }}">{{ $area->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-6">
              <label for="meeting_date" class="form-label">Tanggal</label>
              <input type="date" name="meeting_date" class="form-control" value="{{ date('Y-m-d') }}" required>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-md-6">
              <label for="start_time" class="form-label">Jam Mulai</label>
              <input type="time" name="start_time" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label for="end_time" class="form-label">Jam Selesai</label>
              <input type="time" name="end_time" class="form-control" required>
            </div>
          </div>

          <div class="mb-3">
            <label for="location" class="form-label">Lokasi Spesifik</label>
            <input type="text" name="location" class="form-control" placeholder="Contoh: Depan Lobi Produksi" required>
          </div>

          <div class="mb-4">
            <label for="agenda" class="form-label">Agenda & Materi</label>
            <textarea name="agenda" rows="5" class="form-control" placeholder="Tuliskan poin-poin yang akan disampaikan..." required></textarea>
          </div>

          <div class="d-flex gap-2 justify-content-end mt-4">
            <a href="{{ route('supervisor.toolbox.index') }}" class="btn btn-light">Batal</a>
            <button type="submit" class="btn btn-pandu-primary px-5">SIMPAN JADWAL TBM <i class="fas fa-save ms-2"></i></button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
