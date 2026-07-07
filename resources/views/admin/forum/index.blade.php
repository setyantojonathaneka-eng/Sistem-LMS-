<x-app-layout>
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-6">Forum Diskusi</h1>
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-100 text-left">
                    <tr>
                        <th class="p-3 font-semibold">Penulis</th>
                        <th class="p-3 font-semibold">Judul</th>
                        <th class="p-3 font-semibold">Kursus</th>
                        <th class="p-3 font-semibold">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($posts as $p)
                        <tr class="border-t">
                            <td class="p-3">{{ $p->user->name ?? '-' }}</td>
                            <td class="p-3">{{ $p->title ?? $p->body }}</td>
                            <td class="p-3">{{ $p->course->title ?? '-' }}</td>
                            <td class="p-3">{{ $p->created_at->format('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="p-6 text-center text-gray-400">Belum ada diskusi.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
