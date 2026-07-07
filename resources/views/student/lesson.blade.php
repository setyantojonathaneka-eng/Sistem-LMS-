@extends('student')

@section('title', $lesson->title)

@section('content')
<a href="{{ route('student.course', $course->id) }}" class="text-sm text-[#8a7d70] mb-3 flex items-center gap-1">
    <span class="material-symbols-outlined" style="font-size:14px;transform:rotate(180deg)">chevron_right</span> Kembali
</a>

<div class="bg-white rounded-2xl overflow-hidden border border-black/[0.04] shadow-sm mb-4">
        @php
        $isYoutube = str_contains($lesson->file_path ?? '', 'youtube.com') || str_contains($lesson->file_path ?? '', 'youtu.be');
        $youtubeId = null;
        if ($isYoutube) {
            preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]+)/', $lesson->file_path, $m);
            $youtubeId = $m[1] ?? null;
        }
        $isLocalVideo = $lesson->type === 'video' && !$isYoutube && $lesson->file_path;
        $isPdf = $lesson->type === 'pdf';
    @endphp

    @if ($youtubeId)
        <div class="aspect-video" style="position:relative;">
            <iframe src="https://www.youtube.com/embed/{{ $youtubeId }}"
                    frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen style="position:absolute;inset:0;width:100%;height:100%;"></iframe>
        </div>
    @elseif ($isLocalVideo)
        <div class="aspect-video" style="position:relative;">
            <video controls style="width:100%;height:100%;position:absolute;inset:0;background:#000;" preload="metadata">
                <source src="{{ $lesson->file_path }}" type="video/mp4">
            </video>
        </div>
    @elseif ($isPdf)
        <div class="aspect-video flex flex-col items-center justify-center" style="background:#F0EAE4">
            <span class="material-symbols-outlined" style="font-size:36px;color:#C05545">description</span>
            <p class="text-sm mt-4 font-semibold" style="color:#2C4A5E">{{ $lesson->title }}</p>
            <p class="text-xs text-[#8a7d70]">Dokumen PDF</p>
            @if ($lesson->file_path)
                <a href="{{ $lesson->file_path }}" target="_blank" class="mt-3 text-sm font-semibold text-white px-4 py-2 rounded-xl" style="background:#5D9EC7">Buka PDF</a>
            @endif
        </div>
    @else
        <div class="aspect-video flex flex-col items-center justify-center" style="background:linear-gradient(135deg, #2C4A5E, #1c3242)">
            <span class="material-symbols-outlined" style="font-size:48px;color:rgba(255,255,255,0.8)">play_circle</span>
            <p class="text-white/80 text-sm mt-4">{{ $lesson->title }}</p>
        </div>
    @endif
</div>

<div class="bg-white rounded-2xl p-5 border border-black/[0.04] shadow-sm mb-4">
    <h4 class="font-bold mb-1" style="color:#2C4A5E">{{ $lesson->title }}</h4>
    <p class="text-sm text-[#6b5f52] leading-relaxed">{{ $lesson->description ?? $course->description ?? '' }}</p>

    <form action="{{ route('student.lesson.complete', $lesson->id) }}" method="POST" class="mt-4">
        @csrf
        <button type="submit" class="text-sm font-semibold text-white px-5 py-2.5 rounded-xl flex items-center gap-2" style="background:#69B96F">
            <span class="material-symbols-outlined" style="font-size:16px">check_circle</span> Tandai Selesai
        </button>
    </form>
</div>

@if ($quiz)
    <a href="{{ route('student.quiz', $quiz->id) }}"
       class="block w-full text-center py-3 rounded-xl text-sm font-semibold text-white" style="background:#5D9EC7">
        <span class="material-symbols-outlined" style="font-size:16px;vertical-align:middle">quiz</span> Kerjakan Kuis
    </a>
@endif
@endsection
