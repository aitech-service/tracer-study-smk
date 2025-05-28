<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <!-- Menu -->

        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
          <div class="app-brand demo">
            <a href="<?php echo base_url('panel_alumni')?>" class="app-brand-link">
              <span class="app-brand-text demo menu-text fw-bolder ms-2 text-capitalize">Tracer Study</span>
            </a>
          </div>

          <div class="menu-inner-shadow"></div>

          <ul class="menu-inner py-1">
            <!-- Dashboard -->
            <li class="menu-item">
              <a href="<?php echo base_url('panel_alumni')?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
              </a>
            </li>

            <li class="menu-header small text-uppercase">
              <span class="menu-header-text">Master Data</span>
            </li>
            <li class="menu-item">
              <a href="<?php echo base_url('alumni-profil')?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user"></i>
                <div data-i18n="Account Settings">Profil Alumni</div>
              </a>
            </li>
           <li class="menu-header small text-uppercase">
              <span class="menu-header-text">Survey</span>
            </li>
            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-pie-chart-alt"></i>
                <div data-i18n="Authentications">Survey Tracer Study</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item">
                  <a href="<?php echo base_url('tracersurvey')?>" class="menu-link">
                    <div data-i18n="Basic">Isi Survey</div>
                  </a>
                </li>
              </ul>
            </li>
            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-pie-chart-alt"></i>
                <div data-i18n="Authentications">Survey Kepuasan</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item">
                  <a href="<?php echo base_url('underconstruction')?>" class="menu-link">
                    <div data-i18n="Basic">Data Survey</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="<?php echo base_url('underconstruction')?>" class="menu-link">
                    <div data-i18n="Basic">Hasil Survey</div>
                  </a>
                </li>
              </ul>
            </li>
            <li class="menu-item">
              <a href="<?php echo base_url('testimoni')?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-message"></i>
                <div data-i18n="Tables">Testimoni</div>
              </a>
            </li>
            <li class="menu-header small text-uppercase">
              <span class="menu-header-text">Other</span>
            </li>
            <!-- Tables -->
            <li class="menu-item">
              <a href="<?php echo base_url('logout')?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-left-indent"></i>
                <div data-i18n="Tables">Logout</div>
              </a>
            </li>
            <!-- Misc -->
          </ul>
        </aside>
        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
          <!-- Navbar -->
          <?php
            $CI =& get_instance();
            $CI->load->model('Pengaturan_model');
            $pengaturan = $CI->Pengaturan_model->get_pengaturan();
          ?>
          <nav
            class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
            id="layout-navbar"
          >
          <div class="navbar-nav-right d-flex align-items-center w-100 justify-content-between" id="school">
              <!-- Informasi Sekolah -->
              <div class="navbar-nav align-items-center">
                <img src="<?= base_url('uploads/logo/' . $pengaturan->logo_sekolah  . '?t=' . time()) ?>" alt="Logo Sekolah" height="40" class="me-2">
                <div class="nav-item d-flex flex-column">
                  <h4 class="mb-0"><?= $pengaturan->nama_sekolah ?></h4>
                  <small class="text-muted">
                    <?= $pengaturan->alamat ?>, 
                    Kec. <?= $pengaturan->kecamatan ?>, 
                    <?= $pengaturan->kabupaten ?>, 
                    <?= $pengaturan->provinsi ?>
                  </small>
                </div>
              </div>

              <!-- Status Sekolah -->
              <div class="navbar-nav mx-3">
                <div class="nav-item d-flex flex-column text-center">
                  <h4 class="mb-0">Sekolah <?= $pengaturan->status_sekolah ?></h4>
                </div>
              </div>

              <!-- BKK -->
              <div class="navbar-nav flex-row align-items-center">
                <div class="nav-item d-flex align-items-center">
                  <img src="<?= base_url('uploads/logo/' . $pengaturan->logo_bkk  . '?t=' . time()) ?>" alt="Logo BKK" style="height: 40px; margin-right: 10px;">
                  <h4 class="mb-0">Bursa Kerja Khusus</h4>
                </div>
              </div>
            </div>
          </nav>

          <!-- / Navbar -->