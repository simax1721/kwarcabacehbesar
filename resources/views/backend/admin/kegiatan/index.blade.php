@extends('layouts.admin')

@push('css')
    <link href="{{ url('') }}/adminvendor/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush

@section('main-content')
    <h2>Data Kegiatan</h2>

    <div class="mt-3 mb-3">
        <a href="{{ url('/admin/data/kegiatan/create') }}" class="btn btn-primary w-100" id="btn-create">
            <i class="icon fas fa-plus pr-1"></i> Tambah Data Kegiatan
        </a>
    </div>


    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Judul Kegiatan</th>
                        <th>Tanggal</th>
                        <th>Thumbnail</th>
                        <th>Deskripsi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Judul Kegiatan</th>
                        <th>Tanggal</th>
                        <th>Thumbnail</th>
                        <th>Deskripsi</th>
                        <th>Aksi</th>
                    </tr>
                </tfoot>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ url('') }}/adminvendor/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ url('') }}/adminvendor/vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#dataTable').DataTable({
                processing : true,
                serverSide : true,
                ajax : {
                url: "/admin/data/kegiatan/datatable",
                //   type: 'GET'
                },
                columns: [
                    { data: 'title', name: 'title' },
                    { data: 'date', name: 'date' },
                    { data: 'thumbnail', name: 'thumbnail' },
                    { data: 'description', name: 'description' },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                ],
                order: [[0, 'asc']],
            });
        });
    </script>
@endpush