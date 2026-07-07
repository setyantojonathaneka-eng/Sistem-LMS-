<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>LearnPath — Platform Belajar Online</title>
    <link rel="icon" type="image/png" href="{{ asset('images/Logo LearnPath .png') }}" />

    <!-- font: Arial, sans-serif -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,1,0" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --primary: #2C4A5E;
            --background: #F0EAE4;
            --card-blue: #3A7DEC;
            --box-dark: #5E68A8;
            --accent: #F7D070;
            --white: #FFFFFF;
            --text-muted: #6B7280;
            --border: #E4DED6;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: var(--white); color: var(--primary); line-height: 1.5; }
        a { text-decoration: none; color: inherit; }
        ul { list-style: none; }
        img { max-width: 100%; display: block; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; vertical-align: middle; }

        .container { max-width: 1200px; margin: 0 auto; padding: 0 24px; }

        /* Header */
        header {
            position: fixed; top: 0; left: 0; right: 0; z-index: 50;
            background: rgba(255,255,255,0.9); backdrop-filter: blur(8px);
            border-bottom: 1px solid var(--border);
        }
        .header-inner { display: flex; align-items: center; justify-content: space-between; height: 68px; }
        .logo { display: flex; align-items: center; gap: 8px; font-weight: 800; font-size: 18px; color: var(--primary); }
        .logo-icon { display: grid; place-items: center; width: 36px; height: 36px; border-radius: 10px; background: var(--primary); color: var(--white); }
        .logo-icon-img { width: 48px; height: 48px; border-radius: 10px; object-fit: contain; }
        nav.main-nav { display: flex; gap: 32px; font-size: 14px; font-weight: 500; color: var(--text-muted); }
        nav.main-nav a:hover { color: var(--primary); }
        .header-actions { display: flex; align-items: center; gap: 12px; }
        .btn-ghost { font-size: 14px; font-weight: 600; color: var(--primary); }
        .btn-primary {
            display: inline-flex; align-items: center; gap: 6px;
            background: var(--primary); color: var(--white);
            padding: 10px 20px; border-radius: 999px; font-size: 14px; font-weight: 600;
            border: none; cursor: pointer; transition: transform .2s;
        }
        .btn-primary:hover { transform: translateY(-2px); }
        .btn-outline {
            display: inline-flex; align-items: center; gap: 8px;
            border: 1px solid var(--border); background: var(--white);
            padding: 12px 22px; border-radius: 999px; font-size: 14px; font-weight: 600; color: var(--primary);
        }
        .menu-toggle { display: none; background: none; border: none; cursor: pointer; color: var(--primary); }
        .mobile-menu { display: none; flex-direction: column; gap: 14px; padding: 16px 24px 20px; border-top: 1px solid var(--border); background: var(--white); }
        .mobile-menu.show { display: flex; }

        @media (max-width: 860px) {
            nav.main-nav, .header-actions { display: none; }
            .menu-toggle { display: block; }
        }

        /* Hero */
        .hero {
            position: relative; min-height: 520px; display: flex; align-items: center;
            padding: 100px 0 40px; overflow: hidden;
        }
        .hero-bg {
            position: absolute; inset: 0; overflow: hidden;
        }
        .hero-bg video {
            width: 100%; height: 100%; object-fit: cover; object-position: top center;
        }
        .hero-overlay {
            position: absolute; inset: 0;
            background: linear-gradient(100deg, rgba(18,28,36,0.88) 0%, rgba(18,28,36,0.65) 45%, rgba(18,28,36,0.15) 100%);
        }
        .hero .container {
            position: relative; z-index: 2; width: 100%;
        }
        .hero-content { max-width: 620px; }

        .badge {
            display: inline-flex; align-items: center; gap: 8px;
            border: 1px solid rgba(255,255,255,0.2); background: rgba(255,255,255,0.08);
            padding: 7px 16px; border-radius: 999px; font-size: 12px; font-weight: 600; color: #fff;
            backdrop-filter: blur(4px);
        }
        .badge .material-symbols-outlined { color: var(--accent) !important; }
        .hero h1 { margin-top: 22px; font-size: clamp(2.2rem, 4vw, 3.4rem); font-weight: 800; line-height: 1.1; color: #fff; }
        .highlight { background: linear-gradient(120deg, var(--accent) 0%, var(--accent) 100%); background-repeat: no-repeat; background-size: 100% 0.35em; background-position: 0 88%; }
        .hero p.lead { margin-top: 22px; max-width: 520px; font-size: 17px; color: rgba(255,255,255,0.75); }
        .hero-cta { margin-top: 28px; display: flex; flex-wrap: wrap; gap: 14px; }
        .hero-cta .btn-primary { background: var(--accent); color: var(--primary); }
        .hero-cta .btn-outline {
            display: inline-flex; align-items: center; gap: 8px;
            border: 1px solid rgba(255,255,255,0.3); background: rgba(255,255,255,0.06);
            padding: 12px 22px; border-radius: 999px; font-size: 14px; font-weight: 600; color: #fff;
            backdrop-filter: blur(4px);
        }
        .hero-cta .btn-outline .material-symbols-outlined { color: var(--accent) !important; }
        .rating { margin-top: 30px; display: flex; align-items: center; gap: 14px; font-size: 14px; color: rgba(255,255,255,0.85); }
        .stars { color: var(--accent); }

        .float-card {
            position: absolute; border-radius: 16px; padding: 12px 16px;
            display: flex; align-items: center; gap: 10px;
            box-shadow: 0 12px 40px rgba(0,0,0,0.25); font-size: 13px;
            z-index: 3;
        }
        .float-card.bottom {
            bottom: 40px; right: 40px;
            background: rgba(255,255,255,0.95); backdrop-filter: blur(8px);
            border: 1px solid rgba(255,255,255,0.3);
        }
        .float-card.top {
            top: 120px; right: 40px;
            background: rgba(44,74,94,0.92); backdrop-filter: blur(8px);
            color: #fff; flex-direction: column; align-items: flex-start;
            border: 1px solid rgba(255,255,255,0.1);
        }
        .icon-circle { display: grid; place-items: center; width: 36px; height: 36px; border-radius: 10px; background: #d1fae5; color: #10b981; }

        @media (max-width: 860px) {
            .hero { min-height: 460px; padding: 80px 0 30px; }
            .float-card.bottom { bottom: 20px; right: 20px; }
            .float-card.top { top: 90px; right: 20px; }
        }
        @media (max-width: 600px) {
            .hero { min-height: 420px; padding: 80px 0 20px; }
            .float-card.top { display: none; }
            .float-card.bottom { bottom: 16px; right: 16px; padding: 10px 14px; font-size: 12px; }
        }

        /* Section shared */
        section { padding: 80px 0; }
        .eyebrow { font-size: 13px; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase; color: var(--card-blue); }
        .section-title { margin-top: 10px; font-size: clamp(1.8rem, 3vw, 2.4rem); font-weight: 800; }
        .section-head { display: flex; flex-wrap: wrap; justify-content: space-between; align-items: flex-end; gap: 16px; }

        /* Marquee */
        .marquee-wrap { background: var(--background); border-top: 1px solid var(--border); border-bottom: 1px solid var(--border); padding: 20px 0; overflow: hidden; }
        .marquee-track { display: flex; gap: 60px; white-space: nowrap; width: max-content; animation: marquee 26s linear infinite; }
        .marquee-track span { font-weight: 600; font-size: 17px; color: #A79E92; }
        @keyframes marquee { from { transform: translateX(0); } to { transform: translateX(-50%); } }

        /* Stats */
        .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px; text-align: center; }
        @media (max-width: 700px) { .stats-grid { grid-template-columns: repeat(2, 1fr); } }
        .stats-grid .num { font-size: clamp(2rem, 4vw, 2.6rem); font-weight: 800; }
        .stats-grid .label { margin-top: 6px; font-size: 14px; color: var(--text-muted); }

        /* Features */
        .features-grid { margin-top: 44px; display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
        @media (max-width: 900px) { .features-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 600px) { .features-grid { grid-template-columns: 1fr; } }
        .feature-card { border: 1px solid var(--border); border-radius: 18px; padding: 26px; transition: transform .2s, box-shadow .2s; }
        .feature-card:hover { transform: translateY(-4px); box-shadow: 0 14px 30px rgba(44,74,94,0.08); }
        .feature-icon { display: grid; place-items: center; width: 48px; height: 48px; border-radius: 14px; background: #EAF1FB; color: var(--card-blue); }
        .feature-card h3 { margin-top: 18px; font-size: 17px; font-weight: 700; }
        .feature-card p { margin-top: 8px; font-size: 14px; color: var(--text-muted); }

        /* Courses */
        .courses-section { background: var(--background); border-top: 1px solid var(--border); border-bottom: 1px solid var(--border); }
        .courses-grid { margin-top: 44px; display: grid; grid-template-columns: repeat(3, 1fr); gap: 22px; }
        @media (max-width: 900px) { .courses-grid { grid-template-columns: 1fr; } }
        .course-card { background: var(--white); border: 1px solid var(--border); border-radius: 18px; overflow: hidden; transition: transform .2s; }
        .course-card:hover { transform: translateY(-4px); }
        .course-thumb { aspect-ratio: 16/10; background: linear-gradient(135deg, #dfe8f2, #eee4d8); position: relative; }
        .course-tag { position: absolute; top: 12px; left: 12px; background: var(--white); padding: 4px 12px; border-radius: 999px; font-size: 12px; font-weight: 600; }
        .course-body { padding: 20px; }
        .course-meta { display: flex; gap: 12px; font-size: 12px; color: var(--text-muted); align-items: center; }
        .course-level { background: var(--background); padding: 3px 10px; border-radius: 6px; font-weight: 500; }
        .course-body h3 { margin-top: 12px; font-size: 16px; font-weight: 700; }
        .course-footer { margin-top: 18px; display: flex; justify-content: space-between; align-items: center; font-size: 14px; }
        .course-price { font-weight: 700; }

        /* Instructor split */
        .split { display: grid; grid-template-columns: 1fr 1fr; gap: 48px; align-items: center; }
        @media (max-width: 860px) { .split { grid-template-columns: 1fr; } }
        .split-visual { border-radius: 28px; border: 1px solid var(--border); background: linear-gradient(135deg, #eee4d8, #dfe8f2); aspect-ratio: 4/3; }
        .split ul { margin-top: 20px; display: flex; flex-direction: column; gap: 12px; }
        .split li { display: flex; align-items: flex-start; gap: 10px; font-size: 14px; }
        .split li .material-symbols-outlined { color: #10b981; font-size: 20px; margin-top: 1px; }
        .split p.lead { margin-top: 16px; color: var(--text-muted); font-size: 15px; }

        /* Stories */
        .stories-section { background: var(--primary); color: var(--white); }
        .stories-section .eyebrow { color: var(--accent); }
        .stories-grid { margin-top: 44px; display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
        @media (max-width: 900px) { .stories-grid { grid-template-columns: 1fr; } }
        .story-card { background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1); border-radius: 18px; padding: 24px; }
        .story-card .material-symbols-outlined.quote { color: var(--accent); font-size: 28px; }
        .story-card p.text { margin-top: 14px; font-size: 14px; line-height: 1.6; color: rgba(255,255,255,0.9); }
        .story-person { margin-top: 20px; display: flex; align-items: center; gap: 12px; }
        .story-avatar { width: 44px; height: 44px; border-radius: 50%; background: rgba(255,255,255,0.15); border: 2px solid rgba(247,208,112,0.5); }
        .story-name { font-size: 13px; font-weight: 600; }
        .story-role { font-size: 12px; color: rgba(255,255,255,0.6); }

        /* Pricing */
        .pricing-head { max-width: 560px; margin: 0 auto; text-align: center; }
        .pricing-grid { margin-top: 44px; display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; align-items: stretch; }
        @media (max-width: 900px) { .pricing-grid { grid-template-columns: 1fr; } }
        .plan-card { border: 1px solid var(--border); border-radius: 18px; padding: 30px; display: flex; flex-direction: column; }
        .plan-card.highlight { border-color: var(--accent); box-shadow: 0 20px 40px rgba(247,208,112,0.2); transform: translateY(-10px); }
        .plan-badge { align-self: flex-start; background: var(--accent); color: var(--primary); font-size: 11px; font-weight: 700; padding: 5px 12px; border-radius: 999px; margin-bottom: 14px; }
        .plan-card h3 { font-size: 19px; font-weight: 700; }
        .plan-card .plan-desc { margin-top: 4px; font-size: 13px; color: var(--text-muted); }
        .plan-price { margin-top: 18px; display: flex; align-items: baseline; gap: 6px; }
        .plan-price .amount { font-size: 34px; font-weight: 800; }
        .plan-price .period { font-size: 13px; color: var(--text-muted); }
        .plan-card ul { margin-top: 20px; flex: 1; display: flex; flex-direction: column; gap: 10px; }
        .plan-card li { display: flex; align-items: flex-start; gap: 8px; font-size: 13px; }
        .plan-card li .material-symbols-outlined { color: #10b981; font-size: 18px; }
        .plan-cta { margin-top: 24px; text-align: center; padding: 12px; border-radius: 999px; font-size: 14px; font-weight: 600; }
        .plan-cta.filled { background: var(--primary); color: var(--white); }
        .plan-cta.outline { border: 1px solid var(--border); color: var(--primary); }

        /* CTA */
        .cta-box { position: relative; background: var(--primary); color: var(--white); border-radius: 28px; padding: 70px 40px; text-align: center; overflow: hidden; }
        .cta-blob { position: absolute; top: -60px; right: -40px; width: 260px; height: 260px; border-radius: 50%; background: rgba(247,208,112,0.25); filter: blur(50px); }
        .cta-box h2 { position: relative; font-size: clamp(1.8rem, 4vw, 2.6rem); font-weight: 800; }
        .cta-box p { position: relative; margin-top: 14px; color: rgba(255,255,255,0.8); max-width: 480px; margin-inline: auto; }
        .btn-accent { position: relative; margin-top: 26px; display: inline-flex; align-items: center; gap: 8px; background: var(--accent); color: var(--primary); font-weight: 700; padding: 14px 28px; border-radius: 999px; font-size: 14px; }

        /* Footer */
        footer { background: var(--background); border-top: 1px solid var(--border); padding: 60px 0 0; }
        .footer-grid { display: grid; grid-template-columns: 1.4fr 1fr 1fr 1fr; gap: 40px; }
        @media (max-width: 700px) { .footer-grid { grid-template-columns: 1fr 1fr; } }
        .footer-grid h4 { font-size: 14px; font-weight: 700; }
        .footer-grid ul { margin-top: 14px; display: flex; flex-direction: column; gap: 10px; font-size: 13px; color: var(--text-muted); }
        .footer-desc { margin-top: 14px; font-size: 13px; color: var(--text-muted); max-width: 260px; }
        .footer-bottom { margin-top: 40px; border-top: 1px solid var(--border); padding: 20px 0; display: flex; flex-wrap: wrap; justify-content: space-between; gap: 10px; font-size: 12px; color: var(--text-muted); }

        /* Reveal animation */
        .reveal { opacity: 0; transform: translateY(24px); transition: opacity .55s cubic-bezier(.22,1,.36,1), transform .55s cubic-bezier(.22,1,.36,1); }
        .reveal.show { opacity: 1; transform: translateY(0); }
    </style>
</head>
<body>

    @php
        $nav = [
            ['label' => 'Kursus', 'href' => '#courses'],
            ['label' => 'Fitur', 'href' => '#features'],
            ['label' => 'Cerita', 'href' => '#stories'],
            ['label' => 'Harga', 'href' => '#pricing'],
        ];
        $marquee = ['Universitas Terbuka', 'Kelas.id', 'BelajarBersama', 'LearnPath Academy', 'Nusantara Tech', 'Ruang Ilmu', 'Cendekia Digital'];
        $features = [
            ['icon' => 'collections_bookmark', 'title' => 'Manajemen kursus', 'desc' => 'Kelola kursus, kelas, dan kurikulum dengan mudah untuk admin dan instruktur.'],
            ['icon' => 'video_library', 'title' => 'Materi video & PDF', 'desc' => 'Akses materi dalam bentuk video HD maupun dokumen PDF kapan saja.'],
            ['icon' => 'fact_check', 'title' => 'Auto grading', 'desc' => 'Soal kuis dengan auto grading, hasil langsung muncul setelah selesai.'],
            ['icon' => 'notifications_active', 'title' => 'Notifikasi tugas', 'desc' => 'Pengingat otomatis untuk tugas baru, deadline, dan tugas yang belum dikumpulkan.'],
            ['icon' => 'workspace_premium', 'title' => 'Sertifikat resmi', 'desc' => 'Sertifikat terverifikasi yang bisa dibagikan ke LinkedIn.'],
            ['icon' => 'bar_chart', 'title' => 'Pelacakan progres', 'desc' => 'Dashboard yang menunjukkan capaian, streak, dan target mingguan.'],
        ];
        $img = [
            'hero' => 'https://images.hostinger.com/05d8cc77-565d-402d-a289-43e2c52f0be5.png',
            'inst' => 'https://images.hostinger.com/798c22fb-46eb-49a6-a56c-01de7c663a64.png',
            'm1'   => 'https://images.hostinger.com/e9670b52-a73f-4b01-b923-8b5c3d2ca448.png',
            'm2'   => 'https://images.hostinger.com/a8ec1571-2286-4248-8836-66dc542b55ac.png',
        ];
        $courses = [
            ['tag' => 'Terlaris', 'title' => 'Fondasi Data Science', 'level' => 'Pemula', 'lessons' => 48, 'hours' => 22, 'price' => 'Rp 249rb', 'img' => $img['m2']],
            ['tag' => 'Baru', 'title' => 'UI/UX Design Sprint', 'level' => 'Menengah', 'lessons' => 36, 'hours' => 18, 'price' => 'Rp 199rb', 'img' => $img['hero']],
            ['tag' => 'Populer', 'title' => 'Bahasa Inggris Profesional', 'level' => 'Semua level', 'lessons' => 60, 'hours' => 30, 'price' => 'Rp 179rb', 'img' => $img['m1']],
        ];
        $stories = [
            ['name' => 'Rani Puspita', 'role' => 'Data Analyst di Gojek', 'text' => 'Dalam 4 bulan saya pindah karier ke bidang data. Mentornya sabar dan materinya benar-benar terpakai di dunia kerja.', 'img' => $img['m2']],
            ['name' => 'Bagas Prakoso', 'role' => 'Freelance Designer', 'text' => 'Sertifikat dari sini bikin klien lebih percaya. Portofolio yang saya bangun selama kelas langsung dilihat recruiter.', 'img' => $img['m1']],
            ['name' => 'Dewi Anjani', 'role' => 'Guru & Content Creator', 'text' => 'Fleksibilitasnya luar biasa. Saya belajar malam hari setelah mengajar, dan progres tracking-nya bikin konsisten.', 'img' => $img['inst']],
        ];
        $stats = [
            ['n' => '120K+', 'l' => 'Pelajar aktif'],
            ['n' => '850+', 'l' => 'Kursus kurasi'],
            ['n' => '94%', 'l' => 'Lulus & bersertifikat'],
            ['n' => '4.9', 'l' => 'Rating rata-rata'],
        ];
        $plans = [
            ['name' => 'Gratis', 'price' => 'Rp 0', 'period' => '/selamanya', 'desc' => 'Untuk mencoba pengalaman belajar.', 'features' => ['5 kursus pengantar', 'Kuis dasar', 'Komunitas belajar'], 'cta' => 'Mulai gratis', 'highlight' => false],
            ['name' => 'Pro', 'price' => 'Rp 149rb', 'period' => '/bulan', 'desc' => 'Pilihan terbaik untuk berkembang cepat.', 'features' => ['Akses semua kursus', 'Sertifikat resmi', 'Kelas langsung mingguan', 'Pelacakan progres lanjutan'], 'cta' => 'Coba 7 hari gratis', 'highlight' => true],
            ['name' => 'Tim', 'price' => 'Rp 99rb', 'period' => '/anggota', 'desc' => 'Untuk perusahaan & institusi.', 'features' => ['Dashboard admin', 'Laporan tim', 'Onboarding khusus', 'Prioritas dukungan'], 'cta' => 'Hubungi kami', 'highlight' => false],
        ];
    @endphp

    <header>
        <div class="container header-inner">
            <a href="#top" class="logo">
                <img src="{{ asset('images/Logo LearnPath .png') }}" alt="LearnPath" class="logo-icon-img" />
                LearnPath
            </a>
            <nav class="main-nav">
                @foreach ($nav as $n)
                    <a href="{{ $n['href'] }}">{{ $n['label'] }}</a>
                @endforeach
            </nav>
            <div class="header-actions">
                <a href="{{ route('login') }}" class="btn-ghost">Masuk</a>
                <a href="{{ route('login') }}" class="btn-primary">Daftar gratis <span class="material-symbols-outlined" style="font-size:16px;">arrow_forward</span></a>
            </div>
            <button class="menu-toggle" id="menuBtn"><span class="material-symbols-outlined">menu</span></button>
        </div>
        <div class="mobile-menu" id="mobileMenu">
            @foreach ($nav as $n)
                <a href="{{ $n['href'] }}">{{ $n['label'] }}</a>
            @endforeach
            <a href="{{ route('login') }}" class="btn-primary" style="justify-content:center;">Daftar gratis</a>
        </div>
    </header>

    <section class="hero" id="top">
        <div class="hero-bg">
            <video autoplay muted loop playsinline>
                <source src="{{ asset('images/7778145-hd_1920_1080_25fps.mp4') }}" type="video/mp4">
            </video>
        </div>
        <div class="hero-overlay"></div>

        <div class="container">
            <div class="hero-content">
                <div class="reveal badge"><span class="material-symbols-outlined" style="font-size:16px;">auto_awesome</span> Platform belajar No.1 di Asia Tenggara</div>
                <h1 class="reveal">Kuasai skill baru, <span class="highlight">tanpa batas ruang kelas.</span></h1>
                <p class="reveal lead">LearnPath menyatukan kursus terkurasi, mentor ahli, dan pelacakan progres pintar dalam satu tempat. Belajar dengan cara yang menyenangkan dan benar-benar terpakai.</p>
                <div class="reveal hero-cta">
                    <a href="{{ route('login') }}" class="btn-primary">Mulai belajar gratis <span class="material-symbols-outlined" style="font-size:16px;">arrow_forward</span></a>
                    <a href="#courses" class="btn-outline"><span class="material-symbols-outlined">play_circle</span> Lihat kursus</a>
                </div>
                <div class="reveal rating">
                    <div class="stars">
                        @for ($k = 0; $k < 5; $k++)<span class="material-symbols-outlined" style="font-size:18px;">star</span>@endfor
                    </div>
                    <p>Dipercaya <strong>120.000+</strong> pelajar</p>
                </div>
            </div>
        </div>

        <div class="float-card bottom">
            <span class="icon-circle"><span class="material-symbols-outlined">check_circle</span></span>
            <div><strong>Modul selesai</strong><br><span style="color:#6B7280;font-size:12px;">+120 XP hari ini</span></div>
        </div>
        <div class="float-card top">
            <span style="font-size:22px;font-weight:800;">7 🔥</span>
            <span style="font-size:11px;opacity:.8;">hari streak</span>
        </div>
    </section>

    <div class="marquee-wrap">
        <div class="marquee-track">
            @foreach (array_merge($marquee, $marquee) as $m)
                <span>{{ $m }}</span>
            @endforeach
        </div>
    </div>

    <section class="container">
        <div class="stats-grid">
            @foreach ($stats as $s)
                <div class="reveal"><div class="num">{{ $s['n'] }}</div><div class="label">{{ $s['l'] }}</div></div>
            @endforeach
        </div>
    </section>

    <section class="container" id="features">
        <div class="reveal" style="max-width:600px;">
            <span class="eyebrow">Kenapa LearnPath</span>
            <h2 class="section-title">Semua yang kamu butuhkan untuk belajar sampai tuntas.</h2>
        </div>
        <div class="features-grid">
            @foreach ($features as $f)
                <div class="reveal feature-card">
                    <span class="feature-icon"><span class="material-symbols-outlined">{{ $f['icon'] }}</span></span>
                    <h3>{{ $f['title'] }}</h3>
                    <p>{{ $f['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <section class="courses-section" id="courses">
        <div class="container">
            <div class="section-head">
                <div class="reveal" style="max-width:520px;">
                    <span class="eyebrow">Kursus unggulan</span>
                    <h2 class="section-title">Mulai dari yang paling diminati.</h2>
                </div>
                <a href="#pricing" style="font-size:14px;font-weight:600;color:var(--card-blue);">Jelajahi semua kursus →</a>
            </div>
            <div class="courses-grid">
                @foreach ($courses as $c)
                    <div class="reveal course-card">
                        <div class="course-thumb" style="background-image:url('{{ $c['img'] }}');background-size:cover;background-position:center;"><span class="course-tag">{{ $c['tag'] }}</span></div>
                        <div class="course-body">
                            <div class="course-meta">
                                <span class="course-level">{{ $c['level'] }}</span>
                                <span><span class="material-symbols-outlined" style="font-size:14px;">menu_book</span> {{ $c['lessons'] }} pelajaran</span>
                            </div>
                            <h3>{{ $c['title'] }}</h3>
                            <div class="course-footer">
                                <span style="color:var(--text-muted);"><span class="material-symbols-outlined" style="font-size:15px;">schedule</span> {{ $c['hours'] }} jam</span>
                                <span class="course-price">{{ $c['price'] }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="container split">
        <div class="reveal split-visual" style="background-image:url('{{ $img['inst'] }}');background-size:cover;background-position:center;"></div>
        <div class="reveal">
            <span class="eyebrow">Belajar dari yang terbaik</span>
            <h2 class="section-title">Mentor praktisi, bukan sekadar teori.</h2>
            <p class="lead">Setiap kursus dirancang bersama praktisi aktif dari industri. Kamu belajar hal yang benar-benar dipakai di lapangan, lengkap dengan studi kasus nyata dan feedback personal.</p>
            <ul>
                @foreach (['Kurikulum diperbarui mengikuti tren industri', 'Proyek nyata untuk portofolio', 'Sesi mentoring 1-on-1 di paket Pro'] as $t)
                    <li><span class="material-symbols-outlined">check_circle</span> {{ $t }}</li>
                @endforeach
            </ul>
        </div>
    </section>

    <section class="stories-section" id="stories">
        <div class="container">
            <div class="reveal" style="max-width:600px;">
                <span class="eyebrow">Cerita pelajar</span>
                <h2 class="section-title">Ribuan karier berubah dimulai dari sini.</h2>
            </div>
            <div class="stories-grid">
                @foreach ($stories as $s)
                    <div class="reveal story-card">
                        <span class="material-symbols-outlined quote">format_quote</span>
                        <p class="text">&quot;{{ $s['text'] }}&quot;</p>
                        <div class="story-person">
                            <div class="story-avatar" style="background-image:url('{{ $s['img'] }}');background-size:cover;background-position:center;"></div>
                            <div><div class="story-name">{{ $s['name'] }}</div><div class="story-role">{{ $s['role'] }}</div></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="container" id="pricing">
        <div class="reveal pricing-head">
            <span class="eyebrow">Harga transparan</span>
            <h2 class="section-title">Pilih paket yang sesuai ritmemu.</h2>
            <p style="margin-top:12px;color:var(--text-muted);">Tanpa biaya tersembunyi. Batalkan kapan saja.</p>
        </div>
        <div class="pricing-grid">
            @foreach ($plans as $p)
                <div class="reveal plan-card {{ $p['highlight'] ? 'highlight' : '' }}">
                    @if ($p['highlight'])<span class="plan-badge">Paling populer</span>@endif
                    <h3>{{ $p['name'] }}</h3>
                    <p class="plan-desc">{{ $p['desc'] }}</p>
                    <div class="plan-price"><span class="amount">{{ $p['price'] }}</span><span class="period">{{ $p['period'] }}</span></div>
                    <ul>
                        @foreach ($p['features'] as $f)
                            <li><span class="material-symbols-outlined">check_circle</span> {{ $f }}</li>
                        @endforeach
                    </ul>
                    <a href="{{ route('login') }}" class="plan-cta {{ $p['highlight'] ? 'filled' : 'outline' }}">{{ $p['cta'] }}</a>
                </div>
            @endforeach
        </div>
    </section>

    <section class="container">
        <div class="reveal cta-box">
            <div class="cta-blob"></div>
            <h2>Siap mulai perjalanan belajarmu?</h2>
            <p>Gabung ratusan ribu pelajar dan buka potensimu hari ini. Gratis untuk memulai.</p>
            <a href="{{ route('login') }}" class="btn-accent">Daftar sekarang, gratis <span class="material-symbols-outlined" style="font-size:16px;">arrow_forward</span></a>
        </div>
    </section>

    <footer>
        <div class="container footer-grid">
            <div>
                <a href="#top" class="logo"><img src="{{ asset('images/Logo LearnPath .png') }}" alt="LearnPath" class="logo-icon-img" />LearnPath</a>
                <p class="footer-desc">Platform belajar online yang membantu kamu tumbuh, satu skill dalam satu waktu.</p>
            </div>
            @foreach ([
                ['h' => 'Platform', 'l' => ['Kursus', 'Fitur', 'Harga', 'Untuk Tim']],
                ['h' => 'Perusahaan', 'l' => ['Tentang', 'Karier', 'Blog', 'Kontak']],
                ['h' => 'Bantuan', 'l' => ['Pusat bantuan', 'Syarat', 'Privasi', 'FAQ']],
            ] as $col)
                <div>
                    <h4>{{ $col['h'] }}</h4>
                    <ul>@foreach ($col['l'] as $l)<li><a href="#top">{{ $l }}</a></li>@endforeach</ul>
                </div>
            @endforeach
        </div>
        <div class="container footer-bottom">
            <p>© {{ date('Y') }} LearnPath. Semua hak dilindungi.</p>
            <p>Dibuat untuk para pembelajar seumur hidup.</p>
        </div>
    </footer>

    <script>
        const menuBtn = document.getElementById('menuBtn');
        const mobileMenu = document.getElementById('mobileMenu');
        menuBtn.addEventListener('click', () => mobileMenu.classList.toggle('show'));

        const revealEls = document.querySelectorAll('.reveal');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('show');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.15, rootMargin: '-60px' });
        revealEls.forEach((el) => observer.observe(el));
    </script>
</body>
</html>