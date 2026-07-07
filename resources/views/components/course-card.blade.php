{{--
    Pengganti <CourseCard course onOpen onEnroll /> di HomePage.jsx.
    $course diharapkan berupa model/array dengan atribut:
    id, title, instructor, category, enrolled (bool), lessons_count, progress_pct, done_count

    Pemakaian:
    <x-course-card :course="$course" />
--}}
@props(['course'])
@php
    $styles = config('lms.category_styles', []);
    $s = $styles[$course->category] ?? ['bg' => '#E6F1FB', 'fg' => '#185FA5', 'bar' => '#5D9EC7'];
@endphp

<div class="bg-white rounded-2xl p-5 shadow-sm hover:shadow-md transition-shadow lms-fade border border-black/[0.04]">
    <div class="h-24 rounded-xl mb-4 flex items-end p-3"
         style="background: linear-gradient(135deg, {{ $s['bg'] }}, #fff)">
        <i data-lucide="book-open" width="30" height="30" style="color:{{ $s['fg'] }}"></i>
    </div>

    <div class="flex items-center justify-between mb-2">
        <x-pill :cat="$course->category" />
        <span class="text-xs text-[#8a7d70]">{{ $course->lessons_count }} lesson</span>
    </div>

    <h3 class="font-bold text-[15px] leading-snug mb-1" style="color:#2C4A5E">{{ $course->title }}</h3>
    <p class="text-xs text-[#8a7d70] mb-3">{{ $course->instructor }}</p>

    @if ($course->enrolled)
        <div class="flex justify-between text-xs mb-1.5 text-[#6b5f52]">
            <span>Progress</span>
            <span class="font-semibold">{{ $course->done_count }}/{{ $course->lessons_count }}</span>
        </div>
        <x-progress-bar :pct="$course->progress_pct" :color="$s['bar']" />

        <a href="{{ route('student.course', $course->id) }}"
           class="mt-4 block text-center w-full py-2 rounded-xl text-sm font-semibold text-white transition-transform active:scale-[0.98]"
           style="background:#2C4A5E">
            Lanjutkan Belajar
        </a>
    @else
        <form action="{{ route('student.join') }}" method="POST">
            @csrf
            <input type="hidden" name="course_id" value="{{ $course->id }}">
            <button type="submit"
                    class="mt-2 w-full py-2 rounded-xl text-sm font-semibold transition-transform active:scale-[0.98]"
                    style="background:{{ $s['bg'] }}; color:{{ $s['fg'] }}">
                Enroll Sekarang
            </button>
        </form>
    @endif
</div>
