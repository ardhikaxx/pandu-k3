@extends('layouts.app')

@section('title', 'Laporkan Insiden')
@section('page-title', 'Formulir Laporan Insiden')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('worker.dashboard') }}">Beranda</a></li>
  <li class="breadcrumb-item"><a href="{{ route('worker.incident.index') }}">Laporan Insiden</a></li>
  <li class="breadcrumb-item active">Lapor Baru</li>
@endsection

@section('content')
<div class="row justify-content-center">
  <div class="col-lg-10">
    
    <!-- Step Indicator (Visual Only) -->
    <div class="step-indicator justify-content-center mb-5">
      <div class="step-item active">
        <div class="step-circle">1</div>
        <span class="step-label">Data Insiden</span>
      </div>
      <div class="step-line"></div>
      <div class="step-item">
        <div class="step-circle">2</div>
        <span class="step-label">Analisis & Bukti</span>
      </div>
    </div>

    <form action="{{ route('worker.incident.store') }}" method="POST" enctype="multipart/form-data">
      @csrf

      <div class="row g-4">
        <div class="col-md-7">
          <div class="pandu-card">
            <div class="pandu-card-header bg-light">
              <h6 class="card-title-custom mb-0">I. Detail Kejadian</h6>
            </div>
            <div class="pandu-card-body">
              <div class="mb-3">
                <label for="title" class="form-label">Judul Insiden</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" placeholder="Contoh: Terpeleset di Area Gudang" required>
                @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>

              <div class="row mb-3">
                <div class="col-md-6">
                  <label for="incident_date" class="form-label">Tanggal Kejadian</label>
                  <input type="date" class="form-control @error('incident_date') is-invalid @enderror" id="incident_date" name="incident_date" value="{{ old('incident_date', date('Y-m-d')) }}" required>
                  @error('incident_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                  <label for="incident_time" class="form-label">Waktu Kejadian</label>
                  <input type="time" class="form-control @error('incident_time') is-invalid @enderror" id="incident_time" name="incident_time" value="{{ old('incident_time', date('H:i')) }}" required>
                  @error('incident_time') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-md-6">
                  <label for="work_area_id" class="form-label">Area Kerja</label>
                  <select class="form-control @error('work_area_id') is-invalid @enderror" id="work_area_id" name="work_area_id" required>
                    <option value="" selected disabled>Pilih Area...</option>
                    @foreach($workAreas as $area)
                      <option value="{{ $area->id }}" {{ old('work_area_id') == $area->id ? 'selected' : '' }}>{{ $area->name }}</option>
                    @endforeach
                  </select>
                  @error('work_area_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                  <label for="incident_type" class="form-label">Tipe Insiden</label>
                  <select class="form-control @error('incident_type') is-invalid @enderror" id="incident_type" name="incident_type" required>
                    <option value="near_miss" {{ old('incident_type') == 'near_miss' ? 'selected' : '' }}>Hampir Celaka (Near Miss)</option>
                    <option value="first_aid" {{ old('incident_type') == 'first_aid' ? 'selected' : '' }}>P3K (First Aid)</option>
                  </select>
                  <div class="form-text">Pekerja hanya dapat melaporkan Near Miss & First Aid.</div>
                </div>
              </div>

              <div class="mb-0">
                <label for="description" class="form-label">Kronologi Singkat</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="5" placeholder="Jelaskan secara urut bagaimana kejadian tersebut terjadi..." required>{{ old('description') }}</textarea>
                @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-5">
          <div class="pandu-card mb-4">
            <div class="pandu-card-header bg-light">
              <h6 class="card-title-custom mb-0">II. Informasi Korban & Tingkat Bahaya</h6>
            </div>
            <div class="pandu-card-body">
               <div class="mb-3">
                <label for="victim_name" class="form-label">Nama Korban (Opsional)</label>
                <input type="text" class="form-control" id="victim_name" name="victim_name" value="{{ old('victim_name') }}" placeholder="Nama karyawan yang terlibat">
              </div>
              <div class="mb-3">
                <label for="severity_classification" class="form-label">Klasifikasi Keparahan</label>
                <select class="form-control @error('severity_classification') is-invalid @enderror" id="severity_classification" name="severity_classification" required>
                  <option value="minor" {{ old('severity_classification') == 'minor' ? 'selected' : '' }}>Ringan (Minor)</option>
                  <option value="moderate" {{ old('severity_classification') == 'moderate' ? 'selected' : '' }}>Sedang (Moderate)</option>
                </select>
              </div>
              <div class="mb-0">
                <label class="form-label">Foto Bukti / Lokasi Kejadian</label>
                <div class="photo-upload-area py-4" id="photoUpload">
                  <div class="photo-upload-icon" style="width:40px;height:40px;font-size:1rem"><i class="fas fa-camera"></i></div>
                  <div class="photo-upload-text small">Klik untuk ambil foto</div>
                  <input type="file" name="photos[]" accept="image/*" multiple class="d-none" id="photoInput" required>
                </div>
                <div class="photo-preview-grid mt-2" id="photoPreview"></div>
              </div>
            </div>
          </div>

          <div class="alert alert-warning border-0 small shadow-sm">
            <h6 class="fw-bold"><i class="fas fa-triangle-exclamation me-2"></i> PENTING</h6>
            Laporan ini akan segera diteruskan ke HSE Manager untuk proses investigasi lebih lanjut. Pastikan data yang Anda masukkan benar.
          </div>

          <div class="d-grid gap-2">
            <button type="submit" class="btn btn-pandu-danger py-3 fw-bold">
              KIRIM LAPORAN INSIDEN <i class="fas fa-paper-plane ms-2"></i>
            </button>
            <a href="{{ route('worker.incident.index') }}" class="btn btn-light">Batal</a>
          </div>
        </div>
      </div>
    </form>

  </div>
</div>
@endsection

@push('scripts')
<script>
const uploadArea = document.getElementById('photoUpload');
const fileInput = document.getElementById('photoInput');
const previewGrid = document.getElementById('photoPreview');

uploadArea.addEventListener('click', () => fileInput.click());

fileInput.addEventListener('change', function() {
  previewGrid.innerHTML = '';
  const files = Array.from(this.files);
  files.forEach((file) => {
    const reader = new FileReader();
    reader.onload = (e) => {
      const div = document.createElement('div');
      div.className = 'photo-preview-item';
      div.style.width = '80px';
      div.innerHTML = `<img src="${e.target.result}">`;
      previewGrid.appendChild(div);
    };
    reader.readAsDataURL(file);
  });
});
</script>
@endpush

@push('styles')
<style>
.step-indicator { display: flex; align-items: center; margin-bottom: 32px; }
.step-item { display: flex; flex-direction: column; align-items: center; gap: 6px; flex-shrink: 0; }
.step-circle { width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.875rem; font-weight: 700; border: 2px solid var(--gray-300); color: var(--gray-500); background: #FFF; transition: var(--transition-base); }
.step-item.active .step-circle { background: var(--pandu-blue); border-color: var(--pandu-blue); color: #FFF; box-shadow: 0 4px 12px rgba(21,101,192,0.35); }
.step-label { font-size: 0.6875rem; font-weight: 600; color: var(--gray-500); white-space: nowrap; }
.step-item.active .step-label { color: var(--pandu-blue); }
.step-line { flex: 1; max-width: 100px; height: 2px; background: var(--gray-200); margin: 0 8px; margin-bottom: 22px; }
.photo-upload-area { border: 2px dashed var(--gray-300); border-radius: var(--radius-md); text-align: center; cursor: pointer; background: var(--gray-50); }
.photo-preview-grid { display: flex; flex-wrap: wrap; gap: 8px; }
.photo-preview-item { position: relative; border-radius: 4px; overflow: hidden; aspect-ratio: 1; background: var(--gray-100); border: 1px solid var(--gray-200); }
.photo-preview-item img { width: 100%; height: 100%; object-fit: cover; }
</style>
@endpush
