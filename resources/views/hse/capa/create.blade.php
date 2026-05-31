@extends('layouts.app')

@section('title', 'Buat CAPA')
@section('page-title', 'Buat Rencana Tindakan (CAPA)')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('hse.dashboard') }}">Beranda</a></li>
  <li class="breadcrumb-item"><a href="{{ route('hse.capa.index') }}">CAPA</a></li>
  <li class="breadcrumb-item active">Buat Baru</li>
@endsection

@section('content')
<div class="row justify-content-center">
  <div class="col-lg-8">
    <div class="pandu-card">
      <div class="pandu-card-header bg-light">
        <h6 class="card-title-custom mb-0">Formulir Rencana Tindakan Korektif & Preventif</h6>
      </div>
      <div class="pandu-card-body">
        <form action="{{ route('hse.capa.store') }}" method="POST">
          @csrf
          
          <div class="mb-3">
            <label for="title" class="form-label">Judul Tindakan</label>
            <input type="text" name="title" class="form-control" placeholder="Contoh: Pemasangan Guarding pada Mesin Press" required>
          </div>

          <div class="mb-3">
            <label for="description" class="form-label">Deskripsi Detail & Instruksi</label>
            <textarea name="description" rows="4" class="form-control" placeholder="Jelaskan apa yang harus dilakukan..." required></textarea>
          </div>

          <div class="row mb-3">
            <div class="col-md-6">
              <label for="action_type" class="form-label">Tipe Tindakan</label>
              <select name="action_type" class="form-control" required>
                <option value="corrective">Korektif (Corrective)</option>
                <option value="preventive">Preventif (Preventive)</option>
                <option value="improvement">Peningkatan (Improvement)</option>
              </select>
            </div>
            <div class="col-md-6">
              <label for="priority" class="form-label">Prioritas</label>
              <select name="priority" class="form-control" required>
                <option value="low">Rendah</option>
                <option value="medium" selected>Sedang</option>
                <option value="high">Tinggi</option>
                <option value="critical">Kritis</option>
              </select>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-md-6">
              <label for="division_id" class="form-label">Divisi Penanggung Jawab</label>
              <select name="division_id" class="form-control" required>
                <option value="" selected disabled>Pilih Divisi...</option>
                @foreach($divisions as $div)
                  <option value="{{ $div->id }}">{{ $div->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-6">
              <label for="assigned_to" class="form-label">Personil yang Ditugaskan (PIC)</label>
              <select name="assigned_to" class="form-control" required>
                <option value="" selected disabled>Pilih Personil...</option>
                @foreach($users as $user)
                  <option value="{{ $user->id }}">{{ $user->name }} ({{ ucfirst($user->role) }})</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="mb-4">
            <label for="due_date" class="form-label">Batas Waktu Penyelesaian (Deadline)</label>
            <input type="date" name="due_date" class="form-control" value="{{ date('Y-m-d', strtotime('+7 days')) }}" required>
          </div>

          <div class="d-flex gap-2 justify-content-end">
            <a href="{{ route('hse.capa.index') }}" class="btn btn-light">Batal</a>
            <button type="submit" class="btn btn-pandu-primary px-4">Tugaskan Sekarang <i class="fas fa-paper-plane ms-2"></i></button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
