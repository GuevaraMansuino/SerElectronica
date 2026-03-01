import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/login.css',
                'resources/css/home.css',
                'resources/css/catalog.css',
                'resources/css/productCard.css',
                'resources/js/app.js',
                'resources/js/bootstrap.js',
                'resources/js/catalog.js',
                'resources/js/confirm-modal.js',
                'resources/js/navbar.js',
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
