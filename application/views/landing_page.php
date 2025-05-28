<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Bursa Kerja Khusus - <?= $pengaturan->nama_sekolah ?></title>
  <link rel="icon" href="<?= base_url('uploads/logo/' . $pengaturan->logo_bkk) ?>">

  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">

  <link href="<?= base_url('assets/landing/') ?>assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?= base_url('assets/landing/') ?>assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="<?= base_url('assets/landing/') ?>assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="<?= base_url('assets/landing/') ?>assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="<?= base_url('assets/landing/') ?>assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <link href="<?= base_url('assets/landing/') ?>assets/css/main.css" rel="stylesheet">
</head>

<body class="index-page">

  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="header-container container-fluid container-xl position-relative d-flex align-items-center justify-content-between" style="min-height: 80px;">
      <a href="<?= base_url() ?>" class="logo d-flex align-items-center">
        <img src="<?= base_url('uploads/logo/' . $pengaturan->logo_bkk) ?>" alt="Logo BKK" style="height: 90px; margin-right: 10px;">
        <h1>Bursa Kerja Khusus</h1>
      </a>
      <div class="d-flex hero-buttons">
        <a href="<?= base_url('register') ?>" class="btn btn-primary mx-1">Register</a>
        <a href="<?= base_url('login') ?>" class="btn btn-primary mx-1">Login</a>        
      </div>
    </div>
  </header>

  <main class="main">
    <section id="hero" class="hero section">
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row align-items-center">
          <div class="col-lg-6">
            <div class="hero-content" data-aos="fade-up" data-aos-delay="200">
              <div class="company-badge mb-4">
                <i class="bi bi-gear-fill me-2"></i>
                Working for your success
              </div>
              <h1 class="mb-4">
                Bursa Kerja Khusus<br>
                <span class="accent-text"><?= $pengaturan->nama_sekolah ?></span>
              </h1>
              <div class="hero-buttons">
                <a href="<?= base_url('login') ?>" class="btn btn-primary mx-1">Login</a>
                <a href="<?= base_url('register') ?>" class="btn btn-primary mx-1">Register</a>
              </div>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="hero-image" data-aos="zoom-out" data-aos-delay="300">
              <img src="<?= base_url('assets/landing/') ?>assets/img/illustration-1.webp" alt="Hero Image" class="img-fluid">
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Clients Section -->
    <section id="clients" class="clients section">
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="swiper init-swiper">
          <script type="application/json" class="swiper-config">
            {
              "loop": true,
              "speed": 600,
              "autoplay": {
                "delay": 5000
              },
              "slidesPerView": "auto",
              "pagination": {
                "el": ".swiper-pagination",
                "type": "bullets",
                "clickable": true
              },
              "breakpoints": {
                "320": {
                  "slidesPerView": 2,
                  "spaceBetween": 40
                },
                "480": {
                  "slidesPerView": 3,
                  "spaceBetween": 60
                },
                "640": {
                  "slidesPerView": 4,
                  "spaceBetween": 80
                },
                "992": {
                  "slidesPerView": 6,
                  "spaceBetween": 120
                }
              }
            }
          </script>
          <div class="swiper-wrapper align-items-center">
            <?php foreach ($perusahaan as $p): ?>
              <div class="swiper-slide text-center">
                <img src="<?= base_url('uploads/logo_perusahaan/' . $p->logo) ?>" class="img-fluid mb-2" alt="<?= $p->nama ?>" style="max-height: 80px;">
                <div style="font-size: 14px;"><?= $p->nama ?></div>
              </div>
            <?php endforeach; ?>
          </div>
          <div class="swiper-pagination"></div>
        </div>
      </div>
    </section>
    <!-- /Clients Section -->

    <section id="testimonials" class="testimonials section light-background">
      <div class="container section-title" data-aos="fade-up">
        <h2>Testimoni Alumni</h2>
      </div>
      <div class="container">
        <div class="row g-5">
          <?php foreach ($testimoni as $t): ?>
            <div class="col-lg-6" data-aos="fade-up">
              <div class="testimonial-item">
                <img src="<?= base_url('uploads/foto_alumni/' . $t->foto) ?>" class="testimonial-img rounded-circle mb-3" alt="<?= htmlspecialchars($t->nama) ?>" style="object-fit: cover; width: 100px; height: 100px;">
                <h3><?= htmlspecialchars($t->nama) ?></h3>
                <h4>Alumni</h4>
                <p>
                  <i class="bi bi-quote quote-icon-left"></i>
                  <?= htmlspecialchars($t->isi) ?>
                  <i class="bi bi-quote quote-icon-right"></i>
                </p>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </section>

  </main>

  <footer id="footer" class="footer">
    <div class="container">
      <div class="copyright">
        &copy; <?= date('Y') ?> <strong><span><?= $pengaturan->nama_sekolah ?></span></strong>. All Rights Reserved
      </div>
    </div>
  </footer>

  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <script src="<?= base_url('assets/landing/') ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?= base_url('assets/landing/') ?>assets/vendor/php-email-form/validate.js"></script>
  <script src="<?= base_url('assets/landing/') ?>assets/vendor/aos/aos.js"></script>
  <script src="<?= base_url('assets/landing/') ?>assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="<?= base_url('assets/landing/') ?>assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="<?= base_url('assets/landing/') ?>assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="<?= base_url('assets/landing/') ?>assets/js/main.js"></script>
</body>

</html>
