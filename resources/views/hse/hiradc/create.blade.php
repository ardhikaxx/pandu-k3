@extends('layouts.app')

@section('title', 'Buat HIRADC')
@section('page-title', 'Penyusunan HIRADC')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('hse.dashboard') }}">Beranda</a></li>
  <li class="breadcrumb-item"><a href="{{ route('hse.hiradc.index') }}">HIRADC</a></li>
  <li class="breadcrumb-item active">Buat Baru</li>
@endsection

@section('content')
<form action="{{ route('hse.hiradc.store') }}" method="POST">
  @csrf
  <div class="row g-4">
    <div class="col-lg-12">
      <div class="pandu-card">
        <div class="pandu-card-header bg-light">
          <h6 class="card-title-custom mb-0">Informasi Dokumen</h6>
        </div>
        <div class="pandu-card-body">
          <div class="row g-3">
            <div class="col-md-4">
              <label for="title" class="form-label">Judul HIRADC</label>
              <input type="text" name="title" class="form-control" placeholder="Contoh: HIRADC Operasional Mesin Bubut" required>
            </div>
            <div class="col-md-2">
              <label for="division_id" class="form-label">Divisi</label>
              <select name="division_id" class="form-control" required>
                <option value="" selected disabled>Pilih Divisi...</option>
                @foreach($divisions as $div)
                  <option value="{{ $div->id }}">{{ $div->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-2">
              <label for="work_area_id" class="form-label">Area Kerja</label>
              <select name="work_area_id" class="form-control" required>
                <option value="" selected disabled>Pilih Area...</option>
                @foreach($workAreas as $area)
                  <option value="{{ $area->id }}">{{ $area->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-2">
              <label for="valid_from" class="form-label">Masa Berlaku (Mulai)</label>
              <input type="date" name="valid_from" class="form-control" value="{{ date('Y-m-d') }}" required>
            </div>
            <div class="col-md-2">
              <label for="valid_until" class="form-label">Masa Berlaku (Selesai)</label>
              <input type="date" name="valid_until" class="form-control" value="{{ date('Y-m-d', strtotime('+1 year')) }}" required>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-12">
      <div class="pandu-card">
        <div class="pandu-card-header d-flex justify-content-between align-items-center">
          <h6 class="card-title-custom mb-0">Identifikasi Bahaya & Penilaian Risiko</h6>
          <button type="button" class="btn btn-sm btn-outline-primary" id="addItem"><i class="fas fa-plus me-1"></i> Tambah Item</button>
        </div>
        <div class="pandu-card-body p-0">
          <div class="table-responsive">
            <table class="table table-bordered mb-0" id="itemsTable" style="min-width: 1200px;">
              <thead class="bg-light small fw-bold text-center align-middle">
                <tr>
                  <th rowspan="2" style="width: 150px;">Kegiatan</th>
                  <th rowspan="2" style="width: 200px;">Bahaya & Risiko</th>
                  <th colspan="3" class="bg-warning-soft">Risiko Awal</th>
                  <th rowspan="2" style="width: 250px;">Langkah Kontrol</th>
                  <th colspan="3" class="bg-success-soft">Risiko Sisa</th>
                  <th rowspan="2">Aksi</th>
                </tr>
                <tr>
                  <th style="width: 70px;">S</th>
                  <th style="width: 70px;">P</th>
                  <th style="width: 80px;">Skor</th>
                  <th style="width: 70px;">S</th>
                  <th style="width: 70px;">P</th>
                  <th style="width: 80px;">Skor</th>
                </tr>
              </thead>
              <tbody id="itemsContainer">
                <!-- Initial 3 items as per rules -->
                @for($i=0; $i<3; $i++)
                <tr class="item-row">
                  <td>
                    <input type="text" name="items[{{$i}}][activity]" class="form-control form-control-sm" placeholder="Contoh: Pengelasan" required>
                  </td>
                  <td>
                    <textarea name="items[{{$i}}][hazard_description]" class="form-control form-control-sm mb-1" placeholder="Bahaya" rows="2" required></textarea>
                    <select name="items[{{$i}}][hazard_type]" class="form-control form-control-sm mb-1" required>
                      <option value="physical">Fisik</option>
                      <option value="chemical">Kimia</option>
                      <option value="biological">Biologi</option>
                      <option value="ergonomic">Ergonomi</option>
                      <option value="mechanical">Mekanikal</option>
                      <option value="electrical">Listrik</option>
                    </select>
                    <textarea name="items[{{$i}}][potential_incident]" class="form-control form-control-sm" placeholder="Potensi Insiden" rows="2" required></textarea>
                  </td>
                  <td>
                    <input type="number" name="items[{{$i}}][severity_before]" class="form-control form-control-sm s-before" min="1" max="5" required>
                  </td>
                  <td>
                    <input type="number" name="items[{{$i}}][probability_before]" class="form-control form-control-sm p-before" min="1" max="5" required>
                  </td>
                  <td class="text-center align-middle fw-bold score-before">0</td>
                  <td>
                    <select name="items[{{$i}}][control_hierarchy]" class="form-control form-control-sm mb-1" required>
                      <option value="elimination">Eliminasi</option>
                      <option value="substitution">Substitusi</option>
                      <option value="engineering">Rekayasa Teknik</option>
                      <option value="administrative">Administratif</option>
                      <option value="ppe">APD</option>
                    </select>
                    <textarea name="items[{{$i}}][control_measures]" class="form-control form-control-sm mb-1" placeholder="Tindakan Pengendalian" rows="2" required></textarea>
                    <div class="row g-1">
                       <div class="col-6"><input type="text" name="items[{{$i}}][pic_control]" class="form-control form-control-sm" placeholder="PIC" required></div>
                       <div class="col-6"><input type="date" name="items[{{$i}}][target_date]" class="form-control form-control-sm" required></div>
                    </div>
                  </td>
                  <td>
                    <input type="number" name="items[{{$i}}][severity_after]" class="form-control form-control-sm s-after" min="1" max="5" required>
                  </td>
                  <td>
                    <input type="number" name="items[{{$i}}][probability_after]" class="form-control form-control-sm p-after" min="1" max="5" required>
                  </td>
                  <td class="text-center align-middle fw-bold score-after">0</td>
                  <td class="text-center align-middle">
                    <button type="button" class="btn btn-sm btn-link text-danger remove-item"><i class="fas fa-trash"></i></button>
                  </td>
                </tr>
                @endfor
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-12">
      <div class="d-flex justify-content-end gap-2">
        <a href="{{ route('hse.hiradc.index') }}" class="btn btn-light">Batal</a>
        <button type="submit" class="btn btn-pandu-primary px-5 py-2">SIMPAN SEBAGAI DRAFT <i class="fas fa-save ms-2"></i></button>
      </div>
    </div>
  </div>
</form>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('itemsContainer');
    const addButton = document.getElementById('addItem');
    let rowCount = 3;

    addButton.addEventListener('click', () => {
        const tr = document.createElement('tr');
        tr.className = 'item-row';
        tr.innerHTML = `
            <td><input type="text" name="items[${rowCount}][activity]" class="form-control form-control-sm" required></td>
            <td>
                <textarea name="items[${rowCount}][hazard_description]" class="form-control form-control-sm mb-1" rows="2" required></textarea>
                <select name="items[${rowCount}][hazard_type]" class="form-control form-control-sm mb-1" required>
                    <option value="physical">Fisik</option><option value="chemical">Kimia</option><option value="biological">Biologi</option>
                    <option value="ergonomic">Ergonomi</option><option value="mechanical">Mekanikal</option><option value="electrical">Listrik</option>
                </select>
                <textarea name="items[${rowCount}][potential_incident]" class="form-control form-control-sm" rows="2" required></textarea>
            </td>
            <td><input type="number" name="items[${rowCount}][severity_before]" class="form-control form-control-sm s-before" min="1" max="5" required></td>
            <td><input type="number" name="items[${rowCount}][probability_before]" class="form-control form-control-sm p-before" min="1" max="5" required></td>
            <td class="text-center align-middle fw-bold score-before">0</td>
            <td>
                <select name="items[${rowCount}][control_hierarchy]" class="form-control form-control-sm mb-1" required>
                    <option value="elimination">Eliminasi</option><option value="substitution">Substitusi</option><option value="engineering">Rekayasa Teknik</option>
                    <option value="administrative">Administratif</option><option value="ppe">APD</option>
                </select>
                <textarea name="items[${rowCount}][control_measures]" class="form-control form-control-sm mb-1" rows="2" required></textarea>
                <div class="row g-1">
                    <div class="col-6"><input type="text" name="items[${rowCount}][pic_control]" class="form-control form-control-sm" required></div>
                    <div class="col-6"><input type="date" name="items[${rowCount}][target_date]" class="form-control form-control-sm" required></div>
                </div>
            </td>
            <td><input type="number" name="items[${rowCount}][severity_after]" class="form-control form-control-sm s-after" min="1" max="5" required></td>
            <td><input type="number" name="items[${rowCount}][probability_after]" class="form-control form-control-sm p-after" min="1" max="5" required></td>
            <td class="text-center align-middle fw-bold score-after">0</td>
            <td class="text-center align-middle"><button type="button" class="btn btn-sm btn-link text-danger remove-item"><i class="fas fa-trash"></i></button></td>
        `;
        container.appendChild(tr);
        rowCount++;
    });

    container.addEventListener('click', (e) => {
        if (e.target.closest('.remove-item')) {
            if (container.children.length > 1) {
                e.target.closest('tr').remove();
            } else {
                Swal.fire({ icon:'warning', title:'Oops!', text:'Wajib memiliki minimal 1 item bahaya.' });
            }
        }
    });

    container.addEventListener('input', (e) => {
        if (e.target.matches('.s-before, .p-before, .s-after, .p-after')) {
            const row = e.target.closest('tr');
            const sB = row.querySelector('.s-before').value || 0;
            const pB = row.querySelector('.p-before').value || 0;
            const sA = row.querySelector('.s-after').value || 0;
            const pA = row.querySelector('.p-after').value || 0;

            const scoreB = sB * pB;
            const scoreA = sA * pA;

            const bDisplay = row.querySelector('.score-before');
            const aDisplay = row.querySelector('.score-after');

            bDisplay.textContent = scoreB;
            aDisplay.textContent = scoreA;

            // Color coding based on risk matrix
            bDisplay.className = 'text-center align-middle fw-bold score-before ' + getRiskColorClass(scoreB);
            aDisplay.className = 'text-center align-middle fw-bold score-after ' + getRiskColorClass(scoreA);
        }
    });

    function getRiskColorClass(score) {
        if (score <= 4) return 'text-success';
        if (score <= 9) return 'text-info';
        if (score <= 14) return 'text-warning';
        if (score <= 19) return 'text-orange';
        return 'text-danger';
    }
});
</script>
@endpush

@push('styles')
<style>
.bg-warning-soft { background: rgba(243, 156, 18, 0.1); }
.bg-success-soft { background: rgba(39, 174, 96, 0.1); }
.text-orange { color: #E67E22; }
</style>
@endpush
