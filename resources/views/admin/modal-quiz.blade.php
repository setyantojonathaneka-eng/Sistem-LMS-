<div id="modal-quiz" class="modal-bg">
  <div class="modal">
    <div class="modal-header">
      <span class="modal-title">Buat Quiz</span>
      <button type="button" class="modal-close" onclick="closeModal('modal-quiz')">&times;</button>
    </div>

    <form method="POST" action="{{ route('admin.quizzes.store') }}">
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
          <label class="form-label">Judul Quiz</label>
          <input type="text" name="title" class="form-control" placeholder="Contoh: Quiz Bab 1 - Dasar Laravel" required>
        </div>

        <div class="form-group">
          <label class="form-label">Nilai Lulus (Passing Score)</label>
          <input type="number" name="passing_score" class="form-control" min="0" max="100" placeholder="Contoh: 70" required>
        </div>

      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-outline" onclick="closeModal('modal-quiz')">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan Quiz</button>
      </div>
    </form>
  </div>
</div>