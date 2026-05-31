@extends('layouts.app')

@section('title', 'Rencana Audit')
@section('page-title', 'Rencanakan Audit Baru')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('hse.dashboard') }}">Beranda</a></li>
  <li class="breadcrumb-item"><a href="{{ route('hse.audit.index') }}">Audit</a></li>
  <li class="breadcrumb-item active">Rencana Baru</li>
@endsection

@section('content')
<div class="row justify-content-center">
  <div class="col-lg-10">
    <div class="pandu-card">
      <div class="pandu-card-header bg-light">
        <h6 class="card-title-custom mb-0">Formulir Rencana Audit Internal/Eksternal</h6>
      </div>
      <div class="pandu-card-body">
        <form action="{{ route('hse.audit.store') }}" method="POST">
          @csrf
          
          <div class="mb-3">
            <label for="title" class="form-label">Judul Audit</label>
            <input type="text" name="title" class="form-control" placeholder="Contoh: Audit Kepatuhan SMK3 Tahunan 2025" required>
          </div>

          <div class="row mb-3">
            <div class="col-md-4">
              <label for="audit_type" class="form-label">Tipe Audit</label>
              <select name="audit_type" class="form-control" required>
                <option value="internal">Internal Audit</option>
                <option value="external">External Audit</option>
                <option value="surveillance">Surveillance</option>
                <option value="certification">Certification</option>
              </select>
            </div>
            <div class="col-md-4">
              <label for="division_id" class="form-label">Divisi Objek Audit</label>
              <select name="division_id" class="form-control" required>
                @foreach($divisions as $div)
                  <option value="{{ $div->id }}">{{ $div->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-4">
              <label for="work_area_id" class="form-label">Area Kerja Spesifik</label>
              <select name="work_area_id" class="form-control" required>
                @foreach($workAreas as $area)
                  <option value="{{ $area->id }}">{{ $area->name }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-md-6">
              <label for="scheduled_start" class="form-label">Jadwal Mulai</label>
              <input type="datetime-local" name="scheduled_start" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label for="scheduled_end" class="form-label">Jadwal Selesai</label>
              <input type="datetime-local" name="scheduled_end" class="form-control" required>
            </div>
          </div>

          <div class="mb-3">
             <label for="lead_auditor_id" class="form-label">Lead Auditor (HSE)</label>
             <select name="lead_auditor_id" class="form-control" required>
                <option value="" selected disabled>Pilih Lead Auditor...</option>
                @foreach($auditors as $auditor)
                   <option value="{{ $auditor->id }}">{{ $auditor->name }}</option>
                @endforeach
             </select>
          </div>

          <div class="row mb-3">
             <div class="col-md-6">
                <label for="scope" class="form-label">Ruang Lingkup (Scope)</label>
                <textarea name="scope" rows="3" class="form-control" placeholder="Jelaskan apa saja yang akan diaudit..." required></textarea>
             </div>
             <div class="col-md-6">
                <label for="criteria" class="form-label">Kriteria Audit (Standard)</label>
                <textarea name="criteria" rows="3" class="form-control" placeholder="Contoh: Klausul 5 ISO 45001..." required></textarea>
             </div>
          </div>

          <div class="d-flex gap-2 justify-content-end mt-4">
            <a href="{{ route('hse.audit.index') }}" class="btn btn-light">Batal</a>
            <button type="submit" class="btn btn-pandu-primary px-5">SIMPAN RENCANA AUDIT <i class="fas fa-save ms-2"></i></button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
