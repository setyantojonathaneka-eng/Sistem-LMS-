import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/student.css',
                'resources/js/.js',
                'resources/css/login.css',  
                'resources/js/login.js',
                'resources/css/admin.css', 
                'resources/js/admin.js',
                'resources/css/student/courses.css',
                'resources/js/student/courses.js',
                'resources/css/student/absensi.css',
                'resources/js/student/absensi.js',
                'resources/css/student/nilai.css',
                'resources/js/student/nilai.js',
                'resources/css/student/sertifikat.css',
                'resources/js/student/sertifikat.js',
            ], 
            refresh: true,
        }),
    ],
    serve: {
        host: '127.0.0.1',
    },
});