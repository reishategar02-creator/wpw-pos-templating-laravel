@extends('layouts.frontend.app')

@section('content')
<main class="main">

  <!-- Hero Section -->
  <section id="hero" class="hero section dark-background">
    <!-- Gambar background disesuaikan jalurnya -->
    <img src="{{ asset('frontend_assets/assets/img/hero-bg-2.jpg') }}" alt="" class="hero-bg">

    <div class="container">
      <div class="row gy-4 justify-content-between">
        <div class="col-lg-4 order-lg-last hero-img" data-aos="zoom-out" data-aos-delay="100">
          <!-- Gambar hero disesuaikan jalurnya -->
          <img src="{{ asset('frontend_assets/assets/img/hero-img.png') }}" class="img-fluid animated" alt="">
        </div>

        <div class="col-lg-6 d-flex flex-column justify-content-center" data-aos="fade-in">
          <h1>Aplikasi mirip Go-jek, <span>Gas-Jek</span></h1>
          <p>Sistem pemesana ojek motor, mobil, serta delivery barang ataupun makanan secara efisien dan cepat.</p>
          <div class="d-flex">
            <!-- Tombol diarahkan langsung ke halaman login sesuai instruksi tugas -->
            <a href="{{ url('/login') }}" class="btn-get-started">Pesan Sekarang</a>
            <a href="https://www.youtube.com/watch?v=Y7f98aduVJ8" class="glightbox btn-watch-video d-flex align-items-center"><i class="bi bi-play-circle"></i><span>Watch Video</span></a>
          </div>
        </div>

      </div>
    </div>

    <svg class="hero-waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 24 150 28 " preserveAspectRatio="none">
      <defs>
        <path id="wave-path" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z"></path>
      </defs>
      <g class="wave1">
        <use xlink:href="#wave-path" x="50" y="3"></use>
      </g>
      <g class="wave2">
        <use xlink:href="#wave-path" x="50" y="0"></use>
      </g>
      <g class="wave3">
        <use xlink:href="#wave-path" x="50" y="9"></use>
      </g>
    </svg>

  </section><!-- /Hero Section -->

  <!-- About Section -->
  <section id="about" class="about section">

    <div class="container" data-aos="fade-up" data-aos-delay="100">
      <div class="row align-items-xl-center gy-5">

        <div class="col-xl-5 content">
          <h3>Tentang Kami</h3>
          <h2>Solusi Digital untuk Mobilitas Anda</h2>
          <p>Aplikasi Gas-Jek ini dirancang untuk mempermudah mobilitas anda memperoleh layanan ojek dan delivery secara cepat, aman, dan nyaman.</p>
          <a href="#" class="read-more"><span>Pelajari Lebih Lanjut</span><i class="bi bi-arrow-right"></i></a>
        </div>

        <div class="col-xl-7">
          <div class="row gy-4 icon-boxes">

            <div class="col-md-6" data-aos="fade-up" data-aos-delay="200">
              <div class="icon-box">
                <i class="bi bi-buildings"></i>
                <h3>Monitoring Cepat</h3>
                <p>Memungkinkan Anda untuk memantau status pemesanan dan lokasi driver secara real-time.</p>
              </div>
            </div> <!-- End Icon Box -->

            <div class="col-md-6" data-aos="fade-up" data-aos-delay="300">
              <div class="icon-box">
                <i class="bi bi-clipboard-pulse"></i>
                <h3>Mudah Digunakan</h3>
                <p>Antarmuka yang sederhana dan intuitif membuat penggunaan aplikasi menjadi lebih menyenangkan.</p>
              </div>
            </div> <!-- End Icon Box -->

            <div class="col-md-6" data-aos="fade-up" data-aos-delay="400">
              <div class="icon-box">
                <i class="bi bi-command"></i>
                <h3>Banyak Diskon</h3>
                <p>Menawarkan berbagai promo dan diskon menarik untuk pengguna setia.</p>
              </div>
            </div> <!-- End Icon Box -->

            <div class="col-md-6" data-aos="fade-up" data-aos-delay="500">
              <div class="icon-box">
                <i class="bi bi-graph-up-arrow"></i>
                <h3>Kendaraan Tersedia</h3>
                <p>Menyediakan berbagai jenis kendaraan yang tersedia untuk layanan ojek dan delivery.</p>
              </div>
            </div> <!-- End Icon Box -->

          </div>
        </div>

      </div>
    </div>

  </section><!-- /About Section -->

  <!-- Features Section -->
  <section id="features" class="features section">

    <div class="container">

      <div class="row gy-4">

        <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="100">
          <div class="features-item">
            <i class="bi bi-eye" style="color: #ffbb2c;"></i>
            <h3><a href="" class="stretched-link">Aplikasi Terbaik</a></h3>
          </div>
        </div><!-- End Feature Item -->

        <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="200">
          <div class="features-item">
            <i class="bi bi-infinity" style="color: #5578ff;"></i>
            <h3><a href="" class="stretched-link">Driver Ramah</a></h3>
          </div>
        </div><!-- End Feature Item -->

        <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="300">
          <div class="features-item">
            <i class="bi bi-mortarboard" style="color: #e80368;"></i>
            <h3><a href="" class="stretched-link">Pengalaman Pengguna Terbaik</a></h3>
          </div>
        </div><!-- End Feature Item -->

        <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="400">
          <div class="features-item">
            <i class="bi bi-nut" style="color: #e361ff;"></i>
            <h3><a href="" class="stretched-link">Delivery Cepat</a></h3>
          </div>
        </div><!-- End Feature Item -->

      </div>

    </div>

  </section><!-- /Features Section -->

</main>
@endsection