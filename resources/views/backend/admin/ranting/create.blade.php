@extends('layouts.admin')

@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('main-content')
    <h2>Data Ranting</h2>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <p class="h5">Tambah Data Ranting</p>
                </div>
                <div class="card-body">
                    {{-- <form action="{{ url('/admin/data/ranting/store') }}" method="POST">
                        @csrf --}}
                        <div class="form-group">
                            <label for="kecamatan">Nama Ranting</label>
                                <select class="kecamatan form-control" id="kecamatan" name="kecamatan">
                                </select>
                        </div>
                        <div class="form-group">
                            <label for="nokwaranting">Nomor Kwaran Ranting</label>
                            <input class="form-control" id="nokwaranting" name="nokwaranting" required value="01.06.">
                        </div>
                        <div class="form-group">
                            <label for="ketuakwaranting">Ketua Kwaran Ranting</label>
                            <input class="form-control" id="ketuakwaranting" name="ketuakwaranting">
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
        $(document).ready(function() {
            $('.kecamatan').select2({
                placeholder: 'Pilih Ranting Berdasarkan Kecamatan',
                allowClear: true,
                minimumInputLength: 1,
                ajax: {
                    url: function (params) {
                        return '/admin/data/ranting/datakecamatan?name=' + encodeURIComponent(params.term || '');
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
                                    id: item.code,   // WAJIB unique
                                    text: item.name // WAJIB ada
                                };
                            })
                        };
                    },

                    cache: true
                }
            });
        });

        $('#store').click(function (e) { 
            e.preventDefault();
            let selectedkecamatan = $('.kecamatan').select2('data');
            let kecamatan_code = '';
            let kecamatan_name = '';

            let nokwaranting = $('#nokwaranting').val();
            let ketuakwaranting = $('#ketuakwaranting').val();
            
            if (selectedkecamatan.length > 0) {
                kecamatan_code = selectedkecamatan[0].id;
                kecamatan_name = selectedkecamatan[0].text;
            }
        });
        
        
    </script>
    
@endpush