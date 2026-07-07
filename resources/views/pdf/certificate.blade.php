<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sertifikat</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 40px; }
        .certificate { border: 4px solid #2C4A5E; padding: 60px 40px; text-align: center; }
        h1 { color: #2C4A5E; font-size: 32px; margin-bottom: 8px; }
        .subtitle { color: #8a7d70; font-size: 14px; margin-bottom: 30px; }
        .name { font-size: 28px; font-weight: bold; color: #5D9EC7; margin: 20px 0; }
        .course-name { font-size: 20px; font-weight: bold; margin: 10px 0; }
        .detail { color: #555; font-size: 13px; margin-top: 30px; }
        .footer { margin-top: 40px; font-size: 11px; color: #999; }
    </style>
</head>
<body>
    <div class="certificate">
        <h1>SERTIFIKAT</h1>
        <p class="subtitle">Diberikan kepada</p>
        <p class="name">{{ $certificate->user->name ?? $user->name ?? '-' }}</p>
        <p>telah menyelesaikan kursus</p>
        <p class="course-name">{{ $certificate->course->title ?? $course->title ?? '-' }}</p>
        <p class="detail">Nomor Sertifikat: {{ $certificate->number ?? $certificate->id ?? '-' }}</p>
        <p class="detail">Tanggal: {{ ($certificate->created_at ?? now())->format('d F Y') }}</p>
        <div class="footer">LearnPath — Platform Belajar Online</div>
    </div>
</body>
</html>
