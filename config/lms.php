<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Category Styles
    |--------------------------------------------------------------------------
    |
    | Warna badge & aksen per kategori course, dipakai di:
    | - components/pill.blade.php        (badge kategori)
    | - components/course-card.blade.php (gradient thumbnail, progress bar, tombol enroll)
    |
    | bg  -> warna background badge/thumbnail (soft)
    | fg  -> warna teks/icon (kontras dengan bg)
    | bar -> warna progress bar / aksen solid
    |
    | Sesuaikan key (nama kategori) dengan yang benar-benar dipakai
    | di kolom `category` pada tabel courses kamu.
    |
    */

    'category_styles' => [
        'UI/UX' => [
            'bg'  => '#B5D4F4',
            'fg'  => '#185FA5',
            'bar' => '#5D9EC7',
        ],
        'Web' => [
            'bg'  => '#C8ECC9',
            'fg'  => '#3E8B45',
            'bar' => '#69B96F',
        ],
        'Data' => [
            'bg'  => '#E3D6F7',
            'fg'  => '#6B3FA0',
            'bar' => '#9B7BE0',
        ],
        'Mobile' => [
            'bg'  => '#FBE7C6',
            'fg'  => '#B8860B',
            'bar' => '#E0B84C',
        ],
        'Bisnis' => [
            'bg'  => '#FBD8D0',
            'fg'  => '#C05545',
            'bar' => '#E88774',
        ],
        // Tambahkan kategori lain sesuai data course kamu, contoh:
        // 'Marketing' => [
        //     'bg'  => '#FDE2E4',
        //     'fg'  => '#C0587A',
        //     'bar' => '#E894A8',
        // ],
    ],

];