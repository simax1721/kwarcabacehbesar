@extends('layouts.admin')

@section('main-content')
    <a href="{{ url('/admin/pendaftaran') }}" class="btn btn-dark my-3"><i class="fas fa-reply"></i> kembali</a>

    <h1 class="h3">Detail Pendaftaran: {{ $kegiatan_partisipan->kegiatan->title ?? '-' }}</h1>

    <div class="row">
        <div class="col-12 mt-2">
            <div class="card">
                <div class="card-header">
                    <p class="h5 py-1 font-weight-bolder">Informasi Pendaftaran</p>
                </div>
                <div class="card-body">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <th style="width: 220px;">Nama Kegiatan</th>
                            <td>: {{ $kegiatan_partisipan->kegiatan->title ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Kegiatan</th>
                            <td>: {{ $kegiatan_partisipan->kegiatan && $kegiatan_partisipan->kegiatan->date ? date('d M Y', strtotime($kegiatan_partisipan->kegiatan->date)) : '-' }}</td>
                        </tr>
                        <tr>
                            <th>Gugus Depan</th>
                            <td>: {{ $kegiatan_partisipan->gudep->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Ranting</th>
                            <td>: {{ $kegiatan_partisipan->gudep->district_name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Form Pendaftaran</th>
                            <td>:
                                @if ($kegiatan_partisipan->file_pendaftaran)
                                    <a href="{{ url('uploads/file_pendaftaran/'.$kegiatan_partisipan->file_pendaftaran) }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                                        <i class="fas fa-file-pdf"></i> Lihat Berkas
                                    </a>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6 mt-4">
            <div class="card">
                <div class="card-header">
                    <p class="h5 py-1 font-weight-bolder">Data PA ({{ $anggota_pa->count() }})</p>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th style="width: 20px">No.</th>
                            <th>Nama</th>
                            <th>Kesertaan Sebagai</th>
                            <th>Berkas</th>
                        </tr>

                        @forelse ($anggota_pa as $agt_pa)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $agt_pa->name }}</td>
                                <td>{{ $agt_pa->is_pembina ? 'Pembina' : 'Anggota' }}</td>
                                <td>
                                    <a href="{{ url('uploads/file_pendaftaran/'.$agt_pa->file) }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                                        <i class="fas fa-file-pdf"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">Belum ada data PA</td>
                            </tr>
                        @endforelse
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6 mt-4">
            <div class="card">
                <div class="card-header">
                    <p class="h5 py-1 font-weight-bolder">Data PI ({{ $anggota_pi->count() }})</p>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th style="width: 20px">No.</th>
                            <th>Nama</th>
                            <th>Kesertaan Sebagai</th>
                            <th>Berkas</th>
                        </tr>

                        @forelse ($anggota_pi as $agt_pi)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $agt_pi->name }}</td>
                                <td>{{ $agt_pi->is_pembina ? 'Pembina' : 'Anggota' }}</td>
                                <td>
                                    <a href="{{ url('uploads/file_pendaftaran/'.$agt_pi->file) }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                                        <i class="fas fa-file-pdf"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">Belum ada data PI</td>
                            </tr>
                        @endforelse
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
