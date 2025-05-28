<!-- Content wrapper -->
<div class="content-wrapper">
  <!-- Content -->
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
      <div class="col-lg-12 mb-4 order-0">
        <div class="card">
          <div class="d-flex row">
            <div class="col-sm-12">
              <div class="card-body">
                <h2 class="card-title text-primary">Testimoni Alumni</h2>

                <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambahTestimoni">
                  <i class="bx bx-plus"></i> Tambah Testimoni
                </button>


                <?php if ($this->session->flashdata('success')): ?>
                  <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= $this->session->flashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
                  </div>
                <?php endif; ?>

                <!-- Table -->
                <div class="card">
                  <div class="table-responsive text-nowrap">
                    <table class="table table-hover">
                      <thead class="table-light">
                        <tr>
                          <th>No</th>
                          <th>Nama Alumni</th>
                          <th>Isi Testimoni</th>
                          <th>Status</th>
                          <th>Dibuat</th>
                          <th>Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php if (count($testimoni) == 0): ?>
                          <tr>
                            <td colspan="5" class="text-center">Belum ada testimoni</td>
                          </tr>
                        <?php else: ?>
                          <?php $no = 1; foreach ($testimoni as $item): ?>
                            <tr>
                              <td><?= $no++ ?></td>
                              <td><?= htmlspecialchars($item->nama) ?></td>
                              <td class="text-wrap text-justify" style="white-space: normal; max-width: 300px;">
                                <?= nl2br(htmlspecialchars($item->isi)) ?>
                              </td>
                              <td>
                                <?php if ($item->status == 'pending'): ?>
                                  <span class="badge bg-warning">Pending</span>
                                <?php elseif ($item->status == 'diterima'): ?>
                                  <span class="badge bg-success">Di Terima</span>
                                <?php else : ?>
                                  <span class="badge bg-danger">Di Tolak</span>
                                <?php endif; ?>
                              </td>
                              <td><?= date('d-m-Y H:i', strtotime($item->created_at)) ?></td>
                              <td>
                                <!-- Tombol Edit -->
                                  <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalEditTestimoni<?= $item->id ?>">
                                    <i class="bx bx-edit"></i> Edit
                                  </button>
                              </td>
                            </tr>
                            <!-- Modal Edit Testimoni -->
                            <div class="modal fade" id="modalEditTestimoni<?= $item->id ?>" tabindex="-1" aria-labelledby="modalEditTestimoniLabel<?= $item->id ?>" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                  <form action="<?= site_url('testimoni/update') ?>" method="post">
                                    <input type="hidden" name="id" value="<?= $item->id ?>">
                                    <div class="modal-header bg-warning text-white">
                                      <h5 class="modal-title text-white" id="modalEditTestimoniLabel<?= $item->id ?>">
                                        <i class="bx bx-edit text-white me-2"></i> Edit Testimoni
                                      </h5>
                                      <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                    </div>
                                    <div class="modal-body">
                                      <div class="mb-3">
                                        <label for="isi<?= $item->id ?>" class="form-label">Isi Testimoni</label>
                                        <textarea name="isi" id="isi<?= $item->id ?>" rows="4" class="form-control" required><?= htmlspecialchars($item->isi) ?></textarea>
                                      </div>
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                        <i class="bx bx-x"></i> Batal
                                      </button>
                                      <button type="submit" class="btn btn-warning text-white">
                                        <i class="bx bx-save"></i> Simpan Perubahan
                                      </button>
                                    </div>
                                  </form>
                                </div>
                              </div>
                            </div>

                          <?php endforeach; ?>
                        <?php endif; ?>
                      </tbody>
                    </table>
                  </div>
                </div>

                <!-- Modal Tambah Testimoni -->
                <div class="modal fade" id="modalTambahTestimoni" tabindex="-1" aria-labelledby="modalTambahTestimoniLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                      <form action="<?= site_url('testimoni/simpan') ?>" method="post">
                        <div class="modal-header bg-primary text-white">
                          <h5 class="modal-title" id="modalTambahTestimoniLabel">
                            <i class="bx bx-comment-dots me-2"></i> Tambah Testimoni
                          </h5>
                          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
                        </div>
                        <div class="modal-body">
                          <div class="row">
                            <div class="col-12 mb-3">
                              <label for="isi" class="form-label">Isi Testimoni</label>
                              <textarea name="isi" id="isi" rows="4" class="form-control" placeholder="Tulis testimoni Anda..." required></textarea>
                            </div>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            <i class="bx bx-x"></i> Batal
                          </button>
                          <button type="submit" class="btn btn-primary">
                            <i class="bx bx-send"></i> Simpan
                          </button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>