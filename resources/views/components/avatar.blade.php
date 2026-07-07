@props(['user' => null, 'size' => 10, 'color' => null, 'extra' => ''])

@php
    $u = $user ?? auth()->user();
    $sizePx = $size * 4;
    $initials = $u ? $u->initials : '?';
    $photoUrl = $u ? $u->photo_url : null;
    $bg = $color ?? ($u && $u->role === 'instructor' ? '#E0B84C' : '#5D9EC7');
@endphp

@if ($photoUrl)
    <img src="{{ $photoUrl }}" alt=""
         style="width:{{ $sizePx }}px;height:{{ $sizePx }}px"
         class="rounded-full object-cover border-2 border-white shadow-sm shrink-0 {{ $extra }}">
@else
    <div style="width:{{ $sizePx }}px;height:{{ $sizePx }}px;font-size:{{ $sizePx * 0.35 }}px;background:{{ $bg }};line-height:1"
         class="rounded-full flex items-center justify-center font-bold text-white shrink-0 {{ $extra }}">
        {{ $initials }}
    </div>
@endif
