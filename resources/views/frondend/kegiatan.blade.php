@extends('layouts.frondend')

@section('breadcrumbs')
    <div class="breadcrumbs">
      <div class="page-header d-flex align-items-center" style="background-image: url('');">
        <div class="container position-relative">
          <div class="row d-flex justify-content-center">
            <div class="col-lg-6 text-center">
              <h2>Informasi Kegiatan</h2>
              <p></p>
            </div>
          </div>
        </div>
      </div>
      <nav>
        <div class="container">
          <ol>
            <li><a href="{{ url('') }}">Home</a></li>
            <li>Informasi Kegiatan</li>
          </ol>
        </div>
      </nav>
    </div><!-- End Breadcrumbs -->
@endsection

@section('main-content')
    <div class="container"></div>
@endsection