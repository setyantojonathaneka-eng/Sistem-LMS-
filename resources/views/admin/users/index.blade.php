<x-app-layout>
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-6">Pengguna</h1>
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-100 text-left">
                    <tr>
                        <th class="p-3 font-semibold">Nama</th>
                        <th class="p-3 font-semibold">Email</th>
                        <th class="p-3 font-semibold">Role</th>
                        <th class="p-3 font-semibold">Bergabung</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $u)
                        <tr class="border-t">
                            <td class="p-3">{{ $u->name }}</td>
                            <td class="p-3">{{ $u->email }}</td>
                            <td class="p-3">{{ $u->role }}</td>
                            <td class="p-3">{{ $u->created_at->format('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="p-6 text-center text-gray-400">Belum ada pengguna.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
