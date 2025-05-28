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
                          <h3>User Management</h3>
                           <button class="btn btn-success mb-3" onclick="showAddModal()">Tambah User</button>
                            <table id="userTable" class="display table table-striped">
                              <thead>
                                  <tr>
                                      <th>Username</th><th>Email</th><th>Role</th><th>Status</th><th>Aksi</th>
                                  </tr>
                              </thead>
                          </table>
                        </div>
                      </div>
                      <!-- Modal -->
                      <div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel">
                          <div class="modal-dialog" role="document">
                            <form id="userForm">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="modalTitle">Tambah User</h5>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                  </div>
                                  <div class="modal-body">
                                    <input type="hidden" id="id_user" name="id_user">
                                    <div class="form-group">
                                        <label>Username</label>
                                        <input type="text" class="form-control" name="username" id="username">
                                    </div>
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" class="form-control" name="email" id="email">
                                    </div>
                                    <div class="form-group password-field">
                                        <label>Password</label>
                                        <input type="password" class="form-control" name="password" id="password">
                                    </div>
                                    <div class="form-group">
                                        <label>Role</label>
                                        <select name="role" id="role" class="form-control">
                                            <option value="admin">Admin</option>
                                            <option value="alumni">Alumni</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select name="status" id="status" class="form-control">
                                            <option value="aktif">Aktif</option>
                                            <option value="nonaktif">Nonaktif</option>
                                        </select>
                                    </div>
                                  </div>
                                  <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                  </div>
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
            <!-- / Content -->
            

            