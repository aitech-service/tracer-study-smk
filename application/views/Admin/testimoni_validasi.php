<!-- Content wrapper -->
<div class="content-wrapper">
  <!-- Content -->
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
      <div class="col-lg-12 mb-4 order-0">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h4 class="fw-bold">
            <i class="bx bx-check-double me-1"></i> Validasi Testimoni Alumni
          </h4>
        </div>

        <!-- Flashdata -->
        <?php if ($this->session->flashdata('success')): ?>
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $this->session->flashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
          </div>
        <?php endif; ?>

        <!-- Table -->
        <div class="card">
          <div class="table-responsive text-nowrap">
            <table class="table table-striped" id="testimoniAdminTable">
              <thead class="table-light">
                <tr>
                  <th>No</th>
                  <th>Nama Alumni</th>
                  <th>Isi Testimoni</th>
                  <th>Status</th>
                  <th>Lengkap?</th>
                  <th>Tanggal</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php if (count($testimoni) == 0): ?>
                  <tr>
                    <td colspan="7" class="text-center">Belum ada testimoni</td>
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
                        <?php
                          $badge_class = [
                            'pending'   => 'warning',
                            'diterima' => 'success',
                            'ditolak'   => 'danger'
                          ];
                        ?>
                        <span class="badge bg-<?= $badge_class[$item->status] ?? 'secondary' ?>">
                          <?= ucfirst($item->status) ?>
                        </span>
                      </td>
                      <td>
                        <?php if ($item->is_complete === 'yes'): ?>
                          <span class="badge bg-success">Yes</span>
                        <?php else: ?>
                          <span class="badge bg-secondary">No</span>
                        <?php endif; ?>
                      </td>
                      <td><?= date('d-m-Y H:i', strtotime($item->created_at)) ?></td>
                      <td>
                        <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalStatus<?= $item->id ?>">
                          <i class="bx bx-edit"></i> Validasi
                        </button>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>

        <!-- Modal Area (di luar table agar tidak rusak) -->
        <?php foreach ($testimoni as $item): ?>
          <div class="modal fade" id="modalStatus<?= $item->id ?>" tabindex="-1" aria-labelledby="modalLabel<?= $item->id ?>" aria-hidden="true">
            <div class="modal-dialog">
              <form action="<?= site_url('testimoni/update_status/' . $item->id) ?>" method="post" class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="modalLabel<?= $item->id ?>">Ubah Status Testimoni</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                  <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select" required>
                      <option value="pending" <?= $item->status == 'pending' ? 'selected' : '' ?>>Pending</option>
                      <option value="diterima" <?= $item->status == 'diterima' ? 'selected' : '' ?>>Diterima</option>
                      <option value="ditolak" <?= $item->status == 'ditolak' ? 'selected' : '' ?>>Ditolak</option>
                    </select>
                  </div>
                  <?php if ($this->config->item('csrf_protection')): ?>
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>"
                           value="<?= $this->security->get_csrf_hash() ?>" />
                  <?php endif; ?>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                  <button type="submit" class="btn btn-primary">
                    <i class="bx bx-save"></i> Simpan
                  </button>
                </div>
              </form>
            </div>
          </div>
        <?php endforeach; ?>

      </div>
    </div>
  </div>
</div>
