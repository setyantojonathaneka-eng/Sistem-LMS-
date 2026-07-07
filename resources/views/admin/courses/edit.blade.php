<x-app-layout>
    <div class="p-6 max-w-xl">
        <h1 class="text-2xl font-bold mb-6">Edit Kursus</h1>

        <form action="{{ route('admin.courses.update', $course) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block font-medium mb-1">Judul</label>
                <input type="text" name="title" value="{{ old('title', $course->title) }}"
                       class="w-full border rounded p-2">
                @error('title') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block font-medium mb-1">Deskripsi</label>
                <textarea name="description" rows="4" class="w-full border rounded p-2">{{ old('description', $course->description) }}</textarea>
                @error('description') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block font-medium mb-1">Instruktur</label>
                <select name="instructor_id" class="w-full border rounded p-2">
                    @foreach ($instructors as $instructor)
                        <option value="{{ $instructor->id }}" @selected(old('instructor_id', $course->instructor_id) == $instructor->id)>
                            {{ $instructor->name }}
                        </option>
                    @endforeach
                </select>
                @error('instructor_id') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_published" value="1" id="is_published"
                       @checked(old('is_published', $course->is_published))>
                <label for="is_published">Publikasikan</label>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
                <a href="{{ route('admin.courses.index') }}" class="px-4 py-2 rounded border">Batal</a>
            </div>
        </form>
    </div>
</x-app-layout>