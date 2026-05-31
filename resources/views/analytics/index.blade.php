@extends('layouts.app')

@section('title', 'Analitik K3')
@section('page-title', 'Pusat Analitik & KPI K3')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="#">Beranda</a></li>
  <li class="breadcrumb-item active">Analitik</li>
@endsection

@section('content')
<div class="row g-4 mb-4">
  <div class="col-md-4">
     <div class="stat-card stat-card--navy h-100">
        <div class="stat-card-header">
           <span class="stat-card-label">CAPA Closure Rate</span>
           <div class="stat-card-icon bg-light text-dark"><i class="fas fa-check-double"></i></div>
        </div>
        <div class="stat-card-body">
           @php 
             $rate = $stats['total_capa'] > 0 ? ($stats['closed_capa'] / $stats['total_capa']) * 100 : 0;
           @endphp
           <div class="stat-card-number">{{ round($rate) }}%</div>
           <div class="stat-progress mt-3">
              <div class="stat-progress-bar" style="width: {{ $rate }}%"></div>
           </div>
        </div>
     </div>
  </div>
  <div class="col-md-4">
     <div class="stat-card stat-card--danger h-100">
        <div class="stat-card-header">
           <span class="stat-card-label">LTIFR (Current)</span>
           <div class="stat-card-icon"><i class="fas fa-chart-line"></i></div>
        </div>
        <div class="stat-card-body">
           <div class="stat-card-number">0.42</div>
           <p class="small text-secondary mb-0">Target: < 1.00</p>
        </div>
     </div>
  </div>
  <div class="col-md-4">
     <div class="stat-card stat-card--success h-100">
        <div class="stat-card-header">
           <span class="stat-card-label">Inspeksi Selesai</span>
           <div class="stat-card-icon"><i class="fas fa-clipboard-check"></i></div>
        </div>
        <div class="stat-card-body">
           <div class="stat-card-number">{{ $stats['completed_inspections'] }}</div>
           <p class="small text-secondary mb-0">Bulan ini</p>
        </div>
     </div>
  </div>
</div>

<div class="row g-4 mb-4">
  <div class="col-lg-12">
     <div class="pandu-card">
        <div class="pandu-card-header">
           <h6 class="card-title-custom mb-0">Matriks Risiko HIRADC 5×5 (Kumulatif)</h6>
        </div>
        <div class="pandu-card-body">
           <div class="risk-matrix-container">
              <div class="risk-matrix-grid">
                 <div class="matrix-corner"></div>
                 @for($p=1; $p<=5; $p++) <div class="matrix-header fw-bold text-center">P{{$p}}</div> @endfor
                 
                 @for($s=5; $s>=1; $s--)
                    <div class="matrix-row-label fw-bold d-flex align-items-center justify-content-center">S{{$s}}</div>
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
                       <div class="matrix-cell {{ $class }}" data-bs-toggle="tooltip" title="Skor: {{ $score }}">
                          {{ $score }}
                       </div>
                    @endfor
                 @endfor
              </div>
              <div class="d-flex justify-content-center mt-3 gap-4 small fw-bold">
                 <div class="d-flex align-items-center gap-1"><span class="risk-badge risk-very_low" style="width:12px;height:12px;padding:0"></span> Sangat Rendah</div>
                 <div class="d-flex align-items-center gap-1"><span class="risk-badge risk-low" style="width:12px;height:12px;padding:0"></span> Rendah</div>
                 <div class="d-flex align-items-center gap-1"><span class="risk-badge risk-medium" style="width:12px;height:12px;padding:0"></span> Sedang</div>
                 <div class="d-flex align-items-center gap-1"><span class="risk-badge risk-high" style="width:12px;height:12px;padding:0"></span> Tinggi</div>
                 <div class="d-flex align-items-center gap-1"><span class="risk-badge risk-critical" style="width:12px;height:12px;padding:0"></span> Kritis</div>
              </div>
           </div>
        </div>
     </div>
  </div>
</div>

<div class="row g-4">
  <div class="col-lg-8">
     <div class="pandu-card h-100">
        <div class="pandu-card-header">
           <h6 class="card-title-custom mb-0">Tren Kinerja K3 Tahunan</h6>
        </div>
        <div class="pandu-card-body">
           <canvas id="trendChart" height="350"></canvas>
        </div>
     </div>
  </div>
  <div class="col-lg-4">
     <div class="pandu-card h-100">
        <div class="pandu-card-header">
           <h6 class="card-title-custom mb-0">Komposisi Bahaya</h6>
        </div>
        <div class="pandu-card-body">
           <canvas id="hazardDoughnut" height="300"></canvas>
           <div class="mt-4 small">
              @foreach($hazardCategories as $cat)
                 <div class="d-flex justify-content-between mb-1">
                    <span>{{ ucfirst($cat->category) }}</span>
                    <span class="fw-bold">{{ $cat->total }}</span>
                 </div>
              @endforeach
           </div>
        </div>
     </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
const trendCtx = document.getElementById('trendChart').getContext('2d');
new Chart(trendCtx, {
  type: 'bar',
  data: {
    labels: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'],
    datasets: [{
      label: 'Insiden',
      data: [1, 2, 0, 1, 3, 0, 1, 2, 1, 0, 1, 1],
      backgroundColor: '#C0392B',
    }, {
      label: 'Near Miss',
      data: [5, 8, 4, 7, 12, 6, 9, 10, 5, 4, 8, 7],
      backgroundColor: '#E67E22',
    }]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    scales: { y: { beginAtZero: true } }
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
      borderWidth: 0
    }]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    cutout: '75%',
    plugins: { legend: { display: false } }
  }
});
</script>
@endpush

@push('styles')
<style>
.stat-card { background: #fff; border-radius: var(--radius-lg); padding: 24px; border: 1px solid var(--gray-200); position: relative; overflow: hidden; }
.stat-card::before { content: ''; position: absolute; top: 0; left: 0; width: 4px; height: 100%; }
.stat-card--danger::before { background: var(--color-danger); }
.stat-card--success::before { background: var(--color-success); }
.stat-card--navy::before { background: var(--pandu-navy); }
.stat-card-label { font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: var(--gray-500); }
.stat-card-number { font-size: 2.5rem; font-weight: 800; color: var(--gray-900); }
.stat-card-icon { width: 40px; height: 40px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; }
.stat-card--danger .stat-card-icon { background: var(--color-danger-light); color: var(--color-danger); }
.stat-card--success .stat-card-icon { background: var(--color-success-light); color: var(--color-success); }
.stat-card-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; }
.stat-progress { height: 6px; background: var(--gray-100); border-radius: 10px; }
.stat-progress-bar { height: 100%; background: var(--pandu-navy); border-radius: 10px; }
</style>
@endpush
