@extends('student')

@section('title', 'Hasil Kuis')

@section('content')
<div class="max-w-2xl mx-auto">
    <a href="{{ route('student.quiz.index') }}" class="text-sm text-[#8a7d70] mb-3 flex items-center gap-1">
        <span class="material-symbols-outlined" style="font-size:14px;transform:rotate(180deg)">chevron_right</span> Daftar Kuis
    </a>

    <div class="bg-white rounded-2xl p-8 border border-black/[0.04] shadow-sm text-center">
        <div class="w-20 h-20 mx-auto rounded-full flex items-center justify-center mb-4"
             style="background:{{ $passed ? '#DDF2DC' : '#FBDFD9' }}">
            <span class="text-2xl font-extrabold" style="color:{{ $passed ? '#3E8B45' : '#C05545' }}">{{ $score }}</span>
        </div>
        <h3 class="text-xl font-extrabold" style="color:#2C4A5E">{{ $passed ? 'Selamat, Lulus!' : 'Belum Lulus' }}</h3>
        <p class="text-sm text-[#8a7d70] mt-1">
            Benar {{ $correct }} dari {{ $questions->where('type', '!=', 'essay')->count() }} soal pilihan ganda
            @if (!empty($essayPending))
                <br><span style="color:#92400E;">Soal uraian menunggu penilaian pengajar</span>
            @endif
        </p>

        <div class="flex gap-3 justify-center mt-5">
            <a href="{{ route('student.quiz.index') }}" class="px-5 py-2.5 rounded-xl text-sm font-semibold" style="background:#F0EAE4; color:#2C4A5E">Kembali</a>
        </div>
    </div>
</div>
@endsection
