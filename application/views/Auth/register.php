        <?php
            $CI =& get_instance();
            $CI->load->model('Pengaturan_model');
            $pengaturan = $CI->Pengaturan_model->get_pengaturan();
          ?>
<div class="container-xxl">
      <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
          <!-- Register Card -->
          <div class="card">
            <div class="card-body">
              <!-- Logo -->
              <div class="app-brand justify-content-center">
                <a href="#" class="app-brand-link gap-2">
                  <span class="app-brand-logo demo">
                     <img src="<?= base_url('uploads/logo/' . $pengaturan->logo_bkk  . '?t=' . time()) ?>" alt="Logo BKK" style="width: 75px; height: auto">
                </a>
                <span class="app-brand-text demo text-body fw-bolder text-capitalize">Register</span>
              </div>

              <?php if(validation_errors()): ?>
                  <div style="color:red;">
                      <?= validation_errors(); ?>
                  </div>
              <?php endif; ?>
              <form id="formAuthentication" class="mb-3" action="<?= base_url('auth/register') ?>" method="POST">
                <div class="mb-3">
                  <label for="username" class="form-label">Username</label>
                  <input
                    type="text"
                    class="form-control"
                    id="username"
                    name="username"
                    placeholder="Enter your username"
                    autofocus
                  />
                </div>
                
                <div class="mb-3">
                  <label for="email" class="form-label">Email</label>
                  <input type="text" class="form-control" id="email" name="email" placeholder="Enter your email" />
                </div>
                
                <div class="mb-3 form-password-toggle">
                  <label class="form-label" for="password">Password</label>
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
                
                <div class="mb-3 form-password-toggle">
                  <label class="form-label" for="password_confirm">Confirm Password</label>
                  <div class="input-group input-group-merge">
                    <input
                      type="password"
                      id="password_confirm"
                      class="form-control"
                      name="password_confirm"
                      placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                      aria-describedby="password_confirm"
                    />
                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                  </div>
                </div>

                
                <button class="btn btn-primary d-grid w-100">Daftar</button>
              </form>

              <p class="text-center">
                <span>Already have an account?</span>
                <a href="<?php echo base_url('login')?>">
                  <span>Sign in instead</span>
                </a>
              </p>
            </div>
          </div>
          <!-- Register Card -->
        </div>
      </div>
    </div>

    <!-- SweetAlert Notifikasi -->
<?php if ($this->session->flashdata('success')): ?>
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '<?= $this->session->flashdata("success") ?>',
        confirmButtonText: 'OK'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "<?= base_url('auth/login') ?>";
        }
    });
</script>
<?php endif; ?>