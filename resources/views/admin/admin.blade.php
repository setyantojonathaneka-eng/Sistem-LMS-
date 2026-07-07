<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <!-- font: Arial, sans-serif -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css"/>
    <style>
        .page { display: none; }
        .page.active { display: block; }
        .nav-item { cursor: pointer; }
    </style>
</head>
<body style="font-family:Arial,sans-serif">
<div class="layout">

  <aside class="sidebar">
    <div class="sidebar-brand">
      <div class="brand-name">&#127891; LearnPath</div>
      <div class="brand-tag">Learning Management System</div>
    </div>

    <div class="nav-section">
      <div class="nav-section-label">Utama</div>
      <div class="nav-item active" data-page="dashboard"><i class="ti ti-layout-dashboard"></i> Dashboard</div>
    </div>

    <div class="nav-section">
      <div class="nav-section-label">Manajemen</div>
      <div class="nav-item" data-page="courses"><span class="material-symbols-outlined">auto_stories</span> Course Management</div>

      <div class="nav-item" data-page="enroll"><span class="material-symbols-outlined">person_add</span> Enroll Student</div>

      <div class="nav-item" data-page="materi"><span class="material-symbols-outlined">play_lesson</span> Materi (Video, PDF)</div>
    </div>

    <div class="nav-section">
      <div class="nav-section-label">Akademik</div>
      <div class="nav-item" data-page="quiz"><span class="material-symbols-outlined">Quiz</span> Quiz &amp; Soal</div>
      <div class="nav-item" data-page="grading"><span class="material-symbols-outlined">Grading</span> Auto Grading</div>

      <div class="nav-item" data-page="sertifikat"><span class="material-symbols-outlined">workspace_premium</span> Sertifikat</div>
    </div>

    <div class="nav-section">
      <div class="nav-section-label">Komunitas</div>
      <div class="nav-item" data-page="forum"><span class="material-symbols-outlined">Forum</span> Diskusi Forum <span class="notif-dot"></span></div>
      <div class="nav-item" data-page="progress"><span class="material-symbols-outlined">insights</span> Progress Tracking</div>
    </div>

    @if(auth()->user()->role === 'admin')
    <div class="nav-section">
      <div class="nav-section-label">Akun</div>
      <div class="nav-item" data-page="auth"><span class="material-symbols-outlined">manage_accounts</span> Users &amp; Roles</div>
    </div>
    @endif

    <div class="nav-section">
      <div class="nav-section-label">Lainnya</div>
      <div class="nav-item" data-page="settings"><span class="material-symbols-outlined">settings</span> Pengaturan Akun</div>
    </div>

      <div class="sidebar-footer">
        <x-avatar :size="9" />
      <div style="flex:1;">
        <div class="sidebar-user-name">{{ auth()->user()->name ?? 'Admin' }}</div>
        <div class="sidebar-user-role">
          @if(auth()->user()->role === 'admin')
            Super Admin
          @elseif(auth()->user()->role === 'instructor')
            Instructor
          @else
            {{ ucfirst(auth()->user()->role ?? 'User') }}
          @endif
        </div>
      </div>
      <form method="POST" action="{{ route('logout') }}" onsubmit="return confirm('Yakin ingin logout?')">
        @csrf
        <button type="submit" class="btn-logout" title="Logout">
          <span class="material-symbols-outlined">logout</span>
        </button>
      </form>
    </div>
  </aside>

  <div class="main-content">

    @if (session('success'))
      <div style="background:#DDF2DC;color:#3E8B45;padding:12px 24px;font-size:14px;font-weight:600;border-bottom:1px solid #C3E6CB;">{{ session('success') }}</div>
    @endif
    @if (session('error'))
      <div style="background:#FDE8E8;color:#C0392B;padding:12px 24px;font-size:14px;font-weight:600;border-bottom:1px solid #F5C6CB;">{{ session('error') }}</div>
    @endif

    {{-- ==================== DASHBOARD ==================== --}}
    <div id="page-dashboard" class="page active">
      <div class="topbar">
        <div class="topbar-title">Dashboard</div>
        <div class="topbar-actions">
          <span class="text-sm text-muted">{{ now()->translatedFormat('l, d F Y') }}</span>
        </div>
      </div>
      <div style="padding:2rem;">

        {{-- Stats --}}
        <div class="stats-grid">
          <div class="stat-card">
            <div class="stat-icon" style="background:var(--purple-50);">&#128100;</div>
            <div class="stat-label">Total Students</div>
            <div class="stat-value">{{ number_format($stats['total_students']) }}</div>
          </div>
          <div class="stat-card">
            <div class="stat-icon" style="background:var(--teal-50);">&#128218;</div>
            <div class="stat-label">Active Courses</div>
            <div class="stat-value">{{ number_format($stats['active_courses']) }}</div>
          </div>
          <div class="stat-card">
            <div class="stat-icon" style="background:var(--amber-50);">&#127881;</div>
            <div class="stat-label">Certificates Issued</div>
            <div class="stat-value">{{ number_format($stats['certificates']) }}</div>
          </div>
          <div class="stat-card">
            <div class="stat-icon" style="background:var(--red-50);">&#10067;</div>
            <div class="stat-label">Quiz Submissions</div>
            <div class="stat-value">{{ number_format($stats['quiz_submissions']) }}</div>
          </div>
        </div>

      {{-- Grafik Aktivitas --}}
