<div id="modal-cert" class="modal-bg" onclick="if(event.target===this)closeModal('modal-cert')">
  <div class="modal">
    <div class="modal-header">
      <span>Generate Sertifikat</span>
      <button class="btn-close" onclick="closeModal('modal-cert')">&times;</button>
    </div>
    <form method="POST" action="{{ route('admin.certificates.store') }}">
      @csrf
      <div class="modal-body">
        <div class="form-group">
          <label>Siswa</label>
          <select name="user_id" required>
            @foreach (\App\Models\User::where('role', 'student')->get() as $s)
              <option value="{{ $s->id }}">{{ $s->name }} ({{ $s->email }})</option>
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <label>Kursus</label>
          <select name="course_id" required>
            @foreach (\App\Models\Course::where('is_published', true)->get() as $c)
              <option value="{{ $c->id }}">{{ $c->title }}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline" onclick="closeModal('modal-cert')">Batal</button>
        <button type="submit" class="btn btn-primary">Generate</button>
      </div>
    </form>
  </div>
</div>
