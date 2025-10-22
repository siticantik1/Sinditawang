@extends('layouts.app')

@section('content')

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    
    <!-- Filter Lokasi -->
    <form action="{{ route('dashboard') }}" method="GET" class="d-none d-sm-inline-block">
        <div class="input-group">
            <select name="lokasi" class="form-control form-control-sm" onchange="this.form.submit()">
                <option value="">Semua Lokasi</option>
                @foreach ($allLokasi as $lokasi)
                    <option value="{{ $lokasi }}" {{ $selectedLokasi == $lokasi ? 'selected' : '' }}>
                        {{ ucfirst($lokasi) }}
                    </option>
                @endforeach
            </select>
            <div class="input-group-append">
                <button class="btn btn-primary btn-sm" type="submit">
                    <i class="fas fa-filter fa-sm"></i> Filter
                </button>
            </div>
        </div>
    </form>
</div>

<!-- Baris KPI Cards -->
<div class="row">
    <!-- Total Nilai Aset -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Nilai Aset</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">Rp {{ number_format($kpiTotalNilai, 0, ',', '.') }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Aset Terdaftar -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Aset Terdaftar</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($kpiTotalAset, 0, ',', '.') }} Unit</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-boxes fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Ruangan -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Ruangan</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $kpiTotalRuangan }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-door-open fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Barang Rusak Berat -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Barang Rusak Berat (RB)</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $kpiTotalRusak }} Unit</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-heart-broken fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Baris Charts 1 -->
<div class="row">
    <!-- Bar Chart: Nilai Aset per KIB -->
    <div class="col-xl-8 col-lg-7">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Nilai Aset per Kategori</h6>
            </div>
            <div class="card-body">
                <div class="chart-bar">
                    <canvas id="chartNilaiAset"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Pie Chart: Komposisi Aset per KIB -->
    <div class="col-xl-4 col-lg-5">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Komposisi Unit Aset</h6>
            </div>
            <div class="card-body">
                <div class="chart-pie pt-4">
                    <canvas id="chartKomposisiAset"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Baris Charts 2 -->
<div class="row">
    <!-- Line Chart: Perolehan Aset per Tahun -->
    <div class="col-xl-8 col-lg-7">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Tren Perolehan Aset per Tahun (Jumlah)</h6>
            </div>
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="chartPerolehan"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Pie Chart: Kondisi Inventaris -->
    <div class="col-xl-4 col-lg-5">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Kondisi Inventaris Ruangan</h6>
            </div>
            <div class="card-body">
                <div class="chart-pie pt-4">
                    <canvas id="chartKondisi"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Baris Quick Lists & Navigasi -->
