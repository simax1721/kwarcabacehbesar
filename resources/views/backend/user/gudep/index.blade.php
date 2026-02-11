@extends('layouts.admin')

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
                                            <input class="form-control" id="nogudeppa" name="nogudeppa" placeholder="01.01" value="{{ Auth::user()->gudep[0]->nogudeppa }}" readonly>
                                        </div>
                                        
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nogudeppi" class="text-white">Nomor Gudep</label>
                                            <input class="form-control" id="nogudeppi" name="nogudeppi" placeholder="01.02" value="{{ Auth::user()->gudep[0]->nogudeppi }}" readonly>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="text-white">Nama Gugus Depan</label>
                                    <input class="form-control" id="name" name="name" placeholder="01.02" value="{{ Auth::user()->gudep[0]->name }}" readonly>
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
                                    <input class="form-control" id="npsn" name="npsn" readonly value="{{ Auth::user()->gudep[0]->npsn }}">
                                </div>
                                
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="grade">Jentang</label>
                                    <input class="form-control" id="grade" name="grade" readonly value="{{ Auth::user()->gudep[0]->grade }}">
                                </div>
                                
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <input class="form-control" id="status" name="status" readonly value="{{ Auth::user()->gudep[0]->status }}">
                                </div>
                                
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="ranting">Ranting</label>
                                    <input class="form-control" id="ranting" name="ranting" readonly value="{{ Auth::user()->gudep[0]->district_name }}">
                                </div>
                                
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input class="form-control" type="email" id="email" name="email" value="{{ Auth::user()->gudep[0]->email }}">
                                </div>
                                
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="kepsek">Kepala Sekolah</label>
                                    <input class="form-control" type="text" id="kepsek" name="kepsek" value="{{ Auth::user()->gudep[0]->kepsek }}">
                                </div>
                                
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="address">Alamat</label>
                                    <textarea class="form-control" id="address" name="address" readonly>{{ Auth::user()->gudep[0]->address }}</textarea>
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
    <script>
        

        $('#update').click(function (e) { 
            e.preventDefault();
            let id = "{{ Auth::user()->gudep[0]->id }}";
            let email = $('#email').val();
            let nogudeppa = $('#nogudeppa').val();
            let nogudeppi = $('#nogudeppi').val();
            let kepsek = $('#kepsek').val();
            let address = $('#address').val();

            $.ajax({
                url: "/user/data/gudep/update/" + id,
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
                    toastr.success('Data gugus depan berhasil perbaharui');
                },
                error: function(xhr, status, error) {
                    console.error(xhr);

                    xhr.responseJSON.email?.[0] && toastr.error(xhr.responseJSON.email?.[0]);
                    xhr.responseJSON.kepsek?.[0] && toastr.error(xhr.responseJSON.kepsek?.[0]);

                    
                }
            });
        });

    </script>
@endpush