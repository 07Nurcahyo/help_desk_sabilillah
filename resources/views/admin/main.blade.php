@extends('layouts.template')

@section('content')

<div class="container">

<section class="content pt-3">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-6">
            <div class="small-box bg-primary">
                <div class="inner">
                <h3>{{ $jumlahAdmin }}</h3> {{-- menyesuaikan banyak user dengan role admin --}}

                <p>Admin</p>
                </div>
                <div class="icon">
                <i class="fas fa-user-tie"></i>
                </div>
            </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
                <div class="inner">
                <h3>{{ $jumlahGuru }}</h3>

                <p>Guru</p>
                </div>
                <div class="icon">
                <i class="fas fa-user-graduate"></i>
                </div>
            </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
                <div class="inner">
                <h3>{{ $jumlahSiswa }}</h3>

                <p>Siswa</p>
                </div>
                <div class="icon">
                <i class="fas fa-user-graduate"></i>
                </div>
            </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                <h3>{{ $penggunaAktif }}</h3> {{-- menyesuaikan banyak user dengan status aktif --}}

                <p>Pengguna Aktif</p>
                </div>
                <div class="icon">
                <i class="fas fa-users"></i>
                </div>
            </div>
            </div>
            <!-- ./col -->
        </div>

    <div class="row">
        <div class="col-md-6">
            {{-- Linechart keseluruhan linimasa laporan  --}}
            <div class="card">
                <div class="card-header bg-navy">
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool">
                            <select class="form-control" name="id_category" id="id_category" required>
                                <option value="">--Semua--</option>
                                @foreach($category as $item)
                                <option value="{{$item->id_category}}">{{$item->category_name}}</option>
                                @endforeach
                            </select>
                        </button>
                    </div>
                    <h2 class="card-title font-weight-bold" style="font-size: 22px">Linechart Linimasa Laporan</h2>
                </div>
                <div class="card-body" style="background-color: ">
                    <canvas id="lineLaporan"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            {{-- Chart apa ya enaknya --}}
            <div class="card">
                <div class="card-header bg-navy">
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool">
                            <select class="form-control" name="id_category" id="id_category" required>
                                <option value="">--Semua--</option>
                                @foreach($category as $item)
                                <option value="{{$item->id_category}}">{{$item->category_name}}</option>
                                @endforeach
                            </select>
                        </button>
                    </div>
                    <h2 class="card-title font-weight-bold" style="font-size: 22px"> </h2>
                </div>
                <div class="card-body">
                    <canvas id="statusChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    </div>
</section>

</div>

@endsection

@push('css')
@endpush

@push('js')
{{-- linechart --}}
<script>
const lineCtx = document.getElementById('lineLaporan').getContext('2d');

// gradient biru
const gradient = lineCtx.createLinearGradient(0, 0, 0, 300);
gradient.addColorStop(0, 'rgba(54, 162, 235, 0.4)');
gradient.addColorStop(1, 'rgba(54, 162, 235, 0.05)');

const lineChart = new Chart(lineCtx, {
    type: 'line',
    data: {
        labels: {!! json_encode($laporanPerTanggal->pluck('tanggal')) !!},
        datasets: [{
            label: 'Jumlah Laporan',
            data: {!! json_encode($laporanPerTanggal->pluck('total')) !!},
            borderColor: '#36A2EB',
            backgroundColor: gradient,
            pointBackgroundColor: '#36A2EB',
            pointBorderColor: '#fff',
            pointRadius: 5,
            pointHoverRadius: 8,
            pointHoverBackgroundColor: '#1d6fa5',
            borderWidth: 3,
            tension: 0.45,
            fill: true
        }]
    },
    options: {
        responsive: true,
        interaction: {
            mode: 'index',
            intersect: false
        },
        plugins: {
            legend: {
                display: true,
                labels: {
                    usePointStyle: true
                }
            },
            tooltip: {
                backgroundColor: '#1f2937',
                titleColor: '#fff',
                bodyColor: '#e5e7eb',
                padding: 12,
                cornerRadius: 6
            }
        },
        scales: {
            x: {
                grid: {
                    display: false
                },
                title: {
                    display: true,
                    text: 'Tanggal'
                }
            },
            y: {
                beginAtZero: true,
                grid: {
                    color: 'rgba(0,0,0,0.05)'
                },
                title: {
                    display: true,
                    text: 'Jumlah Laporan'
                }
            }
        }
    }
});
</script>


{{-- status chart --}}
<script>
const statusCtx = document.getElementById('statusChart').getContext('2d');

const statusChart = new Chart(statusCtx, {
    type: 'doughnut',
    data: {
        labels: {!! json_encode($laporanPerStatus->pluck('status')) !!},
        datasets: [{
            data: {!! json_encode($laporanPerStatus->pluck('total')) !!},
            backgroundColor: [
                '#3B82F6', // baru - biru
                '#FACC15', // proses - kuning
                '#22C55E'  // selesai - hijau
            ],
            hoverBackgroundColor: [
                '#2563EB',
                '#EAB308',
                '#16A34A'
            ],
            borderWidth: 2,
            borderColor: '#ffffff'
        }]
    },
    options: {
        responsive: true,
        cutout: '65%',
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    padding: 15,
                    usePointStyle: true
                }
            },
            tooltip: {
                backgroundColor: '#1f2937',
                titleColor: '#fff',
                bodyColor: '#e5e7eb',
                padding: 10,
                cornerRadius: 6
            }
        }
    }
});
</script>


@endpush