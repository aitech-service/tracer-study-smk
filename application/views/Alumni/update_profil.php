<div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Alumni /</span> Profil</h4>

              <div class="row">
                <div class="col-md-12">
                  <div class="card mb-4">
                    <h5 class="card-header">Profile Details</h5>
                    <!-- Account -->   
                    <div class="card-body">
                      <form action="<?= base_url('alumni/update_profil') ?>" method="post" enctype="multipart/form-data">
                        <div class="row">
                          <div class="card-body">
                            <div class="d-flex align-items-start align-items-sm-center gap-4">
                              <img id="foto-preview" src="<?= get_foto_alumni(isset($alumni->foto) ? $alumni->foto : null) ?>" width="160" class="mt-2" alt="Preview">
                              <div class="button-wrapper">
                                <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                                  <span class="d-none d-sm-block">Upload photo</span>
                                  <i class="bx bx-upload d-block d-sm-none"></i>
                                  <input type="file" name="foto" class="form-control" id="foto-input" accept="image/*">
                                </label>
                                <p class="text-danger mb-0"><strong>Allowed JPG or PNG. Max size of 512 Kb</strong></p>
                              </div>
                            </div>
                          </div>
                          <div class="form-group mb-3 col-md-6">
                            <label>Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" value="<?= isset($alumni->nama) ? $alumni->nama : '-' ?>" required>
                          </div>
                          <div class="form-group mb-3 col-md-6">
                            <label>Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-control">
                              <option value="Laki-laki" <?= isset($alumni->jenis_kelamin) && $alumni->jenis_kelamin == 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
                              <option value="Perempuan" <?= isset($alumni->jenis_kelamin) && $alumni->jenis_kelamin == 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
                            </select>
                          </div>
                          <div class="form-group mb-3 col-md-6">
                            <label>NISN</label>
                            <input type="text" name="nis" class="form-control" value="<?= isset($alumni->nis) ? $alumni->nis :'-' ?>" required>
                          </div>

                          <div class="form-group mb-3 col-md-6">
                            <label>Angkatan</label>
                            <input type="number" name="angkatan" class="form-control" value="<?= isset($alumni->angkatan) ? $alumni->angkatan : '-' ?>" required>
                          </div>
                          <div class="form-group mb-3 col-md-6">
                            <label>Jurusan</label>
                            <select name="jurusan" class="form-control" required>
                              <option value="">-- Pilih Jurusan --</option>
                              <option value="Teknik Instalasi Tenaga Listrik" <?= isset($alumni->jurusan) && $alumni->jurusan == 'Teknik Instalasi Tenaga Listrik' ? 'selected' : '' ?>>Teknik Instalasi Tenaga Listrik</option>
                              <option value="Teknik Kendaraan Ringan" <?= isset($alumni->jurusan) && $alumni->jurusan == 'Teknik Kendaraan Ringan' ? 'selected' : '' ?>>Teknik Kendaraan Ringan</option>
                              <option value="Teknik Komputer dan Jaringan" <?= isset($alumni->jurusan) && $alumni->jurusan == 'Teknik Komputer dan Jaringan' ? 'selected' : '' ?>>Teknik Komputer dan Jaringan</option>
                              <option value="Tata Kecantikan Kulit dan Rambut" <?= isset($alumni->jurusan) && $alumni->jurusan == 'Tata Kecantikan Kulit dan Rambut' ? 'selected' : '' ?>>Tata Kecantikan Kulit dan Rambut</option>
                            </select>
                          </div>
                          <div class="form-group mb-3 col-md-6">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" value="<?= isset($alumni->email) ? $alumni->email : '-' ?>">
                          </div>
                          <div class="form-group mb-3 col-md-6">
                            <label>No WhatsApp</label>
                            <input type="text" name="no_hp" class="form-control" value="<?= isset($alumni->no_hp) ? $alumni->no_hp : '-' ?>">
                          </div>
                          <div class="form-group mb-3 col-md-6">
                            <label>Alamat</label>
                            <textarea name="alamat" class="form-control" rows="2"><?= isset($alumni->alamat) ? $alumni->alamat : '-' ?></textarea>
                          </div>
                          <div class="form-group mb-3 col-md-6">
                            <label>Tahun Lulus</label>
                            <input type="number" name="tahun_lulus" class="form-control" min="1900" max="<?= date('Y') ?>" value="<?= isset($alumni->tahun_lulus) ? $alumni->tahun_lulus : '-' ?>">
                          </div>
                          <div class="form-group">
                            <label for="status_aktifitas">Aktivitas Saat Ini</label>
                            <select name="status_aktifitas" id="status_aktifitas" class="form-control" onchange="toggleAktifitas()">
                              <option value="Belum Bekerja" <?= (isset($alumni->status_aktifitas) && $alumni->status_aktifitas == 'Belum Bekerja') ? 'selected' : '' ?>>Belum Bekerja / Mencari Pekerjaan</option>
                              <option value="Bekerja" <?= (isset($alumni->status_aktifitas) && $alumni->status_aktifitas == 'Bekerja') ? 'selected' : '' ?>>Bekerja</option>
                              <option value="Kuliah" <?= (isset($alumni->status_aktifitas) && $alumni->status_aktifitas == 'Kuliah') ? 'selected' : '' ?>>Kuliah</option>
                              <option value="Wirausaha" <?= (isset($alumni->status_aktifitas) && $alumni->status_aktifitas == 'Wirausaha') ? 'selected' : '' ?>>Wirausaha</option>
                            </select>
                          </div>
                          <!-- Kuliah -->
                          <div class="row" id="form_kuliah" style="display: none;">
                            <div class="form-group mb-3 col-md-6">
                              <label for="universitas">Nama Universitas</label>
                              <input type="text" name="universitas" class="form-control" value="<?= isset($alumni->universitas) ? $alumni->universitas : '-' ?>">
                            </div>
                            <div class="form-group mb-3 col-md-6">
                              <label for="universitas">Program Studi / Jurusan</label>
                              <input type="text" name="prodi" class="form-control" value="<?= isset($alumni->prodi) ? $alumni->prodi : '-' ?>">
                            </div>
                          </div>
                          <!-- Bekerja -->
                          <div class="row" id="form_bekerja" style="display: none;">
                            <div class="form-group mb-3 col-md-6">
                              <label for="pekerjaan">Jenis Pekerjaan / Posisi</label>
                              <input type="text" name="pekerjaan" class="form-control" value="<?= isset($alumni->pekerjaan) ? $alumni->pekerjaan : '-' ?>">
                            </div>
                            <div class="form-group mb-3 col-md-6">
                              <label for="tempat_kerja">Tempat Kerja</label>
                              <input type="text" name="tempat_kerja" class="form-control" value="<?= isset($alumni->tempat_kerja) ? $alumni->tempat_kerja : '-' ?>">
                            </div>
                          </div>
                          
                          <!-- Wirausaha -->
                          <div class="row" id="form_usaha" style="display: none;">
                            <div class="form-group mb-3 col-md-6">
                              <label for="nama_usaha">Nama Usaha</label>
                              <input type="text" name="nama_usaha" class="form-control" value="<?= isset($alumni->nama_usaha) ? $alumni->nama_usaha : '-' ?>">
                            </div>
                            <div class="form-group mb-3 col-md-6">
                              <label for="jenis_usaha">Jenis Usaha</label>
                              <input type="text" name="jenis_usaha" class="form-control" value="<?= isset($alumni->jenis_usaha) ? $alumni->jenis_usaha : '-' ?>">
                            </div>
                          </div>
                          <div class="mt-2 ">
                              <button type="submit" class="btn btn-primary me-2" >Save changes</button>
                            </div>
                        </div>
                    </form>
                    </div>
                    <!-- /Account -->
                  </div>
                </div>
              </div>
            </div>

            <?php if ($this->session->flashdata('info')): ?>
            <script>
            Swal.fire({
                icon: 'info',
                title: 'Lengkapi Profil',
                text: '<?= $this->session->flashdata('info') ?>',
                confirmButtonColor: '#3085d6'
            });
            </script>
            <?php endif; ?>