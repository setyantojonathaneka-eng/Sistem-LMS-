@extends('student')

@section('title', 'Forum Diskusi')

@section('content')
<div x-data="forumChat()" x-init="init()" class="max-w-6xl mx-auto">
  <div class="mb-4">
    <h2 class="text-2xl font-extrabold" style="color:#2C4A5E">Forum Diskusi</h2>
    <p class="text-sm text-[#8a7d70] mt-1">Diskusi per course — tanya jawab dengan pengajar dan sesama mahasiswa.</p>
  </div>

  <div class="bg-white rounded-2xl border border-black/[0.04] shadow-sm overflow-hidden" style="display:grid; grid-template-columns:220px 1fr; height:580px;">
    {{-- Left: Course tabs --}}
    <div style="border-right:1px solid #eee; overflow-y:auto; background:#F8F6F4;">
      <template x-for="c in courses" :key="c.id">
        <div @click="selectCourse(c.id)"
             style="padding:12px 14px; cursor:pointer; border-bottom:1px solid #eee; font-size:13px; display:flex; align-items:center; gap:8px; transition:all .15s;"
             :style="selected === c.id ? 'background:#DCEBFA; color:#1E40AF; font-weight:600;' : 'background:transparent; color:#2C4A5E;'">
          <div style="width:28px; height:28px; border-radius:50%; background:#E4DED6; display:flex; align-items:center; justify-content:center; font-size:11px; font-weight:700; flex-shrink:0; color:#6b5f52;"
               x-text="c.title[0].toUpperCase()"></div>
          <div style="overflow:hidden;">
            <div x-text="c.title" style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis;"></div>
            <div x-show="c.last_preview" style="font-size:10px; color:#8a7d70; white-space:nowrap;overflow:hidden;text-overflow:ellipsis; margin-top:1px;" x-text="c.last_preview"></div>
          </div>
          <span x-show="c.post_count > 0"
                style="margin-left:auto; background:#5D9EC7; color:#fff; font-size:9px; padding:1px 6px; border-radius:999px; flex-shrink:0;"
                x-text="c.post_count"></span>
        </div>
      </template>
      <div x-show="courses.length === 0" style="padding:20px; text-align:center; font-size:12px; color:#8a7d70;">
        <p>Belum ada course.</p>
        <p class="mt-1">Enroll course untuk mulai diskusi.</p>
      </div>
    </div>

    {{-- Right: Chat area --}}
    <div style="display:flex; flex-direction:column; height:580px;">
      {{-- Header --}}
      <div style="padding:12px 16px; border-bottom:1px solid #eee; display:flex; align-items:center; gap:8px; background:#fff;">
        <div style="width:32px; height:32px; border-radius:50%; background:#E4DED6; display:flex; align-items:center; justify-content:center; font-size:12px; font-weight:700; color:#6b5f52;"
             x-text="selectedCourse?.title?.[0]?.toUpperCase() || '?'"></div>
        <div>
          <div style="font-weight:700; font-size:14px; color:#2C4A5E" x-text="selectedCourse?.title || 'Pilih course'"></div>
          <div style="font-size:11px; color:#8a7d70">
            <span x-text="messages.length + ' pesan'"></span>
            <span x-show="typing" style="margin-left:8px; color:#5D9EC7; font-style:italic;">mengetik...</span>
          </div>
        </div>
      </div>

      {{-- Messages --}}
      <div style="flex:1; overflow-y:auto; padding:14px; background:#F0EAE4;" x-ref="chatbox">
        <template x-for="msg in messages" :key="msg.id">
          <div style="display:flex; gap:8px; margin-bottom:12px; flex-direction:row;" :style="msg.is_mine ? 'flex-direction:row-reverse' : ''">
            <div style="width:30px; height:30px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:11px; font-weight:700; flex-shrink:0; margin-top:4px;"
                 :style="'background:' + (msg.is_mine ? '#DCEBFA' : '#E4DED6') + '; color:' + (msg.is_mine ? '#1E40AF' : '#6b5f52')"
                 x-text="(msg.user?.name || '?')[0].toUpperCase()"></div>
            <div style="max-width:75%;">
              <div style="display:flex; align-items:center; gap:4px; margin-bottom:2px; flex-wrap:wrap; flex-direction:row;"
                   :style="msg.is_mine ? 'flex-direction:row-reverse' : ''">
                <span style="font-size:11px; font-weight:600; color:#2C4A5E" x-text="msg.user?.name || '-'"></span>
                <span x-show="msg.user?.role === 'admin' || msg.user?.role === 'instructor'"
                      style="font-size:9px; font-weight:700; padding:1px 6px; border-radius:999px;"
                      :style="'background:' + (msg.user?.role === 'admin' ? '#FEF2F2' : '#FBF0D2') + '; color:' + (msg.user?.role === 'admin' ? '#991B1B' : '#B8860B')"
                      x-text="msg.user?.role === 'admin' ? 'Admin' : 'Instructor'"></span>
                <span style="font-size:10px; color:#8a7d70" x-text="timeAgo(msg.created_at)"></span>
              </div>
              <div style="border-radius:16px; padding:8px 14px; font-size:13px; line-height:1.5; word-wrap:break-word;"
                   :style="msg.is_mine ? 'background:#DCEBFA; color:#1E405E; border-bottom-right-radius:4px;' : 'background:#fff; color:#2C4A5E; border-bottom-left-radius:4px;'">
                <p style="margin:0; white-space:pre-wrap;" x-text="msg.body"></p>
              </div>
              <button x-show="msg.can_delete" @click="deleteMsg(msg.id)"
                      style="font-size:10px; color:#f87171; border:none; background:none; cursor:pointer; padding:0; margin-top:2px;">Hapus</button>
            </div>
          </div>
        </template>
        <div x-show="messages.length === 0 && selected"
             style="text-align:center; color:#8a7d70; font-size:13px; padding:60px 0;">
          <span class="material-symbols-outlined" style="font-size:32px;color:#c9bdb0;display:block;text-align:center">forum</span>
          <p class="mt-2">Belum ada pesan. Mulai diskusi!</p>
        </div>
        <div x-show="!selected"
             style="text-align:center; color:#8a7d70; font-size:13px; padding:80px 0;">
          <span class="material-symbols-outlined" style="font-size:48px;color:#c9bdb0;display:block;text-align:center">forum</span>
          <p class="mt-3 font-semibold" style="color:#2C4A5E">Pilih course di sebelah kiri</p>
          <p class="mt-1 text-sm">untuk mulai diskusi</p>
        </div>
      </div>

      {{-- Input --}}
      <div style="border-top:1px solid #eee; padding:10px 14px; display:flex; gap:8px; background:#fff;">
        <input type="text" x-model="text" @keydown.enter="send()"
               style="flex:1; border:1px solid #ddd; border-radius:12px; padding:8px 14px; font-size:13px; outline:none; background:#F8F6F4;"
               placeholder="Ketik pesan..." x-bind:disabled="!selected">
        <button @click="send()" :disabled="!text.trim() || !selected"
                style="padding:8px 18px; border-radius:12px; font-size:13px; font-weight:600; color:#fff; border:none; cursor:pointer; display:flex; align-items:center; gap:4px;"
                :style="text.trim() && selected ? 'background:#5D9EC7' : 'background:#b0cfe0; cursor:not-allowed;'">
          <span class="material-symbols-outlined" style="font-size:16px;">send</span> Kirim
        </button>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
