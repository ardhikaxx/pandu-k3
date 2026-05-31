@extends('layouts.app')

@section('title', 'Analitik K3')
@section('page-title', 'Pusat Analitik & KPI K3')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="#">Beranda</a></li>
  <li class="breadcrumb-item active">Analitik</li>
@endsection

@section('content')
<!-- Metric Row -->
<div class="row g-3 g-md-4 mb-4">
  <div class="col-12 col-sm-6 col-xl-3">
     <div class="stat-card stat-card--navy h-100 shadow-sm border-0">
        <div class="stat-card-header">
           <span class="stat-card-label">CAPA Closure Rate</span>
           <div class="stat-card-icon bg-light text-dark shadow-sm"><i class="fas fa-check-double"></i></div>
        </div>
        <div class="stat-card-body">
           @php 
             $rate = $stats['total_capa'] > 0 ? ($stats['closed_capa'] / $stats['total_capa']) * 100 : 0;
           @endphp
           <div class="stat-card-number">{{ round($rate) }}%</div>
           <div class="stat-progress mt-2">
              <div class="stat-progress-bar" style="width: {{ $rate }}%"></div>
           </div>
           <p class="smaller text-muted mt-2 mb-0">Target: 95% Selesai</p>
        </div>
     </div>
  </div>
  <div class="col-12 col-sm-6 col-xl-3">
     <div class="stat-card stat-card--danger h-100 shadow-sm border-0">
        <div class="stat-card-header">
           <span class="stat-card-label">LTIFR (Frekuensi)</span>
           <div class="stat-card-icon shadow-sm"><i class="fas fa-chart-line"></i></div>
        </div>
        <div class="stat-card-body">
           <div class="stat-card-number">0.42</div>
           <div class="stat-card-trend trend--down small mt-1">
              <i class="fas fa-arrow-trend-down"></i>
              <span>-12% dari target</span>
           </div>
           <p class="smaller text-muted mt-2 mb-0">Per 1,000,000 Jam Kerja</p>
        </div>
     </div>
  </div>
  <div class="col-12 col-sm-6 col-xl-3">
     <div class="stat-card stat-card--success h-100 shadow-sm border-0">
        <div class="stat-card-header">
           <span class="stat-card-label">Inspeksi Selesai</span>
           <div class="stat-card-icon shadow-sm"><i class="fas fa-clipboard-check"></i></div>
        </div>
        <div class="stat-card-body">
           <div class="stat-card-number">{{ $stats['completed_inspections'] }}</div>
           <div class="stat-card-trend trend--up small mt-1 text-success">
              <i class="fas fa-calendar-day"></i>
              <span>Update hari ini</span>
           </div>
           <p class="smaller text-muted mt-2 mb-0">Total bulan ini</p>
        </div>
     </div>
  </div>
  <div class="col-12 col-sm-6 col-xl-3">
     <div class="stat-card stat-card--warning h-100 shadow-sm border-0">
        <div class="stat-card-header">
           <span class="stat-card-label">Hazard Open</span>
           <div class="stat-card-icon shadow-sm text-warning"><i class="fas fa-triangle-exclamation"></i></div>
        </div>
        <div class="stat-card-body">
           <div class="stat-card-number text-dark">{{ $stats['open_hazards'] }}</div>
           <div class="stat-card-trend trend--up small mt-1 text-danger">
              <i class="fas fa-clock"></i>
              <span>Butuh tindakan segera</span>
           </div>
           <p class="smaller text-muted mt-2 mb-0">Masih aktif</p>
        </div>
     </div>
  </div>
</div>

