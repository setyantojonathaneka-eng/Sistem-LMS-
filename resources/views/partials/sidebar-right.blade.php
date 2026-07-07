
@auth
    {{-- PROFILE CARD --}}
    <div class="bg-white rounded-2xl p-5 text-center border border-black/[0.04] shadow-sm">
        <div class="w-16 h-16 mx-auto rounded-2xl flex items-center justify-center font-bold text-white text-xl mb-3" style="background:#2C4A5E">
            <i data-lucide="user" width="26" height="26"></i>
        </div>
        <h3 class="font-bold" style="color:#2C4A5E">{{ Auth::user()->name }}</h3>
        <p class="text-xs text-[#8a7d70]">{{ Auth::user()->email }}</p>
        <p class="text-xs text-[#8a7d70] mb-3">{{ ucfirst(Auth::user()->role) }}</p>
        <button class="w-full py-2 rounded-xl text-sm font-semibold text-white" style="background:#5D9EC7">
            Enroll Kelas
        </button>
    </div>
@else
    {{-- LOGIN CTA CARD --}}
    <div class="bg-white rounded-2xl p-5 text-center border border-black/[0.04] shadow-sm">
        <div class="w-16 h-16 mx-auto rounded-2xl flex items-center justify-center mb-3" style="background:#F0EAE4">
            <i data-lucide="user-circle" width="26" height="26" style="color:#2C4A5E"></i>
        </div>
        <a href="{{ url('/login') }}" class="block w-full py-2 rounded-xl text-sm font-semibold text-white" style="background:#2C4A5E">
            Log In
        </a>
        <p class="text-xs text-[#8a7d70] mt-3">Login untuk track progress belajarmu!</p>
    </div>
@endauth