function forumChat() {
  return {
    courses: @json($forumCourses),
    selected: null,
    messages: [],
    text: '',
    lastFetch: null,
    pollTimer: null,
    typing: false,
    get selectedCourse() {
      return this.courses.find(c => c.id === this.selected) || null;
    },
    init() {
      if (this.courses.length > 0) this.selectCourse(this.courses[0].id);
    },
    selectCourse(id) {
      this.selected = id;
      this.messages = [];
      this.lastFetch = null;
      if (this.pollTimer) clearInterval(this.pollTimer);
      this.fetchMessages();
      this.pollTimer = setInterval(() => this.fetchMessages(), 5000);
    },
    fetchMessages() {
      if (!this.selected) return;
      let url = '/api/courses/' + this.selected + '/forum';
      if (this.lastFetch) url += '?since=' + encodeURIComponent(this.lastFetch);
      fetch(url).then(r => r.json()).then(data => {
        if (Array.isArray(data)) {
          data.forEach(m => {
            if (!this.messages.some(x => x.id === m.id)) {
              m.is_mine = m.user_id === {{ auth()->id() }};
              m.can_delete = {{ auth()->user()->role === 'admin' ? 'true' : 'false' }} || m.user_id === {{ auth()->id() }};
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
      if (!this.text.trim() || !this.selected) return;
      let csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';
      fetch('/api/courses/' + this.selected + '/forum', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
        body: JSON.stringify({ body: this.text, title: '' })
      }).then(r => r.json()).then(data => {
        this.text = '';
        this.lastFetch = null;
        this.fetchMessages();
      });
    },
    deleteMsg(id) {
      if (!confirm('Hapus pesan ini?')) return;
      let csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';
      fetch('/api/forum/' + id, {
        method: 'DELETE',
        headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' }
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
