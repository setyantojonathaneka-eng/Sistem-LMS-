<aside
    class="sticky top-0 h-[100dvh] flex flex-col shrink-0 transition-all duration-300 py-6 px-3 overflow-y-auto lms-scroll"
    :style="collapsed ? 'width:76px; background:#2C4A5E' : 'width:260px; background:#2C4A5E'"
    style="font-family:Arial,sans-serif">

    {{-- LOGO + TOGGLE --}}
    <div class="flex items-center gap-3 px-2 mb-6">
        <div class="flex items-center gap-3 flex-1 min-w-0">
            <img src="{{ asset('images/Logo LearnPath .png') }}" alt="LearnPath"
                 class="w-9 h-9 rounded-lg shrink-0 object-cover">
            <div x-show="!collapsed" x-cloak
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-x-2"
             x-transition:enter-end="opacity-100 translate-x-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-x-0"
             x-transition:leave-end="opacity-0 -translate-x-2"
             class="text-white font-bold text-base tracking-wide truncate" style="font-family:Arial,sans-serif">LearnPath</div>
        </div>
        <button @click="collapsed = !collapsed"
                class="flex items-center justify-center w-8 h-8 rounded-lg text-white/40 hover:text-white/70 hover:bg-white/5 transition-colors shrink-0">
            <i data-lucide="chevron-left" style="width:18px;height:18px"
               :style="'width:18px;height:18px;' + (collapsed ? 'transform:rotate(180deg)' : '')"></i>
        </button>
    </div>

    {{-- SEARCH --}}
    <div class="px-2 mb-6" :class="collapsed ? 'flex justify-center' : ''">
        <div class="relative" :class="collapsed ? '' : 'w-full'">
            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-white/40" style="font-size:14px">
                <i data-lucide="search" style="width:15px;height:15px"></i>
            </span>
            <input x-show="!collapsed" x-cloak
                   x-transition:enter="transition ease-out duration-200"
                   x-transition:enter-start="opacity-0"
                   x-transition:enter-end="opacity-100"
                   x-transition:leave="transition ease-in duration-150"
                   x-transition:leave-start="opacity-100"
                   x-transition:leave-end="opacity-0"
                   type="text" placeholder="Cari kursus..."
                   class="w-full bg-white/10 text-white/80 placeholder:text-white/40 text-sm rounded-lg pl-9 pr-3 py-2 outline-none border border-white/10 focus:border-white/30 transition-colors"
                   style="font-family:Arial,sans-serif">
        </div>
    </div>

    {{-- SECTION LABEL --}}
    <div x-show="!collapsed" x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="px-2 mb-2">
        <span class="text-white/40 text-[11px] font-semibold tracking-[1.5px]">MENU</span>
    </div>

    {{-- NAV --}}
    <nav class="flex flex-col gap-0.5 flex-1">

        {{-- 1. Dashboard --}}
        <a href="{{ route('student.dashboard') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors text-sm font-medium"
           :class="collapsed ? 'justify-center' : ''"
           style="{{ request()->routeIs('student.dashboard') ? 'background:rgba(255,255,255,0.12); color:#fff' : 'color:rgba(255,255,255,0.6)' }}"
           onmouseover="this.style.background='rgba(255,255,255,0.08)';this.style.color='#fff'"
           onmouseout="this.style.background='{{ request()->routeIs('student.dashboard') ? 'rgba(255,255,255,0.12)' : 'transparent' }}';this.style.color='{{ request()->routeIs('student.dashboard') ? '#fff' : 'rgba(255,255,255,0.6)' }}'">
            <i data-lucide="home" style="width:19px;height:19px;flex-shrink:0"></i>
            <span x-show="!collapsed" x-cloak
                  x-transition:enter="transition ease-out duration-200"
                  x-transition:enter-start="opacity-0 -translate-x-2"
                  x-transition:enter-end="opacity-100 translate-x-0"
                  x-transition:leave="transition ease-in duration-150"
                  x-transition:leave-start="opacity-100 translate-x-0"
                  x-transition:leave-end="opacity-0 -translate-x-2">Dashboard</span>
        </a>

        {{-- 2. Katalog Course --}}
        <a href="{{ route('student.mycourses') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors text-sm font-medium"
           :class="collapsed ? 'justify-center' : ''"
           style="{{ request()->routeIs('student.mycourses') ? 'background:rgba(255,255,255,0.12); color:#fff' : 'color:rgba(255,255,255,0.6)' }}"
           onmouseover="this.style.background='rgba(255,255,255,0.08)';this.style.color='#fff'"
           onmouseout="this.style.background='{{ request()->routeIs('student.mycourses') ? 'rgba(255,255,255,0.12)' : 'transparent' }}';this.style.color='{{ request()->routeIs('student.mycourses') ? '#fff' : 'rgba(255,255,255,0.6)' }}'">
            <i data-lucide="book-open" style="width:19px;height:19px;flex-shrink:0"></i>
            <span x-show="!collapsed" x-cloak
                  x-transition:enter="transition ease-out duration-200"
                  x-transition:enter-start="opacity-0 -translate-x-2"
                  x-transition:enter-end="opacity-100 translate-x-0"
                  x-transition:leave="transition ease-in duration-150"
                  x-transition:leave-start="opacity-100 translate-x-0"
                  x-transition:leave-end="opacity-0 -translate-x-2">Katalog Course</span>
        </a>

        {{-- 3. Kuis --}}
        <a href="{{ route('student.quiz.index') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors text-sm font-medium"
           :class="collapsed ? 'justify-center' : ''"
           style="{{ request()->routeIs('student.quiz.*') ? 'background:rgba(255,255,255,0.12); color:#fff' : 'color:rgba(255,255,255,0.6)' }}"
           onmouseover="this.style.background='rgba(255,255,255,0.08)';this.style.color='#fff'"
           onmouseout="this.style.background='{{ request()->routeIs('student.quiz.*') ? 'rgba(255,255,255,0.12)' : 'transparent' }}';this.style.color='{{ request()->routeIs('student.quiz.*') ? '#fff' : 'rgba(255,255,255,0.6)' }}'">
            <i data-lucide="clipboard-check" style="width:19px;height:19px;flex-shrink:0"></i>
            <span x-show="!collapsed" x-cloak
                  x-transition:enter="transition ease-out duration-200"
                  x-transition:enter-start="opacity-0 -translate-x-2"
                  x-transition:enter-end="opacity-100 translate-x-0"
                  x-transition:leave="transition ease-in duration-150"
                  x-transition:leave-start="opacity-100 translate-x-0"
                  x-transition:leave-end="opacity-0 -translate-x-2">Kuis</span>
        </a>

        {{-- 4. Sertifikat --}}
        <a href="{{ route('student.sertifikat') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors text-sm font-medium"
           :class="collapsed ? 'justify-center' : ''"
           style="{{ request()->routeIs('student.sertifikat') ? 'background:rgba(255,255,255,0.12); color:#fff' : 'color:rgba(255,255,255,0.6)' }}"
           onmouseover="this.style.background='rgba(255,255,255,0.08)';this.style.color='#fff'"
           onmouseout="this.style.background='{{ request()->routeIs('student.sertifikat') ? 'rgba(255,255,255,0.12)' : 'transparent' }}';this.style.color='{{ request()->routeIs('student.sertifikat') ? '#fff' : 'rgba(255,255,255,0.6)' }}'">
            <i data-lucide="award" style="width:19px;height:19px;flex-shrink:0"></i>
            <span x-show="!collapsed" x-cloak
                  x-transition:enter="transition ease-out duration-200"
                  x-transition:enter-start="opacity-0 -translate-x-2"
                  x-transition:enter-end="opacity-100 translate-x-0"
                  x-transition:leave="transition ease-in duration-150"
                  x-transition:leave-start="opacity-100 translate-x-0"
                  x-transition:leave-end="opacity-0 -translate-x-2">Sertifikat</span>
        </a>

        {{-- 5. Forum Diskusi --}}
        <a href="{{ route('forum.index') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors text-sm font-medium"
           :class="collapsed ? 'justify-center' : ''"
           style="{{ request()->routeIs('forum.*') ? 'background:rgba(255,255,255,0.12); color:#fff' : 'color:rgba(255,255,255,0.6)' }}"
           onmouseover="this.style.background='rgba(255,255,255,0.08)';this.style.color='#fff'"
           onmouseout="this.style.background='{{ request()->routeIs('forum.*') ? 'rgba(255,255,255,0.12)' : 'transparent' }}';this.style.color='{{ request()->routeIs('forum.*') ? '#fff' : 'rgba(255,255,255,0.6)' }}'">
            <i data-lucide="messages-square" style="width:19px;height:19px;flex-shrink:0"></i>
            <span x-show="!collapsed" x-cloak
                  x-transition:enter="transition ease-out duration-200"
                  x-transition:enter-start="opacity-0 -translate-x-2"
                  x-transition:enter-end="opacity-100 translate-x-0"
                  x-transition:leave="transition ease-in duration-150"
                  x-transition:leave-start="opacity-100 translate-x-0"
                  x-transition:leave-end="opacity-0 -translate-x-2">Forum Diskusi</span>
        </a>

        {{-- 6. Absensi --}}
        <a href="{{ route('student.absensi') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors text-sm font-medium"
           :class="collapsed ? 'justify-center' : ''"
           style="{{ request()->routeIs('student.absensi') ? 'background:rgba(255,255,255,0.12); color:#fff' : 'color:rgba(255,255,255,0.6)' }}"
           onmouseover="this.style.background='rgba(255,255,255,0.08)';this.style.color='#fff'"
           onmouseout="this.style.background='{{ request()->routeIs('student.absensi') ? 'rgba(255,255,255,0.12)' : 'transparent' }}';this.style.color='{{ request()->routeIs('student.absensi') ? '#fff' : 'rgba(255,255,255,0.6)' }}'">
            <i data-lucide="calendar-check" style="width:19px;height:19px;flex-shrink:0"></i>
            <span x-show="!collapsed" x-cloak
                  x-transition:enter="transition ease-out duration-200"
                  x-transition:enter-start="opacity-0 -translate-x-2"
                  x-transition:enter-end="opacity-100 translate-x-0"
                  x-transition:leave="transition ease-in duration-150"
                  x-transition:leave-start="opacity-100 translate-x-0"
                  x-transition:leave-end="opacity-0 -translate-x-2">Absensi</span>
        </a>

        {{-- 7. Pengaturan --}}
        <a href="{{ route('student.pengaturan') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors text-sm font-medium"
           :class="collapsed ? 'justify-center' : ''"
           style="{{ request()->routeIs('student.pengaturan') ? 'background:rgba(255,255,255,0.12); color:#fff' : 'color:rgba(255,255,255,0.6)' }}"
           onmouseover="this.style.background='rgba(255,255,255,0.08)';this.style.color='#fff'"
           onmouseout="this.style.background='{{ request()->routeIs('student.pengaturan') ? 'rgba(255,255,255,0.12)' : 'transparent' }}';this.style.color='{{ request()->routeIs('student.pengaturan') ? '#fff' : 'rgba(255,255,255,0.6)' }}'">
            <i data-lucide="settings" style="width:19px;height:19px;flex-shrink:0"></i>
            <span x-show="!collapsed" x-cloak
                  x-transition:enter="transition ease-out duration-200"
                  x-transition:enter-start="opacity-0 -translate-x-2"
                  x-transition:enter-end="opacity-100 translate-x-0"
                  x-transition:leave="transition ease-in duration-150"
                  x-transition:leave-start="opacity-100 translate-x-0"
                  x-transition:leave-end="opacity-0 -translate-x-2">Pengaturan</span>
        </a>

    </nav>

    {{-- LOGOUT --}}
    <form method="POST" action="{{ route('logout') }}" class="mt-2">
        @csrf
        <button type="submit"
                class="flex items-center gap-3 px-3 py-2.5 w-full rounded-xl text-sm font-medium text-white/40 hover:text-white/70 hover:bg-white/5 transition-colors"
                :class="collapsed ? 'justify-center' : ''">
            <i data-lucide="log-out" style="width:19px;height:19px;flex-shrink:0"></i>
            <span x-show="!collapsed" x-cloak
                  x-transition:enter="transition ease-out duration-200"
                  x-transition:enter-start="opacity-0 -translate-x-2"
                  x-transition:enter-end="opacity-100 translate-x-0"
                  x-transition:leave="transition ease-in duration-150"
                  x-transition:leave-start="opacity-100 translate-x-0"
                  x-transition:leave-end="opacity-0 -translate-x-2">Keluar</span>
        </button>
    </form>
</aside>
