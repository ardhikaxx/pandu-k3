@extends('layouts.app')

@section('title', 'Audit K3')
@section('page-title', 'Manajemen Audit K3')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('hse.dashboard') }}">Beranda</a></li>
  <li class="breadcrumb-item active">Audit</li>
@endsection

@section('page-actions')
  <a href="{{ route('hse.audit.create') }}" class="btn btn-pandu-primary">
    <i class="fas fa-plus me-2"></i> Rencanakan Audit
  </a>
@endsection

@section('content')
<div class="pandu-card">
  <div class="pandu-card-header">
    <h6 class="card-title-custom mb-0">Seluruh Rencana & Riwayat Audit</h6>
  </div>
  <div class="pandu-card-body p-0">
    <div class="table-responsive">
      <table class="table pandu-table">
        <thead>
          <tr>
            <th>No. Audit</th>
            <th>Judul / Tipe</th>
            <th>Area / Divisi</th>
            <th>Lead Auditor</th>
            <th>Jadwal</th>
            <th>Status</th>
            <th>Temuan</th>
          </tr>
        </thead>
        <tbody>
          @forelse($audits as $audit)
          <tr>
            <td><span class="doc-number">{{ $audit->audit_number }}</span></td>
            <td>
              <div class="td-main">{{ $audit->title }}</div>
              <div class="td-sub">{{ ucfirst($audit->audit_type) }}</div>
            </td>
            <td>
              <div class="td-main">{{ $audit->workArea->name }}</div>
              <div class="td-sub">{{ $audit->division->name }}</div>
            </td>
            <td><div class="td-main">{{ $audit->leadAuditor->name }}</div></td>
            <td>
               <div class="td-main">{{ $audit->scheduled_start->format('d/m/Y') }}</div>
               <div class="td-sub">s/d {{ $audit->scheduled_end->format('d/m/Y') }}</div>
            </td>
            <td><span class="status-badge status-{{ $audit->status }}">{{ ucfirst(str_replace('_', ' ', $audit->status)) }}</span></td>
            <td>
               <div class="d-flex gap-2">
                  <span class="badge bg-danger" title="Major">{{ $audit->major_findings }}</span>
                  <span class="badge bg-warning text-dark" title="Minor">{{ $audit->minor_findings }}</span>
               </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="7" class="text-center py-5">
              <p class="text-secondary">Belum ada jadwal audit.</p>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
