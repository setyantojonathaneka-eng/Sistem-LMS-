<div id="modal-materi" class="modal-bg">
  <div class="modal">
    <div class="modal-header">
      <span class="modal-title">Upload Materi</span>
      <button type="button" class="modal-close" onclick="closeModal('modal-materi')">&times;</button>
    </div>

    <form method="POST" action="{{ route('admin.lessons.store') }}" enctype="multipart/form-data">
      @csrf

      <div class="modal-body">

        <div class="form-group">
          <label class="form-label">Kursus</label>
          <select name="course_id" class="form-control" required>
            <option value="">-- Pilih Kursus --</option>
            @foreach($recent_courses as $course)
              <option value="{{ $course->id }}">{{ $course->title }}</option>
            @endforeach
          </select>
        </div>

        <div class="form-group">
          <label class="form-label">Judul Materi</label>
          <input type="text" name="title" class="form-control" placeholder="Contoh: Pengenalan Laravel" required>
        </div>

        <div class="form-group">
          <label class="form-label">Tipe Materi</label>
          <select name="type" class="form-control" required>
            <option value="video">🎬 Video</option>
            <option value="pdf">📄 PDF</option>
          </select>
        </div>

        <div class="form-group">
          <label class="form-label">Urutan (opsional)</label>
          <input type="number" name="order" class="form-control" min="1" placeholder="Urutan otomatis jika dikosongkan">
        </div>

        {{-- Toggle sumber konten: Upload File atau Paste Link --}}
        <div class="form-group">
          <label class="form-label">Sumber Materi</label>
          <div style="display:flex;gap:16px;margin-bottom:8px;">
            <label style="display:flex;align-items:center;gap:6px;font-size:13px;font-weight:400;">
              <input type="radio" name="source_mode" value="upload" checked onchange="toggleMateriSource(this)"> Upload File
            </label>
            <label style="display:flex;align-items:center;gap:6px;font-size:13px;font-weight:400;">
              <input type="radio" name="source_mode" value="link" onchange="toggleMateriSource(this)"> Paste Link
            </label>
          </div>

          <div id="materiUploadField">
            <input type="file" name="file" class="form-control">
            <div class="text-sm text-muted" style="margin-top:4px;">Video: mp4, mov, avi, mkv &middot; PDF: pdf</div>
          </div>

          <div id="materiLinkField" style="display:none;">
            <input type="url" name="external_url" class="form-control" placeholder="https://youtube.com/watch?v=... atau link PDF">
          </div>
        </div>

      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-outline" onclick="closeModal('modal-materi')">Batal</button>
        <button type="submit" class="btn btn-primary">Upload Materi</button>
      </div>
    </form>
  </div>
</div>

<script>
function toggleMateriSource(radio) {
    const uploadField = document.getElementById('materiUploadField');
    const linkField = document.getElementById('materiLinkField');
    if (radio.value === 'upload') {
        uploadField.style.display = 'block';
        linkField.style.display = 'none';
    } else {
        uploadField.style.display = 'none';
        linkField.style.display = 'block';
    }
}
</script>