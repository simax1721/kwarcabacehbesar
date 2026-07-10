@extends('layouts.admin')

@push('css')
    <link href="{{ url('') }}/adminvendor/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush

@section('main-content')
    <h2>Partisipan Kegiatan</h2>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <p class="h5">Data Pendaftaran Gugus Depan pada Kegiatan</p>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped table-responsive w-100" id="dataTable">
                        <thead>
                            <tr>
                                <th>Kegiatan</th>
                                <th>Tanggal Kegiatan</th>
                                <th>Gugus Depan</th>
                                <th>Ranting</th>
                                <th>Form Pendaftaran</th>
                                <th>Kesiapan Berkas</th>
                                <th>Menu</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Kegiatan</th>
                                <th>Tanggal Kegiatan</th>
                                <th>Gugus Depan</th>
                                <th>Ranting</th>
                                <th>Form Pendaftaran</th>
                                <th>Kesiapan Berkas</th>
                                <th>Menu</th>
                            </tr>
                        </tfoot>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
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
                    url: "{{ url('/admin/pendaftaran/datatable') }}",
                },
                columns: [
                    { data: 'kegiatan', name: 'kegiatan' },
                    { data: 'tanggal_kegiatan', name: 'tanggal_kegiatan' },
                    { data: 'gudep', name: 'gudep' },
                    { data: 'ranting', name: 'ranting' },
                    { data: 'file_pendaftaran', name: 'file_pendaftaran', orderable: false, searchable: false },
                    { data: 'readiness', name: 'readiness', orderable: false, searchable: false },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                ],
                order: [[1, 'desc']],
            });
        });
    </script>
@endpush