<div class="row g-4 mb-4">
  <!-- Risk Matrix Heatmap -->
  <div class="col-12 col-xl-6">
     <div class="pandu-card h-100 shadow-sm border-0">
        <div class="pandu-card-header bg-white border-bottom py-3">
           <h6 class="card-title-custom mb-0 fw-bold text-dark"><i class="fas fa-th me-2 text-primary"></i> Matriks Risiko HIRADC 5×5</h6>
        </div>
        <div class="pandu-card-body p-4">
           <div class="risk-matrix-container overflow-hidden">
              <div class="risk-matrix-grid mx-auto" style="max-width: 450px;">
                 <div class="matrix-corner"></div>
                 @for($p=1; $p<=5; $p++) <div class="matrix-header fw-bold text-center text-muted small">P{{$p}}</div> @endfor
                 
                 @for($s=5; $s>=1; $s--)
                    <div class="matrix-row-label fw-bold d-flex align-items-center justify-content-center text-muted small">S{{$s}}</div>
                    @for($p=1; $p<=5; $p++)
                       @php 
                         $score = $s * $p;
                         $class = match(true) {
                           $score <= 4 => 'risk-very_low',
                           $score <= 9 => 'risk-low',
                           $score <= 14 => 'risk-medium',
                           $score <= 19 => 'risk-high',
                           default => 'risk-critical',
                         };
                       @endphp
                       <div class="matrix-cell {{ $class }} m-1 rounded-3 d-flex align-items-center justify-content-center fw-bold text-white shadow-sm" 
                            style="cursor: pointer; height: 60px; font-size: 1.1rem; transition: all 0.2s;"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="Keparahan: {{$s}}, Probabilitas: {{$p}}, Skor: {{$score}}">
                          {{ $score }}
                       </div>
                    @endfor
                 @endfor
              </div>
              <!-- Matrix Legend -->
              <div class="mt-4 border-top pt-3">
                <div class="row g-2 justify-content-center">
                  <div class="col-auto"><span class="badge bg-success-soft text-success px-2 py-1" style="font-size: 10px;">1-4 VERY LOW</span></div>
                  <div class="col-auto"><span class="badge bg-info-soft text-info px-2 py-1" style="font-size: 10px;">5-9 LOW</span></div>
                  <div class="col-auto"><span class="badge bg-warning-soft text-warning px-2 py-1" style="font-size: 10px;">10-14 MEDIUM</span></div>
                  <div class="col-auto"><span class="badge bg-danger-soft text-danger px-2 py-1" style="font-size: 10px;">15-19 HIGH</span></div>
                  <div class="col-auto"><span class="badge bg-danger text-white px-2 py-1" style="font-size: 10px;">20-25 CRITICAL</span></div>
                </div>
              </div>
           </div>
        </div>
     </div>
  </div>

  <!-- Yearly Performance Chart -->
  <div class="col-12 col-xl-6">
     <div class="pandu-card h-100 shadow-sm border-0">
        <div class="pandu-card-header bg-white border-bottom py-3">
           <h6 class="card-title-custom mb-0 fw-bold text-dark"><i class="fas fa-chart-area me-2 text-primary"></i> Tren Kinerja K3 (12 Bulan)</h6>
        </div>
        <div class="pandu-card-body p-4">
           <div style="height: 350px;">
             <canvas id="trendChart"></canvas>
           </div>
        </div>
     </div>
  </div>
</div>

