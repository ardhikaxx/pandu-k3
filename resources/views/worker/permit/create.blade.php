@extends('layouts.app')

@section('title', 'Ajukan PTW')
@section('page-title', 'Pengajuan Izin Kerja')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('worker.dashboard') }}">Beranda</a></li>
  <li class="breadcrumb-item"><a href="{{ route('worker.permit.index') }}">Izin Kerja</a></li>
  <li class="breadcrumb-item active">Pengajuan Baru</li>
@endsection

@section('content')
<div class="row justify-content-center">
  <div class="col-lg-8">
    <div class="pandu-card">
      <div class="pandu-card-header bg-light">
        <h6 class="card-title-custom mb-0">Formulir Permit to Work (PTW)</h6>
      </div>
      <div class="pandu-card-body">
        <form action="{{ route('worker.permit.store') }}" method="POST">
          @csrf
          
          <div class="mb-3">
            <label for="title" class="form-label">Judul Pekerjaan</label>
            <input type="text" name="title" class="form-control" placeholder="Contoh: Pengelasan Tangki Solar Utama" required>
          </div>

          <div class="row mb-3">
            <div class="col-md-6">
              <label for="work_type" class="form-label">Tipe Pekerjaan Berisiko</label>
              <select name="work_type" class="form-control" required>
                <option value="hot_work">Pekerjaan Panas (Hot Work)</option>
                <option value="confined_space">Ruang Terbatas (Confined Space)</option>
                <option value="working_at_height">Ketinggian (Working at Height)</option>
                <option value="electrical">Listrik (Electrical)</option>
                <option value="other">Lainnya</option>
              </select>
            </div>
            <div class="col-md-6">
              <label for="work_area_id" class="form-label">Area Kerja</label>
              <select name="work_area_id" class="form-control" required>
                @foreach($workAreas as $area)
                  <option value="{{ $area->id }}">{{ $area->name }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-md-6">
              <label for="start_datetime" class="form-label">Mulai Pekerjaan</label>
              <input type="datetime-local" name="start_datetime" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label for="end_datetime" class="form-label">Selesai Pekerjaan</label>
              <input type="datetime-local" name="end_datetime" class="form-control" required>
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label">APD Wajib (Pilih minimal 1)</label>
            <div class="row g-2">
              <div class="col-md-4">
                <div class="form-check border p-2 rounded">
                  <input class="form-check-input ms-1" type="checkbox" name="required_ppe[]" value="helmet" id="ppe1">
                  <label class="form-check-label ms-1" for="ppe1">Safety Helmet</label>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-check border p-2 rounded">
                  <input class="form-check-input ms-1" type="checkbox" name="required_ppe[]" value="shoes" id="ppe2">
                  <label class="form-check-label ms-1" for="ppe2">Safety Shoes</label>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-check border p-2 rounded">
                  <input class="form-check-input ms-1" type="checkbox" name="required_ppe[]" value="harness" id="ppe3">
                  <label class="form-check-label ms-1" for="ppe3">Body Harness</label>
                </div>
              </div>
            </div>
          </div>

          <div class="mb-3">
            <label for="precautions" class="form-label">Langkah Pencegahan Bahaya</label>
            <textarea name="precautions" rows="4" class="form-control" placeholder="Jelaskan langkah keselamatan yang akan diambil..." required></textarea>
          </div>

          <div class="mb-4">
            <label for="supervisor_id" class="form-label">Supervisor Pengawas</label>
            <select name="supervisor_id" class="form-control" required>
              <option value="" selected disabled>Pilih Supervisor...</option>
              @foreach($supervisors as $sv)
                <option value="{{ $sv->id }}">{{ $sv->name }}</option>
              @endforeach
            </select>
          </div>

          <div class="d-flex gap-2 justify-content-end">
            <a href="{{ route('worker.permit.index') }}" class="btn btn-light">Batal</a>
            <button type="submit" class="btn btn-pandu-primary px-4">Kirim Pengajuan <i class="fas fa-paper-plane ms-2"></i></button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
