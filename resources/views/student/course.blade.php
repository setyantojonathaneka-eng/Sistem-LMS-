@extends('student')

@section('title', $course->title)

@section('content')
<div class="mb-5">
    <a href="{{ route('student.mycourses') }}" class="text-sm text-[#8a7d70] mb-3 flex items-center gap-1">
        <span class="material-symbols-outlined" style="font-size:14px;transform:rotate(180deg)">chevron_right</span> Kembali
    </a>
    <h2 class="text-2xl font-extrabold mt-2" style="color:#2C4A5E">{{ $course->title }}</h2>
    <p class="text-sm text-[#8a7d70] mt-1">{{ $course->instructor->name ?? '-' }}</p>
</div>

@php
    $progress = round($enrollment->progress_percentage ?? 0);
    $categoryStyles = [
        'Web Development' => ['bg' => '#DCEBFA', 'fg' => '#2C6FA0', 'bar' => '#5D9EC7'],
        'Design'          => ['bg' => '#F3E8FF', 'fg' => '#7C3AED', 'bar' => '#9B7BE0'],
        'Business'        => ['bg' => '#FBF0D2', 'fg' => '#B8860B', 'bar' => '#E0B84C'],
        'Data Science'    => ['bg' => '#DDF2DC', 'fg' => '#3E8B45', 'bar' => '#69B96F'],
    ];
    $s = $categoryStyles[$course->category ?? ''] ?? ['bg' => '#EBE3DA', 'fg' => '#6b5f52', 'bar' => '#8a7d70'];
@endphp

<div class="grid lg:grid-cols-[1fr_300px] gap-5">
    <div class="flex flex-col gap-4">
        @foreach ($lessons as $lesson)
            @php $done = $completedLessons->contains($lesson->id); @endphp
            <a href="{{ route('student.lesson', [$course->id, $lesson->id]) }}"
               class="bg-white rounded-2xl p-4 border border-black/[0.04] shadow-sm flex items-center gap-3 hover:shadow-md transition-shadow">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0"
                     style="background:{{ $done ? '#DDF2DC' : $s['bg'] }}">
                    <span class="material-symbols-outlined" style="font-size:20px;color:{{ $done ? '#3E8B45' : $s['fg'] }}">{{ $lesson->type === 'video' ? 'play_circle' : 'description' }}</span>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="font-semibold text-sm truncate" style="color:#2C4A5E">{{ $lesson->title }}</p>
                    <p class="text-xs text-[#8a7d70]">{{ $lesson->duration ?? '-' }}</p>
                </div>
                @if ($done)
                    <span class="material-symbols-outlined" style="font-size:18px;color:#69B96F">check_circle</span>
                @endif
            </a>
        @endforeach
    </div>

    <div>
        <div class="bg-white rounded-2xl p-4 border border-black/[0.04] shadow-sm mb-4">
            <div class="flex justify-between text-xs mb-1.5 text-[#6b5f52]">
                <span>Progress</span>
                <span class="font-bold">{{ $progress }}%</span>
            </div>
            <div class="w-full rounded-full overflow-hidden" style="background:#EBE3DA;height:8px">
                <div class="h-full rounded-full transition-all duration-700" style="width:{{ $progress }}%; background:{{ $s['bar'] }}"></div>
            </div>
        </div>
    </div>
</div>
@endsection
