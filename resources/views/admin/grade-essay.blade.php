<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penilaian Essay - {{ $quiz->title }}</title>
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
        <div class="topbar-title">Penilaian Essay — {{ $quiz->title }}</div>
        <div class="topbar-actions">
            <a href="{{ route('admin.quizzes.questions.index', $quiz->id) }}" class="btn btn-outline">&larr; Kembali ke Soal</a>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline">&larr; Dashboard</a>
        </div>
    </div>

    <div style="padding:2rem;">

        @if (session('success'))
            <div class="alert alert-info" style="margin-bottom:1.25rem; background:var(--green-50); color:var(--green-600);">
                {{ session('success') }}
            </div>
        @endif

        @php
            $attemptsWithEssay = $quiz->attempts->filter(fn($a) => $a->attemptAnswers->isNotEmpty());
            $grouped = $attemptsWithEssay->groupBy('user_id');
        @endphp

        @forelse ($grouped as $userId => $userAttempts)
            @php $user = $userAttempts->first()->user; @endphp
            <div class="card" style="margin-bottom:1.25rem;">
                <div class="card-header">
                    <span class="card-title">{{ $user->name ?? 'User #'.$userId }}</span>
                    <span style="font-size:12px; color:var(--gray-400);">
                        {{ $userAttempts->count() }}x attempt · Nilai akhir: {{ $userAttempts->sortByDesc('id')->first()->score ?? '—' }}
                    </span>
                </div>
                @foreach ($userAttempts->sortByDesc('id') as $attempt)
                    <div class="card-body" style="border-bottom:1px solid var(--gray-100); padding:16px;">
                        <div style="font-size:12px; color:var(--gray-400); margin-bottom:8px;">
                            Attempt #{{ $attempt->id }} · {{ $attempt->created_at->format('d M Y H:i') }}
                        </div>
                        <form method="POST" action="{{ route('admin.quizzes.grade.update', [$quiz->id, $attempt->id]) }}">
                            @csrf
                            @foreach ($attempt->attemptAnswers as $aa)
                                @php $q = $aa->question; @endphp
                                @if ($q && $q->type === 'essay')
                                    <div style="margin-bottom:12px; padding:10px; background:#F9F7F5; border-radius:8px;">
                                        <div style="font-weight:500; font-size:13px; margin-bottom:4px; color:#2C4A5E;">
                                            {{ $q->question }}
                                        </div>
                                        <div style="font-size:13px; color:#6b5f52; background:white; padding:10px; border-radius:6px; border:1px solid var(--gray-100); margin-bottom:8px; white-space:pre-wrap;">
                                            {{ $aa->answer_text ?? '<em>tidak dijawab</em>' }}
                                        </div>
                                        <div style="display:flex; align-items:center; gap:8px;">
                                            <label style="font-size:12px; color:var(--gray-400);">Nilai (0-100):</label>
                                            <input type="number" name="scores[{{ $aa->id }}]" min="0" max="100"
                                                   value="{{ $aa->score ?? '' }}" class="form-control"
                                                   style="width:100px; padding:4px 8px; font-size:13px;">
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                            <button type="submit" class="btn btn-primary btn-sm">Simpan Nilai</button>
                        </form>
                    </div>
                @endforeach
            </div>
        @empty
            <div class="card">
                <div class="card-body">
                    <div style="color:var(--gray-400); font-size:13px;">Belum ada jawaban essay yang perlu dinilai.</div>
                </div>
            </div>
        @endforelse

    </div>
  </div>
</div>
</body>
</html>
