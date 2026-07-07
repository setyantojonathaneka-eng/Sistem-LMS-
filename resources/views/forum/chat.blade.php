@extends('student')

@section('title', 'Diskusi - ' . $course->title)

@section('content')
<div class="max-w-4xl mx-auto">
    <a href="{{ route('forum.index') }}" class="text-sm text-[#8a7d70] mb-3 flex items-center gap-1">
        <span class="material-symbols-outlined" style="font-size:14px;transform:rotate(180deg)">chevron_right</span> Forum
    </a>

    <h2 class="text-2xl font-extrabold mb-1" style="color:#2C4A5E">{{ $course->title }}</h2>
    <p class="text-sm text-[#8a7d70] mb-5">Diskusi kursus — tanya jawab dengan pengajar dan sesama mahasiswa</p>

    <div class="bg-white rounded-2xl border border-black/[0.04] shadow-sm overflow-hidden"
         x-data="chat({{ $course->id }})" x-init="init()">
        <div class="h-[500px] overflow-y-auto p-4 space-y-3" x-ref="chatbox" id="chatbox">
            <template x-for="msg in messages" :key="msg.id">
                <div class="flex gap-2.5" :class="msg.is_mine ? 'flex-row-reverse' : ''">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold shrink-0"
                         :style="'background:' + (msg.is_mine ? '#DCEBFA' : '#F0EAE4') + '; color:' + (msg.is_mine ? '#1E40AF' : '#6b5f52')"
                         x-text="(msg.user?.name || '?')[0].toUpperCase()"></div>
                    <div class="max-w-[75%]" :class="msg.is_mine ? 'items-end' : 'items-start'">
                        <div class="flex items-center gap-1.5 mb-0.5">
                            <span class="text-xs font-semibold" style="color:#2C4A5E" x-text="msg.user?.name || '-'"></span>
                            <span x-show="msg.user?.role === 'admin' || msg.user?.role === 'instructor'"
                                  class="text-[10px] font-bold px-1.5 py-0.5 rounded-full"
                                  :style="'background:' + (msg.user?.role === 'admin' ? '#FEF2F2' : '#FBF0D2') + '; color:' + (msg.user?.role === 'admin' ? '#991B1B' : '#B8860B')"
                                  x-text="msg.user?.role === 'admin' ? 'Admin' : 'Instructor'"></span>
                        </div>
                        <div class="rounded-2xl px-3.5 py-2.5 text-sm leading-relaxed"
                             :style="msg.is_mine ? 'background:#DCEBFA; color:#1E405E' : 'background:#F5F2EF; color:#2C4A5E'">
                            <p x-show="msg.title" class="font-bold text-sm mb-1" x-text="msg.title"></p>
                            <p x-text="msg.body"></p>
                        </div>
                        <div class="flex items-center gap-2 mt-0.5">
                            <span class="text-[10px] text-[#8a7d70]" x-text="timeAgo(msg.created_at)"></span>
                            <button x-show="msg.can_delete" @click="deleteMsg(msg.id)"
                                    class="text-[10px] text-red-400 hover:text-red-600 transition-colors">Hapus</button>
                        </div>
                    </div>
                </div>
            </template>
        </div>

        <div class="border-t border-black/[0.04] p-3 flex gap-2">
            <input type="text" x-model="text" @keydown.enter="send()"
                   class="flex-1 rounded-xl border border-black/[0.08] px-4 py-2.5 text-sm"
                   style="background:#F8F6F4" placeholder="Ketik pesan...">
            <button @click="send()" :disabled="!text.trim()"
                    class="px-4 py-2.5 rounded-xl text-sm font-semibold text-white disabled:opacity-40"
                    style="background:#5D9EC7">
                <span class="material-symbols-outlined" style="font-size:16px;vertical-align:middle">send</span>
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
function chat(courseId) {
    return {
        messages: [],
        text: '',
        lastFetch: null,
        init() {
            this.fetchMessages();
            setInterval(() => this.fetchMessages(), 5000);
        },
        fetchMessages() {
            let url = '/api/courses/' + courseId + '/forum';
            if (this.lastFetch) url += '?since=' + encodeURIComponent(this.lastFetch);
            fetch(url)
                .then(r => r.json())
                .then(data => {
                    if (Array.isArray(data)) {
                        data.forEach(m => {
                            if (!this.messages.some(x => x.id === m.id)) {
                                m.is_mine = m.user_id === {{ auth()->id() }};
                                m.can_delete = m.user_id === {{ auth()->id() }} || {{ auth()->user()->role === 'admin' ? 'true' : 'false' }};
                                this.messages.push(m);
                            }
                        });
                        this.messages.sort((a, b) => new Date(a.created_at) - new Date(b.created_at));
                    }
                    this.lastFetch = new Date().toISOString();
                    this.$nextTick(() => {
                        const box = this.$refs.chatbox;
                        if (box) box.scrollTop = box.scrollHeight;
                    });
                });
        },
        send() {
            if (!this.text.trim()) return;
            fetch('/api/courses/' + courseId + '/forum', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
                body: JSON.stringify({ body: this.text, title: '' })
            }).then(r => r.json()).then(data => {
                this.text = '';
                this.lastFetch = null;
                this.fetchMessages();
            });
        },
        deleteMsg(id) {
            if (!confirm('Hapus pesan ini?')) return;
            fetch('/api/forum/' + id, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
            }).then(r => r.json()).then(() => {
                this.messages = this.messages.filter(m => m.id !== id);
            });
        },
        timeAgo(dt) {
            const diff = Date.now() - new Date(dt).getTime();
            const min = Math.floor(diff / 60000);
            if (min < 1) return 'baru saja';
            if (min < 60) return min + 'm';
            const hr = Math.floor(min / 60);
            if (hr < 24) return hr + 'j';
            return new Date(dt).toLocaleDateString('id-ID');
        }
    };
}
</script>
@endpush
@endsection
