{{-- Pengganti <header> sticky di HomePage.jsx --}}
<header class="sticky top-0 z-10 flex items-center gap-4 px-6 py-4 bg-[#F0EAE4]/80 backdrop-blur border-b border-black/[0.05]">
    <div class="flex-1">
        <p class="text-xs text-[#8a7d70]">Selamat datang kembali,</p>
        <h1 class="text-lg font-extrabold" style="color:#2C4A5E">
            {{ explode(' ', auth()->user()->name)[0] ?? 'Student' }} 👋
        </h1>
    </div>

    <form action="{{ route('student.mycourses') }}" method="GET" class="hidden md:flex items-center gap-2 bg-white rounded-xl px-3 py-2 w-64 border border-black/[0.05]">
        <span class="material-symbols-outlined" style="font-size:16px;color:#8a7d70">search</span>
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari course..."
               class="bg-transparent outline-none text-sm flex-1 min-w-0">
    </form>

    <div class="relative">
        <button @click="notifOpen = !notifOpen" class="relative p-2.5 bg-white rounded-xl border border-black/[0.05]">
            <span class="material-symbols-outlined" style="font-size:18px;color:#2C4A5E">notifications</span>
            @if ($unreadCount > 0)
                <span class="absolute -top-1 -right-1 w-5 h-5 rounded-full flex items-center justify-center text-[10px] font-bold text-white" style="background:#E88774">{{ $unreadCount > 9 ? '9+' : $unreadCount }}</span>
            @endif
        </button>

        <div x-show="notifOpen" @click.outside="notifOpen = false" x-cloak
             class="absolute right-0 mt-2 w-80 bg-white rounded-2xl border border-black/[0.06] shadow-xl z-50 overflow-hidden lms-fade">
            <div class="flex items-center justify-between px-4 py-3 border-b border-black/[0.05]">
                <h4 class="font-bold text-sm" style="color:#2C4A5E">Notifikasi</h4>
                <form action="{{ route('notifications.readAll') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-xs font-semibold flex items-center gap-1" style="color:#5D9EC7">
                        <span class="material-symbols-outlined" style="font-size:14px">done_all</span> Tandai dibaca
                    </button>
                </form>
            </div>
            <div class="max-h-80 overflow-y-auto lms-scroll divide-y divide-black/[0.04]">
                @forelse (($notifications ?? []) as $n)
                    <a href="{{ $n['link'] ?? '#' }}" class="flex gap-3 px-4 py-3 hover:bg-[#F7F3EE] transition-colors" @if(!$n['read']) style="background:#F7F3EE" @endif>
                        <span class="w-2 h-2 rounded-full mt-1.5 shrink-0" style="background: {{ $n['color'] }}"></span>
                        <div class="min-w-0">
                            <p class="text-sm font-semibold leading-snug" style="color:#2C4A5E">{{ $n['title'] }}</p>
                            <p class="text-xs text-[#6b5f52] leading-snug">{{ $n['body'] }}</p>
                            <p class="text-[11px] text-[#8a7d70] mt-0.5">{{ $n['time'] }}</p>
                        </div>
                    </a>
                @empty
                    <div class="px-4 py-6 text-center text-xs text-[#8a7d70]">Tidak ada notifikasi.</div>
                @endforelse
            </div>
        </div>
    </div>

    <x-avatar :size="10" />
</header>
