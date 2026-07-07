{{--
    Pengganti <ProgressBar pct color height /> di HomePage.jsx
    Pemakaian: <x-progress-bar :pct="$course->progress_pct" color="#5D9EC7" />
--}}
@props(['pct' => 0, 'color' => '#5D9EC7', 'height' => 8])

<div class="w-full rounded-full overflow-hidden" style="background:#EBE3DA; height: {{ $height }}px">
    <div class="h-full rounded-full transition-all duration-700"
         style="width: {{ $pct }}%; background: {{ $color }}"></div>
</div>
