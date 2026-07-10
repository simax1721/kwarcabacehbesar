@extends('layouts.frondend')

@section('section-hero')
    <!-- ======= Hero Section ======= -->
  <section id="hero" class="hero">
    <div class="container position-relative">
      <div class="row gy-5" data-aos="fade-in">
        <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center text-center text-lg-start">
          <h2>Selamat Datang Di <span>Kwarcab Aceh Besar</span></h2>
          <p>Gerakan Pramuka Kwartir Cabang Aceh Besar &mdash; membentuk generasi muda yang berkarakter, mandiri, dan berjiwa kepemimpinan melalui pendidikan kepramukaan.</p>
          <div class="d-flex justify-content-center justify-content-lg-start">
            <a href="{{ url('/kegiatan') }}" class="btn-get-started">Lihat Kegiatan</a>
          </div>
        </div>
        <div class="col-lg-6 order-1 order-lg-2">
          <img src="{{ url('frondend') }} /assets/img/hero-img.svg" class="img-fluid" alt="" data-aos="zoom-out" data-aos-delay="100">
        </div>
      </div>
    </div>

    <div class="icon-boxes position-relative">
      <div class="container position-relative">
        <div class="row gy-4 mt-5">

          <div class="col-xl-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
            <div class="icon-box">
              <div class="icon"><i class="bi bi-map-fill"></i></div>
              <h4 class="title"><a href="{{ url('/gugus-depan') }}" class="stretched-link">Gugus Depan</a></h4>
            </div>
          </div><!--End Icon Box -->

          <div class="col-xl-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
            <div class="icon-box">
              <div class="icon"><i class="bi bi-diagram-3-fill"></i></div>
              <h4 class="title"><a href="{{ url('/struktur-organisasi') }}" class="stretched-link">Struktur Organisasi</a></h4>
            </div>
          </div><!--End Icon Box -->

          <div class="col-xl-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
            <div class="icon-box">
              <div class="icon"><i class="bi bi-calendar-event-fill"></i></div>
              <h4 class="title"><a href="{{ url('/kegiatan') }}" class="stretched-link">Informasi Kegiatan</a></h4>
            </div>
          </div><!--End Icon Box -->

          <div class="col-xl-3 col-md-6" data-aos="fade-up" data-aos-delay="500">
            <div class="icon-box">
              <div class="icon"><i class="bi bi-people-fill"></i></div>
              <h4 class="title"><a href="{{ url('login') }}" class="stretched-link">Login Gugus Depan</a></h4>
            </div>
          </div><!--End Icon Box -->

        </div>
      </div>
    </div>

    </div>
  </section>
  <!-- End Hero Section -->
@endsection

