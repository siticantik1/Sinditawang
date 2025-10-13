@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Selamat Datang, {{ Auth::user()->name }}!</h1>
</div>

<!-- Content Row - Kartu Statistik (Baris 1) -->
<div class="row">
    <!-- Total Nilai Aset -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Nilai Aset (KIB)</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">Rp {{ number_format($totalValue, 0, ',', '.') }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Jumlah Tanah -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Jumlah Tanah (A)</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalCounts['tanah'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-map-marked-alt fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Jumlah Peralatan -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Peralatan (B)
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalCounts['peralatan'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-cogs fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Jumlah Gedung -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Gedung (C)</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalCounts['gedung'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-building fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Content Row - Kartu Statistik (Baris 2) -->
<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-dark shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">Jalan & Jaringan (D)</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalCounts['jalan'] }}</div>
                    </div>
                    <div class="col-auto"><i class="fas fa-road fa-2x text-gray-300"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Barang Rusak Berat</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalCounts['rusak'] }}</div>
                    </div>
                    <div class="col-auto"><i class="fas fa-times-circle fa-2x text-gray-300"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-secondary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">Total Ruangan</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalCounts['ruangan'] }}</div>
                    </div>
                    <div class="col-auto"><i class="fas fa-door-open fa-2x text-gray-300"></i></div>
                </div>
            </div>
        </div>
    </div>
     <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Inventaris</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalCounts['inventaris'] }}</div>
                    </div>
                    <div class="col-auto"><i class="fas fa-boxes fa-2x text-gray-300"></i></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Content Row - Chart -->
<div class="row">
    {{-- Tampilkan Chart Persebaran hanya untuk Admin --}}
    @if($assetByLocation->isNotEmpty())
    <!-- Area Chart -->
    <div class="col-xl-8 col-lg-7">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Persebaran Aset Tanah per Lokasi</h6>
            </div>
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="myAreaChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Pie Chart -->
    {{-- Jika bukan admin, buat chart ini lebih besar --}}
    <div class="{{ $assetByLocation->isEmpty() ? 'col-lg-12' : 'col-xl-4 col-lg-5' }}">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Komposisi Nilai Aset</h6>
            </div>
            <div class="card-body">
                <div class="chart-pie pt-4">
                    <canvas id="myPieChart"></canvas>
                </div>
                <div class="mt-4 text-center small">
                    <span class="mr-2"><i class="fas fa-circle text-primary"></i> Tanah</span>
                    <span class="mr-2"><i class="fas fa-circle text-success"></i> Peralatan</span>
                    <span class="mr-2"><i class="fas fa-circle text-info"></i> Gedung</span>
                    <span class="mr-2"><i class="fas fa-circle text-dark"></i> Jalan</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Page level plugins -->
<script src="{{ asset('template/vendor/chart.js/Chart.min.js')}}"></script>

<!-- Page level custom scripts -->
<script>
// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

function number_format(number, decimals, dec_point, thousands_sep) {
  number = (number + '').replace(',', '').replace(' ', '');
  var n = !isFinite(+number) ? 0 : +number,
    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
    s = '',
    toFixedFix = function(n, prec) {
      var k = Math.pow(10, prec);
      return '' + Math.round(n * k) / k;
    };
  s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
  if (s[0].length > 3) {
    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
  }
  return s.join(dec);
}

// Area Chart (hanya dijalankan jika elemennya ada)
if (document.getElementById("myAreaChart")) {
    var ctxArea = document.getElementById("myAreaChart");
    var myLineChart = new Chart(ctxArea, {
      type: 'line',
      data: {
        labels: {!! json_encode($assetByLocation->keys()) !!},
        datasets: [{
          label: "Jumlah Aset Tanah",
          lineTension: 0.3,
          backgroundColor: "rgba(78, 115, 223, 0.05)",
          borderColor: "rgba(78, 115, 223, 1)",
          pointRadius: 3,
          pointBackgroundColor: "rgba(78, 115, 223, 1)",
          pointBorderColor: "rgba(78, 115, 223, 1)",
          pointHoverRadius: 3,
          data: {!! json_encode($assetByLocation->values()) !!},
        }],
      },
      options: {
        maintainAspectRatio: false,
        scales: {
          yAxes: [{ ticks: { callback: function(value) { return number_format(value); } } }],
        },
        tooltips: {
          callbacks: {
            label: function(tooltipItem, chart) {
              var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
              return datasetLabel + ': ' + number_format(tooltipItem.yLabel);
            }
          }
        }
      }
    });
}


// Pie Chart
var ctxPie = document.getElementById("myPieChart");
var myPieChart = new Chart(ctxPie, {
  type: 'doughnut',
  data: {
    labels: {!! json_encode($assetValueComposition->keys()) !!},
    datasets: [{
      data: {!! json_encode($assetValueComposition->values()) !!},
      backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#5a5c69'],
      hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf', '#42444b'],
      hoverBorderColor: "rgba(234, 236, 244, 1)",
    }],
  },
  options: {
    maintainAspectRatio: false,
    tooltips: {
        callbacks: {
            label: function(tooltipItem, data) {
                var dataset = data.datasets[tooltipItem.datasetIndex];
                var total = dataset.data.reduce(function(previousValue, currentValue) {
                    return previousValue + currentValue;
                });
                var currentValue = dataset.data[tooltipItem.index];
                var percentage = total > 0 ? Math.floor(((currentValue/total) * 100)+0.5) : 0;
                return ' ' + data.labels[tooltipItem.index] + ': Rp ' + number_format(currentValue) + ' (' + percentage + '%)';
            }
        }
    },
    legend: { display: false },
    cutoutPercentage: 80,
  },
});
</script>
@endpush

