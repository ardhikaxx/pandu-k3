@extends('layouts.app')

@section('title', 'Jadwalkan Pelatihan')
@section('page-title', 'Tambah Jadwal Pelatihan Baru')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('hse.dashboard') }}">Beranda</a></li>
  <li class="breadcrumb-item"><a href="{{ route('hse.training.index') }}">Pelatihan</a></li>
  <li class="breadcrumb-item active">Jadwal Baru</li>
@endsection

@section('content')
<div class="row justify-content-center">
  <div class="col-lg-8">
    <div class="pandu-card">
      <div class="pandu-card-header bg-light">
        <h6 class="card-title-custom mb-0">Formulir Pelatihan K3</h6>
      </div>
      <div class="pandu-card-body">
        <form action="{{ route('hse.training.store') }}" method="POST">
          @csrf
          
          <div class="mb-3">
            <label for="title" class="form-label">Judul Pelatihan / Sosialisasi</label>
            <input type="text" name="title" class="form-control" placeholder="Contoh: Induksi Keselamatan Pekerja Baru" required>
          </div>

          <div class="row mb-3">
            <div class="col-md-6">
              <label for="type" class="form-label">Tipe Pelatihan</label>
              <select name="type" class="form-control" required>
                <option value="induction">Safety Induction</option>
                <option value="refresher">Refresher Training</option>
                <option value="specialist">Specialist Training</option>
                <option value="emergency_drill">Emergency Drill</option>
                <option value="regulatory">Regulatory Compliance</option>
                <option value="on_the_job">On the Job Training</option>
              </select>
            </div>
            <div class="col-md-6">
              <label for="division_id" class="form-label">Target Divisi (Opsional)</label>
              <select name="division_id" class="form-control">
                <option value="">Seluruh Divisi</option>
                @foreach($divisions as $div)
                  <option value="{{ $div->id }}">{{ $div->name }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-md-6">
              <label for="provider" class="form-label">Lembaga Penyelenggara</label>
              <input type="text" name="provider" class="form-control" placeholder="Internal / Nama Vendor" required>
            </div>
            <div class="col-md-6">
              <label for="trainer_name" class="form-label">Nama Trainer / Instruktur</label>
              <input type="text" name="trainer_name" class="form-control" placeholder="Nama lengkap instruktur" required>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-md-4">
              <label for="scheduled_date" class="form-label">Tanggal Pelaksanaan</label>
              <input type="date" name="scheduled_date" class="form-control" required>
            </div>
            <div class="col-md-4">
              <label for="duration_hours" class="form-label">Durasi (Jam)</label>
              <input type="number" name="duration_hours" class="form-control" step="0.5" placeholder="Contoh: 4.5" required>
            </div>
            <div class="col-md-4">
              <label for="max_participants" class="form-label">Maksimal Peserta</label>
              <input type="number" name="max_participants" class="form-control" placeholder="Contoh: 30" required>
            </div>
          </div>

          <div class="mb-3">
            <label for="location" class="form-label">Lokasi / Ruangan</label>
            <input type="text" name="location" class="form-control" placeholder="Contoh: Ruang Rapat Lt. 2 / Zoom Meeting" required>
          </div>

          <div class="mb-4">
            <label for="description" class="form-label">Deskripsi & Materi Pelatihan</label>
            <textarea name="description" rows="4" class="form-control" placeholder="Jelaskan silabus atau poin penting pelatihan..." required></textarea>
          </div>

          <div class="d-flex gap-2 justify-content-end mt-4">
            <a href="{{ route('hse.training.index') }}" class="btn btn-light">Batal</a>
            <button type="submit" class="btn btn-pandu-primary px-5">JADWALKAN PELATIHAN <i class="fas fa-calendar-check ms-2"></i></button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
