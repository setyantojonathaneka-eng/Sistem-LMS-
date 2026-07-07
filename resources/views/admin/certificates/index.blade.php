<x-app-layout>
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-6">Sertifikat</h1>
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-100 text-left">
                    <tr>
                        <th class="p-3 font-semibold">Siswa</th>
                        <th class="p-3 font-semibold">Kursus</th>
                        <th class="p-3 font-semibold">Nomor</th>
                        <th class="p-3 font-semibold">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($certificates as $c)
                        <tr class="border-t">
                            <td class="p-3">{{ $c->user->name ?? '-' }}</td>
                            <td class="p-3">{{ $c->course->title ?? '-' }}</td>
                            <td class="p-3">{{ $c->number ?? $c->id }}</td>
                            <td class="p-3">{{ $c->created_at->format('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="p-6 text-center text-gray-400">Belum ada sertifikat.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
