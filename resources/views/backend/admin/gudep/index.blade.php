@extends('layouts.admin')

@push('css')
    <link href="{{ url('') }}/adminvendor/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush


@section('main-content')
    <h2>Data Gugus Depan</h2>

    <div class="mt-3 mb-3">
        <a href="{{ url('/admin/data/gudep/create') }}" class="btn btn-primary w-100" id="btn-create">
            <i class="icon fas fa-plus pr-1"></i> Tambah Data Gugus Depan
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No Gudep</th>
                        <th>Ranting</th>
                        <th>Nama Gudep</th>
                        <th>Jenjang</th>
                        <th>Kepala Sekolah</th>
                        <th>Foto</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>No Gudep</th>
                        <th>Ranting</th>
                        <th>Nama Gudep</th>
                        <th>Jenjang</th>
                        <th>Kepala Sekolah</th>
                        <th>Foto</th>
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
          url: "{{ url('/admin/data/gudep/datatable') }}",
        //   type: 'GET'
        },
        columns: [
          {data:'nogudep',name:'nogudep'},
          {data:'ranting',name:'ranting'},
          {data:'namagudep',name:'namagudep'},
          {data:'jenjang',name:'jenjang'},
          {data:'kepsek',name:'kepsek'},
          {data:'foto',name:'foto', orderable: false, searchable: false},
          {data:'action',name:'action', orderable: false, searchable: false},
        ],
        order: [[0, 'desc']]
      });
    });

  </script>

	<script>
    $('body').on('click', '#btn-delete', function () {
    let data_id = $(this).data('id');
    let token   = $("meta[name='csrf-token']").attr("content");
    Swal.fire({
      icon: 'warning',
      title: 'Apakah Kamu Yakin?',
      text: "ingin menghapus data ini!",
      showCancelButton: true,
      cancelButtonText: 'TIDAK',
      confirmButtonText: 'YA, HAPUS!'
    }).then((result) => {
      if (result.isConfirmed) {
        console.log('test');
        //fetch to delete data
        $.ajax({
          url: `{{ url('admin/data/gudep/${data_id}') }}`,
          type: "DELETE",
          cache: false,
          data: {
            "_token": token
          },
          success:function(response){ 
            //show success message
            swal.fire({
              icon: `${response.icon}`,
              title: `${response.title}`,
              text: `${response.text}`,
              showConfirmButton: false,
              timer: 3000
            });
            //remove post on table
            $('#dataTable').DataTable().ajax.reload();
          },
          error: function (error) { 
            console.log(error);
            swal.fire({
              icon: `error`,
              title: `Gudep`,
              text: `Data Belum Bisa Dihapus!`,
              showConfirmButton: false,
              timer: 3000
            });
          }
        });          
      }
    })

    });
  </script>
@endpush