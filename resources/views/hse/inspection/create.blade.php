@extends('layouts.app')

@section('title', 'Jadwalkan Inspeksi')
@section('page-title', 'Jadwalkan Inspeksi Baru')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('hse.dashboard') }}">Beranda</a></li>
  <li class="breadcrumb-item"><a href="{{ route('hse.inspection.index') }}">Inspeksi</a></li>
  <li class="breadcrumb-item active">Jadwal Baru</li>
@endsection

@section('content')
<div class="row justify-content-center">
  <div class="col-lg-8">
    <div class="pandu-card">
      <div class="pandu-card-header bg-light">
        <h6 class="card-title-custom mb-0">Formulir Penjadwalan Inspeksi K3</h6>
      </div>
      <div class="pandu-card-body">
        <form action="{{ route('hse.inspection.store') }}" method="POST">
          @csrf
          
          <div class="mb-3">
            <label for="title" class="form-label">Judul Inspeksi</label>
            <input type="text" name="title" class="form-control" placeholder="Contoh: Inspeksi Bulanan APD Divisi Produksi" required>
          </div>

          <div class="row mb-3">
            <div class="col-md-6">
              <label for="inspection_type" class="form-label">Tipe Inspeksi</label>
              <select name="inspection_type" class="form-control" required>
                <option value="daily">Harian (Daily)</option>
                <option value="weekly">Mingguan (Weekly)</option>
                <option value="monthly" selected>Bulanan (Monthly)</option>
                <option value="special">Khusus (Special)</option>
                <option value="audit_follow_up">Tindak Lanjut Audit</option>
              </select>
            </div>
            <div class="col-md-6">
              <label for="scheduled_date" class="form-label">Tanggal Pelaksanaan</label>
              <input type="date" name="scheduled_date" class="form-control" value="{{ date('Y-m-d') }}" required>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-md-6">
              <label for="division_id" class="form-label">Divisi Objek Inspeksi</label>
              <select name="division_id" class="form-control" required>
                <option value="" selected disabled>Pilih Divisi...</option>
                @foreach($divisions as $div)
                  <option value="{{ $div->id }}">{{ $div->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-6">
              <label for="work_area_id" class="form-label">Area Kerja Spesifik</label>
              <select name="work_area_id" class="form-control" required>
                <option value="" selected disabled>Pilih Area...</option>
                @foreach($workAreas as $area)
                  <option value="{{ $area->id }}">{{ $area->name }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="mb-4">
            <label for="inspector_id" class="form-label">Inspektur yang Ditugaskan</label>
            <select name="inspector_id" class="form-control" required>
              <option value="" selected disabled>Pilih Personil...</option>
              @foreach($inspectors as $user)
                <option value="{{ $user->id }}">{{ $user->name }} ({{ ucfirst($user->role) }})</option>
              @endforeach
            </select>
          </div>

          <div class="alert alert-info border-0 small shadow-sm">
            <i class="fas fa-info-circle me-2"></i> Inspektur akan menerima notifikasi tugas pada hari pelaksanaan yang dijadwalkan.
          </div>

          <div class="d-flex gap-2 justify-content-end">
            <a href="{{ route('hse.inspection.index') }}" class="btn btn-light">Batal</a>
            <button type="submit" class="btn btn-pandu-primary px-4">Simpan Jadwal <i class="fas fa-calendar-check ms-2"></i></button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
