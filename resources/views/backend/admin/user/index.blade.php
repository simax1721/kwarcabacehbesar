@extends('layouts.admin')

@push('css')
    <link href="{{ url('') }}/adminvendor/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('main-content')
    <h2>Data User</h2>

    <div class="mt-3 mb-3">
        <a href="#" class="btn btn-primary w-100" id="btn-create">
            <i class="icon fas fa-plus pr-1"></i> Tambah Data User
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Nama Pengelola</th>
                        <th>Email Pengelola</th>
                        <th>Nama Gudep</th>
                        <th>Nomor Gudep</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Nama Pengelola</th>
                        <th>Email Pengelola</th>
                        <th>Nama Gudep</th>
                        <th>Nomor Gudep</th>
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

  <script>
    //Call the dataTables jQuery plugin
    $(document).ready(function() {
      $('#dataTable').DataTable({
        processing : true,
        serverSide : true,
        ajax : {
          url: "/admin/data/user/datatable",
        //   type: 'GET'
        },
        columns: [
            { data: 'user_name', name: 'user_name' },
            { data: 'user_email', name: 'user_email' },
            { data: 'gudep_name', name: 'gudep_name' },
            { data: 'gudep_nogudep', name: 'gudep_nogudep' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ],
        order: [[0, 'asc']],
      });
    });
  </script>

    <div class="modal fade" id="modal-create" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Form Tambah Prodi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name" class="control-label">Nama</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="email" class="control-label">Email</label>
                        <input type="text" class="form-control" id="email" name="email" placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="password" class="control-label">Password</label>
                        <input type="text" class="form-control" id="password" name="password" placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="gudep_id" class="control-label">Gugus Depan</label>
                        <select style="width: 100%" class="gudep_id form-control form-control-lg" id="gudep_id" name="gudep_id"></select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-x"></i></button>
                    <button type="button" class="btn btn-primary" id="store"><i class="fa fa-send"></i></button>
                </div>
            </div>
        </div>
    </div>

    <script>

    // Initialize Select2 for gudep_id dropdown
    $('.gudep_id').select2({
        placeholder: 'Pilih Gugus Depan',
        dropdownParent: $("#modal-create"),
        allowClear: true,
        minimumInputLength: 1,
        ajax: {
            url: function (params) {
                return '/admin/data/gudep/datakegudep?q=' + encodeURIComponent(params.term || '');
                
            },
            dataType: 'json',
            delay: 300,

            data: function (params) {
                return {
                    term: params.term
                };
            },
            processResults: function (results) {
                console.log(results);
                
                return {
                    results: $.map(results, function (item) {
                        return {
                            text: item.text,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        }
    });
        
    $('body').on('click', '#btn-create', function () {
        //open modal
        $('#modal-create').modal('show');
    });

    $('#store').click(function (e) { 
        e.preventDefault();
        var gudep_id = $('#gudep_id').val();
        var name = $('#name').val();
        var email = $('#email').val();
        var password = $('#password').val();

        $.ajax({
            type: "POST",
            url: "{{ url('/admin/data/user/store') }}",
            data: {
                '_token': '{{ csrf_token() }}',
                'gudep_id': gudep_id,
                'name': name,
                'email': email,
                'password': password,
            },
            success: function (response) {
                console.log(response);
                //close modal
                $('#email').val('');
                $('#name').val('');
                $('#password').val('');
                $('#gudep_id').val(null).trigger('change');
                $('#modal-create').modal('hide');
                
                //show success message
                Swal.fire({
                    icon: response.icon,
                    title: response.title,
                    text: response.text,
                });
                //refresh datatable
                $('#dataTable').DataTable().ajax.reload();
            },
            error: function (error) {
                console.log(error);
                error.responseJSON.gudep_id?.[0] ? toastr.error(error.responseJSON.gudep_id[0]) : '';
                error.responseJSON.password?.[0] ? toastr.error(error.responseJSON.password[0]) : '';  
                error.responseJSON.email?.[0] ? toastr.error(error.responseJSON.email[0]) : '';
                error.responseJSON.name?.[0] ? toastr.error(error.responseJSON.name[0]) : '';
            }   
        });
    });

    </script>

    <div class="modal fade" id="modal-edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Form Edit Role</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="users_id">
                <div class="form-group">
                    <label for="name_edit" class="control-label">Nama</label>
                    <input type="text" class="form-control" id="name_edit" name="name_edit" placeholder="">
                </div>
                <div class="form-group">
                    <label for="email_edit" class="control-label">Email</label>
                    <input type="text" class="form-control" id="email_edit" name="email_edit" placeholder="">
                </div>
                <div class="form-group">
                    <label for="password_edit" class="control-label">Password</label>
                    <input type="text" class="form-control" id="password_edit" name="password_edit" placeholder="********">
                </div>
                <div class="form-group">
                    <label for="gudep_edit" class="control-label">Gugus Depan</label>
                    <input type="text" class="form-control" id="gudep_edit" name="gudep_edit" readonly placeholder="">
                </div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-x"></i></button>
                <button type="button" class="btn btn-primary" id="update"><i class="fa fa-send"></i></button>
            </div>
            </div>
        </div>
        </div>

        <script>
        $('body').on('click', '#btn-edit', function () {
            let data_id = $(this).data('id');
            //fetch detail data with ajax
            $.ajax({
                url: `{{ url('admin/data/user/show/${data_id}') }}`,
                type: "GET",
                cache: false,
                success:function(response){
                    console.log(response);
                    $('#users_id').val(response.id);
                    $('#name_edit').val(response.name);
                    $('#email_edit').val(response.email);
                    $('#gudep_edit').val(response.gudep[0].nogudeppa + ' - ' + response.gudep[0].nogudeppi + ' - ' + response.gudep[0].name);
                    //open modal
                    $('#modal-edit').modal('show');
                },
                error: function (error) { 
                    console.log(error);
                    alert('Something went wrong!');
                }
            });
        });

        $('#update').click(function (e) { 
            e.preventDefault();
            let users_id = $('#users_id').val();
            let name = $('#name_edit').val();
            let email = $('#email_edit').val();
            let password = $('#password_edit').val();
            

            $.ajax({
                url: `{{ url('admin/data/user/update/${users_id}') }}`,
                type: "post",
                cache: false,
                data: {
                    '_token': '{{ csrf_token() }}',
                    'name': name,
                    'email': email,
                    'password': password,
                },
                success:function(response){ 
                    console.log(response);
                    //close modal
                    $('#modal-edit').modal('hide');
                    //show success message
                    Swal.fire({
                        icon: response.icon,
                        title: response.title,
                        text: response.text,
                    });
                    //refresh datatable
                    $('#dataTable').DataTable().ajax.reload();
                },
                error: function (error) { 
                    console.log(error);
                    error.responseJSON.password?.[0] ? toastr.error(error.responseJSON.password[0]) : '';  
                    error.responseJSON.email?.[0] ? toastr.error(error.responseJSON.email[0]) : '';
                    error.responseJSON.name?.[0] ? toastr.error(error.responseJSON.name[0]) : '';
                }
            });
        });

        $('body').on('click', '#btn-delete', function () {
            // e.preventDefault();
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
                  url: `{{ url('admin/data/user/delete/${data_id}') }}`,
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
                      title: `User`,
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