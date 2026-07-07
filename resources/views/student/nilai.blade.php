@extends('student')

@section('title', 'Nilai')

@section('content')
<div class="mb-5">
    <h2 class="text-2xl font-extrabold" style="color:#2C4A5E">Nilai</h2>
    <p class="text-sm text-[#8a7d70] mt-1">Riwayat nilai kuis Anda.</p>
</div>

@if ($quiz_attempts->count())
    <div class="bg-white rounded-2xl border border-black/[0.04] shadow-sm overflow-hidden">
        <div class="divide-y divide-black/[0.04]">
            @foreach ($quiz_attempts as $attempt)
                @php
                    $score = round($attempt->score ?? 0);
                    $passed = $score >= 70;
                @endphp
                <div class="p-4 flex items-center gap-4">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0"
                         style="background:{{ $passed ? '#DDF2DC' : '#FBDFD9' }}">
                        <span class="material-symbols-outlined" style="font-size:20px;color:{{ $passed ? '#3E8B45' : '#C05545' }}">quiz</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-semibold text-sm truncate" style="color:#2C4A5E">{{ $attempt->quiz->title ?? 'Kuis' }}</p>
                        <p class="text-xs text-[#8a7d70]">{{ $attempt->created_at->format('d M Y H:i') }}</p>
                    </div>
                    <span class="text-sm font-bold px-3 py-1 rounded-full"
                          style="background:{{ $passed ? '#DDF2DC' : '#FBDFD9' }}; color:{{ $passed ? '#3E8B45' : '#C05545' }}">
                        {{ $score }}
                    </span>
                </div>
            @endforeach
        </div>
    </div>
@else
    <div class="bg-white rounded-2xl p-12 text-center border border-dashed border-black/[0.1]">
        <span class="material-symbols-outlined" style="font-size:32px;color:#c9bdb0;display:block;text-align:center">quiz</span>
        <p class="text-sm text-[#8a7d70]">Belum ada riwayat nilai.</p>
    </div>
@endif
@endsection
