{{--
    Pengganti <StatCard label icon color /> di HomePage.jsx
    Pemakaian:
    <x-stat-card label="Course Aktif" :value="$enrolled->count()" icon="book-open" color="#5D9EC7" />
--}}
@props(['label', 'value', 'icon', 'color' => '#5D9EC7'])

<div class="bg-white rounded-2xl p-5 border border-black/[0.04] shadow-sm lms-fade">
    <div class="w-11 h-11 rounded-xl flex items-center justify-center mb-3" style="background: {{ $color }}22">
        <span class="material-symbols-outlined" style="font-size:22px;color:{{ $color }}">{{ $icon }}</span>
    </div>
    <p class="text-2xl font-extrabold" style="color:#2C4A5E">{{ $value }}</p>
    <p class="text-xs text-[#8a7d70]">{{ $label }}</p>
</div>