<div class="row">
    <!-- Quick Lists -->
    <div class="col-lg-6 mb-4">
        <!-- Aset Baru Ditambahkan -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Inventaris Baru Ditambahkan</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-hover" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Nama Barang</th>
                                <th>Ruangan</th>
                                <th>Lokasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($listAsetTerbaru as $item)
                                <tr>
                                    <td>
                                        <a href="{{ route('lokasi.inventaris.edit', ['lokasi' => $item->room->lokasi, 'room' => $item->room->id, 'inventari' => $item->id]) }}">
                                            {{ $item->nama_barang }}
                                        </a>
                                    </td>
                                    <td>{{ $item->room->name ?? 'N/A' }}</td>
                                    <td>{{ $item->room->lokasi ?? 'N/A' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">Tidak ada data.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Ruangan Terpadat -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Ruangan dengan Inventaris Terbanyak</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-hover" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Nama Ruangan</th>
                                <th>Lokasi</th>
                                <th class="text-center">Jumlah Barang</th>
                            </tr>
                        </thead>
                        <tbody>
                             @forelse ($listRuangan as $room)
                                <tr>
                                    <td>
                                        <a href="{{ route('lokasi.inventaris.index', ['lokasi' => $room->lokasi, 'room' => $room->id]) }}">
                                            {{ $room->name }}
                                        </a>
                                    </td>
                                    <td>{{ $room->lokasi }}</td>
                                    <td class="text-center">{{ $room->inventaris_count }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">Tidak ada data.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigasi KIB -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Navigasi Utama</h6>
            </div>
            <div class="card-body">
                <div class="list-group">
                    <a href="{{ route('lokasi.inventaris.index', ['lokasi' => $selectedLokasi ?? $allLokasi->first(), 'room' => \App\Models\Room::firstWhere('lokasi', $selectedLokasi ?? $allLokasi->first())->id ?? 0]) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fas fa-door-open fa-fw mr-2 text-gray-400"></i>
                            Inventaris Ruangan (KIR)
                        </div>
                        <span class="badge badge-primary badge-pill">{{ $countInventaris }}</span>
                    </a>
                    <a href="{{ route('lokasi.tanah.index', ['lokasi' => $selectedLokasi ?? $allLokasi->first()]) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fas fa-map-marked-alt fa-fw mr-2 text-gray-400"></i>
                            KIB A (Tanah)
                        </div>
                        <span class="badge badge-primary badge-pill">{{ $countTanah }}</span>
                    </a>
                    <a href="{{ route('lokasi.peralatan.index', ['lokasi' => $selectedLokasi ?? $allLokasi->first()]) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fas fa-tractor fa-fw mr-2 text-gray-400"></i>
                            KIB B (Peralatan & Mesin)
                        </div>
                        <span class="badge badge-primary badge-pill">{{ $countPeralatan }}</span>
                    </a>
                    <a href="{{ route('lokasi.gedung.index', ['lokasi' => $selectedLokasi ?? $allLokasi->first()]) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fas fa-building fa-fw mr-2 text-gray-400"></i>
                            KIB C (Gedung & Bangunan)
                        </div>
                        <span class="badge badge-primary badge-pill">{{ $countGedung }}</span>
                    </a>
                    <a href="{{ route('lokasi.jalan.index', ['lokasi' => $selectedLokasi ?? $allLokasi->first()]) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fas fa-road fa-fw mr-2 text-gray-400"></i>
                            KIB D (Jalan, Irigasi, Jaringan)
                        </div>
                        <span class="badge badge-primary badge-pill">{{ $countJalan }}</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Helper untuk format Rupiah (hanya untuk tooltip)
    function number_format(number, decimals, dec_point, thousands_sep) {
        number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
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

    // Ambil data dari PHP
    var chartNilaiData = @json($chartNilaiAset);
    var chartKomposisiData = @json($chartKomposisiAset);
    var chartKondisiData = @json($chartKondisi);
    var chartPerolehanData = @json($chartPerolehan);

    // Set default style untuk Chart.js (agar cocok dengan SB Admin 2)
    Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
    Chart.defaults.global.defaultFontColor = '#858796';

    // 1. Chart Nilai Aset (Bar)
    var ctxNilai = document.getElementById("chartNilaiAset");
    var chartNilaiAset = new Chart(ctxNilai, {
        type: 'bar',
        data: {
            labels: chartNilaiData.labels,
            datasets: [{
                label: "Nilai Aset (Rp)",
                backgroundColor: "#4e73df",
                hoverBackgroundColor: "#2e59d9",
                borderColor: "#4e73df",
                data: chartNilaiData.data,
            }],
        },
        options: {
            maintainAspectRatio: false,
            legend: { display: false },
            tooltips: {
                callbacks: {
                    label: function(tooltipItem, data) {
                        return data.datasets[tooltipItem.datasetIndex].label + ': Rp ' + number_format(tooltipItem.yLabel);
                    }
                }
            },
            scales: {
                xAxes: [{ gridLines: { display: false, drawBorder: false } }],
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        callback: function(value, index, values) {
                            return 'Rp ' + number_format(value);
                        }
                    }
                }],
            },
        }
    });

    // 2. Chart Komposisi Aset (Pie)
    var ctxKomposisi = document.getElementById("chartKomposisiAset");
    var chartKomposisiAset = new Chart(ctxKomposisi, {
        type: 'doughnut',
        data: {
            labels: chartKomposisiData.labels,
            datasets: [{
                data: chartKomposisiData.data,
                backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b'],
                hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf', '#dda20a', '#c73123'],
                hoverBorderColor: "rgba(234, 236, 244, 1)",
            }],
        },
        options: {
            maintainAspectRatio: false,
            tooltips: {
                callbacks: {
                    label: function(tooltipItem, data) {
                        var label = data.labels[tooltipItem.index] || '';
                        var value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                        return label + ': ' + number_format(value) + ' Unit';
                    }
                }
            },
            legend: { display: true, position: 'bottom' },
            cutoutPercentage: 80,
        },
    });

    // 3. Chart Perolehan Aset (Line)
    var ctxPerolehan = document.getElementById("chartPerolehan");
    var chartPerolehan = new Chart(ctxPerolehan, {
        type: 'line',
        data: {
            labels: chartPerolehanData.labels,
            datasets: [{
                label: "Jumlah Aset Diperoleh",
                lineTension: 0.3,
                backgroundColor: "rgba(78, 115, 223, 0.05)",
                borderColor: "rgba(78, 115, 223, 1)",
                pointRadius: 3,
                pointBackgroundColor: "rgba(78, 115, 223, 1)",
                pointBorderColor: "rgba(78, 115, 223, 1)",
                pointHoverRadius: 3,
                pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                pointHitRadius: 10,
                pointBorderWidth: 2,
                data: chartPerolehanData.data,
            }],
        },
        options: {
            maintainAspectRatio: false,
            scales: {
                xAxes: [{ gridLines: { display: false, drawBorder: false } }],
                yAxes: [{ ticks: { beginAtZero: true, padding: 10 } }],
            },
            legend: { display: false },
            tooltips: {
                callbacks: {
                    label: function(tooltipItem, data) {
                        return 'Jumlah: ' + number_format(tooltipItem.yLabel) + ' Unit';
                    }
                }
            }
        }
    });

    // 4. Chart Kondisi Inventaris (Pie)
    var ctxKondisi = document.getElementById("chartKondisi");
    var chartKondisi = new Chart(ctxKondisi, {
        type: 'pie',
        data: {
            labels: chartKondisiData.labels,
            datasets: [{
                data: chartKondisiData.data,
                backgroundColor: ['#1cc88a', '#f6c23e', '#e74a3b'],
                hoverBackgroundColor: ['#17a673', '#dda20a', '#c73123'],
                hoverBorderColor: "rgba(234, 236, 244, 1)",
            }],
        },
        options: {
            maintainAspectRatio: false,
            tooltips: {
                callbacks: {
                    label: function(tooltipItem, data) {
                        var label = data.labels[tooltipItem.index] || '';
                        var value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                        return label + ': ' + number_format(value) + ' Unit';
                    }
                }
            },
            legend: { display: true, position: 'bottom' },
        },
    });

</script>
@endpush
