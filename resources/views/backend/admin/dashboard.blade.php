@extends('layouts.admin')

@section('main-content')
    <h2>Dashboard Admin</h2>
    <p class="mb-4 text-gray-600">Ringkasan data Kwartir Cabang Gerakan Pramuka Aceh Besar.</p>

    <div class="row">

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Ranting
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalRanting }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-map fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Gugus Depan
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalGudep }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-map-marked-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Total Kegiatan
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalKegiatan }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Total Partisipan
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalPartisipan }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-tag fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <p class="h6 m-0 font-weight-bold text-primary">Kegiatan Mendatang</p>
                    <a href="{{ url('/admin/data/kegiatan') }}" class="small">Lihat Semua</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Nama Kegiatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($kegiatanMendatang as $keg)
                                    <tr>
                                        <td>{{ $keg->date ? date('d M Y', strtotime($keg->date)) : '-' }}</td>
                                        <td>{{ $keg->title }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center">Belum ada kegiatan mendatang</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <p class="h6 m-0 font-weight-bold text-primary">Partisipan Terbaru</p>
                    <a href="{{ url('/admin/pendaftaran') }}" class="small">Lihat Semua</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0">
                            <thead>
                                <tr>
                                    <th>Gugus Depan</th>
                                    <th>Kegiatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($partisipanTerbaru as $partisipan)
                                    <tr>
                                        <td>{{ $partisipan->gudep->name ?? '-' }}</td>
                                        <td>{{ $partisipan->kegiatan->title ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center">Belum ada partisipan</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
