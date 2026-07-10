@extends('layouts.frondend')

@section('breadcrumbs')
    <div class="breadcrumbs">
      <div class="page-header d-flex align-items-center" style="background-image: url('');">
        <div class="container position-relative">
          <div class="row d-flex justify-content-center">
            <div class="col-lg-8 text-center">
              <h2>{{ $kegiatan->title }}</h2>
              <p></p>
            </div>
          </div>
        </div>
      </div>
      <nav>
        <div class="container">
          <ol>
            <li><a href="{{ url('') }}">Home</a></li>
            <li><a href="{{ url('/kegiatan') }}">Informasi Kegiatan</a></li>
            <li>{{ $kegiatan->title }}</li>
          </ol>
        </div>
      </nav>
    </div><!-- End Breadcrumbs -->
@endsection

@section('main-content')
<section class="blog">
    <div class="container" data-aos="fade-up">
        <div class="row">
            <div class="col-lg-8 mx-auto">

                <div class="blog-details">
                    <div class="post-img">
                        <img src="{{ $kegiatan->thumbnail ?? url('frondend/assets/img/blog/blog-1.jpg') }}" alt="{{ $kegiatan->title }}" class="img-fluid">
                    </div>

                    <h2 class="title">{{ $kegiatan->title }}</h2>

                    <div class="meta-top">
                        <ul>
                            <li>
                                <i class="bi bi-calendar-event"></i>
                                {{ $kegiatan->date ? \Carbon\Carbon::parse($kegiatan->date)->translatedFormat('d F Y') : 'Tanggal menyusul' }}
                            </li>
                        </ul>
                    </div>

                    <div class="content">
                        @if ($kegiatan->description)
                            <p>{!! nl2br(e($kegiatan->description)) !!}</p>
                        @else
                            <p class="fst-italic">Belum ada deskripsi untuk kegiatan ini.</p>
                        @endif
                    </div>
                </div>

                <a href="{{ url('/kegiatan') }}" class="btn btn-dark mt-4">
                    <i class="bi bi-arrow-left"></i> Kembali ke Daftar Kegiatan
                </a>

                @if ($kegiatanLainnya->count())
                    <hr class="my-5">
                    <h4 class="mb-4">Kegiatan Lainnya</h4>
                    <div class="row gy-4 posts-list">
                        @foreach ($kegiatanLainnya as $lain)
                            <div class="col-md-4">
                                <article>
                                    <div class="post-img">
                                        <img src="{{ $lain->thumbnail ?? url('frondend/assets/img/blog/blog-2.jpg') }}" alt="{{ $lain->title }}" class="img-fluid">
                                    </div>
                                    <p class="post-category">
                                        {{ $lain->date ? \Carbon\Carbon::parse($lain->date)->translatedFormat('d F Y') : '-' }}
                                    </p>
                                    <h2 class="title" style="font-size: 18px;">
                                        <a href="{{ url('/kegiatan/detail/'.$lain->id) }}">{{ $lain->title }}</a>
                                    </h2>
                                </article>
                            </div>
                        @endforeach
                    </div>
                @endif

            </div>
        </div>
    </div>
</section>
@endsection