<div class="card" style="margin-bottom:1.25rem;">
  <div class="chart-tabs">
    <button class="chart-tab active" data-metric="signups" onclick="switchChartTab(this,'signups')">
      <span class="material-symbols-outlined" style="font-size:16px;">check_box</span> New Signups
    </button>
    <button class="chart-tab" data-metric="enrollments" onclick="switchChartTab(this,'enrollments')">
      <span class="material-symbols-outlined" style="font-size:16px;">grid_view</span> Enrollments
    </button>
    <button class="chart-tab" data-metric="certificates" onclick="switchChartTab(this,'certificates')">
      <span class="material-symbols-outlined" style="font-size:16px;">workspace_premium</span> Sertifikat
    </button>
  </div>
  <div style="padding:1.25rem 1.5rem;">
    <canvas id="activityChart" height="90"></canvas>
  </div>
</div>
        
        {{-- Kursus Terbaru & Progress --}}
        <div class="grid-2" style="margin-bottom:1.25rem;">
          <div class="card">
            <div class="card-header">
              <span class="card-title">Kursus Terbaru</span>
              <button class="btn btn-outline btn-sm" onclick="document.querySelector('[data-page=courses]').click()">Lihat Semua</button>
            </div>
            <div class="table-wrap">
              <table>
                <thead><tr><th>Kursus</th><th>Instructor</th><th>Enrolled</th><th>Status</th></tr></thead>
                <tbody>
                @forelse($recent_courses as $course)
                <tr>
                  <td><strong>{{ $course->title }}</strong></td>
                  <td>{{ $course->instructor->name ?? '—' }}</td>
                  <td>{{ $course->enrollments->count() }}</td>
                  <td>
                    <span class="badge {{ $course->is_published ? 'badge-green' : 'badge-gray' }}">
                      {{ $course->is_published ? 'Aktif' : 'Draft' }}
                    </span>
                  </td>
                </tr>
                @empty
                <tr><td colspan="4" style="text-align:center;color:var(--gray-400);">Belum ada kursus.</td></tr>
                @endforelse
                </tbody>
              </table>
            </div>
          </div>

          <div class="card">
            <div class="card-header"><span class="card-title">Progress Siswa Terbaru</span></div>
            <div class="card-body" style="padding-top:0.5rem;">
              @php $avColors = ['av-purple','av-amber','av-teal','av-coral','av-green']; @endphp
              @forelse($recent_progress as $i => $enrollment)
                  <div class="student-progress-row">
                <x-avatar :user="$enrollment->user" :size="8" />
                <div style="flex:1;">
                  <div style="font-size:13px;font-weight:500;">{{ $enrollment->user->name }}</div>
                  <div style="font-size:11px;color:var(--gray-400);">{{ $enrollment->course->title }}</div>
                </div>
                <div style="width:100px;">
                  <div class="progress-bar">
                    <div class="progress-fill" style="width:{{ $enrollment->progress_percentage }}%"></div>
                  </div>
                  <div style="font-size:11px;text-align:right;color:var(--gray-400);margin-top:2px;">
                    {{ $enrollment->progress_percentage }}%
                  </div>
                </div>
              </div>
              @empty
              <div style="font-size:13px;color:var(--gray-400);padding:1rem 0;">Belum ada data progress.</div>
              @endforelse
            </div>
          </div>
        </div>

        {{-- Quiz, Sertifikat, Forum --}}
        <div class="grid-3">
          <div class="card">
            <div class="card-header"><span class="card-title">Aktivitas Quiz</span></div>
            <div class="card-body">
              <div style="display:flex;flex-direction:column;gap:8px;">
                <div style="display:flex;justify-content:space-between;font-size:13px;">
                  <span>Quiz Selesai Hari Ini</span>
                  <strong>{{ $quiz_stats['completed_today'] }}</strong>
                </div>
                <div style="display:flex;justify-content:space-between;font-size:13px;">
                  <span>Rata-rata Nilai</span>
                  <strong style="color:var(--green-600);">{{ $quiz_stats['average_score'] }}</strong>
                </div>
                <div style="display:flex;justify-content:space-between;font-size:13px;">
                  <span>Pass Rate</span>
                  <strong>{{ $quiz_stats['pass_rate'] }}</strong>
                </div>
              </div>
            </div>
          </div>

          <div class="card">
            <div class="card-header"><span class="card-title">Sertifikat Terbaru</span></div>
            <div class="card-body">
              <div style="font-size:13px;display:flex;flex-direction:column;gap:8px;">
                @forelse($recent_certificates as $i => $cert)
                <div class="flex items-center gap-8">
                  <x-avatar :user="$cert->user" :size="6.5" />
                  <div style="flex:1;">{{ $cert->user->name }}</div>
                  <span class="badge badge-green" style="font-size:10px;">Terkirim</span>
                </div>
                @empty
                <div style="color:var(--gray-400);">Belum ada sertifikat.</div>
                @endforelse
              </div>
            </div>
          </div>

          <div class="card">
            <div class="card-header"><span class="card-title">Forum Terbaru</span></div>
            <div class="card-body">
              <div style="display:flex;flex-direction:column;gap:10px;">
                @forelse($recent_forum as $post)
                <div style="font-size:13px;border-bottom:1px solid var(--gray-100);padding-bottom:8px;">
                  <div style="font-weight:500;margin-bottom:2px;">
                    {{ Str::limit($post->body ?? $post->title, 50) }}
                  </div>
                  <div style="font-size:11px;color:var(--gray-400);">
                    {{ $post->user->name }} · {{ $post->created_at->diffForHumans() }}
                  </div>
                </div>
                @empty
                <div style="color:var(--gray-400);">Belum ada diskusi.</div>
                @endforelse
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>

    {{-- ==================== COURSES ==================== --}}
    <div id="page-courses" class="page">
      <div class="topbar">
        <div class="topbar-title">Course Management</div>
        <div class="topbar-actions">
          <button class="btn btn-primary" onclick="openModal('modal-course')">+ Tambah Kursus</button>
        </div>
      </div>
      <div style="padding:2rem;">
        <div class="search-bar">
          <input class="search-input" type="text" placeholder="Cari kursus...">
          <select class="form-control" id="filterStatusCourse" style="width:160px;" onchange="filterCoursesByStatus()">
            <option value="all">Semua Status</option>
            <option value="aktif">Aktif</option>
            <option value="draft">Draft</option>
          </select>
        </div>
        <div class="card">
          <div class="table-wrap">
            <table>
              <thead>
                <tr><th>#</th><th>Nama Kursus</th><th>Instructor</th><th>Enrolled</th><th>Lessons</th><th>Status</th><th>Aksi</th></tr>
              </thead>
              <tbody>
              @forelse($recent_courses as $course)
              <tr data-status="{{ $course->is_published ? 'aktif' : 'draft' }}">
                <td class="font-mono text-sm text-muted">C{{ str_pad($course->id, 3, '0', STR_PAD_LEFT) }}</td>
                <td>
                  <strong>{{ $course->title }}</strong>
                  <div class="text-sm text-muted">{{ Str::limit($course->description, 40) }}</div>
                </td>
                <td>{{ $course->instructor->name ?? '—' }}</td>
                <td>{{ $course->enrollments->count() }}</td>
                <td>{{ $course->lessons->count() }}</td>
                <td>
                  <span class="badge {{ $course->is_published ? 'badge-green' : 'badge-gray' }}">
                    {{ $course->is_published ? 'Aktif' : 'Draft' }}
                  </span>
                </td>
                <td>
                  <div class="flex gap-8">
                    <button class="btn btn-outline btn-sm"
                      onclick='openEditCourse({{ $course->id }})'>Edit</button>
                    <form method="POST" action="{{ route('admin.courses.destroy', $course->id) }}" onsubmit="return confirm('Hapus kursus ini?')">
                      @csrf @method('DELETE')
                      <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                  </div>
                </td>
              </tr>
              @empty
              <tr><td colspan="7" style="text-align:center;color:var(--gray-400);">Belum ada kursus.</td></tr>
              @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    {{-- ==================== ENROLL ==================== --}}
    <div id="page-enroll" class="page">
      <div class="topbar">
        <div class="topbar-title">Enroll Student</div>
        <div class="topbar-actions">
          <button class="btn btn-primary" onclick="openModal('modal-enroll')">+ Enroll Baru</button>
        </div>
      </div>
      <div style="padding:2rem;">
        <div class="alert alert-info">
          &#128139; Total {{ number_format($stats['total_students']) }} student terdaftar di {{ number_format($stats['active_courses']) }} kursus aktif.
        </div>
        <div class="search-bar">
          <input class="search-input" type="text" placeholder="Cari student atau kursus...">
        </div>
        <div class="card">
          <div class="table-wrap">
            <table>
              <thead><tr><th>Student</th><th>Email</th><th>Kursus</th><th>Tanggal Enroll</th><th>Progress</th><th>Status</th><th>Aksi</th></tr></thead>
              <tbody>
              @forelse($recent_progress as $i => $enrollment)
              <tr>
                <td>
                  <div class="flex items-center gap-8">
                    <x-avatar :user="$enrollment->user" :size="8" />
                    <div>{{ $enrollment->user->name }}</div>
                  </div>
                </td>
                <td class="text-sm text-muted">{{ $enrollment->user->email }}</td>
                <td>{{ $enrollment->course->title }}</td>
                <td class="text-sm">{{ $enrollment->enrolled_at ? $enrollment->enrolled_at->format('d M Y') : '—' }}</td>
                <td>
                  <div style="width:80px;">
                    <div class="progress-bar">
                      <div class="progress-fill" style="width:{{ $enrollment->progress_percentage }}%"></div>
                    </div>
                    <div class="text-sm text-muted" style="margin-top:2px;">{{ $enrollment->progress_percentage }}%</div>
                  </div>
                </td>
                <td>
                  <span class="badge {{ $enrollment->status === 'active' ? 'badge-green' : ($enrollment->status === 'completed' ? 'badge-teal' : 'badge-gray') }}">
                    {{ ucfirst($enrollment->status) }}
                  </span>
                </td>
                <td>
                  <form method="POST" action="{{ route('admin.enrollments.destroy', $enrollment->id) }}" onsubmit="return confirm('Unenroll student ini?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Unenroll</button>
                  </form>
                </td>
              </tr>
              @empty
              <tr><td colspan="7" style="text-align:center;color:var(--gray-400);">Belum ada enrollment.</td></tr>
              @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    {{-- ==================== MATERI ==================== --}}
    <div id="page-materi" class="page">
      <div class="topbar">
        <div class="topbar-title">Materi (Video &amp; PDF)</div>
        <div class="topbar-actions">
          <button class="btn btn-primary" onclick="openModal('modal-materi')">+ Upload Materi</button>
        </div>
      </div>
      <div style="padding:2rem;">
        <div class="search-bar">
          <input class="search-input" type="text" placeholder="Cari materi...">
          <select class="form-control" id="filterTypeMateri" style="width:160px;" onchange="filterMateriByType()">
            <option value="all">Semua Tipe</option>
            <option value="video">&#127916; Video</option>
            <option value="pdf">&#128196; PDF</option>
          </select>
        </div>
        <div class="card">
          <div class="table-wrap">
            <table>
              <thead><tr><th>Judul Materi</th><th>Tipe</th><th>Kursus</th><th>Urutan</th><th>Aksi</th></tr></thead>
              <tbody>
              @forelse($recent_courses as $course)
                @foreach($course->lessons as $lesson)
                <tr data-type="{{ $lesson->type }}">
                  <td><strong>{{ $lesson->title }}</strong></td>
                  <td>
                    <span class="badge {{ $lesson->type === 'video' ? 'badge-red' : 'badge-blue' }}">
                      {{ $lesson->type === 'video' ? '🎬 Video' : '📄 PDF' }}
                    </span>
                  </td>
                  <td>{{ $course->title }}</td>
                  <td class="text-sm">Lesson {{ $lesson->order }}</td>
                  <td>
                    <div class="flex gap-8">
                      <button class="btn btn-outline btn-sm" onclick="openModal('modal-materi')">Edit</button>
                      <form method="POST" action="{{ route('admin.lessons.destroy', $lesson->id) }}" onsubmit="return confirm('Hapus materi ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                      </form>
                    </div>
                  </td>
                </tr>
                @endforeach
              @empty
              <tr><td colspan="5" style="text-align:center;color:var(--gray-400);">Belum ada materi.</td></tr>
              @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    {{-- ==================== QUIZ ==================== --}}
    <div id="page-quiz" class="page">
      <div class="topbar">
        <div class="topbar-title">Quiz &amp; Soal</div>
        <div class="topbar-actions">
          <button class="btn btn-primary" onclick="openModal('modal-quiz')">+ Buat Quiz</button>
        </div>
      </div>
      <div style="padding:2rem;">
        <div class="card">
          <div class="table-wrap">
            <table>
              <thead><tr><th>Quiz</th><th>Kursus</th><th>Soal</th><th>Nilai Lulus</th><th>Aksi</th></tr></thead>
              <tbody>
              @forelse($recent_courses as $course)
                @foreach($course->quizzes as $quiz)
                <tr>
                  <td><strong>{{ $quiz->title }}</strong></td>
                  <td class="text-sm">{{ $course->title }}</td>
                  <td>{{ $quiz->questions->count() }}</td>
                  <td class="font-mono text-sm">{{ $quiz->passing_score }}</td>
                  <td>
                    <div class="flex gap-8">
                      <a href="{{ route('admin.quizzes.questions.index', $quiz->id) }}" class="btn btn-outline btn-sm">Kelola Soal</a>
                      <a href="{{ route('admin.quizzes.grade.index', $quiz->id) }}" class="btn btn-outline btn-sm" style="color:var(--green-600);">Nilai Essay</a>
                      <button class="btn btn-outline btn-sm" onclick="openModal('modal-quiz')">Edit</button>
                      <form method="POST" action="{{ route('admin.quizzes.destroy', $quiz->id) }}" onsubmit="return confirm('Hapus quiz ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                      </form>
                    </div>
                  </td>
                </tr>
                @endforeach
              @empty
              <tr><td colspan="5" style="text-align:center;color:var(--gray-400);">Belum ada quiz.</td></tr>
              @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    @include('admin.modal-materi')
    @include('admin.modal-quiz')
    @include('admin.modal-course')
    @include('admin.modal-enroll')
    @include('admin.modal-cert')
    @if(auth()->user()->role === 'admin')
    @include('admin.modal-user')
    @endif

    

    {{-- ==================== GRADING ==================== --}}
    <div id="page-grading" class="page">
      <div class="topbar">
        <div class="topbar-title">Auto Grading</div>
        <div class="topbar-actions">
          <button class="btn btn-primary">&#9654; Jalankan Auto Grade</button>
        </div>
      </div>
      <div style="padding:2rem;">
        <div class="stats-grid" style="grid-template-columns:repeat(3,1fr);">
          <div class="stat-card">
            <div class="stat-label">Total Submissions</div>
            <div class="stat-value">{{ number_format($stats['quiz_submissions']) }}</div>
          </div>
          <div class="stat-card">
            <div class="stat-label">Rata-rata Nilai</div>
            <div class="stat-value" style="color:var(--green-600);">{{ $quiz_stats['average_score'] }}</div>
          </div>
          <div class="stat-card">
            <div class="stat-label">Pass Rate</div>
            <div class="stat-value" style="color:var(--green-600);">{{ $quiz_stats['pass_rate'] }}</div>
          </div>
        </div>
        <div class="card">
          <div class="card-header"><span class="card-title">Hasil Grading Terbaru</span></div>
          <div class="card-body">
            @if($stats['quiz_submissions'] === 0)
            <div style="color:var(--gray-400);font-size:13px;">Belum ada quiz submission.</div>
            @else
            <table style="width:100%; table-layout:fixed;">
              <colgroup>
                <col style="width:18%">
                <col style="width:22%">
                <col style="width:22%">
                <col style="width:8%">
                <col style="width:10%">
                <col style="width:20%">
              </colgroup>
              <thead>
                <tr>
                  <th style="padding:10px 12px; text-align:left; font-size:11px; font-weight:600; color:var(--gray-400); text-transform:uppercase; letter-spacing:0.05em; border-bottom:1px solid var(--gray-200); background:var(--gray-50);">Siswa</th>
                  <th style="padding:10px 12px; text-align:left; font-size:11px; font-weight:600; color:var(--gray-400); text-transform:uppercase; letter-spacing:0.05em; border-bottom:1px solid var(--gray-200); background:var(--gray-50);">Quiz</th>
                  <th style="padding:10px 12px; text-align:left; font-size:11px; font-weight:600; color:var(--gray-400); text-transform:uppercase; letter-spacing:0.05em; border-bottom:1px solid var(--gray-200); background:var(--gray-50);">Course</th>
                  <th style="padding:10px 12px; text-align:center; font-size:11px; font-weight:600; color:var(--gray-400); text-transform:uppercase; letter-spacing:0.05em; border-bottom:1px solid var(--gray-200); background:var(--gray-50);">Nilai</th>
                  <th style="padding:10px 12px; text-align:center; font-size:11px; font-weight:600; color:var(--gray-400); text-transform:uppercase; letter-spacing:0.05em; border-bottom:1px solid var(--gray-200); background:var(--gray-50);">Status</th>
                  <th style="padding:10px 12px; text-align:left; font-size:11px; font-weight:600; color:var(--gray-400); text-transform:uppercase; letter-spacing:0.05em; border-bottom:1px solid var(--gray-200); background:var(--gray-50);">Tanggal</th>
                </tr>
              </thead>
              <tbody>
                @foreach($recent_attempts as $att)
                <tr>
                  <td style="padding:12px 12px; font-size:13px; border-bottom:1px solid var(--gray-100); vertical-align:middle; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">{{ $att->user->name ?? '—' }}</td>
                  <td style="padding:12px 12px; font-size:13px; border-bottom:1px solid var(--gray-100); vertical-align:middle; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">{{ $att->quiz->title ?? '—' }}</td>
                  <td style="padding:12px 12px; font-size:13px; border-bottom:1px solid var(--gray-100); vertical-align:middle; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; color:var(--gray-500);">{{ $att->quiz->course->title ?? '—' }}</td>
                  <td style="padding:12px 12px; font-size:13px; border-bottom:1px solid var(--gray-100); vertical-align:middle; text-align:center; font-family:monospace;">{{ $att->score }}</td>
                  <td style="padding:12px 12px; border-bottom:1px solid var(--gray-100); vertical-align:middle; text-align:center;"><span style="font-size:11px; font-weight:600; padding:2px 8px; border-radius:999px; background:{{ $att->passed ? '#DDF2DC' : '#FBDFD9' }}; color:{{ $att->passed ? '#3E8B45' : '#C05545' }}">{{ $att->passed ? 'Lulus' : 'Tidak' }}</span></td>
                  <td style="padding:12px 12px; font-size:12px; border-bottom:1px solid var(--gray-100); vertical-align:middle; color:var(--gray-400); overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">{{ $att->created_at->format('d M Y H:i') }}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
            @endif
          </div>
        </div>
      </div>
    </div>

    {{-- ==================== SERTIFIKAT ==================== --}}
    <div id="page-sertifikat" class="page">
      <div class="topbar">
        <div class="topbar-title">Sertifikat</div>
        <div class="topbar-actions">
          <button class="btn btn-primary" onclick="openModal('modal-cert')">+ Generate Sertifikat</button>
        </div>
      </div>
      <div style="padding:2rem;">
        <div class="stats-grid" style="grid-template-columns:repeat(3,1fr);">
          <div class="stat-card">
            <div class="stat-label">Total Sertifikat</div>
            <div class="stat-value">{{ number_format($stats['certificates']) }}</div>
          </div>
          <div class="stat-card">
            <div class="stat-label">Bulan Ini</div>
            <div class="stat-value" style="color:var(--purple-600);">
              {{ \App\Models\Certificate::whereMonth('issued_at', now()->month)->count() }}
            </div>
          </div>
          <div class="stat-card">
            <div class="stat-label">Terbaru</div>
            <div class="stat-value" style="color:var(--purple-600);font-size:13px;">
              @if($recent_certificates->count())
                {{ $recent_certificates->first()->user->name ?? '-' }}
              @else
                -
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- ==================== FORUM ==================== --}}
    <div id="page-forum" class="page">
      <div class="topbar">
        <div class="topbar-title">Diskusi Forum</div>
      </div>
      <div style="padding:1.25rem;" x-data="adminChat()" x-init="init()">
        <div style="display:grid; grid-template-columns:240px 1fr; gap:1rem; height:520px;">
          {{-- Left: Daftar Course --}}
          <div class="card" style="overflow-y:auto; margin:0;">
            <div class="card-header"><span class="card-title">Course</span></div>
            <div class="card-body" style="padding:0;">
              <template x-for="c in courses" :key="c.id">
                <div @click="selectCourse(c.id)"
                     style="padding:10px 14px; cursor:pointer; border-bottom:1px solid var(--gray-100); font-size:13px; display:flex; align-items:center; gap:8px;"
                     :style="selected === c.id ? 'background:var(--blue-50); color:var(--blue-600); font-weight:600;' : ''">
                  <span class="material-symbols-outlined" style="font-size:16px;">forum</span>
                  <span x-text="c.title"></span>
                </div>
              </template>
            </div>
          </div>

          {{-- Right: Chat Area --}}
          <div class="card" style="margin:0; display:flex; flex-direction:column;">
            <div style="flex:1; overflow-y:auto; padding:14px;" x-ref="chatbox">
              <template x-for="msg in messages" :key="msg.id">
                <div style="display:flex; gap:10px; margin-bottom:12px; flex-direction:row;"
                     :style="msg.is_mine ? 'flex-direction:row-reverse' : ''">
                  <div style="width:28px; height:28px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:10px; font-weight:700; flex-shrink:0; margin-top:4px;"
                       :style="'background:' + (msg.is_mine ? '#DCEBFA' : '#F0EAE4') + '; color:' + (msg.is_mine ? '#1E40AF' : '#6b5f52')"
                       x-text="(msg.user?.name || '?')[0].toUpperCase()"></div>
                  <div style="max-width:80%;">
                    <div style="display:flex; align-items:center; gap:4px; margin-bottom:2px; flex-wrap:wrap;">
                      <span style="font-size:11px; font-weight:600; color:#2C4A5E" x-text="msg.user?.name || '-'"></span>
                      <span x-show="msg.user?.role === 'admin' || msg.user?.role === 'instructor'"
                            style="font-size:9px; font-weight:700; padding:1px 6px; border-radius:999px;"
                            :style="'background:' + (msg.user?.role === 'admin' ? '#FEF2F2' : '#FBF0D2') + '; color:' + (msg.user?.role === 'admin' ? '#991B1B' : '#B8860B')"
                            x-text="msg.user?.role === 'admin' ? 'Admin' : 'Instructor'"></span>
                      <span style="font-size:10px; color:#8a7d70" x-text="timeAgo(msg.created_at)"></span>
                    </div>
                    <div style="border-radius:16px; padding:8px 14px; font-size:13px; line-height:1.5;"
                         :style="msg.is_mine ? 'background:#DCEBFA; color:#1E405E' : 'background:#F5F2EF; color:#2C4A5E'">
                      <p x-show="msg.title" style="font-weight:700; font-size:11px; margin:0 0 2px;" x-text="msg.title"></p>
                      <p style="margin:0;" x-text="msg.body"></p>
                    </div>
                    <button x-show="msg.can_delete" @click="deleteMsg(msg.id)"
                            style="font-size:10px; color:#f87171; border:none; background:none; cursor:pointer; padding:0; margin-top:2px;">Hapus</button>
                  </div>
                </div>
              </template>
              <div x-show="messages.length === 0" style="text-align:center; color:var(--gray-400); font-size:13px; padding:40px 0;">
                Pilih course di sebelah kiri untuk mulai diskusi.
              </div>
            </div>

            <div style="border-top:1px solid var(--gray-100); padding:10px 14px; display:flex; gap:8px;">
              <input type="text" x-model="text" @keydown.enter="send()"
                     class="form-control" style="flex:1; font-size:13px; padding:8px 12px;"
                     placeholder="Ketik pesan..." x-bind:disabled="!selected">
              <button @click="send()" :disabled="!text.trim() || !selected"
                      class="btn btn-primary btn-sm" style="padding:8px 16px;">
                <span class="material-symbols-outlined" style="font-size:16px;vertical-align:middle">send</span> Kirim
              </button>
            </div>
          </div>
        </div>
      </div>

      <script>
      function adminChat() {
        return {
          courses: @json($forum_courses->map(fn($c) => ['id' => $c->id, 'title' => $c->title])),
          selected: null,
          messages: [],
          text: '',
          lastFetch: null,
          pollTimer: null,
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
                    m.can_delete = {{ auth()->user()->role === 'admin' ? 'true' : 'false' }};
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
    </div>

    {{-- ==================== PROGRESS ==================== --}}
    <div id="page-progress" class="page">
      <div class="topbar">
        <div class="topbar-title">Progress Tracking</div>
      </div>
      <div style="padding:2rem;">
        <div class="card">
          <div class="table-wrap">
            <table>
              <thead><tr><th>Siswa</th><th>Kursus</th><th>Progress</th><th>Status</th><th>Terakhir</th></tr></thead>
              <tbody>
              @forelse($recent_progress as $e)
                <tr>
                  <td><strong>{{ $e->user->name ?? '-' }}</strong></td>
                  <td class="text-sm">{{ $e->course->title ?? '-' }}</td>
                  <td>
                    <div style="display:flex;align-items:center;gap:8px;">
                      <div style="flex:1;height:6px;background:#e5e7eb;border-radius:99px;overflow:hidden;">
                        <div style="width:{{ $e->progress_percentage }}%;height:100%;background:#5D9EC7;border-radius:99px;"></div>
                      </div>
                      <span class="text-xs font-mono">{{ $e->progress_percentage }}%</span>
                    </div>
                  </td>
                  <td><span class="badge badge-{{ $e->status === 'active' ? 'success' : 'muted' }}">{{ $e->status ?? 'active' }}</span></td>
                  <td class="text-sm">{{ $e->updated_at->format('d M Y') }}</td>
                </tr>
              @empty
                <tr><td colspan="5" style="text-align:center;color:var(--gray-400);">Belum ada data progress.</td></tr>
              @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    @if(auth()->user()->role === 'admin')
    {{-- ==================== AUTH / USERS ==================== --}}
    <div id="page-auth" class="page">
      <div class="topbar">
        <div class="topbar-title">Users &amp; Roles</div>
        <div class="topbar-actions">
          <button class="btn btn-primary" onclick="openModal('modal-user')">+ Tambah User</button>
        </div>
      </div>
      <div style="padding:2rem;">
        <div class="card">
          <div class="table-wrap">
            <table>
              <thead><tr><th>Nama</th><th>Email</th><th>Role</th><th>Bergabung</th><th>Aksi</th></tr></thead>
              <tbody>
              @php $users = \App\Models\User::latest()->get(); @endphp
              @forelse($users as $user)
                <tr>
                  <td><strong>{{ $user->name }}</strong></td>
                  <td class="text-sm">{{ $user->email }}</td>
                  <td><span class="badge badge-{{ $user->role === 'admin' ? 'primary' : ($user->role === 'instructor' ? 'warning' : 'muted') }}">{{ $user->role }}</span></td>
                  <td class="text-sm">{{ $user->created_at->format('d M Y') }}</td>
                  <td>
                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Hapus user ini?')">
                      @csrf @method('DELETE')
                      <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                  </td>
                </tr>
              @empty
                <tr><td colspan="5" style="text-align:center;color:var(--gray-400);">Belum ada user.</td></tr>
              @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    @endif

    {{-- ==================== PENGATURAN AKUN ==================== --}}
    <div id="page-settings" class="page">
      <div class="topbar">
        <div class="topbar-title">Pengaturan Akun</div>
      </div>
      <div style="padding:2rem;max-width:640px;">
        @if (session('success'))
          <div style="background:#DDF2DC;color:#3E8B45;padding:14px 20px;border-radius:14px;margin-bottom:20px;font-size:14px;font-weight:600;display:flex;align-items:center;gap:8px;">
            <span class="material-symbols-outlined" style="font-size:18px;">check_circle</span> {{ session('success') }}
          </div>
        @endif
        @if ($errors && $errors->any())
          <div style="background:#FDE8E8;color:#C0392B;padding:14px 20px;border-radius:14px;margin-bottom:20px;font-size:13px;display:flex;gap:8px;">
            <span class="material-symbols-outlined" style="font-size:18px;flex-shrink:0;">error</span>
            <ul style="margin:0;padding-left:16px;">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif
        <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          @php $u = auth()->user(); @endphp

          {{-- Foto Profil --}}
          <div class="card" style="margin-bottom:20px;border-radius:16px;box-shadow:0 1px 4px rgba(0,0,0,0.04);">
            <div class="card-header" style="padding:18px 24px;">
              <span class="card-title" style="display:flex;align-items:center;gap:8px;font-size:15px;">
                <span class="material-symbols-outlined" style="font-size:18px;color:#5D9EC7;">photo_camera</span> Foto Profil
              </span>
            </div>
            <div class="card-body" style="padding:24px;display:flex;align-items:center;gap:20px;flex-wrap:wrap;">
              <div style="position:relative;width:80px;height:80px;flex-shrink:0;">
                <img id="adminPhotoPreview" src="{{ $u->photo_url ?? '' }}" onerror="this.style.display='none'"
                     style="width:80px;height:80px;border-radius:50%;object-fit:cover;border:3px solid #fff;box-shadow:0 2px 8px rgba(0,0,0,0.1);{{ $u->photo_url ? '' : 'display:none' }}">
                <div id="adminPhotoFallback"
                     style="width:80px;height:80px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;color:#fff;background:linear-gradient(135deg,#5D9EC7,#2C4A5E);font-size:28px;{{ $u->photo_url ? 'display:none' : '' }}">{{ $u->initials }}</div>
              </div>
              <div>
                <label for="adminAvatarInput" style="display:inline-flex;align-items:center;gap:6px;padding:8px 18px;border-radius:10px;font-size:13px;font-weight:600;cursor:pointer;background:#5D9EC7;color:#fff;border:none;transition:opacity .15s;" onmouseover="this.style.opacity='.9'" onmouseout="this.style.opacity='1'">
                  <span class="material-symbols-outlined" style="font-size:16px;">upload</span> Upload Foto
                </label>
                <input id="adminAvatarInput" type="file" name="avatar" accept="image/*" hidden
                       onchange="var f=this.files[0];if(f){var r=new FileReader();r.onload=function(e){var p=document.getElementById('adminPhotoPreview');p.src=e.target.result;p.style.display='block';p.onerror=null;document.getElementById('adminPhotoFallback').style.display='none'};r.readAsDataURL(f)}">
                <p style="margin:6px 0 0;font-size:11px;color:#8a7d70;">Format: JPG, PNG. Maks 2MB</p>
              </div>
            </div>
          </div>

          {{-- Data Diri --}}
          <div class="card" style="margin-bottom:20px;border-radius:16px;box-shadow:0 1px 4px rgba(0,0,0,0.04);">
            <div class="card-header" style="padding:18px 24px;">
              <span class="card-title" style="display:flex;align-items:center;gap:8px;font-size:15px;">
                <span class="material-symbols-outlined" style="font-size:18px;color:#5D9EC7;">person</span> Data Diri
              </span>
            </div>
            <div class="card-body" style="padding:24px;display:flex;flex-direction:column;gap:16px;">
              <div>
                <label style="display:block;font-size:12px;font-weight:700;color:#2C4A5E;margin-bottom:6px;text-transform:uppercase;letter-spacing:.04em;">Nama Lengkap</label>
                <input type="text" name="name" value="{{ $u->name }}"
                       style="width:100%;padding:11px 16px;border-radius:12px;border:1.5px solid #E4DED6;font-size:14px;outline:none;background:#f5f0eb;transition:border-color .2s,box-shadow .2s;box-sizing:border-box;"
                       onfocus="this.style.borderColor='#5D9EC7';this.style.boxShadow='0 0 0 3px rgba(93,158,199,0.15)';this.style.background='#fff'"
                       onblur="this.style.borderColor='#E4DED6';this.style.boxShadow='none';this.style.background='#f5f0eb'">
              </div>
              <div>
                <label style="display:block;font-size:12px;font-weight:700;color:#2C4A5E;margin-bottom:6px;text-transform:uppercase;letter-spacing:.04em;">Email</label>
                <input type="email" name="email" value="{{ $u->email }}"
                       style="width:100%;padding:11px 16px;border-radius:12px;border:1.5px solid #E4DED6;font-size:14px;outline:none;background:#f5f0eb;transition:border-color .2s,box-shadow .2s;box-sizing:border-box;"
                       onfocus="this.style.borderColor='#5D9EC7';this.style.boxShadow='0 0 0 3px rgba(93,158,199,0.15)';this.style.background='#fff'"
                       onblur="this.style.borderColor='#E4DED6';this.style.boxShadow='none';this.style.background='#f5f0eb'">
              </div>
            </div>
          </div>

          {{-- Ganti Password --}}
          <div class="card" style="margin-bottom:24px;border-radius:16px;box-shadow:0 1px 4px rgba(0,0,0,0.04);">
            <div class="card-header" style="padding:18px 24px;">
              <span class="card-title" style="display:flex;align-items:center;gap:8px;font-size:15px;">
                <span class="material-symbols-outlined" style="font-size:18px;color:#5D9EC7;">lock</span> Ganti Password
              </span>
            </div>
            <div class="card-body" style="padding:24px;display:flex;flex-direction:column;gap:14px;">
              <div>
                <label style="display:block;font-size:12px;font-weight:700;color:#2C4A5E;margin-bottom:6px;text-transform:uppercase;letter-spacing:.04em;">Password Saat Ini</label>
                <input type="password" name="current_password"
                       style="width:100%;padding:11px 16px;border-radius:12px;border:1.5px solid #E4DED6;font-size:14px;outline:none;background:#f5f0eb;transition:border-color .2s,box-shadow .2s;box-sizing:border-box;"
                       onfocus="this.style.borderColor='#5D9EC7';this.style.boxShadow='0 0 0 3px rgba(93,158,199,0.15)';this.style.background='#fff'"
                       onblur="this.style.borderColor='#E4DED6';this.style.boxShadow='none';this.style.background='#f5f0eb'">
              </div>
              <div>
                <label style="display:block;font-size:12px;font-weight:700;color:#2C4A5E;margin-bottom:6px;text-transform:uppercase;letter-spacing:.04em;">Password Baru</label>
                <input type="password" name="new_password"
                       style="width:100%;padding:11px 16px;border-radius:12px;border:1.5px solid #E4DED6;font-size:14px;outline:none;background:#f5f0eb;transition:border-color .2s,box-shadow .2s;box-sizing:border-box;"
                       onfocus="this.style.borderColor='#5D9EC7';this.style.boxShadow='0 0 0 3px rgba(93,158,199,0.15)';this.style.background='#fff'"
                       onblur="this.style.borderColor='#E4DED6';this.style.boxShadow='none';this.style.background='#f5f0eb'">
              </div>
              <div>
                <label style="display:block;font-size:12px;font-weight:700;color:#2C4A5E;margin-bottom:6px;text-transform:uppercase;letter-spacing:.04em;">Konfirmasi Password Baru</label>
                <input type="password" name="new_password_confirmation"
                       style="width:100%;padding:11px 16px;border-radius:12px;border:1.5px solid #E4DED6;font-size:14px;outline:none;background:#f5f0eb;transition:border-color .2s,box-shadow .2s;box-sizing:border-box;"
                       onfocus="this.style.borderColor='#5D9EC7';this.style.boxShadow='0 0 0 3px rgba(93,158,199,0.15)';this.style.background='#fff'"
                       onblur="this.style.borderColor='#E4DED6';this.style.boxShadow='none';this.style.background='#f5f0eb'">
              </div>
            </div>
          </div>

          <button type="submit" style="display:inline-flex;align-items:center;gap:8px;padding:12px 32px;border-radius:12px;border:none;font-size:15px;font-weight:700;color:#fff;background:linear-gradient(135deg,#2C4A5E,#1a3040);cursor:pointer;transition:opacity .2s,transform .15s;box-shadow:0 2px 8px rgba(44,74,94,0.25);"
                  onmouseover="this.style.opacity='.92';this.style.transform='translateY(-1px)'"
                  onmouseout="this.style.opacity='1';this.style.transform='none'">
            <span class="material-symbols-outlined" style="font-size:18px;">save</span> Simpan Perubahan
          </button>
        </form>
      </div>
    </div>

  </div>{{-- /.main-content --}}
  </div>{{-- /.layout --}}
<script>
function openModal(id) {
    document.getElementById(id).style.display = 'flex';
}

function closeModal(id) {
    document.getElementById(id).style.display = 'none';
}

function filterCoursesByStatus() {
    const val = document.getElementById('filterStatusCourse').value;
    document.querySelectorAll('#page-courses table tbody tr').forEach(tr => {
        if (val === 'all') { tr.style.display = ''; return; }
        tr.style.display = tr.dataset.status === val ? '' : 'none';
    });
}

function filterMateriByType() {
    const val = document.getElementById('filterTypeMateri').value;
    document.querySelectorAll('#page-materi table tbody tr').forEach(tr => {
        if (val === 'all') { tr.style.display = ''; return; }
        tr.style.display = tr.dataset.type === val ? '' : 'none';
    });
}

function switchChartTab(btn, metric) {
    document.querySelectorAll('.chart-tab').forEach(t => t.classList.remove('active'));
    btn.classList.add('active');
    const chart = Chart.getChart('activityChart');
    if (chart) {
        chart.data.datasets[0].label = metric.charAt(0).toUpperCase() + metric.slice(1);
        chart.data.datasets[0].data = window.chartData[metric] ?? [];
        chart.update();
    }
}

function openEditCourse(id) {
    openModal('modal-course');
}

function switchPage(pageId, navItem) {
    document.querySelectorAll('.page').forEach(function (p) { p.classList.remove('active'); });
    document.querySelectorAll('.nav-item').forEach(function (n) { n.classList.remove('active'); });
    var page = document.getElementById('page-' + pageId);
    if (page) page.classList.add('active');
    if (navItem) navItem.classList.add('active');
}

document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.nav-item[data-page]').forEach(function (item) {
        item.addEventListener('click', function (e) {
            e.stopPropagation();
            var pageId = this.getAttribute('data-page');
            switchPage(pageId, this);
        });
    });

    window.chartData = {
        signups: {!! json_encode($chart_signups ?? [0,0,2,5,3,1,4], JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_AMP|JSON_HEX_QUOT) !!},
        enrollments: {!! json_encode($chart_enrollments ?? [0,0,2,5,3,1,4], JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_AMP|JSON_HEX_QUOT) !!},
        certificates: {!! json_encode($chart_certificates ?? [0,0,2,5,3,1,4], JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_AMP|JSON_HEX_QUOT) !!},
    };
    var ctx = document.getElementById('activityChart');
    if (ctx && typeof Chart !== 'undefined') {
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($chart_labels ?? ['Sen','Sel','Rab','Kam','Jum','Sab','Min'], JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_AMP|JSON_HEX_QUOT) !!},
                datasets: [{
                    label: 'Signups',
                    data: window.chartData.signups,
                    backgroundColor: 'rgba(93,158,199,0.7)',
                    borderRadius: 4,
                }]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true } }
            }
        });
    }
});
</script>
</body>
</html>