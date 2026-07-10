@extends('layouts.frondend')

@section('breadcrumbs')
    <div class="breadcrumbs">
      <div class="page-header d-flex align-items-center" style="background-image: url('');">
        <div class="container position-relative">
          <div class="row d-flex justify-content-center">
            <div class="col-lg-6 text-center">
              <h2>Informasi Struktur Organisasi</h2>
              <p>Struktur Organisasi Kwartir Cabang Gerakan Pramuka Aceh Besar</p>
            </div>
          </div>
        </div>
      </div>
      <nav>
        <div class="container">
          <ol>
            <li><a href="{{ url('') }}">Home</a></li>
            <li>Informasi Struktur Organisasi</li>
          </ol>
        </div>
      </nav>
    </div><!-- End Breadcrumbs -->
@endsection

@section('main-content')
    <div class="container my-5" data-aos="fade-up">
        <div class="row justify-content-center">
            <div class="col-lg-10 text-center">
                <a class="shadow" href="{{ url('frondend/assets/img/struktur-organisasi.jpeg') }}" target="_blank">
                  <img
                    src="{{ url('frondend/assets/img/struktur-organisasi1.jpeg') }}"
                    alt="Struktur Organisasi Kwarcab Aceh Besar"
                    class="img-fluid rounded shadow"
                    style="min-height: 300px; background-color: #f0f0f0; object-fit: contain;"
                    onerror="this.onerror=null; this.alt='Gambar struktur organisasi belum tersedia';"
                >
                </a>
                <a class="shadow" href="{{ url('frondend/assets/img/struktur-pramuka1.jpeg') }}" target="_blank">
                  <img
                    src="{{ url('frondend/assets/img/struktur-pramuka1.jpeg') }}"
                    alt="Struktur Organisasi Kwarcab Aceh Besar"
                    class="img-fluid rounded shadow"
                    style="min-height: 300px; background-color: #f0f0f0; object-fit: contain; margin-top: 20px"
                    onerror="this.onerror=null; this.alt='Gambar struktur organisasi belum tersedia';"
                >
                </a>
                
                <a class="shadow" href="{{ url('frondend/assets/img/struktur-pramuka2.jpeg') }}" target="_blank">
                  <img
                    src="{{ url('frondend/assets/img/struktur-pramuka2.jpeg') }}"
                    alt="Struktur Organisasi Kwarcab Aceh Besar"
                    class="img-fluid rounded shadow"
                    style="min-height: 300px; background-color: #f0f0f0; object-fit: contain; margin-top: 20px"
                    onerror="this.onerror=null; this.alt='Gambar struktur organisasi belum tersedia';"
                >
                </a>
                {{-- <a class="shadow" href="{{ url('frondend/assets/img/struktur-organisasi2.jpeg') }}" target="_blank">
                  <img
                    src="{{ url('frondend/assets/img/struktur-organisasi2.jpeg') }}"
                    alt="Struktur Organisasi Kwarcab Aceh Besar"
                    class="img-fluid rounded shadow"
                    style="min-height: 300px; background-color: #f0f0f0; object-fit: contain;"
                    onerror="this.onerror=null; this.alt='Gambar struktur organisasi belum tersedia';"
                >
                </a> --}}
            </div>
        </div>
    </div>
@endsection
