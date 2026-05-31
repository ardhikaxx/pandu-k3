@extends('layouts.app')

@section('title', 'Pelaksanaan Inspeksi')
@section('page-title', 'Checklist Inspeksi')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('supervisor.dashboard') }}">Beranda</a></li>
  <li class="breadcrumb-item"><a href="{{ route('supervisor.inspection.index') }}">Inspeksi</a></li>
  <li class="breadcrumb-item active">{{ $inspection->inspection_number }}</li>
@endsection

@section('content')
<div class="row">
  <div class="col-lg-12">
    <div class="pandu-card mb-4">
      <div class="pandu-card-header bg-dark text-white">
        <h5 class="mb-0 fw-bold">{{ $inspection->title }}</h5>
        <p class="mb-0 small opacity-75">{{ $inspection->inspection_number }} · Area: {{ $inspection->workArea->name }}</p>
      </div>
      <div class="pandu-card-body">
        <form action="{{ route('supervisor.inspection.complete', $inspection->id) }}" method="POST" enctype="multipart/form-data">
          @csrf
          
          <div class="table-responsive">
            <table class="table table-hover align-middle">
              <thead class="bg-light small fw-bold">
                <tr>
                  <th style="width: 50px;">No</th>
                  <th>Deskripsi Item / Standar</th>
                  <th style="width: 250px;">Status Temuan</th>
                  <th>Catatan & Foto</th>
                </tr>
              </thead>
              <tbody>
                @forelse($inspection->checklistItems as $index => $item)
                <tr>
                  <td>{{ $index + 1 }}</td>
                  <td>
                    <p class="fw-bold mb-0 small">{{ $item->item_description }}</p>
                    @if($item->standard_reference)
                      <span class="badge bg-secondary smaller">Ref: {{ $item->standard_reference }}</span>
                    @endif
                  </td>
                  <td>
                    <div class="btn-group w-100" role="group">
                      <input type="radio" class="btn-check" name="items[{{$item->id}}][status]" id="ok{{$item->id}}" value="ok" {{ $item->status == 'ok' ? 'checked' : '' }} required>
                      <label class="btn btn-outline-success btn-sm" for="ok{{$item->id}}">OK</label>

                      <input type="radio" class="btn-check" name="items[{{$item->id}}][status]" id="notok{{$item->id}}" value="not_ok" {{ $item->status == 'not_ok' ? 'checked' : '' }} required>
                      <label class="btn btn-outline-danger btn-sm" for="notok{{$item->id}}">NOT OK</label>

                      <input type="radio" class="btn-check" name="items[{{$item->id}}][status]" id="na{{$item->id}}" value="na" {{ $item->status == 'na' ? 'checked' : '' }} required>
                      <label class="btn btn-outline-secondary btn-sm" for="na{{$item->id}}">N/A</label>
                    </div>
                  </td>
                  <td>
                    <div class="row g-2">
                       <div class="col-8">
                         <input type="text" name="items[{{$item->id}}][notes]" class="form-control form-control-sm" placeholder="Catatan..." value="{{ $item->notes }}">
                       </div>
                       <div class="col-4">
                         <input type="file" name="items[{{$item->id}}][photo]" class="form-control form-control-sm" accept="image/*">
                       </div>
                    </div>
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="4" class="text-center py-4">Tidak ada item checklist untuk inspeksi ini.</td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>

          <div class="mt-4">
             <label for="overall_notes" class="form-label fw-bold">Kesimpulan / Catatan Umum</label>
             <textarea name="overall_notes" id="overall_notes" rows="3" class="form-control" placeholder="Tuliskan ringkasan hasil inspeksi...">{{ $inspection->overall_notes }}</textarea>
          </div>

          @if($inspection->status !== 'completed')
          <div class="d-flex justify-content-end gap-2 mt-4">
            <a href="{{ route('supervisor.inspection.index') }}" class="btn btn-light">Simpan Draft</a>
            <button type="submit" class="btn btn-pandu-primary px-5 fw-bold">
              SELESAIKAN INSPEKSI <i class="fas fa-check-circle ms-2"></i>
            </button>
          </div>
          @endif
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@push('styles')
<style>
.smaller { font-size: 0.7rem; }
.btn-group .btn { font-size: 0.75rem; font-weight: 700; }
</style>
@endpush
