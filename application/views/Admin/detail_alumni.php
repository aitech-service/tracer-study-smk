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
                          <h2 class="card-title text-primary"><?= $title ?></h2>
                        </div>
                      </div>
                      <div class="table-responsive">
                        <div class="card">
                            <div class="card-body">
                                <?php if ($alumni->foto): ?>
                                    <img src="<?= base_url('uploads/foto_alumni/' . $alumni->foto) ?>" width="160" class="mb-3">
                                <?php endif; ?>

                                <table class="table table-bordered">
                                    <tr><th>Nama</th><td><?= $alumni->nama ?></td></tr>
                                    <tr><th>Username</th><td><?= $alumni->username ?></td></tr>
                                    <tr><th>Email</th><td><?= $alumni->email ?></td></tr>
                                    <tr><th>NISN</th><td><?= $alumni->nis ?></td></tr>
                                    <tr><th>Angkatan</th><td><?= $alumni->angkatan ?></td></tr>
                                    <tr><th>Jurusan</th><td><?= $alumni->jurusan ?></td></tr>
                                    <tr><th>No HP / WA</th><td><?= $alumni->no_hp ?></td></tr>
                                    <tr><th>Alamat</th><td><?= $alumni->alamat ?></td></tr>
                                    <tr><th>Status Aktivitas</th><td><?= $alumni->status_aktifitas ?></td></tr>
                                    <tr><th>Pekerjaan</th><td><?= $alumni->pekerjaan ?></td></tr>
                                    <tr><th>Tempat Kerja</th><td><?= $alumni->tempat_kerja ?></td></tr>
                                    <tr><th>Universitas</th><td><?= $alumni->universitas ?></td></tr>
                                    <tr><th>Prodi</th><td><?= $alumni->prodi ?></td></tr>
                                    <tr><th>Nama Usaha</th><td><?= $alumni->nama_usaha ?></td></tr>
                                    <tr><th>Jenis Usaha</th><td><?= $alumni->jenis_usaha ?></td></tr>
                                    <tr><th>Tahun Lulus</th><td><?= $alumni->tahun_lulus ?></td></tr>
                                </table>
                            </div>
                        </div>
                        <a href="<?= base_url('admin/list_alumni') ?>" class="btn btn-secondary mt-3">Kembali</a>
                    </div>
                    </div>
                  </div>
                </div>
                <div>
                  
                </div>
              </div>
            </div>
            <!-- / Content -->
            