
@extends('student')

@section('title', 'Dashboard')

@section('content')
    <div class="mb-5">
        <h2 class="text-2xl font-extrabold" style="color:#2C4A5E">Dashboard</h2>
        <p class="text-sm text-[#8a7d70] mt-1">Ringkasan perjalanan belajar Anda hari ini.</p>
    </div>

    {{-- STAT CARDS (inline dulu, tanpa x-stat-card) --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">

        <div class="bg-white rounded-2xl p-5 border border-black/[0.04] shadow-sm">
            <div class="w-11 h-11 rounded-xl flex items-center justify-center mb-3" style="background:#5D9EC722">
                <span class="material-symbols-outlined" style="font-size:22px;color:#5D9EC7">auto_stories</span>
            </div>
            <p class="text-2xl font-extrabold" style="color:#2C4A5E">{{ $enrolled->count() }}</p>
            <p class="text-xs text-[#8a7d70]">Course Aktif</p>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-black/[0.04] shadow-sm">
            <div class="w-11 h-11 rounded-xl flex items-center justify-center mb-3" style="background:#69B96F22">
                <span class="material-symbols-outlined" style="font-size:22px;color:#69B96F">trending_up</span>
            </div>
            <p class="text-2xl font-extrabold" style="color:#2C4A5E">{{ $overallProgress }}%</p>
            <p class="text-xs text-[#8a7d70]">Progress Rata-rata</p>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-black/[0.04] shadow-sm">
            <div class="w-11 h-11 rounded-xl flex items-center justify-center mb-3" style="background:#E0B84C22">
                <span class="material-symbols-outlined" style="font-size:22px;color:#E0B84C">event_available</span>
            </div>
            <p class="text-2xl font-extrabold" style="color:#2C4A5E">{{ $attendanceRecap['pct'] }}%</p>
            <p class="text-xs text-[#8a7d70]">Kehadiran</p>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-black/[0.04] shadow-sm">
            <div class="w-11 h-11 rounded-xl flex items-center justify-center mb-3" style="background:#9B7BE022">
                <span class="material-symbols-outlined" style="font-size:22px;color:#9B7BE0">workspace_premium</span>
            </div>
            <p class="text-2xl font-extrabold" style="color:#2C4A5E">{{ $certificatesCount }}</p>
            <p class="text-xs text-[#8a7d70]">Sertifikat</p>
        </div>

    </div>

    <div class="flex items-center justify-between mb-4">
        <h3 class="font-bold text-lg" style="color:#2C4A5E">Lanjutkan Belajar</h3>
        <a href="{{ route('student.mycourses') }}" class="text-sm font-semibold flex items-center gap-1" style="color:#5D9EC7">
            Lihat semua <span class="material-symbols-outlined" style="font-size:16px">chevron_right</span>
        </a>
    </div>

    {{-- COURSE CARDS (inline dulu, tanpa x-course-card) --}}
    @if ($enrollments->count())
        <div class="grid sm:grid-cols-2 gap-4">
            @foreach ($enrollments as $enrollment)
                @php $course = $enrollment->course; @endphp
                <div class="bg-white rounded-2xl p-5 shadow-sm hover:shadow-md transition-shadow border border-black/[0.04]">
                    <div class="h-24 rounded-xl mb-4 flex items-end p-3" style="background:linear-gradient(135deg, #eef2f5, #fff)">
                        <span class="material-symbols-outlined" style="font-size:30px;color:#2C4A5E">auto_stories</span>
                    </div>

                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-semibold px-2.5 py-1 rounded-full" style="background:#EDEDED;color:#555">
                            {{ $course->category ?? '-' }}
                        </span>
                        <span class="text-xs text-[#8a7d70]">{{ $course->lessons->count() }} lesson</span>
                    </div>

                    <h3 class="font-bold text-[15px] leading-snug mb-1" style="color:#2C4A5E">{{ $course->title }}</h3>
                    <p class="text-xs text-[#8a7d70] mb-3">{{ $course->instructor->name ?? '-' }}</p>

                    <div class="flex justify-between text-xs mb-1.5 text-[#6b5f52]">
                        <span>Progress</span>
                        <span class="font-semibold">{{ round($enrollment->progress_percentage) }}%</span>
                    </div>

                    <div class="w-full rounded-full overflow-hidden" style="background:#EBE3DA;height:8px">
                        <div class="h-full rounded-full" style="width:{{ $enrollment->progress_percentage }}%; background:#5D9EC7"></div>
                    </div>

                    <a href="{{ route('student.course', $course->id) }}"
                       class="mt-4 w-full inline-block text-center py-2 rounded-xl text-sm font-semibold text-white"
                       style="background:#2C4A5E">
                        Lanjutkan Belajar
                    </a>
                </div>
            @endforeach
        </div>
    @else
        <div class="bg-white rounded-2xl p-12 text-center border border-dashed border-black/[0.1]">
            <span class="material-symbols-outlined" style="font-size:32px;color:#c9bdb0;display:block;margin:0 auto 12px">auto_stories</span>
            <p class="text-sm text-[#8a7d70]">Belum ada course aktif.</p>
        </div>
    @endif
@endsection