@auth
    {{-- SERTIFIKAT SAYA --}}
    <div class="bg-white rounded-2xl p-5 border border-black/[0.04] shadow-sm">
        <div class="flex items-center gap-2 mb-3">
            <i data-lucide="award" width="18" height="18" style="color:#9B7BE0"></i>
            <h3 class="font-bold text-sm" style="color:#2C4A5E">Sertifikat saya</h3>
        </div>
        @if($certificates->count() > 0)
            <div class="flex flex-col gap-1 divide-y divide-black/[0.04]">
                @foreach($certificates as $cert)
                    <div class="flex items-center gap-2 py-1.5 text-xs">
                        <i data-lucide="trophy" width="16" height="16" style="color:#E0B84C" class="shrink-0"></i>
                        <div class="min-w-0">
                            <div class="font-medium" style="color:#2C4A5E">{{ $cert->course->title }}</div>
                            <div class="text-[11px] text-[#8a7d70]">{{ \Carbon\Carbon::parse($cert->issued_at)->format('d M Y') }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-xs text-[#8a7d70]">Belum ada sertifikat. Selesaikan kursus untuk mendapatkan sertifikat!</p>
        @endif
    </div>

    {{-- QUIZ TERBARU --}}
    <div class="bg-white rounded-2xl p-5 border border-black/[0.04] shadow-sm">
        <div class="flex items-center gap-2 mb-3">
            <i data-lucide="clipboard-check" width="18" height="18" style="color:#5D9EC7"></i>
            <h3 class="font-bold text-sm" style="color:#2C4A5E">Quiz terbaru</h3>
        </div>
        @if($quiz_attempts->count() > 0)
            <div class="flex flex-col gap-1 divide-y divide-black/[0.04]">
                @foreach($quiz_attempts as $attempt)
                    <div class="flex justify-between items-center py-1.5 text-xs">
                        <div>
                            <div class="font-medium" style="color:#2C4A5E">{{ $attempt->quiz->title ?? 'Quiz' }}</div>
                            <div class="text-[11px] text-[#8a7d70]">{{ $attempt->created_at->diffForHumans() }}</div>
                        </div>
                        <span class="font-bold" style="color: {{ $attempt->passed ? '#69B96F' : '#E88774' }}">
                            {{ $attempt->score }}
                        </span>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-xs text-[#8a7d70]">Belum ada quiz yang dikerjakan.</p>
        @endif
    </div>
@endauth

{{-- TRACK PROGRESS --}}
<div class="bg-white rounded-2xl p-5 border border-black/[0.04] shadow-sm">
    <div class="flex items-center gap-2 mb-3">
        <i data-lucide="activity" width="18" height="18" style="color:#69B96F"></i>
        <h3 class="font-bold text-sm" style="color:#2C4A5E">Track Progress</h3>
    </div>
    @auth
        @if($enrollments->count() > 0)
            <div class="flex flex-col gap-3">
                @foreach($enrollments->take(3) as $enrollment)
                    <div>
                        <div class="flex justify-between text-xs mb-1.5 text-[#6b5f52]">
                            <span>{{ Str::limit($enrollment->course->title, 25) }}</span>
                            <span class="font-semibold">{{ $enrollment->progress_percentage }}%</span>
                        </div>
                        <div class="w-full rounded-full overflow-hidden" style="background:#EBE3DA;height:8px">
                            <div class="h-full rounded-full" style="width:{{ $enrollment->progress_percentage }}%; background:#5D9EC7"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-xs text-[#8a7d70]">Belum ada progress. Mulai enroll kursus!</p>
        @endif
    @else
        <p class="text-xs text-[#8a7d70] mb-2">Pantau perkembangan belajarmu setiap hari.</p>
        <span class="text-xs font-semibold" style="color:#5D9EC7">0% selesai</span>
    @endauth
</div>

{{-- ABSENSI --}}
<div class="bg-white rounded-2xl p-5 border border-black/[0.04] shadow-sm">
    <div class="flex items-center gap-2 mb-3">
        <i data-lucide="calendar-check" width="18" height="18" style="color:#E0B84C"></i>
        <h3 class="font-bold text-sm" style="color:#2C4A5E">Absensi</h3>
    </div>
    @auth
        @php
            $eCount = \App\Models\Enrollment::where('user_id', Auth::id())->count();
            $eDone = \App\Models\Enrollment::where('user_id', Auth::id())->where('progress_percentage', '>=', 100)->count();
            $ePct = $eCount > 0 ? round(($eDone / $eCount) * 100) : 0;
        @endphp
        <div class="flex items-center gap-2 text-sm font-medium mb-2" style="color:#3E8B45">
            <i data-lucide="check-circle-2" width="16" height="16"></i>
            {{ $eDone }}/{{ $eCount }} course selesai
        </div>
        <div class="flex justify-between items-center mt-3 pt-3 border-t border-black/[0.05] text-xs">
            <span class="text-[#8a7d70]">Persentase kehadiran</span>
            <strong style="color:#2C4A5E">{{ $ePct }}%</strong>
        </div>
    @else
        <p class="text-xs text-[#8a7d70]">Login untuk melakukan absensi kelas.</p>
    @endauth
</div>

{{-- JOIN KELAS --}}
<div class="bg-white rounded-2xl p-5 border border-black/[0.04] shadow-sm">
    <div class="flex items-center gap-2 mb-3">
        <i data-lucide="graduation-cap" width="18" height="18" style="color:#2C4A5E"></i>
        <h3 class="font-bold text-sm" style="color:#2C4A5E">Join Kelas</h3>
    </div>
    @auth
        <p class="text-xs text-[#8a7d70] mb-2">Punya kode dari dosenmu?</p>
        <form method="POST" action="{{ route('student.join') }}" class="flex flex-col gap-2">
            @csrf
            <input type="text" name="join_code" placeholder="Masukkan kode kelas..." required
                   class="bg-[#F7F3EE] rounded-xl px-3 py-2 text-sm outline-none border border-black/[0.05]" />
            <button type="submit" class="w-full py-2 rounded-xl text-sm font-semibold text-white" style="background:#5D9EC7">
                Enroll
            </button>
        </form>
        @if(session('join_error'))
            <p class="text-xs mt-2" style="color:#E88774">{{ session('join_error') }}</p>
        @endif
        @if(session('join_success'))
            <p class="text-xs mt-2" style="color:#69B96F">{{ session('join_success') }}</p>
        @endif
    @else
        <p class="text-xs text-[#8a7d70] mb-3">Silakan login untuk bergabung ke kelas dosen.</p>
        <a href="{{ url('/login') }}" class="block w-full text-center py-2 rounded-xl text-sm font-semibold text-white" style="background:#5D9EC7">
            Login dulu
        </a>
    @endauth
</div>

{{-- FORUM DISKUSI --}}
<div class="bg-white rounded-2xl p-5 border border-black/[0.04] shadow-sm">
    <div class="flex items-center gap-2 mb-3">
        <i data-lucide="messages-square" width="18" height="18" style="color:#5D9EC7"></i>
        <h3 class="font-bold text-sm" style="color:#2C4A5E">Forum Diskusi</h3>
    </div>
    @auth
        @if(isset($discussions) && $discussions->count() > 0)
            <div class="flex flex-col gap-2 mb-3">
                @foreach($discussions->take(3) as $discussion)
                    <div class="pb-2 border-b border-black/[0.04] last:border-0">
                        <span class="text-sm font-semibold block" style="color:#2C4A5E">{{ $discussion->title }}</span>
                        <div class="flex items-center gap-1.5 text-[11px] text-[#8a7d70] mt-1">
                            <i data-lucide="book-open" width="12" height="12"></i>
                            <span>{{ $discussion->course->title ?? '' }} · {{ $discussion->replies_count ?? 0 }} balasan</span>
                        </div>
                    </div>
                @endforeach
            </div>
            <a href="{{ route('forum.index') }}" class="text-xs font-semibold" style="color:#5D9EC7">Lihat semua diskusi</a>
        @else
            <p class="text-xs text-[#8a7d70] mb-2">Belum ada diskusi. Mulai diskusi pertama di kursusmu!</p>
            <a href="{{ route('forum.create') }}" class="text-xs font-semibold" style="color:#5D9EC7">+ Buat Diskusi</a>
        @endif
    @else
        <p class="text-xs text-[#8a7d70]">Login untuk ikut diskusi dengan teman dan dosen.</p>
    @endauth
</div>