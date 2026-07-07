<x-app-layout>
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Daftar Kursus</h1>
            <a href="{{ route('admin.courses.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">
                + Tambah Kursus
            </a>
        </div>

        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <table class="w-full border-collapse bg-white shadow rounded">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="p-3">Judul</th>
                    <th class="p-3">Instruktur</th>
                    <th class="p-3">Lesson</th>
                    <th class="p-3">Enrollment</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($courses as $course)
                    <tr class="border-t">
                        <td class="p-3">{{ $course->title }}</td>
                        <td class="p-3">{{ $course->instructor->name ?? '-' }}</td>
                        <td class="p-3">{{ $course->lessons->count() }}</td>
                        <td class="p-3">{{ $course->enrollments->count() }}</td>
                        <td class="p-3">
                            @if ($course->is_published)
                                <span class="text-green-600 font-semibold">Published</span>
                            @else
                                <span class="text-gray-500">Draft</span>
                            @endif
                        </td>
                        <td class="p-3 space-x-2">
                            <a href="{{ route('admin.courses.edit', $course) }}" class="text-blue-600">Edit</a>
                            <form action="{{ route('admin.courses.destroy', $course) }}" method="POST" class="inline"
                                  onsubmit="return confirm('Yakin hapus kursus ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-3 text-center text-gray-500">Belum ada kursus.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>