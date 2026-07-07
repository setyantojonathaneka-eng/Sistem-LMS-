@extends('student')

@section('title', $quiz->title)

@section('content')
<div class="max-w-2xl"
     x-data="{
        answers: {},
        essayAnswers: {},
        result: null,
        totalQuestions: {{ $quiz->questions->count() }},
        answeredCount() {
            let mc = Object.keys(this.answers).length;
            let essay = 0;
            @foreach ($quiz->questions as $i => $q)
                @if ($q->type === 'essay')
                    if (this.essayAnswers[{{ $q->id }}]?.trim()) essay++;
                @endif
            @endforeach
            return mc + essay;
        },
        submit() {
            let correct = 0;
            let totalMC = 0;
            @foreach ($quiz->questions as $i => $q)
                @if ($q->type !== 'essay')
                    totalMC++;
                    if (this.answers[{{ $q->id }}] === {{ $q->answers->where('is_correct', true)->first()->id ?? 'null' }}) correct++;
                @endif
            @endforeach
            let score = totalMC > 0 ? Math.round((correct / totalMC) * 100) : 100;
            this.result = { correct, total: this.totalQuestions, score, hasEssay: {{ $quiz->questions->where('type', 'essay')->count() > 0 ? 'true' : 'false' }} };
        }
     }">

    <a href="{{ route('student.quiz.index') }}" class="text-sm text-[#8a7d70] mb-3 flex items-center gap-1">
        <span class="material-symbols-outlined" style="font-size:14px;transform:rotate(180deg)">chevron_right</span> Daftar Kuis
    </a>

    <h2 class="text-2xl font-extrabold mb-5" style="color:#2C4A5E">{{ $quiz->title }}</h2>

    <!-- Hasil (tampil setelah submit) -->
    <div x-show="result" x-cloak class="bg-white rounded-2xl p-8 border border-black/[0.04] shadow-sm text-center lms-fade">
        <div class="w-20 h-20 mx-auto rounded-full flex items-center justify-center mb-4"
             :style="result && result.score >= {{ $quiz->passing_score }} ? 'background:#DDF2DC' : 'background:#FBDFD9'">
            <span class="text-2xl font-extrabold" x-text="result?.score" :style="result && result.score >= {{ $quiz->passing_score }} ? 'color:#3E8B45' : 'color:#C05545'"></span>
        </div>
        <h3 class="text-xl font-extrabold" style="color:#2C4A5E" x-text="result && result.score >= {{ $quiz->passing_score }} ? 'Selamat, Lulus!' : 'Belum Lulus'"></h3>
        <p class="text-sm text-[#8a7d70] mt-1">
            <span x-text="result?.correct"></span> benar
            <template x-if="result?.hasEssay">
                <span class="text-[#92400E]"> · soal uraian akan dinilai oleh pengajar</span>
            </template>
        </p>
        <div class="flex gap-3 justify-center mt-5">
            <button @click="answers = {}; essayAnswers = {}; result = null" class="px-5 py-2.5 rounded-xl text-sm font-semibold" style="background:#F0EAE4; color:#2C4A5E">Ulangi</button>

            <!-- Kirim semua jawaban ke server -->
            <form action="{{ route('student.quiz.submit', $quiz->id) }}" method="POST">
                @csrf
                <template x-for="(val, key) in answers">
                    <input type="hidden" :name="'answers[' + key + ']'" :value="val">
                </template>
                <template x-for="(val, key) in essayAnswers">
                    <input type="hidden" :name="'essay[' + key + ']'" :value="val">
                </template>
                <input type="hidden" name="has_essay" value="1">
                <button type="submit" class="px-5 py-2.5 rounded-xl text-sm font-semibold text-white" style="background:#2C4A5E">Selesai</button>
            </form>
        </div>
    </div>

    <!-- Daftar soal -->
    <div x-show="!result" class="flex flex-col gap-4">
        @foreach ($quiz->questions as $i => $q)
            <div class="bg-white rounded-2xl p-5 border border-black/[0.04] shadow-sm">
                <div class="flex items-center gap-2 mb-3">
                    <p class="font-semibold" style="color:#2C4A5E">{{ $i + 1 }}. {{ $q->question }}</p>
                    @if ($q->type === 'essay')
                        <span style="font-size:11px; font-weight:500; padding:2px 8px; border-radius:999px; background:#FEF3C7; color:#92400E;">Uraian</span>
                    @endif
                </div>

                @if ($q->type === 'essay')
                    <textarea x-model="essayAnswers[{{ $q->id }}]"
                              class="w-full text-sm px-4 py-2.5 rounded-xl border transition-colors"
                              style="border-color:#EBE3DA; color:#2C4A5E; min-height:100px; resize:vertical;"
                              placeholder="Tulis jawaban Anda di sini..."></textarea>
                @else
                    <div class="grid gap-2">
                        @foreach ($q->answers as $oi => $opt)
                            <button type="button"
                                    @click="answers[{{ $q->id }}] = {{ $opt->id }}"
                                    :style="answers[{{ $q->id }}] === {{ $opt->id }} ? 'border-color:#5D9EC7; background:#DCEBFA; color:#2C4A5E; font-weight:600' : 'border-color:#EBE3DA; color:#6b5f52'"
                                    class="text-left text-sm px-4 py-2.5 rounded-xl border transition-colors w-full">
                                {{ chr(65 + $oi) }}. {{ $opt->answer }}
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>
        @endforeach

        <button @click="submit()" :disabled="answeredCount() < totalQuestions"
                class="py-3 rounded-xl text-sm font-bold text-white disabled:opacity-40 transition-opacity"
                style="background:#5D9EC7">
            Kumpulkan Jawaban
        </button>
    </div>
</div>
@endsection
