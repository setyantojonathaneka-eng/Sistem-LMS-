<div id="modal-user" class="modal-bg" onclick="if(event.target===this)closeModal('modal-user')">
  <div class="modal">
    <div class="modal-header">
      <span>Tambah User</span>
      <button class="btn-close" onclick="closeModal('modal-user')">&times;</button>
    </div>
    <form method="POST" action="{{ route('admin.users.store') }}">
      @csrf
      <div class="modal-body">
        <div class="form-group">
          <label>Nama Lengkap</label>
          <input type="text" name="name" class="form-control" required>
        </div>
        <div class="form-group">
          <label>Email</label>
          <input type="email" name="email" class="form-control" required>
        </div>
        <div class="form-group">
          <label>Role</label>
          <select name="role" class="form-control" required>
            <option value="student">Student</option>
            <option value="instructor">Instructor</option>
            <option value="admin">Admin</option>
          </select>
        </div>
        <div class="form-group">
          <label>Password</label>
          <input type="password" name="password" class="form-control" required min="8">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline" onclick="closeModal('modal-user')">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
    </form>
  </div>
</div>
