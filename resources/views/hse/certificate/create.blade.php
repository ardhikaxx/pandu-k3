@extends('layouts.app')

@section('title', 'Tambah Sertifikat')
@section('page-title', 'Pencatatan Sertifikat K3')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('hse.dashboard') }}">Beranda</a></li>
  <li class="breadcrumb-item"><a href="{{ route('hse.certificate.index') }}">Sertifikat</a></li>
  <li class="breadcrumb-item active">Tambah Baru</li>
@endsection

@section('content')
<div class="row justify-content-center">
  <div class="col-lg-8">
    <div class="pandu-card">
      <div class="pandu-card-header bg-light">
        <h6 class="card-title-custom mb-0">Formulir Data Sertifikasi Kompetensi</h6>
      </div>
      <div class="pandu-card-body">
        <form action="{{ route('hse.certificate.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
          
          <div class="mb-3">
            <label for="user_id" class="form-label">Nama Karyawan</label>
            <select name="user_id" class="form-control" required>
               <option value="" selected disabled>Pilih Karyawan...</option>
               @foreach($users as $user)
                 <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->employee_id }})</option>
               @endforeach
            </select>
          </div>

          <div class="row mb-3">
            <div class="col-md-6">
              <label for="certificate_type" class="form-label">Tipe Sertifikat</label>
              <select name="certificate_type" class="form-control" required>
                <option value="k3_umum">Ahli K3 Umum</option>
                <option value="k3_ahli">Ahli K3 Spesialis</option>
                <option value="operator_forklift">Operator Forklift</option>
                <option value="operator_crane">Operator Crane</option>
                <option value="welder">Welder / Juru Las</option>
                <option value="first_aid">Petugas P3K</option>
                <option value="fire_fighting">Pemadam Kebakaran</option>
                <option value="other">Lainnya</option>
              </select>
            </div>
            <div class="col-md-6">
              <label for="certificate_number" class="form-label">Nomor Sertifikat</label>
              <input type="text" name="certificate_number" class="form-control" placeholder="Contoh: 12345/K3-UM/XII/2024" required>
            </div>
          </div>

          <div class="row mb-3">
             <div class="col-md-12">
               <label for="issuing_body" class="form-label">Lembaga Penerbit</label>
               <input type="text" name="issuing_body" class="form-control" placeholder="Contoh: Kemnaker RI / BNSP" required>
             </div>
          </div>

          <div class="row mb-3">
            <div class="col-md-6">
              <label for="issued_date" class="form-label">Tanggal Terbit</label>
              <input type="date" name="issued_date" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label for="expiry_date" class="form-label">Tanggal Kadaluarsa</label>
              <input type="date" name="expiry_date" class="form-control" required>
            </div>
          </div>

          <div class="mb-4">
            <label for="document" class="form-label">Scan Sertifikat (PDF/Gambar)</label>
            <input type="file" name="document" class="form-control" accept=".pdf,image/*">
          </div>

          <div class="d-flex gap-2 justify-content-end">
            <a href="{{ route('hse.certificate.index') }}" class="btn btn-light">Batal</a>
            <button type="submit" class="btn btn-pandu-primary px-4">Simpan Data <i class="fas fa-save ms-2"></i></button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