<div class="row g-4">
  <!-- Hazard Composition -->
  <div class="col-12 col-lg-5">
     <div class="pandu-card h-100 shadow-sm border-0">
        <div class="pandu-card-header bg-white border-bottom py-3">
           <h6 class="card-title-custom mb-0 fw-bold text-dark"><i class="fas fa-chart-pie me-2 text-primary"></i> Komposisi Jenis Bahaya</h6>
        </div>
        <div class="pandu-card-body p-4">
           <div class="row align-items-center">
              <div class="col-md-6 mb-3 mb-md-0 text-center">
                 <div style="height: 220px;">
                    <canvas id="hazardDoughnut"></canvas>
                 </div>
              </div>
              <div class="col-md-6">
                 <div class="list-group list-group-flush border-0">
                    @foreach($hazardCategories as $cat)
                       <div class="list-group-item d-flex justify-content-between align-items-center px-0 py-2 border-0">
                          <div class="d-flex align-items-center gap-2">
                             <div class="rounded-circle" style="width: 10px; height: 10px; background-color: {{ ['#F39C12', '#2C3E50', '#8E44AD', '#C0392B', '#1A7A4A', '#1E88E5'][$loop->index % 6] }}"></div>
                             <span class="small fw-semibold text-secondary">{{ ucfirst($cat->category) }}</span>
                          </div>
                          <span class="badge bg-light text-dark fw-bold rounded-pill shadow-sm">{{ $cat->total }}</span>
                       </div>
                    @endforeach
                 </div>
              </div>
           </div>
        </div>
     </div>
  </div>

  <!-- Quick Action or Key Stats -->
  <div class="col-12 col-lg-7">
     <div class="pandu-card h-100 shadow-sm border-0">
        <div class="pandu-card-header bg-white border-bottom py-3">
           <h6 class="card-title-custom mb-0 fw-bold text-dark"><i class="fas fa-list-ul me-2 text-primary"></i> Ringkasan Indikator Kunci</h6>
        </div>
        <div class="pandu-card-body p-0">
           <div class="table-responsive">
              <table class="table align-middle mb-0 small">
                 <thead class="bg-light text-muted">
                    <tr>
                       <th class="ps-4 py-3">Indikator Performa</th>
                       <th class="py-3">Status</th>
                       <th class="py-3 text-end pe-4">Progress</th>
                    </tr>
                 </thead>
                 <tbody>
                    <tr>
                       <td class="ps-4 py-3">
                          <div class="fw-bold text-dark">Penyelesaian CAPA</div>
                          <div class="smaller text-muted">Total: {{ $stats['total_capa'] }} Tindakan</div>
                       </td>
                       <td><span class="badge bg-success-soft text-success rounded-pill px-3">On Track</span></td>
                       <td class="pe-4 text-end">
                          <div class="d-flex align-items-center justify-content-end gap-3">
                             <span class="fw-bold">{{ round($rate) }}%</span>
                             <div class="progress" style="width: 100px; height: 6px;">
                                <div class="progress-bar bg-primary rounded-pill" style="width: {{ $rate }}%"></div>
                             </div>
                          </div>
                       </td>
                    </tr>
                    <tr>
                       <td class="ps-4 py-3">
                          <div class="fw-bold text-dark">Kepatuhan Inspeksi</div>
                          <div class="smaller text-muted">Bulan berjalan</div>
                       </td>
                       <td><span class="badge bg-info-soft text-info rounded-pill px-3">Active</span></td>
                       <td class="pe-4 text-end">
                          <div class="d-flex align-items-center justify-content-end gap-3">
                             <span class="fw-bold">85%</span>
                             <div class="progress" style="width: 100px; height: 6px;">
                                <div class="progress-bar bg-info rounded-pill" style="width: 85%"></div>
                             </div>
                          </div>
                       </td>
                    </tr>
                    <tr>
                       <td class="ps-4 py-3">
                          <div class="fw-bold text-dark">Zero Accident Days</div>
                          <div class="smaller text-muted">Sejak insiden terakhir</div>
                       </td>
                       <td><span class="badge bg-warning-soft text-warning rounded-pill px-3">Watching</span></td>
                       <td class="pe-4 text-end">
                          <div class="fw-bold text-dark fs-5">124 Hari</div>
                       </td>
                    </tr>
                 </tbody>
              </table>
           </div>
        </div>
     </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    })

    // Charts
    const trendCtx = document.getElementById('trendChart').getContext('2d');
    new Chart(trendCtx, {
      type: 'line',
      data: {
        labels: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'],
        datasets: [{
          label: 'Insiden',
          data: [1, 2, 0, 1, 3, 0, 1, 2, 1, 0, 1, 1],
          borderColor: '#C0392B',
          backgroundColor: 'rgba(192,57,43,0.1)',
          fill: true,
          tension: 0.4,
          borderWidth: 2,
          pointRadius: 4,
          pointBackgroundColor: '#C0392B'
        }, {
          label: 'Near Miss',
          data: [5, 8, 4, 7, 12, 6, 9, 10, 5, 4, 8, 7],
          borderColor: '#E67E22',
          backgroundColor: 'rgba(230,126,34,0.05)',
          fill: true,
          tension: 0.4,
          borderWidth: 2,
          pointRadius: 4,
          pointBackgroundColor: '#E67E22'
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: { position: 'top', align: 'end', labels: { usePointStyle: true, boxWidth: 6, font: { weight: '600', size: 12 } } },
          tooltip: { backgroundColor: '#0D2137', padding: 12, cornerRadius: 8 }
        },
        scales: { 
          y: { beginAtZero: true, grid: { borderDash: [5, 5], color: 'rgba(0,0,0,0.05)' } },
          x: { grid: { display: false } }
        }
      }
    });

    const doughnutCtx = document.getElementById('hazardDoughnut').getContext('2d');
    new Chart(doughnutCtx, {
      type: 'doughnut',
      data: {
        labels: {!! json_encode($hazardCategories->pluck('category')) !!},
        datasets: [{
          data: {!! json_encode($hazardCategories->pluck('total')) !!},
          backgroundColor: ['#F39C12', '#2C3E50', '#8E44AD', '#C0392B', '#1A7A4A', '#1E88E5'],
          borderWidth: 0,
          hoverOffset: 15
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '75%',
        plugins: { 
          legend: { display: false },
          tooltip: { backgroundColor: '#0D2137', padding: 12, cornerRadius: 8 }
        }
      }
    });
});
</script>
@endpush

@push('styles')
<style>
.stat-card { background: #fff; border-radius: 16px; padding: 24px; position: relative; overflow: hidden; transition: all 0.3s ease; }
.stat-card:hover { transform: translateY(-5px); }
.stat-card::before { content: ''; position: absolute; top: 0; left: 0; width: 4px; height: 100%; }
.stat-card--danger::before { background: var(--color-danger); }
.stat-card--success::before { background: var(--color-success); }
.stat-card--warning::before { background: var(--color-warning); }
.stat-card--navy::before { background: var(--pandu-navy); }
.stat-card-label { font-size: 0.7rem; font-weight: 800; text-transform: uppercase; color: var(--gray-500); letter-spacing: 0.5px; }
.stat-card-number { font-size: 2.25rem; font-weight: 800; color: var(--gray-900); line-height: 1.2; }
.stat-card-icon { width: 42px; height: 42px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; }
.stat-card--danger .stat-card-icon { background: var(--color-danger-light); color: var(--color-danger); }
.stat-card--success .stat-card-icon { background: var(--color-success-light); color: var(--color-success); }
.stat-card--warning .stat-card-icon { background: var(--color-warning-light); color: var(--color-warning); }
.stat-card-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; }
.stat-progress { height: 6px; background: var(--gray-100); border-radius: 10px; }
.stat-progress-bar { height: 100%; background: var(--pandu-navy); border-radius: 10px; }

.matrix-cell:hover { transform: scale(1.15); z-index: 10; box-shadow: 0 5px 15px rgba(0,0,0,0.1) !important; }
.bg-success-soft { background-color: rgba(26, 122, 74, 0.1); }
.bg-info-soft { background-color: rgba(21, 101, 192, 0.1); }
.bg-warning-soft { background-color: rgba(230, 126, 34, 0.1); }
.bg-danger-soft { background-color: rgba(192, 57, 43, 0.1); }

@media (max-width: 576px) {
  .stat-card-number { font-size: 1.75rem; }
  .matrix-cell { height: 45px !important; font-size: 0.9rem !important; }
}
</style>
@endpush
