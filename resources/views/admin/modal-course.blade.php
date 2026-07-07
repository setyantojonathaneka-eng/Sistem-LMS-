@php
    $instructors = \App\Models\User::where('role', 'instructor')->get();
@endphp

<div id="modal-course" class="modal-bg">
  <div class="modal">
    <div class="modal-header">
      <span class="modal-title">Tambah Kursus</span>
      <button type="button" class="modal-close" onclick="closeModal('modal-course')">&times;</button>
    </div>

    <form method="POST" action="{{ route('admin.courses.store') }}">
      @csrf

      <div class="modal-body">

        <div class="form-group">
          <label class="form-label">Judul Kursus</label>
          <input type="text" name="title" class="form-control" placeholder="Contoh: Belajar Laravel Dasar" required>
        </div>

        <div class="form-group">
          <label class="form-label">Deskripsi</label>
          <textarea name="description" class="form-control" rows="3" placeholder="Deskripsi singkat kursus..."></textarea>
        </div>

        <div class="form-group">
          <label class="form-label">Instructor</label>
          <select name="instructor_id" class="form-control" required>
            <option value="">-- Pilih Instructor --</option>
            @foreach($instructors as $instructor)
              <option value="{{ $instructor->id }}">{{ $instructor->name }}</option>
            @endforeach
          </select>
        </div>

        <div class="form-group">
          <label class="form-label">Status</label>
          <select name="is_published" class="form-control" required>
            <option value="1">Aktif</option>
            <option value="0">Draft</option>
          </select>
        </div>

      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-outline" onclick="closeModal('modal-course')">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan Kursus</button>
      </div>
    </form>
  </div>
</div>