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
  <div class="col-lg-10 col-xl-9">
    <div class="pandu-card shadow-lg">
      <div class="pandu-card-header bg-light py-3">
        <div class="d-flex align-items-center gap-2">
           <div class="icon-box-sm bg-primary text-white rounded"><i class="fas fa-user-plus"></i></div>
           <h6 class="card-title-custom mb-0">Formulir Registrasi Akun PANDU K3</h6>
        </div>
      </div>
      <div class="pandu-card-body p-4 p-md-5">
        <form action="{{ route('admin.users.store') }}" method="POST" id="userForm">
          @csrf
          
          <div class="row g-4">
             <!-- Section 1: Data Pribadi -->
             <div class="col-12 border-bottom pb-2">
                <h5 class="section-title mb-0" style="font-size: 1rem;"><i class="fas fa-id-card me-2 text-primary"></i> I. Informasi Personal</h5>
             </div>
             
             <div class="col-md-6">
                <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                <div class="input-group">
                   <span class="input-group-text bg-light border-end-0"><i class="fas fa-user text-secondary"></i></span>
                   <input type="text" name="name" class="form-control border-start-0 @error('name') is-invalid @enderror" placeholder="Nama sesuai ID Card" value="{{ old('name') }}" required>
                   @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
             </div>
             
             <div class="col-md-6">
                <label for="employee_id" class="form-label">NIK / Nomor Induk Karyawan</label>
                <div class="input-group">
                   <span class="input-group-text bg-light border-end-0"><i class="fas fa-hashtag text-secondary"></i></span>
                   <input type="text" name="employee_id" class="form-control border-start-0 @error('employee_id') is-invalid @enderror" placeholder="Contoh: 20240012" value="{{ old('employee_id') }}">
                   @error('employee_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
             </div>

             <div class="col-md-6">
                <label for="email" class="form-label">Alamat Email <span class="text-danger">*</span></label>
                <div class="input-group">
                   <span class="input-group-text bg-light border-end-0"><i class="fas fa-envelope text-secondary"></i></span>
                   <input type="email" name="email" class="form-control border-start-0 @error('email') is-invalid @enderror" placeholder="user@company.com" value="{{ old('email') }}" required>
                   @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
             </div>

             <div class="col-md-6">
                <label for="phone" class="form-label">Nomor WhatsApp / HP</label>
                <div class="input-group">
                   <span class="input-group-text bg-light border-end-0"><i class="fas fa-phone text-secondary"></i></span>
                   <input type="text" name="phone" class="form-control border-start-0 @error('phone') is-invalid @enderror" placeholder="Contoh: 0812..." value="{{ old('phone') }}">
                   @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
             </div>

             <!-- Section 2: Akses & Unit Kerja -->
             <div class="col-12 border-bottom pb-2 mt-5">
                <h5 class="section-title mb-0" style="font-size: 1rem;"><i class="fas fa-shield-halved me-2 text-primary"></i> II. Pengaturan Akses & Organisasi</h5>
             </div>

             <div class="col-md-6">
              <label for="role" class="form-label">Peran Sistem (Role) <span class="text-danger">*</span></label>
              <select name="role" id="role" class="form-select @error('role') is-invalid @enderror" required>
                <option value="" selected disabled>Pilih Hak Akses...</option>
                <option value="worker" {{ old('role') == 'worker' ? 'selected' : '' }}>Pekerja / Staf Lapangan</option>
                <option value="supervisor" {{ old('role') == 'supervisor' ? 'selected' : '' }}>Supervisor / Pengawas</option>
                <option value="hse_manager" {{ old('role') == 'hse_manager' ? 'selected' : '' }}>HSE Manager</option>
                <option value="super_admin" {{ old('role') == 'super_admin' ? 'selected' : '' }}>Super Admin / Direktur</option>
              </select>
              @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
              <label for="company_id" class="form-label">Perusahaan / Site <span class="text-danger">*</span></label>
              <select name="company_id" class="form-select @error('company_id') is-invalid @enderror" required>
                <option value="" selected disabled>Pilih Perusahaan...</option>
                @foreach($companies as $c)
                  <option value="{{ $c->id }}" {{ old('company_id') == $c->id ? 'selected' : '' }}>{{ $c->name }} ({{ $c->code }})</option>
                @endforeach
              </select>
              @error('company_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

             <div class="col-md-6">
                <label for="division_id" class="form-label">Divisi Utama</label>
                <select name="division_id" class="form-select @error('division_id') is-invalid @enderror">
                  <option value="">Pilih Divisi...</option>
                  @foreach($divisions as $d)
                    <option value="{{ $d->id }}" {{ old('division_id') == $d->id ? 'selected' : '' }}>{{ $d->name }}</option>
                  @endforeach
                </select>
                @error('division_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
             </div>

             <div class="col-md-6">
                <label for="work_area_id" class="form-label">Area Kerja Default</label>
                <select name="work_area_id" class="form-select @error('work_area_id') is-invalid @enderror">
                   <option value="">Pilih Area...</option>
                   @foreach($workAreas as $wa)
                     <option value="{{ $wa->id }}" {{ old('work_area_id') == $wa->id ? 'selected' : '' }}>{{ $wa->name }}</option>
                   @endforeach
                </select>
                @error('work_area_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
             </div>

             <!-- Section 3: Keamanan -->
             <div class="col-12 border-bottom pb-2 mt-5">
                <h5 class="section-title mb-0" style="font-size: 1rem;"><i class="fas fa-lock me-2 text-primary"></i> III. Kredensial Keamanan</h5>
             </div>

             <div class="col-md-6">
                <label for="password" class="form-label">Password Sementara <span class="text-danger">*</span></label>
                <div class="input-group">
                   <span class="input-group-text bg-light border-end-0"><i class="fas fa-key text-secondary"></i></span>
                   <input type="password" name="password" class="form-control border-start-0 @error('password') is-invalid @enderror" placeholder="Minimal 8 karakter" required>
                   <button class="btn btn-outline-secondary border-start-0" type="button" onclick="togglePass()"><i class="fas fa-eye"></i></button>
                   @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="form-text smaller">Berikan password ini kepada pengguna untuk login pertama kali.</div>
             </div>
          </div>

          <div class="d-flex gap-3 justify-content-end mt-5 pt-4 border-top">
            <a href="{{ route('admin.users.index') }}" class="btn btn-pandu-ghost px-4">Batal</a>
            <button type="submit" class="btn btn-pandu-primary px-5 fw-bold">
               DAFTARKAN PENGGUNA <i class="fas fa-save ms-2"></i>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
function togglePass() {
   const input = document.querySelector('input[name="password"]');
   const icon = document.querySelector('button[onclick="togglePass()"] i');
   if (input.type === "password") {
      input.type = "text";
      icon.className = "fas fa-eye-slash";
   } else {
      input.type = "password";
      icon.className = "fas fa-eye";
   }
}
</script>
@endpush
