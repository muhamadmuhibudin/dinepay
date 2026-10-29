import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/assets/customer/css/app.css',
                'resources/assets/customer/js/app.js',
            ],
            refresh: true,
        }),
    ],
});