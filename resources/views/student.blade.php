<!DOCTYPE html>
<html lang="id" x-data="{ collapsed: false, notifOpen: false, notifRead: false }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'LearnPath') | Dashboard Student</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,1,0" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('js/lib/lmsData.js') }}"></script>
    <style>
        body { background: #F0EAE4; font-family: Arial, sans-serif; }
        .lms-fade { animation: lmsFade .35s ease both; }
        @keyframes lmsFade { from { opacity:0; transform: translateY(4px);} to { opacity:1; transform:none;} }
        .lms-scroll::-webkit-scrollbar { width: 6px; }
        .lms-scroll::-webkit-scrollbar-thumb { background: rgba(0,0,0,.15); border-radius: 99px; }
    </style>
    @stack('styles')
</head>
<body class="min-h-[100dvh] flex" style="background:#F0EAE4">

    @include('partials.sidebar')

    <main class="flex-1 min-w-0 flex flex-col">
        @include('partials.header')

        <div class="flex flex-1 min-h-0">
            <div class="flex-1 min-w-0 p-6 overflow-y-auto lms-scroll">
                @yield('content')
            </div>
        </div>
    </main>

    @stack('modals')

    
    @stack('scripts')
    <script>document.addEventListener('alpine:init', () => { setTimeout(() => lucide.createIcons(), 50); });</script>
</body>
</html>
