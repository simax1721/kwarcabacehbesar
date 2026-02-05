@extends('layouts.admin')

@push('css')
    <link href="{{ url('') }}/adminvendor/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush


@section('main-content')
    <h2>Data Ranting</h2>

    <div class="mt-3 mb-3">
        <a href="{{ url('/admin/data/ranting/create') }}" class="btn btn-primary w-100" id="btn-create">
            <i class="icon fas fa-plus pr-1"></i> Tambah Data Ranting
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        {{-- <th>No.</th> --}}
                        <th>No. Kwaran Ranting</th>
                        <th>Nama Ranting</th>
                        <th>Ketua Kwaran Ranting</th>
                        <th>Total Gugus Depan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        {{-- <th>No.</th> --}}
                        <th>No. Kwaran Ranting</th>
                        <th>Nama Ranting</th>
                        <th>Ketua Kwaran Ranting</th>
                        <th>Total Gugus Depan</th>
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
    //Call the dataTables jQuery plugin
    $(document).ready(function() {
        $('#dataTable').DataTable({
        processing : true,
        serverSide : true,
        ajax : {
          url: "{{ url('/admin/data/ranting/datatable') }}",
        //   type: 'GET'
        },
        columns: [
        //   { data: 'DT_RowIndex', orderable: false, searchable: false },
          { data: 'nokwaranting', name: 'nokwaranting' },
          { data: 'name', name: 'name' },
          { data: 'ketuakwaranting', name: 'ketuakwaranting' },
          { data: 'total_gudep', name: 'total_gudep' },
          { data: 'action', name: 'action', orderable: false, searchable: false },
        ],
        order: [[0, 'asc']]
      });

    });
  </script>

@endpush