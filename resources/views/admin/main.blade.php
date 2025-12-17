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
            {{-- piechart keseluruhan  --}}
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
                    <canvas id="pieChartKeseluruhan"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            {{-- piechart per tahun filter by tahun --}}
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
                    <h2 class="card-title font-weight-bold" style="font-size: 22px">Barchart </h2>
                </div>
                <div class="card-body">
                    <canvas id="pieChartTahun"></canvas>
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
<script></script>
@endpush