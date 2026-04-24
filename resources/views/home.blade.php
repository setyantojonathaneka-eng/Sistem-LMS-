<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>LearnPath</title>
    <link rel="icon" type="image/png" href="{{ asset('images/Logo LearnPath .png') }}" />
    @vite(['resources/css/home.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,1,0"
    />
  </head>
  <body>
    <div class="layout">

      <!-- ═══ SIDEBAR KIRI ═══ -->
      <aside class="sidebar" id="sidebar">
        <button class="toggle" type="button" id="toggleBtn" aria-label="Toggle sidebar">
          <span class="material-symbols-outlined">chevron_right</span>
        </button>

        <div class="inner">
          <div class="sidebar-header">
            <img src="{{ asset('images/Logo LearnPath .png') }}" class="logo" alt="LearnPath logo" />
            <span class="brand-name">LearnPath</span>
          </div>

          <div class="search-wrap">
            <span class="material-symbols-outlined search-icon">search</span>
            <input type="text" placeholder="Cari kursus..." class="search-input" />
          </div>

          <nav class="menu">
            <span class="menu-section-label">Menu</span>
            <button type="button" class="nav-btn active" data-label="Beranda">
              <span class="material-symbols-outlined">home</span>
              <span class="nav-label">Beranda</span>
            </button>
            <button type="button" class="nav-btn" data-label="Kursus">
              <span class="material-symbols-outlined">menu_book</span>
              <span class="nav-label">Kursus</span>
            </button>
            <button type="button" class="nav-btn" data-label="Riwayat">
              <span class="material-symbols-outlined">history</span>
              <span class="nav-label">Riwayat</span>
            </button>
            <span class="menu-section-label">Komunitas</span>
            <button type="button" class="nav-btn" data-label="Teman">
              <span class="material-symbols-outlined">group</span>
              <span class="nav-label">Teman</span>
              <span class="nav-badge">3</span>
            </button>
            <button type="button" class="nav-btn" data-label="Leaderboard">
              <span class="material-symbols-outlined">leaderboard</span>
              <span class="nav-label">Leaderboard</span>
            </button>
            <span class="menu-section-label">Lainnya</span>
            <button type="button" class="nav-btn" data-label="Pengaturan">
              <span class="material-symbols-outlined">settings</span>
              <span class="nav-label">Pengaturan</span>
            </button>
          </nav>

          <div class="sidebar-user">
            <div class="user-avatar">?</div>
            <div class="user-info">
              <p class="user-name">Tamu</p>
              <p class="user-sub">Login untuk mulai</p>
            </div>
          </div>
        </div>
      </aside>

      <!-- ═══ MAIN CONTENT ═══ -->
      <main class="main-content">

        <!-- Hero -->
        <div class="hero">
          <p class="hero-eyebrow">Selamat datang</p>
          <h1 class="hero-title">Invest in Your Learning</h1>
          <p class="hero-subtitle">Mulai atau lanjutkan perjalanan belajarmu hari ini.</p>
          <button class="btn-download">
            <span class="material-symbols-outlined">download</span>
            Download materi dari dosen
          </button>
        </div>

        <!-- Stats Row -->
        <div class="stats-row">
          <div class="stat-card">
            <span class="stat-label">Kursus aktif</span>
            <span class="stat-value">0</span>
            <span class="stat-sub">Login untuk melihat</span>
          </div>
          <div class="stat-card">
            <span class="stat-label">Progress belajar</span>
            <span class="stat-value">0%</span>
            <span class="stat-sub">Materi selesai</span>
          </div>
          <div class="stat-card">
            <span class="stat-label">Streak belajar</span>
            <span class="stat-value">—</span>
            <span class="stat-sub">Hari berturut-turut</span>
          </div>
          <div class="stat-card">
            <span class="stat-label">Poin XP</span>
            <span class="stat-value">—</span>
            <span class="stat-sub">Login untuk unlock</span>
          </div>
        </div>

        <!-- Lanjutkan Belajar -->
        <div class="section-header">
          <h2 class="section-title">Lanjutkan belajar</h2>
          <span class="section-hint">Login untuk melihat progress-mu</span>
        </div>
        <div class="continue-card">
          <div class="continue-icon">
            <span class="material-symbols-outlined">laptop_mac</span>
          </div>
          <div class="continue-body">
            <p class="continue-eyebrow">Sedang berjalan</p>
            <div class="progress-bar">
              <div class="progress-fill" style="width: 0%"></div>
            </div>
            <span class="progress-label">Modul 0 dari 0 · 0% selesai</span>
          </div>
          <button class="btn-continue">Lanjutkan</button>
        </div>

        <!-- Kursus Populer -->
        <div class="section-header">
          <h2 class="section-title">Kursus populer</h2>
          <a href="#" class="section-link">Lihat semua →</a>
        </div>
        <div class="course-grid">

          <div class="course-card">
            <div class="course-thumb thumb-blue">
              <span class="material-symbols-outlined thumb-icon">sports_esports</span>
            </div>
            <div class="course-body">
              <span class="course-tag tag-blue">Game Dev</span>
              <h3 class="course-title">Game Development</h3>
              <p class="course-desc">Belajar bikin game, bukan cuma main aja.</p>
              <div class="course-meta">
                <span><span class="material-symbols-outlined star-icon">star</span> 4.8</span>
                <span>24 modul</span>
                <span class="badge-free">Gratis</span>
              </div>
              <div class="course-progress-bar"><div class="course-progress-fill" style="width:0%"></div></div>
            </div>
          </div>

          <div class="course-card">
            <div class="course-thumb thumb-teal">
              <span class="material-symbols-outlined thumb-icon">cloud</span>
            </div>
            <div class="course-body">
              <span class="course-tag tag-teal">Cloud</span>
              <h3 class="course-title">Cloud Computing</h3>
              <p class="course-desc">Kelola server dan infrastruktur di cloud.</p>
              <div class="course-meta">
                <span><span class="material-symbols-outlined star-icon">star</span> 4.6</span>
                <span>18 modul</span>
                <span class="badge-free">Gratis</span>
              </div>
              <div class="course-progress-bar"><div class="course-progress-fill" style="width:0%"></div></div>
            </div>
          </div>

          <div class="course-card">
            <div class="course-thumb thumb-purple">
              <span class="material-symbols-outlined thumb-icon">psychology</span>
            </div>
            <div class="course-body">
              <span class="course-tag tag-purple">AI/ML</span>
              <h3 class="course-title">Machine Learning</h3>
              <p class="course-desc">Pahami konsep dan implementasi ML dari dasar.</p>
              <div class="course-meta">
                <span><span class="material-symbols-outlined star-icon">star</span> 4.9</span>
                <span>30 modul</span>
                <span class="badge-pro">Pro</span>
              </div>
              <div class="course-progress-bar"><div class="course-progress-fill" style="width:0%"></div></div>
            </div>
          </div>

          <div class="course-card">
            <div class="course-thumb thumb-amber">
              <span class="material-symbols-outlined thumb-icon">phone_android</span>
            </div>
            <div class="course-body">
              <span class="course-tag tag-blue">Mobile</span>
              <h3 class="course-title">Mobile App Dev</h3>
              <p class="course-desc">Build aplikasi Android & iOS dengan Flutter.</p>
              <div class="course-meta">
                <span><span class="material-symbols-outlined star-icon">star</span> 4.7</span>
                <span>22 modul</span>
                <span class="badge-free">Gratis</span>
              </div>
              <div class="course-progress-bar"><div class="course-progress-fill" style="width:0%"></div></div>
            </div>
          </div>

          <div class="course-card">
            <div class="course-thumb thumb-coral">
              <span class="material-symbols-outlined thumb-icon">security</span>
            </div>
            <div class="course-body">
              <span class="course-tag tag-teal">Security</span>
              <h3 class="course-title">Cybersecurity Dasar</h3>
              <p class="course-desc">Lindungi sistem dan data dari ancaman siber.</p>
              <div class="course-meta">
                <span><span class="material-symbols-outlined star-icon">star</span> 4.5</span>
                <span>16 modul</span>
                <span class="badge-free">Gratis</span>
              </div>
              <div class="course-progress-bar"><div class="course-progress-fill" style="width:0%"></div></div>
            </div>
          </div>

          <div class="course-card">
            <div class="course-thumb thumb-green">
              <span class="material-symbols-outlined thumb-icon">bar_chart</span>
            </div>
            <div class="course-body">
              <span class="course-tag tag-purple">Data</span>
              <h3 class="course-title">Data Science</h3>
              <p class="course-desc">Olah dan visualisasikan data jadi insight.</p>
              <div class="course-meta">
                <span><span class="material-symbols-outlined star-icon">star</span> 4.8</span>
                <span>28 modul</span>
                <span class="badge-pro">Pro</span>
              </div>
              <div class="course-progress-bar"><div class="course-progress-fill" style="width:0%"></div></div>
            </div>
          </div>

        </div>
      </main>

      <!-- ═══ SIDEBAR KANAN ═══ -->
      <aside class="sidebar-right">

        <!-- Login CTA -->
        <div class="right-card login-cta-card">
          <div class="login-avatar">
            <span class="material-symbols-outlined">account_circle</span>
          </div>
          <p class="login-desc">Login untuk melacak progress, melihat aktivitas teman, dan unlock semua fitur.</p>
          <a href="{{ url('/login') }}" class="btn-login">Masuk ke Akun</a>
        </div>

        <!-- Aktivitas Teman -->
        <div class="right-card">
          <div class="right-card-header">
            <span class="material-symbols-outlined">group</span>
            <h3>Aktivitas terbaru</h3>
          </div>
        </div>

        <!-- Track Progress -->
        <div class="right-card">
          <div class="right-card-header">
            <span class="material-symbols-outlined">monitoring</span>
            <h3>Track Progress</h3>
          </div>
        </div>

        <!-- Leaderboard Mini -->
        <div class="right-card">
          <div class="right-card-header">
            <span class="material-symbols-outlined">leaderboard</span>
            <h3>Top learner minggu ini</h3>
          </div>
        </div>

        <!-- Join Kelas -->
        <div class="right-card">
          <div class="right-card-header">
            <span class="material-symbols-outlined">school</span>
            <h3>Join kelas dari dosen</h3>
          </div>
          <p class="right-card-desc">Silakan masuk ke akun untuk bergabung ke kelas dosen</p>
        </div>

      </aside>
    </div>

    <script>
      const sidebar = document.getElementById('sidebar');
      const layout  = document.querySelector('.layout');
      const toggleBtn = document.getElementById('toggleBtn');

      toggleBtn.addEventListener('click', () => {
        sidebar.classList.toggle('open');
        layout.classList.toggle('sidebar-open');
      });

      document.querySelectorAll('.nav-btn').forEach(btn => {
        btn.addEventListener('click', () => {
          document.querySelectorAll('.nav-btn').forEach(b => b.classList.remove('active'));
          btn.classList.add('active');
        });
      });
    </script>
  </body>
</html>