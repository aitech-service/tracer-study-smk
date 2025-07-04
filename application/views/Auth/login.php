<?php
            $CI =& get_instance();
            $CI->load->model('Pengaturan_model');
            $pengaturan = $CI->Pengaturan_model->get_pengaturan();
          ?>
<div class="container-xxl">
      <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
          <!-- Register -->
          <div class="card">
            <div class="card-body">
              <!-- Logo -->
              <div class="app-brand justify-content-center">
                <a href="<?php echo base_url('')?>" class="app-brand-link gap-2">
                  <span class="app-brand-logo demo">
                    <img src="<?= base_url('uploads/logo/' . $pengaturan->logo_bkk  . '?t=' . time()) ?>" alt="Logo BKK" style="width: 75px; height: auto">
                </a>
                <span class="app-brand-text demo text-body fw-bolder text-capitalize">Login</span>
              </div>
              <!-- /Logo -->

              <form id="formAuthentication" class="mb-3" action="<?= base_url('auth/login') ?>" method="POST">
                <div class="mb-3">
                  <label for="email" class="form-label">Username</label>
                  <input
                    type="text"
                    class="form-control"
                    id="email"
                    name="username"
                    placeholder="Enter your username"
                    autofocus
                  />
                </div>
                <div class="mb-3 form-password-toggle">
                  <div class="d-flex justify-content-between">
                    <label class="form-label" for="password">Password</label>
                  </div>
                  <div class="input-group input-group-merge">
                    <input
                      type="password"
                      id="password"
                      class="form-control"
                      name="password"
                      placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                      aria-describedby="password"
                    />
                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                  </div>
                </div>
                <div class="mb-3">
                  <button class="btn btn-primary d-grid w-100" type="submit">Login</button>
                </div>
              </form>

              <p class="text-center">
                <span>New on our platform?</span>
                <a href="<?php echo base_url('register')?>">
                  <span>Create an account</span>
                </a>
              </p>
            </div>
          </div>
          <!-- /Register -->
        </div>
      </div>
    </div>

    <!-- Notifikasi SweetAlert -->
      <?php if ($this->session->flashdata('error')): ?>
      <script>
          Swal.fire({
              icon: 'error',
              title: 'Gagal',
              text: '<?= $this->session->flashdata("error") ?>'
          });
      </script>
      <?php endif; ?>