@extends('student')

@section('title', 'Sertifikat')

@section('content')
<div class="mb-5">
    <h2 class="text-2xl font-extrabold" style="color:#2C4A5E">Sertifikat</h2>
    <p class="text-sm text-[#8a7d70] mt-1">Sertifikat otomatis untuk course yang telah selesai (unduh PDF).</p>
</div>

@if ($certificates->count())
    <div class="grid sm:grid-cols-2 gap-4">
        @foreach ($certificates as $cert)
            @php
                $course = $cert->course;
                $categoryStyles = [
                    'Web Development' => ['bg' => '#DCEBFA', 'fg' => '#2C6FA0', 'bar' => '#5D9EC7'],
                    'Design'          => ['bg' => '#F3E8FF', 'fg' => '#7C3AED', 'bar' => '#9B7BE0'],
                    'Business'        => ['bg' => '#FBF0D2', 'fg' => '#B8860B', 'bar' => '#E0B84C'],
                    'Data Science'    => ['bg' => '#DDF2DC', 'fg' => '#3E8B45', 'bar' => '#69B96F'],
                ];
                $s = $categoryStyles[$course->category ?? ''] ?? ['bg' => '#EBE3DA', 'fg' => '#6b5f52', 'bar' => '#8a7d70'];
            @endphp
            <div class="bg-white rounded-2xl p-5 border border-black/[0.04] shadow-sm">
                <div class="rounded-xl p-5 mb-4 border-2 border-dashed" style="border-color:{{ $s['bar'] }}; background:{{ $s['bg'] }}">
                    <span class="material-symbols-outlined" style="font-size:28px;color:{{ $s['fg'] }}">workspace_premium</span>
                    <p class="text-xs mt-2 font-semibold" style="color:{{ $s['fg'] }}">SERTIFIKAT PENYELESAIAN</p>
                    <p class="font-bold mt-1" style="color:#2C4A5E">{{ $course->title ?? '-' }}</p>
                </div>
                <a href="{{ route('student.certificate.download', $cert->id) }}"
                   class="w-full inline-block text-center py-2.5 rounded-xl text-sm font-semibold text-white"
                   style="background:#2C4A5E">
                    <span class="material-symbols-outlined" style="font-size:16px;vertical-align:middle">download</span> Lihat & Unduh
                </a>
            </div>
        @endforeach
    </div>
@else
    <div class="bg-white rounded-2xl p-12 text-center border border-dashed border-black/[0.1]">
        <span class="material-symbols-outlined" style="font-size:32px;color:#c9bdb0;display:block;text-align:center">auto_stories</span>
        <p class="text-sm text-[#8a7d70]">Selesaikan semua lesson sebuah course untuk membuka sertifikat.</p>
    </div>
@endif
@endsection
