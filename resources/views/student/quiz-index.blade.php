@extends('student')

@section('title', 'Daftar Kuis')

@section('content')
<div class="mb-5">
    <h2 class="text-2xl font-extrabold" style="color:#2C4A5E">Daftar Kuis</h2>
    <p class="text-sm text-[#8a7d70] mt-1">Kuis yang tersedia untuk kursus Anda.</p>
</div>

<div class="flex flex-col gap-3">
    @forelse ($quizzes as $quiz)
        @php
            $attempt = $quiz->attempts->first();
            $done = $quiz->attempts->isNotEmpty();
        @endphp
        <a href="{{ route('student.quiz', $quiz) }}"
           class="bg-white rounded-2xl p-4 border border-black/[0.04] shadow-sm flex items-center justify-between hover:shadow-md transition-shadow">
            <div>
                <p class="font-bold" style="color:#2C4A5E">{{ $quiz->title }}</p>
                <p class="text-xs text-[#8a7d70] mt-1">{{ $quiz->course->title ?? '-' }} • {{ $quiz->questions->count() }} soal</p>
            </div>
            <div class="text-right">
                @if ($done)
                    <span class="text-xs font-semibold" style="color:{{ $attempt->passed ? '#69B96F' : '#E88774' }}">
                        {{ $attempt->score }}/100
                    </span>
                @else
                    <span class="text-xs text-[#5D9EC7] font-semibold">Kerjakan</span>
                @endif
            </div>
        </a>
    @empty
        <div class="bg-white rounded-2xl p-8 text-center border border-black/[0.04] shadow-sm">
            <p class="text-sm text-[#8a7d70]">Belum ada kuis untuk kursus Anda.</p>
        </div>
    @endforelse
</div>
@endsection
