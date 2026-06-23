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
                    <p class="h5">Data Kegiatan</p>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped table-responsive w-100" id="dataTable">
                        <thead>
                            <tr>
                                <th>Tanggal Kegiatan</th>
                                <th>Nama Kegiatan</th>
                                <th>Nama Gudep</th>
                                <th>Status</th>                                
                                <th>Kesiapan</th>                                
                                <th>Menu</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Tanggal Kegiatan</th>
                                <th>Nama Kegiatan</th>
                                <th>Nama Gudep</th>
                                <th>Status</th>                                
                                <th>Kesiapan</th>                                
                                <th>Menu</th>
                            </tr>
                        </tfoot>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-create" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Form Partisipasi Kegiatan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="kegiatans_id" id="kegiatans_id">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="file_pendaftaran_name">Form Pendaftaran / Ikut Serta</span>
                    </div>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="file_pendaftaran" aria-describedby="file_pendaftaran_name">
                        <label class="custom-file-label" for="file_pendaftaran">Choose file</label>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-x"></i></button>
                <button type="button" class="btn btn-primary font-weight-bolder" id="store">Partisipasi <i class="fa fa-send"></i></button>
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
                url: "/user/pendaftaran/datatable",
                //   type: 'GET'
                },
                columns: [
                    { data: 'date', name: 'date' },
                    { data: 'title', name: 'title' },
                    { data: 'gudep', name: 'gudep' },
                    { data: 'status', name: 'status' },
                    { data: 'readiness', name: 'readiness' },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                ],
                order: [[0, 'asc']],
            });

            $('body').on('click', '#btn-partisipan', function () {
                $('#modal-create').modal('show');

                var id = $(this).data('id');

                $('#kegiatans_id').val(id);

                $('#file_pendaftaran').on('change', function() {
                    // ambil nama file yang dipilih
                    let fileName = $(this).val().split('\\').pop(); 
                    // ganti teks label di sebelah input
                    $(this).next('.custom-file-label').text(fileName || 'New Thumbnail');
                });

            });


            $('#store').click(function (e) { 
                e.preventDefault();
                let kegiatans_id = $('#kegiatans_id').val();
                let gudeps_id = "{{ Auth::user()->gudep->first()->id }}";
                let token   = $("meta[name='csrf-token']").attr("content");
                let file_pendaftaran = $('#file_pendaftaran')[0].files[0];

                var formData = new FormData();

                formData.append('_token', token);
                formData.append('kegiatans_id', kegiatans_id);
                formData.append('gudeps_id', gudeps_id);
                file_pendaftaran ? formData.append('file_pendaftaran', file_pendaftaran) : '';

                $.ajax({
                    type: "post",
                    url: "/user/pendaftaran/pendaftaran-join",
                    data: formData,
                    processData: false, // penting! biar jQuery tidak ubah ke query string
                    contentType: false, // penting! biar browser set Content-Type otomatis
                    success: function (response) {
                        console.log(response);
                        $('#dataTable').DataTable().ajax.reload();
                        $('#modal-create').modal('hide');

                        $('#file_pendaftaran').val('');

                        swal.fire({
                            icon: `${response.icon}`,
                            title: `${response.title}`,
                            text: `${response.text}`,
                            showConfirmButton: false,
                            timer: 3000
                        });
                    }, error: function (error) {
                        console.log(error);

                        error.responseJSON.file_pendaftaran ? toastr.warning(error.responseJSON.file_pendaftaran[0]) : '';

                        if (error.responseJSON.kegiatans_id) {
                            swal.fire({
                                icon: `warning`,
                                title: `Partisipasi Kegiatan`,
                                text: `Anda telah berpartisipasi!`,
                                showConfirmButton: false,
                                timer: 3000
                            });
                        }
                    }
                });
            });

            // $('body').on('click', '#btn-partisipan', function () {

            //     let kegiatans_id = $(this).data('id');
            //     let gudeps_id = "{{ Auth::user()->gudep->first()->id }}";
            //     let token   = $("meta[name='csrf-token']").attr("content");

            //     Swal.fire({
            //         icon: 'success',
            //         title: 'Apakah Kamu Yakin?',
            //         text: "akan berpartisipasi pada kegiatan ini!",
            //         showCancelButton: true,
            //         cancelButtonText: 'TIDAK',
            //         confirmButtonText: 'YA, BERPARTISIPASI!'
            //     }).then((result) => {
            //         // console.log(result);
            //         console.log(kegiatans_id);
            //         console.log(gudeps_id);
                    
            //         if (result.isConfirmed) {
            //             $.ajax({
            //                 type: "post",
            //                 url: "/user/pendaftaran/pendaftaran-join",
            //                 data: {
            //                     kegiatans_id: kegiatans_id,
            //                     gudeps_id: gudeps_id,
            //                     _token: token,
            //                 },
            //                 success: function (response) {
            //                     console.log(response);
            //                     $('#dataTable').DataTable().ajax.reload();
            //                     swal.fire({
            //                         icon: `${response.icon}`,
            //                         title: `${response.title}`,
            //                         text: `${response.text}`,
            //                         showConfirmButton: false,
            //                         timer: 3000
            //                     });
            //                 }, error: function (error) {
            //                     console.log(error);

            //                     if (error.responseJSON.kegiatans_id) {
            //                         swal.fire({
            //                             icon: `warning`,
            //                             title: `Partisipasi Kegiatan`,
            //                             text: `Anda telah berpartisipasi!`,
            //                             showConfirmButton: false,
            //                             timer: 3000
            //                         });
            //                     }
            //                 }
            //             });
            //         }
            //     })
            // });
            
            
        });

    </script>
@endpush