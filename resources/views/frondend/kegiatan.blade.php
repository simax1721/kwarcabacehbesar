@extends('layouts.frondend')

@section('breadcrumbs')
    <div class="breadcrumbs">
      <div class="page-header d-flex align-items-center" style="background-image: url('');">
        <div class="container position-relative">
          <div class="row d-flex justify-content-center">
            <div class="col-lg-6 text-center">
              <h2>Informasi Kegiatan</h2>
              <p>Agenda dan dokumentasi kegiatan Gerakan Pramuka Kwartir Cabang Aceh Besar</p>
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
<section class="blog">
    <div class="container" data-aos="fade-up">

        <div class="row gy-4 posts-list">

            @forelse ($kegiatans as $kegiatan)
                <div class="col-lg-4 col-md-6">
                    <article>
                        <div class="post-img">
                            <img src="{{ $kegiatan->thumbnail ?? url('frondend/assets/img/blog/blog-'.(($loop->index % 6) + 1).'.jpg') }}" alt="{{ $kegiatan->title }}" class="img-fluid">
                        </div>

                        <p class="post-category">
                            <i class="bi bi-calendar-event"></i>
                            {{ $kegiatan->date ? \Carbon\Carbon::parse($kegiatan->date)->translatedFormat('d F Y') : 'Tanggal menyusul' }}
                        </p>

                        <h2 class="title">
                            <a href="{{ url('/kegiatan/detail/'.$kegiatan->id) }}">{{ $kegiatan->title }}</a>
                        </h2>

                        <p>{{ Str::limit(strip_tags($kegiatan->description), 120) }}</p>

                        <a href="{{ url('/kegiatan/detail/'.$kegiatan->id) }}" class="btn btn-sm text-white" style="background-color: #004C3F;">
                            Selengkapnya <i class="bi bi-arrow-right"></i>
                        </a>
                    </article>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <i class="bi bi-calendar-x" style="font-size: 48px; color: #999;"></i>
                    <p class="mt-3 mb-0">Belum ada informasi kegiatan yang dipublikasikan.</p>
                </div>
            @endforelse

        </div>

        @if ($kegiatans->hasPages())
            <div class="d-flex justify-content-center mt-5">
                {{ $kegiatans->links() }}
            </div>
        @endif

    </div>
</section>
@endsection
