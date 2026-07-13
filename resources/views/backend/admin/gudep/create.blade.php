@extends('layouts.admin')

@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('main-content')
    <h2>Data Gugus Depan</h2>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <p class="h5">Tambah Data Gugus Depan</p>
                </div>
                <div class="card-body">
                    {{-- <form action="{{ url('/admin/data/gudep/store') }}" method="POST">
                        @csrf --}}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nogudeppa">Nomor Gudep</label>
                                            <input class="form-control" id="nogudeppa" name="nogudeppa" placeholder="01.01" >
                                        </div>
                                        
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nogudeppi" class="text-white">Nomor Gudep</label>
                                            <input class="form-control" id="nogudeppi" name="nogudeppi" placeholder="01.02" >
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="sekolah">Nama Gugus Depan</label>
                                        <select class="sekolah form-control" id="sekolah" name="sekolah"></select>
                                </div>
                                
                            </div>
                            {{-- <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nogudep">Nomor Gugus Depan</label>
                                    <input class="form-control" id="nogudep" name="nogudep" required value="01.06.">
                                </div>
                                
                            </div> --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="npsn">Nomor Sekolah (npsn)</label>
                                    <input class="form-control" id="npsn" name="npsn" readonly>
                                </div>
                                
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="grade">Jentang</label>
                                    <input class="form-control" id="grade" name="grade" readonly>
                                </div>
                                
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <input class="form-control" id="status" name="status" readonly>
                                </div>
                                
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="ranting">Ranting</label>
                                    <input class="form-control" id="ranting" name="ranting" readonly>
                                </div>
                                
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input class="form-control" type="email" id="email" name="email">
                                </div>
                                
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="kepsek">Kepala Sekolah</label>
                                    <input class="form-control" type="text" id="kepsek" name="kepsek">
                                </div>
                                
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="address">Alamat</label>
                                    <textarea class="form-control" id="address" name="address" readonly></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="image">Foto Gugus Depan</label>
                                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                    <small class="form-text text-muted">Format: JPG/PNG, maksimal 2MB.</small>
                                    <div class="mt-2">
                                        <img id="image-preview" src="" alt="Preview" style="display:none; max-width:200px; max-height:200px; border-radius:6px;" class="border">
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="form-group">
                            <label for="alamat">Alamat Ranting</label>
                            <textarea class="form-control" id="alamat" name="alamat"></textarea>
                        </div> --}}

                        <button type="button" class="btn btn-success" id="store">Simpan</button>
                    {{-- </form> --}}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        let save_data = new FormData();

        $('.sekolah').select2({
            placeholder: 'Pilih Gugus Depan Berdasarkan Sekolah',
            allowClear: true,
            minimumInputLength: 1,
            ajax: {
                url: function (params) {
                    return '/admin/data/gudep/datasekolah?name=' + encodeURIComponent(params.term || '');
                },
                dataType: 'json',
                delay: 300,

                data: function (params) {
                    return {
                        term: params.term
                    };
                },

                processResults: function (response) {
                    return {
                        results: response.data.map(function (item) {
                            return {
                                id: item.npsn,   // WAJIB unique
                                text: item.name // WAJIB ada
                            };
                        })
                    };
                },

                cache: true
            }
        });

        function getDetailSekolah(npsn) {
            $.ajax({
                url: '/admin/data/gudep/detailsekolah',
                type: 'GET',
                data: { npsn },
                dataType: 'json',
                success: function (res) {
                    let data = res.data[0];

                    $('#npsn').val(data.npsn);
                    $('#grade').val(data.grade);
                    $('#status').val(data.status);
                    $('#ranting').val(data.district_name);
                    $('#address').val(data.address);

                $.get(`/admin/data/ranting/show/${data.district_code}`, data,
                    function (data, textStatus, jqXHR) {
                        $('#nogudeppa').val(data.nokwaranting + '.');
                        $('#nogudeppi').val(data.nokwaranting + '.');
                    },
                    "json"
                );


                    save_data = new FormData(); // 🔥 reset

                    save_data.append('npsn', data.npsn);
                    save_data.append('name', data.name);
                    save_data.append('grade', data.grade);
                    save_data.append('status', data.status);
                    save_data.append('accreditation', data.accreditation);
                    save_data.append('address', data.address);
                    save_data.append('province_code', data.province_code);
                    save_data.append('province_name', data.province_name);
                    save_data.append('regency_code', data.regency_code);
                    save_data.append('regency_name', data.regency_name);
                    save_data.append('district_code', data.district_code);
                    save_data.append('district_name', data.district_name);
                    save_data.append('lang', data.lang);   // 🔧 typo fix
                    save_data.append('long', data.long);
                }
            });
        }

        $('#sekolah').on('select2:select', function (e) {
            let data = e.params.data;
            let npsn = data.id;
            
            console.log(npsn);
            
            // panggil API detail sekolah
            getDetailSekolah(npsn);
        });

        $('#sekolah').on('select2:clear', function () {
            $('#npsn, #grade, #status, #email, #ranting, #address').val('');
            save_data = new FormData();
        });


        $('#image').on('change', function (e) {
            let file = e.target.files[0];
            if (file) {
                let reader = new FileReader();
                reader.onload = function (ev) {
                    $('#image-preview').attr('src', ev.target.result).show();
                };
                reader.readAsDataURL(file);
            } else {
                $('#image-preview').hide();
            }
        });


        $('#store').click(function (e) { 
            e.preventDefault();

            save_data.append('nogudeppa', $('#nogudeppa').val());
            save_data.append('nogudeppi', $('#nogudeppi').val());
            save_data.append('email', $('#email').val());
            save_data.append('kepsek', $('#kepsek').val());
            save_data.append('_token', '{{ csrf_token() }}');

            let imageFile = $('#image')[0].files[0];
            if (imageFile) {
                save_data.append('image', imageFile);
            }

            $.ajax({
                type: 'POST',
                url: '/admin/data/gudep',
                data: save_data,
                processData: false,   // 🔥 WAJIB
                contentType: false,   // 🔥 WAJIB
                success: function (response) {
                    console.log(response);
                    toastr.success('Data gugus depan berhasil disimpan');
                    window.location.href = '/admin/data/gudep';
                },
                error: function (xhr) {
                    console.log(xhr);
                    xhr.responseJSON.nogudeppi ? toastr.error(xhr.responseJSON.nogudeppi[0]) : '';
                    xhr.responseJSON.nogudeppa ? toastr.error(xhr.responseJSON.nogudeppa[0]) : '';
                    xhr.responseJSON.name ? toastr.error(xhr.responseJSON.name[0]) : '';
                    xhr.responseJSON.npsn ? toastr.error(xhr.responseJSON.npsn[0]) : '';
                }
            });
        });
        
        
    </script>
    
@endpush