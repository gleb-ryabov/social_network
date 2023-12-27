import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/main.css',
                'resources/js/app.js',
                'resources/js/check_fields_form.js',
                'resources/js/hide_form.js',
            ],
            refresh: true,
        }),
    ],
});
