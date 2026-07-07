@extends('student')

@section('title', 'Absensi')

@section('content')
    <div class="mb-5">
        <h2 class="text-2xl font-extrabold" style="color:#2C4A5E">Absensi</h2>
        <p class="text-sm text-[#8a7d70] mt-1">Kehadiran berdasarkan progress penyelesaian course Anda.</p>
    </div>

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <x-stat-card label="Total Course" :value="$attendanceRecap['total']" icon="school" color="#5D9EC7" />
        <x-stat-card label="Hadir (Selesai)" :value="$attendanceRecap['hadir']" icon="check_circle" color="#69B96F" />
        <x-stat-card label="Alfa (Belum Selesai)" :value="$attendanceRecap['alfa']" icon="close" color="#E88774" />
        <x-stat-card label="Persentase" :value="$attendanceRecap['pct'] . '%'" icon="trending_up" color="#5D9EC7" />
    </div>

    <div class="grid lg:grid-cols-2 gap-4 mb-6">
        <div class="bg-white rounded-2xl p-5 border border-black/[0.04] shadow-sm">
            <h4 class="font-bold text-sm mb-3" style="color:#2C4A5E">Distribusi Kehadiran</h4>
            @if ($attendanceRecap['total'])
                <canvas id="chartDistribusi" height="200"></canvas>
            @else
                <x-empty-state text="Belum ada course." />
            @endif
        </div>

        <div class="bg-white rounded-2xl p-5 border border-black/[0.04] shadow-sm">
            <h4 class="font-bold text-sm mb-3" style="color:#2C4A5E">Perbandingan</h4>
            <canvas id="chartRekap" height="200"></canvas>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-black/[0.04] shadow-sm overflow-hidden">
        <div class="p-4 border-b border-black/[0.05]">
            <h4 class="font-bold" style="color:#2C4A5E">Riwayat Course</h4>
        </div>
        <div class="divide-y divide-black/[0.04]">
            @foreach ($sessions as $s)
                @php
                    $isHadir = $s->status === 'hadir';
                @endphp
                <div class="p-4 flex items-center gap-4 flex-wrap">
                    <div class="flex-1 min-w-0">
                        <p class="font-semibold text-sm truncate" style="color:#2C4A5E">{{ $s->judul }}</p>
                        <p class="text-xs text-[#8a7d70]">Bergabung {{ $s->tanggal }} · Progress {{ $s->progress }}%</p>
                    </div>
                    <span class="text-xs font-semibold px-3 py-1.5 rounded-full" style="background:{{ $isHadir ? '#DDF2DC' : '#FBDFD9' }}; color:{{ $isHadir ? '#3E8B45' : '#C05545' }}">
                        {{ $isHadir ? 'Hadir (Selesai)' : 'Alfa (Belum Selesai)' }}
                    </span>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@push('scripts')
<script>
    @if ($attendanceRecap['total'])
    new Chart(document.getElementById('chartDistribusi'), {
        type: 'doughnut',
        data: {
            labels: ['Hadir (Selesai)', 'Alfa (Belum Selesai)'],
            datasets: [{
                data: [{{ $attendanceRecap['hadir'] }}, {{ $attendanceRecap['alfa'] }}],
                backgroundColor: ['#69B96F', '#E88774'],
                borderWidth: 0,
            }]
        },
        options: { plugins: { legend: { position: 'bottom' } }, cutout: '65%' }
    });
    @endif

    new Chart(document.getElementById('chartRekap'), {
        type: 'bar',
        data: {
            labels: ['Hadir (Selesai)', 'Alfa (Belum Selesai)'],
            datasets: [{
                data: [{{ $attendanceRecap['hadir'] }}, {{ $attendanceRecap['alfa'] }}],
                backgroundColor: '#5D9EC7',
                borderRadius: 6,
            }]
        },
        options: {
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }
        }
    });
</script>
@endpush
