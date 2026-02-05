@extends('layouts.frondend')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.6/css/dataTables.bootstrap5.css">
@endpush

@section('breadcrumbs')
    <div class="breadcrumbs">
      <div class="page-header d-flex align-items-center" style="background-image: url('');">
        <div class="container position-relative">
          <div class="row d-flex justify-content-center">
            <div class="col-lg-6 text-center">
              <h2>Informasi Gugus Depan</h2>
              <p></p>
            </div>
          </div>
        </div>
      </div>
      <nav>
        <div class="container">
          <ol>
            <li><a href="{{ url('') }}">Home</a></li>
            <li>Informasi Gugus Depan</li>
          </ol>
        </div>
      </nav>
    </div><!-- End Breadcrumbs -->
@endsection

@section('main-content')
    <div class="container">
        <div class="row my-5">
            <div class=" col-md-5">
                <div class="form-group mb-2">
                    <label for="name">Kata Kunci</label>
                    <input type="text" name="name" id="name" class="form-control">
                </div>

                <div class="form-group mb-2">
                    <label for="name">Ranting</label>
                    <select name="ranting" id="ranting" class="form-control">
                        <option value="">--</option>
                        @foreach ($rantings as $ran)
                            <option value="{{ $ran->code }}">{{ $ran->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class=" col-md-5">
                <div class="form-group mb-2">
                    <label for="name">Jenjang Pendidikan</label>
                    <select name="grade" id="grade" class="form-control">
                        <option value="">--</option>
                        <option value="SD">Sekolah Dasar (SD)</option>
                        <option value="MI">Madrasah Ibtidaiyah (MI)</option>
                        <option value="SMP">Sekolah Menengah Pertama (SMP)</option>
                        <option value="MTs">Madrasah Tsanawiyah (MTs)</option>
                        <option value="SMA">Sekolah Menengah Atas (SMA)</option>
                        <option value="MA">Madrasah Aliyah (MA)</option>
                        <option value="SMK">Sekolah Menengah Kejuruan (SMK)</option>
                        <option value="MAK">Madrasah Aliyah Kejuruan (MAK)</option>
                        <option value="PKBM">Pusat Kegiatan Belajar Masyarakat (PKBM)</option>
                        <option value="PLB">Pendidikan Luar Biasa (PLB)</option>
                        <option value="PT">Perguruan Tinggi (PT)</option>
                    </select>
                </div>
                <div class="form-group mb-2">
                    <label for="status">Status Sekolah</label>
                    <select name="status" id="status" class="form-control">
                        <option value="">--</option>
                        <option value="N">Negeri</option>
                        <option value="S">Swasta</option>
                    </select>
                </div>
            </div>
            <div class="col-md-2 align-items-end d-flex mb-2">
                <button class="btn btn-primary fw-bolder">Cari</button>
            </div>
        </div>

        <div class="row my-5">
            <div class="col-12">
                <hr>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="dataTableGugusDepan">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>No. Gugus Depan</th>
                            <th>Ranting</th>
                            <th>Nama Gugus Depan</th>
                            <th>Jenjang</th>
                            <th>Status</th>
                            <th>Kepala Sekolah</th>
                            <th>Alamat</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                        
                    <tfoot>
                        <tr>
                            <th>No.</th>
                            <th>No. Gugus Depan</th>
                            <th>Ranting</th>
                            <th>Nama Gugus Depan</th>
                            <th>Jenjang</th>
                            <th>Status</th>
                            <th>Kepala Sekolah</th>
                            <th>Alamat</th>
                        </tr>
                    </tfoot>
                </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.datatables.net/2.3.6/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.3.6/js/dataTables.bootstrap5.js"></script>


    <script>
        //Call the dataTables jQuery plugin
        $(document).ready(function() {

            const table = new DataTable('#dataTableGugusDepan', {
                processing: true,
                serverSide: true,
                responsive: true,

                ajax: {
                    url: '/gugus-depan-datatable',
                    data: function (d) {
                        d.keyword = $('#name').val();
                        d.ranting = $('#ranting').val();
                        d.grade   = $('#grade').val();
                        d.status  = $('#status').val();
                    }
                },

                columns: [
                    { data: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'nogudep' },
                    { data: 'ranting' },
                    { data: 'namagudep' },
                    { data: 'jenjang' },
                    { data: 'status' },
                    { data: 'kepsek' },
                    { data: 'address' },
                ],

                layout: {
                    topStart: 'pageLength',
                    topEnd: 'search',
                    bottomStart: 'info',
                    bottomEnd: 'paging'
                }
            });

            // tombol cari → reload datatable
            $('.btn.btn-primary').on('click', function (e) {
                e.preventDefault();
                table.ajax.reload();
            });

            
        });
        </script>

@endpush

