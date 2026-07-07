@extends('student')

@section('title', 'Pengaturan')

@section('content')
<div class="mb-5">
    <h2 class="text-2xl font-extrabold" style="color:#2C4A5E">Pengaturan</h2>
    <p class="text-sm text-[#8a7d70] mt-1">Kelola profil dan preferensi akun Anda.</p>
</div>

@if (session('success'))
    <div style="background:#DDF2DC;color:#3E8B45;padding:14px 20px;border-radius:14px;margin-bottom:20px;font-size:14px;font-weight:600;display:flex;align-items:center;gap:8px;">
        <span class="material-symbols-outlined" style="font-size:18px;">check_circle</span> {{ session('success') }}
    </div>
@endif

<div class="grid lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 flex flex-col gap-5">

        {{-- Profil --}}
        <div style="background:#fff;border-radius:16px;border:1px solid #E4DED6;box-shadow:0 1px 4px rgba(0,0,0,0.04);overflow:hidden;">
            <div style="padding:18px 24px;border-bottom:1px solid #E4DED6;display:flex;align-items:center;gap:8px;">
                <span class="material-symbols-outlined" style="font-size:18px;color:#5D9EC7;">person</span>
                <span style="font-size:15px;font-weight:700;color:#2C4A5E;">Profil</span>
            </div>
            <div style="padding:24px;">
                <form action="{{ route('student.pengaturan.profil') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div style="display:flex;align-items:center;gap:20px;flex-wrap:wrap;margin-bottom:20px;">
                        <div style="position:relative;width:72px;height:72px;flex-shrink:0;">
                            @php $u = auth()->user(); @endphp
                            <img id="photoPreview" src="{{ $u->photo_url ?? '' }}" onerror="this.style.display='none'"
                                 style="width:72px;height:72px;border-radius:50%;object-fit:cover;border:3px solid #fff;box-shadow:0 2px 8px rgba(0,0,0,0.1);{{ $u->photo_url ? '' : 'display:none' }}">
                            <span id="previewFallback" style="{{ $u->photo_url ? 'display:none' : '' }}">
                                <x-avatar :size="18" extra="" />
                            </span>
                        </div>
                        <div>
                            <label for="photoInput" style="display:inline-flex;align-items:center;gap:6px;padding:8px 18px;border-radius:10px;font-size:13px;font-weight:600;cursor:pointer;background:#5D9EC7;color:#fff;border:none;transition:opacity .15s;" onmouseover="this.style.opacity='.9'" onmouseout="this.style.opacity='1'">
                                <span class="material-symbols-outlined" style="font-size:16px;">upload</span> Upload Foto
                            </label>
                            <input type="file" name="photo" accept="image/*" id="photoInput" hidden
                                   onchange="var f=this.files[0];if(f){var r=new FileReader();r.onload=function(e){var p=document.getElementById('photoPreview');p.src=e.target.result;p.style.display='block';p.onerror=null;document.getElementById('previewFallback').style.display='none'};r.readAsDataURL(f)}">
                            <p style="margin:4px 0 0;font-size:11px;color:#8a7d70;">Format: JPG, PNG. Maks 2MB</p>
                            @error('photo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label style="display:block;font-size:12px;font-weight:700;color:#2C4A5E;margin-bottom:6px;text-transform:uppercase;letter-spacing:.04em;">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ $u->name }}"
                                   style="width:100%;padding:11px 16px;border-radius:12px;border:1.5px solid #E4DED6;font-size:14px;outline:none;background:#F0EAE4;transition:border-color .2s,box-shadow .2s;box-sizing:border-box;"
                                   onfocus="this.style.borderColor='#5D9EC7';this.style.boxShadow='0 0 0 3px rgba(93,158,199,0.15)';this.style.background='#fff'"
                                   onblur="this.style.borderColor='#E4DED6';this.style.boxShadow='none';this.style.background='#F0EAE4'">
                        </div>
                        <div>
                            <label style="display:block;font-size:12px;font-weight:700;color:#2C4A5E;margin-bottom:6px;text-transform:uppercase;letter-spacing:.04em;">Email</label>
                            <input type="email" name="email" value="{{ $u->email }}"
                                   style="width:100%;padding:11px 16px;border-radius:12px;border:1.5px solid #E4DED6;font-size:14px;outline:none;background:#F0EAE4;transition:border-color .2s,box-shadow .2s;box-sizing:border-box;"
                                   onfocus="this.style.borderColor='#5D9EC7';this.style.boxShadow='0 0 0 3px rgba(93,158,199,0.15)';this.style.background='#fff'"
                                   onblur="this.style.borderColor='#E4DED6';this.style.boxShadow='none';this.style.background='#F0EAE4'">
                        </div>
                    </div>
                    <button type="submit" style="display:inline-flex;align-items:center;gap:8px;padding:11px 28px;border-radius:12px;border:none;font-size:14px;font-weight:700;color:#fff;background:linear-gradient(135deg,#2C4A5E,#1a3040);cursor:pointer;transition:opacity .2s,transform .15s;box-shadow:0 2px 8px rgba(44,74,94,0.25);margin-top:20px;"
                            onmouseover="this.style.opacity='.92';this.style.transform='translateY(-1px)'"
                            onmouseout="this.style.opacity='1';this.style.transform='none'">
                        <span class="material-symbols-outlined" style="font-size:16px;">save</span> Simpan
                    </button>
                </form>
            </div>
        </div>

        {{-- Bahasa --}}
        <div style="background:#fff;border-radius:16px;border:1px solid #E4DED6;box-shadow:0 1px 4px rgba(0,0,0,0.04);overflow:hidden;">
            <div style="padding:18px 24px;border-bottom:1px solid #E4DED6;display:flex;align-items:center;gap:8px;">
                <span class="material-symbols-outlined" style="font-size:18px;color:#5D9EC7;">language</span>
                <span style="font-size:15px;font-weight:700;color:#2C4A5E;">Bahasa</span>
            </div>
            <div style="padding:24px;">
                <form action="{{ route('student.pengaturan.bahasa') }}" method="POST">
                    @csrf
                    <div style="display:flex;align-items:center;gap:12px;flex-wrap:wrap;">
                        <select name="language" style="padding:11px 16px;border-radius:12px;border:1.5px solid #E4DED6;font-size:14px;outline:none;background:#F0EAE4;min-width:220px;transition:border-color .2s,box-shadow .2s;"
                                onfocus="this.style.borderColor='#5D9EC7';this.style.boxShadow='0 0 0 3px rgba(93,158,199,0.15)'"
                                onblur="this.style.borderColor='#E4DED6';this.style.boxShadow='none'">
                            <option value="id" @if(session('app_language', 'id') === 'id') selected @endif>Bahasa Indonesia</option>
                            <option value="en" @if(session('app_language') === 'en') selected @endif>English</option>
                        </select>
                        <button type="submit" style="display:inline-flex;align-items:center;gap:6px;padding:11px 24px;border-radius:12px;border:none;font-size:13px;font-weight:700;color:#fff;background:#2C4A5E;cursor:pointer;transition:opacity .2s;"
                                onmouseover="this.style.opacity='.9'" onmouseout="this.style.opacity='1'">
                            <span class="material-symbols-outlined" style="font-size:16px;">check</span> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Notifikasi --}}
        <div style="background:#fff;border-radius:16px;border:1px solid #E4DED6;box-shadow:0 1px 4px rgba(0,0,0,0.04);overflow:hidden;">
            <div style="padding:18px 24px;border-bottom:1px solid #E4DED6;display:flex;align-items:center;gap:8px;">
                <span class="material-symbols-outlined" style="font-size:18px;color:#5D9EC7;">notifications</span>
                <span style="font-size:15px;font-weight:700;color:#2C4A5E;">Notifikasi</span>
            </div>
            <div style="padding:24px;">
                <form action="{{ route('student.pengaturan.notifikasi') }}" method="POST">
                    @csrf
                    <label style="display:flex;align-items:center;gap:12px;font-size:14px;cursor:pointer;color:#2C4A5E;padding:8px 0;">
                        <input type="checkbox" name="notifications_enabled" value="1"
                               @if(auth()->user()->notifications_enabled ?? true) checked @endif
                               style="width:18px;height:18px;accent-color:#5D9EC7;cursor:pointer;">
                        Aktifkan notifikasi
                    </label>
                    <button type="submit" style="display:inline-flex;align-items:center;gap:6px;padding:11px 24px;border-radius:12px;border:none;font-size:13px;font-weight:700;color:#fff;background:#2C4A5E;cursor:pointer;transition:opacity .2s;margin-top:12px;"
                            onmouseover="this.style.opacity='.9'" onmouseout="this.style.opacity='1'">
                        <span class="material-symbols-outlined" style="font-size:16px;">check</span> Simpan
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Sidebar card --}}
    <div style="display:flex;flex-direction:column;gap:4;">
        <div style="background:#fff;border-radius:16px;border:1px solid #E4DED6;box-shadow:0 1px 4px rgba(0,0,0,0.04);padding:32px 24px;text-align:center;">
            <div style="margin-bottom:16px;">
                <x-avatar :size="20" extra="mx-auto" />
            </div>
            <h3 style="font-weight:700;font-size:16px;color:#2C4A5E;margin:0 0 4px;">{{ auth()->user()->name }}</h3>
            <p style="font-size:12px;color:#8a7d70;margin:0;">{{ auth()->user()->email }}</p>
            <div style="margin-top:12px;display:inline-flex;align-items:center;gap:4px;padding:4px 14px;border-radius:999px;font-size:11px;font-weight:600;background:rgba(93,158,199,0.12);color:#5D9EC7;">
                <span class="material-symbols-outlined" style="font-size:12px;">badge</span>
                {{ ucfirst(auth()->user()->role) }}
            </div>
        </div>
    </div>
</div>
@endsection