@section('main-content')
    <!-- ======= About Us Section ======= -->
    <section id="about" class="about">
      <div class="container" data-aos="fade-up">

        <div class="section-header">
          <h2>Tentang Kami</h2>
          <p>Kwartir Cabang Gerakan Pramuka Aceh Besar merupakan lembaga penyelenggara pendidikan kepramukaan di tingkat Kabupaten Aceh Besar</p>
        </div>

        <div class="row gy-4">
          <div class="col-lg-6">
            <h3>Membentuk Karakter Generasi Muda Aceh Besar</h3>
            <img src="{{ url('frondend') }} /assets/img/about.jpg" class="img-fluid rounded-4 mb-4" alt="">
            <p>Kwartir Cabang (Kwarcab) Gerakan Pramuka Aceh Besar bertugas membina, mengembangkan, dan mengoordinasikan seluruh kegiatan kepramukaan di wilayah Kabupaten Aceh Besar, mulai dari tingkat Ranting hingga Gugus Depan yang berada di satuan pendidikan.</p>
          </div>
          <div class="col-lg-6">
            <div class="content ps-0 ps-lg-5">
              <p class="fst-italic">
                Melalui pendidikan kepramukaan, Kwarcab Aceh Besar berkomitmen mencetak generasi muda yang disiplin, mandiri, berjiwa sosial, dan cinta tanah air sesuai dengan Tri Satya dan Dasa Darma Pramuka.
              </p>
              <ul>
                <li><i class="bi bi-check-circle-fill"></i> Membina dan mengembangkan Gugus Depan di seluruh Ranting Aceh Besar.</li>
                <li><i class="bi bi-check-circle-fill"></i> Menyelenggarakan berbagai kegiatan kepramukaan secara berkala.</li>
                <li><i class="bi bi-check-circle-fill"></i> Mendorong partisipasi aktif anggota Pramuka Penggalang dan Penegak dalam kegiatan positif dan bermanfaat bagi masyarakat.</li>
              </ul>
              <p>
                Informasi seputar data Gugus Depan, struktur organisasi, serta agenda kegiatan Kwarcab dapat diakses secara terbuka melalui halaman informasi pada situs ini.
              </p>
            </div>
          </div>
        </div>

      </div>
    </section><!-- End About Us Section -->

    <!-- ======= Stats Counter Section ======= -->
    <section id="stats-counter" class="stats-counter">
      <div class="container" data-aos="fade-up">

        <div class="row gy-4 align-items-center">

          <div class="col-lg-6">
            <img src="{{ url('frondend') }} /assets/img/stats-img.svg" alt="" class="img-fluid">
          </div>

          <div class="col-lg-6">

            <div class="stats-item d-flex align-items-center">
              <span data-purecounter-start="0" data-purecounter-end="{{ $totalRanting }}" data-purecounter-duration="1" class="purecounter">{{ $totalRanting }}</span>
              <p><strong>Ranting</strong> tersebar di seluruh wilayah Kabupaten Aceh Besar</p>
            </div><!-- End Stats Item -->

            <div class="stats-item d-flex align-items-center">
              <span data-purecounter-start="0" data-purecounter-end="{{ $totalGudep }}" data-purecounter-duration="1" class="purecounter">{{ $totalGudep }}</span>
              <p><strong>Gugus Depan</strong> aktif terdaftar di bawah Kwarcab Aceh Besar</p>
            </div><!-- End Stats Item -->

            <div class="stats-item d-flex align-items-center">
              <span data-purecounter-start="0" data-purecounter-end="{{ $totalKegiatan }}" data-purecounter-duration="1" class="purecounter">{{ $totalKegiatan }}</span>
              <p><strong>Kegiatan</strong> telah diselenggarakan oleh Kwarcab Aceh Besar</p>
            </div><!-- End Stats Item -->

          </div>

        </div>

      </div>
    </section><!-- End Stats Counter Section -->

    <!-- ======= Kegiatan Terbaru Section ======= -->
    <section id="kegiatan-terbaru" class="blog">
      <div class="container" data-aos="fade-up">

        <div class="section-header">
          <h2>Kegiatan Terbaru</h2>
          <p>Agenda dan dokumentasi kegiatan terbaru Kwarcab Aceh Besar</p>
        </div>

        <div class="row gy-4 posts-list">
          @forelse ($kegiatanTerbaru as $keg)
            <div class="col-lg-4 col-md-6">
              <article>
                <div class="post-img">
                  <img src="{{ $keg->thumbnail ?? url('frondend/assets/img/blog/blog-'.(($loop->index % 6) + 1).'.jpg') }}" alt="{{ $keg->title }}" class="img-fluid">
                </div>
                <p class="post-category">
                  <i class="bi bi-calendar-event"></i>
                  {{ $keg->date ? \Carbon\Carbon::parse($keg->date)->translatedFormat('d F Y') : 'Tanggal menyusul' }}
                </p>
                <h2 class="title">
                  <a href="{{ url('/kegiatan/detail/'.$keg->id) }}">{{ $keg->title }}</a>
                </h2>
                <p>{{ Str::limit(strip_tags($keg->description), 100) }}</p>
              </article>
            </div>
          @empty
            <div class="col-12 text-center py-4">
              <p class="mb-0">Belum ada informasi kegiatan yang dipublikasikan.</p>
            </div>
          @endforelse
        </div>

        @if ($kegiatanTerbaru->count())
          <div class="text-center mt-5">
            <a href="{{ url('/kegiatan') }}" class="btn-get-started">Lihat Semua Kegiatan</a>
          </div>
        @endif

      </div>
    </section><!-- End Kegiatan Terbaru Section -->

    <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact">
      <div class="container" data-aos="fade-up">

        <div class="section-header">
          <h2>Hubungi Kami</h2>
          <p>Kwartir Cabang Gerakan Pramuka Aceh Besar siap menerima pertanyaan, saran, dan informasi seputar kepramukaan</p>
        </div>

        <div class="row gx-lg-0 gy-4">

          <div class="col-lg-4">

            <div class="info-container d-flex flex-column align-items-center justify-content-center">
              <div class="info-item d-flex">
                <i class="bi bi-geo-alt flex-shrink-0"></i>
                <div>
                  <h4>Alamat:</h4>
                  <p>Sekretariat Gerakan Pramuka Kwartir Cabang Aceh Besar, Jl. Banda Aceh - Medan, Lampreh Lamteungoh, Ingin Jaya, Aceh Besar, Aceh 23235</p>
                </div>
              </div><!-- End Info Item -->

              <div class="info-item d-flex">
                <i class="bi bi-envelope flex-shrink-0"></i>
                <div>
                  <h4>Email:</h4>
                  <p>kwarcabacehbesar87@gmail.com</p>
                </div>
              </div><!-- End Info Item -->

              <div class="info-item d-flex">
                <i class="bi bi-phone flex-shrink-0"></i>
                <div>
                  <h4>Telepon:</h4>
                  <p>+62 812 6335 8424</p>
                </div>
              </div><!-- End Info Item -->
            </div>

          </div>

          <div class="col-lg-8">
            <form action="forms/contact.php" method="post" role="form" class="php-email-form">
              <div class="row">
                <div class="col-md-6 form-group">
                  <input type="text" name="name" class="form-control" id="name" placeholder="Nama Anda" required>
                </div>
                <div class="col-md-6 form-group mt-3 mt-md-0">
                  <input type="email" class="form-control" name="email" id="email" placeholder="Email Anda" required>
                </div>
              </div>
              <div class="form-group mt-3">
                <input type="text" class="form-control" name="subject" id="subject" placeholder="Subjek" required>
              </div>
              <div class="form-group mt-3">
                <textarea class="form-control" name="message" rows="7" placeholder="Pesan" required></textarea>
              </div>
              <div class="my-3">
                <div class="loading">Mengirim...</div>
                <div class="error-message"></div>
                <div class="sent-message">Pesan Anda telah terkirim. Terima kasih!</div>
              </div>
              <div class="text-center"><button type="submit">Kirim Pesan</button></div>
            </form>
          </div><!-- End Contact Form -->

        </div>

      </div>
    </section><!-- End Contact Section -->
@endsection
