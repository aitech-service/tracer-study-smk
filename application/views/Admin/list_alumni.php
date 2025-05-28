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
                <h2 class="card-title text-primary"><?= $title ?></h2>

                <!-- Filter dan Tombol Export -->
                <div class="row align-items-end mb-3">
                  <div class="col-md-2">
                    <label for="filterStatus" class="form-label">Status Aktivitas</label>
                    <select id="filterStatus" class="form-select form-select-sm">
                      <option value="">-- Pilih --</option>
                      <option value="Kuliah">Kuliah</option>
                      <option value="Bekerja">Bekerja</option>
                      <option value="Wirausaha">Wirausaha</option>
                      <option value="Belum Bekerja">Belum Bekerja</option>
                    </select>
                  </div>
                  <div class="col-md-2">
                    <label for="filterAngkatan" class="form-label">Angkatan</label>
                    <select id="filterAngkatan" class="form-select form-select-sm">
                      <option value="">-- Pilih --</option>
                      <?php foreach ($angkatan_list as $a): ?>
                        <option value="<?= $a['angkatan'] ?>"><?= $a['angkatan'] ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="col-md-2">
                    <label for="filterJurusan" class="form-label">Jurusan</label>
                    <select id="filterJurusan" class="form-select form-select-sm">
                      <option value="">-- Pilih --</option>
                      <?php foreach ($jurusan_list as $j): ?>
                        <option value="<?= $j['jurusan'] ?>"><?= $j['jurusan'] ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="col-md-2">
                    <button id="resetFilter" class="btn btn-danger btn-sm w-100 mt-2">
                      <i class="bx bx-rotate-ccw"></i> Reset
                    </button>
                  </div>
                  <div class="col-md-4 text-end">
                    <label class="form-label d-block"><strong>Export:</strong></label>
                    <div class="btn-group" role="group">
                      <a href="<?= base_url('admin/export_pdf') ?>"  class="btn btn-danger btn-sm">
                        <i class="bx bx-file"></i> PDF
                      </a>
                      <a href="<?= base_url('alumni/export_excel') ?>" class="btn btn-success btn-sm">
                        <i class="bx bx-file"></i> Excel
                      </a>
                      <button onclick="window.print()" class="btn btn-secondary btn-sm">
                        <i class="bx bx-printer"></i> Print
                      </button>
                    </div>
                  </div>
                </div>

                <!-- Table Alumni -->
                <div class="table-responsive">
                  <table id="alumniTable" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Angkatan</th>
                        <th>Jurusan</th>
                        <th>Email</th>
                        <th>No HP</th>
                        <th>Status</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $no = 1; foreach ($alumni as $row): ?>
                        <tr>
                          <td><?= $no++ ?></td>
                          <td><?= $row->nama ?></td>
                          <td><?= $row->angkatan ?></td>
                          <td><?= $row->jurusan ?></td>
                          <td><?= $row->email ?></td>
                          <td><?= $row->no_hp ?></td>
                          <td><?= $row->status_aktifitas ?></td>
                          <td>
                            <a href="<?= base_url('admin/detail_alumni/' . $row->id_user) ?>" class="btn btn-sm btn-info">Detail</a>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>

              </div> <!-- /card-body -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- / Content -->
</div>
