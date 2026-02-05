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
                    <p class="h5">Edit Data Gugus Depan</p>
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
                                            <input class="form-control" id="nogudeppa" name="nogudeppa" placeholder="01.01" value="{{ $gudep->nogudeppa }}">
                                        </div>
                                        
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nogudeppi" class="text-white">Nomor Gudep</label>
                                            <input class="form-control" id="nogudeppi" name="nogudeppi" placeholder="01.02" value="{{ $gudep->nogudeppi }}">
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="text-white">Nama Gugus Depan</label>
                                    <input class="form-control" id="name" name="name" placeholder="01.02" value="{{ $gudep->name }}" readonly>
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
                                    <input class="form-control" id="npsn" name="npsn" readonly value="{{ $gudep->npsn }}">
                                </div>
                                
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="grade">Jentang</label>
                                    <input class="form-control" id="grade" name="grade" readonly value="{{ $gudep->grade }}">
                                </div>
                                
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <input class="form-control" id="status" name="status" readonly value="{{ $gudep->status }}">
                                </div>
                                
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="ranting">Ranting</label>
                                    <input class="form-control" id="ranting" name="ranting" readonly value="{{ $gudep->district_name }}">
                                </div>
                                
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input class="form-control" type="email" id="email" name="email" value="{{ $gudep->email }}">
                                </div>
                                
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="kepsek">Kepala Sekolah</label>
                                    <input class="form-control" type="text" id="kepsek" name="kepsek" value="{{ $gudep->kepsek }}">
                                </div>
                                
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="address">Alamat</label>
                                    <textarea class="form-control" id="address" name="address" readonly>{{ $gudep->address }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                
                            </div>
                        </div>
                        {{-- <div class="form-group">
                            <label for="alamat">Alamat Ranting</label>
                            <textarea class="form-control" id="alamat" name="alamat"></textarea>
                        </div> --}}

                        <button type="button" class="btn btn-success" id="update">Perbarui</button>
                    {{-- </form> --}}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        

        $('#update').click(function (e) { 
            e.preventDefault();
            let id = "{{ $gudep->id }}";
            let email = $('#email').val();
            let nogudeppa = $('#nogudeppa').val();
            let nogudeppi = $('#nogudeppi').val();
            let kepsek = $('#kepsek').val();
            let address = $('#address').val();

            $.ajax({
                url: "/admin/data/gudep/update",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id,
                    nogudeppa: nogudeppa,
                    nogudeppi: nogudeppi,
                    email: email,
                    kepsek: kepsek,
                    address: address
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success('Data gugus depan berhasil perbaharui');
                        window.location.href = '/admin/data/gudep';
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });

    </script>
    
@endpush