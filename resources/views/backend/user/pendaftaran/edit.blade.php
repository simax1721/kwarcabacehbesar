@extends('layouts.admin')

@section('main-content')
    <a href="/user/pendaftaran" class="btn btn-dark my-3"><i class="fas fa-reply"></i> kembali</a>
    <h1 class="h3">Kelola Anggota Kegiatan: {{ $kegiatan->title }}</h1>


    <a href="#" class="btn btn-primary btn-block" id="add_partisipan">Tambah Peserta</a>

    <div class="row">
        <div class="col-md-6 mt-4">
        <div class="card">
            <div class="card-header">
                <p class="h5 py-1 font-weight-bolder">Data PA</p>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th style="width: 20px">No.</th>
                        <th>Nama</th>
                        <th>Kesertaan Sebagai</th>
                        <th></th>
                    </tr>

                    @php
                        $no = 1
                    @endphp
                    @foreach ($anggota_pa as $agt_pa)
                    
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td><a href="{{ url('uploads/file_pendaftaran/'.$agt_pa->file) }}" target="_blank">{{ $agt_pa->name }}</a></td>
                            <td>{{ $agt_pa->is_pembina ? 'Pembina' : 'Anggota' }}</td>
                            <td class="">
                                {{-- <a href="#" class="btn btn-info btn-sm">Edit</a> --}}
                                <a href="#" id="btn-delete-agt" data-agtid="{{ $agt_pa->id }}" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>  
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 mt-4">
        <div class="card">
            <div class="card-header">
                <p class="h5 py-1 font-weight-bolder">Data PI</p>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th style="width: 20px">No.</th>
                        <th>Nama</th>
                        <th>Kesertaan Sebagai</th>
                        <th></th>
                    </tr>

                    @php
                        $no = 1
                    @endphp
                    @foreach ($anggota_pi as $agt_pi)
                    
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td><a href="{{ url('uploads/file_pendaftaran/'.$agt_pi->file) }}" target="_blank">{{ $agt_pi->name }}</a></td>
                            <td>{{ $agt_pi->is_pembina ? 'Pembina' : 'Anggota' }}</td>
                            <td class="">
                                {{-- <a href="#" class="btn btn-info btn-sm">Edit</a> --}}
                                <a href="#" id="btn-delete-agt" data-agtid="{{ $agt_pi->id }}" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>  
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    </div>

    <div class="modal fade" id="modal-create" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Form Partisipasi Anggota</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-4">
                            <div class="custom-control custom-radio">
                                <input type="radio" id="is_pa" name="data_pa_pi" value="is_pa" class="custom-control-input">
                                <label class="custom-control-label" for="is_pa">DATA PA</label>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="custom-control custom-radio">
                                <input type="radio" id="is_pi" name="data_pa_pi" value="is_pi" class="custom-control-input">
                                <label class="custom-control-label" for="is_pi">DATA PI</label>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-name">Nama</span>
                        </div>
                        <input type="text" id="add_name" class="form-control" placeholder="Nama Lengkap" aria-label="Nama Lengkap" aria-describedby="basic-name">
                    </div>
                    
                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="add_pembina" name="add_pembina">
                        <label class="form-check-label" for="add_pembina">PENDAMPING</label>
                    </div>

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="add_berkas_name">Berkas</span>
                        </div>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="add_berkas" aria-describedby="add_berkas_name">
                            <label class="custom-file-label" for="berkas">Choose file</label>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-x"></i></button>
                    <button type="button" class="btn btn-primary font-weight-bolder" id="store">Tambah <i class="fa fa-send"></i></button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
         $('body').on('click', '#add_partisipan', function () {
                $('#modal-create').modal('show');

                $('#add_berkas').on('change', function() {
                    // ambil nama file yang dipilih
                    let fileName = $(this).val().split('\\').pop(); 
                    // ganti teks label di sebelah input
                    $(this).next('.custom-file-label').text(fileName || 'New Thumbnail');
                });

            });

            $('#store').click(function (e) { 
                e.preventDefault();
                let token   = $("meta[name='csrf-token']").attr("content");

                let kegiatans_id = "{{ $kegiatan->id }}";
                let kegiatan_partisipans_id = "{{ $kegiatan_partisipan->id }}";
                // let gudeps_id = "{{ Auth::user()->gudep->first()->id }}";
                let name = $('#add_name').val();

                let data_pa_pi = $('input[name="data_pa_pi"]:checked').val();
                
                if (!data_pa_pi) return toastr.warning('DATA PA / PI harus dipilih!');
                let pembina = $('#add_pembina').is(':checked');

                let add_berkas = $('#add_berkas')[0].files[0];
                

                var formData = new FormData();

                formData.append('_token', token);
                formData.append('kegiatans_id', kegiatans_id);
                formData.append('kegiatan_partisipans_id', kegiatan_partisipans_id);
                // formData.append('gudeps_id', gudeps_id);
                formData.append('name', name);
                add_berkas ? formData.append('add_berkas', add_berkas) : '';
                data_pa_pi == 'is_pa' ? formData.append('is_pa', true) : formData.append('is_pi', true);
                formData.append('is_pembina', pembina);

                console.log([...formData.entries()]);
                
                $.ajax({
                    url: '/user/pendaftaran/add-anggota',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        console.log(response);

                        swal.fire({
                            icon: `${response.icon}`,
                            title: `${response.title}`,
                            text: `${response.text}`,
                            showConfirmButton: false,
                            timer: 3000
                        });
                        location.reload();
                        
                    },
                    error: function(error) {
                        console.log(error);

                        error.responseJSON.add_berkas ? toastr.warning(error.responseJSON.add_berkas[0]) : '';
                        error.responseJSON.name ? toastr.warning(error.responseJSON.name[0]) : '';
                    }
                });
            });

            $('body').on('click', '#btn-delete-agt', function () {
                // e.preventDefault();
                let data_id = $(this).data('agtid');

                console.log(data_id);
                
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
                    url: `{{ url('/user/pendaftaran/delete-anggota/${data_id}') }}`,
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
                        // $('#dataTable').DataTable().ajax.reload();
                        location.reload();
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