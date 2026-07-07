{{--
    Pengganti <Pill cat /> di HomePage.jsx.
    $categoryStyles idealnya di-share lewat config atau helper, contoh:
    config/lms.php -> 'category_styles' => ['UI/UX' => ['bg' => '#B5D4F4', 'fg' => '#185FA5'], ...]

    Pemakaian: <x-pill :cat="$course->category" />
--}}
@props(['cat'])
@php
    $styles = config('lms.category_styles', []);
    $s = $styles[$cat] ?? ['bg' => '#E6F1FB', 'fg' => '#185FA5'];
@endphp

<span class="text-xs font-semibold px-2.5 py-1 rounded-full" style="background: {{ $s['bg'] }}; color: {{ $s['fg'] }}">
    {{ $cat }}
</span>
