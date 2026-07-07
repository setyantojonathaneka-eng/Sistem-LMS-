<x-app-layout>
    <div class="p-6 max-w-xl">
        <h1 class="text-2xl font-bold mb-6">Generate Sertifikat</h1>
        <form action="{{ route('admin.certificates.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block font-medium mb-1">Siswa</label>
                <select name="user_id" class="w-full border rounded px-3 py-2" required>
                    @foreach ($students as $s)
                        <option value="{{ $s->id }}">{{ $s->name }} ({{ $s->email }})</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block font-medium mb-1">Kursus</label>
                <select name="course_id" class="w-full border rounded px-3 py-2" required>
                    @foreach ($courses as $c)
                        <option value="{{ $c->id }}">{{ $c->title }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Generate</button>
        </form>
    </div>
</x-app-layout>
