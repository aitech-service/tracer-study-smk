<!-- Footer -->
            <footer class="content-footer footer bg-footer-theme">
              <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                <div class="mb-2 mb-md-0">
                  ©
                  <script>
                    document.write(new Date().getFullYear());
                  </script>
                  , made by  
                  <a href="https://instagram.com/servicelaptop.gresik" target="_blank" class="footer-link fw-bolder">AITECH</a>
                </div>
                <div>
                  Developer : <a href="https://facebook.com/alphie399" class="footer-link me-4 fw-bolder" target="_blank">Alphi Rosyidi</a>
                  Template Admin : <a href="https://themewagon.com/themes/free-responsive-bootstrap-5-html5-admin-template-sneat/" target="_blank" class="footer-link me-4 fw-bolder">Sneat Admin</a>
                </div>
              </div>
            </footer>
            <!-- / Footer -->

            <div class="content-backdrop fade"></div>
          </div>
          <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="<?php echo base_url('assets')?>/assets/vendor/libs/jquery/jquery.js"></script>
    <script src="<?php echo base_url('assets')?>/assets/vendor/libs/popper/popper.js"></script>
    <script src="<?php echo base_url('assets')?>/assets/vendor/js/bootstrap.js"></script>
    <script src="<?php echo base_url('assets')?>/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="<?php echo base_url('assets')?>/assets/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


    <!-- Vendors JS -->
    <script src="<?php echo base_url('assets')?>/assets/vendor/libs/apex-charts/apexcharts.js"></script>

    <!-- Main JS -->
    <script src="<?php echo base_url('assets')?>/assets/js/main.js"></script>

    <!-- Page JS -->
    <script src="<?php echo base_url('assets')?>/assets/js/dashboards-analytics.js"></script>

    <!-- Place this tag in your head or just before your close body tag. -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    <!--DataTables-->
    <script src="<?php echo base_url('assets')?>/datatables/datatables.js"></script>
    <script src="<?php echo base_url('assets')?>/datatables/datatables.min.js"></script>

    <script async defer src="https://buttons.github.io/buttons.js"></script>

    <!--Status Aktifitas-->
    <script>
    function toggleAktifitas() {
      const val = document.getElementById('status_aktifitas').value;
      document.getElementById('form_bekerja').style.display = val === 'Bekerja' ? 'block' : 'none';
      document.getElementById('form_kuliah').style.display = val === 'Kuliah' ? 'block' : 'none';
      document.getElementById('form_usaha').style.display  = val === 'Wirausaha' ? 'block' : 'none';
    }
    document.addEventListener("DOMContentLoaded", toggleAktifitas);
    </script>

    <!--sweetalert-->
    <script>
      <?php if ($this->session->flashdata('success')): ?>
        Swal.fire({
          icon: 'success',
          title: 'Sukses!',
          text: '<?= $this->session->flashdata('success'); ?>',
          confirmButtonText: 'OK'
        });
      <?php elseif ($this->session->flashdata('error')): ?>
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: '<?= $this->session->flashdata('error'); ?>',
          confirmButtonText: 'OK'
        });
      <?php endif; ?>
    </script>    


    <!--preview foto-->
    <script>
      document.getElementById('foto-input').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const preview = document.getElementById('foto-preview');

        if (file && file.type.startsWith('image/')) {
          const reader = new FileReader();
          reader.onload = function(e) {
            preview.src = e.target.result;
          }
          reader.readAsDataURL(file);
        } else {
          preview.src = "<?= base_url('assets/assets/img/default.png') ?>"; // fallback jika bukan gambar
        }
      });
    </script>
    <!--DataTables-->
    <script type="text/javascript">
      new DataTable('#alat');
    </script>

    <script>
      $(document).ready(function() {
          $('#alumniTable').DataTable();
      });
    
      $(document).ready(function() {
          $('#testimoniTable').DataTable();
      });
    
      $(document).ready(function() {
          $('#testimoniAdminTable').DataTable();
      });

      $(document).ready(function() {
          $('#perusahaanTable').DataTable();
      });

      $(document).ready(function() {
          $('#pertanyaanTable').DataTable();
      });       
    </script>
  <!--DataTables-->
  
  <script>
    function goBack() {
      window.history.back();
    }
  </script>

    <script>
    let isEdit = false;

    $(document).ready(function() {
        $('#userTable').DataTable({
            ajax: {
                url: '<?= base_url("usermanagement/ajax_list") ?>',
                dataSrc: 'data'
            }
        });

        $('#userForm').on('submit', function(e) {
            e.preventDefault();
            const url = isEdit ? '<?= base_url("usermanagement/ajax_update") ?>' : '<?= base_url("usermanagement/ajax_add") ?>';
            $.ajax({
                type: 'POST',
                url: url,
                data: $('#userForm').serialize(),
                dataType: 'json',
                success: function(res) {
                    if (res.status) {
                        $('#userModal').modal('hide');
                        $('#userTable').DataTable().ajax.reload();
                        Swal.fire('Berhasil', isEdit ? 'Data diperbarui' : 'Data ditambahkan', 'success');
                    } else {
                        Swal.fire('Gagal', res.errors, 'error');
                    }
                }
            });
        });
    });

    function showAddModal() {
        isEdit = false;
        $('#userForm')[0].reset();
        $('#id_user').val('');
        $('#username').prop('readonly', false);
        $('.password-field').show();
        $('#modalTitle').text('Tambah User');
        $('#userModal').modal('show');
    }

    function editUser(id) {
        isEdit = true;
        $.get('<?= base_url("usermanagement/ajax_edit/") ?>' + id, function(data) {
            $('#id_user').val(data.id_user);
            $('#username').val(data.username).prop('readonly', true);
            $('#email').val(data.email);
            $('#role').val(data.role);
            $('#status').val(data.status);
            $('.password-field').hide(); // tidak ubah password
            $('#modalTitle').text('Edit User');
            $('#userModal').modal('show');
        }, 'json');
    }

    function deleteUser(id) {
        Swal.fire({
            title: 'Hapus user?',
            text: "Data tidak bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus'
        }).then((result) => {
            if (result.isConfirmed) {
                $.get('<?= base_url("usermanagement/ajax_delete/") ?>' + id, function() {
                    Swal.fire('Dihapus!', 'User telah dihapus.', 'success');
                    $('#userTable').DataTable().ajax.reload();
                });
            }
        });
    }
</script>

    <script>
    $(document).ready(function() {
        var table = $('#alumniTable').DataTable();


    // Tombol Reset Filter
    $('#resetFilter').on('click', function () {
        // Reset semua filter dropdown
        $('#filterStatus').val('');
        $('#filterAngkatan').val('');
        $('#filterJurusan').val('');

        // Trigger ulang filter manual (jika pakai column().search())
        table.columns(2).search(''); // angkatan
        table.columns(3).search(''); // jurusan
        table.columns(6).search(''); // status aktifitas
        table.draw();
    });

        // Filter jurusan
        $('#filterJurusan').on('change', function() {
            table.column(3).search(this.value).draw(); // kolom ke-4 (index 3)
        });

        // Filter angkatan
        $('#filterAngkatan').on('change', function() {
            table.column(2).search(this.value).draw(); // kolom ke-3 (index 2)
        });

        // Filter status aktifitas
        $('#filterStatus').on('change', function() {
            table.column(6).search(this.value).draw(); // kolom ke-7 (index 6)
        });
    });
    </script>

  </body>
</html>
