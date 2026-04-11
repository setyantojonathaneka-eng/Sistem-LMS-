import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/home.css', 'resources/js/app.js', 'resources/css/login.css', 'resources/css/register.css'], // ← ubah di sini
            refresh: true,
        }),
    ],
    serve: {
        host: '127.0.0.1',
    },
});