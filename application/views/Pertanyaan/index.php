<!-- Content wrapper -->
<div class="content-wrapper">
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><i class="bx bx-question-mark me-2"></i> Pertanyaan Survey</h4>

    <?php if ($this->session->flashdata('success')): ?>
      <div class="alert alert-success alert-dismissible" role="alert">
        <?= $this->session->flashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <?php endif; ?>

    <div class="card">
      <div class="card-body">
        <button class="btn btn-primary mb-3" onclick="resetForm()" data-bs-toggle="modal" data-bs-target="#modalForm">
          <i class="bx bx-plus"></i> Tambah Pertanyaan
        </button>

        <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#modalImport">
          <i class="bx bx-upload"></i> Import Excel
        </button>

        <div class="table-responsive">
          <table class="table table-bordered table-striped" id="pertanyaanTable">
            <thead class="table-light">
              <tr>
                <th>No</th>
                <th>Pertanyaan</th>
                <th>Tipe</th>
                <th>Pilihan</th>
                <th>Wajib</th>
                <th>Urutan</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php if (empty($pertanyaan)): ?>
                <tr><td colspan="7" class="text-center">Belum ada data</td></tr>
              <?php else: ?>
                <?php $no = 1; foreach ($pertanyaan as $p): ?>
                  <tr>
                    <td><?= htmlspecialchars($no++) ?></td>
                    <td><?= htmlspecialchars($p->pertanyaan ?? '') ?></td>
                    <td><span class="badge bg-info"><?= htmlspecialchars($p->tipe ?? '') ?></span></td>
                    <td><?= nl2br(htmlspecialchars($p->pilihan ?? '')) ?></td>
                    <td><?= !empty($p->is_required) ? 'Ya' : 'Tidak' ?></td>
                    <td><?= htmlspecialchars($p->urutan ?? '') ?></td>
                    <td>
                      <button class="btn btn-sm btn-warning" onclick='editData(<?= json_encode($p, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>)' data-bs-toggle="modal" data-bs-target="#modalForm">
                        <i class="bx bx-edit"></i>
                      </button>
                      <button class="btn btn-sm btn-danger" onclick="setDeleteId(<?= (int) $p->id ?>)" data-bs-toggle="modal" data-bs-target="#modalHapus">
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
<div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="modalFormLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="<?= site_url('pertanyaan/simpan') ?>" method="post" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalFormLabel">Tambah Pertanyaan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="id" id="id">
        <div class="mb-3">
          <label class="form-label">Pertanyaan</label>
          <textarea name="pertanyaan" id="pertanyaan" class="form-control" required></textarea>
        </div>
        <div class="mb-3">
          <label class="form-label">Tipe</label>
          <select name="tipe" id="tipe" class="form-select" required onchange="togglePilihan()">
            <option value="isian">Isian</option>
            <option value="pilihan_ganda">Pilihan Ganda</option>
            <option value="skala">Skala</option>
          </select>
        </div>
        <div class="mb-3" id="pilihan-group" style="display: none;">
          <label class="form-label">Pilihan (pisahkan dengan koma)</label>
          <textarea name="pilihan" id="pilihan" class="form-control"></textarea>
        </div>
        <div class="mb-3">
          <label class="form-label">Urutan</label>
          <input type="number" name="urutan" id="urutan" class="form-control" value="0">
        </div>
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="is_required" id="is_required" checked>
          <label class="form-check-label" for="is_required">Wajib Diisi</label>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary"><i class="bx bx-save"></i> Simpan</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal Hapus -->
<div class="modal fade" id="modalHapus" tabindex="-1" aria-labelledby="modalHapusLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="post" id="formDelete" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalHapusLabel">Konfirmasi Hapus</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        <p>Apakah Anda yakin ingin menghapus pertanyaan ini?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-danger"><i class="bx bx-trash"></i> Hapus</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal Import Excel -->
<div class="modal fade" id="modalImport" tabindex="-1" aria-labelledby="modalImportLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="<?= base_url('pertanyaan/import') ?>" method="post" enctype="multipart/form-data" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalImportLabel">Import Pertanyaan dari Excel</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label for="file_excel" class="form-label">Pilih File Excel (.xlsx)</label>
          <input type="file" name="file_excel" id="file_excel" class="form-control" required accept=".xlsx,.xls">
        </div>
        <div class="alert alert-info">
          <strong>Catatan:</strong> Format Excel harus sesuai template.
          <br>
          <a href="<?= base_url('assets/template/template_pertanyaan.xlsx') ?>" class="btn btn-sm btn-outline-secondary mt-2">
            <i class="bx bx-download"></i> Unduh Template
          </a>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-success"><i class="bx bx-upload"></i> Import</button>
      </div>
    </form>
  </div>
</div>

<script>
  function resetForm() {
    document.getElementById('modalFormLabel').textContent = 'Tambah Pertanyaan';
    document.getElementById('id').value = '';
    document.getElementById('pertanyaan').value = '';
    document.getElementById('tipe').value = 'isian';
    document.getElementById('pilihan').value = '';
    document.getElementById('urutan').value = '0';
    document.getElementById('is_required').checked = true;
    togglePilihan();
  }

  function editData(data) {
    document.getElementById('modalFormLabel').textContent = 'Edit Pertanyaan';
    document.getElementById('id').value = data.id;
    document.getElementById('pertanyaan').value = data.pertanyaan;
    document.getElementById('tipe').value = data.tipe;
    document.getElementById('pilihan').value = data.pilihan;
    document.getElementById('urutan').value = data.urutan;
    document.getElementById('is_required').checked = data.is_required == 1;
    togglePilihan();
  }

  function togglePilihan() {
    const tipe = document.getElementById('tipe').value;
    const pilihanGroup = document.getElementById('pilihan-group');
    pilihanGroup.style.display = (tipe === 'pilihan_ganda' || tipe === 'skala') ? 'block' : 'none';
  }

  function setDeleteId(id) {
    document.getElementById('formDelete').action = '<?= site_url('pertanyaan/delete/') ?>' + id;
  }
</script>
