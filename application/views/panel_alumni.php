  <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <div class="row">
                <div class="col-lg-12 mb-4 order-0">
                  <div class="card">
                    <div class="d-flex row">
                      <div class="col-sm-7">
                        <div class="card-body">
                          <h2 class="card-title text-primary">Selamat Datang Alumni <?= $alumni->nama ?></h2>
                          <h5 class="card-title text-primary">Jurusan <?= $alumni->jurusan ?> , Angkatan <?= $alumni->angkatan ?></h5>
                        </div>
                      </div>
                      <div class="col-sm-5 text-center text-sm-left">

                        <div class="card-body pb-0 px-0 px-md-4">
                          <img
                            src="<?php echo base_url('assets')?>/assets/img/illustrations/man-with-laptop-light.png"
                            height="140"
                            alt="View Badge User"
                            data-app-dark-img="illustrations/man-with-laptop-dark.png"
                            data-app-light-img="illustrations/man-with-laptop-light.png"
                          />
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-12 col-md-4 order-1">
                  <div class="row">
                    <div class="col-lg-6 col-md-12 col-6 mb-4">
                      <?php if ($alumni->status_aktifitas == 'Bekerja'): ?>
                        <div class="card bg-primary">
                          <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                              <div >
                                <h3 class="text-white">Aktivitas saat ini:</h3>
                               <h4 class="text-white"><i class="bx bxs-factory"></i> Bekerja</h4>
                              </div>
                            </div>
                            <h4 class="fw-semibold d-block mb-1 text-white">Pekerjaan / Posisi : <?= $alumni->pekerjaan ?></h4>
                            <h6 class="card-title mb-2 text-white">Tempat : <?= $alumni->tempat_kerja ?></h6>
                          </div>
                        </div>
                        <?php elseif ($alumni->status_aktifitas == 'Kuliah'): ?>
                          <div class="card bg-success">
                            <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                              <div >
                                <h3 class="text-white">Aktivitas saat ini:</h3>
                               <h4 class="text-white"><i class="bx bxs-school"></i> Kuliah</h4>
                              </div>
                            </div>
                            <h4 class="fw-semibold d-block mb-1 text-white">Universitas : <?= $alumni->universitas ?></h4>
                            <h6 class="card-title mb-2 text-white">Program Studi : <?= $alumni->prodi ?></h6>
                          </div>
                        </div>
                        <?php elseif ($alumni->status_aktifitas == 'Wirausaha'): ?>
                          <div class="card bg-secondary">
                            <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                              <div >
                                <h3 class="text-white">Aktivitas saat ini:</h3>
                               <h4 class="text-white"><i class="bx bxs-cart"></i> Wirausaha</h4>
                              </div>
                            </div>
                            <h4 class="fw-semibold d-block mb-1 text-white">Nama Usaha : <?= $alumni->nama_usaha ?></h4>
                            <h6 class="card-title mb-2 text-white">Jenis Usaha : <?= $alumni->jenis_usaha ?></h6>
                          </div>
                        </div>
                        <?php elseif ($alumni->status_aktifitas == 'Belum Bekerja'): ?>
                          <div class="card bg-danger">
                            <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                              <div >
                                <h3 class="text-white">Aktivitas saat ini:</h3>
                               <h4 class="text-white"><i class="bx bx-search-alt"></i> Belum Bekerja / Mencari Pekerjaan</h4>
                              </div>
                            </div>
                          </div>
                        <?php endif; ?>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- / Content -->
            