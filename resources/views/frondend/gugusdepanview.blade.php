@extends('layouts.frondend')

@section('breadcrumbs')
    <div class="breadcrumbs">
      <div class="page-header d-flex align-items-center" style="background-image: url('');">
        <div class="container position-relative">
          <div class="row d-flex justify-content-center">
            <div class="col-lg-6 text-center">
              <h2>{{ $gudep->name }}</h2>
              <p></p>
            </div>
          </div>
        </div>
      </div>
      <nav>
        <div class="container">
          <ol>
            <li><a href="{{ url('') }}">Home</a></li>
            <li><a href="{{ url('/gugus-depan') }}">Informasi Gugus Depan</a></li>
            <li>{{ $gudep->name }}</li>
          </ol>
        </div>
      </nav>
    </div><!-- End Breadcrumbs -->
@endsection

@section('main-content')
    <div class="container">
        <div class="row my-5">
            <div class="col-md-5">
                <img class="mb-5" style="min-width: 100%; min-height: 400px; background-color: #f0f0f0;" src="" alt="">
                

            </div>
            <div class="col-md-7">
                <table class="table table-striped">
                    <tr class="">
                        <th class="py-3" style="max-width: 100px;">Nama Gugus Depan</th>
                        <td class="py-3" style="width: 5px !important;">:</td>
                        <td class="py-3">{{ $gudep->name }}</td>
                    </tr>
                    <tr class="">
                        <th class="py-3" style="max-width: 100px;">Nomor Gudep</th>
                        <td class="py-3" style="width: 5px !important;">:</td>
                        <td class="py-3">{{ $gudep->nogudeppa }} - {{ $gudep->nogudeppi }}</td>
                    </tr>
                    <tr class="">
                        <th class="py-3" style="max-width: 100px;">Jenjang Pendidikan</th>
                        <td class="py-3" style="width: 5px !important;">:</td>
                        <td class="py-3">{{ $gudep->grade }}</td>
                    </tr>
                    <tr class="">
                        <th class="py-3" style="max-width: 100px;">Ranting</th>
                        <td class="py-3" style="width: 5px !important;">:</td>
                        <td class="py-3">{{ $gudep->district_name }}</td>
                    </tr>
                    <tr class="">
                        <th class="py-3" style="max-width: 100px;">Alamat Sekolah</th>
                        <td class="py-3" style="width: 5px !important;">:</td>
                        <td class="py-3">{{ $gudep->address ?? '-' }}</td>
                    </tr>
                    <tr class="">
                        <th class="py-3" style="max-width: 100px;">Email Sekolah</th>
                        <td class="py-3" style="width: 5px !important;">:</td>
                        <td class="py-3">{{ $gudep->email }}</td>
                    </tr>
                    <tr class="">
                        <th class="py-3" style="max-width: 100px;">Kepala Sekolah</th>
                        <td class="py-3" style="width: 5px !important;">:</td>
                        <td class="py-3">{{ $gudep->kepsek ?? '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection