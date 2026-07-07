@extends('student')

@section('content')
@php
    // Mapping warna per kategori course, konsisten dengan CATEGORY_STYLES di versi React.
    // Tambah entri baru di sini kalau ada kategori lain di database kamu.
    $categoryStyles = [
        'Web Development'   => ['bg' => '#DCEBFA', 'fg' => '#2C6FA0', 'bar' => '#5D9EC7'],
        'Design'            => ['bg' => '#F3E8FF', 'fg' => '#7C3AED', 'bar' => '#9B7BE0'],
        'Business'          => ['bg' => '#FBF0D2', 'fg' => '#B8860B', 'bar' => '#E0B84C'],
        'Data Science'      => ['bg' => '#DDF2DC', 'fg' => '#3E8B45', 'bar' => '#69B96F'],
    ];
    $defaultStyle = ['bg' => '#EBE3DA', 'fg' => '#6b5f52', 'bar' => '#8a7d70'];
@endphp

<div class="mb-5">
    <h2 class="text-2xl font-extrabold" style="color:#2C4A5E">My Courses</h2>
    <p class="text-sm mt-1" style="color:#8a7d70">Course yang sedang Anda ikuti.</p>
</div>

@if($enrollments->isEmpty())
    <div class="bg-white rounded-2xl p-12 text-center border border-dashed border-black/10">
        <span class="material-symbols-outlined" style="font-size:32px;color:#c9bdb0;display:block;text-align:center">auto_stories</span>
        <p class="text-sm" style="color:#8a7d70">Anda belum enroll course apa pun.</p>
    </div>
@else
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($enrollments as $enrollment)
            @php
                $course = $enrollment->course;
                if (!$course) continue;
                $style = $categoryStyles[$course->category] ?? $defaultStyle;
                $total = $course->lessons->count();
                $pct   = round($enrollment->progress_percentage ?? 0);
            @endphp

            <div class="bg-white rounded-2xl p-5 shadow-sm hover:shadow-md transition-shadow border border-black/[0.04]">
                <div class="h-24 rounded-xl mb-4 flex items-end p-3"
                     style="background: linear-gradient(135deg, {{ $style['bg'] }}, #fff)">
                    <span class="material-symbols-outlined" style="font-size:30px;color:{{ $style['fg'] }}">auto_stories</span>
                </div>

                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full"
                          style="background:{{ $style['bg'] }}; color:{{ $style['fg'] }}">
                        {{ $course->category ?? 'Umum' }}
                    </span>
                    <span class="text-xs" style="color:#8a7d70">{{ $total }} lesson</span>
                </div>

                <h3 class="font-bold text-[15px] leading-snug mb-1" style="color:#2C4A5E">
                    {{ $course->title }}
                </h3>
                <p class="text-xs mb-3" style="color:#8a7d70">
                    {{ $course->instructor->name ?? '-' }}
                </p>

                <div class="flex justify-between text-xs mb-1.5" style="color:#6b5f52">
                    <span>Progress</span>
                    <span class="font-semibold">{{ $pct }}%</span>
                </div>
                <div class="w-full rounded-full overflow-hidden" style="background:#EBE3DA; height:8px">
                    <div class="h-full rounded-full transition-all duration-700"
                         style="width:{{ $pct }}%; background:{{ $style['bar'] }}"></div>
                </div>

                <a href="{{ route('student.course', $course->id) }}"
                   class="mt-4 w-full inline-block text-center py-2 rounded-xl text-sm font-semibold text-white transition-transform active:scale-[0.98]"
                   style="background:#2C4A5E">
                    Lanjutkan Belajar
                </a>
            </div>
        @endforeach
    </div>
@endif
@endsection