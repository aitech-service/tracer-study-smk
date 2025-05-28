<div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Alumni /</span> Profil</h4>

              <div class="row">
                <div class="col-md-12">
                  <div class="card mb-4">
                    <h4 class="card-header"><?= $title ?></h4>
                    <?php if ($this->session->flashdata('success')): ?>
                        <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
                    <?php endif; ?>

                    <?php if ($this->session->flashdata('error')): ?>
                        <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
                    <?php endif; ?>

                    <!-- Account -->   
                    <div class="card-body">
                      <form method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>Nama Sekolah</label>
                            <input type="text" name="nama_sekolah" class="form-control" value="<?= $pengaturan->nama_sekolah ?>">
                        </div>
                        <div class="form-group">
                            <label>Status Sekolah</label>
                            <select name="status_sekolah" class="form-control">
                                <option value="Negeri" <?= $pengaturan->status_sekolah == 'Negeri' ? 'selected' : '' ?>>Negeri</option>
                                <option value="Swasta" <?= $pengaturan->status_sekolah == 'Swasta' ? 'selected' : '' ?>>Swasta</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Alamat</label>
                            <input type="text" name="alamat" class="form-control" value="<?= $pengaturan->alamat ?>">
                        </div>
                        <div class="form-group">
                            <label>Kecamatan</label>
                            <input type="text" name="kecamatan" class="form-control" value="<?= $pengaturan->kecamatan ?>">
                        </div>
                        <div class="form-group">
                            <label>Kabupaten</label>
                            <input type="text" name="kabupaten" class="form-control" value="<?= $pengaturan->kabupaten ?>">
                        </div>
                        <div class="form-group">
                            <label>Provinsi</label>
                            <input type="text" name="provinsi" class="form-control" value="<?= $pengaturan->provinsi ?>">
                        </div>
                        <div class="form-group">
                            <label>Logo Sekolah</label><br>
                            <img src="<?= base_url('uploads/logo/' . $pengaturan->logo_sekolah) ?>" height="60"><br>
                            <input type="file" name="logo_sekolah" class="form-control">
                            <small class="text-danger mb-0 fw-bold">
                                Allowed JPG or PNG. Max size of 512 Kb
                            </small>
                        </div>
                        <div class="form-group">
                            <label>Logo BKK</label><br>
                            <img src="<?= base_url('uploads/logo/' . $pengaturan->logo_bkk) ?>" height="60"><br>
                            <input type="file" name="logo_bkk" class="form-control">
                            <small class="text-danger mb-0 fw-bold">
                                Allowed JPG or PNG. Max size of 512 Kb
                            </small>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
                    </form>
                    </div>
                    <!-- /Account -->
                  </div>
                </div>
              </div>
            </div>