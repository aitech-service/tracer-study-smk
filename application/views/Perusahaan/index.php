<!-- Content wrapper -->
<div class="content-wrapper">
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
      <i class="bx bx-buildings me-2"></i> Data Perusahaan
    </h4>

    <?php if ($this->session->flashdata('success')): ?>
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= $this->session->flashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <?php endif; ?>

    <div class="card">
      <div class="card-body">
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalPerusahaan" onclick="resetForm()">
          <i class="bx bx-plus"></i> Tambah Perusahaan
        </button>

        <div class="table-responsive">
          <table class="table table-striped table-bordered" id="perusahaanTable">
            <thead class="table-light">
              <tr>
                <th>No</th>
                <th>Logo</th>
                <th>Nama</th>
                <th>Email</th>
                <th>No. Telepon</th>
                <th>Website</th>
                <th>Alamat</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php if (empty($perusahaan)): ?>
                <tr><td colspan="8" class="text-center">Belum ada data</td></tr>
              <?php else: ?>
                <?php $no = 1; foreach ($perusahaan as $p): ?>
                  <tr>
                    <td><?= $no++ ?></td>
                    <td>
                      <?php if ($p->logo): ?>
                        <img src="<?= base_url('uploads/logo_perusahaan/' . $p->logo) ?>" alt="Logo" width="50">
                      <?php else: ?>
                        <span class="text-muted">Tidak ada</span>
                      <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($p->nama) ?></td>
                    <td><?= htmlspecialchars($p->email) ?></td>
                    <td><?= htmlspecialchars($p->no_telepon) ?></td>
                    <td><?= htmlspecialchars($p->website) ?></td>
                    <td><?= htmlspecialchars($p->alamat) ?></td>
                    <td>
                      <button class="btn btn-sm btn-warning" onclick='editPerusahaan(<?= json_encode($p) ?>)'>
                        <i class="bx bx-edit"></i>
                      </button>
                      <button 
                        class="btn btn-sm btn-danger" 
                        onclick="confirmDelete(<?= $p->id ?>, '<?= htmlspecialchars(addslashes($p->nama)) ?>')"
                        data-bs-toggle="modal" 
                        data-bs-target="#modalHapusGlobal"
                      >
                        <i class="bx bx-trash"></i>
                      </button>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Tambah/Edit -->
<div class="modal fade" id="modalPerusahaan" tabindex="-1" aria-labelledby="modalPerusahaanLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form method="post" action="<?= site_url('perusahaan/simpan') ?>" enctype="multipart/form-data" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalPerusahaanLabel">Tambah Perusahaan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="id" id="perusahaan-id">
        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label">Nama</label>
            <input type="text" name="nama" class="form-control" id="nama" required>
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" id="email">
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label">No. Telepon</label>
            <input type="text" name="no_telepon" class="form-control" id="no_telepon">
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label">Website</label>
            <input type="text" name="website" class="form-control" id="website">
          </div>
          <div class="col-12 mb-3">
            <label class="form-label">Alamat</label>
            <textarea name="alamat" class="form-control" id="alamat"></textarea>
          </div>
          <div class="col-12 mb-3">
            <label class="form-label">Logo (opsional)</label>
            <input type="file" name="logo" class="form-control" id="logo">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary"><i class="bx bx-save"></i> Simpan</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal Hapus Global -->
<div class="modal fade" id="modalHapusGlobal" tabindex="-1" aria-labelledby="hapusGlobalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="formHapus" method="post" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="hapusGlobalLabel">Konfirmasi Hapus</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        <p>Yakin ingin menghapus <strong id="namaPerusahaanHapus"></strong>?</p>
      </div>
      <div class="modal-footer">
        <?php if ($this->config->item('csrf_protection')): ?>
          <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
        <?php endif; ?>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
          <i class="bx bx-x"></i> Batal
        </button>
        <button type="submit" class="btn btn-danger">
          <i class="bx bx-trash"></i> Hapus
        </button>
      </div>
    </form>
  </div>
</div>


<script>
  function resetForm() {
    document.getElementById('modalPerusahaanLabel').textContent = 'Tambah Perusahaan';
    document.getElementById('perusahaan-id').value = '';
    document.getElementById('nama').value = '';
    document.getElementById('email').value = '';
    document.getElementById('no_telepon').value = '';
    document.getElementById('website').value = '';
    document.getElementById('alamat').value = '';
    document.getElementById('logo').value = '';
  }

  function editPerusahaan(data) {
    document.getElementById('modalPerusahaanLabel').textContent = 'Edit Perusahaan';
    document.getElementById('perusahaan-id').value = data.id;
    document.getElementById('nama').value = data.nama;
    document.getElementById('email').value = data.email;
    document.getElementById('no_telepon').value = data.no_telepon;
    document.getElementById('website').value = data.website;
    document.getElementById('alamat').value = data.alamat;
    new bootstrap.Modal(document.getElementById('modalPerusahaan')).show();
  }

  function confirmDelete(id, nama) {
    document.getElementById('namaPerusahaanHapus').textContent = nama;
    document.getElementById('formHapus').action = '<?= site_url("perusahaan/delete/") ?>' + id;
  }
</script>
