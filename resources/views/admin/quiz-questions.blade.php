<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Soal - {{ $quiz->title }}</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    @vite(['resources/css/admin.css', 'resources/js/admin.js'])
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css"/>
</head>
<body>
<div class="layout">
  <div class="main-content" style="margin-left:0; width:100%;">

    <div class="topbar">
        <div class="topbar-title">Kelola Soal — {{ $quiz->title }}</div>
        <div class="topbar-actions">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline">&larr; Kembali ke Dashboard</a>
        </div>
    </div>

    <div style="padding:2rem;">

        @if (session('success'))
            <div class="alert alert-info" style="margin-bottom:1.25rem; background:var(--green-50); color:var(--green-600);">
                {{ session('success') }}
            </div>
        @endif

        <div class="alert alert-info" style="margin-bottom:1.25rem;">
            Kursus: <strong>{{ $quiz->course->title ?? '—' }}</strong> ·
            Nilai Lulus: <strong>{{ $quiz->passing_score }}</strong> ·
            Total Soal: <strong>{{ $quiz->questions->count() }}</strong> ·
            <a href="{{ route('admin.quizzes.grade.index', $quiz->id) }}" style="color:var(--blue-600); font-weight:600;">
                Penilaian Essay &rarr;
            </a>
        </div>

        {{-- Form tambah soal --}}
        <div class="card" style="margin-bottom:1.25rem;">
            <div class="card-header"><span class="card-title">Tambah Soal Baru</span></div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.quizzes.questions.store', $quiz->id) }}">
                    @csrf

                    <div class="form-group">
                        <label class="form-label">Pertanyaan</label>
                        <textarea name="question" class="form-control" rows="3" required placeholder="Tulis pertanyaan di sini...">{{ old('question') }}</textarea>
                        @error('question') <div class="text-sm" style="color:var(--red-600);">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Tipe Soal</label>
                        <select name="type" class="form-control" id="questionType" onchange="toggleQuestionType()">
                            <option value="multiple_choice" {{ old('type') === 'essay' ? '' : 'selected' }}>Pilihan Ganda</option>
                            <option value="essay" {{ old('type') === 'essay' ? 'selected' : '' }}>Uraian (Essay)</option>
                        </select>
                    </div>

                    <div id="mcFields">
                        <label class="form-label">Pilihan Jawaban (pilih salah satu sebagai jawaban benar)</label>
                        @for ($i = 0; $i < 4; $i++)
                            <div class="form-group" style="display:flex; align-items:center; gap:10px;">
                                <input type="radio" name="correct_answer" value="{{ $i }}" required
                                    {{ old('correct_answer') == $i ? 'checked' : '' }}>
                                <input type="text" name="answers[]" class="form-control"
                                    placeholder="Pilihan jawaban {{ chr(65 + $i) }}"
                                    value="{{ old('answers.' . $i) }}" required>
                            </div>
                        @endfor
                        @error('answers.*') <div class="text-sm" style="color:var(--red-600);">{{ $message }}</div> @enderror
                        @error('correct_answer') <div class="text-sm" style="color:var(--red-600);">{{ $message }}</div> @enderror
                    </div>

                    <div id="essayFields" style="display:none;">
                        <div class="form-group">
                            <label class="form-label">Kunci Jawaban (opsional, untuk referensi)</label>
                            <textarea name="key_answer" class="form-control" rows="2" placeholder="Tulis kunci jawaban di sini...">{{ old('key_answer') }}</textarea>
                        </div>
                    </div>

                    <script>
                    function toggleQuestionType() {
                        var type = document.getElementById('questionType').value;
                        document.getElementById('mcFields').style.display = type === 'essay' ? 'none' : '';
                        document.getElementById('essayFields').style.display = type === 'essay' ? '' : 'none';
                        var mcInputs = document.querySelectorAll('#mcFields input, #mcFields select');
                        var essayInputs = document.querySelectorAll('#essayFields input, #essayFields textarea');
                        mcInputs.forEach(function(el) { el.required = type !== 'essay'; });
                        essayInputs.forEach(function(el) { el.required = type === 'essay'; });
                    }
                    toggleQuestionType();
                    </script>

                    <div style="margin-top:1rem;">
                        <button type="submit" class="btn btn-primary">Simpan Soal</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Daftar soal yang sudah ada --}}
        <div class="card">
            <div class="card-header"><span class="card-title">Daftar Soal</span></div>
            <div class="card-body">
                @forelse($quiz->questions as $index => $question)
                    <div style="border-bottom:1px solid var(--gray-100); padding:14px 0;">
                        <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                            <div style="flex:1;">
                                <div style="font-weight:500; margin-bottom:8px;">
                                    {{ $index + 1 }}. {{ $question->question }}
                                    <span style="display:inline-block; font-size:11px; font-weight:500; padding:2px 8px; border-radius:999px; margin-left:8px; vertical-align:middle;
                                        {{ $question->type === 'essay' ? 'background:#FEF3C7; color:#92400E;' : 'background:#DCEBFA; color:#1E40AF;' }}">
                                        {{ $question->type === 'essay' ? 'Uraian' : 'Pilihan Ganda' }}
                                    </span>
                                </div>
                                @if ($question->type === 'essay')
                                    @php $keyAns = $question->answers->first(); @endphp
                                    @if ($keyAns)
                                        <div style="font-size:13px; color:var(--gray-500); margin-top:4px;">
                                            <em>Kunci: {{ $keyAns->answer }}</em>
                                        </div>
                                    @endif
                                @else
                                <ul style="margin:0; padding-left:20px; font-size:13px;">
                                    @foreach ($question->answers as $answer)
                                        <li style="{{ $answer->is_correct ? 'color:var(--green-600); font-weight:600;' : '' }}">
                                            {{ $answer->answer }}
                                            @if ($answer->is_correct) &nbsp;✓ Benar @endif
                                        </li>
                                    @endforeach
                                </ul>
                                @endif
                            </div>
                            <form method="POST" action="{{ route('admin.quizzes.questions.destroy', [$quiz->id, $question->id]) }}"
                                  onsubmit="return confirm('Hapus soal ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div style="color:var(--gray-400); font-size:13px;">Belum ada soal untuk quiz ini.</div>
                @endforelse
            </div>
        </div>

    </div>
  </div>
</div>
</body>
</html>