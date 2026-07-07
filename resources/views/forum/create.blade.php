@extends('student')

@section('title', 'Post Baru')

@section('content')
<a href="{{ route('forum.index') }}" class="text-sm text-[#8a7d70] mb-3 flex items-center gap-1">
    <span class="material-symbols-outlined" style="font-size:14px;transform:rotate(180deg)">chevron_right</span> Kembali
</a>

<h2 class="text-2xl font-extrabold mb-5" style="color:#2C4A5E">Post Baru</h2>

<form action="{{ route('forum.store') }}" method="POST" class="bg-white rounded-2xl p-5 border border-black/[0.04] shadow-sm max-w-2xl">
    @csrf

    <label class="text-sm font-semibold mb-1 block" style="color:#2C4A5E">Course</label>
    <select name="course_id" required
            class="w-full rounded-xl border border-black/[0.08] px-4 py-3 text-sm mb-4 @error('course_id') border-red-400 @enderror"
            style="background:#F8F6F4">
        <option value="">Pilih course</option>
        @foreach (\App\Models\Course::whereHas('enrollments', fn($q) => $q->where('user_id', auth()->id())->where('status', 'active'))->get() as $c)
            <option value="{{ $c->id }}" {{ old('course_id') == $c->id ? 'selected' : '' }}>{{ $c->title }}</option>
        @endforeach
    </select>
    @error('course_id')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror

    <label class="text-sm font-semibold mb-1 block" style="color:#2C4A5E">Judul</label>
    <input type="text" name="title" value="{{ old('title') }}" required maxlength="255"
           class="w-full rounded-xl border border-black/[0.08] px-4 py-3 text-sm mb-4 @error('title') border-red-400 @enderror"
           style="background:#F8F6F4" placeholder="Contoh: Cara mengerjakan tugas akhir">
    @error('title')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror

    <label class="text-sm font-semibold mb-1 block" style="color:#2C4A5E">Pesan</label>
    <textarea name="body" rows="6" required
              class="w-full rounded-xl border border-black/[0.08] px-4 py-3 text-sm mb-4 @error('body') border-red-400 @enderror"
              style="background:#F8F6F4" placeholder="Tulis pesan diskusi...">{{ old('body') }}</textarea>
    @error('body')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror

    <button type="submit" class="px-5 py-2.5 rounded-xl text-sm font-semibold text-white" style="background:#69B96F">
        <span class="material-symbols-outlined" style="font-size:14px;vertical-align:middle">send</span> Kirim
    </button>
</form>
@endsection
