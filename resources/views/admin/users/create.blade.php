@extends('layouts.app')

@section('title', 'Tambah Pengguna')
@section('page-title', 'Pendaftaran Pengguna Baru')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Beranda</a></li>
  <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Pengguna</a></li>
  <li class="breadcrumb-item active">Tambah</li>
@endsection

@section('content')
<div class="row justify-content-center">
  <div class="col-lg-8">
    <div class="pandu-card">
      <div class="pandu-card-header bg-light">
        <h6 class="card-title-custom mb-0">Formulir Identitas & Hak Akses Pengguna</h6>
      </div>
      <div class="pandu-card-body">
        <form action="{{ route('admin.users.store') }}" method="POST">
          @csrf
          
          <div class="row mb-3">
             <div class="col-md-6">
                <label for="name" class="form-label">Nama Lengkap</label>
                <input type="text" name="name" class="form-control" placeholder="Nama sesuai KTP" required>
             </div>
             <div class="col-md-6">
                <label for="employee_id" class="form-label">NIK / Nomor Induk Karyawan</label>
                <input type="text" name="employee_id" class="form-control" placeholder="Contoh: 20240012">
             </div>
          </div>

          <div class="row mb-3">
             <div class="col-md-6">
                <label for="email" class="form-label">Alamat Email (User ID)</label>
                <input type="email" name="email" class="form-control" placeholder="user@company.com" required>
             </div>
             <div class="col-md-6">
                <label for="password" class="form-label">Password Sementara</label>
                <input type="password" name="password" class="form-control" placeholder="Minimal 8 karakter" required>
             </div>
          </div>

          <div class="row mb-3">
            <div class="col-md-6">
              <label for="role" class="form-label">Peran (Role)</label>
              <select name="role" class="form-control" required>
                <option value="worker">Pekerja / Staf Lapangan</option>
                <option value="supervisor">Supervisor / Pengawas</option>
                <option value="hse_manager">HSE Manager</option>
                <option value="super_admin">Super Admin / Direktur</option>
              </select>
            </div>
            <div class="col-md-6">
              <label for="company_id" class="form-label">Perusahaan / Site</label>
              <select name="company_id" class="form-control" required>
                @foreach($companies as $c)
                  <option value="{{ $c->id }}">{{ $c->name }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="row mb-4">
             <div class="col-md-6">
                <label for="division_id" class="form-label">Divisi (Opsional)</label>
                <select name="division_id" class="form-control">
                  <option value="">Pilih Divisi...</option>
                  @foreach($divisions as $d)
                    <option value="{{ $d->id }}">{{ $d->name }}</option>
                  @endforeach
                </select>
             </div>
             <div class="col-md-6">
                <label for="work_area_id" class="form-label">Area Kerja (Opsional)</label>
                <select name="work_area_id" class="form-control">
                   <option value="">Pilih Area...</option>
                   @foreach($workAreas as $wa)
                     <option value="{{ $wa->id }}">{{ $wa->name }}</option>
                   @endforeach
                </select>
             </div>
          </div>

          <div class="d-flex gap-2 justify-content-end">
            <a href="{{ route('admin.users.index') }}" class="btn btn-light">Batal</a>
            <button type="submit" class="btn btn-pandu-primary px-5">DAFTARKAN PENGGUNA <i class="fas fa-user-check ms-2"></i></button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
