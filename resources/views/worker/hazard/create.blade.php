@extends('layouts.app')

@section('title', 'Buat Laporan Bahaya')
@section('page-title', 'Buat Laporan Bahaya')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('worker.dashboard') }}">Beranda</a></li>
  <li class="breadcrumb-item"><a href="{{ route('worker.hazard.index') }}">Laporan Bahaya</a></li>
  <li class="breadcrumb-item active">Buat Laporan</li>
@endsection

@section('content')
<div class="row justify-content-center">
  <div class="col-lg-8">
    <div class="pandu-card">
      <div class="pandu-card-header">
        <h5 class="card-title-custom mb-0">Formulir Laporan Temuan Bahaya</h5>
      </div>
      <div class="pandu-card-body">
        <form action="{{ route('worker.hazard.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
          
          <div class="mb-4">
            <label class="form-label">Upload Foto Temuan (Min 1, Maks 5)</label>
            <div class="photo-upload-area" id="photoUpload">
              <div class="photo-upload-icon"><i class="fas fa-camera"></i></div>
              <div class="photo-upload-text">
                <span class="fw-semibold">Klik untuk upload</span> atau drag & drop foto
              </div>
              <div class="photo-upload-hint">JPG, PNG, WEBP · Maks 5MB per foto</div>
              <input type="file" name="photos[]" accept="image/*" multiple class="d-none" id="photoInput" required>
            </div>
            <div class="photo-preview-grid mt-3" id="photoPreview"></div>
            @error('photos') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
            @error('photos.*') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
          </div>

          <div class="mb-3">
            <label for="title" class="form-label">Judul Temuan</label>
            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" placeholder="Contoh: Kabel Terkelupas di Area Basah" required>
            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
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
              <label for="location_detail" class="form-label">Detail Lokasi</label>
              <input type="text" class="form-control @error('location_detail') is-invalid @enderror" id="location_detail" name="location_detail" value="{{ old('location_detail') }}" placeholder="Contoh: Dekat Mesin CNC-01" required>
              @error('location_detail') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-md-4">
              <label for="hazard_type" class="form-label">Tipe Bahaya</label>
              <select class="form-control @error('hazard_type') is-invalid @enderror" id="hazard_type" name="hazard_type" required>
                <option value="unsafe_condition" {{ old('hazard_type') == 'unsafe_condition' ? 'selected' : '' }}>Kondisi Tidak Aman</option>
                <option value="unsafe_act" {{ old('hazard_type') == 'unsafe_act' ? 'selected' : '' }}>Tindakan Tidak Aman</option>
                <option value="near_miss" {{ old('hazard_type') == 'near_miss' ? 'selected' : '' }}>Hampir Celaka (Near Miss)</option>
              </select>
              @error('hazard_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-4">
              <label for="category" class="form-label">Kategori</label>
              <select class="form-control @error('category') is-invalid @enderror" id="category" name="category" required>
                <option value="electrical" {{ old('category') == 'electrical' ? 'selected' : '' }}>Listrik</option>
                <option value="mechanical" {{ old('category') == 'mechanical' ? 'selected' : '' }}>Mekanikal</option>
                <option value="chemical" {{ old('category') == 'chemical' ? 'selected' : '' }}>Kimia</option>
                <option value="fire" {{ old('category') == 'fire' ? 'selected' : '' }}>Kebakaran</option>
                <option value="ergonomic" {{ old('category') == 'ergonomic' ? 'selected' : '' }}>Ergonomi</option>
                <option value="biological" {{ old('category') == 'biological' ? 'selected' : '' }}>Biologi</option>
                <option value="other" {{ old('category') == 'other' ? 'selected' : '' }}>Lainnya</option>
              </select>
              @error('category') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-4">
              <label for="severity" class="form-label">Tingkat Risiko</label>
              <select class="form-control @error('severity') is-invalid @enderror" id="severity" name="severity" required>
                <option value="low" {{ old('severity') == 'low' ? 'selected' : '' }}>Rendah</option>
                <option value="medium" {{ old('severity') == 'medium' ? 'selected' : 'selected' }}>Sedang</option>
                <option value="high" {{ old('severity') == 'high' ? 'selected' : '' }}>Tinggi</option>
                <option value="critical" {{ old('severity') == 'critical' ? 'selected' : '' }}>Kritis</option>
              </select>
              @error('severity') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
          </div>

          <div class="mb-4">
            <label for="description" class="form-label">Deskripsi Bahaya</label>
            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4" placeholder="Jelaskan secara detail bahaya yang ditemukan..." required>{{ old('description') }}</textarea>
            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="d-flex gap-2 justify-content-end">
            <a href="{{ route('worker.hazard.index') }}" class="btn btn-light">Batal</a>
            <button type="submit" class="btn btn-pandu-primary">Kirim Laporan <i class="fas fa-paper-plane ms-2"></i></button>
          </div>
        </form>
      </div>
    </div>
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
  
  if (files.length > 5) {
    Swal.fire({ icon:'warning', title:'Batas Maksimum', text:'Anda hanya dapat mengupload maksimal 5 foto.' });
    this.value = '';
    return;
  }

  files.forEach((file, index) => {
    const reader = new FileReader();
    reader.onload = (e) => {
      const div = document.createElement('div');
      div.className = 'photo-preview-item';
      div.innerHTML = `
        <img src="${e.target.result}">
        <div class="photo-preview-remove" onclick="removePhoto(${index})"><i class="fas fa-times"></i></div>
      `;
      previewGrid.appendChild(div);
    };
    reader.readAsDataURL(file);
  });
});

function removePhoto(index) {
  // Logic to remove specific file from input is tricky with standard input, 
  // usually requires a DataTransfer object or just resetting the whole thing.
  // For simplicity, we just clear for now or the user re-selects.
  fileInput.value = '';
  previewGrid.innerHTML = '';
}
</script>
@endpush

@push('styles')
<style>
.photo-upload-area {
  border: 2px dashed var(--gray-300);
  border-radius: var(--radius-lg);
  padding: 32px 24px;
  text-align: center; cursor: pointer;
  background: var(--gray-50);
  transition: var(--transition-fast);
}
.photo-upload-area:hover {
  border-color: var(--pandu-blue);
  background: rgba(21, 101, 192, 0.04);
}
.photo-upload-icon {
  width: 52px; height: 52px;
  background: rgba(21, 101, 192, 0.1);
  border-radius: 50%; margin: 0 auto 12px;
  display: flex; align-items: center; justify-content: center;
  color: var(--pandu-blue); font-size: 1.25rem;
}
.photo-preview-grid {
  display: grid; grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
  gap: 10px;
}
.photo-preview-item {
  position: relative; border-radius: var(--radius-md); overflow: hidden;
  aspect-ratio: 1; background: var(--gray-100);
}
.photo-preview-item img {
  width: 100%; height: 100%; object-fit: cover;
}
.photo-preview-remove {
  position: absolute; top: 4px; right: 4px;
  width: 22px; height: 22px; border-radius: 50%;
  background: rgba(0,0,0,0.6); color: #FFF;
  border: none; cursor: pointer; font-size: 0.625rem;
  display: flex; align-items: center; justify-content: center;
}
</style>
@endpush
